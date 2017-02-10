<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use WC_API_Client;
use WC_API_Client_Exception;
use WC_API_Client_Resource_Orders;
use WC_API_Client_Resource_Customers;
use WC_API_Client_Resource_Products;

use \Garan24\Garan24 as Garan24;
use \Garan24\Deal\Deal as Deal;
use \Garan24\Deal\Customer as Customer;
use \Garan24\Delivery\BoxBerry\Converter as Converter;
use \Garan24\Delivery\BoxBerry\BoxBerry as BoxBerry;

class ManagerController extends Controller{
    protected $resource_avaliable = false;
    protected $resource;
    protected $products;
    public function __construct(){
        $this->middleware('cors');
        //$this->middleware('auth');
        \Garan24\Garan24::$DB["prefix"] = "xr_";
        \Garan24\Garan24::$DB["schema"] = "gauzymall";
        //\Garan24\Garan24::$DB["host"] = "151.248.117.239";
        \Garan24\Garan24::$DB["host"] = "127.0.0.1";
        \Garan24\Garan24::$DB["user"] = "gauzymall";
        \Garan24\Garan24::$DB["pass"] = "D6a8O2e1";
        $domain = "https://www.gauzymall.com";
        $consumer_key = "ck_49991773cb558558384abaa2b00be9ab3b3de3b5";
        $consumer_secret = "cs_4a56c14e1f65523c757cf18fdfacb95ed18a1a55";
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        try {
            $client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
            $this->resource = new WC_API_Client_Resource_Orders($client);
            $this->products = new WC_API_Client_Resource_Products($client);
            $this->resource_avaliable = true;
        } catch ( WC_API_Client_Exception $e ) {

            echo $e->getMessage() . PHP_EOL;
            echo $e->getCode() . PHP_EOL;

            if ( $e instanceof WC_API_Client_HTTP_Exception ) {
                print_r( $e->get_request() );
                print_r( $e->get_response() );
            }
        }
    }
    public function getIndex(Request $rq){
        //$id = $rq->input("status","0");
        $filtersSet = false;
        $filters = $rq->all();
        $sel = DB::table('orders')->join('userinfo','orders.user_id','=','userinfo.user_id');

        foreach($filters as $f=>$v){
            if($f=="status"){
                $sel = $sel->where("status","=",$v);
                $filtersSet = true;
            }
            elseif ($f=="search"){
                $sel = $sel->where("external_order_id","like", "%".$v."%");//->orWhere("internal_order_id","=",$v);
            }
        }
        if($filtersSet === false )$sel = $sel->where('status','<>','new')->where('status','<>','closed')->where("status","<>","canceled");
        $orders=$sel->take(100)->get();
        $st = DB::table('garan24_deal_statuses')->get();
        $out = [];
        foreach($st as $s){$out[$s->status]=$s->description;}
        return view("orders.index",["orders"=>$orders,"statuses" => $out]);
    }
    public function getOrderitems(Request $rq){
        $id = $rq->input("id","0");
        $res = $this->resource->get($id);
        //var_dump($res);
        return response()->json($res->order,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getUpdate(Request $rq){
        $resp=["error"=>"No Id accepted"];
        $data = $rq->all();
        if(!isset($data["id"]))return response()->json($resp,500,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        $order_id = $data["id"];
        if(isset($data["external_order_id"])){
            DB::table('deals')->where("internal_order_id",$order_id)
                ->update(["external_order_id" => $data["external_order_id"]]);
            $resp = ["Ok"];
        }
        return response()->json($resp,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getUpdatestatus(Request $rq){
        $exid = $rq->input("external_order_id",false);
        $status = DB::table('garan24_deal_statuses')
            ->where("status",$rq->input("status"))->first();
        //WooCommerce statuses
        // pending, processing, on-hold, completed, cancelled, refunded and failed.
        $order_id = $rq->input("id","0");
        if($status->status=="canceled"){
            $this->resource->update($order_id,["status"=>"cancelled"]);
        }
        else if($status->status=="closed"){
            $this->resource->update($order_id,["status"=>"completed"]);
        }
        else if($status->status=="confirmed"){
            $this->resource->update($order_id,["status"=>"processing"]);
        }
        else if($status->status=="new"){
            $this->resource->update($order_id,["status"=>"pending"]);
        }
        else if($status->status=="shipped"){
            $this->resource->update($order_id,["status"=>"on-hold"]);
        }
        DB::table('deals')
            ->where("internal_order_id",$order_id)
            ->update(["status" => $status->id]);
        if($exid!==false){
            DB::table('deals')
            ->where("internal_order_id",$order_id)
            ->update(["external_order_id" => $exid]);
        }
        return response()->json($status);
    }
    public function getProduct(Request $rq){
        $id = $rq->input("id","0");
        $res = $this->products->get($id);
        //var_dump($res);
        return response()->json($res->product,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getConsole(Request $rq){
        return view("orders.manager");
    }
    public function getPayed(Request $rq){
        $c = ["error"=>"No Id accepted"];
        $order = $rq->input("id",false);
        while($order!==false){
            $dd = DB::table('deals')
                ->join('userinfo','deals.customer_id','=','userinfo.user_id')
                ->join('garan24_user_cardref','garan24_user_cardref.user_id','=','userinfo.user_id')
                ->join('garan24_cardrefs','garan24_user_cardref.card_ref_id','=','garan24_cardrefs.id')
                ->where('deals.internal_order_id','=',$order)->select(
                    'deals.internal_order_id as client_orderid',
                    'garan24_cardrefs.card_ref_id as cardrefid',
                    'deals.amount',
                    'deals.service_fee',
                    'deals.shipping_cost'
                    )->get();
            $dd = json_decode(json_encode($dd),true);
            $dd = $dd[count($dd)-1];
            $c = $dd;
            if(!count($dd)) break;
            $dd["order_desc"] = "Post payment for order #".$order;
            $dd["ipaddress"] = "213.87.145.97";
            $dd["redirect_url"] = "gauzymall.com";
            $dd["cardrefid"] = preg_replace("/[\r\n]+/i","",$dd["cardrefid"]);
            $dd["currency"] = "RUB";
            $dd["amount"] += $dd["service_fee"]+$dd["shipping_cost"];
            unset($dd["service_fee"]);
            unset($dd["shipping_cost"]);

            $crdData = array_merge(ManagerController::$ariuspay["akbars"]["RebillRequest"],["data"=>$dd]);
            $crdData["data"]["login"] = $crdData["merchant_login"];
            $c = $crdData;
            $request = new \Garan24\Gateway\Ariuspay\RebillRequest($crdData);
            $connector = new \Garan24\Gateway\Ariuspay\Connector();
            $connector->setRequest($request);
            $connector->call();
            $response =  $connector->getResponse();

            $field = "paynet-order-id";
            //if(!count(trim($response->$field))) continue;
            $c = array_merge(ManagerController::$ariuspay["akbars"]["StatusRequest"],["data"=> [
                "client_orderid"=>$dd["client_orderid"],
                "orderid" => $response->$field,
                "login" =>$crdData["merchant_login"]
            ]]);
            $c["endpoint"] = $crdData["endpoint"];
            break;
        }
        return response()->json($c,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getPayedstatus(Request $rq){
        $c = ["error"=>"No Id accepted"];
        $order = $rq->input("id",false);
        while($order!==false){
            $c = array_merge(ManagerController::$ariuspay["akbars"]["StatusRequest"],["data"=> [
                "client_orderid"=>$order,
                "orderid" => $rq->input("orderid"),
                "login" => ManagerController::$ariuspay["akbars"]["StatusRequest"]["merchant_login"]
            ]]);
            $connector = new \Garan24\Gateway\Ariuspay\Connector();
            $status = new \Garan24\Gateway\Ariuspay\StatusRequest($c);
            $connector->setRequest($status);
            $connector->call();
            $response =  $connector->getResponse();
            /*while(preg_replace("/[\r\n\s]/m","",$response->status) == "processing"){
                sleep(5);
                $connector->call();
                $response =  $connector->getResponse();
            }*/
            if(preg_replace("/[\r\n\s]/m","",$response->status) == 'approved'){
                $dbstatus = DB::table('garan24_deal_statuses')
                    ->where("status","=","payed")->first();
                    DB::table('deals')
                        ->where("internal_order_id",$order)
                        ->update(["status" => $dbstatus->id,"payed"=>"1"]);
            }
            $field = "last-four-digits";
            $c = [
                "status"=>preg_replace("/[\r\n]+/m","",$response->status),
                "card" =>preg_replace("/[\r\n]+/m","",$response->bin)."xxxxxx".preg_replace("/[\r\n]+/m","",$response->$field)
            ];
            break;
        }
        return response()->json($c,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getCurrencyupdate(Request $rq){
        return $this->postCurrencyUpdate($rq);
    }
    public function postCurrencyupdate(Request $rq){
        $d = $rq->all();
        Log::debug(json_encode($d,JSON_PRETTY_PRINT));
        $woocommerce__exchange_rate = [
            "EUR" => "woocommerce_euro_exchange_rate",
            "USD" => "woocommerce_dollar_exchange_rate",
            "GBP" => "woocommerce_pound_exchange_rate"
        ];
        foreach($d as $k=>$v){

            if(in_array(strtoupper($k),["EUR","USD","GBP"])){
                DB::table('currency_rates')->where("iso_code",strtoupper($k))->update(["value"=>$v]);
                DB::table('options')->where("option_name",$woocommerce__exchange_rate[strtoupper($k)])->update(["option_value"=>$v]);
            }
        }
        return $this->getConsole($rq);
    }
    public function getStatistics(Request $rq){
        $r = DB::table('order_statistics')->get();
        return response()->json($r,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getBbparsel(Request $rq){
        $r = ["error"=>["code"=>"1","message"=>"no deal id"]];
        $deal_id = $rq->input("deal",false);
        Log::debug("BB request for: ".$deal_id);
        if($deal_id!==false){
            $b = $rq->input("weight",1000);
            Log::debug("BB parsel wieght: ".$b);
            $deal = new Deal(["id"=>$deal_id]);
            $d2b = new Converter();
            $bb = new BoxBerry();
            $con = $d2b->convert($deal,$b);
            //$r=$con;
            $r = json_decode($bb->ParcelCreateForeign($con),true);
            Log::debug("BB response: ".json_encode($r,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
            if(!isset($r["err"])){
                DB::table('deals')
                    ->where("internal_order_id",$deal_id)
                    ->update(["shipping_track" => $r["result"]["track"]]);
                //"label": "http:\/\/api.boxberry.de\/?act=build&track=PMG2128720&token=18455.rvpqeafa",
                //"box": "10002161451"
            }
        }
        return response()->json($r,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getSocialresult(Request $rq){
        $r = DB::table('social_credit')->get();
        return response()->json($r,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getAnalyticsresult(Request $rq){
        $t = $rq->input("type","add2cart");
        $r = DB::table('analytics')->where("type","=",$t)->orderBy("id","desc")->take(20)->get();
        return response()->json($r,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function Currency(Request $rq){
        //DB::table('currency_rates')->insertGetId(["value"=>"{}"])];
        $c = DB::table('currency_rates')->take(4)->get();
        return response()->json($c,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function CurrencyFee(Request $rq){
        //DB::table('currency_rates')->insertGetId(["value"=>"{}"])];
        $c = DB::table('currency_rates')->take(4)->get();
        return response()->json($c,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public static $ariuspay = ["akbars" =>[
        "SaleRequest" => [
            "url" => "https://gate.payneteasy.com/paynet/api/v2/",
            "endpoint" => "2879",
            "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
            "merchant_login" => "garan24"
        ],
        "RebillRequest" => [
            "url" => "https://gate.payneteasy.com/paynet/api/v2/",
            "endpoint" => "3058",
            "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
            "merchant_login" => "garan24"
        ],
        "StatusRequest" => [
            "url" => "https://gate.payneteasy.com/paynet/api/v2/",
            "endpoint" => "3058",
            "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
            "merchant_login" => "garan24"
        ],
        "CaptureRequest" => [
            "url" => "https://gate.payneteasy.com/paynet/api/v2/",
            "endpoint" => "2879",
            "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
            "merchant_login" => "garan24"
        ],
        "PreauthRequest" => [
            "url" => "https://gate.payneteasy.com/paynet/api/v2/",
            "endpoint" => "3028",
            "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
            "merchant_login" => "garan24"
        ],
        "CreateCardRef_RIB" => [
            "url" => "https://gate.payneteasy.com/paynet/api/v2/",
            "endpoint" => "3028",
            "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
            "merchant_login" => "garan24"
        ],
        "CreateCardRef" => [
            "url" => "https://gate.payneteasy.com/paynet/api/v2/",
            "endpoint" => "2879",
            "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
            "merchant_login" => "garan24"
        ]
    ]];

}
?>

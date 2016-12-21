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
        //\Garan24\Garan24::$DB["user"] = "gauzymall";
        //\Garan24\Garan24::$DB["pass"] = "D6a8O2e1";
        \Garan24\Garan24::$DB["host"] = "127.0.0.1";
        \Garan24\Garan24::$DB["user"] = "gauzymall";
        \Garan24\Garan24::$DB["pass"] = "D6a8O2e1";
        $domain = "http://gauzymall.com";
        $consumer_key = "ck_653d001502fc0b8e1b5e562582f678ce7b966b85";
        $consumer_secret = "cs_a9b8f4b535f845f82509c1cfa6bea5d094219dce";
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
        $sel = DB::table('orders')->join('userinfo','orders.user_id','=','userinfo.user_id')->where("status","<>","canceled");

        foreach($filters as $f=>$v){
            if($f=="status"){
                $sel = $sel->where("status","=",$v);
                $filtersSet = true;
            }
            elseif ($f=="search"){
                $sel = $sel->where("external_order_id","like", "%".$v."%");//->orWhere("internal_order_id","=",$v);
            }
        }
        if($filtersSet === false )$sel = $sel->where('status','<>','new');
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
        return response()->json($c,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function CurrencyUpdate(Request $rq){
        $d = $rq->all();
        Log::debug(json_encode($d,JSON_PRETTY_PRINT));
        foreach($d as $k=>$v){
            if(in_array(strtoupper($k),["EUR","USD","GBP"]))DB::table('currency_rates')->where("iso_code",strtoupper($k))->update(["value"=>$v]);
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

}
?>

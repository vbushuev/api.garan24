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

class CheckoutController extends Controller{
    protected $rawgoods;
    protected $raworder;
    protected $viewFolder = '/checkout';
    public function __construct(){
        $this->raworder = file_get_contents('../tests/example.order.json');
        $this->raworder = json_decode($this->raworder,true);
        //print_r($this->rawgoods);
    }
    public function getIndex(Request $rq){
        $id = $rq->get('id','noindex');
        if($id=='noindex') return view('public.index');
        $rq->session()->put("deal_id",$id);
        $deal = new Deal();
        $deal->byId($id);
        return view(preg_replace('/\//m','',$this->viewFolder).'.checkout'
            ,["route"=>$this->getBPRoute("checkout"), "debug"=>"", "goods"=>$deal->order->getProducts(),"customer"=>[]]
        );
    }
    public function postIndex(Request $rq){
        $data = $rq->getContent();
        $deal = new Deal();
        $deal->byJson($data);
        return $deal->sync();
    }
    public function postPersonal(Request $rq){
        $data = $this->getParams($rq);
        if(!isset($data["email"])||!isset($data["phone"])){
            return redirect($this->viewFolder.'checkout');
        }
        $id = $rq->session()->get("deal_id");
        $deal = new Deal();
        $deal->byId($id);
        $cust = new Customer('{"email":"'.$data["email"].'","phone":"'.$data["phone"].'"}',$deal->getWC());
        $cust->sync();
        $rq->session()->put("user_id",$cust->customer_id);
        return view(preg_replace('/\//m','',$this->viewFolder).'.personal'
            ,["route"=>$this->getBPRoute("personal")
            ,"debug"=>""
            ,"goods"=>$deal->order->getProducts()
            ,"customer"=>$cust->toArray()
        ]);
    }
    public function postDeliverypaymethod(Request $rq){
        $data = $this->getParams($rq);
        $goods= $rq->session()->get("products");
        $delivery = isset($data["billing"])?$data["billing"]:['no adress'];
        $name = isset($data["fio"])?$data["fio"]:['noname'];
        $rq->session()->put("address",$delivery);
        return view('democheckout.deliverypaymethod',["route"=>$this->getBPRoute("paymethod"), "debug"=>"", "goods"=>$goods]);
    }
    public function getDeliverypaymethod(Request $rq){
        return $this->postDeliverypaymethod($rq);
    }
    public function postThanks(Request $rq){
        try{
            $this->getWC($rq);
            $this->createOrder($rq);
            $this->createDeal($rq);
        }
        catch(Exception $e){
            Log::error($e->getMessage());
        }
        return view('democheckout.thankspage',["route"=>$this->getBPRoute("thanks")]);
    }
    public function getThanks(Request $rq){
        return $this->postThanks($rq);
    }
    public function postPassport(Request $rq){
        $data = $this->getParams($rq);
        $rq->session()->put("paydelivery",$data);
        $goods= $rq->session()->get("products");
        return view('democheckout.passport',["route"=>$this->getBPRoute("passport"), "debug"=>"", "goods"=>$goods]);
    }
    public function getPassport(Request $rq){
        return $this->postPassport($rq);
    }
	public function getCard(Request $rq){
        return $this->postCard($rq);
    }
    public function postCard(Request $rq){
        $data = $this->getParams($rq);
        $pd=[];
        if(isset($data["payment_types"])){
            $pd = $data;
            $rq->session()->put("paydelivery",$data);
        }
        else {
            $pd = $rq->session()->get("paydelivery");
            $rq->session()->put("passport",$data);
        }
        $delivery = $rq->session()->get("address");
        $goods= $rq->session()->get("products");
        return view('democheckout.card',["route"=>$this->getBPRoute("card"), "debug"=>"",
            "goods"=>$goods,
            "paydelivery"=>$pd,
            "delivery"=>$delivery
        ]);
    }
    protected function getParams(Request $rq){
        //Log::debug("getParams data:".$rq->get("data"));
        //Log::debug("getParams all:".Garan24::obj2str($rq->all()));
        $data = $rq->get("data",$rq->getContent());
        $data = json_decode($data,true);
        if(empty($data))$data = $rq->all();
        $log = "";
        if(empty($data))$data = $rq->all();
        foreach($data as $k=>$v){
            if(empty($v))unset($data["{$k}"]);
            else{
                $log .= "{$k} = ".Garan24::obj2str($v).", ";
            }
        }
        Log::debug("getParams request: ".$log);
        return $data;
    }
    protected function getCustomer($data){
        $person = DB::table('users')
            ->join('usermeta',function($join){
                $join->on('users.id', '=','usermeta.user_id')->where('usermeta.meta_key','=','billing_phone');
            })
            ->where('users.user_email', $data["email"])
            ->where('usermeta.meta_value','like','%'.$data["phone"])
            ->first();
        return $person;
    }
    protected $wc_client;
    protected function createOrder(Request $rq){
        $resource = new WC_API_Client_Resource_Orders($this->wc_client);
        $customer = $rq->session()->get("customer");
        $products = $rq->session()->get("products");
        $order = $rq->session()->get("order");
        $delivery = $rq->session()->get("address");
        $data=["order"=>$order];
        $data["order"]["payment_details"] = [ "method_id" => "garan24","method_title" => "Garan24 Pay","paid" => false ];
        $data["order"]["billing_address"] = $delivery;
        $data["order"]["shipping_address"] = $delivery;
        $data["order"]["line_items"] = [];
        $data["order"]["customer_id"] = $customer["customer"]["id"];
        $products = $data["order"]["line_items"];
        $items=[];
        foreach($products as $key => $val) {
            $item=[];
            $item["type"]="external";
            Log::debug("Product check ". json_encode($item));
            $p = $this->createProduct($item);
            $item["product_id"] = $p->product->id;
            $items[]=$item;
        }
        $data["order"]["line_items"]=$items;
        $res = $resource->create($data);

        $internal_order=json_decode($res->http->response->body,true);
        $rq->session()->put("internal_order",$internal_order);
        Log::debug("Order is : ". Garan24::obj2str($internal_order));
        return $internal_order;
    }
    protected function getShop(Request $rq){
        $order = $rq->session()->get("order");
        $consumer_secret = $order["x_secret"];
        Log::debug("Secret is : ". $consumer_secret);
        $shop = DB::table('woocommerce_api_keys')
            ->join('shops','shops.api_key_id', '=','woocommerce_api_keys.key_id')
            ->where('consumer_secret', $consumer_secret)->first();
        $rq->session()->put("shop",json_decode(json_encode($shop),true));
        Log::debug("Shop is : ". json_encode($shop));
    }
    protected function createDeal(Request $rq){
        $order = $rq->session()->get("order");
        $internal_order = $rq->session()->get("internal_order");
        $shop = $rq->session()->get("shop");
        $customer = $rq->session()->get("customer");
        DB::table('deals')->insert(
            [
                'amount' => $order["order"]["order_total"]*100,
                'currency' => $order["order"]["order_currency"],
                'shop_id' => $shop["id"],
                'status' => 1,
                'internal_order_id' => $internal_order["order"]["id"],
                'external_order_id' => $order["order"]["order_id"],
                'external_order_url' => $order["order"]["order_url"],
                'customer_id' => $customer["customer"]["id"]
            ]
        );
    }
    protected function getWC(Request $rq){
        $api = $rq->session()->get("order");
        $this->getShop($rq);
        $domain ="https://garan24.ru";//$this->shop->link;
        $consumer_key = $api["x_key"];
        $consumer_secret = $api["x_secret"];
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        $this->wc_client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
    }
    //else
    public function getDelivery(Request $rq){
        return view('democheckout.delivery',["route"=>$this->getBPRoute("delivery"), "debug"=>"", "goods"=>$this->rawgoods]);
    }
    public function getPaymethod(Request $rq){
        return view('democheckout.paymethod',["route"=>$this->getBPRoute("paymethod"), "debug"=>"", "goods"=>$this->rawgoods]);
    }
    public function getCheckcard(Request $rq){
        return view('democheckout.payment-form',["route"=>$this->getBPRoute("checkcard"), "debug"=>"", "goods"=>$this->rawgoods]);
        $data = [
            "client_orderid"=>"905",
            "order_desc" => "Test Order Description",
            "first_name" => "John",
            "last_name" => "Smith",
            "ssn" => "1267",
            "birthday" => "19820115",
            "address1" => "100 Main st",
            "city" => "Seattle",
            "state" => "WA",
            "zip_code" => "98102",
            "country" => "US",
            "phone" => "+12063582043",
            "cell_phone" => "%2B19023384543",
            "amount" => "10.42",
            "email" => "john.smith@gmail.com",
            "currency" => "RUB",
            "ipaddress" => "65.153.12.232",
            "site_url" => "www.google.com",
            /*"credit_card_number" => "4444555566661111",
            "card_printed_name" => "CARD HOLDER",
            "expire_month" => "12",
            "expire_year" => "2099",
            "cvv2" => "123",*/
            "purpose" => "www.twitch.tv/dreadztv",
            "redirect_url" => "https://service.garan24.ru/".$this->viewFolder."/payneteasyresponse",
            //"server_callback_url" => "http://doc.payneteasy.com/doc/dummy.htm",
            "merchant_data" => "VIP customer",
            "control" => "768eb8162fc361a3e14150ec46e9a6dd8fbfa483"
        ];
        $request = new \Garan24\Gateway\Ariuspay\SaleRequest($data);
        $connector = new \Garan24\Gateway\Ariuspay\Connector();
        $connector->setRequest($request);
        $connector::setLogger("default");
        try{
            //echo $obj->getRequest()->__toString();//call();
            $connector->call();
            return redirect()->away($connector->getResponse()->getRedirectUrl());
        }
        catch(\Garan24\Gateway\Aruispay\Exception $e){
            Log::error("Exception in AruisPay gateway:".$e->getMessage());
        }
        catch(\Garan24\Gateway\Exception $e){
            Log::error("Exception in gateway:".$e->getMessage());
        }
        catch(Exception $e){
            Log::error("Exception :".$e->getMessage());
        }

    }
    public function postPayneteasyresponse(Request $rq){
        return redirect($this->vieFolder.'/thanks',["route"=>$this->getBPRoute("email"), "debug"=>"", "goods"=>$this->rawgoods]);
    }
    public function getPayneteasyresponse(Request $rq){
        return $this->postPayneteasyresponse($rq);
    }
    protected $bpmodels=[
        "index" => ["text"=>"Продолжить","href"=>"/"],
        "email" => ["text"=>"Продолжить","href"=>"/checkout"],
        "personal" => ["text"=>"Продолжить","href"=>"/personal"],
        "delivery" => ["text"=>"Продолжить","href"=>"/delivery"],
        "paymethod" => ["text"=>"Продолжить","href"=>"/paymethod"],
        "checkcard" => ["text"=>"Продолжить","href"=>"/checkcard"],
        "deliverypaymethod" => ["text"=>"Продолжить","href"=>"/deliverypaymethod"],
        "thanks" => ["text"=>"Продолжить","href"=>"/thanks"],
        "passport" => ["text"=>"Продолжить","href"=>"/passport"],
        "card" => ["text"=>"Подтвердить","href"=>"/card"],
    ];
    protected $bpmatrix=[
        "index" => ["condition"=>false,"next"=>"email","back"=>"index"],
        "email" => ["condition"=>false,"next"=>"personal","back"=>"index"],
        "checkout" => ["condition"=>false,"next"=>"personal","back"=>"index"],
        //"personal" => ["condition"=>false,"next"=>"delivery","back"=>"email"],
        "personal" => ["condition"=>false,"next"=>"deliverypaymethod","back"=>"email"],
        "delivery" => ["condition"=>false,"next"=>"paymethod","back"=>"personal"],
        "deliverypaymethod" => ["condition"=>["credit"=>"passport"],"next"=>"card","back"=>"personal"],
        "paymethod" => ["condition"=>["credit"=>"passport"],"next"=>"card","back"=>"delivery"],
        "checkcard" => ["condition"=>false,"next"=>"thanks","back"=>"deliverypaymethod"],
        "thanks" => ["condition"=>false,"next"=>"index","back"=>false],
        "passport" => ["condition"=>false,"next"=>"card","back"=>"deliverypaymethod"],
        "card" => ["condition"=>false,"next"=>"thanks","back"=>"deliverypaymethod"]
    ];
    protected function getBPRoute($current,$condition=false){
        $c = (!isset($this->bpmatrix[$current]))
            ? $this->bpmatrix["index"]
            : $this->bpmatrix[$current];
        return [
            "dir" => $this->viewFolder,
            "next" => ($c["condition"]!==false)
                    ? (isset($c["condition"][$condition])?$this->bpmodels[$c["condition"][$condition]]:$this->bpmodels[$c["next"]])
                    : $this->bpmodels[$c["next"]],
            "back" => (($c["back"]!==false)?$this->bpmodels[$c["back"]]:false)
        ];
    }

}
?>

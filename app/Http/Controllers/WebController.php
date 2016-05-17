<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use WC_API_Client;
use WC_API_Client_Exception;
use WC_API_Client_Resource_Orders;
use WC_API_Client_Resource_Customers;
use WC_API_Client_Resource_Products;
//use Garan24;
//use Garan24\HTTP;
use \Garan24\Garan24 as Garan24;
use \Garan24\Gateway\Ariuspay\Sale as AriusSale;
use \Garan24\Gateway\Ariuspay\Exception as AriuspayException;

class WebController extends Controller{
    protected $wc_client;
    protected $request;
    protected $response;
    protected $customer;
    protected $order;
    protected $shop;
    protected $deal;
    protected $_host = "https://garan24.ru/service/public/";
    protected function createProduct($item){
        $resource = new WC_API_Client_Resource_Products($this->wc_client);
        try{
            $resp = $resource->get($item["product_id"]);
        }
        catch(WC_API_Client_Exception $e){
            $resp = $resource->create(["product"=> $item]);
        }
        return $resp;
    }
    public function getIndex(Request $rq){
        return view('public.index');
    }
    public function getCheckout(Request $rq){
        $order = $rq->input('order',[
            ['img'=>'http://demostore.garan24.ru/wp-content/uploads/2016/04/jacket-180x180.jpg','name' => 'jacket','price' => '79','currency'=>'rub','quantity' => '1'],
            ['img'=>'http://demostore.garan24.ru/wp-content/uploads/2016/04/x._V293494175_-300x300.jpg','name' => 'Shoes','price' => '129','currency'=>'rub','quantity' => '3']
        ]);
        $vd = [
            'order' => $order
        ];
        return view('public.checkout',$vd);
    }
    public function postProcesspay(Request $rq,$test_data=""){
        $order_rq = (!empty($test_data))?$test_data:$rq->getContent();
        $this->request = (substr($order_rq,0,1)=="{")?json_decode($order_rq,true):$rq->all();
        $this->response = [
            "code" => "502",
            "message" => "Protocol Error",
            "request" => $order_rq
        ];
        if((!isset($this->request["x_key"])||!isset($this->request["order"]))){
            Log::error("Protocol error ". json_encode($this->response));
            return json_encode($this->response);
        }
        Log::debug("Request :".json_encode($this->request));
        try {
            $this->getWC($rq);//new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
            $this->getCustomer($rq);
            $this->createOrder($rq);
            $this->createDeal($rq);
            return $this->moveToPayout($rq);

        } catch ( Exception $e ) {
            $this->response["code"] = $e->getCode();
            $this->response["message"] = $e->getMessage();
            if ( $e instanceof WC_API_Client_HTTP_Exception ) {
                $this->response["request"] = $e->get_request();
                $this->response["response"] = $e->get_response();
            }
        }
        return json_encode($this->response);
    }
    public function getProcesspay(Request $rq){
        return $this->postProcesspay($rq,'{"x_secret":"cs_89f95570b4bd18759b8501cd16e4756ab03a544c","x_key":"ck_7575374a55d17741f3999e8c98725c6471030d6c","version":"1.0","order":{"order_url":"http://demostore.garan24.ru","order_id":58,"payment_details":{"method_id":"garan24","method_title":"Garan24 Pay","paid":false},"billing_address":{"first_name":"\u0412\u043b\u0430\u0434\u0438\u043c\u0438\u0440","last_name":"\u0411\u0443\u0448\u0443\u0435\u0432","address_1":"\u041c\u043e\u043b\u043e\u0434\u0446\u043e\u0432\u0430","city":"\u041c\u043e\u0441\u043a\u0432\u0430","state":"","postcode":"127221","country":"RU","phone":"9265766710","email":"yanusdnd@inbox.ru"},"line_items":{"65":{"name":"Jacket","type":"line_item","item_meta":{"_qty":["1"],"_tax_class":[""],"_product_id":["9"],"_variation_id":["0"],"_line_subtotal":["79"],"_line_total":["79"],"_line_subtotal_tax":["0"],"_line_tax":["0"],"_line_tax_data":["a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"]},"item_meta_array":{"427":{"key":"_qty","value":"1"},"428":{"key":"_tax_class","value":""},"429":{"key":"_product_id","value":"9"},"430":{"key":"_variation_id","value":"0"},"431":{"key":"_line_subtotal","value":"79"},"432":{"key":"_line_total","value":"79"},"433":{"key":"_line_subtotal_tax","value":"0"},"434":{"key":"_line_tax","value":"0"},"435":{"key":"_line_tax_data","value":"a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"}},"qty":"1","tax_class":"","product_id":"9","variation_id":"0","line_subtotal":"79","line_total":"79","line_subtotal_tax":"0","line_tax":"0","line_tax_data":"a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"},"66":{"name":"Office package #1","type":"line_item","item_meta":{"_qty":["1"],"_tax_class":[""],"_product_id":["32"],"_variation_id":["0"],"_line_subtotal":["650"],"_line_total":["650"],"_line_subtotal_tax":["0"],"_line_tax":["0"],"_line_tax_data":["a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"]},"item_meta_array":{"436":{"key":"_qty","value":"1"},"437":{"key":"_tax_class","value":""},"438":{"key":"_product_id","value":"32"},"439":{"key":"_variation_id","value":"0"},"440":{"key":"_line_subtotal","value":"650"},"441":{"key":"_line_total","value":"650"},"442":{"key":"_line_subtotal_tax","value":"0"},"443":{"key":"_line_tax","value":"0"},"444":{"key":"_line_tax_data","value":"a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"}},"qty":"1","tax_class":"","product_id":"32","variation_id":"0","line_subtotal":"650","line_total":"650","line_subtotal_tax":"0","line_tax":"0","line_tax_data":"a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"},"67":{"name":"Sofa design","type":"line_item","item_meta":{"_qty":["1"],"_tax_class":[""],"_product_id":["24"],"_variation_id":["0"],"_line_subtotal":["148"],"_line_total":["148"],"_line_subtotal_tax":["0"],"_line_tax":["0"],"_line_tax_data":["a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"]},"item_meta_array":{"445":{"key":"_qty","value":"1"},"446":{"key":"_tax_class","value":""},"447":{"key":"_product_id","value":"24"},"448":{"key":"_variation_id","value":"0"},"449":{"key":"_line_subtotal","value":"148"},"450":{"key":"_line_total","value":"148"},"451":{"key":"_line_subtotal_tax","value":"0"},"452":{"key":"_line_tax","value":"0"},"453":{"key":"_line_tax_data","value":"a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"}},"qty":"1","tax_class":"","product_id":"24","variation_id":"0","line_subtotal":"148","line_total":"148","line_subtotal_tax":"0","line_tax":"0","line_tax_data":"a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}"}},"order_total":"877.00","order_currency":"EUR","customer_ip_address":"31.173.82.154","customer_user_agent":"Mozilla\/5.0 (Windows NT 10.0; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/50.0.2661.94 Safari\/537.36"}}');
        /*******************************************************************
         * Woo Commerce keys
         * Key:     ck_a060e095bdafdc57d95fb4df2d19aa9a2d671a91
         * Secret:  cs_4bbfa365ae1850f93f1144ebe666302315831ff0
         ******************************************************************/
        $domain = "http://garan24.ru";
        $consumer_key = "ck_8ff71be2b15d1dddbe939fb30e7fd0dfc6419ca2";
        $consumer_secret = "cs_735d73f347e10723402539ac503a9df8413f6287";
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        try {
            $this->wc_client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
            $resource = new WC_API_Client_Resource_Orders($this->wc_client);
            $data = [
                "order"=> [
                    "order_id" => '57',
                    "payment_details"=> [
                        "method_id"=> "garan24",
                        "method_title"=> "Direct Bank Transfer",
                        "paid"=> true
                    ],
                    "billing_address"=> [
                        "first_name"=> "John",
                        "last_name"=> "Doe",
                        "address_1"=> "969 Market",
                        "address_2"=> "",
                        "city"=> "San Francisco",
                        "state"=> "CA",
                        "postcode"=> "94103",
                        "country"=> "US",
                        "email"=> "john.doe@example.com",
                        "phone"=> "(555) 555-5555"
                    ],
                    "shipping_address"=> [
                        "first_name"=> "John",
                        "last_name"=> "Doe",
                        "address_1"=> "969 Market",
                        "address_2"=> "",
                        "city"=> "San Francisco",
                        "state"=> "CA",
                        "postcode"=> "94103",
                        "country"=> "US"
                    ],
                    "customer_id"=> 2
                ]
            ];
            $products = [//]"line_items"=> [
                [
                    "title" => "Android Title",
                    "product_id"=> 546,
                    "regular_price" => "49.99",
                    "quantity"=> 2
                ],
                [
                    "product_id"=> 613,
                    "title" => "LCD TV sets",
                    "regular_price" => "99.99",
                    "quantity"=> 1,
                    "variations"=> [
                        "pa_color"=> "Black"
                    ]
                ]
            ];
            for($i=0;$i<count($products);$i++) {
                $p = $this->createProduct($products[$i]);
                $products[$i]["product_id"] = $p->product->id;
            }
            $data = array_merge($data,$products);
            //$data = array_merge($data,$shippings);
            $resp=$resource->create($data)->http->response->body;
            //print_r($obj);
        } catch ( Exception $e ) {

            $resp["code"] = $e->getCode();
            $resp["message"] = $e->getMessage();
            if ( $e instanceof WC_API_Client_HTTP_Exception ) {
                $resp["request"] = $e->get_request();
                $resp["response"] = $e->get_response();
            }
        }
        return json_encode($resp);
    }
    public function postPayout(Request $rq,$local=[]){
        $data = count($local)?$local:$this->parseParams($rq);
        $resp = [
            "code" => "502",
            "message" => "Protocol Error",
            "request" => $data
        ];
        $amt = $this->exchangeRates(["amount"=>(isset($data["amount"])?$data["amount"]:0),"currency" => (isset($data["currency"])?$data["currency"]:"RUB")]);
        $saleData = [
            "client_orderid" => isset($data["client_orderid"])?$data["client_orderid"]:"",
            "order_desc" => isset($data["order_desc"])?$data["order_desc"]:"Garan24 pay order",
            "first_name" => isset($data["first_name"])?$data["first_name"]:"",
            "last_name" => isset($data["last_name"])?$data["last_name"]:"",
            "ssn" => isset($data["ssn"])?$data["ssn"]:"",
            "birthday" => isset($data["birthday"])?$data["birthday"]:"",
            "address1" => isset($data["address1"])?$data["address1"]:"",
            "address2" => isset($data["address2"])?$data["address2"]:"",
            "city" => isset($data["city"])?$data["city"]:"",
            "state" => "",//isset($data["state"])?$data["state"]:"",
            "zip_code" => isset($data["zip_code"])?$data["zip_code"]:"",
            "country" => isset($data["country"])?$data["country"]:"",
            "phone" => isset($data["phone"])?$data["phone"]:"",
            "cell_phone" => isset($data["cell_phone"])?$data["cell_phone"]:"",
            "amount" => $amt["amount"],
            "currency" => $amt["currency"],
            "email" => isset($data["email"])?$data["email"]:"",

            "ipaddress" => isset($data["ipaddress"])?$data["ipaddress"]:"",
            "site_url" => isset($data["site_url"])?$data["site_url"]:"",
            /*"credit_card_number" => "4444555566661111",
            "card_printed_name" => "CARD HOLDER",
            "expire_month" => "12",
            "expire_year" => "2099",
            "cvv2" => "123",*/
            "purpose" => "www.garan24.eu",
            "redirect_url" => $this->_host."payoutresponse",
            //"redirect_url" => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            //"redirect_url" => "https://arius.garan24.bs2/test/response.php",
            "server_callback_url" => $this->_host."payoutcallback",
            //"merchant_data" => "VIP customer"
        ];
        $request = new \Garan24\Gateway\Ariuspay\SaleRequest($saleData);
        $connector = new \Garan24\Gateway\Ariuspay\Connector();
        $connector->setRequest($request);
        try{
            $connector->call();
            $response = $connector->getResponse();
            if($response->isRedirect()){
                return redirect()->away($response->getRedirectUrl());
                return view("public/payout",[
                    "content"=>[
                        "text"=>"Для проведения оплаты Вам необходимо подготовить кредитную карту и нажмите продолжить."
                        ,"url"=>$response->getRedirectUrl()
                    ]
                ]);
            }
        }
        catch(\Garan24\Gateway\Aruispay\Exception $e){
            print("Exception in AruisPay gateway:".$e->getMessage());
        }
    }
    public function postPayoutCallback(Request $rq){
        $data = $rq->getContent();
        Log::debug("payoutcallback:".$data);

    }
    public function postPayoutresponse(Request $rq){
        $data = $rq->getContent();
        Log::debug("payoutresponse:".$data);
        $dataArr = [];
        parse_str($data,$dataArr);
        $r = [
            "url" => $_SERVER["HTTP_ORIGIN"],
            "data" => $dataArr
        ];
        $redirect_url = "";
        try{
            $obj = new \Garan24\Gateway\Ariuspay\CallbackResponse($r,function($d){
                //echo "Make order is payed.";
                //echo \Garan24\Garan24::obj2str($d);
                try{
                    $consumer_key = "ck_0597b2b7f710f5e402f4e8cf90673f41588cbf89";
                    $consumer_secret = "cs_45d3c2b094f683ca8a02834a6d2c6a1126573b7e";
                    $domain = "https://garan24.ru";
                    $options = [
                        'debug'           => true,
                    	'return_as_array' => false,
                    	'validate_url'    => false,
                    	'timeout'         => 30,
                        'ssl_verify'      => false
                    ];
                    $client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
                    $resource = new WC_API_Client_Resource_Orders($client);
                    $order = $resource->update_status($d["client_orderid"],"processing");
                } catch ( Exception $e ) {
                    $resp["code"] = $e->getCode();
                    $resp["message"] = $e->getMessage();
                    if ( $e instanceof WC_API_Client_HTTP_Exception ) {
                        $resp["request"] = $e->get_request();
                        $resp["response"] = $e->get_response();
                    }
                }
            });
            if($obj->accept()){
                $crd = new \Garan24\Gateway\Ariuspay\CreateCardRef([
                    'client_orderid' => $obj->client_orderid,
                    'orderid' => $obj->orderid
                ]);
                $crd->call();
                $key = "card-ref-id";
                $cardref =  $crd->getResponse()->$key;
                //$crd->getResponse()->
                /* Check user have this card*/
                // DB::table('garan24_usermeta')->exist
                $deal = DB::table('deals')->where('internal_order_id', $obj->client_orderid)->first();
                $usercard = DB::table("garan24_usermeta")
                        ->where('user_id',$deal->customer_id)
                        ->where('value_key','card-ref')
                        ->where('value_data',$cardref)
                        ->first();

                if(is_null($usercard)){
                    DB::table("garan24_usermeta")
                            ->insert(['user_id'=>$deal->customer_id,'value_key'=>'card-ref','value_data'=>$cardref]);
                }

                Log::debug("Deal is : ". json_encode($deal));
                $redirect_url = $deal->external_order_url."&status=success&order_id=".$deal->external_order_id;
                return redirect()->away($redirect_url);
            }
        }
        catch(\Garan24\Gateway\Ariuspay\Exception $e){
            Log::error("Exception in AruisPay Response gateway:".$e->getMessage());
        }
        return view("public/payoutresponse");
    }
    public function getPayout(Request $rq){
        return $this->postPayout($rq);
    }
    public function getTest(Request $rq){
        return view("public/test");
    }
    public function getTestwoo(Request $rq){
        /*******************************************************************
         * Woo Commerce keys
         * Key:     ck_da2458ebc6edb86bf2dcc9ad56b396c5c589e222
         * Secret:  cs_59949976e2eb4c6443b521fb542d2a0a93e89fe6
         ******************************************************************/
        $data = [
            // Garan24 Credentials and API Info
			"x_secret"           	=> "cs_59949976e2eb4c6443b521fb542d2a0a93e89fe6",
			"x_key"              	=> "ck_da2458ebc6edb86bf2dcc9ad56b396c5c589e222",
			"x_version"            	=> "1.0",
        ];
        $data = array_merge($data,[
            // Order total
            			"x_amount"             	=> "100",


            			"x_type"               	=> 'AUTH_CAPTURE',
            			"x_invoice_num"        	=> 1,
            			"x_delim_char"         	=> '|',
            			"x_encap_char"         	=> '',
            			"x_delim_data"         	=> "TRUE",
            			"x_relay_response"     	=> "FALSE",
            			"x_method"             	=> "CC",

            			// Billing Information
            			"x_first_name"         	=> "Vladimir",
            			"x_last_name"          	=> "Bushuev",
            			"x_address"            	=> "Address line1",
            			"x_city"              	=> "Moscow",
            			"x_state"              	=> "Moscow",
            			"x_zip"                	=> "127221",
            			"x_country"            	=> "Russia",
            			"x_phone"              	=> "+79265766710",
            			"x_email"              	=> "yanusdnd@inbox.ru",

            			// Shipping Information
            			"x_ship_to_first_name" 	=> "first_name",
            			"x_ship_to_last_name"  	=> "last_name",
            			"x_ship_to_company"    	=> "company",
            			"x_ship_to_address"    	=> "address_1",
            			"x_ship_to_city"       	=> "city",
            			"x_ship_to_country"    	=> "country",
            			"x_ship_to_state"      	=> "state",
            			"x_ship_to_zip"        	=> "postcode",

            			// Some Customer Information
            			"x_cust_id"            	=> "",
            			"x_customer_ip"        	=> $_SERVER['REMOTE_ADDR']
        ]);
        // Create a stream
        $opts = [
            'http'=>[
                'method'=>"POST",
                'header'=>"Accept-language: en\r\n" ."Cookie: foo=bar\r\n"."Content-Type: application/json\r\n",
                'content'=>json_encode($data)
            ]
        ];
        $context = stream_context_create($opts);
        // Open the file using the HTTP headers set above
        $file = file_get_contents('http://www.plugin.garan24.ru/processpay', false, $context);
        return $file;
    }
    protected function parseParams(Request $rq){
        $data = $rq->getContent();
        $data = json_decode($data,true);
        $log = "";
        if(empty($data))$data = $rq->all();
        foreach($data as $k=>$v){
            if(empty($v))unset($data["{$k}"]);
            else{
                $log .= "{$k} = {$v}, ";
            }
        }
        Log::debug($log);
        return $data;
    }
    protected function exchangeRates($d){
        $rates=[
            "USD" => 66.01,
            "EUR" => 75,
            "RUB" => 1
        ];
        $amount = $d["amount"];
        $currency = $d["currency"];
        return ["amount"=>$amount*$rates["{$currency}"],"currency"=>"RUB"];
    }
    protected function getCustomer(Request $rq){
        $resource = new WC_API_Client_Resource_Customers($this->wc_client);
        try{
            $this->customer = $resource->get_by_email($this->request["order"]["billing_address"]["email"]);
        }
        catch ( WC_API_Client_Exception $e ) {
            //create user
            $this->customer = $resource->create([
                "customer"=>[
                    "email"=>$this->request["order"]["billing_address"]["email"],
                    "password"=>$this->request["order"]["billing_address"]["email"],
                    "username"=>$this->request["order"]["billing_address"]["email"]
                ]
            ]);
        }
        if($this->customer===false) throw new Exception("Customers internal error", 500);
        Log::debug("Customer ". json_encode($this->customer));
    }
    protected function createOrder(Request $rq){
        $resource = new WC_API_Client_Resource_Orders($this->wc_client);
        $data=[
            "order"=>$this->request["order"]
        ];
        $data["order"]["customer_id"] = $this->customer->customer->id;
        $products = $data["order"]["line_items"];
        $items=[];
        foreach($products as $key => $val) {
            $item=[];
            $item["title"]=$products[$key]["name"];
            $item["type"]="external";
            $item["quantity"]=$products[$key]["qty"];
            $item["regular_price"]=$products[$key]["line_subtotal"];
            $item["product_id"]=$products[$key]["product_id"];
            Log::debug("Product check ". json_encode($item));
            $p = $this->createProduct($item);
            $item["product_id"] = $p->product->id;
            $items[]=$item;
        }
        $data["order"]["line_items"]=$items;
        $this->order=$resource->create($data);
        Log::debug("Order is : ". json_encode($this->order->http->response->body));
    }
    protected function getShop(Request $rq){
        $consumer_secret = $this->request["x_secret"];
        Log::debug("Secret is : ". $consumer_secret);
        $this->shop = DB::table('woocommerce_api_keys')
            ->join('shops','shops.api_key_id', '=','woocommerce_api_keys.key_id')
            ->where('consumer_secret', $consumer_secret)->first();
        Log::debug("Shop is : ". json_encode($this->shop));
    }
    protected function createDeal(Request $rq){
        DB::table('deals')->insert(
            [
                'amount' => $this->order->order->total*100,
                'currency' => $this->order->order->currency,
                'shop_id' => $this->shop->id,
                'status' => 1,
                'internal_order_id' => $this->order->order->id,
                'external_order_id' => $this->request["order"]["order_id"],
                'external_order_url' => $this->request["order"]["order_url"],
                'customer_id' => $this->customer->customer->id
            ]
        );
    }
    protected function getWC(Request $rq){
        $this->getShop($rq);
        $domain ="https://garan24.ru";//$this->shop->link;
        $consumer_key = $this->request["x_key"];
        $consumer_secret = $this->request["x_secret"];
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        $this->wc_client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
    }
    protected function moveToPayout(Request $rq){
        $res = $this->order;
        $data = $this->request;
        //need redirect to payneteasy
        $payout_data = [
            "amount"			=> 1,//$res->order->total,
            "currency" 			=> "RUB",//$res->order->currency,
            "client_orderid" 	=> $res->order->id,
            "order_desc" 		=> "Financia for order ".$data["order"]["order_id"],
            "first_name" 		=> $res->order->billing_address->first_name,
            "last_name" 		=> $res->order->billing_address->last_name,
            "address" 			=> $res->order->billing_address->address_1,
            "address1" 			=> $res->order->billing_address->address_1,
            "address2" 			=> $res->order->billing_address->address_2,
            "city" 				=> $res->order->billing_address->city,
            "state" 			=> $res->order->billing_address->state,
            "zip_code" 			=> $res->order->billing_address->postcode,
            "country" 			=> $res->order->billing_address->country,
            "phone" 			=> $res->order->billing_address->phone,
            "cell_phone"		=> $res->order->billing_address->phone,
            "email" 			=> $res->order->billing_address->email,
            "ipaddress" 		=> $res->order->customer_ip,
            "site_url" 			=> $data["order"]["order_url"],
            "purpose" 			=> $data["order"]["order_url"]
        ];
        return $this->postPayout($rq,$payout_data);
    }
}
?>

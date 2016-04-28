<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
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
use \Garan24\Gateway\Aruispay\Sale as AruisSale;
use \Garan24\Gateway\Aruispay\Exception as AruispayException;

class WebController extends Controller{
    protected $wc_client;
    protected $_host = "http://api.garan24.bs2/";
    protected function createProduct(WC_API_Client $client,$item){
        $resource = new WC_API_Client_Resource_Products($client);
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
            ['name' => 'jacket','price' => '79','currency'=>'eur','quantity' => '1'],
            ['name' => 'window','price' => '229','currency'=>'eur','quantity' => '3']
        ]);
        $vd = [
            'order' => $order
        ];
        return view('public.checkout',$vd);
    }
    public function postProcesspay(Request $rq){
        $order = $rq->getContent();
        Log::debug($order);
        $order = json_decode($order,true);
        $resp = [
            "code" => "502",
            "message" => "Protocol Error",
            "request" => $order
        ];
        /*******************************************************************
         * Woo Commerce keys
         * Key:     ck_a060e095bdafdc57d95fb4df2d19aa9a2d671a91
         * Secret:  cs_4bbfa365ae1850f93f1144ebe666302315831ff0
         ******************************************************************/
        $domain = "http://garan24.ru";
        if(!isset($order["x_key"])||!isset($order["order"])){
            Log::error("Protocol error ". json_encode($resp));
            return json_encode($resp);
        }
        $consumer_key = $order["x_key"];
        $consumer_secret = $order["x_secret"];
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        try {
            $client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
            $resource = new WC_API_Client_Resource_Customers($client);
            $user = false;
            try{
                $user = $resource->get_by_email($order["order"]["billing_address"]["email"]);
            }
            catch ( WC_API_Client_Exception $e ) {
                //create user
                $user = $resource->create([
                    "customer"=>[
                        "email"=>$order["order"]["billing_address"]["email"],
                        "password"=>$order["order"]["billing_address"]["email"],
                        "username"=>$order["order"]["billing_address"]["email"]
                    ]
                ]);
            }
            if($user===false) throw new Exception("Customers internal error", 500);
            Log::debug("Customer ". json_encode($user));
            $resource = new WC_API_Client_Resource_Orders($client);
            $data=[
                "order"=>$order["order"]
            ];
            $data["order"]["customer_id"] = $user->customer->id;

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
                $p = $this->createProduct($client,$item);
                $item["product_id"] = $p->product->id;
                $items[]=$item;
            }
            $data["order"]["line_items"]=$items;
            Log::debug("Create order ". json_encode($data));
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
        Log::debug(json_encode($resp));
        return json_encode($resp);
    }
    public function getProcesspay(Request $rq){
        return $this->postProcesspay($rq);
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
            $client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
            $resource = new WC_API_Client_Resource_Orders($client);
            $data = [
                "order"=> [
                    "payment_details"=> [
                        "method_id"=> "bacs",
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
                $p = $this->createProduct($client,$products[$i]);
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
    public function postPayout(Request $rq){
        $data = $this->parseParams($rq);
        $resp = [
            "code" => "502",
            "message" => "Protocol Error",
            "request" => $data
        ];
        $sale = new AruisSale([
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
            "amount" => isset($data["amount"])?$data["amount"]:"",
            "currency" => isset($data["currency"])?$data["currency"]:"",
            "email" => isset($data["email"])?$data["email"]:"",
            "currency" => isset($data["currency"])?$data["currency"]:"",
            "ipaddress" => isset($data["ipaddress"])?$data["ipaddress"]:"",
            "site_url" => isset($data["site_url"])?$data["site_url"]:"",
            /*"credit_card_number" => "4444555566661111",
            "card_printed_name" => "CARD HOLDER",
            "expire_month" => "12",
            "expire_year" => "2099",
            "cvv2" => "123",*/
            "purpose" => "www.twitch.tv/dreadztv",
            "redirect_url" => $this->_host."payoutresponse",
            //"redirect_url" => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            //"redirect_url" => "https://arius.garan24.bs2/test/response.php",
            "server_callback_url" => $this->_host."payoutcallback",
            //"merchant_data" => "VIP customer"
        ]);
        $sale::setLogger(Log);
        try{
            $sale->call();
            $timeout = makeTimeout($timeout);
            while(!$sale->check()){
                $timeout = makeTimeout($timeout);
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

    }
    public function getPayout(Request $rq){
        return $this->postPayout($rq);
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
}
?>

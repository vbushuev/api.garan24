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

class ManagerController extends Controller{
    protected $resource_avaliable = false;
    protected $resource;
    public function __construct(){
        $this->middleware('cors');
        $domain = "https://garan24.ru";
        $consumer_key = "ck_35457354c06e162d14702ef932a3f1207869f705";
        $consumer_secret = "cs_125b46e5e9ee2d02abb662f99ffcbaef6937e4e1";
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
        $id = $rq->input("status","0");
        $orders = DB::table('orders')
            ->join('userinfo','orders.user_id','=','userinfo.user_id')
            //->join("(select '' as items from dual)")
            ->take(20)
            ->get();
        //$orders->passport=json_decode($orders->passport);
        return view("orders.index",["orders"=>$orders]);
    }
    public function getOrderitems(Request $rq){
        $id = $rq->input("id","0");
        $res = $this->resource->get($id)->http->response->body;
        return response()->json($res,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getUpdate(Request $rq){
        DB::table('garan24_cart')
            ->where("id",$rq->input("id","0"))
            ->update(["value" => $rq->input("value","{}")]);
        $cart = DB::table('garan24_cart')
            ->where("id",$rq->input("id","0"))->first();
        return response()->json($cart->value);
    }
}
?>

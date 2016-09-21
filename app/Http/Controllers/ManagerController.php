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
    protected $products;
    public function __construct(){
        $this->middleware('cors');
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
        $filters = $rq->all();
        $sel = DB::table('orders')->join('userinfo','orders.user_id','=','userinfo.user_id');
        foreach($filters as $f=>$v){}
        $orders=$sel->take(20)->get();
        return view("orders.index",["orders"=>$orders]);
    }
    public function getOrderitems(Request $rq){
        $id = $rq->input("id","0");
        $res = $this->resource->get($id);
        //var_dump($res);
        return response()->json($res->order,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getUpdatestatus(Request $rq){
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
        return response()->json($status);
    }
    public function getProduct(Request $rq){
        $id = $rq->input("id","0");
        $res = $this->products->get($id);
        //var_dump($res);
        return response()->json($res->product,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
}
?>

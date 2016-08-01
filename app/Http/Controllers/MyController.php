<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use WC_API_Client;
use WC_API_Client_Exception;
use WC_API_Client_Resource_Orders;
use WC_API_Client_Resource_Customers;
use WC_API_Client_Resource_Products;

//use \Garan24\Garan24 as Garan24;
use \Garan24\Deal\Deal as Deal;
use \Garan24\Deal\Customer as Customer;
/*
- проггрес бар ()
- знак вопроса подвинуть, и тексты сразу
*/

class MyController extends Controller{
    protected $thishost = "https://my.garan24.ru";
    protected $wc;
    protected $userid = false;
    protected $customer = false;
    public function __construct(){
        \Garan24\Garan24::$DB["host"] = "151.248.117.239";
        $domain = "https://garan24.ru";
        $consumer_key = "ck_5fc0fe1b810bde317b6fffcc211b31d96d5f8285";
        $consumer_secret = "cs_01fccb470363b07d5e2ba5c5e0e3d81663709e1f";
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        try {
            $this->wc = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
        }
        catch ( Exception $e ) {
            Log::error($e);
        }
    }
    public function getIndex(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        return response()->view('cabinet.index',["controller"=>$this,"customer"=>$this->customer])->header('Access-Control-Allow-Origin', '*');
    }
    protected function getParams(Request $rq){
        if($rq->cookie("user_id","nodata")=="nodata") {
            $this->userid = 92;
            //return false;
        }
        else $this->userid = $rq->cookie("user_id");
        if($rq->session()->has("customer")){
            $this->customer = $rq->session()->get("customer");
        }
        else {
            $this->customer = new Customer(["id"=>$this->userid],$this->wc);
            $this->customer->sync();
            $rq->session()->put("customer", $this->customer);
        }

        $data = $rq->get("data",$rq->getContent());
        $data = json_decode($data,true);
        if(empty($data))$data = $rq->all();
        $log = "";
        foreach($data as $k=>$v){
            if(empty($v))unset($data["{$k}"]);
            else{
                $log .= "{$k} = ".Garan24::obj2str($v).", ";
            }
        }
        return $data;
    }
}
?>

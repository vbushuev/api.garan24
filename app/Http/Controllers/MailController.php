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

class MailController extends Controller{
    protected $rawgoods;
    protected $raworder;
    protected $viewFolder = 'mail';
    protected $thishost = "https://service.garan24.ru";
    public function __construct(){
        Garan24::$DB["host"] = "151.248.117.239";
        //$this->raworder = file_get_contents('../tests/example.order.json');
        //$this->raworder = json_decode($this->raworder,true);
        //print_r($this->rawgoods);
    }
    public function getWelcome(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal([
            "id"=>$data["id"],
        ]);
        return view($this->viewFolder.'.welcome',["viewFolder"=>$this->viewFolder,"deal"=>$deal]);
    }
    public function getOrderpayondelivery(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal([
            "id"=>$data["id"],
        ]);
        return view($this->viewFolder.'.orderpayondelivery',["viewFolder"=>$this->viewFolder,"deal"=>$deal]);
    }
    public function getOrderpayonline(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal([
            "id"=>$data["id"],
        ]);
        return view($this->viewFolder.'.orderpayonline',["viewFolder"=>$this->viewFolder,"deal"=>$deal]);
    }
    public function getOrderpayed(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal([
            "id"=>$data["id"],
        ]);
        return view($this->viewFolder.'.orderpayed',["viewFolder"=>$this->viewFolder,"deal"=>$deal]);
    }

    protected function getParams(Request $rq){
        if($rq->cookie("deal_id","nodata")=="nodata" && !$rq->session()->has("deal_id")) return false;
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
        $data = array_merge($data,["deal_id" => $rq->session()->get("deal_id"),"deal_id_source" => "session"]);
        if(strlen($data["deal_id"])<=0)$data = array_merge($data,["deal_id" => $rq->cookie("deal_id"),"deal_id_source" => "cookie"]);
        Log::debug("CheckoutController:getParams request: ".Garan24::obj2str($data));
        return $data;
    }
}
?>

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
        \Garan24\Garan24::$DB["prefix"] = "xr_";
        \Garan24\Garan24::$DB["schema"] = "gauzymall";
        //\Garan24\Garan24::$DB["user"] = "vsb";
        //\Garan24\Garan24::$DB["pass"] = "Vampire04";
        \Garan24\Garan24::$DB["user"] = "gauzymall";
        \Garan24\Garan24::$DB["pass"] = "gauzymall";
        //$this->raworder = file_get_contents('../tests/example.order.json');
        //$this->raworder = json_decode($this->raworder,true);
        //print_r($this->rawgoods);
    }
    public function getWelcome(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $deal = new Deal(["id"=>$rq->input("id")]);
        return view($this->viewFolder.'.welcome',["viewFolder"=>$this->viewFolder,"deal"=>$deal]);
    }
    public function getOrderpayondelivery(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $deal = new Deal(["id"=>$rq->input("id")]);
        return view($this->viewFolder.'.orderpayondelivery',["viewFolder"=>$this->viewFolder,"deal"=>$deal]);
    }
    public function getOrderpayonline(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $deal = new Deal(["id"=>$rq->input("id")]);
        return view($this->viewFolder.'.orderpayonline',["viewFolder"=>$this->viewFolder,"deal"=>$deal]);
    }
    public function getOrderpayed(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $deal = new Deal(["id"=>$rq->input("id")]);
        return view($this->viewFolder.'.orderpayed',["viewFolder"=>$this->viewFolder,"deal"=>$deal]);
    }
}
?>

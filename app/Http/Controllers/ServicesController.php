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

class ServicesController extends Controller{
    protected $statuses = [
        "0" => ["name"=>"grn-making","success"=>1,"failed"=>0,"wc"=>["pending","on-hold"]],
        "1" => ["name"=>"grn-inshop","success"=>1,"wc"=>["pending","on-hold"]],
        "2" => ["name"=>"grn-to-delivery","success"=>1,"wc"=>["pending","on-hold"]],
        "3" => ["name"=>"grn-delivery-service","success"=>1,"wc"=>["pending","on-hold"]],
        "4" => ["name"=>"grn-customs","success"=>1,"wc"=>["pending","on-hold"]],
        "5" => ["name"=>"grn-pickpoint","success"=>1,"wc"=>["pending","on-hold"]],
        "6" => ["name"=>"grn-complete","success"=>1,"wc"=>["pending","on-hold"]],
        "7" => ["name"=>"grn-refund","success"=>0,"failed"=>0,"wc"=>["refunded"]],
        "8" => ["name"=>"grn-failed","success"=>0,"failed"=>1,"wc"=>["failed","cancelled"]]
    ];
    protected $wcstatuses = [
        "pending" => 4,
		"processing" => 1,
		"on-hold" => 0,
		"completed" => 6,
		"cancelled" => 0,
		"refunded" => 0,
		"failed" => 0,
    ];
    public function Statuses(Request $rq){
        return response()->json($this->statuses)->header('Access-Control-Allow-Origin', '*');
    }
    public function StatusByWC($wc_status){
        return response()->json($this->wcstatuses[$wc_status])->header('Access-Control-Allow-Origin', '*');
    }
    public function ShippingBoxberry(Request $rq){
        Log::debug("ShippingBoxberry: ".$rq->getContent());
        $jr = json_decode($rq->getContent(),true);
        $m = $jr["method"];
        $bb = new \Garan24\Delivery\BoxBerry\BoxBerry();
        return response($bb->$m($jr["data"]))->header('Access-Control-Allow-Origin', '*');
    }
}
?>

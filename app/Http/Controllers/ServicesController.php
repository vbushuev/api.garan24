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
    protected $sales = [
        "boxberry" => true
    ];
    public function __construct(){
        $this->middleware('cors');
    }
    public function Statuses(Request $rq){
        $st = DB::table('garan24_deal_statuses')->get();
        $out = [];
        foreach($st as $s){$out[$s->status]=$s->description;}
        return response()->json($out,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function StatusByWC($wc_status){
        return response()->json($this->wcstatuses[$wc_status]);
    }
    public function ShippingBoxberry(Request $rq){
        Log::debug("ShippingBoxberry: ".$rq->getContent());
        /*if($this->sales["boxberry"]){
            return response()->json([
                "price"=>"0",
                "price_base"=>"0",
                "price_service"=>"0"
            ]);
        }*/
        $jr = json_decode($rq->getContent(),true);
        $m = $jr["method"];
        $bb = new \Garan24\Delivery\BoxBerry\BoxBerry();
        return response($bb->$m($jr["data"]));
    }
    public function CrossDomain(Request $rq){
        Log::debug("CrossDomain: ".$rq->getContent());
        $url = $rq->input("_href",false);
        $result ="";
        if($url!==false){
            $result = file_get_contents($url);
        }
        return response($result);
    }
    public function Currency(Request $rq){
        //DB::table('currency_rates')->insertGetId(["value"=>"{}"])];
        $c = DB::table('currency_rates')->take(4)->get();
        return response()->json($c,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function Social(Request $rq){
        $data = $rq->all();
        $data["referer"]= $rq->headers->get('referer');
        $data = json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        Log::debug("Social: ".$data);
        $id =["id" => DB::table('social_credit')->insertGetId(["data"=>$data])];
        return response()->json($id,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function Analytics(Request $rq){
        $type = $rq->input("type","add2cart");
        $data= $rq->input("data",$rq->headers->get('referer'));
        $ip = $rq->ip();
        $id =["id" => DB::table('analytics')->insertGetId(["value"=>$data,"type"=>$type,"ip"=>$ip])];
        return response()->json($id,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function CatchExceptions(Request $rq){
        $data = json_decode($rq->getContent(),true);
        $id =["id" => DB::table('exceptions')->insertGetId(["data"=>$data])];
        return response()->json($id,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
}
?>

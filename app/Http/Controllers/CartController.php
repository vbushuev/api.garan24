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

class CartController extends Controller{
    public function __construct(){
        $this->middleware('cors');
    }
    public function getCreate(Request $rq){
        $cart =["id" => DB::table('garan24_cart')->insertGetId(["value"=>"{}"])];
        Log::debug($cart);
        return response()->json($cart);
    }
    public function getIndex(Request $rq){
        $id = $rq->input("id","0");
        if($id == 0){
            return view("cart.index");
        }
        $cart = DB::table('garan24_cart')->where("id",$id)->first();
        return response()->json($cart->value);
    }
    public function getUpdate(Request $rq){
        DB::table('garan24_cart')
            ->where("id",$rq->input("id","0"))
            ->update(["value" => $rq->input("value","{}")]);
        $cart = DB::table('garan24_cart')
            ->where("id",$rq->input("id","0"))->first();
        return response()->json($cart->value);
    }
    public function getClean(Request $rq){
        DB::table('garan24_cart')
            ->where("id",$rq->input("id","0"))
            ->update(["value" => "{}"]);
        return response()->json(["status"=>"success","id"=>$rq->input("id","0")]);
    }
}
?>

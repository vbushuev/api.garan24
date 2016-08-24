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
    public function postParseproduct(Request $rq){
        $r = [
            "success"=>true,
            "error"=>[],
            "product"=>[],
            "currency"=>""
        ];
        $url = $rq->getContent();
        $ui = parse_url($url);
        /*
        scheme - e.g. http
        host
        port
        user
        pass
        path
        query - after the question mark ?
        fragment - after the hashmark #
        */
        if(!isset($this->shops[$ui["host"]])){$r["error"]=$this->errors["1"];$r["success"]=false;}
        if($r["success"]){
            $s = $this->shops[$ui["host"]];
            $result = file_get_contents($url);
            foreach($s["patterns"] as $k=>$p){
                if(preg_match($p,$result,$m))$r["product"][$k]=$m["value"];
            }
            $r["currency"] = $this->shops[$ui["host"]]["currency"];

        }
        return response()->json($r);
    }
    protected $shops = [
        "www.baby-walz.fr"=>[
            "patterns" => [
                "title" => "/var\s+lsp_alt\s*=\s*[\"']?(?<value>.+?)[\"']?;/i",
                "sku" => "/owaParams\.product_id\s*=\s*[\"']?(?<value>.+?)[\"']?;/",
                "price" => "/owaParams\.product_price\s*=\s*[\"']?(?<value>.+?)[\"'];/",
                "img" => "/var\s+lsp_img\s*=\s*[\"']?(?<value>.+?)[\"'];/i",
                "pk" =>  "/var\s+lsp_pk\s*=\s*[\"']?(?<value>.+?)[\"'];/i"
            ],
            "currency" =>"EUR"
        ],
        "www.ctshirts.com" => [
            "patterns" => [
                "title" => "/\<img.*?class=\"pdp\-main__image\".*?alt=\"(?<value>.+?)\"/i",
                "sku" => "/\/(?<value>[^\/]+?)\.html/i",
                "price" => "/\<div.*?class=\"tile__pricing tile__pricing--centered regular\"\>[\s\r\n]*£(?<value>[\d\.]+?)\"/im",
                "img" => "/\<img.*?class=\"pdp\-main__image\".*?src=\"(?<value>.+?)\"/i",
                "pk" =>  "/\"product_id\"\s*\:\s*\[\n\s*\"(?<value>.+?)\"/i"
            ],
            "currency" =>"GBP"
        ]///uk/slim-fit-cutaway-collar-popover-white-shirt/CSR0083WHT.html#cgid=shirts-casual-shirts&start=1"
    ];
    protected $errors = [
        "0" => ["code"=>"200","message"=>"Успешно"],
        "1" => ["code"=>"404","message"=>"Данный магазин не поддерживается"]
    ];
}
?>

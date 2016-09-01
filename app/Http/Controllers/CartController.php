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
        Log::debug("parse url:[".$url."]");
        if(!isset($this->shops[$ui["host"]])){$r["error"]=$this->errors["1"];$r["success"]=false;}
        if($r["success"]&&$ui["host"]!="www.kenzo.com"){
            $s = $this->shops[$ui["host"]];
            $result = file_get_contents($url);
            foreach($s["patterns"] as $k=>$p){
                if(is_array($p)){
                    foreach($p as $_){
                        if(preg_match($_,$result,$m)){
                            $r["product"][$k]=$m["value"];
                            break;
                        }
                    }
                }
                else {
                    if(preg_match($p,$result,$m))$r["product"][$k]=$m["value"];
                }

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
        ],
        "www.zara.com" =>[
            "patterns" => [
                "title" => "/\<img.*?class=\"image\-big _img\-zoom\".*?alt=\"Image 1 of (?<value>.+?)\"/i",
                "price" => "/\<div.*?class=\"tile__pricing tile__pricing--centered regular\"\>[\s\r\n]*£(?<value>[\d\.]+?)\"/im",
                "img" => "/\<a.*?class=\"_seoImg\".*?href=\"(?<value>.+?)\"/i",
                "sku" =>  "/\"product_id\"\s*\:\s*\[\n\s*\"(?<value>.+?)\"/i"
            ],
            "currency" => "EUR"
        ],
        "www.yoox.com" =>[
            "patterns" => [
                /*
                tc_vars["product_cod8"] = "46468832";
                tc_vars["product_cod10"] = "46468832QJ";
                tc_vars["product_brand"] = "RAY-BAN JUNIOR";
                tc_vars["product_brand_id"] = "28552";
                tc_vars["product_category"] = "Lunettes de soleil";
                tc_vars["product_category_code"] = "cchldsl";
                tc_vars["product_author"] = "RAY BAN JUNIOR";
                tc_vars["product_title"] = "RJ9063S";
                tc_vars["product_price"] = "89";
                tc_vars["product_discountprice"] = "89";
                tc_vars["product_url"] = "/fr/46468832QJ/item#sts=collgirl_kid";
                tc_vars["product_url_picture"] = "http://images.yoox.com/46/46468832qj_14_f.jpg";
                tc_vars["product_instock_num"] = "1";
                tc_vars["product_discountprice_EUR"] = "89";
                */
                "title" => "/tc_vars\[\"product_title\"\]\s*\=\s*\"(?<value>.+?)\"/i",
                "sku" => "/tc_vars\[\"product_cod10\"\]\s*\=\s*\"(?<value>.+?)\"/i",
                "img" => "/tc_vars\[\"product_url_picture\"\]\s*\=\s*\"(?<value>.+?)\"/i",
                "price" => [
                    "/tc_vars\[\"product_discountprice\"\]\s*\=\s*\"(?<value>.+?)\"/i",
                    "/tc_vars\[\"product_price\"\]\s*\=\s*\"(?<value>.+?)\"/i"
                ],
                "pk" => "/tc_vars\[\"product_cod8\"\]\s*\=\s*\"(?<value>.+?)\"/i",
            ],
            "currency" => "EUR"
        ],
        "www.disneystore.fr" =>[
            /*
            window.universal_variable.product={"id":"411018744389",
                "sku_code":"411018744389",
                "url":"http\u003a\u002f\u002fwww\u002edisneystore\u002efr\u002fproduits\u002fjouets\u002ffigurines\u002dd\u002daction\u002ffigurine\u002dwoody\u002dparlante\u002f411018744389\u002ehtml","name":"Figurine Woody parlante",
                "description":"Tirez sur la ficelle dans le dos de cette figurine Woody parlante et \u00e9coutez la prononcer des c\u00e9l\u00e8bres phrases de la vedette de Toy Story\u002e Ce fid\u00e8le compagnon est parfait pour les petits cowboys avec ses fantastiques d\u00e9tails du personnage\u002e",
                "stock":0,
                "unit_price":35.99,
                "unit_sale_price":35.99,"currency":"EUR","manufacturer":null,"category":"Jouets","subcategory":"Figurines d\u0027action","promo_code":"","isProductSet":false,"omniturepage":"products\u003atoys\u003aactionfigs","linked_products":[]};
            */
            "patterns" =>[
                "title" => "/\"\,\"name\"\:\"(?<value>.+?)\"/i",
                "description" => "/\"description\"\:\"(?<value>.+?)\"/i",
                "sku" => "/\"sku_code\"\:\"(?<value>.+?)\"/i",
                "img" => "/\<div.*class=\"mainImage\s+zoom\"\>[\r\n\s]*\<img.*?src\=\"(?<value>.+?)\".*?alt/i",
                "price" => "/\"unit_price\"\:(?<value>.+?)\,/i",
                "pk" => "/\"id\"\:\"(?<value>.+?)\"/i"
            ],
            "currency" => "EUR"
        ],
        "www.kenzo.com" =>[
            "patterns" => [
                //"app.page.setContext({"namespace":"product","title":"Eye Sweat","type":"product","host":"www.kenzo.com","path":"/on/demandware.store/Sites-Kenzo-Site/en/Product-ShowInCategory","querystring":"pid=L56G15084G08.98.4A&cgid=Boys"})",
                "title" => "/\title\"\:\"(?<value>.+?)\"/i",
                "img" => "/\<img.*?src\=\"(?<value>.+?)\".*?class\=\"img-responsive\"/i",
                "sku" => "/pid\=(?<value>.+?)[\&\"]/i"
            ],
            "currency" => "EUR"
        ],
        "www.polar.com" =>[
            "patterns" => [
                /*
                <div data-group-label="Polar A360 - Grand (L)" class="color_options group3"
                style="display: block;">
                <div data-product-id="90057424" data-product-price="199.90"
                data-color-label="Charcoal Black"
                class="selected">
                <img src="/sites/default/files/product2/66x83/a360_66x83_0004_black_hr.png" alt=""><br><span class="radio"></span><br><span class="label">Charcoal<br>Black</span></div></div>
                */
                "title" => "/\<div.*?data\-group\-label\=\"(?<value>.+?)\"/i",
                "img" => "/\<img.*?src\=\"(?<value>.+?)\".*?class\=\"img-responsive\"/i",
                "sku" => "/\<div.*?data-product-id\=\"(?<value>.+?)\"/i",
                "price" => "/\div.*?data\-product\-price\=\"(?<value>.+?)\"/i"
            ],
            "currency" => "EUR"
        ],
    ];
    protected $errors = [
        "0" => ["code"=>"200","message"=>"Успешно"],
        "1" => ["code"=>"404","message"=>"Данный магазин не поддерживается"]
    ];
}
?>

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
        //if($r["success"]&&$ui["host"]!="www.kenzo.com"){
        if($r["success"]){
            $s = $this->shops[$ui["host"]];
            //$result = file_get_contents($url);
            $result = $this->getPage($url);
            Log::debug($result);
            foreach($s["patterns"] as $k=>$p){
                if(is_array($p)){
                    foreach($p as $_){
                        if(preg_match($_,$result,$m)){
                            $r["product"][$k]=$m["value"];
                            if($k=='price'){
                                $r["product"][$k]=preg_replace("/\,/",".",$r["product"][$k]);
                                $r["product"][$k]=preg_replace("/[€]/","",$r["product"][$k]);
                            }
                            break;
                        }
                    }
                }
                else {
                    if(preg_match($p,$result,$m))$r["product"][$k]=$m["value"];
                }
                if($k == "img" && !isset($r["product"][$k])){
                    if($ui["host"]=="www.kenzo.com") $r["product"][$k] = "https://upload.wikimedia.org/wikipedia/en/thumb/5/5a/Kenzo_logo.png/250px-Kenzo_logo.png";
                    else if($ui["host"]=="www.polar.com") $r["product"][$k]="https://www.polar.com/kg-polar-logo.jpg";
                }
            }
            $r["currency"] = $this->shops[$ui["host"]]["currency"];
            Log::debug(json_encode($r,JSON_PRETTY_PRINT));
        }
        return response()->json($r);
    }
    protected function getPage ($url) {
        $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
        $timeout= 120;
        $dir            = dirname(__FILE__);
        $cookie_file    = 'storage/logs/cookies_' . md5($_SERVER['REMOTE_ADDR']) . '.txt';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($ch, CURLOPT_ENCODING, "" );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_AUTOREFERER, true );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout );
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
        $content = curl_exec($ch);
        if(curl_errno($ch))
        {
            //echo 'error:' . curl_error($ch);
        }
        else
        {
            return $content;
        }
        curl_close($ch);

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
        "www.chevignon.com" =>[
            /*
            <img id="img1" src="http://www.chevignon.com/content/product_9316305b.jpg"  itemprop="image"

            alt="CL FOUL" />
            */
            "patterns" =>[
                "title" => "/\<title.*\>(?<value>.+?)\<\/title\>/i",
                "sku" => "/product_id_magento\s*\:\s*\'(?<value>.+?)\'/i",
                "img" => "/product_url_picture\s*\:\s*\'(?<value>.+?)\'/i",
                "price" => "/product_unitprice_ati\s*\:\s*\'(?<value>.+?)\'\,/i",
            ],
            "currency" => "EUR"
        ],
        "www.3suisses.fr" =>[
            /*
            <img id="img1" src="http://www.chevignon.com/content/product_9316305b.jpg"  itemprop="image"

            alt="CL FOUL" />
            */
            "patterns" =>[
                "title" => "/\<title.*\>(?<value>.+?)\<\/title\>/i",
                "sku" => "/\<input.+?class=\"referenceMc\".+?value=\"(?<value>.+?)\"/i",
                "img" => "/\<img data-index=\"1\"\s*class=\"js-picture productpage_picture\".+?src=\"(?<value>.+?)\"/i",
                "price" => [
                    "/\<input.+?class=\"prixSansD3e\".+?value=\"(?<value>.+?)\"/i",
                    "/\<input.+?class=\"produitPrixBarre\".+?value=\"(?<value>.+?)\"/i",
                ]
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
        "www.royalcheese.com" =>[
            "patterns" => [
                "title" => "/\<title.*\>(?<value>.+?)\<\/title\>/i",
                "img" => "/\<img\s*class=img-responsive\s+id=thumb_\d+\s*src\=\"(?<value>.+?)\"/i",
                "sku" => "/var\s*productReference\s*=\s*\'(?<value>.+?)\'\;/i",
                "price" => "/var\s*productPrice\s*=\s*(?<value>.+?)\;/i",
            ],
            "currency" => "EUR"
        ],
        "www.novoidplus.com" =>[
            "patterns" => [
                "title" => "/\<title.*\>(?<value>.+?)\<\/title\>/i",
                "img" => "/\<meta property=\"og\:image\"\s+content\=\"(?<value>.+?)\"/i",
                "sku" => "/\<title.*\>(?<value>.+?)\<\/title\>/i",
                "price" => [
                    "/\<span itemprop=\"price\" content=\s*\"(?<value>.+?)\"/i",
                ]
            ],
            "currency" => "EUR"
        ],
        "www.frenchblossom.com" =>[
            "patterns" => [
                "title" => "/\<title.*\>(?<value>.+?)\<\/title\>/i",
                "img" => "/\<meta property=\"og\:image\"\s+content\=\"(?<value>.+?)\"/i",
                "sku" => "/\<title.*\>(?<value>.+?)\<\/title\>/i",
                "price" => [
                    //<span id="our_price_display" class="price" itemprop="price">17,60 €</span>
                    "/\<span id=\"our_price_display\".+?\>(?<value>.+?)\<\//i",
                ]
            ],
            "currency" => "EUR"
        ],
        "www.avenuedesjeux.com" =>[
            "patterns" => [
                "title" => "/\<title.*\>(?<value>.+?)\<\/title\>/i",
                //<img itemprop="image" class="first_picture" src="http://static.alipson.fr/fun-frag-ed-debroise.137/fun-frag--ed-debroise-aquarellum--peinture-sur-soie-perroquets-.28432-1.jpg" alt="Aquarellum Peinture sur soie&nbsp;: Perroquets  - 646" style="border:none;" width="400" height="400">
                "img" => "/\<meta (property|name)=\"og\:image\"\s+content\=\"(?<value>.+?)\"/i",
                "sku" => "/ecomm_prodid\:\s*\"(?<value>.+?)\"\,/i",
                "price" => [
                    //ecomm_value: "16.99"
                     "/ecomm_value\:\s*\"(?<value>.+?)\"/i",
                ]
            ],
            "currency" => "EUR"
        ],
        "www.auboisjoli.com" =>[
            "patterns" => [
                "title" => "/\<title.*\>(?<value>.+?)\<\/title\>/i",
                //<img itemprop="image" class="first_picture" src="http://static.alipson.fr/fun-frag-ed-debroise.137/fun-frag--ed-debroise-aquarellum--peinture-sur-soie-perroquets-.28432-1.jpg" alt="Aquarellum Peinture sur soie&nbsp;: Perroquets  - 646" style="border:none;" width="400" height="400">
                "img" => "/\<meta (property|name)=\"og\:image\"\s+content\=\"(?<value>.+?)\"/i",
                "sku" => "/ecomm_prodid\:\s*\"(?<value>.+?)\"\,/i",
                "price" => [
                    //ecomm_value: "16.99"
                     "/ecomm_value\:\s*\"(?<value>.+?)\"/i",
                ]
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

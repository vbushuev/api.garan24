<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use WC_API_Client;
use WC_API_Client_Exception;
use WC_API_Client_Resource_Products;


class ProductsController extends Controller{
    protected $resource;
    public function __construct(){
        $this->middleware('cors');
        $domain = "http://shop.gauzymall.com";
        $consumer_key = "ck_aae4b84777ac446eb62fc0e4276a0ee7b2bbd209";
        $consumer_secret = "cs_3e1c58bd4f00bdf2fc9c526318200d25dd3d4989";
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        try {
            $client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
            $this->resource = new WC_API_Client_Resource_Products($client);
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
        $id = $rq->input("i",false);
        $r=$this->get($id);
        return response()->json($r,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function postCreate(Request $rq){
        $r = ["error"=>["code"=>0,"message"=>"No request data"]];
        $d = $rq->getContent();
        Log::debug($d);
        $d = json_decode($d,true);
        if(isset($d["sku"])){
            $r=$this->get($d["sku"]);
            try{
                $d["enable_html_description"] = true;
                //$d["description"] = htmlspecialchars($d["description"]);
                if(isset($r["error"])){
                    $resp=$this->resource->create($d);
                }else{
                    $resp=$this->resource->update($r["id"],$d);
                }
                $r=$resp->product;
            }
            catch ( WC_API_Client_Exception $e ) {
                $r = [
                    "error"=>[
                        "message"=>$e->getMessage(),
                        "code"=>$e->getCode()
                    ]
                ];
            }
        }
        return response()->json($r,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getCreate(Request $rq){
        return $this->postCreate($rq);
    }
    public function getS(Request $rq){
        $r = [
            "ctshirts"=>[
                "s"=>"www.ctshirts.com",
                "j"=>"#pdpMain",
                "c"=>"CTS",
                "f"=>"^shirts\\-"
            ],
            "brandalley"=>[
                "s"=>"www.brandalley.com",
                "j"=>"#pdpMain",
                "c"=>"BRA",
                "f"=>"^shirts\\-"
            ]
        ];

        return response()->json($r,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getCategories(Request $rq){
        $r = ["error"=>["code"=>0,"message"=>"No request data"]];
        $c = $rq->input("c",false);
        try{
            $p = [];
            if($c!==false) $p["name"]=$c;
            $resp=$this->resource->get_categories(null,$p);
            $r=$resp->product_categories;
        }
        catch ( WC_API_Client_Exception $e ) {
            $r = [
                "error"=>[
                    "message"=>$e->getMessage(),
                    "code"=>$e->getCode()
                ]
            ];
        }
        return response()->json($r,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    protected function get($sku){
        $r=[];
        try{
            $resp=$this->resource->get_by_sku($sku);
            $r=json_decode(json_encode($resp->product),true);
        }catch ( WC_API_Client_Exception $e ) {
            $r = [
                "error"=>[
                    "message"=>$e->getMessage(),
                    "code"=>$e->getCode()
                ]
            ];
        }
        return $r;
    }
    public function Social(Request $rq){
        $data = $rq->all();
        $data = json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        Log::debug("Social: ".$data);
        $id =["id" => DB::table('social_credit')->insertGetId(["data"=>$data])];
        return response()->json($id,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }

}
?>

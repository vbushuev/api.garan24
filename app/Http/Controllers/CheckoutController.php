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

class CheckoutController extends Controller{
    protected $rawgoods;
    protected $raworder;
    protected $viewFolder = '/checkout';
    public function __construct(){
        //$this->raworder = file_get_contents('../tests/example.order.json');
        //$this->raworder = json_decode($this->raworder,true);
        //print_r($this->rawgoods);
    }
    public function getDesign(Request $rq){
        $deal = new Deal();
        $deal->byId("500");
        return view(
            preg_replace('/\//m','',$this->viewFolder).'.design',
            ["route"=>$this->getBPRoute("checkout"), "debug"=>"", "goods"=>$deal->order->getProducts(),"customer"=>[],"shop_url"=>$deal->getShopUrl()]
        );
    }
    public function getIndex(Request $rq){
        $id = $rq->get('id','noindex');
        if($id=='noindex') return view('public.index');
        $rq->session()->put("deal_id",$id);
        $deal = new Deal();
        $deal->byId($id);
        if(!isset($deal->x_secret))  return view('public.index');
        return view(preg_replace('/\//m','',$this->viewFolder).'.checkout'
            ,["route"=>$this->getBPRoute("checkout"),"section" => 'contact', "debug"=>"", "goods"=>$deal->order->getProducts(),"customer"=>[],"shop_url"=>$deal->getShopUrl()]
        );
    }
    public function postIndex(Request $rq){
        $data = $rq->getContent();
        $deal = new Deal();
        $deal->byJson($data);
        $resp = $deal->sync();
        Log::debug("Deal response: ".Garan24::obj2str($resp));
        //if($resp->code==0){return redirect()->away($resp->redirect_url);}
        return $resp->__toString();
    }
    public function postPersonal(Request $rq){
        $data = $this->getParams($rq);
        if($data===false)redirect($this->vieFolder.'/checkout');
        if(!isset($data["email"])||!isset($data["phone"])){
            return redirect($this->viewFolder.'checkout');
        }
        $id = $rq->session()->get("deal_id");
        $deal = new Deal();
        $deal->byId($id);
        $cust = new Customer('{"email":"'.$data["email"].'","phone":"'.$data["phone"].'"}',$deal->getWC());
        $cust->sync();
        $rq->session()->put("user_id",$cust->customer_id);
        $deal->update(["customer_id"=>$cust->id]);
        return view(preg_replace('/\//m','',$this->viewFolder).'.personal'
            ,["route"=>$this->getBPRoute("personal")
            ,"section" => 'contact'
            ,"debug"=>""
            ,"goods"=>$deal->order->getProducts()
            ,"customer"=>$cust->toArray()
            ,"shop_url"=>$deal->getShopUrl()
        ]);
    }
    public function postDeliverypaymethod(Request $rq){
        $data = $this->getParams($rq);
        if($data===false)redirect($this->vieFolder.'/checkout');
        $id = $rq->session()->get("deal_id");
        $deal = new Deal();
        $deal->byId($id);
        $deal->update($data);
        Garan24::debug($deal->getDeliveryTypes());
        Garan24::debug($deal->getPaymentTypes());
        return view(
            preg_replace('/\//m','',$this->viewFolder).'.deliverypaymethod',
            [
                "route"=>$this->getBPRoute("deliverypaymethod"),
                "section" => 'delivery',
                "debug"=>"",
                "goods"=>$deal->order->getProducts()
                ,"shop_url"=>$deal->getShopUrl()
                ,"payments" => $deal->getPaymentTypes()
                ,"delivery" => $deal->getDeliveryTypes()
            ]
        );
    }
    public function postThanks(Request $rq){
        $data = $this->getParams($rq);
        if($data===false)redirect($this->vieFolder.'/checkout');
        $id = $rq->session()->get("deal_id");
        $deal = new Deal();
        $deal->byId($id);
        $resp = $deal->finish();
        return redirect()->away($deal->response_url)->with($resp->__toString());//->with($resp->toArray());
        return response($resp->__toString())
            ->header('Content-Type', "application/json")
            ->header('Status', "302")
            ->header("Location",$deal->response_url);
    }
    public function postPassport(Request $rq){
        $data = $this->getParams($rq);
        if($data===false)redirect($this->vieFolder.'/checkout');
        $id = $rq->session()->get("deal_id");
        $deal = new Deal();
        $deal->byId($id);
        return view(preg_replace('/\//m','',$this->viewFolder).'.passport',["route"=>$this->getBPRoute("passport"), "debug"=>"", "goods"=>$deal->order->getProducts()]);
    }
    public function getCard(Request $rq){
        return $this->postCard($rq);
    }
    public function postCard(Request $rq){
        $data = $this->getParams($rq);
        if($data===false)redirect($this->vieFolder.'/checkout');
        $id = $rq->session()->get("deal_id");
        $deal = new Deal();
        $deal->byId($id);
        $deal->update([
            "payment_id"=>$data["payment_type_id"],
            "delivery_id"=>$data["delivery_type_id"],
        ]);
        return view(preg_replace('/\//m','',$this->viewFolder).'.card',[
            "route"=>$this->getBPRoute("card"),
            "section" => 'payment',
            "debug"=>"",
            "goods"=>$deal->order->getProducts(),
            "shop_url"=>$deal->getShopUrl(),
            "order_id"=>$deal->order->id,
            "address"=>$deal->getCustomer()->toAddressString(),
            "payment"=>[
                "id"=>$data["payment_type_id"],
                "name"=>$data["payment_type_name"],
                "desc"=>$data["payment_type_desc"]
            ],
            "delivery"=>[
                "id"=>$data["delivery_type_id"],
                "name"=>$data["delivery_type_name"],
                "desc"=>$data["delivery_type_desc"]
            ]
        ]);
    }
    protected function getParams(Request $rq){
        $id = $rq->session()->get("deal_id","session_expired");
        if($id=="session_expired") return false;
        //Log::debug("getParams data:".$rq->get("data"));
        //Log::debug("getParams all:".Garan24::obj2str($rq->all()));
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
        Log::debug("CheckoutController:getParams request: ".Garan24::obj2str($data));
        return $data;
    }
    protected $bpmodels=[
        "index" => ["text"=>"Продолжить","href"=>"/"],
        "email" => ["text"=>"Продолжить","href"=>"/checkout"],
        "personal" => ["text"=>"Продолжить","href"=>"/personal"],
        "delivery" => ["text"=>"Продолжить","href"=>"/delivery"],
        "paymethod" => ["text"=>"Продолжить","href"=>"/paymethod"],
        "checkcard" => ["text"=>"Продолжить","href"=>"/checkcard"],
        "deliverypaymethod" => ["text"=>"Продолжить","href"=>"/deliverypaymethod"],
        "thanks" => ["text"=>"Продолжить","href"=>"/thanks"],
        "passport" => ["text"=>"Продолжить","href"=>"/passport"],
        "card" => ["text"=>"Подтвердить","href"=>"/card"],
    ];
    protected $bpmatrix=[
        "index" => ["condition"=>false,"next"=>"email","back"=>"index"],
        "email" => ["condition"=>false,"next"=>"personal","back"=>"index"],
        "checkout" => ["condition"=>false,"next"=>"personal","back"=>"index"],
        //"personal" => ["condition"=>false,"next"=>"delivery","back"=>"email"],
        "personal" => ["condition"=>false,"next"=>"deliverypaymethod","back"=>"email"],
        "delivery" => ["condition"=>false,"next"=>"paymethod","back"=>"personal"],
        "deliverypaymethod" => ["condition"=>["credit"=>"passport"],"next"=>"card","back"=>"personal"],
        "paymethod" => ["condition"=>["credit"=>"passport"],"next"=>"card","back"=>"delivery"],
        "checkcard" => ["condition"=>false,"next"=>"thanks","back"=>"deliverypaymethod"],
        "thanks" => ["condition"=>false,"next"=>"index","back"=>false],
        "passport" => ["condition"=>false,"next"=>"card","back"=>"deliverypaymethod"],
        "card" => ["condition"=>false,"next"=>"thanks","back"=>"deliverypaymethod"]
    ];
    protected function getBPRoute($current,$condition=false){
        $c = (!isset($this->bpmatrix[$current]))
            ? $this->bpmatrix["index"]
            : $this->bpmatrix[$current];
        return [
            "dir" => $this->viewFolder,
            "next" => ($c["condition"]!==false)
                    ? (isset($c["condition"][$condition])?$this->bpmodels[$c["condition"][$condition]]:$this->bpmodels[$c["next"]])
                    : $this->bpmodels[$c["next"]],
            "back" => (($c["back"]!==false)?$this->bpmodels[$c["back"]]:false)
        ];
    }

}
?>

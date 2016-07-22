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
            "id"=>$data["deal_id"],
        ]);
        return view($this->viewFolder.'.welcome',["viewFolder"=>$this->viewFolder,"deal"=>$deal]);
    }
    public function getPassport(Request $rq){
        $this->postPassport($rq);
    }
    public function postPassport(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal([
            "id"=>$data["deal_id"],
            "data"=>$data
        ]);
        return view(
            $this->viewFolder.'.passport',
            [
                "route"=>$this->getBPRoute("passport"),
                "section" => 'passport',
                "viewFolder"=>$this->viewFolder,"debug"=>"",
                "customer"=>($deal->getCustomer()!==null)?$deal->getCustomer()->toArray():[],
                "shop_url"=>$deal->getShopUrl(),
                "goods"=>$deal->order->getProducts(),
                "deal"=>$deal
            ]
        );
    }
    public function getPayment(Request $rq){
        $this->postPayment($rq);
    }
    public function postPayment(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        if(isset($data["payment_type_id"])&&isset($data["delivery_type_id"])){
            $data["payment_id"]=$data["payment_type_id"];
            $data["delivery_id"]=$data["delivery_type_id"];
        }
        $deal = new Deal([
            "id"=>$data["deal_id"],
            "data"=>$data
        ]);
        return view(
            $this->viewFolder.'.payment',
            [
                "route"=>$this->getBPRoute("payment"),
                "section" => 'payment',
                "viewFolder"=>$this->viewFolder,"debug"=>"",
                "customer"=>($deal->getCustomer()!==null)?$deal->getCustomer()->toArray():[],
                "shop_url"=>$deal->getShopUrl(),
                "goods"=>$deal->order->getProducts(),
                "amount"=>($deal->order->order_total+$deal->shipping_cost),
                "deal"=>$deal
            ]
        );
    }
    public function getCard(Request $rq){
        return $this->postCard($rq);
    }
    public function postCard(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal([
            "id"=>$data["deal_id"],
            "data"=>$data
        ]);
        $deal->client_ip = $rq->ip();
        $deal->update($data);
        try{
            //$response = $this->payout($deal);
            //return view($this->viewFolder.'.cardpayneteasy',[
            return view($this->viewFolder.'.card',[
                "route"=>$this->getBPRoute("card2"),
                "section" => 'payment',
                "title"=>'<i class="first">Заказ</i> №'.$deal->order->id.' оформлен',
                "deal" => $deal,
                "viewFolder"=>$this->viewFolder,"debug"=>"",
                "amount"=>($deal->order->order_total+$deal->shipping_cost),//"amount"=>(isset($data["TotalAmountHidden"])?$data["TotalAmountHidden"]:"0"),
                "goods"=>$deal->order->getProducts(),
                "shipping_cost"=>$deal->shipping_cost,
                "shop_url"=>$deal->getShopUrl(),
                "order_id"=>$deal->order->id,
                "address"=>$deal->getCustomer()->toAddressString(),
                "payment"=>$deal->payment,
                "delivery"=>$deal->delivery,
                //"payneteasy_url"=>$response->getRedirectUrl()
            ]);
        }
        catch(\Garan24\Gateway\Aruispay\Exception $e){
            Garan24::debug("Exception in AruisPay gateway:".$e->getMessage());
            return redirect()->back()->with("message","На данный момент сервис оплаты картой не доступен, попробуйте повторить попытку или выберете другой метод оплаты");
        }

    }
    public function getPayout(Request $rq){
        return $this->postPayout($rq);
    }
    public function postPayout(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view('checkout.ups');
        $deal = new Deal(["id"=>$data["deal_id"]]);
        $deal->client_ip = $rq->ip();
        try{
            $response = $this->payout($deal);
            if($response->isRedirect()) return redirect()->away($response->getRedirectUrl());
        }
        catch(\Garan24\Gateway\Aruispay\Exception $e){
            print("Exception in AruisPay gateway:".$e->getMessage());
        }
    }
    public function postPayoutCallback(Request $rq){
        $data = $rq->getContent();
        Log::debug("payoutcallback:".$data);
    }
    public function getPayoutresponse(Request $rq){
        return $this->postPayoutresponse($rq);
    }
    public function postPayoutresponse(Request $rq){
        $data = $rq->getContent();
        Log::debug("payoutresponse:".$data);
        $dataArr = [];
        parse_str($data,$dataArr);
        $r = [
            "url" => $_SERVER["HTTP_ORIGIN"],
            "data" => $dataArr
        ];
        $redirect_url = "";
        try{
            $obj = new \Garan24\Gateway\Ariuspay\CallbackResponse($r,function($d){});
            if($obj->accept()){
                $crd = new \Garan24\Gateway\Ariuspay\CreateCardRef([
                    'client_orderid' => $obj->client_orderid,
                    'orderid' => $obj->orderid
                ]);
                $crd->call();
                $key = "card-ref-id";
                $cardref =  $crd->getResponse()->$key;
                //$crd->getResponse()->
                /* Check user have this card*/
                // DB::table('garan24_usermeta')->exist
                $id = $rq->session()->get("deal_id");
                $deal = new Deal();
                $deal->byId($id);
                $deal->update(["card-ref-id"=>$cardref]);
                Garan24::debug("Redirecting to ".$this->viewFolder.'/thanks');
                return redirect($this->viewFolder."/thanks");
                return $this->postThanks($rq);
            }
            else return redirect($this->viewFolder."/card")->with('status','Вашу карту не удалось проверить. Повторите попытку или воспользуйтесь другой картой.');//$this->postCard($rq);
        }
        catch(\Garan24\Gateway\Ariuspay\Exception $e){
            Log::error("Exception in AruisPay Response gateway:".$e->getMessage());
            return redirect()->action("CheckoutController@postCard")->with('status','Вашу карту не удалось проверить. Повторите попытку или воспользуйтесь другой картой.');//$this->postCard($rq);
        }
    }
    public function getThanks(Request $rq){
        return $this->postThanks($rq);
    }
    public function postThanks(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if($data["cvv"]!="123"){
            return redirect()->back()->with('status','Вашу карту не удалось проверить. Повторите попытку или воспользуйтесь другой картой.');
        }
        if($data===false||!$rq->session()->has("deal_id"))redirect('/checkout');
        $deal = new Deal(["id"=>$data["deal_id"],"data"=>$data]);
        $resp = $deal->finish();
        $resp_str = $resp->__toString();
        Garan24::debug("Response :".$resp_str);
        try{
            $result = file_get_contents($deal->response_url, null, stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
                    'header' => array('Content-Type: application/json'."\r\n"
                    . 'Authorization: username:key'."\r\n"
                    . 'Content-Length: ' . strlen($resp_str) . "\r\n"),
                    'content' => $resp_str)
                    )
                )
            );
        }
        catch(\Exception $e){
            Log::error($e);
        }
        return view($this->viewFolder.'.thanks',[
            "route"=>$this->getBPRoute("thanks"),
            "section" => 'thanks',
            "deal" => $deal,
            "title"=>'<i class="first">Заказ</i> №'.$deal->order->id.' подтвержден',
            "viewFolder"=>$this->viewFolder,"debug"=>"",
            "goods"=>$deal->order->getProducts(),
            "amount"=>($deal->order->order_total+$deal->shipping_cost),
            "shop_url"=>$deal->getShopUrl(),
            "order_id"=>$deal->order->id,
            "address"=>$deal->getCustomer()->toAddressString(),
            "payment"=>$deal->payment,
            "delivery"=>$deal->delivery
        ]);
        return redirect()->away($deal->response_url)->with($resp->__toString());//->with($resp->toArray());
        return response($resp->__toString())
            ->header('Content-Type', "application/json")
            ->header('Status', "302")
            ->header("Location",$deal->response_url);
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
    protected function payout($deal){
        $saleData = [
            "client_orderid" => $deal->order->id,
            "order_desc" => "Garan24 pay order",
            "first_name" => $deal->getCustomer()->billing_address["first_name"],
            "last_name" => $deal->getCustomer()->billing_address["last_name"],
            "ssn" => "",
            "birthday" => "",
            "address1" => $deal->getCustomer()->toAddressString(),
            "address2" => "",
            "city" => $deal->getCustomer()->billing_address["city"],
            "state" => "",//isset($data["state"])?$data["state"]:"",
            "zip_code" => $deal->getCustomer()->billing_address["postcode"],
            "country" => "RU",
            "phone" => $deal->getCustomer()->billing_address["phone"],
            "cell_phone" => $deal->getCustomer()->billing_address["phone"],
            "amount" => 1,
            "currency" => "RUB",
            "email" => $deal->getCustomer()->billing_address["email"],

            "ipaddress" => "151.248.117.239",//$deal->client_ip(),
            "site_url" => isset($data["site_url"])?$data["site_url"]:"",
            /*"credit_card_number" => "4444555566661111",
            "card_printed_name" => "CARD HOLDER",
            "expire_month" => "12",
            "expire_year" => "2099",
            "cvv2" => "123",*/
            "purpose" => "www.garan24.eu",
            "redirect_url" => $this->thishost."/checkout/payoutresponse",
            "server_callback_url" => $this->thishost."/checkout/payoutcallback",
            //"merchant_data" => "VIP customer"
        ];
        $request = new \Garan24\Gateway\Ariuspay\SaleRequest($saleData);
        $connector = new \Garan24\Gateway\Ariuspay\Connector();
        $connector->setRequest($request);
        $connector->call();
        return $connector->getResponse();
    }
    protected function getBPRoute($current,$condition=false){
        $c = (!isset($this->bpmatrix[$current]))
            ? $this->bpmatrix["index"]
            : $this->bpmatrix[$current];
        return [
            "dir" => "/checkout",
            //"dir" => $this->viewFolder,
            "next" => ($c["condition"]!==false)
                    ? (isset($c["condition"][$condition])?$this->bpmodels[$c["condition"][$condition]]:$this->bpmodels[$c["next"]])
                    : $this->bpmodels[$c["next"]],
            "back" => (($c["back"]!==false)?$this->bpmodels[$c["back"]]:false)
        ];
    }
    protected $bpmodels=[
        "index" => ["text"=>"Продолжить","href"=>"/"],
        "email" => ["text"=>"Продолжить","href"=>"/checkout"],
        "personal" => ["text"=>"Продолжить","href"=>"/personal"],
        "delivery" => ["text"=>"Продолжить","href"=>"/delivery"],
        "paymethod" => ["text"=>"Продолжить","href"=>"/paymethod"],
        "checkcard" => ["text"=>"Продолжить","href"=>"/checkcard"],
        "deliverypaymethod" => ["text"=>"Продолжить","href"=>"/deliverypaymethod"],
        "address" => ["text"=>"Продолжить","href"=>"/address"],
        "thanks" => ["text"=>"Продолжить","href"=>"/thanks"],
        "passport" => ["text"=>"Продолжить","href"=>"/passport"],
        "payment" => ["text"=>"Продолжить","href"=>"/payment"],
        "card2" => ["text"=>"Продолжить","href"=>"/cardpayneteasy"],
        "card" => ["text"=>"Оплатить","href"=>"/card"],
        "payout" => ["text"=>"Подтвердить","href"=>"/payout"],
    ];
    protected $bpmatrix=[
        "index" => ["condition"=>false,"next"=>"email","back"=>"index"],
        "email" => ["condition"=>false,"next"=>"personal","back"=>"index"],
        "checkout" => ["condition"=>false,"next"=>"deliverypaymethod","back"=>"index"],
        //"personal" => ["condition"=>false,"next"=>"delivery","back"=>"email"],
        "personal" => ["condition"=>false,"next"=>"deliverypaymethod","back"=>"email"],
        "delivery" => ["condition"=>false,"next"=>"paymethod","back"=>"personal"],
        "deliverypaymethod" => ["condition"=>false,"next"=>"address","back"=>"email"],
        "address" => ["condition"=>false,"next"=>"passport","back"=>"deliverypaymethod"],
        "deliverymethod" => ["condition"=>false,"next"=>"address","back"=>"email"],
        "paymethod" => ["condition"=>["credit"=>"passport"],"next"=>"card","back"=>"delivery"],
        "checkcard" => ["condition"=>false,"next"=>"thanks","back"=>"deliverypaymethod"],
        "thanks" => ["condition"=>false,"next"=>"card","back"=>"passport"],
        "passport" => ["condition"=>false,"next"=>"payment","back"=>"deliverypaymethod"],
        "payment" => ["condition"=>false,"next"=>"card","back"=>"passport"],
        "card" => ["condition"=>false,"next"=>"thanks","back"=>"deliverypaymethod"],
        //"card2" => ["condition"=>false,"next"=>"payout","back"=>"deliverypaymethod"]
        "card2" => ["condition"=>false,"next"=>"thanks","back"=>"passport"]
    ];

}
?>

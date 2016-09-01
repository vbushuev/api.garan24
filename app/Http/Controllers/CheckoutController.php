<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Mail;
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
use \Garan24\Gateway\Ariuspay\PreauthRequest as PreauthRequest;
/*
- проггрес бар ()
- знак вопроса подвинуть, и тексты сразу
*/

class CheckoutController extends Controller{
    protected $viewFolder = 'co';
    protected $thishost = "https://service.garan24.ru";
    public function __construct(){
        \Garan24\Garan24::$DB["host"] = "151.248.117.239";
        $this->middleware('cors');
        //$this->raworder = file_get_contents('../tests/example.order.json');
        //$this->raworder = json_decode($this->raworder,true);
        //print_r($this->rawgoods);
    }
    public function getDesign(Request $rq){
        $deal = new Deal(["id"=>"1014"]);
        return view(
            $this->viewFolder.'.design',
            ["viewFolder"=>$this->viewFolder,"debug"=>"","section"=>"thanks","deal"=>$deal]
        );
    }
    public function getIndex(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $id = $rq->get('id','noindex');
        if($id=="noindex") return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $rq->session()->put("deal_id",$id);
        $deal = new Deal(["id"=>$id]);
        if(!isset($deal->x_secret))  return view('public.index');
        return response()->view($this->viewFolder.'.checkout',[
            "route"=>$this->getBPRoute("checkout"),
            "section" => 'contact',
            "viewFolder"=>$this->viewFolder,"debug"=>"",
            "goods"=>$deal->order->getProducts(),
            "customer"=>[],
            "deal"=>$deal,
            "shop_url"=>$deal->getShopUrl()
        ]
        );
    }
    public function postIndex(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $rq->getContent();
        $deal = new Deal();
        Log::debug("In request:".$data);
        $deal->byJson($data);
        $resp = $deal->sync();
        Log::debug("Deal response: ".$resp);
        //if($resp->code==0){return redirect()->away($resp->redirect_url);}
        return response()->json($resp->toArray());
    }
    public function getCrossbrowser(Request $rq){
        return response()->json(["a"=>"b"]);
    }
    /* Ajax functions */
    public function getGoods(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        //$data = $this->getParams($rq);
        //if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal(["id"=>$rq->input("deal_id")]);
        return response()->view(
            $this->viewFolder.'.goods',
            [
                "deal"=>$deal,
            ]
        );
    }
    /* Ajax functions */
    public function postPersonal(Request $rq){
        $data = $this->getParams($rq);
        if($data===false||!$rq->session()->has("deal_id"))return redirect()-back();
        if(!isset($data["email"])||!isset($data["phone"])){
            return redirect()-back();
        }
        //$id = $rq->session()->get("deal_id");
        $id = $rq->cookie("deal_id");
        $deal = new Deal(["id"=>$id]);
        $cust = new Customer('{"email":"'.$data["email"].'","phone":"'.$data["phone"].'"}',$deal->getWC());
        $cust->sync();
        $rq->session()->put("user_id",$cust->customer_id);
        $deal->update(["customer_id"=>$cust->id]);
        return view($this->viewFolder.'.personal'
            ,["route"=>$this->getBPRoute("personal")
            ,"section" => 'contact'
            ,"debug"=>""
            ,"goods"=>$deal->order->getProducts()
            ,"customer"=>$cust->toArray()
            ,"shop_url"=>$deal->getShopUrl()
        ]);
    }
    public function getDeliverypaymethod(Request $rq){
        return $this->postDeliverypaymethod($rq);
    }
    public function postDeliverypaymethod(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal(["id"=>$data["deal_id"],"data"=>$data]);
        if(isset($data["email"])&&isset($data["phone"])){
            Log::debug("Appending customer. ".'{"email":"'.$data["email"].'","phone":"'.$data["phone"].'"}');
            $cust = new Customer('{"email":"'.$data["email"].'","phone":"'.$data["phone"].'"}',$deal->getWC());
            $cust->sync();
            $rq->session()->put("user_id",$cust->customer_id);
            $deal->update(["customer_id"=>$cust->customer_id]);
        }
        $deal->update($data);

        return view(
            $this->viewFolder.'.deliverymethod',
            [
                "route"=>$this->getBPRoute("deliverymethod"),
                "section" => 'delivery',
                "viewFolder"=>$this->viewFolder,"debug"=>"",
                "goods"=>$deal->order->getProducts(),
                "deal"=>$deal,
                "customer"=>$deal->getCustomer()->toArray(),
                "shop_url"=>$deal->getShopUrl(),
                "payments" => $deal->getPaymentTypes(),
                "delivery" => $deal->getDeliveryTypes()
            ]
        );
    }
    public function getAddress(Request $rq){
        return $this->postAddress($rq);
    }
    public function postAddress(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal([
            "id"=>$data["deal_id"],
            "data"=>$data
        ]);
        //if($deal->delivery["id"]==6) {
            return view(
                $this->viewFolder.'.address',
                [
                    "route"=>$this->getBPRoute("address"),
                    "section" => 'delivery',
                    "viewFolder"=>$this->viewFolder,"debug"=>"",
                    "shop_url"=>$deal->getShopUrl(),
                    "deal"=>$deal
                ]
            );

        //return redirect()->action("CheckoutController@postPassport");
        //return redirect('checkout/passport');
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
        Mail::send('mail.welcome',["viewFolder"=>"mail","deal"=>$deal],function($message) use ($deal){
            $message->to($deal->getCustomer()->email)->subject("ГАРАН24");
        });
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
        try{
            $response = $this->payout($deal);
            Log::debug(json_encode($response));
            if($response->isRedirect()) return redirect()->away($response->getRedirectUrl());

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
            \Garan24\Garan24::debug("Exception in AruisPay gateway:".$e->getMessage());
            return redirect()->back()->with("message","На данный момент сервис оплаты картой не доступен, попробуйте повторить попытку или выберете другой метод оплаты");
        }

    }
    public function getPayout(Request $rq){
        return $this->postPayout($rq);
    }
    public function postPayout(Request $rq){
        Log::debug(__CLASS__.".".__METHOD__);
        $data = $this->getParams($rq);
        if(!$data) return view($this->viewFolder.'.ups',["viewFolder"=>$this->viewFolder]);
        $deal = new Deal([
            "id"=>$data["deal_id"],
            "data"=>$data
        ]);
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
                $deal = new Deal(["id"=>$id,"data"=>["card-ref-id"=>$cardref]]);
                \Garan24\Garan24::debug("Redirecting to ".$this->viewFolder.'/thanks');
                //return redirect("/thanks");
                return $this->postThanks($rq);
            }
            else return redirect("checkout/card")->with('status','Вашу карту не удалось проверить. Повторите попытку или воспользуйтесь другой картой.');//$this->postCard($rq);
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
        $data["status"] = "checkout";
        if(isset($data["cvv"])&&$data["cvv"]!="123"){
            return redirect()->back()->with('status','Вашу карту не удалось проверить. Повторите попытку или воспользуйтесь другой картой.');
        }
        if($data===false||!$rq->session()->has("deal_id"))redirect('/checkout');
        $deal = new Deal(["id"=>$data["deal_id"],"data"=>$data]);
        $resp = $deal->finish();
        $resp_str = $resp->__toString();
        \Garan24\Garan24::debug("Response :".$resp_str);
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
        if($deal->payment["id"]==2) Mail::send('mail.orderpayonline',["viewFolder"=>"mail","deal"=>$deal],function($message) use ($deal){$message->to($deal->getCustomer()->email)->subject("ГАРАН24");});
        else Mail::send('mail.orderpayondelivery',["viewFolder"=>"mail","deal"=>$deal],function($message) use ($deal){$message->to($deal->getCustomer()->email)->subject("ГАРАН24");});
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
    public function getSendmemails(Request $rq){
        $deal = new Deal(["id"=>$rq->input("id","1107")]);
        Mail::send('mail.welcome',["viewFolder"=>"mail","deal"=>$deal],function($message) use ($deal){
            $message->to($deal->getCustomer()->email)->subject("ГАРАН24");
        });
        if($deal->payment["id"]==2) Mail::send('mail.orderpayonline',["viewFolder"=>"mail","deal"=>$deal],function($message) use ($deal){$message->to($deal->getCustomer()->email)->subject("ГАРАН24");});
        else Mail::send('mail.orderpayondelivery',["viewFolder"=>"mail","deal"=>$deal],function($message) use ($deal){$message->to($deal->getCustomer()->email)->subject("ГАРАН24");});
        return "Mails are sent.";
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
                $log .= "{$k} = ".\Garan24\Garan24::obj2str($v).", ";
            }
        }
        $data = array_merge($data,["deal_id" => $rq->session()->get("deal_id"),"deal_id_source" => "session"]);
        if(strlen($data["deal_id"])<=0)$data = array_merge($data,["deal_id" => $rq->cookie("deal_id"),"deal_id_source" => "cookie"]);
        Log::debug("CheckoutController:getParams request: ".\Garan24\Garan24::obj2str($data));
        return $data;
    }
    protected function payout($deal){
        if($deal->payment["id"] == "1") $amount = 1;
        else $amount = ($deal->order->order_total+$deal->shipping_cost);

        $operation = "PreauthRequest";
        $saleData = [
            "data"=>[
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
                "amount" => $amount,
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
            ]
        ];
        //$saleData = array_merge($this->ariuspay["akbars"][$operation],$saleData);
        $saleData = array_merge($this->ariuspay["lemonway"][$operation],$saleData);
        $request = new \Garan24\Gateway\Ariuspay\PreauthRequest($saleData);
        switch($operation){
            case "CaptureRequest":$request = new \Garan24\Gateway\Ariuspay\CaptureRequest($saleData);break;
        }
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
        "index" => ["condition"=>false,"next"=>"email","back"=>false],
        "email" => ["condition"=>false,"next"=>"personal","back"=>"index"],
        "checkout" => ["condition"=>false,"next"=>"deliverypaymethod","back"=>false],
        //"personal" => ["condition"=>false,"next"=>"delivery","back"=>"email"],
        "personal" => ["condition"=>false,"next"=>"deliverypaymethod","back"=>"email"],
        "delivery" => ["condition"=>false,"next"=>"paymethod","back"=>"personal"],
        "deliverypaymethod" => ["condition"=>false,"next"=>"address","back"=>"index"],
        "address" => ["condition"=>false,"next"=>"passport","back"=>"deliverypaymethod"],
        "deliverymethod" => ["condition"=>false,"next"=>"passport","back"=>"index"],
        "paymethod" => ["condition"=>["credit"=>"passport"],"next"=>"card","back"=>"delivery"],
        "checkcard" => ["condition"=>false,"next"=>"thanks","back"=>"deliverypaymethod"],
        "thanks" => ["condition"=>false,"next"=>"card","back"=>"passport"],
        "passport" => ["condition"=>false,"next"=>"payment","back"=>"deliverypaymethod"],
        "payment" => ["condition"=>false,"next"=>"card","back"=>"passport"],
        "card" => ["condition"=>false,"next"=>"thanks","back"=>"deliverypaymethod"],
        //"card2" => ["condition"=>false,"next"=>"payout","back"=>"deliverypaymethod"]
        "card2" => ["condition"=>false,"next"=>"thanks","back"=>"passport"]
    ];
    protected $ariuspay = [
        "test" => [// testdata
            "CaptureRequest" => [
                "url" => "https://sandbox.ariuspay.ru/paynet/api/v2/",
                "endpoint" => "1144",
                "merchant_key" => "99347351-273F-4D88-84B4-89793AE62D94",
                "merchant_login" => "GARAN24"
            ],
            "PreauthRequest" => [
                "url" => "https://sandbox.ariuspay.ru/paynet/api/v2/",
                "endpoint" => "1144",
                "merchant_key" => "99347351-273F-4D88-84B4-89793AE62D94",
                "merchant_login" => "GARAN24"
            ]
        ],
        "akbars" =>[
            "CaptureRequest" => [
                "url" => "https://gate.payneteasy.com/paynet/api/v2/",
                "endpoint" => "2879",
                "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
                "merchant_login" => "garan24"
            ],
            "PreauthRequest" => [
                "url" => "https://gate.payneteasy.com/paynet/api/v2/",
                "endpoint" => "3028",
                "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
                "merchant_login" => "garan24"
            ]
        ],
        "lemonway" =>[
            "CaptureRequest" => [
                "url" => "https://gate.payneteasy.com/paynet/api/v2/",
                "endpoint" => "2879",
                "merchant_key" => "1398E8C3-3D93-44BF-A14A-6B82D3579402",
                "merchant_login" => "garan24"
            ],
            "PreauthRequest" => [
                "url" => "https://sandbox.libill.com/paynet/api/v2/",
                "endpoint" => "204",
                "merchant_key" => "DB3C4FE7-1D1B-4106-8E36-1F5EAC807E34",
                "merchant_login" => "eurolego"
            ]
        ],
    ];
}
?>

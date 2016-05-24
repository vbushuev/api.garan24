<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use \Garan24\Garan24 as Garan24;
use \Garan24\Gateway\Ariuspay\Sale as AriusSale;
use \Garan24\Gateway\Ariuspay\Exception as AriuspayException;

class MagnitolkinController extends Controller{
    public function getIndex(Request $rq){
        return view('magnitolkin.index');
    }
    public function getCheckout(Request $rq){
        return view('magnitolkin.cart.email',["route"=>$this->getBPRoute("email")]);
    }
    public function getPersonal(Request $rq){
        return view('magnitolkin.cart.personal',["route"=>$this->getBPRoute("personal")]);
    }
    public function getDelivery(Request $rq){
        return view('magnitolkin.cart.delivery',["route"=>$this->getBPRoute("delivery")]);
    }
    public function getPaymethod(Request $rq){
        return view('magnitolkin.cart.paymethod',["route"=>$this->getBPRoute("paymethod")]);
    }
    public function getDeliverypaymethod(Request $rq){
        return view('magnitolkin.cart.deliverypaymethod',["route"=>$this->getBPRoute("paymethod")]);
    }
    public function getThanks(Request $rq){
        return view('magnitolkin.cart.thankspage',["route"=>$this->getBPRoute("thanks")]);
    }
    public function getPassport(Request $rq){
        return view('magnitolkin.cart.passport',["route"=>$this->getBPRoute("passport")]);
    }
    public function getCheckcard(Request $rq){
        return view('magnitolkin.cart.payment-form',["route"=>$this->getBPRoute("checkcard")]);
        $data = [
            "client_orderid"=>"905",
            "order_desc" => "Test Order Description",
            "first_name" => "John",
            "last_name" => "Smith",
            "ssn" => "1267",
            "birthday" => "19820115",
            "address1" => "100 Main st",
            "city" => "Seattle",
            "state" => "WA",
            "zip_code" => "98102",
            "country" => "US",
            "phone" => "+12063582043",
            "cell_phone" => "%2B19023384543",
            "amount" => "10.42",
            "email" => "john.smith@gmail.com",
            "currency" => "RUB",
            "ipaddress" => "65.153.12.232",
            "site_url" => "www.google.com",
            /*"credit_card_number" => "4444555566661111",
            "card_printed_name" => "CARD HOLDER",
            "expire_month" => "12",
            "expire_year" => "2099",
            "cvv2" => "123",*/
            "purpose" => "www.twitch.tv/dreadztv",
            "redirect_url" => "https://garan24.ru/service/public/magnitolkin/payneteasyresponse",
            //"server_callback_url" => "http://doc.payneteasy.com/doc/dummy.htm",
            "merchant_data" => "VIP customer",
            "control" => "768eb8162fc361a3e14150ec46e9a6dd8fbfa483"
        ];
        $request = new \Garan24\Gateway\Ariuspay\SaleRequest($data);
        $connector = new \Garan24\Gateway\Ariuspay\Connector();
        $connector->setRequest($request);
        $connector::setLogger("default");
        try{
            //echo $obj->getRequest()->__toString();//call();
            $connector->call();
            return redirect()->away($connector->getResponse()->getRedirectUrl());
        }
        catch(\Garan24\Gateway\Aruispay\Exception $e){
            Log::error("Exception in AruisPay gateway:".$e->getMessage());
        }
        catch(\Garan24\Gateway\Exception $e){
            Log::error("Exception in gateway:".$e->getMessage());
        }
        catch(Exception $e){
            Log::error("Exception :".$e->getMessage());
        }

    }
    public function postPayneteasyresponse(Request $rq){
        return redirect('magnitolkin/thanks',["route"=>$this->getBPRoute("email")]);
    }
    public function getPayneteasyresponse(Request $rq){
        return $this->postPayneteasyresponse($rq);
    }
    protected $bpmodels=[
        "index" => ["text"=>"Продолжить","href"=>"../magnitolkin/"],
        "email" => ["text"=>"Продолжить","href"=>"../magnitolkin/checkout"],
        "personal" => ["text"=>"Продолжить","href"=>"../magnitolkin/personal"],
        "delivery" => ["text"=>"Продолжить","href"=>"../magnitolkin/delivery"],
        "paymethod" => ["text"=>"Продолжить","href"=>"../magnitolkin/paymethod"],
        "checkcard" => ["text"=>"Продолжить","href"=>"../magnitolkin/checkcard"],
        "deliverypaymethod" => ["text"=>"Продолжить","href"=>"../magnitolkin/deliverypaymethod"],
        "thanks" => ["text"=>"Продолжить","href"=>"../magnitolkin/thanks"],
        "passport" => ["text"=>"Продолжить","href"=>"../magnitolkin/passport"],
    ];
    protected $bpmatrix=[
        "index" => ["condition"=>false,"next"=>"email","back"=>"index"],
        "email" => ["condition"=>false,"next"=>"personal","back"=>"index"],
        //"personal" => ["condition"=>false,"next"=>"delivery","back"=>"email"],
        "personal" => ["condition"=>false,"next"=>"deliverypaymethod","back"=>"email"],
        "delivery" => ["condition"=>false,"next"=>"paymethod","back"=>"personal"],
        "deliverypaymethod" => ["condition"=>["credit"=>"passport"],"next"=>"checkcard","back"=>"personal"],
        "paymethod" => ["condition"=>["credit"=>"passport"],"next"=>"checkcard","back"=>"delivery"],
        "checkcard" => ["condition"=>false,"next"=>"thanks","back"=>"deliverypaymethod"],
        "thanks" => ["condition"=>false,"next"=>"index","back"=>false],
        "passport" => ["condition"=>false,"next"=>"checkcard","back"=>"deliverypaymethod"]
    ];
    protected function getBPRoute($current,$condition=false){
        $dir="../magnitolkin/";
        $c = (!isset($this->bpmatrix[$current]))
            ? $this->bpmatrix["index"]
            : $this->bpmatrix[$current];
        return [
            "next" => ($c["condition"]!==false)
                    ? (isset($c["condition"][$condition])?$this->bpmodels[$c["condition"][$condition]]:$this->bpmodels[$c["next"]])
                    : $this->bpmodels[$c["next"]],
            "back" => (($c["back"]!==false)?$this->bpmodels[$c["back"]]:false)
        ];
    }
}
?>

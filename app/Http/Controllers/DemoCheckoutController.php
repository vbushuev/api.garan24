<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use \Garan24\Garan24 as Garan24;
use \Garan24\Gateway\Ariuspay\Sale as AriusSale;
use \Garan24\Gateway\Ariuspay\Exception as AriuspayException;

class DemoCheckoutController extends Controller{
    public function getIndex(Request $rq){
        return $this->getCheckout($rq);
        return view('democheckout.index');
    }
    public function getCheckout(Request $rq){
        return view('democheckout.checkout',["route"=>$this->getBPRoute("email")]);
    }
    public function postPersonal(Request $rq){
        $data = $this->getParams($rq);
        if(!isset($data["email"])||!isset($data["phone"])){
            return redirect('/democheckout/checkout');
        }
        $person = $this->getCustomer($data);
        if(isset($person->ID)){
            Log::debug("Person is : ". json_encode($person));
            $person = json_decode(json_encode($person),true);
            $rq->session()->put('customer',$person);
            Log::debug($this->getBPRoute("personal")["next"]);
            return redirect('/democheckout/'.$this->bpmatrix["personal"]["next"]);
        }else{
            $cust = app('App\Http\Controllers\GaranCustomerController')->create($rq);
            Log::debug($cust);
        }
        Log::debug("Person is new: ". json_encode($person));
        return view('democheckout.personal',["route"=>$this->getBPRoute("personal")]);
    }
    public function getPersonal(Request $rq){
        return $this->postPersonal($rq);
    }
    public function postDeliverypaymethod(Request $rq){
        $data = $this->getParams($rq);
        return view('democheckout.deliverypaymethod',["route"=>$this->getBPRoute("paymethod")]);
    }
    public function getDeliverypaymethod(Request $rq){
        return $this->postDeliverypaymethod($rq);
    }
    public function getThanks(Request $rq){
        return view('democheckout.thankspage',["route"=>$this->getBPRoute("thanks")]);
    }
    public function getPassport(Request $rq){
        return view('democheckout.passport',["route"=>$this->getBPRoute("passport")]);
    }
    public function getCard(Request $rq){
        return view('democheckout.card',["route"=>$this->getBPRoute("card")]);
    }
    public function getDelivery(Request $rq){
        return view('democheckout.delivery',["route"=>$this->getBPRoute("delivery")]);
    }
    public function getPaymethod(Request $rq){
        return view('democheckout.paymethod',["route"=>$this->getBPRoute("paymethod")]);
    }
    public function getCheckcard(Request $rq){
        return view('democheckout.payment-form',["route"=>$this->getBPRoute("checkcard")]);
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
            "redirect_url" => "https://service.garan24.ru/democheckout/payneteasyresponse",
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
        return redirect('/democheckout/thanks',["route"=>$this->getBPRoute("email")]);
    }
    public function getPayneteasyresponse(Request $rq){
        return $this->postPayneteasyresponse($rq);
    }
    protected $bpmodels=[
        "index" => ["text"=>"Продолжить","href"=>"/democheckout/"],
        "email" => ["text"=>"Продолжить","href"=>"/democheckout/checkout"],
        "personal" => ["text"=>"Продолжить","href"=>"/democheckout/personal"],
        "delivery" => ["text"=>"Продолжить","href"=>"/democheckout/delivery"],
        "paymethod" => ["text"=>"Продолжить","href"=>"/democheckout/paymethod"],
        "checkcard" => ["text"=>"Продолжить","href"=>"/democheckout/checkcard"],
        "deliverypaymethod" => ["text"=>"Продолжить","href"=>"/democheckout/deliverypaymethod"],
        "thanks" => ["text"=>"Продолжить","href"=>"/democheckout/thanks"],
        "passport" => ["text"=>"Продолжить","href"=>"/democheckout/passport"],
        "card" => ["text"=>"Подтвердить","href"=>"/democheckout/card"],
    ];
    protected $bpmatrix=[
        "index" => ["condition"=>false,"next"=>"email","back"=>"index"],
        "email" => ["condition"=>false,"next"=>"personal","back"=>"index"],
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
        $dir="/democheckout/";
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
    protected function getParams(Request $rq){
        Log::debug($rq->get("data"));
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
        Log::debug($log);
        return $data;
    }
    protected function getCustomer($data){
        $person = DB::table('users')
            ->join('usermeta',function($join){
                $join->on('users.id', '=','usermeta.user_id')->where('usermeta.meta_key','=','billing_phone');
            })
            ->where('users.user_email', $data["email"])
            ->where('usermeta.meta_value','=',$data["phone"])
            ->first();
        return $person;
    }
}
?>

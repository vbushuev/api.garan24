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
        return view('magnitolkin.cart.email');
    }
    public function getPersonal(Request $rq){
        return view('magnitolkin.cart.personal');
    }
    public function getDelivery(Request $rq){
        return view('magnitolkin.cart.delivery');
    }
    public function getPaymethod(Request $rq){
        return view('magnitolkin.cart.paymethod');
    }
    public function getDeliverypaymethod(Request $rq){
        return view('magnitolkin.cart.deliverypaymethod');
    }
    public function getThanks(Request $rq){
        return view('magnitolkin.cart.thankspage');
    }
    public function getCheckcard(Request $rq){
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
        return redirect('magnitolkin/thanks');
    }
    public function getPayneteasyresponse(Request $rq){
        return $this->postPayneteasyresponse($rq);
    }
}
?>

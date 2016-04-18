<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use WC_API_Client;
use WC_API_Client_Exception;
use WC_API_Client_Resource_Orders;
//use Garan24;
//use Garan24\HTTP;

class WebController extends Controller{
    public function getIndex(Request $rq){
        return view('public.index');
    }
    public function getCheckout(Request $rq){
        $order = $rq->input('order',[
            ['name' => 'jacket','price' => '79 Euros','quantity' => '1'],
            ['name' => 'window','price' => '229 Euros','quantity' => '3']
        ]);
        $vd = [
            'order' => $order
        ];
        return view('public.checkout',$vd);
    }
    public function getTestwoo(Request $rq){
        /*******************************************************************
         * Woo Commerce keys
         * Key:     ck_a060e095bdafdc57d95fb4df2d19aa9a2d671a91
         * Secret:  cs_4bbfa365ae1850f93f1144ebe666302315831ff0
         ******************************************************************/
        $domain = "http://demoshop.garan24.ru";
        $consumer_key = "ck_a060e095bdafdc57d95fb4df2d19aa9a2d671a91";
        $consumer_secret = "cs_4bbfa365ae1850f93f1144ebe666302315831ff0";
        $options = [
            'debug'           => true,
        	'return_as_array' => false,
        	'validate_url'    => false,
        	'timeout'         => 30,
            'ssl_verify'      => false
        ];
        try {
            $client = new WC_API_Client( $domain, $consumer_key,$consumer_secret, $options );
            $order = new WC_API_Client_Resource_Orders($client);
            $obj = $order->create([
                'payment_details' => [
                    "method_id"=> "klarna_checkout",
                      "method_title"=> "Dklarna_checkout",
                      "paid"=> false
                ]
            ]);
            print_r($obj);
        } catch ( WC_API_Client_Exception $e ) {

            echo $e->getMessage() . PHP_EOL;
            echo $e->getCode() . PHP_EOL;

            if ( $e instanceof WC_API_Client_HTTP_Exception ) {

                print_r( $e->get_request() );
                print_r( $e->get_response() );
            }
        }
    }
}
?>

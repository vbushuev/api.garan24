<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
}
?>

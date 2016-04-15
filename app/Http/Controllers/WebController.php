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
}
?>

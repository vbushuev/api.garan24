<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GCatController extends Controller{
    public function __construct(){
        $this->middleware('cors');
    }
    public function getIndex(Request $rq){
        return view('gcat.index');
    }
    public function getProducts(Request $rq){
        $products = DB::connection('gpars')->select("select * from (select @rownum := @rownum + 1 AS rank,p.* from xr_g_product p,(SELECT @rownum := 0) r where p.images is not null and p.original_price>0 and p.status in ('loaded','translated') ) s where s.rank >".$rq->input("page","0")*$rq->input("rows","32")." limit ".$rq->input("rows","32"));
        //return response()->json($products,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        return response()->json($products,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE);
    }

}
?>

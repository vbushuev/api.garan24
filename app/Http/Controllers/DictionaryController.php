<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DictionaryController extends Controller{
    public function __construct(){
        $this->middleware('cors');
    }
    public function getIndex(Request $rq){
        return view('dictionary.index');
    }
    public function getDictionary(Request $rq){
        return $this->postDictionary($rq);
    }
    public function postDictionary(Request $rq){
        $lang = $rq->input("lang",'en');
        $row = $rq->input("row",0);
        $sel = DB::connection('gpars')->select("select * from xr_g_dictionary where lang = '".$lang."' and id>=".$row." order by status desc,id");
        return response()->json($sel,200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getUpdate(Request $rq){
        return $this->postUpdate($rq);
    }
    public function postUpdate(Request $rq){
        $all = $rq->all();
        $data = [
            "id" => $rq->input("id",-1),
            "status" => $rq->input("status",'edited'),
        ];
        $upd = '';
        foreach ($all as $key => $value) {
            if(!in_array($key,["id","status"])){
                $upd .="{$key}=:{$key},";
                if($key=='translate')$value = strtolower($value);
                $data[$key]=$value;
            }
        }
        $affected = DB::connection('gpars')->update("update xr_g_dictionary set ".$upd."updated = CURRENT_TIMESTAMP, status =:status where id = :id",$data);
        return response()->json(["response"=>$affected],200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
}
?>

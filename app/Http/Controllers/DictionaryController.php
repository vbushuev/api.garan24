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
        $search = '%'.$rq->input("search",'').'%';
        $row = $rq->input("row",0);
        $sel = DB::connection('gpars')->select("select * from xr_g_dictionary where lang = '".$lang."' and id>=".$row." and (original like '".$search."' or translate like '".$search."') order by id desc");
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
        $this->updatePriority();
        return response()->json(["response"=>$affected],200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getDelete(Request $rq){
        return $this->postDelete($rq);
    }
    public function postDelete(Request $rq){
        $affected = DB::connection('gpars')->delete("delete from xr_g_dictionary where id = ".$rq->input("id",-1));
        return response()->json(["response"=>$affected],200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    public function getAdd(Request $rq){
        return $this->postDelete($rq);
    }
    public function postAdd(Request $rq){
        $data = [
            "lang"=>$rq->input("lang",'fr'),
            "original"=>mb_strtolower($rq->input("original",'_notext_')),
            "translate"=>mb_strtolower($rq->input("translate",'_notext_')),
            "priority"=>$rq->input("priority",'0')
        ];
        Log::debug("Add to dictionary ".json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
        $affected = DB::connection('gpars')->insert("insert into xr_g_dictionary (lang,original,translate,priority) values(:lang,:original,:translate,:priority)",$data);
        $this->updatePriority();
        return response()->json(["response"=>$affected],200,['Content-Type' => 'application/json; charset=utf-8'],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }
    protected function updatePriority(){
        DB::connection('gpars')->update("update xr_g_dictionary set priority = length(original) where 1");
    }
}
?>

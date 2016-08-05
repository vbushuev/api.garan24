<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CopierController extends Controller{
    protected $donor="http://bruder.ru";

    public function getIndex(Request $rq){
        Log::debug(__CLASS__."::".__METHOD__." line(".__LINE__.")");
        $data = $rq->input("data","");
        $cont = $this->getContent(["url"=>$this->donor.$data]);
        //Log::debug("RAW CONTENT[".$cont."]");
        $cont = $this->replace($cont);
        //Log::debug($cont);
        return response($cont)->header('Access-Control-Allow-Origin', '*');
    }
    protected function getContent($args){
        Log::debug(__CLASS__."::".__METHOD__." line(".__LINE__.")");
        $url = is_string($args)?$args:(is_array($args)&&isset($args["url"])?$args["url"]:$this->donor);
        $data = isset($args["data"])?$args["data"]:null;
        $curlOptions = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true
        ];
        $urlparams = "";
        if(!is_null($data)&&is_array($data)){
            foreach($data as $k=>$v)$urlparams.=(strlen($urlparams)?"&":"").$k."=".$v;
        }
        $raw_url = $url.((strlen($urlparams))?(preg_match("/\\\?/im",$url)?'&':'?'):"").$urlparams;
        Log::debug("RAW URL[".$raw_url."]");
        $curl = curl_init($raw_url);
        curl_setopt_array($curl, $curlOptions);
        $response = curl_exec($curl);
        return $response;

        //return file_get_contents("http://".$url);
        //
    }
    protected function replace($args){
        Log::debug(__CLASS__."::".__METHOD__." line(".__LINE__.")");
        $in =  is_string($args)?$args:(is_array($args)&&isset($args["content"])?$args["content"]:false);
        if($in===false) return false;
        $out = $in;
        $donor = preg_replace("/[\/]/im","\\\/",preg_quote($this->donor));
        $patterns = ["/\<a(.*?)href=['\"](.+?)['\"]/im"];
        $replacements = function($m) use ($donor){
            $print_r = "";
            foreach ($m as $key => $value) {
                $print_r .="{$key}=>{$value}, ";
            }
            $href = $m[2];
            $href_n = preg_replace("/".$donor."(.*?)/im","//service.garan24.bs2/copier?data=$1",$href);
            Log::debug("Found(".$donor.") [".$href."] => [".$href_n."]");
            return "<a".(isset($m[1])?$m[1]:"")."href=\"".$href_n."\"";
        };
        $out = preg_replace_callback($patterns,$replacements,$in);
        return $out;
    }
}
?>

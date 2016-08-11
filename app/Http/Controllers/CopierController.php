<?php

namespace App\Http\Controllers;

use Log;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
include("Snoopy.class.php");
include("simple_html_dom.php");

class CopierController extends Controller{
    //protected $donor="https://bruder.de";
    //protected $donor="http://bruder.ru";
    protected $donor="http://baby-walz.de";
    //protected $donor="https://wish.com";
    protected $localhost = "//service.garan24.bs2/store";
    protected $use_cache = false;
    public function getIndex(Request $rq){
        Log::debug(__CLASS__."::".__METHOD__." line(".__LINE__.")");
        $data = $rq->input("data","");
        $cache_file_name = "../storage/framework/cache/".preg_replace("/[\.\,\-\/\:\;]/im","",$this->donor.$data).date('Ymd');
        if($this->use_cache&&!preg_match("/\?/im",$data)){
            Log::debug("Look for cache: ".$cache_file_name);
            if(file_exists($cache_file_name)){
                return response(file_get_contents($cache_file_name))->header('Access-Control-Allow-Origin', '*');
            }
        }
        Log::debug("query: ".$data);
        $cont = $this->getContent(["url"=>$this->donor.$data]);
        //$this->getScripts($cont);
        //Log::debug("RAW CONTENT[".$cont."]");
        $cont = $this->replace($cont);
        $cont = $this->translate($cont);
        $cont = preg_replace("/\<\/body\>/i",view('toper')."</body>",$cont);
        if(!preg_match("/\?/im",$data))file_put_contents($cache_file_name,$cont);
        return response($cont)->header('Access-Control-Allow-Origin', '*');
    }
    protected function getContent($args){
        Log::debug(__CLASS__."::".__METHOD__." line(".__LINE__.")");
        $url = is_string($args)?$args:(is_array($args)&&isset($args["url"])?$args["url"]:$this->donor);
        $urlparams = "";
        if(isset($args["data"])&&is_array($args["data"])){
            foreach($args["data"] as $k=>$v)$urlparams.=(strlen($urlparams)?"&":"").$k."=".$v;
        }
        $raw_url = $url.((strlen($urlparams))?(preg_match("/\\\?/im",$url)?'&':'?'):"").$urlparams;
        Log::debug("RAW URL[".$raw_url."]");
        /*
        $curl = curl_init();
        $headers = [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*;q=0.8',
            'Accept-Language: de,en-us;q=0.7,en;q=0.3',
            'Accept-Charset: utf-8;q=0.7,*;q=0.7'
        ];
        $curlOptions = [
            CURLOPT_URL => $raw_url,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.17) Gecko/2009122116 Firefox/3.0.17",
            CURLOPT_HTTPHEADER=>$headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_REFERER => "google.com",
            CURLOPT_HEADER => 0,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => true,
            CURLOPT_ENCODING => "", // обрабатывает все кодировки
            CURLOPT_MAXREDIRS =>10, // останавливаться после 10-ого редиректа
            CURLOPT_COOKIEFILE => $GLOBALS['cookie_file'],
            CURLOPT_COOKIEJAR =>  $GLOBALS['cookie_file'],
            CURLOPT_AUTOREFERER => 1,
            CURLOPT_FOLLOWLOCATION => true
        ];
        curl_setopt_array($curl, $curlOptions);
        $response = curl_exec($curl);
        //curl_close($curl);
        */
        $snoopy = new \Snoopy;
        $snoopy->fetch($raw_url);
        $response = $snoopy->results;
        //$response = file_get_contents($raw_url);
        Log::debug($response);
        return $response;
    }
    protected function getScripts($args){
        Log::debug(__CLASS__."::".__METHOD__." line(".__LINE__.")");
        $in =  is_string($args)?$args:(is_array($args)&&isset($args["content"])?$args["content"]:false);
        if($in===false) return false;
        if(preg_match_all("/<(script|link).*(src|href)=['\"](.+?)['\"]/im",$in,$ms)){
            $donor_host =parse_url($this->donor);
            $donor_host =$donor_host["host"];
            foreach($ms[3] as $m){
                Log::debug($m);
                $href = parse_url($m);
                $src = "";
                if(!isset($href["host"])||$href["host"]==$donor_host){
                    $file = (isset($href["path"])?$href["path"]:"");
                    $src = (!isset($href["host"])?$this->donor:$href["host"]).$file;
                    Log::debug("File to get:".$src);
                    if(!file_exists("copier/".basename($file))){
                        $file_data=file_get_contents($src);
                        $file_data=preg_replace("/\surl\((['\"]{0,1})(.+?)['\"]{0,1}\)/im","url($1".$this->donor."$2$1)",$file_data);
                        file_put_contents("copier/".basename($file),$file_data);
                    }
                }
            }
        }
    }
    protected function translate($args){
        Log::debug(__CLASS__."::".__METHOD__." line(".__LINE__.")");
        $key="trnsl.1.1.20160808T114104Z.4fca987aa626b8c2.91ed21fc6a7d733075f78f8cca41fcecf4146acd";
        $host="https://translate.yandex.net/api/v1.5/tr.json/translate";
        $data = is_string($args)?$args:(isset($args["data"])?$args["data"]:null);
        if(is_null($data))return "";
        $curlOptions = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                "text" => $data,
                "format" => "html",
            ]),
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            //CURLOPT_FOLLOWLOCATION => true
        ];
        $url = $host."?lang=ru&key=".$key;
        $curl = curl_init($url);
        curl_setopt_array($curl, $curlOptions);
        $response = curl_exec($curl);
        Log::debug("Yandex translate response: ".$response);
        $response = json_decode($response);
        return ($response->code=="200")?$response->text[0]:$data;
    }
    protected function replace($args){
        Log::debug(__CLASS__."::".__METHOD__." line(".__LINE__.")");
        $in =  is_string($args)?$args:(is_array($args)&&isset($args["content"])?$args["content"]:false);
        if($in===false) return false;
        $donor_href = parse_url($this->donor);
        $local_href = parse_url($this->localhost);
        $out = preg_replace("/<\!DOCTYPE.*?>/i","",$in);
        //$out = preg_replace("/\/\/\s.+$/i","",$out);
        $j = str_get_html($out);
        if($j!==false){
            // removing
            foreach($this->adaptives[$this->donor]["remove"] as $selector){
                foreach($j->find($selector) as $d){
                    $d->outertext = "";
                }
            }
            // relinking
            foreach($j->find("a,img,link") as $a){
                $href = parse_url(isset($a->href)?$a->href:$a->src);
                if(!isset($href["host"]) || $href["host"]==$donor_href["host"]){
                    if($a->tag=="a"){
                        $a->href = $this->localhost."?data=".(isset($href["path"])?$href["path"]:"");
                    }
                    elseif ($a->tag=="img") {
                        $path = (isset($href["path"])?$href["path"]:"");
                        if(!preg_match("/^\//",$path))$path="/".$path;
                        $a->src = $this->donor.$path;
                    }
                    elseif ($a->tag == "link") {
                        $href = parse_url($a->href);
                        $file = (isset($href["path"])?$href["path"]:"");
                        $src = (!isset($href["host"])?$this->donor:"http://".$href["host"]).$file;
                        Log::debug("File to get:".$src);
                        if(!file_exists("copier/".basename($file))){
                            $file_data=file_get_contents($src);
                            $file_data=preg_replace("/\surl\((['\"]{0,1})(.+?)['\"]{0,1}\)/im","url($1".$this->donor."$2$1)",$file_data);
                            file_put_contents("copier/".basename($file),$file_data);
                        }
                        $a->href = "/copier/".basename($href["path"]);
                    }
                    //$a->href.=(isset($href["query"])?"?".$href["query"]:"").(isset($href["fragment"])?"#".$href["fragment"]:"");
                }
            }
            foreach($j->find("script") as $a){
                if(isset($a->src)){
                    $href = parse_url($a->src);
                    $file = (isset($href["path"])?$href["path"]:"");
                    $src = (!isset($href["host"])?$this->donor:"http://".$href["host"]).$file;
                    Log::debug("File to get:".$src);
                    if(!file_exists("copier/".basename($file))){
                        $file_data=file_get_contents($src);
                        $file_data=preg_replace("/\surl\((['\"]{0,1})(.+?)['\"]{0,1}\)/im","url($1".$this->donor."$2$1)",$file_data);
                        file_put_contents("copier/".basename($file),$file_data);
                    }
                    $a->src = "/copier/".basename($href["path"]);
                    //$a->src = $this->donor.(isset($href["path"])?$href["path"]:"");
                }
                else{
                    $a->innertext = preg_replace("/\/\/.+$/im","",$a->innertext);
                }
            }
            $out = $j->save();
            $j->clear();
            unset($j);
        }
        $out = preg_replace("/<\!\-\-[\S\s]*?\-\->/i","",$out);
        $out = preg_replace("/var url=\"/i","var url=\"".$this->localhost."\";",$out);
        //$out = preg_replace("/(\/\/)?(www\.)?".preg_quote($donor_href["host"])."(.*?)['\"]/i",$this->localhost."?data=$3",$out);
        return $out;
    }
    protected function replace_old($args){
        Log::debug(__CLASS__."::".__METHOD__." line(".__LINE__.")");
        $in =  is_string($args)?$args:(is_array($args)&&isset($args["content"])?$args["content"]:false);
        if($in===false) return false;
        $out = $in;
        $copier = $this;
        $patterns = [
            "/\<(a|img|script|link)(.*?)(href|src)=['\"](.+?)['\"]/im"
        ];
        $replacements = function($m) use ($copier){
            $href = $m[4];
            $href_n = $m[4];
            $url = parse_url($href);
            //print_r($url);
            $donor_host =parse_url($copier->donor);
            $donor_host =$donor_host["host"];
            $rule = "none";
            if(!isset($url["host"]) || $url["host"] == $donor_host){
                if (in_array($m[1],["a"])){
                    $href_n = $copier->localhost."?data=".(isset($url["path"])?$url["path"]:"")
                        .(isset($url["query"])?"?".$url["query"]:"")
                        .(isset($url["fragment"])?"#".$url["fragment"]:"")
                        ;
                    $rule = "relink_href";
                }
                else if (in_array($m[1],["img"])){
                    $href_n = $copier->donor.$url["path"]
                        .(isset($url["query"])?"?".$url["query"]:"")
                        .(isset($url["fragment"])?"#".$url["fragment"]:"")
                        ;
                    $rule = "relink_img";
                }
                else if (in_array($m[1],["script","link"])){
                        $href_n = "/copier/".basename($url["path"])
                            .(isset($url["query"])?"?".$url["query"]:"")
                            .(isset($url["fragment"])?"#".$url["fragment"]:"")
                            ;
                    $rule = "relink_scripts";
                }
            }
            $ret = "<".$m[1].(isset($m[2])?$m[2]:"").$m[3]."=\"".$href_n."\"";
            //Log::debug("Replaced (".$rule.") [".$href."] => [".$href_n."]");
            return $ret;
        };
        $out = preg_replace_callback($patterns,$replacements,$in);
        return $out;
    }
    /**/
    protected $adaptives =[
        "http://baby-walz.de"=>[
            "remove"=>[
                "#usp_bar",
                ".headBasket",
                ".meta",
                ".footerbox",
                "#stickyHeadFunctionsWrapper",
            ]
        ]
    ];
}
?>

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
use DB;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('address', function($a) {
            //print_r($a);
            //$str = with($a)['city'].'. '.$a['zip'].', '.$a['address1'];
            return "<?php echo join(', ',array_values(with({$a})))?>";
        });
        Blade::directive('enco', function($a) {
            return "<?php htmlspecialchars_decode({$a});?>";
        });
        Blade::directive('amount', function($a) {
            return "<?php echo number_format(with({$a}),2,'.',' ').' руб.';?>";
        });
        Blade::directive('amountrate', function($a) {
            Log::debug("amountrate ".$a);
            $s = DB::table('currency_rates')->take(4)->get();

            list($amt,$cur) = explode(',',str_replace(['(',')',' ', "'"], '', $a));
            $res = "<?php\n";
            $res .='$a = with('.$amt.');$c=with('.$cur.');'."\n";
            $res .='$cc = json_decode(\''.json_encode($s).'\',true);'."\n";
            $res .='foreach($cc as $cur){if($cur["iso_code"]==$c){$a=$a*1.05*$cur["value"];}}'."\n";
            $res .='echo number_format($a,2,"."," ")." руб.";'."\n";
            $res .="?>";
            return $res;
        });
        Blade::directive('amountrate_nocurrency', function($a) {
            Log::debug("amountrate ".$a);
            list($amt,$cur,$date) = explode(',',str_replace(['(',')',' ', "'"], '', $a));
            $s = DB::table('currency_rate_history')->where("iso_code", "=", strtoupper($cur))->where( "timestamp",">=","str_to_date($date,'%Y-%m-%d %H:%i:%s')")->orderBy("timestamp")->take(1)->get();
            if(!count($s)){
                $s = DB::table('currency_rates')->where("iso_code", "=", strtoupper($cur))->get();
                print_r($s);
                $s = $s["value"];
            }else $s = $s["old_value"];
            $amt = $amt*$s*(($cur=="RUB")?1:1.05);
            return "<?php echo number_format(with({$amt}),2,'.',' ').'';?>";
        });
        Blade::directive('telephone', function($a) {
            return "<?php echo preg_replace(\"/\+7(\d{3})(\d{3})(\d{2})(\d{2})/\",\"+7($1) $2 $3 $4\",with({$a}));?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

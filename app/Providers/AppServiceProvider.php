<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

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

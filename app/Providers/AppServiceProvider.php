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

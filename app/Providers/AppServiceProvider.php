<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
//use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('stateClasses',
            [   1 =>'novy',
                2 =>'ke-zpracovani',
                3 =>'zamitnuto',
                4 =>'reklamace',
                5 =>'zpracovava-se',
                6 =>'schvaleni-rozpoctu',
                7 =>'rozpocet-zamitnut',
                8 =>'rozpocet-schvalen',
                9 =>'kontrola-zakaznikem',
                10 =>'pripominka',
                11 =>'vyrizeno',
                12 =>'smazano'
            ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        //
    }
}

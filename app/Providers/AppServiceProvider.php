<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Mockery\Matcher\Any;
use Illuminate\Pagination\Paginator;
use Coduo\PHPHumanizer\NumberHumanizer;
use Opcodes\LogViewer\Facades\LogViewer;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // //
        // Blade::directive('datetime', function (string $expression) {
        //     return ($expression)->format('m/d/Y H:i');
        // });
        #TODO - urlRoot
        /**
         * example '{host}/users/123'
         * get flag "users" by url requst
        */
        Blade::directive('segmentURL',function($expression=1){
            $seg = request()->segment((int)$expression);
            return "'".$seg."'";
            if($expression){
            }
            //return "'home'";
        });
        Paginator::useBootstrapFive();
        // Blade::component('alert', Alert::class);
        // Paginator::useBootstrapFour();
        LogViewer::auth(function ($request) {
            return auth()->user()->hasRole('Admin');
            // return true to allow viewing the Log Viewer.
        });
    }
}

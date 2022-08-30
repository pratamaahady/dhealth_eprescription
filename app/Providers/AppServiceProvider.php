<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Response as ResponseFactory;
use App\Http\Helpers\Response;
use App\Http\Helpers\ResponseHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ResponseFactory::macro('success', function ($message=null, $data=null, $extend=null) {
            return ResponseHelper::success($message, $data, $extend);
        });

        ResponseFactory::macro('error', function($message=null, $errors=[]){
            return ResponseHelper::error($message, $errors);
        });
    }
}

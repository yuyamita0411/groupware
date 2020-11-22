<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;

use Illuminate\Support\LoginpageValidator;

use Validator;

use App\Http\Validators\MypageValidator;

class LoginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public __construct($str){
        $this->str = $str;
    }

    public function boot()
    {
        Validator::extend('login', function($attribute, $value, $parameters, $validator){
            return $this->str === $value;
        });
    }
}

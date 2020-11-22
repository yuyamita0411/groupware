<?php

namespace App\Http\Validators;

use Illuminate\Validation\Validator;

class MypageValidator extends Validator{
    public function validateMypage($attribute, $value, $parameters){
        return $value % 2 == 0;
    }
}
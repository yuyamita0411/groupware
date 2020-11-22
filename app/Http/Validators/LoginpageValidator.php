<?php

namespace App\Http\Validators;

use Illuminate\Validation\Validator;

class MypageValidator extends Validator{
	public __construct($str){
		$this->str = $str;
	}

    public function validateMypage($attribute, $value, $parameters){
        return $this->str === $value;
    }
}
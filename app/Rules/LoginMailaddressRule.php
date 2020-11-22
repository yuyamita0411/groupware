<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\DB;

class LoginMailaddressRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($namestr, $passwdstr)
    {
        $this->namestr = $namestr;
        $this->passwdstr = $passwdstr;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !empty(DB::table('userinfo')->where('name', $this->namestr)->where('password', $this->passwdstr)->first());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'パスワードが違います。';
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

use App\Rules\LoginMailaddressRule;

use App\Rules\LoginNameRule;

class LoginpageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->path() == 'login'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'username' => ['required', new LoginNameRule($request->username, $request->password)],
            'password' => ['required', new LoginMailaddressRule($request->username, $request->password)]
        ];
    }

    public function messages(){
        return [
            'username.required' => 'ユーザー名が入力されていません。',
            'password.required' => 'パスワードが入力されていません。'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MypageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->path() == 'mypage'){
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
    public function rules()
    {
        return [
            'onamae' => 'required',
            'password' => 'required',
            'age' => 'numeric|between:0,150'
        ];
    }

    public function message(){
        return [
            'onamae.required' => '名前は必ず入力してください。',
            'password.required' => 'パスワードは必ず入力してください。',
            'age.between' => '数字は0~150の間でお願いします。'
        ];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RegisterpageRequest;

use Validator;

use Illuminate\Support\Facades\DB;

/*use App\Rules\Mypagerule;*/

class RegisterpageController extends Controller
{
    public function __construct(){
        $this->databaseinfo = DB::select('select * from userinfo');
        $this->getids = [];
        foreach ($this->databaseinfo as $dbinfokey => $dbinfovalue) {
            $this->getids[] = $dbinfovalue->id;
        }
        if(!empty($this->getids)){
            $this->maxID = max($this->getids);
        }else{
            $this->maxID = 1;
        }

		$this->rule = [
            'username' => ['required', 'unique:userinfo,name'],
            'password' => 'required',
            'mailaddress' => ['required', 'unique:userinfo,mailaddress'],
            'age' => 'numeric'
    	];
    	$this->messages = [
            'username.required' => '名前は必ず入力してください。',
            'password.required' => 'パスワードは必ず入力してください。',
            'mailaddress.required' => 'メールアドレスは必ず入力してください。',
            'age.between' => '数字は0~150の間でお願いします。'
    	];
    	$this->successmsg = '登録が完了しました。';
    	$this->failedmsg = '登録に失敗しました。';
    }

	public function returnmsg($validator){

        if($validator->fails()){
        	$msg = $this->failedmsg;
        }else{
        	$msg = $this->successmsg;    
        }

    	$returnmsg = ['returnmsg' => $msg];
    	return $returnmsg;
	}

    public function index(Request $request){
    	$validator = Validator::make($request->query(), $this->rule);

        if($request->hasCookie('username')){
            $usercookie = 'usercookie:'.$request->cookie('username');
        }else{
            $usercookie = 'cookieはありません。';
        }
        if($request->hasCookie('password')){
            $passwordcookie = 'passwordcookie:'.$request->cookie('password');
        }else{
            $passwordcookie = 'cookieはありません。';
        }

        $indexsendval = array_merge(self::returnmsg($validator), ['usercookie' => $usercookie, 'passwordcookie' => $passwordcookie]); 

    	return view('register.index', $indexsendval);
    }

    public function formmethod(RegisterpageRequest $request){

    	$insertdata = [
    		'id' => $this->maxID + 1,
            'name' => $request->username,
            'password' => $request->password,
            'age' => $request->age,
            'mailaddress' => $request->mailaddress,
            'date' => date("Y-m-d H:i:s")
    	];

		$validator = Validator::make($request->all(), $this->rule, $this->messages);

    	if($validator->fails()){
    		return redirect('/register')
    		->withErrors($validator)
    		->withInput();
    	}else{
            DB::insert('insert into userinfo (id, name, password, age, mailaddress, registerdate) values (:id, :name, :password, :age, :mailaddress, :date)', $insertdata);
            setcookie('username', $_POST['username'], time()+60*60*24*14);
            return redirect('/mypage');
    	}
        return view('register.index', self::returnmsg($validator));

    }
}

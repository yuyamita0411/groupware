<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\Mypagemiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function(){
	return view('welcome');
});

Route::get('testurl', function(){
	return view('testurl');
});

Route::get('test', 'TestController@index');
Route::post('test', 'TestController@formmethod');

Route::get('mypage/rest', 'MypageController@rest');

Route::get('Userschedules', 'UserschedulesController@index');

Route::get('mypage', 'MypageController@index');
Route::post('mypage', 'MypageController@formmethod')->middleware('mypage');

Route::get('test','AjaxController@index');
Route::get('test/ajax','AjaxController@ajax');

Route::get('register', 'RegisterpageController@index');
Route::post('register', 'RegisterpageController@formmethod');

Route::get('login', 'LoginpageController@index');
Route::post('login', 'LoginpageController@formmethod');

Route::get('mypage', 'MypageController@index');
Route::post('mypage', 'MypageController@formmethod');

Route::get('myschedule', 'MyscheduleController@index');
Route::post('myschedule', 'MyscheduleController@formmethod');

Route::resource('rest', 'RestappController');
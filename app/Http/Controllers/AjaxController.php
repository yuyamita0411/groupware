<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
	public function index(Request $request){
		$depart = $request->value;
		$employees = 'test';
		$data = [
			'employees' => [$employees]
		];
		return view('test', $data);
	}
	public function ajax(Request $request){
		header('Content-type:application/json;charset=utf-8');
		$depart = $request->value;
       $employees = Employee::where('depart',$depart)->pluck('name');
       return $employees;
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class dashboardController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function  estatusGeneral(){
		return  View('admin/dashboard');
	}
}

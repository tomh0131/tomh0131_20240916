<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function test(){
        return 'Hi!';
    }
    public function index(){
        $view = view('test');
        return $view;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;

class MailController extends Controller
{
    public function send(){
        $contents = [];
        $data = [];
        $email ='aaa@aaa';
        Mail::send($contents,$data,function($message){
            $message->to($email,'Subject')
            ->subject('');
        }); 

    }
}

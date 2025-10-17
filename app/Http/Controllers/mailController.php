<?php

namespace App\Http\Controllers;

use App\Mail\wellcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
    function sendEmail(){
        $to="priyanshupandey5599@gmail.com";
        $msg="wellcome";
        $subject="info regarding email and password";
        Mail::to($to)->send(new wellcomeMail($msg, $subject));
    }
}

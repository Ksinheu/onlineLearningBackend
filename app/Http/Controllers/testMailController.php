<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

class testMailController extends Controller
{
    public function index()
    {
        $otp = rand(100000, 999999);
        Mail::to('korsinheu@gmail.com')->send(new TwoFactorCodeMail($otp));
        return 'Email sent!';
    }
}

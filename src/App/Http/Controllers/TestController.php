<?php

namespace App\Http\Controllers;

use App\Mail\TestMarkupOrderShippedMail;
use App\Mail\TestMarkupResetPasswordMail;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        return view('test');
    }

    public function testEmailOrderMarkup()
    {
        return new TestMarkupOrderShippedMail();
    }

    public function testResetPasswordMarkup()
    {
        return new TestMarkupResetPasswordMail();
    }
}

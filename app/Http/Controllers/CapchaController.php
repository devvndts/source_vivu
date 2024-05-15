<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CapchaController extends Controller
{
    public function Reset(Request $request){
        return response()->json(['captcha'=> captcha_img('inverse')]);
    }
}

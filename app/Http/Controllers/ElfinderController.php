<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElfinderController extends Controller
{
    public function Index(Request $request){      
        //phpinfo();  
    	return view('elfinder');
    }
}
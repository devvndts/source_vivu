<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function Show(Request $request){
        $category = $request->category;

        if($category=='404'){
            return view('desktop.templates.error.404');
        }else if($category=='403'){
            return view('desktop.templates.error.403');
        }else if($category=='lock'){
            return view('desktop.templates.error.403');
        }
    }
}

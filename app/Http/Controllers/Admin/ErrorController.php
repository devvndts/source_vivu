<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Helper;

class Errorcontroller extends Controller
{
    //
    private $config, $model, $viewShow, $viewEdit, $type;
    private $routeShow = 'admin.error.show';

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
    	$this->category = $request->category;
    	$this->type = $request->type;

        switch($this->category){
        	case '404':
                $this->viewShow = 'admin.templates.error.404';
        	break;
        	case '403':
                $this->viewShow = 'admin.templates.error.403';
        	break;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Hiển thị trang giao diện lỗi
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        $other_title = "Thông báo lỗi";
        return view($this->viewShow)->with('other_title',$other_title);
    }
}

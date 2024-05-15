<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use App\Models\Lang;

use App\Exports\LangExport;
use App\Imports\LangImport;
use Maatwebsite\Excel\Facades\Excel;

use Helper;

class LangController extends Controller
{
    //
    use SupportTrait;

    private $config, $model, $viewShow, $viewAdd, $viewEdit, $type, $page_error, $all_lang;
    private $routeShow = 'admin.lang.show';
    private $viewImport = 'admin.imports.lang.import';
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    public function initialization(Request $request){
    	$this->category = $request->category;
        $this->type = $request->type;
        $this->model = new Lang();
        $this->all_lang = config('config_all.lang');
        $this->page_error = redirect()->back();

        $this->viewEdit = 'admin.templates.lang.lang_add';
        $this->viewShow = 'admin.templates.lang.lang';

    }

    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu tương ứng với category
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
        $this->initialization($request);

        if(config('config_all.debug_developer')==false){
            $request->session()->flash('alert', $this->alert);
            return view('admin.templates.error.403');
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $params = array();
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';

        //### Code xử lý...
        $itemShow = $this->model->GetAllItems($params,true);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'type'=> $type,
        );
        return view($this->viewShow)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị trang thêm - chỉnh sửa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Edit(Request $request){
        $this->initialization($request);

        if(config('config_all.debug_developer')==false){
            $request->session()->flash('alert', $this->alert);
            return view('admin.templates.error.403');
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $id = $request->id;

        //### Code xử lý...
        $rowItem = $this->model->GetOneItem($id);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> $type,
        );
        return view($this->viewEdit)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Delete(Request $request){
        $this->initialization($request);

		//### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;

        $this->model->DeleteOneItem($id);

        return redirect()->route($this->routeShow);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function DeleteAll(Request $request){
        $this->initialization($request);

		//### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;
        $listid = $request->listid;

        if($listid!=''){
            $this->model->DeleteMultiItem($listid);
        }

        return redirect()->route($this->routeShow);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;
        $savehere = ($request->has('savehere'))?true:false;

        $data = $request->data;

        //### Kiểm tra dữ liệu
        if(!$id){
            $rowCheck = $this->model->GetOneItemByParams(['giatri'=>$data['giatri']]);
            if($rowCheck){
                $request->session()->flash('alert', 'Từ khóa này đã tồn tại');
                return redirect()->back();
            }
        }

        //### Code xử lý...
        $row = $this->model->SaveProduct($data,$id);

        //### Hiển thị giao diện
        if($savehere){
            return redirect()->route($this->routeEdit,[$row->id]);
        }else{
            return redirect()->route($this->routeShow);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Xuất excel danh sách ngôn ngữ
    |--------------------------------------------------------------------------
    */
    public function Export(Request $request)
    {
        $this->initialization($request);

        return Excel::download(new LangExport(), 'danhsach_ngonngu_'.time().'.xlsx');
    }

    /*
    |--------------------------------------------------------------------------
    | Import excel danh sách ngôn ngữ
    |--------------------------------------------------------------------------
    */
    public function Import(Request $request)
    {
        $this->initialization($request);

        if($request->hasFile('import_file')){
            $import = Excel::import(new LangImport(), request()->file('import_file'));
            $request->session()->flash('alertSuccess', 'Nhập dữ liệu thành công !');
            return $this->page_error;
        }else{
            $request->session()->flash('alert', 'Hệ thống báo lỗi: bạn chưa chọn file !');
            return $this->page_error;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Giao diện nhập excel sản phẩm
    |--------------------------------------------------------------------------
    */
    public function ImportView(Request $request){
        $this->initialization($request);
        
        $other_title = "Import ngôn ngữ";
        $response = array(
            'other_title'=>$other_title ,
            'category'=>$this->category,
            'type'=>$this->type
        );
        return view($this->viewImport)->with($response);
    }
}

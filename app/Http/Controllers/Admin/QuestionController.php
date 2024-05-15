<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use Illuminate\Support\Str;

use Helper, Thumb, TableManipulation;

class QuestionController extends Controller
{
    use SupportTrait;

    private $type, $table, $viewShow, $viewEdit, $config, $config_tags, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $permissionImport, $permissionExport, $page_error, $folder_upload;
    private $routeShow = 'admin.question.show';
    private $routeEdit = 'admin.question.edit';
    private $folder = "question";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        //### set request value
        $this->category = $request->category;
        $this->page_error = redirect()->back();

        //### set repo relation
        $this->relations = [];

        $this->viewShow = 'admin.templates.question.show';
        $this->viewEdit = 'admin.templates.question.add';

        $this->permissionShow = 'question_man';
        $this->permissionAdd = 'question_add';
        $this->permissionEdit = 'question_edit';
        $this->permissionDelete = 'question_delete';
    }


    public function Show(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }  

        //### Thiết lập giá trị thuộc tính        
        $params = array();


        //### Code xử lý: 
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';

        //### Code xử lý...
        $itemShow = $this->questionRepo->GetQuestions($params,$this->relations,$this->pagination);
        $query_str = Helper::SetQuery($request->query);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'query_str'=>$query_str,
            'type' => ''
        );

        return view($this->viewShow)->with($response);
    }


    public function Edit(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính 
        $id = $request->id;

        //### Code xử lý...
        $rowItem = $this->questionRepo->GetOneItem($id,$this->relations);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> ''
        );

        return view($this->viewEdit)->with($response);
    }


    public function Delete(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;

        $this->questionRepo->DeleteOneItem($id, $this->folder);

        return redirect()->route($this->routeShow,[$category,$type]);
    }


    public function DeleteAll(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;
        $listid = $request->listid;

        if($listid!=''){
            $this->questionRepo->DeleteMultiItem($listid, $this->folder);
        }

        return redirect()->route($this->routeShow,[$category,$type]);
    }


    public function Save(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;        
        $id = $request->id;        
        $savehere = ($request->has('savehere'))?true:false;        

        $data = $request->data;        

        //### check auth permission
        if($id){
            if(!$this->IsPermission($this->permissionEdit)){
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        }else{
            if(!$this->IsPermission($this->permissionAdd)){
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        }

        $data = $request->data;
        $data['duyettin'] = (isset($data['duyettin'])) ? 1 : 0;

        if($id){
            $data['ngayduyet'] = time();
        }else{
            $data['ngaytao'] =  time();
        }

        //### Code xử lý...
        $row = $this->questionRepo->SaveItem($data,$id);

        //### Hiển thị giao diện
        return redirect()->route($this->routeShow,[$category]);
    }
}

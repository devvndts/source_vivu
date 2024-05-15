<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;
use App\Repositories\Repo\PhotoRepository;

use Helper;

class PhotoController extends Controller
{
    //
    use SupportTrait;
    private $config, $viewShow, $viewAdd, $viewEdit, $type, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload, $folder_save;
    private $routeShow = 'admin.photo.show';
    private $folder = "photo";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";    

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
    	$this->category = $request->category;
    	$this->type = $request->type;
        $this->config = config('config_type.photo');
        $this->folder_save = Helper::GetFolder($this->folder);        
        $this->page_error = redirect()->back();
        $this->folder_upload = config('config_upload.UPLOAD_PHOTO');

        //### set repo
        /*$this->photoRepo = $photoRepo;
        $this->photoRepo->setModel($this->category);*/

        switch($this->category){
        	case 'photo_static':
                $this->viewShow = 'admin.templates.photo.static.photo_static';
                $this->permissionEdit = 'photo_photo_static_'.$this->type;
        	break;
        	case 'man_photo':
                $this->viewShow = 'admin.templates.photo.man.photo';
                $this->viewAdd = 'admin.templates.photo.man.photo_add';
                $this->viewEdit = 'admin.templates.photo.man.photo_edit';
                $this->permissionShow = 'photo_man_photo_'.$this->type;
                $this->permissionAdd = 'photo_add_photo_'.$this->type;
                $this->permissionEdit = 'photo_edit_photo_'.$this->type;
                $this->permissionDelete = 'photo_delete_photo_'.$this->type;
        	break;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu tương ứng với category
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
    	$type = $request->type;

        //### Code xử lý...
        if($request->category=='photo_static'){
            //### check auth permission
            if(!$this->IsPermission($this->permissionEdit)){
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }

            $params = array(
                'act'=>$request->category,
                'type'=>$request->type,
            );

            $rowItem = $this->photoRepo->GetItem($params);
            if(!$rowItem){
                $params['hienthi']=1;
                $rowItem = $this->photoRepo->SaveItem($params);
            }

            $options = json_decode($rowItem['options'],true);
            //dd($options['watermark']['position']);

            //### Trả về giao diện
            $response = array(
                'request'=>$request,
                'rowItem'=> $rowItem,
                'options'=>(isset($rowItem['options']))?(json_decode($rowItem['options'],true)):'',
                'type'=> $type,
                'config'=>$this->config,
                "options"=> $options
            );
        }else{
            //### check auth permission
            if(!$this->IsPermission($this->permissionShow)){
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }

            if($request->keyword){
                $params['keyword'] = $request->keyword;
            }else{
                $params=null;
            }


            $itemShow = $this->photoRepo->GetAllItems($type,$params,$this->relations, $this->pagination);

            //### Trả về giao diện
            $response = array(
                'request'=>$request,
                'itemShow'=> $itemShow,
                'type'=> $type,
                'config'=>$this->config,
            );
        }

        return view($this->viewShow)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị trang thêm  1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Add(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionAdd)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $id = $request->id;
        $numberPhoto = (isset($this->config[$type]['number']))? $this->config[$type]['number'] : 0;

        //### Code xử lý...
        $rowItem = $this->photoRepo->GetOneItem($id,$this->relations);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> $type,
            'config'=>$this->config,
            'numberPhoto'=>$numberPhoto,
        );

        return view($this->viewAdd)->with($response);
    }

    /*
    |--------------------------------------------------------------------------
    | Hiển thị trang chỉnh sửa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Edit(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $id = $request->id;

        //### Code xử lý...
        $rowItem = $this->photoRepo->GetOneItem($id,$this->relations);
        $sl_options = (isset($rowItem['sl_options']) && $rowItem['sl_options'] != '') ? json_decode($rowItem['sl_options'],true) : null;
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'sl_options'=> $sl_options,
            'type'=> $type,
            'config'=>$this->config,
            'folder_upload'=>$this->folder
        );

        return view($this->viewEdit)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = (isset($request->id)) ? $request->id : 0;

        $data = $request->data; // là data: khi chỉnh sửa 1 dòng dữ liệu
        $dataMultiTemp = $request->dataMulti; // là dataMulti: khi thêm 1 hay nhiều dòng dữ liệu


        //### Code xử lý...
        if($data)
        {
            foreach($data as $column => $value)
            {
                $data[$column] = $value;
            }
        }

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


        if($id)
        {
            $row = $this->photoRepo->GetOneItem($id, $this->relations);
            if($request->hasFile('file'))
            {                
                $oldimage = $row['photo'];
                $newimage = $request->file('file');
                if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
            }

            if($request->hasFile('background'))
            {                
                $oldimage = $row['background'];
                $newimage = $request->file('background');
                if($newimage){ $data['background'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
            }

            if(isset($this->config[$type]['another_image']) && $this->config[$type]['another_image'] == true)
            {
                if($request->hasFile('file_model'))
                {
                    $oldimage = $row['model'];
                    $newimage = $request->file('file_model');
                    if($newimage){ $data['model'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
                }
                if($request->hasFile('file_banner'))
                {
                    $oldimage = $row['banner'];
                    $newimage = $request->file('file_banner');
                    if($newimage){ $data['banner'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
                }
                if($request->hasFile('file_descript'))
                {
                    $oldimage = $row['descript'];
                    $newimage = $request->file('file_descript');
                    if($newimage){ $data['descript'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
                }
            }
            $data['ngaysua'] = time();
            $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;     
            $data['hienthi1'] = (isset($data['hienthi1'])) ? 1 : 0;     
            $data['hienthi2'] = (isset($data['hienthi2'])) ? 1 : 0;     
            $data['hienthi3'] = (isset($data['hienthi3'])) ? 1 : 0;     
            $data['hienthi4'] = (isset($data['hienthi4'])) ? 1 : 0;            
            $data['act'] = 'photo_multi';
            $data['type'] = $type;

            $sl_option = json_decode($row['sl_options'],true);
            if (isset($data["options"])) {
                $dataOptions = $data["options"];
                unset($data["options"]);
                foreach($dataOptions as $k2 => $v2) $sl_option[$k2] = $v2;
                $data['sl_options'] = json_encode($sl_option);
            }
            

            //### Cập nhật
            $row = $this->photoRepo->SaveItem($data,$id);
        }else{
            $numberPhoto = (isset($this->config[$type]['number']))? $this->config[$type]['number'] : 0;
            if($numberPhoto && $dataMultiTemp)
            {
                for($i=0;$i<count($dataMultiTemp);$i++)
                {                    
                    $dataMulti = $dataMultiTemp[$i];
                    $data['ngaytao'] = $data['ngaysua'] = time();
                    $dataMulti['hienthi'] = (isset($dataMultiTemp[$i]['hienthi'])) ? 1 : 0;
                    $dataMulti['hienthi1'] = (isset($dataMultiTemp[$i]['hienthi1'])) ? 1 : 0;
                    $dataMulti['hienthi2'] = (isset($dataMultiTemp[$i]['hienthi2'])) ? 1 : 0;
                    $dataMulti['hienthi3'] = (isset($dataMultiTemp[$i]['hienthi3'])) ? 1 : 0;
                    $dataMulti['hienthi4'] = (isset($dataMultiTemp[$i]['hienthi4'])) ? 1 : 0;
                    $dataMulti['type'] = $type;
                    $dataMulti['act'] = 'photo_multi';

                    // $row_sl_opt = $this->photoRepo->GetOneItem($id);
                    // $sl_option = json_decode($row_sl_opt['sl_options'],true);
                    if (@$dataMulti["options"]) {
                        $dataOptions = @$dataMulti["options"];
                        unset($dataMulti["options"]);
                        foreach($dataOptions as $k2 => $v2) $sl_option[$k2] = $v2;
                        $dataMulti['sl_options'] = json_encode($sl_option);
                    }
                    if(isset($this->config[$type]['images']) && $this->config[$type]['images'] == true)
                    {
                        if($request->hasFile('file'.$i))
                        {
                            $oldimage = "";
                            $newimage = $request->file('file'.$i);
                            if($newimage){ $dataMulti['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
                        }

                        if($request->hasFile('background'.$i))
                        {
                            $oldimage = "";
                            $newimage = $request->file('background'.$i);
                            if($newimage){ $dataMulti['background'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
                        }

                        if(isset($this->config[$type]['another_image']) && $this->config[$type]['another_image'] == true)
                        {
                            if($request->hasFile('file_model'.$i))
                            {
                                $oldimage = "";
                                $newimage = $request->file('file_model'.$i);
                                if($newimage){ $dataMulti['model'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
                            }
                            if($request->hasFile('file_banner'.$i))
                            {
                                $oldimage = "";
                                $newimage = $request->file('file_banner'.$i);
                                if($newimage){ $dataMulti['banner'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
                            }
                            if($request->hasFile('file_descript'.$i))
                            {
                                $oldimage = "";
                                $newimage = $request->file('file_descript'.$i);
                                if($newimage){ $dataMulti['descript'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
                            }
                        }
                        //thêm mới
                        $this->photoRepo->SaveItem($dataMulti);
                    }
                    else
                    {
                        if(
                            (isset($dataMulti['tenvi']) && $dataMulti['tenvi'] != '') ||
                            (isset($dataMulti['link']) && $dataMulti['link'] != '') ||
                            (isset($dataMulti['link_video']) && $dataMulti['link_video'] != '')
                        )
                        {                            
                            //thêm mới
                            $this->photoRepo->SaveItem($dataMulti);
                        }
                    }
                }
            }
        }

        //### Hiển thị giao diện
        return redirect()->route($this->routeShow,[$category,$type]);
    }


    /*
    |--------------------------------------------------------------------------
    | Cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function SaveStatic(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionEdit)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $category = $request->category;
        $id = $request->id;
        $data = $request->data;
        $params = array(
            'type'=>$type
        );

        $rowItem = $this->photoRepo->GetItem($params);
        $option = json_decode($rowItem['options'],true);

        if($data)
        {
            foreach($data as $column => $value)
            {
                if(is_array($value))
                {
                    foreach($value as $k2 => $v2) $option[$k2] = $v2;
                    $data[$column] = json_encode($option);
                }
                else
                {
                    $data[$column] = htmlspecialchars($value);
                }
            }
        }
        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
        $data['type'] = $type;
        $data['ngaytao'] = $data['ngaysua'] = time();
        $data['act'] = 'photo_static';

        if($id)
        {
            if($request->hasFile('file'))
            {
                $oldimage = $rowItem['photo'];
                $newimage = $request->file('file');
                if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder_save); }
            }

            //### Cập nhật
            $rowItem = $this->photoRepo->SaveItem($data,$id);
        }

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'options'=>(isset($rowItem['options']))?(json_decode($rowItem['options'],true)):'',
            'type'=> $type,
            'config'=>$this->config
        );
        return redirect()->route($this->routeShow,[$category,$type]);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
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

        $row = $this->photoRepo->GetOneItem($id,$this->relations);
        if($row['id']){
            $this->photoRepo->DeleteOneItem($id,$this->folder);
            //### delete photo image
            $image_path = $this->folder_save.$row['photo'];
            Helper::DeleteImage($image_path);
            //### delete photo image
            $image_path = $this->folder_save.$row['model'];
            Helper::DeleteImage($image_path);
            //### delete photo image
            $image_path = $this->folder_save.$row['banner'];
            Helper::DeleteImage($image_path);
            return redirect()->route($this->routeShow,[$category,$type]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu
    |--------------------------------------------------------------------------
    */
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
            $ids = explode(",", $listid);
            foreach($ids as $i=>$item){
                $row = $this->photoRepo->GetOneItem($item,$this->relations);
                //### delete photo image
                $image_path = $this->folder_save.$row['photo'];
                Helper::DeleteImage($image_path);
                //### delete photo image
                $image_path = $this->folder_save.$row['model'];
                Helper::DeleteImage($image_path);
                //### delete photo image
                $image_path = $this->folder_save.$row['banner'];
                Helper::DeleteImage($image_path);
            }
            $this->photoRepo->DeleteMultiItem($listid,$this->folder);
        }

        return redirect()->route($this->routeShow,[$category,$type]);
    }
}

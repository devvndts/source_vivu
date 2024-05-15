<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Traits\SupportTrait;
// use App\Transpost\DeliveryAPI;

use App\Models\Menu;

use Helper;

class SettingController extends Controller
{
    use SupportTrait;
    private $config;
    private $viewShow;
    private $folder_upload;
    private $folder = "user";
    private $routeShow = 'admin.setting.show';
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request)
    {
        $this->config = config('config_type.setting');
        $this->type = $request->type;
        $this->folder_upload = config('config_upload.UPLOAD_USER');

        $this->viewShow = 'admin.templates.setting';
        $this->page_error = redirect()->back();
        $this->permissionEdit = 'setting_capnhat_'.$this->type;
    }


    // Hiển thị thông tin setting
    public function Index(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;

        //dd(env('MAIL_PORT'));

        //### Code xử lý...
        $rowItem = $this->settingRepo->GetItem(['type'=>$type]);
        $menus = Menu::all();

        // dd($this->ViettelPostInventories());

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=>$rowItem,
            'menus'=>$menus,
            'options'=>json_decode($rowItem['options'], true),
            'type'=> $type,
            'config'=>$this->config,
            'folder_upload'=>$this->folder,
            // 'viettelinventory' => $this->ViettelPostInventories()
        );

        return view($this->viewShow)->with($response);
    }


    // Cập nhật thông tin setting
    public function Save(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionEdit)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }


        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;

        $data = $request->data;
        $data['type'] = $type;
        $data['isSoluong'] = (isset($data['isSoluong'])) ? 1 : 0;

        $getimage='';
        if ($request->hasFile('file')) {
            $row = $this->settingRepo->GetOneItem($id);
            $oldimage = $row['photo'];
            //Lưu hình ảnh vào thư mục public/upload/post
            $folder = Helper::GetFolder($this->folder);
            $newimage = $request->file('file');
            if ($newimage) {
                $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }

        if ($data) {
            foreach ($data as $column => $value) {
                if (is_array($value)) {
                    foreach ($value as $k2 => $v2) {
                        $option[$k2] = $v2;
                        //echo $k2.'='.$v2.'<br/>';
                        if ($k2=='linkadmin') {
                            $oldlink = app('settingOptions')['linkadmin'];
                            $newlink = $v2;
                        }
                    }
                    //$option['lang_default'] = 'vi';

                    $data[$column] = json_encode($option);
                } else {
                    $data[$column] = $value;
                }
            }
        }

        //### Code xử lý...
        $row = $this->settingRepo->SaveItem($data, $id);

        $linkAdmin = Str::of(route($this->routeShow, [$category,$type]))->replace($oldlink, $newlink);

        //### Hiển thị giao diện
        return redirect($linkAdmin);
    }


    private function ViettelPostInventories()
    {
        //### khai báo
        $this->transpost = new DeliveryAPI();

        //### lấy thông tin kho hàng
        $inventory = $this->transpost->getListInventoryViettelPost();

        if ($inventory['status']==200) {
            return $inventory['data'];
        }

        return null;
    }
}

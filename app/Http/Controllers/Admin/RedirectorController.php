<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RedirectRulesRequest;
use Illuminate\Http\Request;
use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;
use Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Vkovic\LaravelDbRedirector\Models\RedirectRule;

class RedirectorController extends Controller
{
    private $type;
    private $table;
    private $viewShow;
    private $viewEdit;
    private $config;
    private $config_tags;
    private $permissionShow;
    private $permissionAdd;
    private $permissionEdit;
    private $permissionDelete;
    private $permissionImport;
    private $permissionExport;
    private $page_error;
    private $folder_upload;
    private $routeShow = 'admin.redirector.show';
    private $routeEdit = 'admin.redirector.edit';
    private $folder = "redirector";
    private $folderPost = "post";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    public function initialization(Request $request)
    {
        $this->viewShow = 'admin.templates.redirector.man.redirector';
        $this->viewEdit = 'admin.templates.redirector.man.redirector_add';
        $this->permissionShow = 'redirector_man_'.$this->type;
        $this->permissionAdd = 'redirector_add_'.$this->type;
        $this->permissionEdit = 'redirector_edit_'.$this->type;
        $this->permissionDelete = 'redirector_delete_'.$this->type;
    }

    public function Show(Request $request)
    {
        $this->initialization($request);
        //### check auth permission
        if (!$this->IsPermission($this->permissionShow)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $query = DB::table('redirect_rules');
        
        if ($request->keyword) {
            $query->where('origin', 'like', '%' . $request->keyword . '%');
        }

        $itemShow = $query->select()->get();

        $response = [
            'itemShow' => $itemShow,
            'request' => $request,
            'type' => null,
        ];
        return view($this->viewShow)->with($response);
    }

    public function Add(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionAdd)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Trả về giao diện
        $response = [];
        return view($this->viewEdit)->with($response);
    }

    public function Edit(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionShow)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $id = $request->id;
        $rowItem = null;
        if ($id) {
            $rowItem = RedirectRule::where('id', $id)->first();
        }
        //### Trả về giao diện
        $response = [];
        $response = array(
            'rowItem'=> $rowItem,
        );
        return view($this->viewEdit)->with($response);
    }
    
    public function Save(RedirectRulesRequest $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);
        //### Thiết lập giá trị thuộc tính
        $id = $request->id;
        //### check auth permission
        if ($id) {
            if (!$this->IsPermission($this->permissionEdit)) {
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        } else {
            if (!$this->IsPermission($this->permissionAdd)) {
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        }

        $data = $request->data;

        //### Code xử lý...
        if ($id) {
            RedirectRule::where('id', $id)
            ->update([
                'origin' => $data['origin'],
                'destination' => $data['destination']
            ]);
        } else {
            RedirectRule::create([
                'origin' => $data['origin'],
                'destination' => $data['destination']
            ]);
        }

        return redirect()->route($this->routeShow);
    }

    public function Delete(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionDelete)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $id = $request->id;
        RedirectRule::destroy($id);
        return redirect()->route($this->routeShow);
    }

    public function DeleteAll(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionDelete)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $listid = $request->listid;
        
        if ($listid != '') {
            $listidArray = explode(',', $listid);
            foreach ($listidArray as $key => $value) {
                RedirectRule::destroy($value);
            }
        }

        return redirect()->route($this->routeShow);
    }
}

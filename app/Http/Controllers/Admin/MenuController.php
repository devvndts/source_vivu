<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use App\Models\Menu;
use App\Models\Menuitem;

use Session;

class MenuController extends Controller
{
    use SupportTrait;

    private $type, $table, $viewShow, $viewEdit, $config, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload;
    private $routeShow = 'admin.menu.index';
    private $routeEdit = 'admin.menu.edit';
    private $folder = "menu";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    private $arr_ids_delete = array();
    private $menu_content = '';
    private $arr_page = array(), $arr_post = array(), $arr_product = array(), $arr_album = array(), $arr_category = array(), $arr_menu = array();

    private $config_menu;
    private $config_category;
    private $config_post;
    private $config_product;
    private $config_album;
    private $lang_menu = 'vi';


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->category = $request->category;
        $this->type = $request->type;
        $this->lang_menu = ($request->lang) ? $request->lang : $this->lang_menu;
        $this->page_error = redirect()->back();
        $this->other_title = "Quản lý menu";

        $this->relations = ['HasAllChild'];
        $this->relationsCate = $this->categoryRepo->GetRelationsRepo(); //['CategoryParent'];

        $this->viewShow = 'admin.templates.menu.index';
        $this->viewEdit = 'admin.templates.menu.add';
        
        $this->permissionShow = 'menu_man_'.$this->type;
        $this->permissionAdd = 'menu_add_'.$this->type;
        $this->permissionEdit = 'menu_edit_'.$this->type;
        $this->permissionDelete = 'menu_delete_'.$this->type;        
    }


    public function GetPages(){
        $this->config_menu = config('menu');
        $this->config_category = config('category');
        $this->config_post = config('config_type.post');
        $this->config_product = config('config_type.product');
        $this->config_album = config('config_type.album');
        $this->arr_page = config('pages');

        //### get categories
        foreach($this->config_category as $k=>$v){
            $categories = $this->categoryRepo->GetAll($k);
            if($categories){
                if(isset($v['menu'])){$this->arr_category[$v['title_main_category']] = $categories->toArray();}
            }
        }

        //### get post
        foreach($this->config_post as $k=>$v){
            $posts = $this->postRepo->GetAll($k);
            if($posts){
                if(isset($v['menu'])){$this->arr_post[$v['title_main']] = $posts->toArray();}
                //if($v['menu']){$this->arr_page[$v['com']] = $v['title_main'];}
            }
        }
        

        //### get product
        foreach($this->config_product as $k=>$v){
            $products = $this->productRepo->GetAll($k);
            if($products){
                if(isset($v['menu'])){$this->arr_product[$v['title_main']] = $products->toArray();}
                //if($v['menu']){$this->arr_page[$v['com']] = $v['title_main'];}
            }
        }


        //### get album
        foreach($this->config_album as $k=>$v){
            $albums = $this->albumRepo->GetAll($k);
            if($albums){
                if(isset($v['menu'])){$this->arr_album[$v['title_main']] = $albums->toArray();}
                //if($v['menu']){$this->arr_page[$v['com']] = $v['title_main'];}
            }
        }
    }


    public function Index(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $desiredMenu = '';
        $menuitems = '';


        $this->GetPages();


        //### Code xử lý...
        $id = $request->id;
        $type = 'man';
        $is_new = ($id=='new') ? true : false;

        if($id && $id!='new'){            
            $desiredMenu = Menu::where('id',$id)->first();

            if($desiredMenu->content != ''){
                $menuitems = json_decode($desiredMenu->content,true);
                $menuitems = $menuitems[0]; 

                $menuitems = $this->CallPropertyMenu($menuitems);

            }else{
                $menuitems = Menuitem::where('menu_id',$desiredMenu->id)->get();
            }

        }else{           
            $desiredMenu = Menu::orderby('id','DESC')->first();

            if($desiredMenu){
                if($desiredMenu->content != ''){                    
                    $menuitems = json_decode($desiredMenu->content, true);
                    $menuitems = $menuitems[0]; 

                    $menuitems = $this->CallPropertyMenu($menuitems);

                }else{
                    $menuitems = Menuitem::where('menu_id',$desiredMenu->id)->get();   

                }                
            }    
        }


        //### get ids menu items
        $ids_menuitems = array();
        if($menuitems){
            //get ids has saved
            //dd($menuitems);
            $ids_menuitems = array_merge($ids_menuitems,$this->GetIdsMenuItems($menuitems));
        }


        //### get blade view menuitem
        $menuitems = $this->GetViewMenuitems($menuitems);

        //dd($arr_category);
        $menus = Menu::all();

        //### Trả về giao diện
        $response = array(
            'request'=>$request,            
            'menus'=>$menus,
            'desiredMenu'=>$desiredMenu,
            'menuitems'=>$menuitems,
            'ids_menuitems' => $ids_menuitems,
            'is_new' => $is_new,
            'type'=> $type,
            'categories'=> $this->arr_category,
            'pages' => $this->arr_page,            
            'posts' => $this->arr_post,
            'products' => $this->arr_product,
            'albums' => $this->arr_album,
            'menu_location' => $this->config_menu,            
            'other_title' => $this->other_title,
            'lang_menu' => $this->lang_menu,
            'setting' => app('setting')
            //'config'=>$this->config
        );

        return view($this->viewShow)->with($response);
    }


    public function Create(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $data = $request->all(); 

        //### Code xử lý...        

        if(Menu::create($data)){ 
            //### lưu thông tin menu
            $newdata = Menu::orderby('id','DESC')->first();
            session::flash('success','Menu lưu thành công !');
            return redirect()->route($this->routeShow,[$newdata->id]);
            
        }else{            
            return redirect()->back()->with('error','Failed to save menu !');
        }
    }


    public function AddCatToMenu(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);        

        if($menu->content=='' || $menu->content==null){
          foreach($ids as $id){
            $row_category = $this->categoryRepo->GetOneItem($id);
            $data_save['titlevi'] = $row_category['tenvi'];
            $data_save['titleen'] = $row_category['tenen'];
            $data_save['slug'] = $row_category['tenkhongdauvi'];
            $data_save['id_data'] = $row_category['id'];
            $data_save['type'] = 'category';
            $data_save['menu_id'] = $menuid;            
            $data['updated_at'] = NULL;
            Menuitem::create($data_save);
          }
        }else{
          $olddata = json_decode($menu->content,true);

          foreach($ids as $id){
            $row_category = $this->categoryRepo->GetOneItem($id);            
            $data_save['titlevi'] = $row_category['tenvi'];
            $data_save['titleen'] = $row_category['tenen'];
            $data_save['slug'] = $row_category['tenkhongdauvi'];
            $data_save['id_data'] = $row_category['id'];
            $data_save['type'] = 'category';
            $data_save['menu_id'] = $menuid;
            $data_save['updated_at'] = NULL;
            Menuitem::create($data_save);

            $array['titlevi'] = $row_category['tenvi'];
            $array['titleen'] = $row_category['tenen'];
            $array['slug'] = $row_category['tenkhongdauvi'];
            $array['namevi'] = $array['nameen'] = NULL;
            $array['type'] = 'category';
            $array['target'] = NULL;
            $array['id'] = Menuitem::where('slug',$array['slug'])->where('name'.$this->lang_menu,$array['name'.$this->lang_menu])->where('type',$array['type'])->value('id');
            $array['children'] = [[]];
            array_push($olddata[0],$array);
            $oldata = json_encode($olddata);

            
            $menu->update(['content'=>$olddata]);
          }
        }
    }


    public function AddPostToMenu(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);

        if($menu->content == ''){
          foreach($ids as $id){
            $row_post = $this->postRepo->GetOneItem($id);
            $data_save['titlevi'] = $row_post['tenvi'];
            $data_save['titleen'] = $row_post['tenen'];
            $data_save['slug'] = $row_post['tenkhongdauvi'];
            $data_save['id_data'] = $row_post['id'];
            $data_save['type'] = 'post';
            $data_save['menu_id'] = $menuid;
            $data_save['updated_at'] = NULL;
            Menuitem::create($data_save);
          }
        }else{
          $olddata = json_decode($menu->content,true); 
          foreach($ids as $id){
            $row_post = $this->postRepo->GetOneItem($id);
            $data_save['titlevi'] = $row_post['tenvi'];
            $data_save['titleen'] = $row_post['tenen'];
            $data_save['slug'] = $row_post['tenkhongdauvi'];
            $data_save['id_data'] = $row_post['id'];
            $data_save['type'] = 'post';
            $data_save['menu_id'] = $menuid;
            $data_save['updated_at'] = NULL;
            Menuitem::create($data_save);

            $array['titlevi'] = $row_post['tenvi'];
            $array['titleen'] = $row_post['tenen'];
            $array['slug'] = $row_post['tenkhongdauvi'];
            $array['id_data'] = $row_post['id'];
            $array['namevi'] = $array['nameen'] = NULL;
            $array['type'] = 'post';
            $array['target'] = NULL;
            $array['id'] = Menuitem::where('slug',$array['slug'])->where('name'.$this->lang_menu,$array['name'.$this->lang_menu])->where('type',$array['type'])->orderby('id','DESC')->value('id');                
            $array['children'] = [[]];
            array_push($olddata[0],$array);
            $oldata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }          
        }
    }


    public function AddProductToMenu(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);

        if($menu->content == ''){
          foreach($ids as $id){
            $row_product = $this->productRepo->GetOneItem($id);
            $data_save['titlevi'] = $row_product['tenvi'];
            $data_save['titleen'] = $row_product['tenen'];
            $data_save['slug'] = $row_product['tenkhongdauvi'];
            $data_save['id_data'] = $row_product['id'];
            $data_save['type'] = 'product';
            $data_save['menu_id'] = $menuid;
            $data_save['updated_at'] = NULL;
            Menuitem::create($data_save);
          }
        }else{
          $olddata = json_decode($menu->content,true); 
          foreach($ids as $id){
            $row_product = $this->productRepo->GetOneItem($id);
            $data_save['titlevi'] = $row_product['tenvi'];
            $data_save['titleen'] = $row_product['tenen'];
            $data_save['slug'] = $row_product['tenkhongdauvi'];
            $data_save['id_data'] = $row_product['id'];
            $data_save['type'] = 'product';
            $data_save['menu_id'] = $menuid;
            $data_save['updated_at'] = NULL;
            Menuitem::create($data_save);

            $array['titlevi'] = $row_product['tenvi'];
            $array['titleen'] = $row_product['tenen'];
            $array['slug'] = $row_product['tenkhongdauvi'];
            $array['id_data'] = $row_product['id'];
            $array['namevi'] = $array['nameen'] = NULL;
            $array['type'] = 'product';
            $array['target'] = NULL;
            $array['id'] = Menuitem::where('slug',$array['slug'])->where('name'.$this->lang_menu,$array['name'.$this->lang_menu])->where('type',$array['type'])->orderby('id','DESC')->value('id');
            $array['children'] = [[]];
            array_push($olddata[0],$array);
            $oldata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }          
        }
    }



    public function AddAlbumToMenu(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);

        if($menu->content == ''){
          foreach($ids as $id){
            $row_album = $this->albumRepo->GetOneItem($id);
            $data_save['titlevi'] = $row_album['tenvi'];
            $data_save['titleen'] = $row_album['tenen'];
            $data_save['slug'] = $row_album['tenkhongdauvi'];
            $data_save['id_data'] = $row_album['id'];
            $data_save['type'] = 'album';
            $data_save['menu_id'] = $menuid;
            $data_save['updated_at'] = NULL;
            Menuitem::create($data_save);
          }
        }else{
          $olddata = json_decode($menu->content,true); 
          foreach($ids as $id){
            $row_album = $this->albumRepo->GetOneItem($id);
            $data_save['titlevi'] = $row_album['tenvi'];
            $data_save['titleen'] = $row_album['tenen'];
            $data_save['slug'] = $row_album['tenkhongdauvi'];
            $data_save['id_data'] = $row_album['id'];
            $data_save['type'] = 'album';
            $data_save['menu_id'] = $menuid;
            $data_save['updated_at'] = NULL;
            Menuitem::create($data_save);

            $array['titlevi'] = $row_album['tenvi'];
            $array['titleen'] = $row_album['tenen'];
            $array['slug'] = $row_album['tenkhongdauvi'];
            $array['id_data'] = $row_album['id'];
            $array['namevi'] = $array['nameen'] = NULL;
            $array['type'] = 'album';
            $array['target'] = NULL;
            $array['id'] = Menuitem::where('slug',$array['slug'])->where('name'.$this->lang_menu,$array['name'.$this->lang_menu])->where('type',$array['type'])->orderby('id','DESC')->value('id');
            $array['children'] = [[]];
            array_push($olddata[0],$array);
            $oldata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }
        }
    }


    public function AddPageToMenu(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);

        $this->GetPages();

        if($menu->content == ''){
          foreach($ids as $key=>$id){
            if(array_key_exists($id, $this->arr_page)) {
                $data_save['titlevi'] = $this->arr_page[$id]['titlevi'];
                $data_save['titleen'] = $this->arr_page[$id]['titleen'];
                $data_save['slug'] = $id;
                $data_save['id_data'] = $id;
                $data_save['type'] = 'page';
                $data_save['menu_id'] = $menuid;
                $data_save['updated_at'] = NULL;
                Menuitem::create($data_save);
            }
          }
        }else{
          $olddata = json_decode($menu->content,true);

          foreach($ids as $key=>$id){
            if(array_key_exists($id, $this->arr_page)) {
                $data_save['titlevi'] = $this->arr_page[$id]['titlevi'];
                $data_save['titleen'] = $this->arr_page[$id]['titleen'];
                $data_save['slug'] = $id;
                $data_save['id_data'] = $id;
                $data_save['type'] = 'page';
                $data_save['menu_id'] = $menuid;
                $data_save['updated_at'] = NULL;
                Menuitem::create($data_save);

                $array['titlevi'] = $this->arr_page[$id];
                $array['titleen'] = $this->arr_page[$id]['titleen'];
                $array['slug'] = $id;
                $array['id_data'] = $id;
                $array['namevi'] = $array['nameen'] = NULL;
                $array['type'] = 'page';
                $array['target'] = NULL;
                $array['id'] = Menuitem::where('slug',$array['slug'])->where('name'.$this->lang_menu,$array['name'.$this->lang_menu])->where('type',$array['type'])->orderby('id','DESC')->value('id');
                $array['children'] = [[]];
                array_push($olddata[0],$array);
                $oldata = json_encode($olddata);
                $menu->update(['content'=>$olddata]);
            }
          }
        }
    }


    public function AddCustomLink(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        $data = $request->all();
        $menuid = $request->menuid;
        $menu = Menu::findOrFail($menuid);


        if($menu->content == ''){
          $data_save['titlevi'] = $data_save['titleen'] = $request->link;
          $data_save['slug'] = $request->url;
          $data_save['type'] = 'custom';
          $data_save['menu_id'] = $menuid;
          $data_save['updated_at'] = NULL;
          Menuitem::create($data_save);
        }else{
          $olddata = json_decode($menu->content,true); 
          $data_save['titlevi'] = $data_save['titleen'] = $request->link;
          $data_save['slug'] = $request->url;
          $data_save['type'] = 'custom';
          $data_save['menu_id'] = $menuid;
          $data_save['updated_at'] = NULL;
          Menuitem::create($data_save);

          $array = [];
          $array['titlevi'] = $array['titleen'] = $request->link;
          $array['slug'] = $request->url;
          $array['namevi'] = $array['nameen'] = NULL;
          $array['type'] = 'custom';
          $array['target'] = NULL;
          $array['id'] = Menuitem::where('slug',$array['slug'])->where('name'.$this->lang_menu,$array['name'.$this->lang_menu])->where('type',$array['type'])->orderby('id','DESC')->value('id');
          $array['children'] = [[]];
          array_push($olddata[0],$array);
          $oldata = json_encode($olddata);
          $menu->update(['content'=>$olddata]);
        }
    }


    public function UpdateMenu(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        $newdata = $request->all(); 
        $menu=Menu::findOrFail($request->menuid);            
        $content = $request->data;

        $newdata = [];  
        $newdata['location'] = $request->location;       
        $newdata['content'] = ($content) ? json_encode($content) : '';
        $menu->update($newdata); 

        //### lưu thông tin menu selected to setting model
        $menu_selected = $request->menu_selected;
        $id_setting = $request->id_setting;
        if($menu_selected){$this->settingRepo->SaveItem(['menu'=>$menu_selected], $id_setting);}
    }   


    public function UpdateMenuItem(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        $data = $request->all();
        $item = Menuitem::findOrFail($request->id);
        $item->update($data);
        return redirect()->back();
    }

    public function DeleteMenuitemChild($children, $is_iddelete, $id_delete){
        foreach($children as $c=>$child){            
            foreach($child as $k=>$v){
                if($v['id']==$id_delete){
                    $is_iddelete = true;
                }
                if($is_iddelete){
                    array_push($this->arr_ids_delete,$v['id']);
                }

                if(isset($v['children'])){                                      
                    $this->DeleteMenuitemChild($v['children'],$is_iddelete, $id_delete);
                } 
            }
        }
    }


    public function DeleteMenuItem(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### khởi tạo
        //$menuitem = Menuitem::findOrFail($id);
        $menu = Menu::where('id',$request->menuid)->first();   
        $id_delete = $request->id;

        $ids = Menuitem::where('menu_id',$menu->id)->get();

        //### code xử lý
        if($ids){
            //$data = json_decode($menu->content,true);
            if($menu->content!=''){
                $data = json_decode($menu->content,true);
                $maindata = $data[0];
            }else{                
                $maindata = $ids->toArray();
            }

            foreach($maindata as $k=>$v){
                $is_iddelete = false;
                if($v['id']==$id_delete){
                    $is_iddelete = true;
                    array_push($this->arr_ids_delete,$v['id']);
                }    

                if(isset($v['children'])){
                    $this->DeleteMenuitemChild($v['children'],$is_iddelete,$id_delete);
                }
            }
        }

        //### Delete menuitems  
        if($this->arr_ids_delete){Menuitem::whereIn('id', $this->arr_ids_delete)->delete();}

        //### Cập nhật content menu sau khi delete
        $content = $request->data;
        $newdata = [];

        $newdata['content'] = ($content) ? json_encode($content) : '';        
        $menu->update($newdata);
        
        return redirect()->back();
    }   


    public function destroy(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        Menuitem::where('menu_id',$request->id)->delete();    
        Menu::findOrFail($request->id)->delete();
        return redirect()->route('admin.menu.index')->with('success','Xóa menu thành công');
    }

    public function GetIdsMenuItems($menuitems){
        $arr_ids = array();

        foreach($menuitems as $i=>$item){      
            //dd($item);     
            array_push($arr_ids, $item['id_data']);            
            if(isset($item['children'])){
                foreach($item['children'] as $c=>$child){                 
                    $arr_ids = array_merge($arr_ids,$this->GetIdsMenuItems($child));
                }
            }
            
        }

        return $arr_ids;
    }


    public function CallPropertyMenu($menuitems){
        if($menuitems){
            foreach($menuitems as $key => $menu){
                $menu['id_data'] = Menuitem::where('id',$menu['id'])->value('id_data');
                $menu['titlevi'] = Menuitem::where('id',$menu['id'])->value('titlevi');
                $menu['titleen'] = Menuitem::where('id',$menu['id'])->value('titleen');
                $menu['namevi'] = Menuitem::where('id',$menu['id'])->value('namevi');
                $menu['nameen'] = Menuitem::where('id',$menu['id'])->value('nameen');
                $menu['slug'] = Menuitem::where('id',$menu['id'])->value('slug');
                $menu['target'] = Menuitem::where('id',$menu['id'])->value('target');
                $menu['type'] = Menuitem::where('id',$menu['id'])->value('type');

                if(!empty($menu['children'][0])){
                    $menu['children'][0] = $this->CallPropertyMenu($menu['children'][0]);
                }

                $menuitems[$key] = $menu;
            }

            return $menuitems;
        }
    }


    public function GetViewMenuitems($menuitems){
        $result = ''; 

        //$menuitems = $menuitems->toArray();

        $result.='<ul class="menu ui-sortable" id="menuitems">';
            if(!empty($menuitems)){
                foreach($menuitems as $key=>$item){
                    $result.='<li data-id="'.$item['id'].'" data-title="'.$item['title'.$this->lang_menu].'" data-slug="'.$item['slug'].'" data-type="'.$item['type'].'" class="parent_li"><span class="menu-item-bar"><i class="fa fa-arrows mr-2"></i>';
                    if(empty($item['name'.$this->lang_menu])) {
                        $result.= $item['title'.$this->lang_menu];
                    }else {
                        $result.= $item['name'.$this->lang_menu];
                    }
                    $result.='<a href="#collapse'.$item['id'].'" class="drag-menu-right pull-right" data-toggle="collapse"><i class="fas fa-sort-down"></i></a></span>
                        <div class="collapse" id="collapse'.$item['id'].'">
                            <div class="input-box">
                                <form method="post" action="'.route('admin.menu.updateMenuItem',[$item['id']]).'">                                            
                                    <div class="form-group">
                                        <label>Tên</label>
                                        <input type="text" name="name'.$this->lang_menu.'" value="'.((empty($item['name'.$this->lang_menu])) ? $item['title'.$this->lang_menu] : $item['name'.$this->lang_menu]).'" class="form-control">
                                    </div>';

                                    if($item['type'] == 'custom'){ 
                                        $check = ($item['target'] == '_blank') ? 'checked' : '';                                             
                                        $result.='<div class="form-group">
                                          <label>URL</label>
                                          <input type="text" name="slug" value="'.$item['slug'].'" class="form-control">
                                        </div>
                                        <div class="form-group">
                                          <input type="checkbox" name="target" value="_blank" '.$check.'> Mở trong tab mới
                                        </div>';
                                    }
                                    $result.='<div class="form-group">
                                        <button class="btn btn-sm btn-primary">Lưu</button>
                                        <a class="btn btn-sm btn-danger deleteMenuItem">Xóa</a>
                                    </div>
                                </form>
                            </div>
                        </div>';  

                        $result.='<ul style="padding-left:30px;">';
                        $result.= (isset($item['children'])) ? $this->GetViewMenuitemsChild($item['children'], $key) : '';
                        $result.='</ul>';

                    $result.='</li>';
                } //foreach

            } //endif
        $result.='</ul>';

        return $result;
    }


    public function GetViewMenuitemsChild($children, $key){
        $result = '';

        if(isset($children)){
            foreach($children as $m){
                foreach($m as $in=>$data){
                    $result.='<li data-id="'.$data['id'].'" data-title="'.$data['title'.$this->lang_menu].'"  data-slug="'.$data['slug'].'" data-type="'.$data['type'].'" class="menu-item parent_li"> <span class="menu-item-bar"><i class="fa fa-arrows mr-2"></i>';
                    if(empty($data['name'.$this->lang_menu])){
                        $result.=$data['title'.$this->lang_menu];
                    }else{
                        $result.=$data['name'.$this->lang_menu];
                    }
                    $result.='<a href="#collapse'.$data['id'].'" class="drag-menu-right pull-right" data-toggle="collapse"><i class="fas fa-sort-down"></i></a></span>
                        <div class="collapse" id="collapse'.$data['id'].'">
                            <div class="input-box">
                                <form method="post" action="'.route('admin.menu.updateMenuItem',[$data['id']]).'">
                                    <div class="form-group">
                                        <label>Tên</label>
                                        <input type="text" name="name'.$this->lang_menu.'" value="'.((empty($data['name'.$this->lang_menu])) ? $data['title'.$this->lang_menu] : $data['name'.$this->lang_menu]).'" class="form-control">
                                    </div>';

                                    if($data['type'] == 'custom'){
                                        $check = ($data['target'] == '_blank') ? 'checked' : '';   
                                        $result.='<div class="form-group">
                                            <label>URL</label>
                                            <input type="text" name="slug" value="'.$data['slug'].'" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="target" value="_blank" '.$check.'> Mở trong tab mới
                                        </div>';
                                    }

                                    $result.='<div class="form-group">
                                        <button class="btn btn-sm btn-primary">Lưu</button>
                                        <a class="btn btn-sm btn-danger deleteMenuItem">Xóa</a>
                                    </div>
                                </form>
                            </div>
                        </div>';
                        $result.='<ul style="padding-left:30px;">';                   
                        $result.= (isset($data['children'])) ? $this->GetViewMenuitemsChild($data['children'], $key) : '';
                        $result.='</ul>';
                    $result.='</li>';
                }
            }
        }

        return $result;
    }
}

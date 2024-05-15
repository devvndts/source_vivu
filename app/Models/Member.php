<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Member extends Model
{
    use HasFactory;

    protected $table = "admins";

    protected $fillable = ['username', 'email', 'password', 'lastlogin', 'name', 'hienthi', 'role', 'stt', 'id_nhomquyen', 'id_parent', 'list_idparent', 'list_idchild'];

    /*
    |--------------------------------------------------------------------------
    | Mặc định số lượng dòng dữ liệu trên 1 trang
    |--------------------------------------------------------------------------
    */
    private $numberPerpage = 10;

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    | Dựa theo category mà controller truyền vào để xác định model tương ứng .Sau đó mapping tới table trong database
    |--------------------------------------------------------------------------
    | Số lượng dòng trên 1 trang sẽ được thay đổi theo cấu hình trong file config_all.numberperpages
    |
    */
    public function __construct(){}

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetAllItems($type,$params){
        $auth_admin = Auth::guard('admin')->user();
        $run_sql = $this;
        if($params){
            $run_sql=$run_sql->where('role','<>', 3);
            if($auth_admin->role!=3){$run_sql=$run_sql->where('id_parent',$auth_admin->id);}
            foreach($params as $k=>$v){
                if($k!='keyword' && $v>0){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='keyword'){
                    $run_sql=$run_sql->like('username', $v);
                }
            }
        }
        $run_sql = $run_sql->paginate($this->numberPerpage)->withQueryString();
        return $run_sql;
    }

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type và điều kiện tìm kiếm để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetItemsBySearch($type,$keyword){
        return $this->like('name', $keyword)->paginate($this->numberPerpage)->withQueryString();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function GetOneItem($id){
    	if($id){
            $run_sql = $this;
    		$run_sql = $run_sql->where('id', $id)->first();
            if($run_sql){return $run_sql->toArray();}
    	}
    	return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function GetItemOther($id){
        if($id){
            return $this->where('id', '<>', $id)->get()->toArray();
        }
        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật dữ liệu
    |--------------------------------------------------------------------------
    | Biến $data: Mảng dữ liệu đầu vào
    |--------------------------------------------------------------------------
    | Biến $id: Nếu có thì cập nhật. Ngược lại thì tạo mới
    */
    public function SaveItem($data,$id='null'){
    	return $this->updateOrCreate(['id'=>$id], $data);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function DeleteOneItem($id){
        $row = $this->GetOneItem($id);
        if($row){$this->find($id)->delete();}
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy nhiều dòng dữ liệu theo chuỗi danh sách id
    |--------------------------------------------------------------------------
    */
    public function DeleteMultiItem($listid){
        $ids = explode(",", $listid);
        foreach($ids as $i=>$id_photo){
            $this->DeleteOneItem($id_photo);
        }
        $this->whereIn('id', $ids)->delete();
    }


    /*
    |--------------------------------------------------------------------------
    | Danh sách scope hỗ trợ cho truy vấn
    |--------------------------------------------------------------------------
    */
    public function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%".$value."%");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLimit extends Model
{
    use HasFactory;
    protected $table = "user_limit";
    protected $guarded = [];

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
    public function __construct(){
    	
    }

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetAllItems($type,$params){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                if($k!='keyword' && $v>0){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='keyword'){
                    $run_sql=$run_sql->like('ten', $v);
                }
            }
        }
        $run_sql = $run_sql->where('type', $type)->orderBy('stt', 'asc')->paginate($this->numberPerpage)->withQueryString();
        return $run_sql;
    }

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type và điều kiện tìm kiếm để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetItemsBySearch($type,$keyword){
        return $this->where('type', $type)->where('hienthi',1)->like('ten', $keyword)->orderBy('stt', 'asc')->paginate($this->numberPerpage)->withQueryString();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo params truyền vào
    |--------------------------------------------------------------------------
    */
    public function GetItem($params){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        $run_sql = $run_sql->first();
        if($run_sql){
            $run_sql = $run_sql->toArray();
        }else{
            $run_sql = null;
        }
        return $run_sql;
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function GetOneItem($id){
    	if($id){
    		return $this->where('id', $id)->first()->toArray();
    	}
    	return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo ids
    |--------------------------------------------------------------------------
    */
    public function GetAllItemByIds($ids){
    	if($ids){
    		return $this->whereIn('id', $ids)->get()->toArray();
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
    public function SaveProduct($data,$id='null'){
    	return $this->updateOrCreate(['id'=>$id], $data);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function DeleteOneItem($id){
        $this->find($id)->delete();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy nhiều dòng dữ liệu theo chuỗi danh sách id
    |--------------------------------------------------------------------------
    */
    public function DeleteMultiItem($listid){
        $ids = explode(",", $listid);
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

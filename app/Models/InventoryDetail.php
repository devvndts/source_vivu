<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Helper;

class InventoryDetail extends Model
{
    use HasFactory;

    protected $table = "inventory_detail";
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
        //$this->numberPerpage = config('config_all.numberperpage.color');
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    /*public function GetAllItems($type,$params,$paginate=false){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                if($k!='keyword' && $v>0){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='keyword'){
                    $run_sql=$run_sql->like('tenvi', $v);
                }
            }
        }
        $run_sql = $run_sql->where('type', $type)->hienthi()->orderBy('stt', 'asc');
        if(!$paginate){
            return $run_sql->get()->toArray();
        }
        return $run_sql = $run_sql->paginate($this->numberPerpage)->withQueryString();
    }*/

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type và điều kiện tìm kiếm để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    /*public function GetItemsBySearch($type,$keyword){
        return $this->where('type', $type)->like('tenvi', $keyword)->orderBy('stt', 'asc')->paginate($this->numberPerpage)->withQueryString();
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng -
    |--------------------------------------------------------------------------
    */
    /*public function GetAllItemsFindInSet($type, $field_search=null){
        return $this->where('type', $type)->hienthi()->whereRaw('FIND_IN_SET(id,"'.$field_search.'")')->orderBy('stt', 'asc')->get()->toArray();
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    /*public function GetOneItem($id){
        if($id){
            return $this->where('id', $id)->first()->toArray();
        }
        return null;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    /*public function GetOneItemByParams($params){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        return ($run_sql->first()) ? $run_sql->first() : null;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo ids
    |--------------------------------------------------------------------------
    */
    /*public function GetAllItemByIds($ids){
        if($ids){
            return $this->whereIn('id', $ids)->get()->toArray();
        }
        return null;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật dữ liệu
    |--------------------------------------------------------------------------
    | Biến $data: Mảng dữ liệu đầu vào
    |--------------------------------------------------------------------------
    | Biến $id: Nếu có thì cập nhật. Ngược lại thì tạo mới
    */
    /*public function SaveProduct($data,$id='null'){
        return $this->updateOrCreate(['id'=>$id], $data);
    }*/


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    /*public function DeleteOneItem($id){
        $this->find($id)->delete();
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy nhiều dòng dữ liệu theo chuỗi danh sách id
    |--------------------------------------------------------------------------
    */
    /*public function DeleteMultiItem($listid){
        $ids = explode(",", $listid);
        $this->whereIn('id', $ids)->delete();
    }*/


    /*
    |--------------------------------------------------------------------------
    | Danh sách scope hỗ trợ cho truy vấn
    |--------------------------------------------------------------------------
    */
    public function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%".$value."%");
    }

    public function scopeHienthi($query,$val=1){
        return $query->where('hienthi', $val);
    }
}

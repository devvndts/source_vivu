<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = "order_detail";
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Mặc định số lượng dòng dữ liệu trên 1 trang
    |--------------------------------------------------------------------------
    */
    private $numberPerpage = 20;

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
    | RelationShip: Lấy tất cả dòng dữ liệu của order detail relation với order theo id_order (đk: hiển thị)
    |--------------------------------------------------------------------------
    */
    public function HasOrderDetails() {
        return $this->hasMany('App\Models\OrderDetail','id_order')->where('hienthi',1);
    }

    /*
    |--------------------------------------------------------------------------
    | RelationShip - Belongto: Lấy 1 dòng dữ liệu từ bảng order theo id_order của order_detail
    |--------------------------------------------------------------------------
    */
    public function BelongOrder() {
        return $this->belongsTo('App\Models\Order', 'id_product');
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetItem($params=null){
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
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetAllItems($params){
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
        $run_sql = $run_sql->orderBy('id', 'desc')->paginate($this->numberPerpage)->withQueryString();
        return $run_sql;
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type và điều kiện tìm kiếm để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetItemsBySearch($keyword){
        return $this->like('ten', $keyword)->orderBy('id', 'desc')->paginate($this->numberPerpage)->withQueryString();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetAllItemsByIdParent($idparent){
        $run_sql = $this;
        if($idparent){
            $run_sql=$run_sql->where('id_order', $idparent);
        }
        $run_sql = $run_sql->orderBy('id', 'asc')->get()->toArray();
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
    | Lưu mới - cập nhật dữ liệu
    |--------------------------------------------------------------------------
    | Biến $data: Mảng dữ liệu đầu vào
    |--------------------------------------------------------------------------
    | Biến $id: Nếu có thì cập nhật. Ngược lại thì tạo mới
    */
    public function SaveProduct($data,$id=null){
    	return $this->updateOrCreate(['id'=>$id], $data);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function DeleteOneItem($id){
        $row = $this->GetOneItem($id);
        $this->find($id)->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Xóa dữ liệu theo param truyền vào
    |--------------------------------------------------------------------------
    */
    public function DeleteTMPItemByParams($params=''){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        $run_sql->delete();
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

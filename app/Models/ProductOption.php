<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Helper;

class ProductOption extends Model
{
    use HasFactory;

    protected $table = "product_option";
    protected $guarded = ['slugvi','slugen'];

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
    */
    public function __construct(){

    }

    /*
    |--------------------------------------------------------------------------
    | RelationShip - Belongto: Lấy 1 dòng dữ liệu từ bảng product theo id_product của product_option
    |--------------------------------------------------------------------------
    */
    public function ProductParent() {
        return $this->belongsTo('App\Models\Product', 'id_product');
    }

    /*
    |--------------------------------------------------------------------------
    | RelationShip - Belongto: Lấy 1 dòng dữ liệu từ bảng color theo id_mau của product_option
    |--------------------------------------------------------------------------
    */
    public function ColorOption() {
        return $this->belongsTo('App\Models\Color', 'id_mau');
    }
    

    /*
    |--------------------------------------------------------------------------
    | RelationShip - Belongto: Lấy 1 dòng dữ liệu từ bảng size theo id_size của product_option
    |--------------------------------------------------------------------------
    */
    public function SizeOption() {
        return $this->belongsTo('App\Models\Size', 'id_size');
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy ds relation ship của model
    |--------------------------------------------------------------------------
    */
    public function GetRelations(){
        return ['ProductParent', 'ColorOption', 'SizeOption'];
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    /*public function GetAllItems($type,$params=null){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                if($k!='keyword' && $v>0){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='xoatam'){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='keyword' && $v!=''){
                    $run_sql=$run_sql->like('tenvi', $v);
                }
            }
        }
        //Helper::showSQL($run_sql);
        $run_sql = $run_sql->where('type', $type)->orderBy('stt', 'asc')->paginate($this->numberPerpage)->withQueryString();
        return $run_sql;
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
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    /*public function GetOneItemByParams($params=null){ //Getitem
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                if($k!='keyword' && $v>0){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='xoatam'){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='keyword' && $v!=''){
                    $run_sql=$run_sql->like('tenvi', $v);
                }
            }
        }
        //Helper::showSQL($run_sql);
        $run_sql = $run_sql->where('type', $type)->orderBy('stt', 'asc')->paginate($this->numberPerpage)->withQueryString();
        return $run_sql;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    /*public function CheckOneItemByParams($params){
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
    | Lấy tất cả các dòng dữ liệu theo mảng params (điều kiện truy vấn) truyền vào
    |--------------------------------------------------------------------------
    */
    /*public function GetAllItems($params){//GetAllItemsByParams
        $run_sql = $this;
        foreach($params as $k=>$v){
            $run_sql=$run_sql->where($k, $v);
        }
        $run_sql=$run_sql->orderBy('stt', 'asc')->get()->toArray();
        return $run_sql;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 fiels của tất cả các dòng dữ liệu theo mảng params (điều kiện truy vấn) truyền vào
    |--------------------------------------------------------------------------
    */
    /*public function GetAllItemsByParamsPluck($field, $params){
        $run_sql = $this;
        foreach($params as $k=>$v){
            $run_sql=$run_sql->where($k, $v);
        }
        $run_sql=$run_sql->get()->pluck($field)->toArray();
        return $run_sql;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả các dòng dữ liệu theo mảng params (điều kiện truy vấn) truyền vào
    |--------------------------------------------------------------------------
    */
    /*public function GetItem($params){//GetOneItemsByParams
        $run_sql = $this;
        foreach($params as $k=>$v){
            $run_sql=$run_sql->where($k, $v);
        }
        $run_sql=$run_sql->orderBy('stt', 'asc')->first();
        if($run_sql){
            return $run_sql=$run_sql->toArray();
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
        $row = $this->GetOneItem($id);
        $path = Helper::GetFolder('product').$row['photo'];
        if (file_exists($path)) {
            @unlink($path);
        }
        $this->find($id)->delete();
    }*/


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu theo chuỗi danh sách id
    |--------------------------------------------------------------------------
    */
    /*public function DeleteMultiItem($listid){
        $ids = explode(",", $listid);
        foreach($ids as $i=>$id){
            $this->DeleteOneItem($id);
        }
    }*/


    /*
    |--------------------------------------------------------------------------
    | Xóa tạm 1 dòng dữ liệu theo id chính : sử dụng field xoatam trong db
    |--------------------------------------------------------------------------
    */
    /*public function DeleteTMPOneItem($id){
        $row = $this->GetOneItem($id);
        $path = Helper::GetFolder('product').$row['photo'];
        if (file_exists($path)) {
            @unlink($path);
        }
        $this->find($id)->SaveProduct(['xoatam'=>1],$id);
    }*/


    /*
    |--------------------------------------------------------------------------
    | Xóa tạm nhiều dòng dữ liệu theo chuỗi danh sách id
    |--------------------------------------------------------------------------
    */
    /*public function DeleteTMPMultiItem($listid){
        $ids = explode(",", $listid);
        foreach($ids as $i=>$id){
            $this->DeleteTMPOneItem($id);
        }
    }*/


    /*
    |--------------------------------------------------------------------------
    | Danh sách scope hỗ trợ cho truy vấn
    |--------------------------------------------------------------------------
    */
    public function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%".$value."%");
    }

    /*
    |--------------------------------------------------------------------------
    | scope
    |--------------------------------------------------------------------------
    */
    public function scopeHienthi($query,$val=1){
        return $query->where('hienthi', $val);
    }
}

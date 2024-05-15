<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;
    protected $table = "newsletter";
    protected $fillable = ["id", "tenvi", "taptin", "email", "dienthoai", "chude", "noidung", "ghichu", "diachi", "type", "hienthi", "ngaytao", "ngaysua", "stt", "chieucao", "cannang", "facebook", "tinhtrang", "created_at", "updated_at", "draft", "sl_options"];
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
    	$this->numberPerpage = config('config_all.numberperpage.newsletter');
    }

    

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    /*public function GetAllItems($type,$params){
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
    }*/

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type và điều kiện tìm kiếm để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    /*public function GetItemsBySearch($type,$keyword){
        return $this->where('type', $type)->hienthi()->like('ten', $keyword)->orderBy('stt', 'asc')->paginate($this->numberPerpage)->withQueryString();
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

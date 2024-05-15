<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danhgia extends Model
{
    use HasFactory;

    protected $table = "danhgia";
    //protected $fillable = ['tenvi', 'tenen', 'tenkhongdauvi', 'tenkhongdauen', 'motavi', 'motaen', 'noidungvi', 'noidungen', 'hienthi', 'stt', 'type', 'photo'];
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Mặc định số lượng dòng dữ liệu trên 1 trang
    |--------------------------------------------------------------------------
    */
    private $numberPerpage = 10;
    private $category = 'man';


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
    | RelationShip: Lấy tất cả dòng dữ liệu của product option relation với product theo id_product nhưng tạm thời bị xóa
    |--------------------------------------------------------------------------
    */
    public function HasProduct() {
        return $this->belongsTo('App\Models\Product','id_product')->where('hienthi',1);
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy ds relation ship của model
    |--------------------------------------------------------------------------
    */
    public function GetRelations(){
        return ['HasProduct'];
    }
    

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

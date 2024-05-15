<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = "setting";
    //protected $fillable = ['options','mastertool', 'headjs', 'bodyjs', 'tenvi', 'tenen', 'analytics', 'created_at', 'updated_at', 'titlevi', 'keywordsvi', 'descriptionvi', 'titleen', 'keywordsen', 'descriptionen', 'type', 'dateremovethumb', 'menu', 'fanpagejs', 'isSoluong', 'photo'];
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    /*public function GetItem($type='setting'){
        return $this->first()->toArray();
    }*/

    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật dữ liệu
    |--------------------------------------------------------------------------
    | Biến $data: Mảng dữ liệu đầu vào
    |--------------------------------------------------------------------------
    | Biến $id: Nếu có thì cập nhật theo id
    */
    /*public function SaveItem($data,$id='null'){
    	return $this->updateOrCreate(['id'=>$id], $data);
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

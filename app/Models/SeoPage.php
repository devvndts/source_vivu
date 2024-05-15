<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    use HasFactory;

    protected $table = "seopage";
    protected $guarded = [];

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
    | Lấy 1 dòng dữ liệu theo params truyền vào
    |--------------------------------------------------------------------------
    */
    /*public function GetItem($params){
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
    }*/

    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật dữ liệu
    |--------------------------------------------------------------------------
    | Biến $data: Mảng dữ liệu đầu vào
    |--------------------------------------------------------------------------
    | Biến $id: Nếu có thì cập nhật. Ngược lại thì tạo mới
    */
    /*public function SavePhoto($data,$id='null'){
        return $this->updateOrCreate(['id'=>$id], $data);
    }*/
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = "user_address";
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetAllItems($params){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        $run_sql = $run_sql->orderBy('stt', 'asc')->get();
        if($run_sql){
            return $run_sql->toArray();
        }
        return null;
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
    public function SaveItem($data,$id=null){
    	return $this->updateOrCreate(['id'=>$id], $data);
    }

    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật dữ liệu
    |--------------------------------------------------------------------------
    | Biến $data: Mảng dữ liệu đầu vào
    |--------------------------------------------------------------------------
    | Biến $id: Nếu có thì cập nhật. Ngược lại thì tạo mới
    */
    public function UpdateItemByParam($params=null,$data){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
    	return $run_sql->update($data);
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
}

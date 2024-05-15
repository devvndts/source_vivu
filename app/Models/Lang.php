<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Helper;

class Lang extends Model
{
    use HasFactory;
    protected $table = "lang";
    protected $fillable = ['lang', 'value', 'langvi', 'langen', 'giatri'];

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetAllItems($params=null,$paginate=false){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                if($k!='keyword' && $v>0){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='keyword'){
                    $run_sql=$run_sql->like('giatri', $v);
                }
            }
        }
        $run_sql = $run_sql->orderBy('id', 'desc');
        if(!$paginate){
            return $run_sql->get()->toArray();
        }
        return $run_sql = $run_sql->paginate($this->numberPerpage)->withQueryString();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - nhưng ngoại trừ id hiện tại
    |--------------------------------------------------------------------------
    */
    public function GetAllItemsExceptId($params,$paginate=false){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                if($k=='id'){
                    $run_sql=$run_sql->where($k,'<>',$v);
                }else{
                    $run_sql=$run_sql->where($k,$v);
                }
            }
        }
        $run_sql = $run_sql->orderBy('id', 'desc');
        if(!$paginate){
            return $run_sql->get()->toArray();
        }
        return $run_sql = $run_sql->paginate($this->numberPerpage)->withQueryString();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function CheckOneItemByParams($params){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        return ($run_sql->first()) ? $run_sql->first() : null;
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type và điều kiện tìm kiếm để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetItemsBySearch($keyword){
        return $this->like('giatri', $keyword)->orderBy('id', 'desc')->paginate($this->numberPerpage)->withQueryString();
    }

    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function GetOneItemByParams($params){
        $run_sql = $this;
    	if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k,$v);
            }
    		$run_sql =  $run_sql->first();
    	}
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
    public function SaveProduct($data,$id='null'){
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

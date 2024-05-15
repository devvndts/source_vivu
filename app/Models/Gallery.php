<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Helper;

class Gallery extends Model
{
    use HasFactory;
    protected $table = "gallery";
    protected $fillable = ['id_photo','id_photo_old','tenvi','tenen','motavi','motaen','id_mau','taptin','link_video','stt','type','com','kind','val','hienthi','ngaytao','ngaysua','photo','hash','id_color', 'folder'];


    /*
    |--------------------------------------------------------------------------
    | Đếm số dòng dữ liệu gallery
    |--------------------------------------------------------------------------
    */
    /*public function CountItems($type){
        return $this->where('type', $type)->get()->count();
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả các dòng dữ liệu theo id_photo và type tương ứng
    |--------------------------------------------------------------------------
    */
    /*public function GetAllGallery($type,$idphoto,$com='product'){ //GetAllItems
    	return $this->where('type', $type)->where('id_photo', $idphoto)->where('com', $com)->orderBy('stt', 'asc')->get()->toArray();
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
        //Helper::showSQL($run_sql);
        return $run_sql;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng theo id chính
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
    | Lấy 1 dòng dữ liệu theo mảng params (điều kiện truy vấn) truyền vào
    |--------------------------------------------------------------------------
    */
    /*public function GetItem($params){
        if($params){
            $run_sql = $this;
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
            $run_sql = $run_sql->first()->toArray();
            return $run_sql;
        }
        return null;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy nhiều dòng dữ liệu theo chuỗi danh sách id truyền vào
    |--------------------------------------------------------------------------
    */
    /*public function GetItemByListId($listid){
        if($listid){
            $ids = explode(",", $listid);
            return $this->whereIn('id', $ids)->get()->toArray();
        }
        return null;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lưu - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    /*public function SaveGallery($data,$id='null'){
    	$this->updateOrCreate(['id'=>$id], $data);
    }*/


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    | Trường hợp khi xóa trực tiếp trong trang chi tiết
    |
    */
    /*public function DeleteOneItem($id){
        $this->find($id)->delete();
    }*/


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu theo chuỗi danh sách id truyền vào
    |--------------------------------------------------------------------------
    | Trường hợp khi xóa trực tiếp trong trang chi tiết
    |
    */
    /*public function DeleteMultiItem($listid){
        $ids = explode(",", $listid);
        $this->whereIn('id', $ids)->delete();
    }*/


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu theo chuỗi danh sách id truyền vào
    |--------------------------------------------------------------------------
    | Trường hợp khi xóa 1 sản phẩm hay 1 bài viết
    |
    */
    /*public function DeleteGallery($id_photo,$kind,$type,$folder,$com){
        $gallery_items = $this->GetAllItems($type,$id_photo,$com);

        foreach($gallery_items as $k=>$v){
            $row = $this->GetOneItem($v['id']);
            $path = Helper::GetFolder($folder).$row['photo'];
            if (file_exists($path)) {
                @unlink($path);
            }
        }
        $this->where('id_photo', $id_photo)->where('kind', $kind)->where('type', $type)->delete();
    }*/


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu theo chuỗi danh sách id truyền vào
    |--------------------------------------------------------------------------
    | Trường hợp khi xóa nhiều sản phẩm hay nhiều bài viết
    |
    */
    /*public function DeleteMultiGallery($listid,$kind,$type,$folder,$com){
        $ids = explode(",", $listid);

        foreach($ids as $i=>$id_photo){
            $this->DeleteGallery($id_photo,$kind,$type,$folder,$com);
        }

        $this->whereIn('id_photo', $ids)->where('kind', $kind)->where('type', $type)->delete();
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

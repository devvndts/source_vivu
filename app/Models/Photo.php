<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Helper;

class Photo extends Model
{
    use HasFactory;

    protected $table = "photo";
    //protected $fillable = ['noibat','photo','tenkhongdauvi','tenkhongdauen','noidungvi','noidungen','motavi','motaen','tenvi','tenen','link','link_video','options','type','act','stt','hienthi','ngaytao','ngaysua',];
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
    | Dựa theo category để xác định loại photo sẽ thao tác
    |--------------------------------------------------------------------------
    | Số lượng dòng trên 1 trang sẽ được thay đổi theo cấu hình trong file config_all.numberperpages
    |
    */
    public function __construct(){
    	$this->numberPerpage = config('config_all.numberperpage.photo');
    }

    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    /*public function GetAllItems($type,$params=null,$paginate=false){
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
    | Lấy danh sách watermark
    |--------------------------------------------------------------------------
    */
    /*public function GetAllWatermark($params=null){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        $run_sql = $run_sql->where('options','<>',null)->hienthi()->orderBy('stt', 'asc');
        $result = $run_sql->get()->toArray();

        $arr_tmp = array();
        $upload_folder = config('config_upload.UPLOAD_PHOTO');

        foreach($result as $k=>$v){
            $arr_tmp[$v['type']]['position'] = json_decode($v['options'],true)['watermark']['position'];
            $arr_tmp[$v['type']]['photo'] = $upload_folder.$v['photo'];
            $arr_tmp[$v['type']]['name'] = $v['ngaytao'];
        }
        return $arr_tmp;
    }*/


    /*
    |--------------------------------------------------------------------------
    | Lấy watermark theo type
    |--------------------------------------------------------------------------
    */
    /*public function GetWatermark($params=null){
        $run_sql = $this;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        $run_sql = $run_sql->where('options','<>',null)->hienthi()->orderBy('stt', 'asc');
        $result = $run_sql->first()->toArray();

        $arr_tmp = array();
        $upload_folder = config('config_upload.UPLOAD_PHOTO');

        $arr_tmp[$result['type']]['position'] = json_decode($result['options'],true)['watermark']['position'];
        $arr_tmp[$result['type']]['photo'] = $upload_folder.$result['photo'];
        $arr_tmp[$result['type']]['name'] = $result['ngaytao'];
        return $arr_tmp;
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
    | Lấy 1 dòng dữ liệu theo params truyền vào
    |--------------------------------------------------------------------------
    */
    /*public function GetItem($params=null){
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
    | scope
    |--------------------------------------------------------------------------
    */
    public function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%".$value."%");
    }
    
    public function scopeHienthi($query,$val=1){
        return $query->where('hienthi', $val);
    }
}

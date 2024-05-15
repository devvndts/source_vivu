<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Helper;

class Order extends Model
{
    use HasFactory;

    protected $table = "order";
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
    | RelationShip: Lấy tất cả dòng dữ liệu của order_detail relation với order theo id_order
    |--------------------------------------------------------------------------
    */
    public function HasOrderDetailAll() {
        return $this->hasMany('App\Models\OrderDetail','id_order');
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetItem($params=null){
        $run_sql = $this->with('HasOrderDetailAll');
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
    | Lấy nhiều dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetItems($params=null){
        $run_sql = $this->with('HasOrderDetailAll');
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        $run_sql = $run_sql->get();
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
        //dd($params);
        $run_sql = $this->with('HasOrderDetailAll');
        if($params){
            $run_sql = (isset($params['tinhtrang']) && $params['tinhtrang']==5) ? $run_sql->hienthi() : $run_sql->hienthi();
            $param_not_search = array('keyword','ngaydat','khoanggia');
            foreach($params as $k=>$v){
                if(!in_array($k,$param_not_search) && $v>0){
                    $run_sql=$run_sql->where($k, $v);
                }
                if(!in_array($k,$param_not_search) && $k=='tinhtrang' && $v==5){
                    $run_sql=$run_sql->where($k, $v);
                    $run_sql=$run_sql->hienthi();
                }
                if($k=='keyword'){
                    $run_sql=$run_sql->like('hoten', $v);
                }
                if($k=='ngaydat' && $v!=''){
                    $arr_date = explode("|", $v);
                    if($arr_date[0]){
                        $run_sql=$run_sql->where('created_at', '>=', $arr_date[0]);
                    }
                    if($arr_date[1]){
                        $run_sql=$run_sql->where('created_at', '<=', $arr_date[1]);
                    }
                }
                if($k=='khoanggia' && $v!=''){
                    $arr_date = explode(";", $v);
                    if($arr_date[0]){
                        $run_sql=$run_sql->where('tonggia', '>=', $arr_date[0]);
                    }
                    if($arr_date[1]){
                        $run_sql=$run_sql->where('tonggia', '<=', $arr_date[1]);
                    }
                }
            }
        }
        $run_sql = $run_sql->orderBy('id', 'desc')->paginate($this->numberPerpage)->withQueryString();
        return $run_sql;
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo nhiều điều kiện
    |--------------------------------------------------------------------------
    */
    public function GetItemsCount($arr_params=null){
        $row = $this->addSelect([
            'id',
            //'allFull'=> $this->selectRaw('count(id)')->hienthi()->where('tinhtrang','<>',5)->where('tinhtrang','<>',7)->where('tinhtrang','<>',6),
            'allFull'=> $this->selectRaw('count(id)')->hienthi(),
            'sumFull'=> $this->selectRaw('sum(tonggia)')->hienthi()->where('tinhtrang','<>',5)->where('tinhtrang','<>',7)->where('tinhtrang','<>',6),
            'giamin'=> $this->selectRaw('min(tonggia)')->hienthi(),
            'giamax'=> $this->selectRaw('max(tonggia)')->hienthi(),
            'allMoidat'=> $this->selectRaw('count(id)')->hienthi()->where('tinhtrang',1),
            'sumMoidat'=> $this->selectRaw('sum(tonggia)')->hienthi()->where('tinhtrang',1),
            'allDaxacnhan'=> $this->selectRaw('count(id)')->hienthi()->where('tinhtrang',2),
            'sumDaxacnhan'=> $this->selectRaw('sum(tonggia)')->hienthi()->where('tinhtrang',2),
            'allDanggiao'=> $this->selectRaw('count(id)')->hienthi()->where('tinhtrang',3),
            'sumDanggiao'=> $this->selectRaw('sum(tonggia)')->hienthi()->where('tinhtrang',3),
            'allDangchuyenhoan'=> $this->selectRaw('count(id)')->hienthi()->where('tinhtrang',6),
            'sumDangchuyenhoan'=> $this->selectRaw('sum(tonggia)')->hienthi()->where('tinhtrang',6),
            'allDachuyenhoan'=> $this->selectRaw('count(id)')->hienthi()->where('tinhtrang',7),
            'sumDachuyenhoan'=> $this->selectRaw('sum(tonggia)')->hienthi()->where('tinhtrang',7),
            'allDagiao'=> $this->selectRaw('count(id)')->hienthi()->where('tinhtrang',4),
            'sumDagiao'=> $this->selectRaw('sum(tonggia)')->hienthi()->where('tinhtrang',4),
            'allDahuy'=> $this->selectRaw('count(id)')->hienthi()->where('tinhtrang',5),
            'sumDahuy'=> $this->selectRaw('sum(tonggia)')->hienthi()->where('tinhtrang',5),
        ])->hienthi()->first();

        return ($row) ? $row->toArray() : null;
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type và điều kiện tìm kiếm để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetItemsBySearch($keyword){
        return $this->hienthi()->like('hoten', $keyword)->orderBy('id', 'desc')->paginate($this->numberPerpage)->withQueryString();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function GetOneItem($id){
    	if($id){
    		$row = $this->with('HasOrderDetailAll')->where('id', $id)->first();
            if($row){
                return $row->toArray();
            }
            return null;
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
    | Xóa tạm 1 dòng dữ liệu theo id chính : sử dụng field xoatam trong db
    |--------------------------------------------------------------------------
    */
    public function DeleteTMPOneItem($id){
        $this->find($id)->SaveProduct(['hienthi'=>0],$id);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa tạm nhiều dòng dữ liệu theo chuỗi danh sách id
    |--------------------------------------------------------------------------
    */
    public function DeleteTMPMultiItem($listid){
        $ids = explode(",", $listid);
        foreach($ids as $i=>$id){
            $this->DeleteTMPOneItem($id);
        }
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

    public function scopeHienthi($query,$val=1){
        return $query->where('hienthi', $val);
    }
}

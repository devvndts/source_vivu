<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Helper;
class Webhook extends Model
{
    use HasFactory;
    protected $table = "trackvtp";
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
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetAllItemsByIdParent($idparent){
        $orderInfo = Order::where('id',$idparent)->first();
        $run_sql = $this;
        if ($orderInfo) {
            $orderInfo = $orderInfo->toArray();
            $run_sql=$run_sql->where('order_number', $orderInfo["mavandon"]);
            $run_sql = $run_sql->orderBy('order_statusdate', 'asc')->get()->toArray();
        }
        return $run_sql;
    }

}

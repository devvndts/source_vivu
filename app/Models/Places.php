<?php

namespace App\Models;

use App\Helpers\Helper as HelpersHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Helper;

class Places extends Model
{
    use HasFactory;
    protected $table = "";
    //protected $fillable = ['ten', 'tenen', 'tenkhongdauvi', 'tenkhongdauen', 'motavi', 'motaen', 'noidungvi', 'noidungen', 'hienthi', 'stt', 'type', 'photo'];
    protected $guarded = ['slugvi','slugen'];

    /*
    |--------------------------------------------------------------------------
    | Mặc định số lượng dòng dữ liệu trên 1 trang
    |--------------------------------------------------------------------------
    */
    private $numberPerpage = 30;

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    | Dựa theo category mà controller truyền vào để xác định model tương ứng .Sau đó mapping tới table trong database
    |--------------------------------------------------------------------------
    | Số lượng dòng trên 1 trang sẽ được thay đổi theo cấu hình trong file config_all.numberperpages
    |
    */
    public function __construct($category = null)
    {
        switch ($category) {
            case 'list':
                $this->table = 'city';
                break;
            case 'cat':
                $this->table = 'district';
                break;
            case 'item':
                $this->table = 'ward';
                break;
            case 'man':
                $this->table = 'street';
                break;
            default:
                break;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    public function province()
    {
        return $this->belongsTo(Province::class, config('vietnam-maps.columns.province_id'), 'id');
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
    
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetAllItems($params = null, $paginate = false)
    {
        $run_sql = $this;
        if ($params) {
            // $run_sql=$run_sql->hienthi();
            foreach ($params as $k => $v) {
                if ($k!='keyword' && $v>0) {
                    $run_sql=$run_sql->where($k, $v);
                }
                if ($k!='keyword' && $v == null) {
                    $run_sql=$run_sql->whereNull($k);
                }
                if ($k=='keyword') {
                    $run_sql=$run_sql->like('ten', $v);
                }
            }
        }
        $run_sql = $run_sql->orderBy('stt', 'asc');
        if (!$paginate) {
            return $run_sql->get()->toArray();
        }
        return $run_sql = $run_sql->paginate($this->numberPerpage)
        ->withQueryString();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type và điều kiện tìm kiếm để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetItemsBySearch($keyword)
    {
        return $this->hienthi()->like('ten', $keyword)->orderBy('stt', 'asc')->paginate($this->numberPerpage)->withQueryString();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function GetOneItem($id)
    {
        if ($id) {
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
    public function SaveProduct($data, $id = 'null')
    {
        return $this->updateOrCreate(['id'=> $id], $data);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu theo id chính
    |--------------------------------------------------------------------------
    */
    public function DeleteOneItem($id)
    {
        $row = $this->GetOneItem($id);
        $this->find($id)->delete();
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy nhiều dòng dữ liệu theo chuỗi danh sách id
    |--------------------------------------------------------------------------
    */
    public function DeleteMultiItem($listid)
    {
        $ids = explode(",", $listid);
        foreach ($ids as $i => $id_photo) {
            $this->DeleteOneItem($id_photo);
        }
        $this->whereIn('id', $ids)->delete();
    }


    /*
    |--------------------------------------------------------------------------
    | Danh sách scope hỗ trợ cho truy vấn
    |--------------------------------------------------------------------------
    */
    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%".$value."%");
    }

    public function scopeHienthi($query, $val = 1)
    {
        return $query->where('hienthi', $val);
    }
}

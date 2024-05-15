<?php

namespace App\Imports;

use App\Models\Lang;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Helper, CartHelper;

class LangImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function __construct() {
    	$this->model = new Lang();
    }

    public function headingRow() : int
    {
        return 1; //ko xét dòng tiêu đề của file (dòng 1)
    }

    public function collection(Collection $rows)
    {
        //### set lang
        $arr_lang = array();
        foreach(config('config_all.lang') as $k=>$v){
            $arr_lang[$k] = Helper::changeTitle($v,'_');
        }

        //### xử lý
        foreach ($rows as $row)
        {
            // ## Kiểm tra sản phẩm có tồn tại: nếu có thì cập nhật thông tin <> thêm mới
            $rowPro = $this->model->CheckOneItemByParams(['giatri'=>$row['tu_khoa']]);
            if($rowPro==null){ // thêm mới
                $id = null;
                $params['giatri'] = $row['tu_khoa'];
            }else{ // cập nhật
                $id = $rowPro->id;
            }
            foreach($arr_lang as $l=>$lang){
                if(isset($row[$lang])){$params['lang'.$l] = $row[$lang];}
            }
            $this->model->SaveProduct($params,$id);
        }
    }


    public function chunkSize(): int
    {
        return 1000;
    }
}

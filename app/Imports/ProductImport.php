<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductOption;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Helper, CartHelper;

class ProductImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function __construct($request) {
    	$this->model = new Product('man');
        $this->modelOption = new ProductOption();
        $this->type=$request->type;
    }


    public function headingRow() : int
    {
        return 1; //ko xét dòng tiêu đề của file (dòng 1)
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            // ## Kiểm tra sản phẩm có tồn tại: nếu có thì cập nhật thông tin <> thêm mới
            $rowPro = $this->model->CheckOneItemByParams(['masp'=>$row['ma_san_pham']]);
            if($row['ma_phien_ban'] == null){ // sản phẩm cha
                $params = array();
                if($rowPro==null){ // thêm mới
                    $id = null;
                    $params['masp'] = $row['ma_san_pham'];
                    $params['tenkhongdauvi'] = Helper::changeTitle($row['ten_san_pham']);
                }else{ // cập nhật
                    $id = $rowPro->id;
                }
                $params['tenvi'] = $row['ten_san_pham'];
                $params['giacu'] = $row['gia_cu'];
                $params['gia'] = $row['gia_ban'];
                $params['type'] = $this->type;
                $params['photo'] = $row['hinh_anh'];
                $params['titlevi'] = $row['title'];
                $params['keywordsvi'] = $row['keywords'];
                $params['descriptionvi'] = $row['description'];
                $params['hienthi'] = 1;
                $this->model->SaveProduct($params,$id);
            }else{ // sản phẩm phiên bản con
                if($rowPro!=null){
                    $canCreate = true;
                    $params = array();
                    $rowProOption = $this->modelOption->CheckOneItemByParams(['masp'=>$row['ma_phien_ban'],'id_product'=>$rowPro->id]);
                    if($rowProOption==null){ // thêm mới
                        $id = null;
                        $id_product = $rowPro->id;
                        $params['id_product'] = $id_product;
                        $params['masp'] = $row['ma_phien_ban'];
                        $params['tenkhongdauvi'] = Helper::changeTitle($row['ten_san_pham']);
                        $params['id_mau'] = ($row['mau']!='') ? CartHelper::get_mau_info_by_params(['tenvi'=>$row['mau']])['id'] : 0;
                        $params['id_size'] = ($row['size']!='') ? CartHelper::get_size_info_by_params(['tenvi'=>$row['size']])['id'] : 0;

                        // ## cập nhật size-mau cho sản phẩm cha
                        $params_Parent = array();
                        $arr_proSize = ($rowPro->id_size==0) ? array() : explode(",", $rowPro->id_size);
                        $arr_proMau = ($rowPro->id_mau==0) ? array() : explode(",", $rowPro->id_mau);

                        // ## check màu size có rỗng ?
                        if($row['mau'] =='' && $row['size'] =='' || $params['id_mau']==null || $params['id_size']==null){
                            $canCreate = false;
                        }else if(in_array($params['id_mau'], $arr_proMau) && in_array($params['id_size'], $arr_proSize)){
                            $canCreate = false;
                        }else if($row['mau']!='' && count($arr_proSize)>0 && $row['size'] ==''){
                            $canCreate = false;
                        }else if($row['size']!='' && count($arr_proMau)>0 && $row['mau'] ==''){
                            $canCreate = false;
                        }

                        //set id_mau cho product cha
                        $params_Parent['id_mau'] = ($rowPro->id_mau=='0')?'':$rowPro->id_mau;
                        if($params['id_mau']!=0 && !in_array($params['id_mau'], $arr_proMau)){
                            array_push($arr_proMau,$params['id_mau']);
                            $params_Parent['id_mau'] = implode(',',$arr_proMau);
                        }

                        //set id_size cho product cha
                        $params_Parent['id_size'] = ($rowPro->id_size=='0')?'':$rowPro->id_size;
                        if($params['id_size']!=0 && !in_array($params['id_size'], $arr_proSize)){
                            array_push($arr_proSize,$params['id_size']);
                            $params_Parent['id_size'] = implode(',',$arr_proSize);
                        }

                    }else{ // cập nhật
                        $id = $rowProOption->id;
                    }
                    $params['tenvi'] = $row['ten_san_pham'];
                    $params['giacu'] = $row['gia_cu'];
                    $params['gia'] = $row['gia_ban'];
                    $params['type'] = $this->type;
                    $params['photo'] = $row['hinh_anh'];
                    $params['titlevi'] = $row['title'];
                    $params['keywordsvi'] = $row['keywords'];
                    $params['descriptionvi'] = $row['description'];
                    $params['hienthi'] = 1;
                    if($canCreate){
                        $this->modelOption->SaveProduct($params,$id);
                        if(isset($id_product)){$this->model->SaveProduct($params_Parent,$id_product);}
                    }
                }
            }
        }
    }


    public function chunkSize(): int
    {
        return 1000;
    }
}

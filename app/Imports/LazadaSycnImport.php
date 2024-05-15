<?php

namespace App\Imports;

use App\Models\Lang;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Lazada\LazadaPlatformAPI;

use Helper, CartHelper;

class LazadaSycnImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function __construct() {
    	$this->product = Helper::Get_model('product');
        $this->productOpt = Helper::Get_model('productOption');
    }

    public function headingRow() : int
    {
        return 1; //ko xét dòng tiêu đề của file (dòng 1)
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if($row){
                $row = $row->toArray();

                // ## Kiểm tra sản phẩm có tồn tại: nếu có thì cập nhật thông tin <> thêm mới
                $table="product_option";
                $rowPro = $this->productOpt->GetItem(['masp'=>$row['ma_san_pham_website']]);
                if(!$rowPro){
                    $rowPro = $this->product->GetItem(['masp'=>$row['ma_san_pham_website']]);
                    $table="product";
                }

                if($rowPro){
                    $lazada_api = new LazadaPlatformAPI();
                    $row_lazada = $lazada_api->getDetailProduct_Lazada($row['ma_sellersku_lazada']);
                    $data_lazada = $row_lazada['data'];

                    $skus = $data_lazada['skus'][0];

                    $data['item_id_lazada'] = $data_lazada['item_id'];
                    $data['sku_lazada'] = $row['ma_sellersku_lazada'];
                    $data['soluong'] = $skus['quantity'];
                    $data['sku_id_lazada'] = $skus['SkuId'];

                    if($table=="product_option"){
                        $this->productOpt->SaveItem($data,$rowPro['id']);
                    }else{
                        $this->product->SaveItem($data,$rowPro['id']);
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

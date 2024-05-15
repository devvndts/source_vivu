<?php

namespace App\Imports;

use App\Models\Lang;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Illuminate\Support\Str;

use App\Lazada\LazadaPlatformAPI;

use Helper, CartHelper;

class LazadaInventoryImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function __construct($request) {
        $this->type = $request->type;
        $this->format = $request->format;
    	$this->product = Helper::Get_model('product');
        $this->productOpt = Helper::Get_model('productOption');
        $this->inventory = Helper::Get_model('inventory');
        $this->inventoryDetail = Helper::Get_model('inventory_detail');
    }

    public function headingRow() : int
    {
        return 1; //ko xét dòng tiêu đề của file (dòng 1)
    }

    public function collection(Collection $rows)
    {
        $arr_product = array();

        ///### Lưu lịch sử thông tin xuất nhập kho
        if($rows){
            //## Lưu phiếu nhập - xuất kho
            $random = Str::random(12);
            $data_inventory['maphieu'] = ($this->type=='nhapkho') ? 'PN_'.Str::upper($random) : 'PX_'.Str::upper($random);
            $data_inventory['type'] = $this->type;
            $data_inventory['type_format'] = $this->format;
            $data_inventory['ngaytao'] = time();
            $data_inventory['id_user'] = (Auth::guard('admin')->check()) ? Auth::guard('admin')->user()->id : 0;
            $row_inventory = $this->inventory->SaveItem($data_inventory);
        }


        foreach ($rows as $row)
        {
            if($row){
                $row = $row->toArray();
                
                $masp = $row['ma_san_pham_website'];
                $soluong_nhap_website = ($row['so_luong_website']) ? $row['so_luong_website'] : 0;
                $soluong_nhap_lazada = ($row['so_luong_lazada']) ? $row['so_luong_lazada'] : 0; //$row['so_luong_lazada'];
                $soluong_nhap_shopee = ($row['so_luong_shopee']) ? $row['so_luong_shopee'] : 0; //$row['so_luong_shopee'];

                // ## Kiểm tra sản phẩm có tồn tại: nếu có thì cập nhật thông tin <> thêm mới
                $table="product_option";
                $rowPro = $this->productOpt->GetItem(['masp'=>$masp]);
                if(!$rowPro){
                    $rowPro = $this->product->GetItem(['masp'=>$masp]);
                    $table="product";
                }

                if($rowPro){// && $rowPro['item_id_lazada']>0){
                    $soluong_hientai_website = $rowPro['soluong_website'];
                    $soluong_hientai_lazada = $rowPro['soluong_lazada'];
                    $soluong_hientai_shopee = $rowPro['soluong_shopee'];

                    //### lấy số lượng website
                    $soluong_website = $soluong_lazada = $soluong_shopee = 0;
                    if($this->type=='nhapkho'){
                        if($this->format=='add'){
                            $soluong_website = $soluong_hientai_website + $soluong_nhap_website;
                            $soluong_lazada = $soluong_hientai_lazada + $soluong_nhap_lazada;
                            $soluong_shopee = $soluong_hientai_shopee + $soluong_nhap_shopee;
                        }else{
                            $soluong_website = $soluong_nhap_website;
                            $soluong_lazada = $soluong_nhap_lazada;
                            $soluong_shopee = $soluong_nhap_shopee;
                        }
                    }else if($this->type=='xuatkho'){
                        if($this->format=='add'){
                            if($soluong_nhap_website < $soluong_hientai_website){
                                $soluong_website = $soluong_hientai_website - $soluong_nhap_website;
                            }
                            if($soluong_nhap_lazada < $soluong_hientai_lazada){
                                $soluong_lazada = $soluong_hientai_lazada - $soluong_nhap_lazada;
                            }
                            if($soluong_nhap_shopee < $soluong_hientai_shopee){
                                $soluong_shopee = $soluong_hientai_shopee - $soluong_nhap_shopee;
                            }
                        }
                    }

                    //### Cập nhật thông tin số lượng sản phẩm
                    $id = $rowPro['id'];
                    $data['soluong_website'] = $soluong_website;
                    $data['soluong_lazada'] = $soluong_lazada;
                    $data['soluong_shopee'] = $soluong_shopee;
                    $data['soluong'] = $soluong_website + $soluong_lazada + $soluong_shopee;

                    if($table=="product_option"){
                        $result = $this->productOpt->SaveItem($data,$id);
                    }else{
                        $result = $this->product->SaveItem($data,$id);
                    }

                    if($result){
                        $arr_product[] = $result->toArray();
                    }


                    ///### Lưu lịch sử thông tin xuất nhập kho
                    if(isset($row_inventory)){
                        //## Lưu chi tiết phiếu nhập - xuất kho
                        $data_inventory_detail['tenvi'] = ($this->type=='nhapkho') ? 'Phiếu nhập kho' : 'Phiếu xuất kho';
                        $data_inventory_detail['type'] = $this->type;
                        $data_inventory_detail['ngaytao'] = time();
                        $data_inventory_detail['id_product'] = $id;
                        $data_inventory_detail['id_inventory'] = $row_inventory->id;
                        $data_inventory_detail['table'] = $table;
                        $data_inventory_detail['soluongton_website'] = $soluong_hientai_website;
                        $data_inventory_detail['soluongnhap_website'] = $soluong_nhap_website;
                        $data_inventory_detail['soluongtoncuoi_website'] = $soluong_website;
                        $data_inventory_detail['soluongton_lazada'] = $soluong_hientai_lazada;
                        $data_inventory_detail['soluongnhap_lazada'] = $soluong_nhap_lazada;
                        $data_inventory_detail['soluongtoncuoi_lazada'] = $soluong_lazada;
                        $data_inventory_detail['soluongton_shopee'] = $soluong_hientai_shopee;
                        $data_inventory_detail['soluongnhap_shopee'] = $soluong_nhap_shopee;
                        $data_inventory_detail['soluongtoncuoi_shopee'] = $soluong_shopee;
                        $this->inventoryDetail->SaveItem($data_inventory_detail);
                    }
                }
            }
        } 

        ///### Đồng bộ cập nhật số lượng sản phẩm trên lazada
        if($arr_product && config('lazada')['excute']){
            $lazada_api = new LazadaPlatformAPI();
            $row_lazada = $lazada_api->updateQCProduct_Lazada($arr_product);
            //dd($row_lazada);
        }
    }


    public function chunkSize(): int
    {
        return 1000;
    }
}

<?php

namespace App\Exports;

use App\Models\Product;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Helper;
use CartHelper;

class ProductExport implements FromView, WithStyles, ShouldAutoSize
{
    public function __construct($params,$category) {
    	$this->params = $params;
        $this->category = $category;
    }


    /*
    |--------------------------------------------------------------------------
    | Tạo blade view dữ liệu để render từ html sang excel
    |--------------------------------------------------------------------------
    */
    public function view(): View
    {
        $product = new Product($this->category);

        foreach($this->params as $k=>$v){
            if($this->params['listid'] && $this->params['listid']!=''){
                $product = $product->whereIn('id',explode(",",$this->params['listid']));
            }else if($k=='keyword'){
                $product = $product->like('hoten',$v);
            }else if($k!='listid' && $k!='keyword' && $v!=''){
                $product = $product->where($k,$v);
            }
        }
        $product = $product->where('hienthi',1)->get();

        $arr_items = array();
        foreach($product as $k=>$v){
            $arr_items[$k] = $v->toArray();
            if($this->category=='man'){
                $arr_items[$k]['countVersion'] = $v->HasProductOptions->count();
                $arr_items[$k]['productDetail'] = $v->HasProductOptions->toArray();
            }
        }

        return view('admin.exports.product.man.all', [
            'products' => $arr_items
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Thiết lập thuộc tính cho file excel
    |--------------------------------------------------------------------------
    */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1   => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'A' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
            'B' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
            'C' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
            'D' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
            'E' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
            'F' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
            'G' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
            'H' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
            'J' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
            'K' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'left', 'wrapText' => true]],
        ];
    }
}

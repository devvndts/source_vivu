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

class LazadaSycnExport implements FromView, WithStyles, ShouldAutoSize
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
        return view('admin.exports.lazada.sycn');
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

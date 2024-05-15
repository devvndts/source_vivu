<?php

namespace App\Exports;

use App\Models\Lang;
//use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Helper;

class LangExport implements WithTitle, FromView, WithStyles, ShouldAutoSize
{
    public function __construct() {}

    /*
    |--------------------------------------------------------------------------
    | Tạo blade view dữ liệu để render từ html sang excel
    |--------------------------------------------------------------------------
    */
    public function view(): View
    {
        $lang = Lang::get()->toArray();

        return view('admin.exports.lang.all', [
            'lang' => $lang
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Thiết lập title cho mỗi sheet
    |--------------------------------------------------------------------------
    */
    public function title(): string
    {
        return 'Danh sách ngôn ngữ';
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
            'A' => ['alignment' => ['vertical' => 'center', 'wrapText' => true]],
            'B' => ['alignment' => ['vertical' => 'center', 'wrapText' => true]],
            'C' => ['alignment' => ['vertical' => 'center', 'wrapText' => true]],
        ];
    }
}

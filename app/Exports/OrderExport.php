<?php

namespace App\Exports;

use App\Models\Order;
//use Maatwebsite\Excel\Concerns\FromCollection;
//use Illuminate\Contracts\View\View;
//use Maatwebsite\Excel\Concerns\FromView;

/*use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;*/

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use Helper;

class OrderExport implements  WithMultipleSheets// FromView, WithStyles, ShouldAutoSize,
{
    use Exportable;

    protected $year;
    private $params;

    public function __construct($params,$year) {
    	$this->params = $params;
        $this->year = $year;
    }

    public function sheets(): array
    {
        $sheets = [];
        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new OrderPerMonthSheet($this->year, $month, $this->params);
        }

        return $sheets;
    }


    /*
    |--------------------------------------------------------------------------
    | Tạo blade view dữ liệu để render từ html sang excel
    |--------------------------------------------------------------------------
    */
    /*public function view(): View
    {
        $order = new Order();

        foreach($this->params as $k=>$v){
            if($this->params['listid'] && $this->params['listid']!=''){
                $order = $order->whereIn('id',explode(",",$this->params['listid']));
            }else if($k=='keyword'){
                $order = $order->like('hoten',$v);
            }else if($k!='listid' && $k!='keyword' && $v!=''){
                $order = $order->where($k,$v);
            }
        }
        $order = $order->where('hienthi',1)->orderBy('ngaytao', 'desc')->get();

        $arr_order = array();
        foreach($order as $k=>$v){
            $arr_order[$k] = $v->toArray();
            $arr_order[$k]['rowspan'] = $v->HasOrderDetailAll->count();
            $arr_order[$k]['orderDetail'] = $v->HasOrderDetailAll->toArray();
        }

        return view('admin.exports.order.all', [
            'orders' => $arr_order
        ]);
    }*/


    /*
    |--------------------------------------------------------------------------
    | Thiết lập thuộc tính cho file excel
    |--------------------------------------------------------------------------
    */
    /*public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1   => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'A' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'B' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'C' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'D' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'E' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'F' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'G' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'H' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'J' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'K' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'I' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'L' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'M' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'N' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
            'O' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center', 'wrapText' => true]],
        ];
    }*/
}

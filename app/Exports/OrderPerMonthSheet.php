<?php

namespace App\Exports;

use App\Models\Order;
//use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Helper;

class OrderPerMonthSheet implements  WithTitle, ShouldAutoSize, WithStyles ,FromView
{
    private $month;
    private $year;
    private $params;

    public function __construct(int $year, int $month, $params)
    {
        $this->month = $month;
        $this->year  = $year;
        $this->params = $params;
    }

    /*
    |--------------------------------------------------------------------------
    | Tạo blade view dữ liệu để render từ html sang excel
    |--------------------------------------------------------------------------
    */
    public function view(): View
    {
        $order = new Order();
        $order = ($this->params['tinhtrang'] && $this->params['tinhtrang']==5) ? $order->where('hienthi', 0) : $order->where('hienthi', 1);
        $param_not_search = array('keyword','ngaydat','khoanggia','listid');
        foreach($this->params as $k=>$v){
            if($this->params['listid'] && $this->params['listid']!=''){
                $order = $order->whereIn('id',explode(",",$this->params['listid']));
            }else if($k=='keyword'){
                $order = $order->like('hoten',$v);
            }else if(!in_array($k,$param_not_search) && $v!=''){
                $order = $order->where($k,$v);
            }else if($k=='ngaydat' && $v!=''){
                $arr_date = explode("|", $v);
                if($arr_date[0] && $arr_date[1]){
                    $order = $order->whereBetween('created_at', [$arr_date[0], $arr_date[1]]);
                }
            }else if($k=='khoanggia' && $v!=''){
                $arr_date = explode(";", $v);
                if($arr_date[0]){
                    $order=$order->where('tonggia', '>=', $arr_date[0]);
                }
                if($arr_date[1]){
                    $order=$order->where('tonggia', '<=', $arr_date[1]);
                }
            }
        }
        $order = $order->whereYear('created_at', $this->year)->whereMonth('created_at', $this->month)->where('hienthi',1)->orderBy('ngaytao', 'desc')->get();

        $arr_order = array();
        foreach($order as $k=>$v){
            $arr_order[$k] = $v->toArray();
            $arr_order[$k]['rowspan'] = $v->HasOrderDetailAll->count();
            $arr_order[$k]['orderDetail'] = $v->HasOrderDetailAll->toArray();
        }

        return view('admin.exports.order.all', [
            'orders' => $arr_order
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Thiết lập title cho mỗi sheet
    |--------------------------------------------------------------------------
    */
    public function title(): string
    {
        return 'Tháng: ' . $this->month;
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
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Counter;
use App\Models\Order;
use Helper;
//use Cookie;

//use Models\Counter;

class DashboardController extends Controller
{
    //
    private $config, $model, $viewShow, $viewEdit, $type;
    private $routeShow = 'admin.dashboard';


    public function Index(Request $request){
        //### Code xử lý
        $counter = new Counter();
        $order = new Order();

        //dd($this->lazada_api->getListProduct_Lazada());

        if((isset($request->month) && $request->month != '') && (isset($request->year) && $request->year != ''))
        {
            $time = $request->year.'-'.$request->month.'-1';
            $date = strtotime($time);
        }
        else
        {
            $date = strtotime(date('y-m-d'));
        }

        $day = date('d', $date);
        $month = date('m', $date);
        $year = date('Y', $date);
        $firstDay = mktime(0,0,0,$month, 1, $year);
        $title = strftime('%B', $firstDay);
        $dayOfWeek = date('D', $firstDay);
        $daysInMonth = cal_days_in_month(0, $month, $year);

        //### tạo chartjs
        $arr_daysInmonth = array();
        $arr_values = $arr_order = array();

        for($i=1;$i<=$daysInMonth;$i++){
            //### xử lý mảng thống kê truy cập
            array_push($arr_daysInmonth,'D'.$i);
            $k = $i+1;
            $begin = strtotime($year.'-'.$month.'-'.$i);
            $end = strtotime($year.'-'.$month.'-'.$k);
            $todayrc = $counter->select('id')->where('tm','>=',$begin)->where('tm','<',$end)->get();
            if($todayrc){
                array_push($arr_values,$todayrc->count());
            }

            //### xử lý mảng thống kê đơn hàng
            $today_order = $order->select('id')->where('ngaytao','>=',$begin)->where('ngaytao','<',$end)->get();
            if($today_order){
                array_push($arr_order,$today_order->count());
            }
        }  

        //### response chart truy cập
        $chart = app()->chartjs
            ->name('lineChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 150])
            ->labels($arr_daysInmonth)
            ->datasets([
                [
                    "label" => $title,
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $arr_values,
                ]
            ]);

        $chart->options([
            'legend' => [
                'display' => false,
                'labels' => [
                    'fontColor' => '#000'
                ]
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'stacked' => true,
                        'gridLines' => [
                            'display' => false
                        ]
                    ]
                ]
            ]
        ]);


        //### response chart truy cập
        $chart_order = app()->chartjs
            ->name('lineChartOrder')
            ->type('line')
            ->size(['width' => 400, 'height' => 150])
            ->labels($arr_daysInmonth)
            ->datasets([
                [
                    "label" => $title,
                    'backgroundColor' => "rgba(12, 83, 183, 0.31)",
                    'borderColor' => "rgba(12, 83, 183, 0.7)",
                    "pointBorderColor" => "rgba(12, 83, 183, 0.7)",
                    "pointBackgroundColor" => "rgba(12, 83, 183, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $arr_order,
                ]
            ]);

        $chart_order->options([
            'legend' => [
                'display' => false,
                'labels' => [
                    'fontColor' => '#000'
                ]
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'stacked' => true,
                        'gridLines' => [
                            'display' => false
                        ]
                    ]
                ]
            ]
        ]);

        //### Trả về giao diện
        $response = array(
            'month'=>$month,
            'year'=>$year,
            'daysInMonth'=>$daysInMonth,
            'type'=>'',
            'request'=>$request,
            'chart' => $chart,
            'chart_order' => $chart_order
        );

    	return view('admin.templates.dashboard')->with($response);
    }

}

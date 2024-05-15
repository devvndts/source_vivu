<table>
    <thead>
        <tr>
            <th>Mã Đơn Hàng</th>
            <th>Họ Tên</th>
            <th>Điện thoại</th>
            <th>Địa Chỉ</th>
            <th>Email</th>
            <th>Sản Phẩm</th>
            <th>Mã Sản Phẩm</th>
            <th>Đơn Giá</th>
            <th>Số Lượng</th>
            <th>Thành Tiền</th>
            <th>Tạm tính</th>
            <th>Giảm Giá</th>
            <th>Phí Ship</th>
            <th>Tổng Giá</th>
            <th>Ngày Tạo</th>
        </tr>
    </thead>

    <tbody>
    @foreach($orders as $o=>$order)
        @foreach($order['orderDetail'] as $od=>$orderDetail)
            <tr class="export_table">
                @if($od==0)
                <td style="display:table-cell" rowspan="{{$order['rowspan']}}">{{ $order['madonhang'] }}</td>
                <td rowspan="{{$order['rowspan']}}">{{ $order['hoten'] }}</td>
                <td rowspan="{{$order['rowspan']}}">{{ $order['dienthoai'] }}</td>
                <td rowspan="{{$order['rowspan']}}">{{ $order['diachi'] }}</td>
                <td rowspan="{{$order['rowspan']}}">{{ $order['email'] }}</td>
                @endif

                <td>{{$orderDetail['ten']}}</td>
                <td>{{$orderDetail['masp']}}</td>
                <td>{{Helper::Format_Money($orderDetail['gia'])}}</td>
                <td>{{$orderDetail['soluong']}}</td>
                <td>{{Helper::Format_Money($orderDetail['soluong']*$orderDetail['gia'])}}</td>

                @if($od==0)
                <td rowspan="{{$order['rowspan']}}">{{ Helper::Format_Money($order['tamtinh']) }}</td>
                <td rowspan="{{$order['rowspan']}}">{{ Helper::Format_Money($order['giamgia']) }}</td>
                <td rowspan="{{$order['rowspan']}}">{{ Helper::Format_Money($order['phiship']) }}</td>
                <td rowspan="{{$order['rowspan']}}">{{ Helper::Format_Money($order['tonggia']) }}</td>
                <td rowspan="{{$order['rowspan']}}">{{ date('h:i d-m-Y',$order['ngaytao']) }}</td>
                @endif
            </tr>
        @endforeach
    @endforeach
            {{--<tr>
                <td style="color:red;font-weight:bold;"><b>Tổng tiền</b></td>
                <td style="color:red;font-weight:bold;" colspan="14"><b>{{$orders[0]['sumTonggia']}}</b></td>
            </tr>--}}
    </tbody>
</table>


<?php /*

<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
border: 1px solid black;
}
</style>
</head>
<body>

<h1>The td rowspan attribute</h1>

<table>
<thead>
<tr>
  <th>Mã Đơn Hàng</th>
  <th>Họ Tên</th>
  <th>Điện thoại</th>
  <th>Sản Phẩm</th>
  <th>Mã Sản Phẩm</th>
  <th>Đơn Giá</th>
  <th>Số Lượng</th>
  <th>Thành Tiền</th>
  <th>Tạm tính</th>
  <th>Giảm Giá</th>
  <th>Phí Ship</th>
  <th>Tổng Giá</th>
  <th>Ngày Tạo</th>
</tr>
</thead>

<tbody>
<tr>
  <td rowspan="2">DH1093783</td>
  <td rowspan="2">Bình</td>
  <td rowspan="2">0587287978</td>
  <td>Sản phẩm abc</td>
  <td>code 1039</td>
  <td>50000</td>
  <td>1</td>
  <td>50000</td>
  <td rowspan="2">50000</td>
  <td rowspan="2">0</td>
  <td rowspan="2">0</td>
  <td rowspan="2">50000</td>
  <td rowspan="2">01/06/202</td>
</tr>
<tr>
  <td>February</td>
  <td>DOPE</td>
  <td>80000</td>
  <td>2</td>
  <td>160000</td>
</tr>
<tr>
  <td rowspan="2">DH1093783</td>
  <td rowspan="2">Bình</td>
  <td rowspan="2">0587287978</td>
  <td>February</td>
  <td>80</td>
  <td>50000</td>
  <td>2</td>
  <td>100000</td>
  <td rowspan="2">50000</td>
  <td rowspan="2">0</td>
  <td rowspan="2">0</td>
  <td rowspan="2">50000</td>
  <td rowspan="2">01/06/202</td>
</tr>
</tbody>
</table>

</body>
</html>


*/ ?>

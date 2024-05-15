@extends('desktop.master')

@section('content')

<div class="center-layout py-4 bortop padlr">
	<div class="bg-white rounded">
		@if(!isset($background_category))<h2 class="home-title"><span>{{$title_crumb.' ['.$keyword.']'}}</span></h2>@endif
	</div>
	@php
// 	"1. Cho phép khách hàng tra cứu đơn hàng bằng sđt hoặc mã đơn để kiểm tra quá trình sản xuất và giao hàng. Đơn vị quan lí website sẽ tự cập nhật tiến độ trên hệ thống
// 2. Nội dung hiển thị phần tra cứu bao gồm: Tên khách hàng, Thông tin đơn hàng( ngày đặt hàng, thông tin sản phẩm đặt, số lượng đặt, ngày giao, cập nhật tiến độ thực hiện, giá trị đơn hàng, hình ảnh sản phẩm theo đơn hàng, địa chỉ nhận hàng)"

	@endphp
	<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
		<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
			<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
				<tr>
					<th scope="col" class="px-6 py-3">
						Mã đơn
					</th>
					<th scope="col" class="px-6 py-3">
						Thông tin khách hàng
					</th>
					<th scope="col" class="px-6 py-3">
						Sản phẩm
					</th>
					<th scope="col" class="px-6 py-3">
						Số lương
					</th>
					<th scope="col" class="px-6 py-3">
						Giá
					</th>
					<th scope="col" class="px-6 py-3">
						Ngày dat
					</th>
					<th scope="col" class="px-6 py-3">
						Ngày giao
					</th>
					<th scope="col" class="px-6 py-3">
						Tình trạng
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($posts as $item)
				<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
					
					@php
						if ($item["sl_options"]) {
							$opt = Helper::JsonDecode($item["sl_options"]);
						}
						$code = @$item["tenvi"];
						$name = @$opt["hoten"];
						$phone = @$item["masp"];
						$address = @$opt["diachi"];
						$productInfo = @$opt["thongtinsanpham"];
						$quantity = @$opt["soluong"];
						$price = @$opt["tong"];
						$bookDate = @$opt["ngaydat"];
						$deliveryDate = @$opt["ngaygiao"];
						$status = @$opt["tinhtrang"];
					@endphp
					
					<th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
						{{ $code }}
					</th>
					<td class="px-6 py-4">
						<p><i class="far fa-address-card mr-1 text-black"></i>{{ $name }}</p>
						<p><i class="fas fa-phone-alt mr-1 text-black"></i>{{ $phone }}</p>
						<p><i class="far fa-map-marker-alt mr-1 text-black"></i>{{ $address }}</p>
					</td>
					<td class="px-6 py-4">
						{{ $productInfo }}
					</td>
					<td class="px-6 py-4">
						{{ $quantity }}
					</td>
					<td class="px-6 py-4">
						{{ $price }}
					</td>
					<td class="px-6 py-4">
						{{ $bookDate }}
					</td>
					<td class="px-6 py-4">
						{{ $deliveryDate }}
					</td>
					<td class="px-6 py-4 text-right">
						{{ $status }}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<!--HỎI ĐÁP-->
{{--
@include('desktop.layouts.hoidap')
--}}

@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')

@endpush

@push('strucdata')
@endpush
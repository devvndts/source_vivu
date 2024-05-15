@php
	use App\Helpers\Form as FormTemplate;
	$formLabelAttr = config('zvn.template.form_label.class');
	$formInputAttr = config('zvn.template.form_input.class');
    // $products = get_products('product', 'vi', null);
@endphp
@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{route('admin.sale.save',['man',$type])}}" enctype="multipart/form-data">
	@csrf
    <div class="text-sm card-footer sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="mr-2 far fa-save"></i>{{ __('Lưu') }}</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="mr-2 fas fa-redo"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="{{route('admin.coupon.show',['man',$type])}}" title="Thoát"><i class="mr-2 fas fa-sign-out-alt"></i>Thoát</a>
    </div>
    <div class="text-sm card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Thông tin</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="ngaybatdau">Thời gian kết thúc:</label>
                    <div class="input-group">
                        <input class="form-control" type="datetime-local" name="data[sale_date]" id="sale_date" placeholder="Thời gian kết thúc" value="{{ Carbon\Carbon::parse($rowItem["sale_date"]) }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="hienthi" class="mb-0 mr-2 align-middle d-inline-block">Hiển thị:</label>
				<div class="align-middle custom-control custom-checkbox d-inline-block">
					@if(@$rowItem['hienthi']==1 || !isset($rowItem))
					<input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" checked>
					@else
					<input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox">
					@endif
					<label for="hienthi-checkbox" class="custom-control-label"></label>
				</div>
            </div>
            <span class="btn-add-property" data-typeprop="size" data-type="product" data-toggle="modal" data-target="#modal_property_size" data-showelement="#show_addSize">Thêm sản phẩm </span>
        </div>
    </div>
    <input type="hidden" name="id" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
    @isset ($saleProducts)
    <table class="table table-hover text-nowrap miko-products">
        <thead>
            <tr>
                <th class="text-center align-middle">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="checkAllProduct">
                        <label for="checkAllProduct"></label>
                    </div>
                </th>
                <th>Sản phẩm</th>
                <th class="text-center">Giá</th>
                <th class="text-center">Giá sau giảm</th>
                <th class="text-center">Chiết khấu</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($saleProducts as $k => $v)
            @php
                $item_id = $v->id;
                $item_gia = $v->gia;
                $item_tenvi = $v->tenvi;
                $item_photo = $v->photo;
                $item_masp = $v->masp;
                $item_sale_product_giamoi = $v->sale_giamoi;
                $item_sale_product_giakm = $v->sale_giakm;
                $item_sale_product_id = $v->sale_product_id;
                $saleProductOptions = DB::table('product_option')
                    ->where('id_product', $item_id)
                    ->where('phienbanmau', 0)
                    ->select('*')
                    ->get();
            @endphp
                <tr data-id="{{ $item_sale_product_id }}" data-gia="{{ $item_gia }}">
                    <input type="hidden" name="idgoi[]" value="{{ $item_id }}" />
                    <td class="text-center align-middle dev-item-checkbox">
                        <div class="icheck-primary d-inline dev-check">
                            <input type="checkbox" class="product-checkbox"
                                id="checkItem2-{{ $item_id }}" value="{{ $item_id }}">
                            <label for="checkItem2-{{ $item_id }}"></label>
                        </div>
                    </td>
                    <td class="">
                        <div class="text-info" >
                            <b>{{ $item_tenvi }}</b>
                        </div>
                        <div>{{ $item_masp }}</div>
                    </td>
                    <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format($item_gia, 0, ',', '.') }}đ</span></td>
                    <td class="text-center">
                        <input type="text" name="giamoigoi[]" value="{{ $item_sale_product_giamoi }}" class="form-control format-price giamoi_goi">
                    </td>
                    <td class="text-center">
                        
                        <div class="input-group">
                            <input type="text" name="giakmgoi[]" value="{{ $item_sale_product_giakm }}"  class="form-control giakm_goi" readonly="">
                            <div class="input-group-append">
                                <div class="input-group-text"><strong>%</strong></div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-sm d-block delete-item btn-none-css" data-url="{{route('admin.sale.delete-product',['man',$type,$item_sale_product_id])}}" title="Xóa"><i class="fas fa-trash-alt mr-2"></i> Xóa</a>
                    </td>
                </tr>
                @foreach ($saleProductOptions as $item)
                @php
                    $item_id = $item->id;
                    $item_gia = $item->gia;
                    $item_tenvi = $item->tenvi;
                    $item_photo = $item->photo;
                    $item_masp = $item->masp;
                    $item_sale_product_giamoi = $item->sale_giamoi;
                    $item_sale_product_giakm = $item->sale_giakm;
                    $item_sale_product_id = $item_id;
                @endphp
                <tr data-id="{{ $item_id }}" data-gia="{{ $item_gia }}">
                    <input type="hidden" name="idgoi2[]" value="{{ $item_sale_product_id }}" />
                    <td class="text-center align-middle dev-item-checkbox">
                        <div class="icheck-primary d-inline dev-check">
                            <input type="checkbox" class="product-checkbox"
                                id="checkItem2-{{ $item_id }}" value="{{ $item_id }}">
                            <label for="checkItem2-{{ $item_id }}"></label>
                        </div>
                    </td>
                    <td class="">
                        <div class="text-info pl-5" >
                            <b>{{ $item_tenvi }}</b>
                        </div>
                        <div class="pl-5" >{{ $item_masp }}</div>
                    </td>
                    <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format($item_gia, 0, ',', '.') }}đ</span></td>
                    <td class="text-center">
                        <input type="text" name="giamoigoi2[]" value="{{ $item_sale_product_giamoi }}" class="form-control format-price giamoi_goi">
                    </td>
                    <td class="text-center">
                        
                        <div class="input-group">
                            <input type="text" name="giakmgoi2[]" value="{{ $item_sale_product_giakm }}"  class="form-control giakm_goi" readonly="">
                            <div class="input-group-append">
                                <div class="input-group-text"><strong>%</strong></div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @endisset
</form>
@include('admin.layouts.add_sale_products')
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
	<script type="text/javascript">
        function roundNumber(rnum, rlength)
        {
            return Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
        }
		$(document).ready(function(){
			$(".giamoi_goi").keyup(function(){
                var parent = $(this).parents('tr');
                var gia_cu = parent.data('gia');
                var gia_ban = $(this).val();
                var gia_km = 0;
                if(gia_cu=='' || gia_cu=='0' || gia_ban=='' || gia_ban=='0')
                {
                    gia_km=0;
                }
                else
                {
                //     gia_cu = gia_cu.replace(/,/g,"");
                    gia_ban = gia_ban.replace(/,/g,"");
                //     gia_cu = parseInt(gia_cu);
                    gia_ban = parseInt(gia_ban);
                    if(gia_ban < gia_cu)
                    {
                        gia_km = 100-((gia_ban * 100) / gia_cu);
                        gia_km = roundNumber(gia_km,0);                         
                    }
                    else
                    {
                        gia_km=0;
                    }
                }
                // console.log(gia_ban);
                parent.find('.giakm_goi').val(gia_km);
            })
		})
	</script>
@endsection

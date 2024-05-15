@extends('admin.master')

@section('content')
<form class="validation-form createCartForm js-submit-watting" novalidate method="post" action="{{ route('admin.order.savecreate',['man']) }}" enctype="multipart/form-data">
    @csrf
    <div class="card-footer text-sm sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary" disabled><i class="far fa-save mr-2"></i>Lưu</button>
        <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        <a class="btn btn-sm bg-gradient-danger" href="{{ route('admin.order.show',['man']) }}" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Thông tin chính</h3>
                </div>
                <div class="card-body row">
                    <div class="form-group col-12">
                        <div class="row">
                            {{--
                            <div class="form-group col-md-4 col-sm-6">
                                <label class="d-block" for="id_user">Chọn tài khoản:</label>
                                <select name="data[id_user]" id="id_user" class="select2 form-control">
                                    <option value="0">Chọn tài khoản khách hàng</option>
                                    @foreach ($member as $key => $value) {?>
                                        <option value="{{$value['id']}}">{{$value['ten']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            --}}

                            <div class="form-group col-md-3 col-sm-6">
                                <label class="d-block" for="id_list">Kênh bán hàng:</label>
                                <select name="data[channel]" id="channel" class="select2 form-control">
                                    @foreach(config('config_all.channel') as $k => $v){?>
        	                        	@if($v['active']==true)<option {{$request->channel==$k ? 'selected':''}} value="{{$k}}">{{$v['name']}}</option>@endif
        	                        @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3 col-sm-6">
                                <label class="d-block" for="id_list">Mã đơn hàng:</label>
                                <input type="text" class="form-control" id="madonhang" name="data[madonhang]" value="{{ date('ymd').strtoupper(Helper::stringRandom(6)) }}" required readonly />
                            </div>

                            <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 form-order-category">
                                <label class="d-block" for="id_category">Danh mục:</label>
                                @include('admin.layouts.category')
                            </div>

                            <div class="form-group col-md-4 col-sm-4">
                                <label class="d-block" for="id_product">Danh sách sản phẩm</label>
                                <select name="id_product" id="id_product" data-model="productOption" data-level="man" data-type="product" class="select2 form-control select_order_product">
                                    <option value="0">Chọn sản phẩm</option>
                                </select>
                                <div class="id_product_error text-danger"></div>
                            </div>

                            <div class="form-group col-md-8 col-sm-12 load_detail" style="margin-bottom: 0;"></div>
                            <div class="form-group col-md-12 col-sm-12 " >
                                <button type="button" class="btn btn-sm bg-gradient-success add_to_cart"><i class="fas fa-cart-arrow-down"></i> Thêm vào giỏ hàng</button>
                            </div>
                            <div class="form-group col-md-4 col-sm-6">
                                <label class="d-block" for="id_list">Phí giao hàng:</label>
                                <input type="text" class="form-control format-price" id="phiship" name="data[phiship]" placeholder="Nhập phí ship" value="" required />
                            </div>
                            <div class="form-group col-md-4 col-sm-6">
                                <label class="d-block" for="id_list">Khuyến mãi:</label>
                                <input type="text" class="form-control format-price" id="giamgia" name="data[giamgia]" placeholder="Nhập số tiền giảm giá" value="" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline text-sm">
        <div class="wrap-cart d-flex align-items-stretch justify-content-between">
            <div class="top-cart">
                <p class="title-cart">Giỏ hàng Hiện tại:</p>
                <div class="list-procart">
                    <div class="procart procart-label d-flex align-items-start justify-content-between">
                        <div class="pic-procart">Hình ảnh</div>
                        <div class="info-procart">Tên sản phẩm</div>
                        <div class="quantity-procart">
                            <p>Số lượng</p>
                            <p>Thành tiền</p>
                        </div>
                        <div class="price-procart">Thành tiền</div>
                    </div>
                    <div class="list-procart-info">
                    </div>
                </div>
            </div>
            <div class="bottom-cart">
                <div class="section-cart">
                    <p class="title-cart">Hình thức thanh toán:</p>
                    <div class="information-cart">
                        @if(config('config_all.payment_method') && config('config_all.payment_deffine')==true)
                            @foreach(config('config_all.payment_method') as $k=>$v)
                                <div class="payments-cart custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="payments-{{$k}}" name="data[httt]" value="{{$k}}" {{($k==1)?'checked':''}}>
                                    <label class="payments-label custom-control-label" for="payments-{{$k}}" data-payments="{{$k}}">{{$v['name']}}</label>
                                </div>
                            @endforeach
                        @else
                            @foreach($hinhthucthanhtoan as $k=>$v)
                                <div class="payments-cart custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="payments-{{$k}}" name="data[httt]" value="{{$k}}" {{($k==1)?'checked':''}}>
                                    <label class="payments-label custom-control-label" for="payments-{{$k}}" data-payments="{{$k}}">{{$v['ten'.$lang]}}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-4">
                        <div class="p-relative">
                            <p class="title-cart">Thông tin giỏ hàng:</p>
                        </div>
                        <div class="information-cart">
                            <div class="input-cart">
                                <input type="text" class="form-control js-autocomplete" id="dienthoai" name="data[dienthoai]" placeholder="Nhập số điện thoại" value="" required />
                                <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                            </div>
                            <div class="input-cart">
                                <input type="text" class="form-control" id="ten" name="data[hoten]" placeholder="Họ tên người nhận" value="" required />
                                <div class="invalid-feedback">Vui lòng nhập họ tên</div>
                            </div>
                            <div class="input-cart">
                                <input type="email" class="form-control" id="email" name="data[email]" placeholder="Email" value="" required />
                                <div class="invalid-feedback">Vui lòng nhập email</div>
                            </div>
                            <div class="input-cart">
                                {!! Helper::get_ajax_places("places", "places", "list", null, '', 'required', 'Chọn tỉnh thành') !!}
                                <div class="invalid-feedback">Vui lòng chọn tỉnh thành</div>
                            </div>
                            <div class="input-cart">
                                {!! Helper::get_ajax_places("places", "places", "cat", null, '', 'required', 'Chọn quận huyện') !!}
                                <div class="invalid-feedback">Vui lòng chọn quận huyện</div>
                            </div>
                            <div class="input-cart">
                                {!! Helper::get_ajax_places("places", "places", "item", null, '', 'required', 'Chọn phường xã') !!}
                                <div class="invalid-feedback">Vui lòng chọn phường/xã</div>
                            </div>
                            <div class="input-cart">
                                <input type="text" class="form-control" id="diachi" name="data[diachi]" placeholder="Số nhà, Đường, Xóm, Ấp, Thôn,..."  value="" required />
                                <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
                            </div>
                            <div class="input-cart">
                                <textarea class="form-control" id="yeucaukhac" name="data[yeucaukhac]" placeholder="Yêu cầu khác của khách (Không bắt buộc)" /></textarea>
                            </div>
                        </div>
                    </div>
                    <p class="title-cart">Giá trị đơn hàng:</p>
                    <div class="money-procart mt-0">
                        <div class="total-procart font-weight-bold d-flex align-items-center justify-content-between">
                            <span>Tạm tính:</span>
                            <span class="total-price load-price-temp">0đ</span>
                        </div>
                        <div class="total-procart font-weight-bold d-flex align-items-center justify-content-between">
                            <span>Phí vận chuyển:</span>
                            <span class="total-price load-price-ship">0đ</span>
                        </div>
                        <div class="total-procart font-weight-bold d-flex align-items-center justify-content-between discount_temp d-none">
                            <span>Giảm giá:</span>
                            <span class="total-price load-price-discount">0đ</span>
                        </div>
                        <div class="total-procart font-weight-bold d-flex align-items-center justify-content-between">
                            <span>Thành tiền:</span>
                            <span class="total-price load-price-total fs-20">0đ</span>
                        </div>
                        <input type="hidden" class="tamtinh_tt" name="data[tamtinh]" value="0">
                        <input type="hidden" class="tonggia_tt" name="data[tonggia]" value="0">
                        <input type="hidden" class="action" name="action" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
    <script>
        $(document).ready(function(){
            $('body').on('click','.del-procart', function(){
    			var id = $(this).attr('data-code');
    			$('.procart-'+id).remove();
    		});
            /* Ajax select order */
            $('body').on('click','.form-order-category .miko-li-select', function(){
                var id_category = $('input[name="id_parent"]').val();                
                var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

                $.ajax({
                    url: "{{ route('admin.ajax.category_order') }}",
                    method:"POST",
                    dataType: 'json',
                    data:{id_category:id_category, _token:_token},

                    success: function(result){
                        var op = "<option value='0'>Chọn danh mục</option>";
                        $("#id_product").html(result.product);
                        $(".load_detail").html('');
                    }
                });

                return false;
            });

            $('body').on('change','.select_order_product', function(){
    			var id = $(this).val();
    			var type = $(this).data('type');
                var model = $(this).data('model');
                var level = $(this).data('level');
                var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
                console.log(type);
    			if(parseInt(id)>0){
    				$('.id_product_error').html('');
    			}
    			if($(".load_detail").length){
    				$.ajax({
                        url: "{{ route('admin.ajax.optionProduct') }}",
                        method:"POST",
                        dataType: 'json',
                        data:{id:id,type:type, _token:_token},
    					success: function(result){
    						$(".load_detail").html(result.product);
    						$('.select3').select2();
    					}
    				});

    				return false;
    			}
    		});
    		$('body').on('click','.minimus', function(){
    			let sl=$('#soluong').val();
    			if(parseInt(sl)>1){
    				sl--;
    			}else{
    				sl=1;
    			}
    			$('#soluong').val(sl);

    		});
    		$('body').on('click','.plus', function(){
    			let sl=$('#soluong').val();
    			sl++;
    			$('#soluong').val(sl);

    		});

    		$("#phiship, #giamgia").keyup(function(){
    			$('.action').val('change_fee');
    			load_cart();
    		});
    		/* Ajax place */
    		$('body').on('click','.counter-procart-minus', function(){
    			$('.action').val('change_sl');
    			let id=$(this).attr('data-id');
    			let sl=parseInt($('.quantity-procat'+id).val());
    			if(sl>1){ sl--; }else{ sl=1; }
    			$('.quantity-procat'+id).val(sl);
    			load_cart();
    		});

    		/* Ajax place */
    		$('body').on('click','.counter-procart-plus', function(){
    			$('.action').val('change_sl');
    			let id=$(this).attr('data-id');
    			let sl=parseInt($('.quantity-procat'+id).val());
    			sl++;

    			$('.quantity-procat'+id).val(sl);
    			load_cart();
    		});
    		$('body').on('click','.add_to_cart', function(){
    			$('.action').val('add_cart');
    			let id= $('#id_product').val();
    			let mess='';
    			let option='';
    			let exists=0;

    			if(parseInt(id)==0){
    				mess='Vui lòng chọn sản phẩm';
    				$('.id_product_error').html(mess);
    				return false;
    			}else{
    				$('.id_product_error').html('');
    			}

    			if($(".id_option").length && $('#id_option').val()=='0-0'){
    				mess='Vui lòng chọn phiên bản sản phẩm';
    				$('.id_option_error').html(mess);
    				return false;
    			}else{
    				$('.id_option_error').html('');
    			}
    			if($(".id_option").length && $('#id_option').val()!='0-0'){
    				option=$('#id_option').val();
    			}else{
    				option='0-0';
    			}
    			load_cart();

    		});
        })

        function load_cart(){
    		$.ajax({
                url: "{{ route('admin.ajax.addCart') }}",
                method:"POST",
                dataType: 'json',
                async: false,
                data: $(".createCartForm").serialize(),
    			success: function(result){
    				/*if(result.checkCanBuy==0){
    					if(result.cotheban_tmp>0){
    						$('.quantity-procat'+result.id).val(result.cotheban_tmp);
    						Swal.fire({
    							icon: 'warning',
    							title: 'THÔNG BÁO',
    							html: "Sản phẩm này chỉ còn "+result.cotheban_tmp+" sản phẩm",
    							confirmButtonColor: '#268fff',
    							confirmButtonText: 'Đã hiểu',
    						});
    					}else{
    						//alert("Sản phẩm này tạm hết hàng");
    						Swal.fire({
    							icon: 'warning',
    							title: 'THÔNG BÁO',
    							html: "Sản phẩm này tạm hết hàng",
    							confirmButtonColor: '#268fff',
    							confirmButtonText: 'Đã hiểu',
    						});
    					}
    				}else{*/
    					$('.list-procart-info').html(result.html_text);

    					$('.load-price-temp').html(result.tamtinh_text);
    					$('.tamtinh_tt').val(result.tamtinh);

    					$('.load-price-ship').html(result.phiship_text);

    					$('.load-price-discount').html(result.giamgia_text);
    					if(result.giamgia>=result.tonggia){
    						$('#giamgia').val(result.giamgia_ipput);
    					}

    					$('.load-price-total').html(result.tonggia_text);
    					$('.tonggia_tt').val(result.tonggia);
    				//}
    			}
    		});
    	}


        /*$('body').on("click", ".js-choose-information", function(event) {
            $('#dienthoai').val($(this).attr('data-dienthoai'));
            $('#ten').val($(this).attr('data-hoten'));
            $('#email').val($(this).attr('data-email'));
            let city = $(this).attr('data-city');
            let district = $(this).attr('data-district');
            let wards = $(this).attr('data-wards');
            $('#diachi').val($(this).attr('data-diachi'));
            $.ajax({
                url: 'ajax/GetAddressCustomerInformation.php',
                type: 'POST',
                dataType: 'json',
                data: {city:city, district:district, wards:wards},
            })
            .done(function(res) {
                $('#city').html(res.city);
                $('#district').html(res.district);
                $('#wards').html(res.ward);
            })
            .fail(function() {
                console.log("error");
            })
        });*/
    </script>
@endsection

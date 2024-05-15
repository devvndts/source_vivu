@php
	$rowItem['id_product'] = $rowItem['id_product'] ?? 0;
@endphp
@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{route('admin.productOption.save',['man',$type])}}" enctype="multipart/form-data">
	@csrf
    <div class="card-footer text-sm sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary submit-check submit-check-option"><i class="far fa-save mr-2"></i>Lưu</button>
        <div class="btn dropdown pl-0 ml-1">
		  <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    Thao tác
		  </button>
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<button type="submit" class="btn btn-sm bg-gradient-success submit-check submit-check-option btn-none-css" name="savehere"><i class="far fa-save mr-2"></i>Lưu tại trang</button>
	        <button type="reset" class="btn btn-sm bg-gradient-secondary btn-none-css"><i class="fas fa-redo mr-2"></i>Làm lại</button>	        
			<a class="btn btn-sm bg-gradient-info btn-none-css" href="{{ route('admin.productOption.show',['man',$type,'id_product'=>$rowItem['id_product']]) }}" title="Thoát"><i class="nav-icon text-sm fas fa-layer-group"></i> Xem phiên bản</a>
			<a class="btn btn-sm bg-gradient-danger btn-none-css" href="{{route('admin.productOption.show',['man',$type,'id_product'=>$rowItem['id_product']])}}" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
			</div> 
    	</div>
    </div>
    <div class="row">
        <div class="col-xl-8">
        	@if(isset($config[$type]['slug']) && $config[$type]['slug'] == true)
               @include('admin.layouts.slug')
            @endif
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Nội dung {{ $config[$type]['title_main'] }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="hienthi" class="d-inline-block align-middle mb-0 mr-2">Hiển thị:</label>
                        <div class="custom-control custom-checkbox d-inline-block align-middle">
                            @if(!isset($rowItem) || (isset($rowItem['hienthi']) && $rowItem['hienthi']==1))
                            <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" checked>
                            @else
                            <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox">
                            @endif
                            <label for="hienthi-checkbox" class="custom-control-label"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stt" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                        <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[stt]" id="stt" placeholder="Số thứ tự" value="{{ (isset($rowItem['stt']))?$rowItem['stt']:'1' }}">
                    </div>

                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                @foreach(config('config_all.lang') as $k => $v)
                                    <li class="nav-item">
                                        <a class="nav-link {{($k=='vi')?'active':''}}" id="tabs-lang" data-toggle="pill" href="#tabs-lang-{{$k}}" role="tab" aria-controls="tabs-lang-{{$k}}" aria-selected="true">{{$v}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body card-article">
                            <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                @foreach(config('config_all.lang') as $k => $v)
                                    <div class="tab-pane fade show {{($k=='vi')?'active':''}}" id="tabs-lang-{{$k}}" role="tabpanel" aria-labelledby="tabs-lang">
                                        <div class="form-group">
                                            <label for="ten{{$k}}" class="inp">
	                                            <input type="text" class="form-control for-seo" name="data[ten{{$k}}]" id="ten{{$k}}" placeholder="&nbsp;" value="{{ (isset($rowItem['ten'.$k]))?$rowItem['ten'.$k]:'' }}" required>
	                                            <span class="label">Tiêu đề ({{$k}})</span>
	                                            <span class="focus-bg"></span>
												<p class="alert-masp text-danger d-none mt-2 mb-0" id="alert-ten{{$k}}-danger">
					                                <i class="fas fa-exclamation-triangle mr-1"></i>
					                                <span>Tên sản phẩm đã tồn tại.</span>
					                            </p>
					                            <p class="alert-masp text-success d-none mt-2 mb-0" id="alert-ten{{$k}}-success">
					                                <i class="fas fa-check-circle mr-1"></i>
					                                <span>Tên sản phẩm hợp lệ.</span>
					                            </p>
					                        </label>
                                        </div>

                                        @if(isset($config[$type]['mota']) && $config[$type]['mota'] == true)
                                        <div class="form-group">
                                            <label for="mota{{$k}}" class="inp">
                                            	<textarea class="form-control for-seo {{(isset($config[$type]['mota_cke']) && $config[$type]['mota_cke'] == true)?'form-control-ckeditor':''}}" name="data[mota{{$k}}]" id="mota{{$k}}" rows="5" placeholder="&nbsp;">{{ (isset($rowItem['mota'.$k]))?$rowItem['mota'.$k]:'' }}</textarea>
                                            	<span class="label">Mô tả ({{$k}}):</span>
												<span class="focus-bg"></span>
                                            </label>
                                        </div>
                                        @endif

                                        @if(isset($config[$type]['noidung']) && $config[$type]['noidung'] == true)
                                        <div class="form-group">
                                            <label for="noidung{{$k}}">Nội dung ({{$k}}):</label>
                                            <textarea class="form-control for-seo form-control-ckeditor" name="data[noidung{{$k}}]" id="noidung{{$k}}" rows="5" placeholder="Nội dung ({{$k}})">{{ (isset($rowItem['noidung'.$k]))?$rowItem['noidung'.$k]:'' }}</textarea>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline text-sm">
				<div class="card-header">
					<h3 class="card-title">Thông tin {{ $config[$type]['title_main'] }}</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body card-article">
					<div class="form-group">
						<label for="hienthi" class="d-inline-block align-middle mb-0 mr-2">Hiển thị:</label>
						<div class="custom-control custom-checkbox d-inline-block align-middle">
							<input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" {{ (!isset($rowItem['hienthi']) || $rowItem['hienthi']==1)?'checked':'' }}>
							<label for="hienthi-checkbox" class="custom-control-label"></label>
						</div>
					</div>
					<div class="form-group">
						<label for="stt" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
						<input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[stt]" id="stt" placeholder="Số thứ tự" value="{{ (isset($rowItem['stt'])) ? $rowItem['stt'] : 1 }}">
					</div>
					<div class="row">
						@if(isset($config[$type]['ma']) && $config[$type]['ma'] == true)
							<div class="form-group col-md-4 d-none">
								<label class="d-block" for="masp">Mã sản phẩm(của hãng):</label>
								<input type="text" class="form-control" name="data[masp_brand]" id="masp_brand" placeholder="Mã sản phẩm" value="{{$rowItem['masp_brand']??''}}">
							</div>
							<div class="form-group col-md-4">
								<label class="d-block" for="masp">Mã sản phẩm:</label>
								<input type="text" class="form-control" name="data[masp]" id="masp" placeholder="Mã sản phẩm" value="{{$rowItem['masp']??''}}" required>
								<p class="alert-masp text-danger d-none mt-2 mb-0" id="alert-masp-danger">
									<i class="fas fa-exclamation-triangle mr-1"></i>
									<span>Mã SP đã tồn tại.</span>
								</p>
								<p class="alert-masp text-success d-none mt-2 mb-0" id="alert-masp-success">
									<i class="fas fa-check-circle mr-1"></i>
									<span>Mã SP hợp lệ.</span>
								</p>
							</div>
						@endif
						<div class="form-group col-md-4">
							<label class="d-block" for="giamoi">Kích thước đóng gói(cm):</label>
							<div class="input-group">
								<input type="text" class="form-control format-price dai" name="data[dai]" id="dai" placeholder="Chiều dài" value="{{$rowItem['dai']??''}}">
								<div class="input-group-append">
									<div class="input-group-text"><strong>x</strong></div>
								</div>
								<input type="text" class="form-control format-price rong" name="data[rong]" id="rong" placeholder="Chiều rộng" value="{{$rowItem['rong']??''}}">
								<div class="input-group-append">
									<div class="input-group-text"><strong>x</strong></div>
								</div>
								<input type="text" class="form-control format-price cao" name="data[cao]" id="cao" placeholder="Chiều cao" value="{{$rowItem['cao']??''}}">
								<div class="input-group-append">
									<div class="input-group-text"><strong>/4000</strong></div>
								</div>
							</div>
						</div>
						<div class="form-group col-md-4">
							<label class="d-block" for="giamoi">Khối lượng đóng gói:</label>
							<div class="input-group">
								<input type="text" class="form-control format-price khoiluong" name="data[khoiluong]" id="khoiluong" placeholder="Khối lượng" value="{{$rowItem['khoiluong']??''}}">
								<div class="input-group-append">
									<div class="input-group-text"><strong>Gram</strong></div>
								</div>
							</div>
						</div>

						@if(isset($config[$type]['giacu']) && $config[$type]['giacu'] == true)
							<div class="form-group col-md-4">
								<label class="d-block" for="giamoi">Giá cũ:</label>
								<div class="input-group">
									<input type="text" class="form-control format-price gia_cu" name="data[giacu]" id="giacu" placeholder="Giá cũ" value="{{$rowItem['giacu']??''}}">
									<div class="input-group-append">
										<div class="input-group-text"><strong>VNĐ</strong></div>
									</div>
								</div>
							</div>
						@endif

						@if(isset($config[$type]['gia']) && $config[$type]['gia'] == true)
							<div class="form-group col-md-4">
								<label class="d-block" for="gia">Giá bán:</label>
								<div class="input-group">
									<input type="text" class="form-control format-price gia_ban" name="data[gia]" id="gia" placeholder="Giá bán" value="{{$rowItem['gia']??''}}">
									<div class="input-group-append">
										<div class="input-group-text"><strong>VNĐ</strong></div>
									</div>
								</div>
							</div>
						@endif

						@if(isset($config[$type]['giamoi']) && $config[$type]['giamoi'] == true)
							<div class="form-group col-md-4">
								<label class="d-block" for="giamoi">Giá mới:</label>
								<div class="input-group">
									<input type="text" class="form-control format-price gia_moi" name="data[giamoi]" id="giamoi" placeholder="Giá mới" value="{{$rowItem['giamoi']??''}}">
									<div class="input-group-append">
										<div class="input-group-text"><strong>VNĐ</strong></div>
									</div>
								</div>
							</div>
						@endif

						@if(isset($config[$type]['giakm']) && $config[$type]['giakm'] == true)
							<div class="form-group col-md-4">
								<label class="d-block" for="giakm">Chiết khấu:</label>
								<div class="input-group">
									<input type="text" class="form-control gia_km" name="data[giakm]" id="giakm" placeholder="Chiết khấu" value="{{$rowItem['giakm']??''}}" maxlength="3" readonly>
									<div class="input-group-append">
										<div class="input-group-text"><strong>%</strong></div>
									</div>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
        </div>
        
        <div class="col-xl-4">
			<div class="card card-primary card-outline text-sm">
	            <div class="card-header">
	                <h3 class="card-title">Danh mục {{ $config[$type]['title_main'] }}</h3>
	                <div class="card-tools">
	                	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
	                </div>
	            </div>
	            <div class="card-body">
            		<div class="form-group-category row">
            			@php
            				//dd($config[$type]['size']);
            			@endphp
					    @if(isset($config[$type]['mau']) && $config[$type]['mau'] == true && $arr_colors)
							@if($request->id > 0)
								<div class="form-group col-xl-6 col-sm-4">
									<label class="d-block" for="id_showmau">Danh mục màu sắc:</label>
									<select id="id_showmau" class="select multiselect" required>
										@foreach($arr_colors as $k=>$v)
											@if($v['id']==$rowItem['id_mau'])
											<option value="{{ $v['id'] }}">{{ $v['tenvi'] }}</option>
											@endif
										@endforeach
									</select>
								</div>
							@else
								<div class="form-group col-xl-6 col-sm-4">
									<label class="d-block" for="id_mau">Danh mục màu sắc:</label>
									<select id="id_mau" name="data[id_mau]" class="select multiselect" {{ (count($arr_colors)>0)?'required':'' }} onchange="CheckProductOption()">
										@foreach($arr_colors as $k=>$v)
											<option value="{{ $v['id'] }}">{{ $v['tenvi'] }}</option>
										@endforeach
									</select>
								</div>
							@endif
					    @endif

					    @if(isset($config[$type]['size']) && $config[$type]['size'] == true && $arr_sizes)
							@if($request->id > 0)
								<div class="form-group col-xl-6 col-sm-4">
									<label class="d-block" for="id_size">Danh mục kích thước:</label>
									<select id="id_size" class="select multiselect" required> <!--id=id_showsize-->
										@foreach($arr_sizes as $k=>$v)
											@if($v['id']==$rowItem['id_size'])
											<option value="{{ $v['id'] }}">{{ $v['tenvi'] }}</option>
											@endif
										@endforeach
									</select>
								</div>
							@else
								<div class="form-group col-xl-6 col-sm-4">
									<label class="d-block" for="id_size">Danh mục kích thước:</label>
									<select id="id_size" name="data[id_size]" class="select multiselect" {{ (count($arr_sizes)>0)?'required':'' }} onchange="CheckProductOption()">
										@foreach($arr_sizes as $k=>$v)
											<option value="{{ $v['id'] }}">{{ $v['tenvi'] }}</option>
										@endforeach
									</select>
								</div>
							@endif
					    @endif

						<p class="dev-option-error text-danger col-xl-12 d-none" id="load-error"><i class="fas fa-exclamation-circle"></i> Phiên bản này đã tồn tại !</p>
						<p class="dev-option-error text-success col-xl-12 d-none" id="load-success"><i class="fas fa-check-circle"></i> Phiên bản hợp lệ</p>
					</div>
	            </div>
	        </div>

	        @if(config('config_all.order.soluong'))
	        <div class="card card-primary card-outline text-sm">
				<div class="card-header">
					<h3 class="card-title">Số lượng sản phẩm</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group col-md-12">
						@if($rowItem)
							<div class="form-group">
								<div class="custom-control custom-radio d-inline-block mr-3 text-md">
									<input class="custom-control-input mailertype" type="radio" id="soluong_add" name="soluong_type" value="0" checked>
									<label for="soluong_add" class="custom-control-label font-weight-normal">Thêm</label>
								</div>
								<div class="custom-control custom-radio d-inline-block mr-3 text-md">
									<input class="custom-control-input mailertype" type="radio" id="soluong_minus" name="soluong_type" value="1">
									<label for="soluong_minus" class="custom-control-label font-weight-normal">Giảm</label>
								</div>
							</div>

							<div class="form-group">
	                            <label for="soluong" class="inp">
	                            	<input type="hidden" name="soluong_now" value="{{$rowItem['soluong']}}">
	                                <input type="text" class="form-control" name="soluong" id="soluong" value="{{$rowItem['soluong']}}">
	                                <span class="label">Số lượng hiện tại (<span id="soluong_span">{{$rowItem['soluong']}}</span>)</span>
	                                <span class="focus-bg"></span>
		                        </label>
	                        </div>
	                        <p class="alert-soluong text-danger d-none mt-2 mb-2" id="alert-soluong-danger">
								<i class="fas fa-exclamation-triangle mr-1"></i>
								<span>Số lượng ko hợp lệ</span>
							</p>	
							<p class="alert-soluong text-success d-none mt-2 mb-2" id="alert-soluong-success">
								<i class="fas fa-exclamation-triangle mr-1"></i>
								<span>Xác nhận thành công</span>
							</p>						
	                        <p class="soluong_submit">Xác nhận</p>
                        @else
                        	<div class="form-group">
								<label class="d-block" for="soluong">Số lượng khởi tạo:</label>
								<div class="input-group">
									<input type="text" class="form-control" name="data[soluong]" id="soluong" placeholder="" value="{{$rowItem['soluong']}}" value="0">									
								</div>
							</div>
                        @endif
					</div>
				</div>
			</div>
			@endif


			@if((config('config_all.order.soluong') || config('lazada.active')))
			@php
				$rowItem['soluong_website'] = $rowItem['soluong_website'] ?? 0;
				$rowItem['soluong_lazada'] = $rowItem['soluong_lazada'] ?? 0;
				$rowItem['soluong_shopee'] = $rowItem['soluong_shopee'] ?? 0;
			@endphp
				<div class="card card-primary card-outline text-sm">
					<div class="card-header">
						<h3 class="card-title">Số lượng sản phẩm</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group">
                            <label for="tongsoluong" class="inp">
                                <input type="text" class="form-control for-seo format-price" id="tongsoluong" placeholder="&nbsp;" value="{{ $rowItem['soluong_website']+$rowItem['soluong_lazada']+$rowItem['soluong_shopee'] }}" readonly disabled="">
                                <span class="label">Tổng số lượng</span>
	                        </label>
                        </div>
						<div class="form-group">
                            <label for="soluong_website" class="inp">
                                <input type="text" class="form-control for-seo format-price" name="data[soluong_website]" id="soluong_website" placeholder="&nbsp;" value="{{ (isset($rowItem['soluong_website']))?$rowItem['soluong_website']:'' }}" required>
                                <span class="label">Website</span>
	                        </label>
                        </div>
                        <div class="form-group">
                            <label for="soluong_lazada" class="inp">
                                <input type="text" class="form-control for-seo format-price" name="data[soluong_lazada]" id="soluong_lazada" placeholder="&nbsp;" value="{{ (isset($rowItem['soluong_lazada']))?$rowItem['soluong_lazada']:'' }}" required>
                                <span class="label">Lazada</span>
	                        </label>
                        </div>
                        <div class="form-group">
                            <label for="soluong_shopee" class="inp">
                                <input type="text" class="form-control for-seo format-price" name="data[soluong_shopee]" id="soluong_shopee" placeholder="&nbsp;" value="{{ (isset($rowItem['soluong_shopee']))?$rowItem['soluong_shopee']:'' }}" required>
                                <span class="label">Shopee</span>
	                        </label>
                        </div>
					</div>
				</div>
			@endif	


            @if(isset($config[$type]['images']) && $config[$type]['images'] == true)
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Hình đại diện</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                	@if(config('config_all.fileupload')==true)
	                    @php
	                        $amount_images = $config[$type]['amount_images'];
	                        for($i=0;$i<$amount_images;$i++){
	                            TableManipulation::AddFieldToTable('product_option','photo'.(($i>0) ? $i : ''), 'string');
	                            TableManipulation::AddFieldToTable('product_option','idphoto'.(($i>0) ? $i : ''));
	                        }
	                    @endphp
	                	@include('admin.layouts.devimage')
	                @else
                    	@include('admin.layouts.image')
                    @endif
                </div>
            </div>
            @endif

            @if(isset($config[$type]['seo']) && $config[$type]['seo'] == true)
		    <div class="card card-primary card-outline text-sm">
		        <div class="card-header">
		            <h3 class="card-title">Nội dung SEO</h3>
		            <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
		        </div>
		        <div class="card-body">
		        	@include('admin.layouts.seo')
		        </div>
		    </div>
		    @endif

        </div>
    </div>

    @if(isset($config[$type]['gallery']) && $config[$type]['gallery_option'])
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Bộ sưu tập {{ $config[$type]['title_main'] }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
            	@if(config('config_all.fileupload')==true)
                    @include('admin.layouts.gallery_multy')
                @else                
	                <div class="form-group">
	                    <label for="filer-gallery" class="label-filer-gallery mb-3">Album hình: ({{ $config[$type]['gallery'][$type]['img_type_photo'] }})</label>
	                    <input type="file" name="files[]" id="filer-gallery" multiple="multiple">
	                    <input type="hidden" class="col-filer" value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
	                    <input type="hidden" class="act-filer" name="level" value="man">
	                    <input type="hidden" class="folder-filer" name="model" value="productOption">
	                    <input type="hidden" class="folder-filer" name="type" value="{{ $type }}">
	                    <input type="hidden" name="hash" value="{{ Helper::generateHash() }}" />
	                </div>
	                @if(isset($gallery) && count($gallery) > 0)
	                    <div class="form-group form-group-gallery">
	                        {{--<label class="label-filer">Album hiện tại:</label>--}}
	                        <div class="action-filer mb-3">
	                            <a class="btn btn-sm bg-gradient-primary text-white check-all-filer mr-1"><i class="far fa-square mr-2"></i>Chọn tất cả</a>
	                            <button type="button" class="btn btn-sm bg-gradient-success text-white sort-filer mr-1"><i class="fas fa-random mr-2"></i>Sắp xếp</button>
	                            <a class="btn btn-sm bg-gradient-danger text-white delete-all-filer"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a>
	                        </div>
	                        <div class="alert my-alert alert-sort-filer alert-info text-sm text-white bg-gradient-info"><i class="fas fa-info-circle mr-2"></i>Có thể chọn nhiều hình để di chuyển</div>
	                        <div class="jFiler-items my-jFiler-items jFiler-row">
	                            <ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable">
	                                @foreach($gallery as $v)
	                                    {{ Helper::galleryFiler($v['stt'],$v['id'],$v['photo'],$v['tenvi'],'productOption','col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6') }}
	                                @endforeach
	                            </ul>
	                        </div>
	                    </div>
	                @endif
	            @endif
            </div>
        </div>
    @endif

    <input type="hidden" name="id" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
	<input type="hidden" name="type" value="{{ $type }}">
	<input type="hidden" name="idProOption" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
	<input type="hidden" name="idProParent" value="{{ (isset($idParent))?$idParent:'' }}">
	<input type="hidden" name="table" value="productOption">
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
	<script>

		CheckProductOption();

		function CheckProductOption(){
			var id = $('input[name="id"]').val();
			var id_product = $('input[name="idProParent"]').val();
			var id_mau = $('#id_mau').val();
			var id_size = $('#id_size').val();
			var type = $('input[name="type"]').val();
			var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
			//alert(id_product+'-'+id_mau+'-'+id_size+'-'+type+'-'+_token);

			$.ajax({
				url: "{{ route('admin.ajax.checkOption') }}",
				type: 'POST',
				dataType: 'json',
				async: false,
				data: {id:id,id_product:id_product,id_mau:id_mau,id_size:id_size,type:type,_token:_token},
				success: function(result){
					if(result.check==1){
						$('#load-error').removeClass('d-none');
						$('#load-success').addClass('d-none');
						kq = false;
					}else if(result.check==0){
						$('#load-error').addClass('d-none');
						$('#load-success').removeClass('d-none');
						kq = true;
					}
					if(result.id>0){
						$('input[name="idProOption"]').val(result.id);
						$('input[name="id"]').val(result.id);
						//$('.slug-id').val(result.id);
					}
					if(result.detail){
						//console.log(result.detail);
						$('#slugvi').val(result.detail.tenkhongdauvi);
						$('#slugen').val(result.detail.tenkhongdauen);
						$('#tenvi').val(result.detail.tenvi);
						$('#tenen').val(result.detail.tenen);
						$('#masp').val(result.detail.masp);
						$('#photoUpload-preview').find('img').attr("src","{{ config('config_upload.UPLOAD_PRODUCT')}}"+result.detail.photo);
					}
				}
			});
			return kq;
		}

		$(document).ready(function(){
			$('.submit-check-option').click(function(){
				if(!CheckProductOption()){
					setTimeout(function(){
						$('html,body').animate({scrollTop: $('#load-error').offset().top - 110},'medium');
					},500);
					return false;
				}
			});


			$('.soluong_submit').click(function(){
				var id = $('input[name="id"]').val();
				var table = $('input[name="table"]').val();
				var soluong_type = $('input[name="soluong_type"]:checked').val();
				var soluong_now = $('input[name="soluong_now"]').val();
				var soluong_input = $('input[name="soluong"]').val();
				var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

				
				if(soluong_type==1 && (soluong_input-soluong_now)>0){
					//console.log(soluong_input+'-'+soluong_now);			
					$('#alert-soluong-danger').removeClass('d-none');
					$('#alert-soluong-danger').addClass('d-block');
					return false;
				}else{					
					$('#alert-soluong-danger').addClass('d-none');
					$('#alert-soluong-danger').removeClass('d-block');

					$.ajax({
						url: "{{ route('admin.ajax.changeSoluong') }}",
						type: 'POST',
						dataType: 'json',
						async: false,
						data: {id:id,table:table,soluong_type:soluong_type,soluong_now:soluong_now,soluong_input:soluong_input,_token:_token},
						success: function(result){
							if(result.success==1){
								//console.log('xác nhận thành công');
								$('#alert-soluong-success').removeClass('d-none');
								$('#alert-soluong-success').addClass('d-block');
								$('#soluong_span').text(result.soluong_now);
								$('input[name="soluong"]').val(result.soluong_now);
								$('input[name="soluong_now"]').val(result.soluong_now);								
							}							
						}
					});
				}
			});
		});
	</script>

	@if(isset($config[$type]['giakm']) && $config[$type]['giakm'] == true)
		<script type="text/javascript">
			function roundNumber(rnum, rlength)
			{
				return Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
			}
			$(document).ready(function(){

				$(".gia_ban, .gia_moi").keyup(function(){
					//console.log('ok');
					var gia_cu = $('.gia_ban').val();
					var gia_ban = $('.gia_moi').val();
					var gia_km = 0;

					if(gia_cu=='' || gia_cu=='0' || gia_ban=='' || gia_ban=='0')
					{
						gia_km=0;
					}
					else
					{
						gia_cu = gia_cu.replace(/,/g,"");
						gia_ban = gia_ban.replace(/,/g,"");
						gia_cu = parseInt(gia_cu);
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

					$('.gia_km').val(gia_km);
				})

				$(".dai, .rong, .cao").keyup(function(){
					var dai = $('.dai').val();
					var rong = $('.rong').val();
					var cao = $('.cao').val();
					var weight = 0;

					if(dai=='0'|| rong=='0'|| cao=='0'){
						weight=0;
					}else{
						dai = dai.replace(/,/g,"");
						rong = rong.replace(/,/g,"");
						cao = cao.replace(/,/g,"");
						dai = parseInt(dai);
						rong = parseInt(rong);
						cao = parseInt(cao);

						weight= (dai*rong*cao)/4000;
						weight=weight*1000;
					}
					$('#khoiluong').val(weight);
					$(".format-price").priceFormat({
						limit: 13,
						prefix: '',
						centsLimit: 0
					});
				})
			})
		</script>
	@endif
@endsection

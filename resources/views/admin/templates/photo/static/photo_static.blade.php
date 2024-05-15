@extends('admin.master')
@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];

$urlSave = route('admin.photo.save_static', ['photo_static', $type]);
$urlMan = route('admin.photo.save_static', ['photo_static', $type]);
$urlOption = '';
$isShowOption = false;
@endphp
@section('content')
<form method="post" id="form-watermark" action="{{ $urlSave }}" enctype="multipart/form-data">
	@csrf
    <x-backend_shared.action_buttons
        :urlMan=$urlMan
        :urlOption=$urlOption
        :isShowOption=$isShowOption
    />
    <div class="text-sm card card-primary card-outline">
        <x-backend_shared.card_header >
            {{ __('Chi tiết') }} {{ __($config[$type]['title_main']) }}
        </x-backend_shared.card_header>
        <div class="card-body">
            @if(isset($config[$type]['images']) && $config[$type]['images'])
                <div class="form-group">
                    <label class="change-photo" for="file">
                        <p>Upload hình ảnh:</p>
                        <div class="rounded">
                            <img class="rounded img-upload" src="{{ (isset($rowItem['photo']))?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:'' }}" onerror="src='{{asset('img/noimage.png')}}'" alt="Alt Photo"/>
                            <strong>
                                <b class="text-sm text-split"></b>
                                <span class="btn btn-sm bg-gradient-success"><i class="mr-2 fas fa-camera"></i>Chọn hình</span>
                            </strong>
                        </div>
                    </label>
                    <strong class="mt-2 mb-2 text-sm d-block">{{ "Width: ".$config[$type]['width']." px - Height: ".$config[$type]['height']." px (".$config[$type]['img_type'].")" }}</strong>
                    <div class="custom-file my-custom-file d-none">
                        <input type="file" class="custom-file-input" name="file" id="file">
                        <label class="custom-file-label" for="file">Chọn file</label>
                    </div>
                </div>
            @endif

            @if(isset($config[$type]['watermark-advanced']) && $config[$type]['watermark-advanced'])
                <div class="row">
                    <div class="col-xl-4 row">
                        <div class="form-group col-12">
                            <label>Vị trí đóng dấu:</label>
                            <div class="rounded watermark-position">
                                <label for="tl">
                                    <input type="radio" name="data[options][watermark][position]" id="tl" value="top-left" {{(isset($options['watermark']['position']) && $options['watermark']['position']=='top-left')?'checked':''}}>
                                    <img class="rounded" onerror="src='{{asset('img/noimage.png')}}'" src="{{(isset($options['watermark']['position']) && $options['watermark']['position']=='top-left')?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:''}}" alt="watermark-cover">
                                </label>

								<label for="tc">
                                    <input type="radio" name="data[options][watermark][position]" id="tc" value="top" {{(isset($options['watermark']['position']) && $options['watermark']['position']=='top')?'checked':''}}>
                                    <img class="rounded" onerror="src='{{asset('img/noimage.png')}}'" src="{{(isset($options['watermark']['position']) && $options['watermark']['position']=='top')?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:''}}" alt="watermark-cover">
                                </label>
                                <label for="tr">
                                    <input type="radio" name="data[options][watermark][position]" id="tr" value="top-right" {{(isset($options['watermark']['position']) && $options['watermark']['position']=='top-right')?'checked':''}}>
                                    <img class="rounded" onerror="src='{{asset('img/noimage.png')}}'" src="{{(isset($options['watermark']['position']) && $options['watermark']['position']=='top-right')?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:''}}" alt="watermark-cover">
                                </label>
                                <label for="mr">
                                    <input type="radio" name="data[options][watermark][position]" id="mr" value="right" {{(isset($options['watermark']['position']) && $options['watermark']['position']=='right')?'checked':''}}>
                                    <img class="rounded" onerror="src='{{asset('img/noimage.png')}}'" src="{{(isset($options['watermark']['position']) && $options['watermark']['position']=='right')?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:''}}" alt="watermark-cover">
                                </label>
                                <label for="br">
                                    <input type="radio" name="data[options][watermark][position]" id="br" value="bottom-right" {{(isset($options['watermark']['position']) && $options['watermark']['position']=='bottom-right')?'checked':''}}>
                                    <img class="rounded" onerror="src='{{asset('img/noimage.png')}}'" src="{{(isset($options['watermark']['position']) && $options['watermark']['position']=='bottom-right')?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:''}}" alt="watermark-cover">
                                </label>
                                <label for="bc">
                                    <input type="radio" name="data[options][watermark][position]" id="bc" value="bottom" {{(isset($options['watermark']['position']) && $options['watermark']['position']=='bottom')?'checked':''}}>
                                    <img class="rounded" onerror="src='{{asset('img/noimage.png')}}'" src="{{(isset($options['watermark']['position']) && $options['watermark']['position']=='bottom')?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:''}}" alt="watermark-cover">
                                </label>
                                <label for="bl">
                                    <input type="radio" name="data[options][watermark][position]" id="bl" value="bottom-left" {{(isset($options['watermark']['position']) && $options['watermark']['position']=='bottom-left')?'checked':''}}>
                                    <img class="rounded" onerror="src='{{asset('img/noimage.png')}}'" src="{{(isset($options['watermark']['position']) && $options['watermark']['position']=='bottom-left')?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:''}}" alt="watermark-cover">
                                </label>
                                <label for="ml">
                                    <input type="radio" name="data[options][watermark][position]" id="ml" value="left" {{(isset($options['watermark']['position']) && $options['watermark']['position']=='left')?'checked':''}}>
                                    <img class="rounded" onerror="src='{{asset('img/noimage.png')}}'" src="{{(isset($options['watermark']['position']) && $options['watermark']['position']=='left')?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:''}}" alt="watermark-cover">
                                </label>
                                <label for="cc">
                                    <input type="radio" name="data[options][watermark][position]" id="cc" value="center" {{(isset($options['watermark']['position']) && $options['watermark']['position']=='center')?'checked':''}}>
                                    <img class="rounded" onerror="src='{{asset('img/noimage.png')}}'" src="{{(isset($options['watermark']['position']) && $options['watermark']['position']=='center')?config('config_upload.UPLOAD_PHOTO').$rowItem['photo']:''}}" alt="watermark-cover">
                                </label>
                            </div>
							<input type="hidden" name="data[options][watermark][type]" value="{{$type}}">
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                @if(isset($config[$type]['background']) && $config[$type]['background'])
                    <div class="form-group col-md-3">
                        <label for="background_repeat">Tùy chọn lặp:</label>
                        <select id="background_repeat" name="data[options][background][repeat]" class="form-control select2">
                            <option value="0">Chọn thuộc tính</option>
                            <option <?php if($options['background']['repeat']=='no-repeat') echo 'selected="selected"' ?> value="no-repeat">Không lặp lại</option>
                            <option <?php if($options['background']['repeat']=='repeat') echo 'selected="selected"' ?> value="repeat">Lặp lại</option>
                            <option <?php if($options['background']['repeat']=='repeat-x') echo 'selected="selected"' ?> value="repeat-x">Lặp lại theo chiều ngang</option>
                            <option <?php if($options['background']['repeat']=='repeat-y') echo 'selected="selected"' ?> value="repeat-y">Lặp lại theo chiều dọc</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="background_size">Kích thước:</label>
                        <select id="background_size" name="data[options][background][size]" class="form-control select2">
                            <option value="0">Chọn thuộc tính</option>
                            <option <?php if($options['background']['size']=='auto') echo 'selected="selected"' ?> value="auto">Auto</option>
                            <option <?php if($options['background']['size']=='cover') echo 'selected="selected"' ?> value="cover">Cover</option>
                            <option <?php if($options['background']['size']=='contain') echo 'selected="selected"' ?> value="contain">Contain</option>
                            <option <?php if($options['background']['size']=='100% 100%') echo 'selected="selected"' ?> value="100% 100%">Toàn màn hình</option>
                            <option <?php if($options['background']['size']=='100% auto') echo 'selected="selected"' ?> value="100% auto">Toàn màn hình theo chiều ngang</option>
                            <option <?php if($options['background']['size']=='auto 100%') echo 'selected="selected"' ?> value="auto 100%">Toàn màn hình theo chiều dọc</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="background_position">Vị trí:</label>
                        <select id="background_position" name="data[options][background][position]" class="form-control select2">
                            <option value="0">Chọn thuộc tính</option>
                            <option <?php if($options['background']['position']=='left top') echo 'selected="selected"' ?> value="left top">Canh Trái - Canh Trên</option>
                            <option <?php if($options['background']['position']=='left bottom') echo 'selected="selected"' ?> value="left bottom">Canh Trái - Canh Dưới</option>
                            <option <?php if($options['background']['position']=='left center') echo 'selected="selected"' ?> value="left center">Canh Trái - Canh Giữa</option>
                            <option <?php if($options['background']['position']=='right top') echo 'selected="selected"' ?> value="right top">Canh Phải - Canh Trên</option>
                            <option <?php if($options['background']['position']=='right bottom') echo 'selected="selected"' ?> value="right bottom">Canh Phải - Canh Dưới</option>
                            <option <?php if($options['background']['position']=='right center') echo 'selected="selected"' ?> value="right center">Canh Phải - Canh Giữa</option>
                            <option <?php if($options['background']['position']=='center top') echo 'selected="selected"' ?> value="center top">Canh Giữa - Canh Trên</option>
                            <option <?php if($options['background']['position']=='center bottom') echo 'selected="selected"' ?> value="center bottom">Canh Giữa - Canh Dưới</option>
                            <option <?php if($options['background']['position']=='center center') echo 'selected="selected"' ?> value="center">Canh Giữa - Canh Giữa</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="background_attachment">Cố định:</label>
                        <select class="form-control" name="data[options][background][attachment]" id="background_attachment">
                            <option <?=($options['background']['attachment']=='')?"selected":""?> value="0">Không cố định</option>
                            <option <?=($options['background']['attachment']=='fixed')?"selected":""?> value="fixed">Cố định</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="background_color">Màu nền:</label>
                        <input type="text" class="form-control jscolor" name="data[options][background][color]" id="background_color" maxlength="7" value="<?=($options['background']['color'])?$options['background']['color']:'#000000'?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="loaihienthi">Loại hiển thị:</label>
                        <select class="form-control" name="data[options][background][loaihienthi]" id="loaihienthi">
                            <option value="0">Chọn tình trạng</option>
                            <option <?=($options['background']['loaihienthi']==1)?"selected":""?> value="1">Hình nền</option>
                            <option <?=($options['background']['loaihienthi']==0)?"selected":""?> value="0">Màu nền</option>
                        </select>
                    </div>
                @endif

                @if(isset($config[$type]['link']) && $config[$type]['link'])
                    <x-backend_form.group :class=$formGroupClass >
                        <x-backend_form.label >{{ __('Link') }}: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[link]" id="link" value="{{ $rowItem['link'] ?? '' }}" />
                    </x-backend_form.group>
                @endif

                @if(isset($config[$type]['video']) && $config[$type]['video'])
                <x-backend_form.group :class=$formGroupClass >
                        <x-backend_form.label >{{ __('Video') }}: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[link_video]" id="link_video" value="{{ $rowItem['link_video'] ?? '' }}" />
                    </x-backend_form.group>
                @endif
            </div>

            @php
            $isChecked = false;
            if (!isset($rowItem['hienthi']) || $rowItem['hienthi'] == 1) {
                $isChecked = true;
            }
            @endphp
            <x-backend_form.group>
                <x-backend_form.label isInlineBlock class="{{ $sttLabelClass }}" >{{ __('Hiển thị') }}: </x-backend_form.label>
                <x-backend_form.hienthi_input_group :isChecked="$isChecked" name="data[hienthi]"
                id="hienthi-checkbox" />
            </x-backend_form.group>

            @if(
                (isset($config[$type]['tieude']) && $config[$type]['tieude'])
                || (isset($config[$type]['mota']) && $config[$type]['mota'])
                || (isset($config[$type]['noidung']) && $config[$type]['noidung'] == true)
                )
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="p-0 card-header border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                            @foreach(config('config_all.lang') as $k => $v)
                                <li class="nav-item">
                                    <a class="nav-link {{($k=='vi')?'active':''}}" id="tabs-lang" data-toggle="pill" href="#tabs-lang-{{$k}}" role="tab" aria-controls="tabs-lang-{{$k}}" aria-selected="true">{{$v}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                            @foreach(config('config_all.lang') as $k => $v)
                                <div class="tab-pane fade show {{($k=='vi')?'active':''}}" id="tabs-lang-{{$k}}" role="tabpanel" aria-labelledby="tabs-lang">
                                    @if((isset($config[$type]['tieude']) && $config[$type]['tieude']))
                                        @php
                                            $class = "for-seo ";
                                        @endphp
                                        <x-backend_form.group >
                                            <x-backend_form.label >{{ __('Tiêu đề') }} ({{ $k }}): </x-backend_form.label>
                                            <x-backend_form.input type="text" name="data[ten{{ $k }}]" id="ten{{ $k }}" value="{{ $rowItem['ten' . $k] ?? '' }}"  />
                                        </x-backend_form.group>
                                    @endif

                                    @if((isset($config[$type]['mota']) && $config[$type]['mota']))
                                        @php
                                            $class = "";
                                            if (isset($config[$type]['mota_cke_custom']) 
                                                && $config[$type]['mota_cke_custom']) {
                                                $class .= "form-control-ckeditor-custom ";
                                            } elseif (isset($config[$type]['mota_cke']) 
                                                && $config[$type]['mota_cke']) {
                                                $class .= "form-control-ckeditor ";
                                            }
                                        @endphp
                                        <x-backend_form.group >
                                            <x-backend_form.label >{{ __('Mô tả') }} ({{ $k }}): </x-backend_form.label>
                                            <x-backend_form.textarea class="{{ $class }}" name="data[mota{{ $k }}]" id="mota{{ $k }}" rows="5">{{$rowItem['mota' . $k] ?? '' }}</x-backend_form.textarea>
                                        </x-backend_form.group>
                                    @endif

                                    @if((isset($config[$type]['noidung']) && $config[$type]['noidung']))
                                        @php
                                            $class = "form-control-ckeditor ";
                                            $labelName = $config[$type]['noidung_title'] ?? __('Nội dung');
                                        @endphp
                                        <x-backend_form.group >
                                            <x-backend_form.label >{{ $labelName }} ({{ $k }}): </x-backend_form.label>
                                            <x-backend_form.textarea class="{{ $class }}" name="data[noidung{{ $k }}]" id="noidung{{ $k }}" rows="5">{{$rowItem['noidung' . $k] ?? '' }}</x-backend_form.textarea>
                                        </x-backend_form.group>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if (@$config[$type]['sl_options'])
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header isShowMinus>
                    {{ __('Thông tin') }} {{ __($config[$type]['title_main']) }}
                </x-backend_shared.card_header>
                <div class="card-body">
                    <div class="row">
                        @php
                            $elements = renderBackendComponent($config[$type]['sl_options'], 'options', $sl_options ?? null);
                        @endphp
                        {!! FormTemplate::show($elements) !!}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <input type="hidden" name="id" value="{{ $rowItem['id'] ?? '' }}">
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
	<script>
		$(document).ready(function(){
			$('#file').change(function(event){
				var file = URL.createObjectURL(event.target.files[0]);
				$('.img-upload').attr('src',file);
			});
			/* Watermark */
			$(".watermark-position label").click(function(){
				if($(".change-photo img").length)
				{
					var img = $(".change-photo img").attr("src");
					if(img)
					{
						$(".watermark-position label img").attr("src","img/noimage.png");
						$(this).find("img").attr("src",img);
						$(this).find("img").show();
					}
				}
				else
				{
					notifyDialog("Dữ liệu hình ảnh không hợp lệ");
					return false;
				}
			})
		});

	/*function previewWatermark(){
		$o = $("#form-watermark");
		var formData = new FormData();
		formData.append('file', $('#file')[0].files[0]);
		formData.append('data', $o.serialize());

		$.ajax({
			type:'POST',
			url: "index.php?com=photo&act=save-watermark&type=<?=(isset($type) && $type != '') ? $type : ''?>",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(data){
				Swal.fire({
					imageUrl: "assets/images/ajax-loader.gif",
					customClass: {
						confirmButton: 'btn btn-sm bg-gradient-primary text-sm',
					},
					buttonsStyling: false,
					confirmButtonText: '<i class="mr-2 fas fa-check"></i>Đồng ý',
					showClass: {
						popup: 'animated fadeInDown faster'
					},
					hideClass: {
						popup: 'animated fadeOutUp faster'
					}
				})

				toDataURL('index.php?com=photo&act=preview-watermark&type=<?=(isset($type) && $type != '') ? $type : ''?>&position='+data.position+'&img='+data.image+'&watermark='+data.path+'&upload='+data.upload+'&opacity='+data.data.opacity+'&per='+data.data.per+'&small_per='+data.data.small_per+'&min='+data.data.min+'&max='+data.data.max+"&t="+data.time, function(dataUrl){$(".swal2-image").attr("src", dataUrl);})
			},
			error: function(data){
				console.log("error");
			}
		});

		return false;
	}*/
	</script>
@endsection

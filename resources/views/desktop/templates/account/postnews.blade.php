@extends('desktop.master')

@section('element_detail','page-manage')

@section('content')
	@php
		$validates = ($errors->any()) ? $errors->toArray() : null;
		$danhmuc_cap1 = app('danhmuc_cap1');
	@endphp

	<div class="login-layout">		
		<form id="manage-form" class="manage-form-contain" action="{{ route('account.postnews') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="manage-form-left">
				<div class="postnews-box-sticky">
					<div class="postnews-image postnews-form-img">
						<span id="photoUpload-preview" class="manage-form-img-preview">
							@if(isset($row_postnew['photo']) && $row_postnew['photo']!='')
							<img src="{{UPLOAD_POST.$row_postnew['photo']}}" alt="camera">	
							@else
							<img src="img/icon/icon_camera.png" alt="camera">
							@endif				
						</span>
						<p class="postnews-image-label">Hình đại diện (1024 x 650)</p>
						<label class="module-upload-file css-upload-file" id="photo-zone" for="file-zone" data-preview="photoUpload-preview">
							<input type="file" name="file" id="file-zone">
						</label>
					</div>

					<div class="postnews-file">
						<label for="fileupload">Upload tài liệu<br><span>(.xlsx, .docx, .pdf, .rar, .zip)</span></label>						
						<input type="file" name="fileupload" id="fileupload" accept=".doc,.docx,.xlsx,.pdf,.rar,.zip">
					</div>

					<div class="postnews-file-hasupload {{($row_postnew['fileupload']!='') ? 'd-block' : 'd-none'}}">
						<span class="postnews-file-remove" data-id="{{$row_postnew['id']}}"><i class="fal fa-times"></i></span>
						<label class="mb-0">File đã upload:</label></br>
						<span class="postnews-file-name">{{$row_postnew['fileupload']}}</span> <span class="postnews-file-unit">(~{{Helper::GetFileSize(UPLOAD_FILE.$row_postnew['fileupload'])}})</span>
					</div>

					<div class="postnews-image postnews-form-img d-none">
						<span id="photoUpload-preview-poster" class="manage-form-img-preview">
							@if(isset($row_postnew['poster']) && $row_postnew['poster']!='')
							<img src="{{UPLOAD_POST.$row_postnew['poster']}}" alt="camera">	
							@else
							<img src="img/icon/icon_poster.png" alt="camera">
							@endif						
						</span>
						<p class="postnews-image-label">Poster video (1990 x 896)</p>
						<label class="module-upload-file css-upload-file" id="photo-zone-poster" for="file-zone-poster" data-preview="photoUpload-preview-poster">
							<input type="file" name="poster" id="file-zone-poster">
						</label>
					</div>
				</div>
			</div>
			<div class="manage-form-right">		
				<div class="manage-form-guide"><a href="huong-dan-dang-tin" target="_blank"><i class="fal fa-bullseye-pointer mr-2"></i>Hướng dẫn đăng tin</a></div>		
				<div class="manage-form-field">
					<label for="danhmuctindang">Danh mục tin đăng</label>
					<select name="datapost[ids_level_1]" class="manage-form-field-select manage-form-field-select-level1">
						<option value="0">Chọn danh mục ---</option>
						@if(isset($danhmuc_cap1))
							@foreach($danhmuc_cap1 as $l=>$list)							
							<option value="{{$list['id']}}" {{(isset($row_postnew) && $row_postnew['ids_level_1']==$list['id']) ? 'selected' : ''}}>{{$list['tenvi']}}</option>
							@endforeach
						@endif
					</select>
					<span class="login-form-alert">{!!(isset($validates['ids_level_1'])) ? '<i class="fal fa-exclamation-triangle mr-1"></i>'.$validates['ids_level_1'][0] : ''!!}</span>
					<div id="postnews-show-category"></div>
				</div>

				<div class="manage-form-field">
					<label for="">Tiêu đề và nội dung</label>
					<input id="postnews-tieude" type="text" name="datapost[tenvi]" class="manage-form-field-input" placeholder="Tiêu đề *" value="{{(isset($row_postnew)) ? $row_postnew['tenvi'] : ''}}">
					<span class="login-form-alert">{!!(isset($validates['tenvi'])) ? '<i class="fal fa-exclamation-triangle mr-1"></i>'.$validates['tenvi'][0] : ''!!}</span>
					<input id="postnews-video" type="text" name="datapost[video]" class="manage-form-field-input mt-3" placeholder="Link Youtube" value="{{(isset($row_postnew)) ? $row_postnew['video'] : ''}}">
					<textarea id="postnews-mota" name="datapost[motavi]" class="manage-form-field-textarea mt-3" rows="5" placeholder="Mô tả bài viết">{{(isset($row_postnew)) ? $row_postnew['motavi'] : ''}}</textarea>
					<span class="login-form-alert">{!!(isset($validates['motavi'])) ? '<i class="fal fa-exclamation-triangle mr-1"></i>'.$validates['motavi'][0] : ''!!}</span>
					<div class="mt-3">
						<textarea id="postnews-noidung" name="datapost[noidungvi]" class="manage-form-field-textarea control-ckeditor" rows="10" placeholder="Nội dung bài viết">{{(isset($row_postnew)) ? $row_postnew['noidungvi'] : ''}}</textarea>
						<span class="login-form-alert">{!!(isset($validates['noidungvi'])) ? '<i class="fal fa-exclamation-triangle mr-1"></i>'.$validates['noidungvi'][0] : ''!!}</span>
					</div>
				</div>

				<div class="manage-form-field">
					<label for="">Nội dung SEO</label>
					<input id="postnews-titlevi" type="text" name="datapost[titlevi]" class="manage-form-field-input" placeholder="Title" value="{{(isset($row_postnew)) ? $row_postnew['titlevi'] : ''}}">
					<input id="postnews-keywordsvi" type="text" name="datapost[keywordsvi]" class="manage-form-field-input mt-3" placeholder="Keywords" value="{{(isset($row_postnew)) ? $row_postnew['keywordsvi'] : ''}}">
					<textarea id="postnews-descriptionvi" name="datapost[descriptionvi]" class="manage-form-field-textarea mt-3" rows="5" placeholder="Description">{{(isset($row_postnew)) ? $row_postnew['descriptionvi'] : ''}}</textarea>					
				</div>

				<div class="manage-form-field">
					<label for="">Loại tin</label>
					<span class="login-form-alert">{!!(isset($validates['loaitin'])) ? '<i class="fal fa-exclamation-triangle mr-1"></i>'.$validates['loaitin'][0] : ''!!}</span>
					<div class="manage-form-field-radio">
						<input type="radio" id="postnews-mienphi" name="datapost[loaitin]" class="manage-post-radio" value="0" {{(isset($row_postnew) && $row_postnew['loaitin']==0) ? 'checked' : ''}} {{(!isset($row_postnew)) ? 'checked' : ''}}>
						<label for="postnews-mienphi">Miễn phí</label>
						<input type="radio" id="postnews-traphi" name="datapost[loaitin]" class="manage-post-radio" value="1" {{(isset($row_postnew) && $row_postnew['loaitin']==1) ? 'checked' : ''}}>
						<label for="postnews-traphi">Trả phí</label>
						@if($user->congtacvien==1)
						<input type="radio" id="postnews-theothang" name="datapost[loaitin]" class="manage-post-radio" value="2" {{(isset($row_postnew) && $row_postnew['loaitin']==2) ? 'checked' : ''}}>
						<label for="postnews-theothang">Theo tháng</label>
						@endif
					</div>
				</div>

				<div id="show_kieutin" class="{{(isset($row_postnew) && $row_postnew['loaitin']==1) ? 'd-block' : 'd-none'}}">
					<div class="manage-form-field">
						<label for="postnews-luotxemgioihan">Số vé xem (1 tài khoản là 1 vé)</label>
						<span class="login-form-alert">(Giới hạn số tài khoản có thể đăng ký xem tin)</span>
						<input id="postnews-luotxemgioihan" type="number" name="datapost[luotxemgioihan]" class="manage-form-field-input" placeholder="" value="{{(isset($row_postnew)) ? $row_postnew['luotxemgioihan'] : ''}}">
					</div>

					<div class="manage-form-field">
						<label for="postnews-kieuxem" class="mr-4">Kiểu xem:</label>
						<input type="radio" id="kieuxem-1lan" name="kieuxem" value="0" {{ (isset($row_postnew) && $row_postnew['kieuxem']==0) ? 'checked' : '' }}>
						<label for="kieuxem-1lan" class="mr-4">trong 24h</label>
						<input type="radio" id="kieuxem-vinhvien" name="kieuxem" value="1" {{ (isset($row_postnew) && $row_postnew['kieuxem']==1) ? 'checked' : '' }}>
						<label for="kieuxem-vinhvien">vĩnh viễn</label><br>
						{{-- <span class="login-form-alert d-none">(Kiểu xem 1 lần sẽ có hiệu lực xem tin trong 24h kể từ thời điểm đăng ký xem tin)</span> --}}
					</div>

					<div class="manage-form-field">
						<label for="postnews-soxuphaitra">Số xu người dùng trả cho mỗi lượt mua</label>
						<input id="postnews-soxuphaitra" type="number" name="datapost[soxuphaitra]" class="manage-form-field-input" placeholder="" value="{{(isset($row_postnew)) ? $row_postnew['soxuphaitra'] : ''}}">
					</div>

					<div class="manage-form-field">
						<label for="postnews-soxudukien">Số xu dự kiến nhận lại mỗi lượt mua</label>
						<span class="login-form-alert mt-0">(Số xu này là số xu dự kiến theo admin quy định, không chỉnh sửa được ở đây)</span>
						<input id="postnews-soxudukien" type="number" class="manage-form-field-input" placeholder="" value="" readonly>
					</div>
				</div>

				@if($tags)
				@php
					$tag_selected = (isset($row_postnew) && $row_postnew['id_tags']!='') ? explode(',',$row_postnew['id_tags']) : null;
				@endphp
				<div class="manage-form-field mt-4">
					<label for="">Tags từ khóa</label>
					<span class="login-form-alert">{!!(isset($validates['id_tags'])) ? '<i class="fal fa-exclamation-triangle mr-1"></i>'.$validates['id_tags'][0] : ''!!}</span>
					<div class="manage-form-field-radio">
						@foreach($tags as $k=>$v)
						<input type="checkbox" id="postnews-tag-{{$k}}" name="datatags[]" class="manage-post-radio" value="{{$v['id']}}" {{ ($tag_selected && in_array($v['id'], $tag_selected)) ? 'checked' : '' }}>
						<label for="postnews-tag-{{$k}}">{{$v['tenvi']}}</label>
						@endforeach
					</div>
				</div>
				@endif

				<div class="manage-form-field mt-5 mb-0">
					<select name="datapost[nguon]" class="manage-form-field-select">
						<option value="0">Nguồn</option>
						@if($nguontins)
							@foreach($nguontins as $k=>$v)
							<option value="{{$v['id']}}" {{(isset($row_postnew) &&  $row_postnew['nguon']==$v['id']) ? 'selected' : ''}}>{{$v['ten'.$lang]}}</option>
							@endforeach
						@endif
					</select>
				</div>

				<div class="manage-form-field mt-5 mb-0">
					<span class="manage-form-binhchon-btn"><i class="fal fa-plus-circle mr-1"></i>Tạo bình chọn</span>
					<div id="manage-form-binhchon" class="manage-form-binhchon">
						<input type="text" name="databinhchon[tieude]" value="{{(isset($binhchons)) ? $binhchons['tieude'] : ''}}" placeholder="Tiêu đề bình chọn" class="manage-form-binhchon-input">
						<input type="hidden" name="databinhchon[id]" value="{{(isset($binhchons)) ? $binhchons['id'] : ''}}">

						<div class="manage-form-options">
							<div class="manage-form-option-template d-none">
								<div class="manage-form-option manage-form-sample mt-2">
									<i class="far fa-dot-circle mr-2"></i>
									<input type="text" name="databinhchon[giatri][]" class="manage-form-binhchon-input" placeholder="Phương án">
									<span class="manage-form-option-remove">Xóa</span>
								</div>
							</div>

							@if(isset($binhchons))
								@php
									$binhchon_options = $binhchons['has_all_options'];
								@endphp
								@foreach($binhchon_options as $k=>$v)
								<div class="manage-form-option manage-form-option-{{$v['id']}} mt-2">
									<i class="far fa-dot-circle mr-2"></i>
									<input type="text" class="manage-form-binhchon-input" value="{{$v['value']}}" placeholder="Phương án" readonly>
									<span class="manage-form-option-remove manage-form-option-delete" data-id="{{$v['id']}}">Xóa</span>
								</div>
								@endforeach
							@else
								<div class="manage-form-option manage-form-sample mt-2">
									<i class="far fa-dot-circle mr-2"></i>
									<input type="text" name="databinhchon[giatri][]" class="manage-form-binhchon-input" placeholder="Phương án 1">
									<span class="manage-form-option-remove">Xóa</span>
								</div>
							@endif
						</div>
						<span class="manage-form-add-option">+ Thêm phương án</span>
					</div>
				</div>

				<div class="manage-form-post-buttons mt-4">
					<a href="#" class="postnews-btn postnews-btn-preview">Xem trước</a>
					<button type="submit" class="postnews-btn postnews-btn-submit">Đăng tin</button>
				</div>

				<input type="hidden" name="id" value="{{(isset($row_postnew['id'])) ? $row_postnew['id'] : ''}}">
				<input type="hidden" name="ids_level_1" value="{{(isset($row_postnew['ids_level_1'])) ? $row_postnew['ids_level_1'] : ''}}">
				<input type="hidden" name="ids_level_2" value="{{(isset($row_postnew['ids_level_2'])) ? $row_postnew['ids_level_2'] : ''}}">
				<input type="hidden" name="phantramxunhan" value="{{(100 - $settingOption['phantramhoahong'])}}">
			</div>
		</form>
	</div>
@endsection

@push('css_page')
	<link rel="stylesheet" href="{{ asset('css/manage.css') }} ">
@endpush


<!--js thêm cho mỗi trang-->
@push('js_page')
	<script>
		$('.manage-form-add-option').click(function(){
			var div = $('.manage-form-option-template').find('.manage-form-option').clone(true);
			$('.manage-form-options').append(div);
		});

		$('.manage-form-option-remove').click(function(){
			$(this).parent('.manage-form-sample').remove();
		});

		$('.manage-form-option-delete').click(function(){
			var id = $(this).attr('data-id');

			$.ajax({
				url: '{{route('account.deleteBinhchonOption')}}',
				type: "GET",
				dataType: 'json',
				data: {id:id},
				success: function(result){
					if(result.result == false){
						Swal.fire({
						  title: '<p class="h6">'+result.text+'</p>',		 
						  icon: result.icon,
						  cancelButtonColor: '#d33',
						  cancelButtonText: 'Đã hiểu',
						});	
					}else{
						$('.manage-form-option-'+id).remove();
					}
				}
			});
		});

		$('.postnews-file-remove').click(function(){
			var id = $(this).attr('data-id');
			$('.postnews-file-hasupload').removeClass('d-block').addClass('d-none');
			$('#fileupload').val("");

			$.ajax({
				url: '{{route('account.deleteFileupload')}}',
				type: "GET",
				dataType: 'json',
				data: {id:id},
				success: function(result){}
			});
		});
	</script>


	<!-- ckeditor -->
	<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>

	<script>
		/* Ckeditor */
		var url_ckeditor = "{{ URL::to('/') }}/";
		var options_ckfinder = {
		    filebrowserBrowseUrl: url_ckeditor+'public/ckfinder/ckfinder.html',
	        filebrowserImageBrowseUrl: url_ckeditor+'public/ckfinder/ckfinder.html?type=Images',
	        filebrowserFlashBrowseUrl: url_ckeditor+'public/ckfinder/ckfinder.html?type=Flash',
	        filebrowserUploadUrl: url_ckeditor+'public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	        filebrowserImageUploadUrl: url_ckeditor+'public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	        filebrowserFlashUploadUrl: url_ckeditor+'public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
		};
		var options_lfm = {
		    filebrowserImageBrowseUrl: url_ckeditor+'laravel-filemanager?type=Images',
		    filebrowserImageUploadUrl: url_ckeditor+'laravel-filemanager/upload?type=Images&_token=',
		    filebrowserBrowseUrl: url_ckeditor+'laravel-filemanager?type=Files',
		    filebrowserUploadUrl: url_ckeditor+'laravel-filemanager/upload?type=Files&_token='
		};

		$(".control-ckeditor").each(function(){
			var id = $(this).attr("id");
			CKEDITOR.replace(id);
		})

		CKEDITOR.editorConfig = function( config ) {
			/* Config General */
			config.language = 'vi';
			config.skin = 'moono-lisa';
			config.width = 'auto';
			config.height = 620;

			/* Allow element */
			config.allowedContent = true;

			/* Entities */
			config.entities = false;
			config.entities_latin = false;
			config.entities_greek = false;
			config.basicEntities = false;

			/* Config CSS */
			config.contentsCss =
			[
			"{{ asset('public/ckeditor/contents.css') }}"
			];

			/* All Plugins */
			config.extraPlugins = 'texttransform,copyformatting,html5video,html5audio,flash,youtube,wordcount,tableresize,widget,lineutils,clipboard,dialog,dialogui,widgetselection,lineheight,video,videodetector';

			/* Config Lineheight */
			config.line_height = '1;1.1;1.2;1.3;1.4;1.5;2;2.5;3;3.5;4;4.5;5';

			/* Config Word */
			config.pasteFromWordRemoveFontStyles = false;
			config.pasteFromWordRemoveStyles = false;

			/* Config ELFinder */
			//config.filebrowserBrowseUrl = 'http://localhost/MyProject/public/elfinder/index.php';
			config.filebrowserBrowseUrl = '{{ route('elfinder.user') }}';//'http://localhost/MyProject/elfinder';

			/* Config ToolBar */
			config.toolbar = [
			{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
			{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'PasteFromExcel', '-', 'Undo', 'Redo' ] },
			{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
			{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
			'/',
			{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
			{ name: 'texttransform', items: [ 'TransformTextToUppercase', 'TransformTextToLowercase', 'TransformTextCapitalize', 'TransformTextSwitcher' ] },
			{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
			{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
			{ name: 'insert', items: [ 'Image', 'Flash', 'Youtube', 'VideoDetector', 'Html5video', 'Video', 'Html5audio', 'Iframe', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak' ] },
			'/',
			{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize', 'lineheight' ] },
			{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
			{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
			{ name: 'about', items: [ 'About' ] }
			];

			/* Config StylesSet */
			config.stylesSet = [
			{ name : 'Font Seguoe Regular', element : 'span', attributes : { 'class' : 'segui' } },
			{ name : 'Font Seguoe Semibold', element : 'span', attributes : { 'class' : 'seguisb' } },
			{ name:'Italic title', element:'span', styles:{'font-style':'italic'} },
			{ name:'Special Container', element:'div', styles:{'background' : '#eee', 'border' : '1px solid #ccc', 'padding' : '5px 10px'} },
			{ name:'Big', element:'big' },
			{ name:'Small', element:'small' },
			{ name:'Inline ', element:'q' },
			{ name : 'marker', element : 'span', attributes : { 'class' : 'marker' } }
			];

			/* Config Wordcount */
			config.wordcount = {
				showParagraphs: true,
				showWordCount: true,
				showCharCount: true,
				countSpacesAsChars: false,
				countHTML: false,
				filter: new CKEDITOR.htmlParser.filter({
					elements: {
						div: function( element ) {
							if(element.attributes.class == 'mediaembed') {
								return false;
							}
						}
					}
				})
			};
		};

	</script>


	<script>
		$(window).on('load', function () {
			$('.manage-form-field-select-level1').trigger('change');			
		});

		$('.manage-form-field-select-level1').change(function(){
			var id = $(this).val();
			var id_lv2 = $('input[name="ids_level_2"]').val();

			$.ajax({
				url: '{{route('ajax.loadcategorychild')}}',
				type: "GET",
				dataType: 'html',
				data: {id:id,id_lv2:id_lv2},
				success: function(result){
					$('#postnews-show-category').html(result);
				}
			});

		});


		$('.manage-post-radio').change(function(){
			if(this.value == '0' || this.value == '2') {
		        $('#show_kieutin').removeClass('d-block');
		        $('#show_kieutin').addClass('d-none');
		    }else if (this.value == '1') {
		        $('#show_kieutin').addClass('d-block');
		        $('#show_kieutin').removeClass('d-none');
		    }
		});
	</script>

	<script>
		/* preview tin*/
		$('.postnews-btn-preview').click(function(e){
			e.preventDefault();

			var url_blank = "{{ route('account.preview') }}";
			var formData = new FormData($('#manage-form')[0]);
			$(".control-ckeditor").each(function(){
				var id = $(this).attr("id");
				CKEDITOR.instances[id].updateElement();
			});

			$('#loading_order').show();
			
			//### load property group by level
		    $.ajax({
		        url: "{{ route('ajax.preview_post') }}",
		        type: 'POST',
				dataType: 'html',
				async: true,
				data: formData,
				processData: false,
			    contentType: false,
				success: function(result){						
					window.open(url_blank,"_blank");
				},
				complete: function(){
			        $('#loading_order').hide();
			    }
		    });

		});


		$('#postnews-soxuphaitra').keyup(function(){
			var val = $(this).val();
			var phantramxunhan = $('input[name="phantramxunhan"]').val();
			var result = (phantramxunhan/100)*val;
			$('#postnews-soxudukien').val(result);
			//console.log(result);
		});


		$('#fileupload').on('change', function() {
			var max_file_size = 5242880; // <==> 5mb
			var file_size = file_size_mb = parseInt(this.files[0].size);
			var file_change_mb = (max_file_size/1024)/1024;
			var file_size_extension = 'bytes';

			if(file_size_mb>=1024){
				file_size_mb/=1024;
				file_size_extension = 'Kb';
			}else if(file_size_mb>=1048576){
				file_size_mb/=1024;
				file_size_extension = 'Mb';
			}

			fileName = $(this).val().replace(/C:\\fakepath\\/i, '');
            fileExtension = fileName.substr((fileName.lastIndexOf('.') + 1));

			if (file_size > max_file_size) {
				$('#fileupload').val("");
                Swal.fire({
				  title: '<p class="h6">File upload không được lớn hơn '+(file_change_mb)+'Mb</p>',
				  icon: 'error',
				  cancelButtonColor: '#d33',
				  cancelButtonText: 'Đã hiểu',
				});	
                return false;

            } else {
                $('.postnews-file-hasupload').removeClass('d-none').addClass('d-block');
                $('.postnews-file-name').text(fileName);
                $('.postnews-file-unit').text('(~'+(parseInt(file_size_mb))+file_size_extension+')');
            }
			
            //$('#GFG_DOWN').text(this.files[0].size + "bytes");
        });
	</script>

@endpush


@push('strucdata')


@endpush
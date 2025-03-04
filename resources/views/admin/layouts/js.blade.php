<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Js Config -->
<script>
	var MIKOTECH = MIKOTECH || {};
	var CONFIG_ALL = @json($config_all ?? '');
	var CONFIG_BASE = CONFIG_ALL.config_base;
	var AUTOSAVE_TIME = CONFIG_ALL.autosave_time;
	var url_ckeditor = "{{ URL::to('/') }}/";
</script>

<input type="hidden" name="lang_sendemail" value="{{ __("Bạn muốn gửi thông tin cho các mục đã chọn ?") }}">
<input type="hidden" name="lang_select_one" value="{{ __("Bạn hãy chọn ít nhất 1 mục để gửi") }}">
<input type="hidden" name="lang_duongdankhonghople" value="{{ __("Đường dẫn không hợp lệ") }}">
<input type="hidden" name="lang_keovathahinhvaoday" value="{{ __("Kéo và thả hình vào đây") }}">
<input type="hidden" name="lang_hoac" value="{{ __("hoặc") }}">
<input type="hidden" name="lang_chonhinh" value="{{ __("Chọn hình") }}">
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui-1-13/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
{{-- <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> --}}
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- sweetalert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<!-- select2 -->
<script src="{{ asset('plugins/select2/select2.full.js') }}"></script>
<!-- sumoselect -->
<script src="{{ asset('plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<!-- ckeditor -->
<script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- Toggle Button -->
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<!-- AdminLTE App -->
<script src="{{ asset('plugins/filer/jquery.filer.js') }}"></script>

<script src="{{ asset('plugins/holdon/HoldOn.js') }}"></script>

<script src="{{ asset('plugins/sortable/Sortable.js') }}"></script>

<script src="{{ asset('js/priceFormat.js') }}"></script>

<script src="{{ asset('plugins/jscolor/jscolor.js') }}"></script>

<script src="{{ asset('plugins/rangeSlider/ion.rangeSlider.js') }}"></script>
<script src="{{ asset('plugins/jquery-jvectormap-2.0.5/jquery-jvectormap-2.0.5.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('js/pages/dashboard.js') }}"></script> --}}

<script type="text/javascript">
	let $filterCategory = $("select#filter_category");
	$filterCategory.on("change", function () {
        let ele = $(this);
        let selectValue = $(this).val();
        var pathname = window.location.pathname;
        let params = ["keyword"];
        let searchParams = new URLSearchParams(window.location.search); // ?filter_status=active
		const myArray = selectValue.split("|");
        let link = "";
        link += "filter_category_field=" + myArray[0] + "&" + "filter_category_value=" + myArray[1] + "&"; // 
        $.each(params, function (key, param) {
            // filter_status
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&"; // filter_status=active
            }
        });

        window.location.href =
                pathname +
                "?" +
                link;
    });

	/* Gallery Images */
	$(window).on('load', function () {
        if($('.modal_upload_image').length)
        {
            $.ajax({
                url: "{{ route('admin.ajax.loadImages') }}",
                type: 'GET',
                dataType: 'html',
                success: function(result){
                    if(result!=''){
                        $('.show-gallery-images').html(result);
                    }
                }
            });

            /* Gallery For ONE Images */
            $('body').on('click', '.modal_upload_one .miko-loadimage-item', function(){
		        $('.miko-loadimage-item').removeClass('miko-loadimage-active');
		        $(this).addClass('miko-loadimage-active');
		    });

		    $('body').on('dblclick', '.modal_upload_one .miko-loadimage-item', function(){
		    	var op = $(this).parents('.modal-content').find('.miko-submit-gallery').attr('data-op');
		        $('.miko-submit-gallery-'+op).trigger('click');
		    });

		    /* Gallery For MULTY Images */
            $('body').on('click', '.modal_upload_multy .miko-loadimage-item', function(){
            	if(!$(this).hasClass('miko-loadimage-active')){
            		$(this).addClass('miko-loadimage-active');
            	}else{
            		$(this).removeClass('miko-loadimage-active');
            	}
		    });

            /* Gallery Submit */
		    $('body').on('click', '.miko-submit-gallery', function(){
		    	var e_active = $('.miko-loadimage-active');
		        var id = e_active.attr('data-id');
		        var path = e_active.attr('data-path');
		        var url_photo = e_active.attr('data-photo-url');
		        var op = $(this).attr('data-op');

			    if(op!='multy'){
		        	$('#show-gallery-namephoto-'+op).val(url_photo);
			        $('#show-gallery-idphoto-'+op).val(id);
			        $('#show-gallery-photo-'+op).find('img').attr('src',path+url_photo);
			        $('#modal_upload_image_'+op).modal('hide');
		    	}else{
		    		var path_gallery = $(this).attr('data-path');
		    		var model = $('input[name="model"]').val();
		    		var id = $('input[name="id"]').val();
		    		var type = $('input[name="type"]').val();
		    		
		    		var arr_ids = [];
		    		$('.modal_upload_multy .miko-loadimage-active').each(function(){
		    			arr_ids.push($(this).attr('data-id'));
		    		});

		    		var ids = arr_ids.toString();

		    		$.ajax({
						url: "{{ route('admin.ajax.addGallery') }}",
						type: 'GET',
						dataType: 'html',
						data: {model:model,id:id,type:type,ids:ids},
						success: function(result){
							$('#show-gallery-photo-'+op).html(result);
							$('.miko-loadimage-item').removeClass('miko-loadimage-active');
						}
					});

		        	$('#modal_upload_image_'+op).modal('hide');
		    	}
		    });


		    $('body').on('click', '.miko-gallery-multy-delete', function(){
		    	console.log('deleteGalleryMulty');

		    	var e_delete = $(this);
		    	var model = $('input[name="model"]').val();
	    		var id = $('input[name="id"]').val();
	    		var type = $('input[name="type"]').val();
		    	var id_gallery = e_delete.attr('data-id');

		    	$.ajax({
					url: "{{ route('admin.ajax.deleteGalleryMulty') }}",
					type: 'GET',
					dataType: 'json',
					data: {model:model,id:id,type:type,id_gallery:id_gallery},
					success: function(result){
						if(result.status=='success'){
							e_delete.parents('.miko-gallery-item').remove();
						}
					}
				});
		    });


		    $('body').on('change', '#gallery-folder', function(){
		        var folder = $(this).val();

		        if(folder!=''){
		        	$('.miko-loadimage-item').addClass('d-none');
		        	$('.miko-loadimage-'+folder).removeClass('d-none');
		        }else{
		        	$('.miko-loadimage-item').removeClass('d-none');
		        }
		        
		    });
        }
    });


	/* Autosave */
	function AutoSave(model){		
        setInterval(function(){
		    $('.autosave-btn').trigger('click');
		}, AUTOSAVE_TIME*1000);
    }

    $('body').on('click', '.autosave-btn', function() {
    	var model = $(this).val();
    	var formData = new FormData($('.autosave-form')[0]);

    	$(".form-control-ckeditor").each(function(){
			var id = $(this).attr("id");
			CKEDITOR.instances[id].updateElement();
		})
    	
    	$.ajax({
			url: "{{ route('admin.ajax.autosave') }}",
			type: 'POST',
			dataType: 'json',
			data: formData,
			processData: false,
		    contentType: false,
			success: function(result){
				//console.log('ok');
			}
		});
	});


	/* Validation form */
	function ValidationFormSelf(ele){
	    window.addEventListener('load', function(){
	        var forms = document.getElementsByClassName(ele);
	        var validation = Array.prototype.filter.call(forms, function(form) {
	            form.addEventListener('submit', function(event) {
	                if (form.checkValidity() === false) {
	                    event.preventDefault();
	                    event.stopPropagation();
	                }
	                form.classList.add('was-validated');
	            }, false);
	        });
	        $("."+ele).find("input[type=submit],button[type=submit]").removeAttr("disabled");
	    }, false);
	}

	/* Validation form chung */
	ValidationFormSelf("validation-form");
	$.fn.exists = function(){
		return this.length;
	};

	/* HoldOn */
	function holdonOpen(theme="sk-rect",text="Text here",backgroundColor="rgba(0,0,0,0.8)",textColor="white")
	{
		var options = {
			theme: theme,
			message: text,
			backgroundColor: backgroundColor,
			textColor: textColor
		};

		HoldOn.open(options);
	}
	function holdonClose()
	{
		HoldOn.close();
	}

	/* Sweet Alert - Notify */
	function notifyDialog(text)
	{
		const swalconst = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-sm bg-gradient-primary text-sm',
			},
			buttonsStyling: false
		})
		swalconst.fire({
			text: text,
			icon: "info",
			confirmButtonText: '<i class="mr-2 fas fa-check"></i>Đồng ý',
			showClass: {
				popup: 'animated fadeIn faster'
			},
			hideClass: {
				popup: 'animated fadeOut faster'
			}
		})
	}

	/* Sweet Alert - Confirm */
	function confirmDialog(action,text,value)
	{
		const swalconst = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-sm bg-gradient-primary text-sm mr-2',
				cancelButton: 'btn btn-sm bg-gradient-danger text-sm'
			},
			buttonsStyling: false
		})
		swalconst.fire({
			text: text,
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: '<i class="mr-2 fas fa-check"></i>Đồng ý',
			cancelButtonText: '<i class="mr-2 fas fa-times"></i>Hủy',
			showClass: {
				popup: 'animated zoomIn faster'
			},
			hideClass: {
				popup: 'animated fadeOut faster'
			}
		}).then((result) => {
			if(result.value)
			{
				if(action == "create-seo") seoCreate();
				if(action == "push-onesignal") pushOneSignal(value);
				if(action == "send-email") sendEmail();
				if(action == "delete-filer") deleteFiler(value);
				if(action == "delete-all-filer") deleteAllFiler(value);
				if(action == "delete-item") deleteItem(value);
				if(action == "delete-all") deleteAll(value);
				if(action == "delete-gallery") deleteGallery(value);
				if(action == "delete-all-gallery") deleteAllGallery(value);
			}
		})
	}

	/* Reader image */
	function readImage(inputFile,elementPhoto){
		if(inputFile[0].files[0]){
			if(inputFile[0].files[0].name.match(/.(jpg|jpeg|png|gif)$/i)){
				var size = parseInt(inputFile[0].files[0].size) / 1024;

				if(size <= 4096){
					var reader = new FileReader();
					reader.onload = function(e){
						$(elementPhoto).attr('src', e.target.result);
					}
					reader.readAsDataURL(inputFile[0].files[0]);
				}else{
					notifyDialog("Dung lượng hình ảnh lớn. Dung lượng cho phép <= 4MB ~ 4096KB");
					return false;
				}
			}else{
				notifyDialog("Hình ảnh không hợp lệ");
				return false;
			}
		}else{
			notifyDialog("Dữ liệu không hợp lệ");
			return false;
		}
	}

	/* Youtube preview */
	function youtubePreview(url,element)
	{
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		if (url) {
			var match = url.match(regExp);
			url = (match&&match[7].length==11)? match[7] : false;
			$(element).attr("src","//www.youtube.com/embed/"+url).css({"width": "100%","height": "300"});
		}
	}

	/* SEO */
	seoChange();
	$('body').on("keyup",".title-seo, .keywords-seo, .description-seo",function(){
		seoCount($(this));
	})
	$('body').on("click",".create-seo",function(){
		if(seoExist()) confirmDialog("create-seo","Nội dung SEO đã được thiết lập. Bạn muốn tạo lại nội dung SEO ?","");
		else seoCreate();
	})


	function seoPreview(lang)
	{
		var titlePreview = "#title-seo-preview"+lang;
		var descriptionPreview = "#description-seo-preview"+lang;
		var title = $("#title"+lang).val();
		var description = $("#description"+lang).val();

		if($(titlePreview).length)
		{
			if(title) $(titlePreview).html(title);
			else $(titlePreview).html("Title");
		}

		if($(descriptionPreview).length)
		{
			if(description) $(descriptionPreview).html(description);
			else $(descriptionPreview).html("Description");
		}
	}

	function seoCount(obj)
	{		
		if(obj.length)
		{
			var countseo = parseInt(obj.val().toString().length);
			countseo = (countseo) ? countseo++ : 0;
			//console.log(countseo);
			obj.parents("div.form-group").find('.label').children("span.miko-label-seo").find(".count-seo span").html(countseo);
		}
	}
	function seoChange()
	{
		var seolang = "vi,en";
		var elementSeo = $('.card-seo .check-seo');

		elementSeo.each(function(index){
			var element = $(this).attr('id');
			var lang = element.substr(element.length-2);
			if(seolang.indexOf(lang)>=0)
			{
				if($("#"+element).length)
				{
					$('body').on("keyup","#"+element,function(){
						seoPreview(lang);
					})
				}
			}
		});
	}


	function seoExist()
	{
		var inputs = $('.card-seo input.check-seo');
		var textareas = $('.card-seo textarea.check-seo');
		var flag = false;

		if(!flag)
		{
			inputs.each(function(index){
				var input = $(this).attr('id');
				value = $("#"+input).val();
				if(value)
				{
					flag = true;
					return false;
				}
			});
		}

		if(!flag)
		{
			textareas.each(function(index){
				var textarea = $(this).attr('id');
				value = $("#"+textarea).val();
				if(value)
				{
					flag = true;
					return false;
				}
			});
		}

		return flag;
	}

	function seoCreate()
	{
		var flag = true;
		var seolang = $("#seo-create").val();
		var seolangArray = seolang.split(",");
		var seolangCount = seolangArray.length;
		var inputArticle = $('.card-article input.for-seo');
		var textareaArticle = $('.card-article textarea.for-seo');
		var textareaArticleCount = textareaArticle.length;
		var count = 0;
		var inputSeo = $('.card-seo input.check-seo');
		var textareaSeo = $('.card-seo textarea.check-seo');

		/* SEO Create - Input */
		inputArticle.each(function(index){
			var input = $(this).attr('id');
			var lang = input.substr(input.length-2);
			if(seolang.indexOf(lang)>=0)
			{
				ten = $("#"+input).val();
				ten = ten.substr(0,70);
				ten = ten.trim();
				$("#title"+lang+", #keywords"+lang).val(ten);
				seoCount($("#title"+lang));
				seoCount($("#keywords"+lang));
			}
		});

		/* SEO Create - Textarea */
		textareaArticle.each(function(index){
			var textarea = $(this).attr('id');
			var lang = textarea.substr(textarea.length-2);
			if(seolang.indexOf(lang)>=0)
			{
				if(flag)
				{
					var content = $("#"+textarea).val();

					if(!content && CKEDITOR.instances[textarea])
					{
						content = CKEDITOR.instances[textarea].getData();
					}

					if(content)
					{
						content = content.replace(/(<([^>]+)>)/ig,"");
						content = content.substr(0,160);
						content = content.trim();
						content = content.replace(/[\r\n]+/gm," ");
						$("#description"+lang).val(content);
						seoCount($("#description"+lang));
						flag = false;
					}
					else
					{
						flag = true;
					}
				}
				count++;
				if(count == (textareaArticleCount/seolangCount))
				{
					flag = true;
					count = 0;
				}
			}
		});

		/* SEO Preview */
		for(var i=0;i<seolangArray.length;i++) if(seolangArray[i]) seoPreview(seolangArray[i]);
	}

	/* Photo zone */
	function photoZone(eDrag,iDrag,eLoad){
		if($(eDrag).length){
			/* Drag over */
			$(eDrag).on("dragover",function(){
				$(this).addClass("drag-over");
				return false;
			});

			/* Drag leave */
			$(eDrag).on("dragleave",function(){
				$(this).removeClass("drag-over");
				return false;
			});

			/* Drop */
			$(eDrag).on("drop",function(e){
				e.preventDefault();
				$(this).removeClass("drag-over");

				var lengthZone = e.originalEvent.dataTransfer.files.length;

				if(lengthZone == 1){
					$(iDrag).prop("files", e.originalEvent.dataTransfer.files);
					readImage($(iDrag),eLoad);
				}else if(lengthZone > 1){
					notifyDialog("Bạn chỉ được chọn 1 hình ảnh để upload");
					return false;
				}else{
					notifyDialog("Dữ liệu không hợp lệ");
					return false;
				}
			});

			/* File zone */
			$(iDrag).change(function(){
				readImage($(this),eLoad);
			});
		}
	}

    function photoZoneOption(){
        $('.dev-options-item').each(function(){
            var op = $(this).attr('data-op');
            photoZone("#photo-zone-"+op,"#file-zone-"+op,"#photoUpload-preview-"+op+" img");
        });
    }
    

	$(document).ready(function(){
        /* Slug */
		slugPress();
		$('body').on("click","#slugchange",function(){
			slugChange($(this));
		})

        /* Select 2 */
		$('.select2').select2();

		/* Format price */
		$(".format-price").priceFormat({
			limit: 13,
			prefix: '',
			centsLimit: 0
		});

		/* PhotoZone */
        photoZoneOption();
		// photoZone("#photo-zone","#file-zone","#photoUpload-preview img");
		// photoZone("#photo-zone2","#file-zone2","#photoUpload-preview2 img");
		// photoZone("#photo-zone3","#file-zone3","#photoUpload-preview3 img");
        
        // photoZone("#photo-model-zone","#model-zone","#model-preview img");
        // photoZone("#photo-banner-zone","#banner-zone","#banner-preview img");
        // photoZone("#photo-descript-zone","#descript-zone","#descript-preview img");

        // photoZone("#photo-user-zone","#file-user-zone","#photoUpload-user img");
        // photoZone("#photo-color","#file-color","#photoUpload-color img");

        // photoZone("#photo-zone-background","#file-zone-background","#photoUpload-preview-background img");
		/* PhotoZone */
		var photoZoneItems = $('.photoUpload-zone');
		$.each(photoZoneItems, function (indexInArray, valueOfElement) { 
			var photoZoneId, fileZone, photoUploadPreview;
			photoZoneId = $(this).find('.photoUpload-file').attr('id');
			fileZoneId = $(this).find('input[type="file"]').attr('id');
			photoUploadPreviewId = $(this).find('.photoUpload-detail').attr('id');
			// photoZone("#photo-zone","#file-zone","#photoUpload-preview img");
			photoZone(`#${photoZoneId}`, `#${fileZoneId}`, `#${photoUploadPreviewId} img`);
		});


        /* Sumoselect */
		window.asd = $('.multiselect').SumoSelect({
			selectAll: true,
			search: true,
			searchText: 'Tìm kiếm'
		});


        /* Check required form */
		$('.submit-check').click(function(event){
			var $this;

			/* Holdon */
			holdonOpen("sk-rect","Vui lòng chờ...","rgba(0,0,0,0.8)","white");

			/* Check slug */
			slugCheck();

			/* Check slug danger */
			var elementSlug = $('.card-slug .text-danger:not(.d-none)');

			if(elementSlug.length)
			{
				elementSlug.each(function(){
					$this = $(this);
					var closest = elementSlug.closest('.tab-pane');
					var id = closest.attr('id');

					$('.nav-tabs a[href="#'+id+'"]').tab('show');

					return false;
				});

				setTimeout(function(){
					$('html,body').animate({scrollTop: $this.offset().top - 110},'medium');
				},500);

				holdonClose();

				return false;
			}

			/* Check tenvi */
			infoProCheck("tenvi"); //tham số đầu vào là tên id của div
            //return false;

			var elementTensp = $('#alert-tenvi-danger:not(.d-none)');
			if(elementTensp.length)
			{
				setTimeout(function(){
					$('html,body').animate({scrollTop: elementTensp.offset().top - 110},'medium');
				},500);

				holdonClose();
				return false;
			}

			/* Check masp */
			infoProCheck("masp"); //tham số đầu vào là tên id của div
			var elementMasp = $('#alert-masp-danger:not(.d-none)');
			if(elementMasp.length)
			{
				setTimeout(function(){
					$('html,body').animate({scrollTop: elementMasp.offset().top - 110},'medium');
				},500);

				holdonClose();
				return false;
			}
            /* Check masp option*/
            /*if(!checkMaSPoption()){
                holdonClose();
				return false;
            }*/
            //return false;//phải xóa bỏ

			/* Check input empty */
			var elementArticle = $('.card-article :required:invalid');
			if(elementArticle.length)
			{
				if($('.card').hasClass('collapsed-card'))
				{
					$('.card.collapsed-card .card-body').show();
					$('.card.collapsed-card .btn-tool i').toggleClass('fas fa-plus fas fa-minus');
					$('.card.collapsed-card').removeClass('collapsed-card');
				}

				elementArticle.each(function(){
					$this = $(this);
					var closest = elementArticle.closest('.tab-pane');
					var id = closest.attr('id');

					$('.nav-tabs a[href="#'+id+'"]').tab('show');

					return false;
				});

				setTimeout(function(){
					$('html,body').animate({scrollTop: $this.offset().top - 90},'medium');
				},500);

				holdonClose();
			}
			holdonClose();
		});

		/* Ckeditor */
		// var url_ckeditor = "{{ URL::to('/') }}/"; //http://localhost/MyProject/";
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
		$(".form-control-ckeditor").each(function(){
			var id = $(this).attr("id");
			CKEDITOR.replace(id);
		})
		/* Ckeditor custom */
		$(".form-control-ckeditor-custom").each(function(){
			var id = $(this).attr("id");
			CKEDITOR.replace( id, {
			    customConfig: url_ckeditor+'public/ckeditor/custom/ckeditor_config.js'
			});
		})
	});

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
		config.extraPlugins = 'texttransform,copyformatting,html5video,html5audio,flash,youtube,wordcount,tableresize,widget,lineutils,clipboard,dialog,dialogui,widgetselection,lineheight,video,videodetector,image2';

		/* Config Lineheight */
		config.line_height = '1;1.1;1.2;1.3;1.4;1.5;2;2.5;3;3.5;4;4.5;5';

		/* Config Word */
		config.pasteFromWordRemoveFontStyles = false;
		config.pasteFromWordRemoveStyles = false;

		/* Config ELFinder */
		//config.filebrowserBrowseUrl = 'http://localhost/MyProject/public/elfinder/index.php';
		config.filebrowserBrowseUrl = '{{ route('elfinder') }}';//'http://localhost/MyProject/elfinder';

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

	/* Slug \‘|\’| */
	function slugConvert(slug,focus=false){
		slug = slug.toLowerCase();
		slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
		slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
		slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
		slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
		slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
		slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
		slug = slug.replace(/đ/gi, 'd');
		slug = slug.replace(/\`|\~|\‘|\’|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
		slug = slug.replace(/ /gi, "-");
		slug = slug.replace(/\-\-\-\-\-/gi, '-');
		slug = slug.replace(/\-\-\-\-/gi, '-');
		slug = slug.replace(/\-\-\-/gi, '-');
		slug = slug.replace(/\-\-/gi, '-');

		if(!focus){
			slug = '@' + slug + '@';
			slug = slug.replace(/\@\-|\-\@|\@/gi, '');
		}

		return slug;
	}


	function slugPreview(title,lang,focus=false){
		var slug = slugConvert(title,focus);

		$("#slug"+lang).val(slug);
		$("#slugurlpreview"+lang+" strong").html(slug);
		$("#seourlpreview"+lang+" strong").html(slug);
	}


	function slugPreviewTitleSeo(title,lang){
		if($("#title"+lang).length){
			var titleSeo = $("#title"+lang).val();
			if(!titleSeo){
				if(title) $("#title-seo-preview"+lang).html(title);
				else $("#title-seo-preview"+lang).html("Title");
			}
		}
	}


	function slugPress(){
		var sluglang = "vi,en";
		var inputArticle = $('.card-article input.for-seo');
		var id = $('.slug-id').val();
		var seourlstatic = true;
		//var seourlstatic = $(".slug-seo-preview").data("seourlstatic");
        //alert(sluglang+'-'+inputArticle.val()+'-'+id+'-'+seourlstatic);

		inputArticle.each(function(index){
			var ten = $(this).attr('id');
			var lang = ten.substr(ten.length-2);

			if(sluglang.indexOf(lang)>=0){
				if($("#"+ten).length){
					$('body').on("keyup","#"+ten,function(){
						var title = $("#"+ten).val();

						if((id==0 || $("#slugchange").prop("checked")) && seourlstatic){
							/* Slug preivew */
							slugPreview(title,lang);
						}

						/* Slug preivew title seo */
						slugPreviewTitleSeo(title,lang);

						/* slug Alert */
						slugAlert(2,lang);
					})
				}

				if($("#slug"+lang).length){
					$('body').on("keyup","#slug"+lang,function(){
						var title = $("#slug"+lang).val();

						/* Slug preivew */
						slugPreview(title,lang,true);

						/* slug Alert */
						slugAlert(2,lang);
					})
				}
			}
		});
	}


	function slugChange(obj){
		if(obj.is(':checked')){
			/* Load slug theo tiêu đề mới */
			slugStatus(1);
			$(".slug-input").attr("readonly",true);
		}else{
			/* Load slug theo tiêu đề cũ */
			slugStatus(0);
			$(".slug-input").attr("readonly",false);
		}
	}


	function slugStatus(status){
		var sluglang = "vi,en";
		var inputArticle = $('.card-article input.for-seo');

		inputArticle.each(function(index){
			var ten = $(this).attr('id');
			var lang = ten.substr(ten.length-2);
			if(sluglang.indexOf(lang)>=0){
				var title = "";
				if(status == 1){
					if($("#"+ten).length){
						title = $("#"+ten).val();

						/* Slug preivew */
						slugPreview(title,lang);

						/* Slug preivew title seo */
						slugPreviewTitleSeo(title,lang);
					}
				}else if(status == 0){
					if($("#slug-default"+lang).length){
						title = $("#slug-default"+lang).val();

						/* Slug preivew */
						slugPreview(title,lang);

						/* Slug preivew title seo */
						slugPreviewTitleSeo(title,lang);
					}
				}
			}
		});
	}


	function slugAlert(result,lang){
		if(result == 1){
			$("#alert-slug-danger"+lang).addClass("d-none");
			$("#alert-slug-success"+lang).removeClass("d-none");
		}else if(result == 0){
			$("#alert-slug-danger"+lang).removeClass("d-none");
			$("#alert-slug-success"+lang).addClass("d-none");
		}else if(result == 2){
			$("#alert-slug-danger"+lang).addClass("d-none");
			$("#alert-slug-success"+lang).addClass("d-none");
		}
	}

    function slugCheck(){
		var sluglang = "vi,en";
		var slugInput = $('.slug-input');
		var id = $('.slug-id').val();
        var idOption = ($('input[name="idProOption"]').exists())?$('input[name="idProOption"]').val():0;
		var copy = $('.slug-copy').val();

		slugInput.each(function(index){
			var slugId = $(this).attr('id');
			var slug = $(this).val();
			var lang = slugId.substr(slugId.length-2);
            var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

			if(sluglang.indexOf(lang)>=0){
				if(slug){
					$.ajax({
						url: "{{ route('admin.ajax.slug') }}",
						type: 'POST',
						dataType: 'html',
						async: false,
						data: {slug:slug,id:id,copy:copy,idOption:idOption,_token:_token},
						success: function(result){
							slugAlert(result,lang);
						}
					});
				}
			}
		});
	}

    //check trùng lặp tên và mã sp
	function infoProAlert(result,element)
	{
		//console.log(result);
		//return false;
		if(result == 1)
		{
			$("#alert-"+element+"-danger").addClass("d-none");
			$("#alert-"+element+"-success").removeClass("d-none");
		}
		else if(result == 0)
		{
			$("#alert-"+element+"-danger").removeClass("d-none");
			$("#alert-"+element+"-success").addClass("d-none");
            return false;
		}
		else if(result == 2)
		{
			$("#alert-"+element+"-danger").addClass("d-none");
			$("#alert-"+element+"-success").addClass("d-none");
		}
	}


	function infoProCheck(element,option=false)
	{
        var kq=true;
		var infoInput = $('#'+element).val();
		var id = $('.slug-id').val();
		var copy = $('.slug-copy').val();
        var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
        var id_option='';

        if($('input[name="idProOption"]').exists()){
            id_option = $('input[name="idProOption"]').val();
        }

        if(option==true){
            var op = $('#'+element).attr('data-op');
            var group = $('#'+element).attr('data-group');
            var id_option = $('#hidden_idoption_'+group+'_'+op).val();
        }


		if(infoInput && !option)
		{
			$.ajax({
				url: "{{ route('admin.ajax.checkInfoPro') }}",
				type: 'POST',
				dataType: 'html',
				async: false,
				data: {element:element,infoInput:infoInput,id:id,copy:copy,option:option,id_option:id_option,_token:_token},
				success: function(result){
                    if(result==0)
                    {
                        kq=false;
                    }
					return infoProAlert(result,element);
				}
			});
		}
        return kq;
	}
	//### END check trùng lặp tên và mã sp


    function checkMaSPoption(){
        /* Check masp option*/
        var elementMasp = $('.masp_option_danger');
        var kq=true;

        if(elementMasp.length)
        {
            elementMasp.each(function(){
                var op = $(this).attr('data-op');
                var group = $(this).attr('data-group');
                var value = $(this).val();
                kq = infoProCheck('masp_option_'+group+'_'+op,true);
                if(value!=''){
                    $('#load-error-'+group+'-'+op).addClass('d-none');
                    kq=true;
                }else{
                    $('#load-error-'+group+'-'+op).removeClass('d-none');
                    kq=false;
                }
                if(kq==false && value!=''){
                    $('#load-warning-'+group+'-'+op).removeClass('d-none');
                }else{
                    $('#load-warning-'+group+'-'+op).addClass('d-none');
                }
            });
        }

        //check value input
        $(elementMasp).each(function(){
            var value_parent = $(this).val();
            var op = $(this).attr('data-op');
            var group = $(this).attr('data-group');
            $('.masp_option_danger').not(this).each(function(){
                var value_child = $(this).val();
                if((value_parent!='' && value_child!='') && (value_parent==value_child)){
                    kq=false;
                    $('#load-warning-'+group+'-'+op).removeClass('d-none');
                    $('#alert-masp_option_'+group+'-'+op+'-danger').removeClass('d-none');
                    $('#alert-masp_option_'+group+'-'+op+'-success').addClass('d-none');
                }
            });
        });
        //alert(kq);
        return kq;
    }

	/* Delete item */
	function deleteItem(url){
	    document.location = url;
	}

	/* Delete all */
	function deleteAll(url){
		var listid = "";

	    $("input.select-checkbox").each(function(){
	        if(this.checked) listid = listid+","+this.value;
	    });
	    listid = listid.substr(1);
	    if(listid == ""){
	    	notifyDialog("Bạn hãy chọn ít nhất 1 mục để xóa");
	    	return false;
	    }

	    if(url){
	    	var arr_url = url.split("?");
	    	if(arr_url.length>1){
	    		url = arr_url[0] +'/'+listid+'?'+arr_url[1];
	    		document.location = url;
	    	}else{
	    		document.location = url+'/'+listid;
	    	}
	    }
	    
	}

	/* Delete filer */
	function deleteFiler(string){
		var str = string.split(",");
		var id = str[0];
		var folder = str[1];
		var cmd = 'delete';
		var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

		$.ajax({
			type: 'POST',
			url: "{{ route('admin.ajax.filer') }}",
			data: {id:id,folder:folder,cmd:cmd,_token:_token}
		});

		$('.my-jFiler-item-'+id).remove();
		if($(".my-jFiler-items ul li").length==0) $(".form-group-gallery").remove();
	}
	
	/* Delete gallery */
	function deleteGallery(string){
		var str = string.split(",");
		var id = str[0];
		var folder = str[1];
		var cmd = 'delete';
		var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

		$.ajax({
			type: 'POST',
			url: "{{ route('admin.ajax.filer') }}",
			data: {id:id,folder:folder,cmd:cmd,_token:_token},
			success: function(){
				$('.miko-gallery-item-'+id).remove();
			}
			
		});
	}

	/* Delete all filer */
	function deleteAllFiler(folder)
	{
		var listid = "";
		var cmd = 'delete-all';
		var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
		var e_filter_main = $('.form-group-gallery-main');

	    $(e_filter_main).find("input.filer-checkbox").each(function(){
	        if(this.checked) listid = listid+","+this.value;
	    });
	    listid = listid.substr(1);
	    if(listid == "")
	    {
	    	notifyDialog("Bạn hãy chọn ít nhất 1 mục để xóa");
	    	return false;
	    }

		$.ajax({
			type: 'POST',
			url: "{{ route('admin.ajax.filer') }}",
			data: {listid:listid,folder:folder,cmd:cmd,_token:_token}
		});

		listid = listid.split(",");
		for(var i=0;i<listid.length;i++)
		{
			$(e_filter_main).find('.my-jFiler-item-'+listid[i]).remove();
		}

		if($(e_filter_main).find(".my-jFiler-items ul li").length==0) $(e_filter_main).find(".form-group-gallery-main").remove();

		refreshFiler(e_filter_main);
	}

	/* Delete all gallery */
	function deleteAllGallery(folder)
	{
		var listid = "";
		var cmd = 'delete-all';
		var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
		var e_filter_main = $('.miko-gallery-contain');

	    $(e_filter_main).find("input.gallery-checkbox").each(function(){
	        if(this.checked) listid = listid+","+this.value;
	    });
	    listid = listid.substr(1);
	    if(listid == "")
	    {
	    	notifyDialog("Bạn hãy chọn ít nhất 1 mục để xóa");
	    	return false;
	    }

		$.ajax({
			type: 'POST',
			url: "{{ route('admin.ajax.filer') }}",
			data: {listid:listid,folder:folder,cmd:cmd,_token:_token}
		});

		listid = listid.split(",");
		for(var i=0;i<listid.length;i++)
		{
			$(e_filter_main).find('.miko-gallery-item-'+listid[i]).remove();
		}
		$('.check-all-gallery').addClass('d-none');
		$('.delete-all-gallery').addClass('d-none');
	}

	/* Push OneSignal */
	function pushOneSignal(url)
	{
		document.location = url;
	}

	/* Create sort filer */
	var sortable;
	function createSortFiler(){
		var e_filter_main = $('#photo-upload-group');
		if($("#jFilerSortable").length){
			sortable = new Sortable.create(document.getElementById('jFilerSortable'),{
				animation: 600,
				swap: true,
				disabled: true,
				// swapThreshold: 0.25,
			    ghostClass: 'ghostclass',
			    multiDrag: true,
				selectedClass: 'selected',
				forceFallback: false,
				fallbackTolerance: 3,
				onEnd: function(){
					/* Get all filer sort */
					listid = new Array();
					jFilerItems = $("#jFilerSortable").find('.my-jFiler-item');
					jFilerItems.each(function(index){
						listid.push($(this).data("id"));
					})

					/* Update number */
					var idmuc = $('input[name="id"]').val();
					var com = $(e_filter_main).find('input[name="model"]').val();
					var kind = $(e_filter_main).find('input[name="level"]').val();
					var type = $(e_filter_main).find('input[name="type"]').val();
					var colfiler = $(e_filter_main).find(".col-filer").val();
					var actfiler = $(e_filter_main).find(".act-filer").val();
					var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
					var hash = $('input[name="hash"]').val();

					$.ajax({
						url: "{{ route('admin.ajax.filer') }}",
						type: 'POST',
						dataType: 'json',
						async: false,
						data: {idmuc:idmuc,listid:listid,com:com,kind:actfiler,type:type,colfiler:colfiler,cmd:'updateNumb',hash:hash,_token:_token},
						success: function(result){
							var arrid = result.id;
							var arrnumb = result.numb;
							for(var i=0;i<arrid.length;i++) $(e_filter_main).find('.my-jFiler-item-'+arrid[i]).find("input[type=number]").val(arrnumb[i]);
						}
					})
				},
			});
		}
	}


	/* Destroy sort filer */
	function destroySortFiler(){
		try{var destroy = sortable.destroy();}
		catch(e){}
	}

	/* Refresh filer when complete action */
	function refreshFiler(e_parent_group){
		$(e_parent_group).find(".sort-filer, .check-all-filer").removeClass("active");
		$(e_parent_group).find(".sort-filer").attr('disabled',false);
		$(e_parent_group).find(".alert-sort-filer").hide();
		if($(e_parent_group).find(".check-all-filer").find("i").hasClass("fas fa-check-square"))	{
			$(e_parent_group).find(".check-all-filer").find("i").toggleClass("far fa-square fas fa-check-square");
		}
		$(e_parent_group).find(".my-jFiler-items .jFiler-items-list").find('input.filer-checkbox').each(function(){
			$(this).prop('checked',false);
		});
	}

	/* Refresh filer if empty */
	function refreshFilerIfEmpty(element_parent_group){
		var idmuc = $('input[name="id"]').val();
		var com = $(element_parent_group).find('input[name="model"]').val();
		var type = $(element_parent_group).find('input[name="type"]').val();
		var colfiler = $(element_parent_group).find(".col-filer").val();
		var actfiler = $(element_parent_group).find(".act-filer").val();
        var time = 1;
        if($(element_parent_group).find('input[name="folder-time"]').length) time = $(element_parent_group).find('input[name="folder-time"]').val();
		var cmd = 'refresh';
		var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
		var hash = $('input[name="hash"]').val();

		var class_display = (hash=='gallery') ? '' : 'd-none';

		$.ajax({
			type: 'POST',
			dataType: 'html',
			url: "{{ route('admin.ajax.filer') }}",
			async: false,
			data: {idmuc:idmuc,com:com,kind:actfiler,type:type,colfiler:colfiler,time:time,cmd:cmd,hash:hash,_token:_token},
			success: function(result){
				$(element_parent_group).find(".jFiler-items-list").first().find(".jFiler-item").remove();
				destroySortFiler();

                $tmp = '<div class="form-group form-group-gallery form-group-gallery-main">';
                if(time==1){
    				$tmp +='<label class="label-filer">Album hiện tại:</label>'
    				+'<div class="mb-3 action-filer '+class_display+'">'
    				+'<a class="mr-1 text-white btn btn-sm bg-gradient-primary check-all-filer"><i class="mr-2 far fa-square"></i>Chọn tất cả</a>'
    				+'<button type="button" class="mr-1 text-white btn btn-sm bg-gradient-success sort-filer"><i class="mr-2 fas fa-random"></i>Sắp xếp</button>'
    				+'<a class="text-white btn btn-sm bg-gradient-danger delete-all-filer"><i class="mr-2 far fa-trash-alt"></i>{{ __('Xóa tất cả') }}</a>'
    				+'</div>'
    				+'<div class="text-sm text-white alert my-alert alert-sort-filer alert-info bg-gradient-info"><i class="mr-2 fas fa-info-circle"></i>Có thể chọn nhiều hình để di chuyển</div>';
                }
				$tmp += '<div class="jFiler-items my-jFiler-items jFiler-row">'
				+'<ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable">'
				+result
				+'</ul></div></div>';
				if(hash=='gallery'){$(".form-group-gallery-main").remove();}
				$("#filer-gallery").parents(".form-group").after($tmp);
				createSortFiler();
			}
		});
	}

	/* onChange Category */
	function filter_category(url){
		if($(".filer-category").length > 0 && url != ''){
			var id = '';
			var value = 0;
			url+='';
			$(".filer-category").each(function(){
				id = $(this).attr("id");
				if(id){
					value = $("#"+id).val();
					if(value){
						url += id+"="+value+"&";
					}
				}
			})
			url=url.slice(0, -1);
		}
		return url;
	}

	function onchange_category(obj){
		var name = '';
		var keyword = $("#keyword").val();
		var model = $(obj).attr("data-model");
		var level = $(obj).attr("data-level");
		var type = $(obj).attr("data-type");
		var route = "admin."+model+".show";
		var url = $(obj).attr("data-url")+'?';

		obj.parents(".form-group").nextAll().each(function(){
			name = $(this).find(".filer-category").attr("name");
			if($(this) != obj){
				$(this).find(".filer-category").val(0);
			}
		});
		url = filter_category(url);
		if(keyword){
			url += "&keyword="+encodeURI(keyword);
		}
		return window.location = url;
	}


	function onchange_category_all(obj){
		var name = '';
		var keyword = $("#keyword").val();
		var model = $(obj).attr("data-model");
		var level = $(obj).attr("data-level");
		var type = $(obj).attr("data-type");
		var route = "admin."+model+".show";
		var url = $(obj).attr("data-url")+'?';
		var category = $('#all_category').val();

		/*obj.parents(".form-group").nextAll().each(function(){
			name = $(this).find(".filer-category").attr("name");
			if($(this) != obj){
				$(this).find(".filer-category").val(0);
			}
		});*/

		//url = filter_category(url);
		if(keyword){
			url += "&keyword="+encodeURI(keyword);
		}

		return window.location = url+category;
	}

	/* Search */
	function doEnter(evt,obj,url){
		if(url==''){
			notifyDialog("Đường dẫn không hợp lệ");
			return false;
		}
		if(evt.keyCode == 13 || evt.which == 13) onSearch(obj,url);
	}

	function onSearch(obj,url){
		var pathname = window.location.pathname;
        let params = ["filter_category_field", "filter_category_value"];
        let searchParams = new URLSearchParams(window.location.search); // ?filter_status=active

        let link = "";
        $.each(params, function (key, param) {
            // filter_status
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&"; // filter_status=active
            }
        });

        // let search_field = $inputSearchField.val();
        let search_value = $("#"+obj).val();

		window.location.href =
                pathname +
                "?" +
                link +
                "&keyword=" +
                search_value;
	}

  	$(document).ready(function(){
		/* Ajax category */
		$('body').on('change','.select-category', function(){
		    var id = $(this).val();
		    var child = $(this).data("child");
		    var level = $(this).data('level');
		    var table = $(this).data('table');
		    var type = $(this).data('type');
		    var model = $(this).data('model');
		    var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

		    if($("#"+child).length)
		    {
		      $.ajax({
		        url: "{{ route('admin.ajax.category') }}",
		        method:"POST",
		        data:{model:model,level:level,id:id,table:table,type:type, _token:_token},
		        success: function(result)
		        {
		          var op = "<option value='0'>Chọn danh mục</option>";

		          if(level == 'list')
		          {
		            $("#id_cat").html(op);
		            $("#id_item").html(op);
		            $("#id_sub").html(op);
		          }
		          else if(level == 'cat')
		          {
		            $("#id_item").html(op);
		            $("#id_sub").html(op);
		          }
		          else if(level == 'item')
		          {
		            $("#id_sub").html(op);
		          }
		          $("#"+child).html(result);
		        }
		      });

		      return false;
			}
		});


        /* Ajax category places */
		$('body').on('change','.select-category-places', function(){
		    var id = $(this).val();
		    var child = $(this).data("child");
		    var level = $(this).data('level');
		    var table = $(this).data('table');
		    var type = $(this).data('type');
		    var model = $(this).data('model');
            var title = $(this).data('title');
		    var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

		    if($("#"+child).length)
		    {
		      $.ajax({
		        url: "{{ route('admin.ajax.categoryPlaces') }}",
		        method:"POST",
		        data:{model:model,level:level,id:id,table:table,type:type,title:title, _token:_token},
		        success: function(result)
		        {
		          if(level == 'list')
		          {
		            $("#id_district").html("<option value='0'>Chọn quận huyện</option>");
		            $("#id_wards").html("<option value='0'>Chọn phường xã</option>");
		          }
		          else if(level == 'cat')
		          {
		            $("#id_wards").html("<option value='0'>Chọn phường xã</option>");
		          }        
		          $("#"+child).html(result);
		        }
		      });

		      return false;
			}
		});


		/* Change status */
		//$('body').on('click','.show-checkbox',function(){
		$('.show-checkbox').click(function(){
			var $this = $(this);
			var input = $this.find('input');
			var children = $this.children();
			var id = input.attr('data-id');
			var model = input.attr('data-model');
			var level = input.attr('data-level');
			var loai = input.attr('data-loai');
			var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

			$.ajax({
				url: "{{ route('admin.ajax.status') }}",
				type: 'POST',
				//dataType: 'html',
				data: {id:id,model:model,level:level,loai:loai,_token:_token},
				success: function()
				{
					if(input.is(':checked'))
					{
						children.removeClass('btn-success');
						children.addClass('btn-light off');
						//alert($input.attr('data-loai'));
						input.prop('checked',false);
					}
					else {
						//alert($input.attr('data-table'));
						children.removeClass('btn-light off');
						children.addClass('btn-success');
						input.prop('checked',true);
					}
				}
			});

			return false;
		})

		/* Change stt */
		$('body').on("change","input.update-stt",function(){
			var id = $(this).attr('data-id');
			var model = $(this).attr('data-model');
			var level = $(this).attr('data-level');
			var value = $(this).val();
			var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

			$.ajax({
				url: "{{ route('admin.ajax.stt') }}",
				type: 'POST',
				//dataType: 'html',
				data: {id:id,model:model,level:level,value:value,_token:_token}
			});

			return false;
		})

		$('.delete-item').click(function(){
			var url = $(this).data("url");			
			confirmDialog("delete-item","Bạn có chắc muốn xóa mục này ?",url);
		});

		/* Delete item */
		/*$('body').on('click','.delete-item', function(){			
			var url = $(this).data("url");			
			confirmDialog("delete-item","Bạn có chắc muốn xóa mục này ?",url);
	    });*/

	    /* Delete all */
		$('body').on('click','#delete-all', function(){
			var url = $(this).data("url");			
			confirmDialog("delete-all","Bạn có chắc muốn xóa những mục này ?",url);
	    });

	    /* Check all */
		$('body').on('click','#checkAll', function(){
			var parentTable = $(this).parents('table');
			var input = parentTable.find('input.select-checkbox');

			if($(this).is(':checked'))
			{
				input.each(function(){
					$(this).prop('checked',true);
				});
			}
			else
			{
				input.each(function(){
					$(this).prop('checked',false);
				});
			}
		});

		/* Check all */
		$('body').on('click','#checkAllProduct', function(){
			var parentTable = $(this).parents('.miko-products');
			var input = parentTable.find('input.product-checkbox');

			if($(this).is(':checked'))
			{
				input.each(function(){
					$(this).prop('checked',true);
				});
			}
			else
			{
				input.each(function(){
					$(this).prop('checked',false);
				});
			}
		});

		/* Filer */
		var e_filter_main = $('#photo-upload-group');
		var lang_keovathahinhvaoday = $('input[name="lang_keovathahinhvaoday"]').val();
		var lang_hoac = $('input[name="lang_hoac"]').val();
		var lang_chonhinh = $('input[name="lang_chonhinh"]').val();
		$("#filer-gallery").filer({
            limit: null,
            maxSize: null,
            extensions: ["jpg","png","jpeg","JPG","PNG","JPEG","Png"],
            changeInput: `<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>${lang_keovathahinhvaoday}</h3> <span style="display:inline-block; margin: 15px 0">${lang_hoac}</span></div><a class="jFiler-input-choose-btn blue">${lang_chonhinh}</a></div></div>`,
			theme: "dragdropbox",
            showThumbs: true,
            addMore: true,
            allowDuplicates: false,
            clipBoardPaste: false,
            dragDrop: {
				dragEnter: null,
				dragLeave: null,
				drop: null,
				dragContainer: null
            },
            captions: {
                button: "Thêm hình",
                feedback: "Vui lòng chọn hình ảnh",
                feedback2: "Những hình đã được chọn",
                drop: "Kéo hình vào đây để upload",
                removeConfirmation: "Bạn muốn loại bỏ hình ảnh này ?",
                errors: {
                	@verbatim
                	filesLimit: "Chỉ được upload mỗi lần {{fi-limit}} hình ảnh",
                    filesType: "Chỉ hỗ trợ tập tin là hình ảnh có định dạng: {{fi-extensions}}",
                    filesSize: "Hình {{fi-name}} có kích thước quá lớn. Vui lòng upload hình ảnh có kích thước tối đa {{fi-maxSize}} MB.",
                    filesSizeAll: "Những hình ảnh bạn chọn có kích thước quá lớn. Vui lòng chọn những hình ảnh có kích thước tối đa {{fi-maxSize}} MB."
                    @endverbatim
                }
            },
            afterShow: function(){
            	var jFilerItems = $(e_filter_main).find(".my-jFiler-items .jFiler-items-list li.jFiler-item");
            	var jFilerItemsLength = 0;
            	var jFilerItemsLast = 0;
            	if(jFilerItems.length)
            	{
            		jFilerItemsLength = jFilerItems.length;
            		jFilerItemsLast = parseInt(jFilerItems.last().find("input[type=number]").val());
            	}
            	$(".jFiler-items-list li.jFiler-item").each(function(index){
            		var colClass = $(".col-filer").val();
            		var parent = $(this).parent();
            		if(!parent.is("#jFilerSortable"))
            		{
            			jFilerItemsLast += 1;
	            		$(this).find("input[type=number]").val(jFilerItemsLast);
            		}
	            	if(!$(this).hasClass(colClass)) $("li.jFiler-item").addClass(colClass);
            	});
            },
            uploadFile: {
				url: "{{ route('admin.ajax.upload') }}",
				data: {data:$("#filer-gallery").data(),model:$(e_filter_main).find("input[name='model']").val(),level:$(e_filter_main).find("input[name='level']").val(),type:$(e_filter_main).find("input[name='type']").val(),id:$("input[name='id']").val(),time:$(e_filter_main).find('input[name="folder-time"]').val(), hash:$(e_filter_main).find("input[name='hash']").val(),_token:$('input[name="_token"]').val()},
				type: 'POST',
				enctype: 'multipart/form-data',
				dataType: 'json',
				async: false,
				beforeSend: function(){
					//alert(data);
					holdonOpen("sk-rect","Vui lòng chờ...","rgba(0,0,0,0.8)","white");
				},
				success: function(data, el){
					data = JSON.parse(data);
					if(data['success'] == true)
					{
						var parent = el.find(".jFiler-jProgressBar").parent();
						el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
							$("<div class = \"jFiler-item-others text-success\"><i class = \"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
						});
					}
					else
					{
						var parent = el.find(".jFiler-jProgressBar").parent();
						el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
							$("<div class = \"jFiler-item-others text-error\"><i class = \"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
						});
					}
				},
				error: function(el){
					var parent = el.find(".jFiler-jProgressBar").parent();
					el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
						$("<div class = \"jFiler-item-others text-error\"><i class = \"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
					});
				},
				onComplete: function(){
					refreshFiler(e_filter_main);

					if($(e_filter_main).find(".my-jFiler-item-info").length)
					{
						$(e_filter_main).find(".jFiler-items-list").first().find(".jFiler-item").remove();
						$(e_filter_main).find(".my-jFiler-item-info").trigger("change");
					}
					else
					{						
						refreshFilerIfEmpty(e_filter_main);
					}
					holdonClose();
				},
				statusCode: {},
				onProgress: function(){},
			},

			templates: {
				@verbatim
                box: '<ul class="jFiler-items-list jFiler-items-grid row scroll-bar"></ul>',
                item: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-thumb-overlay">\
                                            <div class="jFiler-item-info">\
                                                <div style="display:table-cell;vertical-align: middle;">\
                                                    <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                    <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li>{{fi-progressBar}}</li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                    <input type="number" class="mb-1 form-control form-control-sm" name="stt-filer[]" placeholder="Số thứ tự"/>\
                                    <input type="text" class="form-control form-control-sm" name="ten-filer[]" placeholder="Tiêu đề"/>\
                                </div>\
                            </div>\
                        </li>',
                itemAppend: '<li class="jFiler-item">\
                                <div class="jFiler-item-container">\
                                    <div class="jFiler-item-inner">\
                                        <div class="jFiler-item-thumb">\
                                            <div class="jFiler-item-status"></div>\
                                            <div class="jFiler-item-thumb-overlay">\
                                                <div class="jFiler-item-info">\
                                                    <div style="display:table-cell;vertical-align: middle;">\
                                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                        <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                            {{fi-image}}\
                                        </div>\
                                        <div class="jFiler-item-assets jFiler-row">\
                                            <ul class="list-inline pull-left">\
                                                <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                            </ul>\
                                            <ul class="list-inline pull-right">\
                                                <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                            </ul>\
                                        </div>\
                                        <input type="number" class="mb-1 form-control form-control-sm" name="stt-filer[]" placeholder="Số thứ tự"/>\
                                    	<input type="text" class="form-control form-control-sm" name="ten-filer[]" placeholder="Tiêu đề"/>\
                                    </div>\
                                </div>\
                            </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: true,
                canvasImage: false,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-items-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action'
                }
                @endverbatim
            }
        });

		@if(isset($gallery) && count($gallery) > 0)
			/* Sort filer */
			createSortFiler();
		@endif

		/* Check all filer */
		$('body').on('click','.check-all-filer', function(){
			var e_upload_main = $('.form-group-gallery-main');
			var e_filter_main = $('#jFilerSortable');

			var parentFiler = $(e_upload_main).find(".my-jFiler-items .jFiler-items-list");
			var input = parentFiler.find('input.filer-checkbox');
			var jFilerItems = $("#jFilerSortable").find('.my-jFiler-item');
			//console.log(input);

			$(this).find("i").toggleClass("far fa-square fas fa-check-square");
			if($(this).hasClass('active'))
			{
				$(this).removeClass('active');
				$(e_filter_main).find(".sort-filer").removeClass("active");
				$(e_filter_main).find(".sort-filer").attr('disabled',false);
				input.each(function(){
					$(this).prop('checked',false);
				});
			}
			else
			{
				sortable.option("disabled",true);
				$(this).addClass('active');
				$(e_filter_main).find(".sort-filer").attr('disabled',true);
				$(e_filter_main).find(".alert-sort-filer").hide();
				$(e_filter_main).find(".my-jFiler-item-trash").show();
				input.each(function(){
					$(this).prop('checked',true);
				});
				jFilerItems.each(function(){
					$(this).find('input').attr('disabled',false);
				});
				jFilerItems.each(function(){
					$(this).removeClass('moved');
				});
			}
		});

		/* Check filer */
		$('body').on('click','.filer-checkbox',function(){
			var e_filter_main = $('.form-group-gallery-main');
			var input = $(e_filter_main).find(".my-jFiler-items .jFiler-items-list").find('input.filer-checkbox:checked');

			if(input.length) $(e_filter_main).find(".sort-filer").attr('disabled',true);
			else $(e_filter_main).find(".sort-filer").attr('disabled',false);
		});

		/* Sort filer */
		$('body').on('click','.sort-filer', function(){
			var e_filter_main = $('.form-group-gallery-main');
			var jFilerItems = $("#jFilerSortable").find('.my-jFiler-item');

			if($(this).hasClass('active'))
			{
				sortable.option("disabled",true);
				$(this).removeClass('active');
				$(e_filter_main).find(".alert-sort-filer").hide();
				$(e_filter_main).find(".my-jFiler-item-trash").show();
				jFilerItems.each(function(){
					$(this).find('input').attr('disabled',false);
					$(this).removeClass('moved');
				});
			}
			else
			{
				sortable.option("disabled",false);
				$(this).addClass('active');
				$(e_filter_main).find(".alert-sort-filer").show();
				$(e_filter_main).find(".my-jFiler-item-trash").hide();
				jFilerItems.each(function(){
					$(this).find('input').attr('disabled',true);
					$(this).addClass('moved');
				});
			}
		});

		/* Delete filer */
		$("body").on("click",".my-jFiler-item-trash",function(){
			var id = $(this).data("id");
			var folder = $(this).data("folder");
			var str = id+","+folder;
			confirmDialog("delete-filer","Bạn có chắc muốn xóa hình ảnh này ?",str);
			createSortFiler();
        });

        /* Delete all filer */
		$("body").on("click",".delete-all-filer",function(){
			var folder = $(".folder-filer").val();
			confirmDialog("delete-all-filer","Bạn có chắc muốn xóa các hình ảnh đã chọn ?",folder);
			createSortFiler();
        });


        /* Hash upload multi filer */
		/*$("form.validation-form").append('<input type="hidden" name="hash" value="{{ Helper::generateHash() }}" />');*/
		$("#filer-gallery").attr({'data-hash':$('input[name="hash"]').val()});

        /* Change info filer */
        $('body').on('change','.my-jFiler-item-info', function(){
        	
			var id = $(this).data("id");
			var info = $(this).data("info");
			var value = $(this).val();
			var idmuc = $('input[name="id"]').val();
			var com = $('input[name="model"]').val();
			var kind = $('input[name="level"]').val();
			var type = $('input[name="type"]').val();
			var colfiler = $(".col-filer").val();
			var actfiler = $(".act-filer").val();
			var cmd = 'info';
			var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
			var hash = $('input[name="hash"]').val();

			$.ajax({
				type: 'POST',
				dataType: 'html',
				url: "{{ route('admin.ajax.filer') }}",
				async: false,
				data: {id:id,idmuc:idmuc,info:info,value:value,com:com,kind:actfiler,type:type,colfiler:colfiler,cmd:cmd,hash:hash,_token:_token},
				success: function(result)
				{
					destroySortFiler();
					$("#jFilerSortable").html(result);
					createSortFiler();
				}
			});

			return false;
        });

	});
</script>

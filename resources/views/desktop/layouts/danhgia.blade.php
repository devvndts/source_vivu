<div class="flex items-center justify-between" id="example-5">
    <span class="flex-1 text-2xl text-black">Đánh giá</span>
</div>
<div class="product-comment-stats mt-6 bg-[#FBECD5] p-5">
    <div class="flex justify-between items-center">
        <div class="danhgia-layout-total flex items-end flex-1 min-w-0">
            <div class="danhgia-layout-score text-4xl text-primary font-semibold">{{ $average_score }}.0</div>
            <div class="danhgia-layout-stars ml-6">
                <div class="danhgia-list-stars ">
                    @for ($i = 1; $i <= $average_score; $i++)
                        <i class="fas fa-star bg-clip-text text-transparent bg-product-gradient"></i>
                    @endfor
                    @for ($i = $average_score + 1; $i <= 5; $i++)
                        <i class="far fa-star bg-clip-text text-transparent bg-product-gradient"></i>
                    @endfor
                </div>
            </div>
            <div class="danhgia-count-stars ml-5 font-semibold text-sm text-black">
                ({{ $info_rating['allrating'] ?? 0 }} lượt đánh giá)</div>
        </div>
        <button type="button"
            class="btn-danhgia-submit inline-block px-4 py-1.5 bg-product-gradient text-white font-medium text-lg leading-6 rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Gửi
            bình luận</button>
    </div>

    <div class="form-danhgia">
        <form method="POST" action="" id="form-danhgia">
            @csrf
            <div class="form-danhgia-content">
                <span class="form-danhgia-close"><i class="fal fa-times"></i></span>
                <div class="form-danhgia-title">Đánh giá</div>
                <div class="form-danhgia-value">
                    <div class="form-danhgia-product">
                        <img src="{{ Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo'], 69, 77, 2, $row_detail['type']) }}"
                            alt="{{ $row_detail['ten' . $lang] }}" width="69" height="77">
                        <div class="form-danhgia-product-name ml-2">{{ $row_detail['ten' . $lang] }}</div>
                    </div>
                    <div class="form-danhgia-rating">
                        <p class="form-danhgia-rating-ask">Bạn đánh giá sản phẩm thế nào ?</p>
                        <div class="form-danhgia-rating-star">
                            <div class="form-star-item" data-value="1"><i class="far fa-star"></i><span>Rất tệ</span>
                            </div>
                            <div class="form-star-item" data-value="2"><i class="far fa-star"></i><span>Tệ</span></div>
                            <div class="form-star-item" data-value="3"><i class="far fa-star"></i><span>Bình
                                    thường</span></div>
                            <div class="form-star-item" data-value="4"><i class="far fa-star"></i><span>Tốt</span></div>
                            <div class="form-star-item" data-value="5"><i class="far fa-star"></i><span>Rất Tốt</span>
                            </div>
                        </div>
                    </div>
                    <textarea name="rating_content" placeholder="Cảm nhận của bạn..." class="form-rating-content"></textarea>
                    <div class="rating-input-file">
                        <input type="file" class="my-pond" name="photos[]" id="rating-file" multiple
                            data-allow-reorder="true" data-max-file-size="3MB" data-max-files="4">
                    </div>
                    <div class="form-danhgia-infomation">
                        <input type="text" name="rating_name" placeholder="Họ và tên (*)" required>
                        <input type="text" name="rating_phone" placeholder="Số điện thoại (*)" required>
                        <input type="email" name="rating_email" placeholder="Email (*)" required>
                    </div>
                    <p class="form-danhgia-submit"><input type="submit" name="" id="form-rating-submit"
                            class="form-rating-submit" value="Gửi đánh giá"></p>
                    <input type="hidden" name="rating_count_star" value="1" id="rating-count-star">
                    <input type="hidden" name="rating_id_product" value="{{ $row_detail['id'] }}">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="box-danhgia-list mt-4" id="show_danhgia_ajax">
    @if (isset($danhgia_list) && $danhgia_list)
        @foreach ($danhgia_list as $k => $v)
            @php
                $arr_name = explode(' ', $v['tenvi']);
                $name = $arr_name[count($arr_name) - 1];
                $photos = json_decode($v['photo'], true);
            @endphp
            <div
                class="product-comment-item py-5 border border-[#845536] border-x-0 border-b-0 border-opacity-20 first:border-t-0 flex justify-between">
                <div class="product-comment-item__info flex-1 min-w-0 flex justify-between">
                    <figure class="w-16 h-16 rounded-full mr-6 flex-shrink-0">
                        {{-- <img class="w-full h-full rounded-full" src="" alt=""> --}}
						<span class="w-full h-full rounded-full text-white bg-slate-600 flex justify-center items-center text-2xl uppercase">{{Str::substr($name, 0, 1);}}</span>
                    </figure>
                    <div class="flex-1 min-w-0 ">
                        <div class="text-black">{{$v['tenvi']}}</div>
                        <div class="flex mt-1 mb-3">
							@for ($i = 1; $i <= $v['star']; $i++)
							<i class="fas ml-1 fa-star bg-clip-text text-transparent bg-product-gradient"></i>
							@endfor
							@for ($i = $v['star'] + 1; $i <= 5; $i++)
							<i class="far ml-1 fa-star bg-clip-text text-transparent bg-product-gradient"></i>
							@endfor
                            <span
                                class="text-opacity-50 text-[#845536] text-xs font-semibold ml-5">{{ date('d/m/Y', $v['ngaytao']) }}
                                lúc {{ date('h:m', $v['ngaytao']) }}</span>
                        </div>
                        <div class="mb-4"> {{ $v['noidungvi'] }} </div>
                    </div>
                </div>
                <div class="product-comment-item__image w-1/5 flex-shrink-0 flex justify-end">
                    @if ($photos)
                        @foreach ($photos as $p => $photo)
                            <a data-src="{{ UPLOAD_IMAGE . $photo }}" data-fancybox="danhgia-{{ $k }}"
                                class="w-16 h-16 ml-4 flex-shrink-0">
								<img class="w-full h-full" src="{{ Thumb::Crop(UPLOAD_IMAGE, $photo, 88, 88, 2) }}"
                                    alt=""></a>
                        @endforeach
                    @endif
                </div>
            </div>
            {{-- <div class="box-danhgia-item">
				<span class="box-danhgia-char">{{Str::substr($name, 0, 1);}}</span>
				<div class="box-danhgia-info">
					<div class="box-danhgia-infoname">
						<div class="box-danhgia-name mr-2">{{$v['tenvi']}}</div>
						<div class="box-danhgia-time">{{Helper::TimeElapsed($v['ngaytao'])}}</div>
					</div>
					<div class="box-danhgia-infostar">
						<div class="box-danhgia-star-list mr-2">
							@for ($i = 1; $i <= $v['star']; $i++)
								<i class="fas fa-star"></i>
							@endfor
							@for ($i = $v['star'] + 1; $i <= 5; $i++)
								<i class="far fa-star"></i>
							@endfor
						</div>
						<div class="box-danhgia-confirm"><i class="far fa-badge-check"></i> <span>Đã mua sản phẩm</span></div>
					</div>
					<div class="box-danhgia-content mt-3">{{$v['noidungvi']}}</div>
					<div class="box-danhgia-photos mt-3">
						@if ($photos)
							@foreach ($photos as $p => $photo)
								@if (Helper::CheckFile($photo) == 'mp4')
									<a data-src="{{UPLOAD_IMAGE.$photo}}" data-fancybox="danhgia-{{$k}}" class="mr-1">
										<p class="danhgia-load-canvas" video="{{Helper::GetConfigBase().UPLOAD_IMAGE.$photo}}" data-id="{{$k.'-'.$p}}">
											<video id="video-{{$k.'-'.$p}}" class="video-btn" widht="88" height="88">
												<source type="video/mp4" src="{{Helper::GetConfigBase().UPLOAD_IMAGE.$photo}}"><!-- FireFox 3.5 -->
												Your browser does not support HTML5 video tag. Please download FireFox 3.5 or higher.
											</video>
											<canvas id="video-canvas-{{$k.'-'.$p}}"></canvas>
											<img id="video-img-{{$k.'-'.$p}}" src="" class="d-none video-img">
										</p>
									</a>
								@else
									<a data-src="{{UPLOAD_IMAGE.$photo}}" data-fancybox="danhgia-{{$k}}" class="mr-1"><img src="{{Thumb::Crop(UPLOAD_IMAGE,$photo,88,88,2)}}" alt=""></a>
								@endif
							@endforeach
							<a data-src="https://play-ws.vod.shopee.com/c3/98934353/103/AnoyC48AlO1ZkvwhegEVAEc.mp4" data-fancybox="danhgia-{{$k}}" class="mr-1"><img src="https://1500000774.vod2.myqcloud.com/412c22d9vodhk1500000774/4619d615387702296282136545/387702296282136546.jpg"></a>
						@endif
					</div>
					<div class="box-danhgia-date mt-2">{{date('d/m/Y', $v['ngaytao'])}} lúc {{date('h:m', $v['ngaytao'])}}</div>

					@if ($v['answer'] != '')
					<div class="box-hoidap-answer mt-3"> 
						<div class="box-hoidap-answer-admin"> 
							<span class="box-hoidap-answer-img">
								<img src="{{Thumb::Crop(UPLOAD_USER,$setting['photo'],35,35,1)}}" alt="admin">
							</span> 
							<div class="box-hoidap-answer-info"> 
								<span class="box-hoidap-answer-name">Admin</span> 
								<div class="box-hoidap-answer-content">{{$v['answer']}}</div> 
							</div> 
						</div> 
					</div>
					@endif
				</div>
			</div> --}}
        @endforeach

        @if (isset($danhgia_list) && !is_array($danhgia_list))
            <div class="clear"></div>
            <div class="row">
                <div class="col-sm-12 dev-center dev-paginator">{{ $danhgia_list->links() }}</div>
            </div>
        @endif
    @endif
</div>



@push('css_page')
    <link rel="stylesheet" href="{{ asset('css/filepond/filepond.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filepond/filepond-plugin-image-preview.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <link rel="stylesheet" href="{{ asset('css/danhgia.css') }} ">
@endpush


@push('js_page')
    <script src="{{ asset('js/uuidv4.min.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-file-encode.min.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-image-resize.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-file-rename.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-file-validate-size.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-image-validate-size.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-image-transform.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-image-crop.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond.jquery.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

    <script>
        $('.form-danhgia-close').click(function() {
            $('.form-danhgia').removeClass('form-danhgia-active');
        });


        $('.btn-danhgia-submit').click(function() {
            $('.form-danhgia').addClass('form-danhgia-active');
        });

        $('.form-star-item').click(function() {
            var value = parseInt($(this).attr('data-value'));

            $('.form-star-item').find('i').removeClass('far fa-star fas');
            for (var i = 1; i <= value; i++) {
                $('.form-star-item').eq(i - 1).find('i').addClass('fas fa-star');
            }
            for (var i = (value + 1); i <= 5; i++) {
                $('.form-star-item').eq(i - 1).find('i').addClass('far fa-star');
            }

            $('#rating-count-star').val(value);
        });
    </script>

    <script>
        // First register any plugins
        $.fn.filepond.registerPlugin(
            FilePondPluginFileEncode,
            FilePondPluginFileRename,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType,
            FilePondPluginImageValidateSize,
            FilePondPluginImageResize,
            FilePondPluginImageTransform,
            FilePondPluginImageCrop,
            FilePondPluginImagePreview
        );

        $.fn.filepond.setDefaults({
            labelIdle: '+ Thêm hình ảnh minh họa',
            acceptedFileTypes: ['image/png', 'image/jpeg', 'video/quicktime', 'video/mp4'],
            imageValidateSizeMinWidth: 200,
            imageValidateSizeMaxWidth: 2000,
            imageValidateSizeMinHeight: 200,
            imageValidateSizeMaxHeight: 2000,
            imageResizeMode: 'force',
            imageCropAspectRatio: '1:1'
        });

        $('.my-pond').filepond();

        FilePond.setOptions({
            fileRenameFunction: (file) => {
                return uuidv4() + `${file.extension}`;
            }
        })

        $('.my-pond-reply').filepond();
        FilePond.setOptions({
            fileRenameFunction: (file) => {
                return uuidv4() + `${file.extension}`;
            }
        })

        FilePond.create({
            imageResizeTargetWidth: 1000,
            imageCropAspectRatio: 1,
            imageTransformVariants: {
                thumb_medium_: (transforms) => {
                    transforms.resize = {
                        size: {
                            width: 1000,
                            height: 1000,
                        },
                    };
                    return transforms;
                }
            },
        });

        $('#form-danhgia').submit(function(e) {
            e.preventDefault();
            //$('#loading_order').show();

            var formData = new FormData($('#form-danhgia')[0]);

            $.ajax({
                url: '{{ route('ajax.add.danhgia') }}',
                type: "POST",
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result) {
                        Swal.fire({
                            position: 'top',
                            icon: result.icon,
                            title: '<p class="h6">' + result.text + '</p>',
                            showConfirmButton: false,
                            timer: 2500,
                            toast: true
                        });
                        $('.form-danhgia').removeClass('form-danhgia-active');
                        $('.form-star-item').find('i').removeClass('fas fa-star');
                        $('.form-star-item').find('i').addClass('far fa-star');
                        $('#form-danhgia')[0].reset();
                        location.reload(true);
                    }
                },
                complete: function() {}
            });
        });


        $('.danhgia-type-select').click(function() {
            var type = $(this).attr('data-type');
            var id_product = $(this).attr('data-idproduct');

            $('.danhgia-type-select').removeClass('danhgia-type-check');
            $(this).addClass('danhgia-type-check');

            pagination_danhgia(type, id_product);
        });


        //### click page number button
        $(document).on('click', '#show_danhgia_ajax .pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var type = $('.danhgia-type-select').attr('data-type');
            var id_product = $('.danhgia-type-select').attr('data-idproduct');

            pagination_danhgia(type, id_product, page);
        });


        function pagination_danhgia(type, id_product, page = 0) {
            $.ajax({
                url: '{{ route('ajax.change.danhgia') }}',
                type: "GET",
                dataType: 'html',
                async: true,
                data: {
                    type: type,
                    id_product: id_product,
                    page: page
                },
                success: function(result) {
                    $('#show_danhgia_ajax').html(result);
                },
                complete: function() {}
            });
        }


        //### Cut thumb video
        /*$('.danhgia-load-canvas').each(function(){
    			var id = $(this).attr('data-id');
    			//var video = $('#video-'+id);
    			let video = document.querySelector('#video-'+id);
    			let canvas = document.querySelector("#video-canvas-"+id);
    			let ctx = canvas.getContext("2d");

    			let width = 0;
    			let height = 0;				

    			video.load();
    			video.currentTime = 0;

    		    video.addEventListener("loadedmetadata", function () {//loadedmetadata pause		    	
    		    	$('#video-'+id).trigger('click');
    		        width = this.videoWidth;
    		        height = this.videoHeight;	

    		        // Set canvas dimensions same as video dimensions
       				canvas.width = width;
    				canvas.height = height;
    				ctx.drawImage(video, 0, 0);
    		    });
    		});*/
    </script>
@endpush

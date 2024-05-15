@php
	$danhmuc3_1 = app('danhmuc_cap1');
	$danhmuc3_2 = app('danhmuc_cap2');
	$danhmuc3_3 = app('danhmuc_cap3');
	// $danhmuc3 = app('danhmuc_cap3');
	$danhmuc3 = array_merge($danhmuc3_1, $danhmuc3_2, $danhmuc3_3);
	$is_pagination = (isset($question) && !is_array($question)) ? true : false;
	//dd($count_question);
@endphp

<div class="home-news bortop padlr">
	<h2 class="home-title"><span>Hỏi đáp</span></h2>
	<div class="center-layout px-0">
		<form action="" method="POST" class="form-hoidap display-relative" id="form-hoidap">
			@csrf			
			<input type="hidden" value="{{(isset($type_question)) ? $type_question : 'product'}}" name="hoidap[type]" id="question_type">
			<input type="hidden" value="{{(isset($model_question)) ? $model_question : 'product'}}" name="hoidap[model]" id="question_model">
			<input type="hidden" value="{{(isset($id_item)) ? $id_item : 0}}" name="hoidap[id_item]" id="question_id_item">
			<input type="hidden" value="{{(isset($id_category)) ? $id_category : 0}}" name="hoidap[id_category]" id="question_id_category">

			<input type="hidden" value="{{$is_pagination}}" name="is_pagination" id="question_pagination">
			<input type="hidden" value="{{(isset($type_question)) ? $type_question : 'product'}}" name="question_type">
			<input type="hidden" value="{{(isset($model_question)) ? $model_question : 'product'}}" name="question_model">
			
			<p class="form-hoidap-alert d-none"><i class="far fa-hand-point-down"></i> Vui lòng nhập nội dung</p>
			<div class="form-hoidap-top">
				<textarea name="hoidap[noidung]" placeholder="Nhập câu hỏi của bạn" class="form-hoidap-area" required></textarea>
				<input type="button" value="Gửi" class="form-hoidap-submit">
			</div>
			<div class="form-hoidap-count">
				<span id="show_count_question">
					@if(isset($count_question))
						{{count($count_question)}}
					@else
						{{(isset($question) && count($question)) ? count($question) : 0}}
					@endif					
				</span> Bình luận
			</div>

				<div class="form-hoidap-bottom">
					<div class="form-hoidap-filter">
						@if (!isset($type_question) || $type_question==='product')
							<select class="form-hoidap-select">
								<option value="">Danh mục</option>
								@if($danhmuc3)
									@foreach($danhmuc3 as $k=>$v)
										<option value="{{$v['id']}}">{{$v['ten'.$lang]}}</option>
									@endforeach
								@endif
							</select>
						@endif
						<input type="text" class="form-hoidap-search" placeholder="Tìm theo nội dung ...">
					</div>
				</div>
			<!--modal info user-->
			<div class="form-hoidap-modal">
				<div class="form-hoidap-input">
					<div class="form-hoidap-input-header">Thông tin người gửi <span class="form-hoidap-close"><i class="fal fa-times"></i></span></div>
					<div class="form-hoidap-input-body">
						<div class="d-flex align-items-center mb-2">
				            <label class="d-flex align-items-center mr-2">
				              <input type="radio" name="hoidap[gioitinh]" value="0" checked="">
				              <span class="pl-1">Anh</span>
				            </label>
				            <label class="d-flex align-items-center">
				              <input type="radio" name="hoidap[gioitinh]" value="1">
				              <span class="pl-1">Chị</span>
				            </label>
				          </div>
						<input type="text" name="hoidap[hoten]" class="form-control mb-2" placeholder="Họ tên (bắt buộc)" required>
						<input type="email" name="hoidap[email]" class="form-control mb-2" placeholder="Email (để nhận phản hồi qua mail)">
						<input type="text" name="hoidap[dienthoai]" class="form-control" placeholder="Số điện thoại" >
					</div>
					<div class="form-hoidap-input-footer">
						<input type="submit" value="Gửi câu hỏi">
					</div>
				</div>
			</div>
		</form>

		<div class="box-hoidap-list mt-2" id="show_question_ajax">
			@if(isset($question) && $question)
				@foreach($question as $k=>$v)
				@php
					$arr_name = explode(' ', $v['hoten']);
					$name = $arr_name[count($arr_name)-1];
				@endphp
				<div class="box-hoidap-item">
					<span class="box-hoidap-char">{{Str::substr($name, 0, 1);}}</span>
					<div class="box-hoidap-info">
						<div class="box-hoidap-name-cate">
							<span class="box-hoidap-name">{{$v['hoten']}}</span>
							@if($v['model']=='category')
								@php
									$danhmuc = Helper::getInfoCategory($v['id_item']);
								@endphp
								<span class="box-hoidap-cate ml-2">{{$danhmuc['tenvi'] ?? ''}}
							</span>@endif
						</div>
						<div class="box-hoidap-question">{!! $v['noidung'] !!}</div>

						@if($v['answer']!='')
						<div class="box-hoidap-time">Trả lời <span>- {{Helper::TimeElapsed($v['ngayduyet'])}}</span></div>
						<div class="box-hoidap-answer">
							<div class="box-hoidap-answer-admin">
								<span class="box-hoidap-answer-img"><img src="{{Thumb::Crop(UPLOAD_USER,$setting['photo'],35,35,1)}}" alt="admin"></span>
								<div class="box-hoidap-answer-info">
									<span class="box-hoidap-answer-name">Admin</span>
									<div class="box-hoidap-answer-content">{{$v['answer']}}</div>
								</div>
							</div>
						</div>
						@endif
					</div>
				</div>
				@endforeach

				@if(isset($question) && !is_array($question))
					<div class="clear"></div>
			        <div class="row">
			           <div class="col-sm-12 dev-center dev-paginator">{{ $question->links() }}</div>
			        </div>
		        @endif

			@endif
		</div>
		@if((isset($question) && count($question)>0 && count($question)<=2) || (isset($count_question) && count($count_question)<=2))<p class="form-hoidap-more display-relative"><a href="cau-hoi">Xem tất cả</a></p>@endif
	</div>
</div>


@push('js_page')
	<script>
		$('body').on('click', '.form-hoidap-submit', function(){
			var val_content = $('.form-hoidap-area').val();
			if(val_content==''){
				$('.form-hoidap-alert').removeClass('d-none');
				$('.form-hoidap-area').focus();
				return false;
			}else{
				if(!$('.form-hoidap-alert').hasClass('d-none')){
					$('.form-hoidap-alert').addClass('d-none');
				}
				$('.form-hoidap-modal').addClass('form-hoidap-active');
			}
		});


		$('body').on('click', '.form-hoidap-close', function(){
			$('.form-hoidap-modal').removeClass('form-hoidap-active');
		});	


		//### enter form search
		$(".form-hoidap-search").keypress(function (e) {
			if (e.which == 13) { 
				var id = $('.form-hoidap-select').val();
				var id_item = $('#question_id_item').val();
				var keyword = $(this).val();
				var is_pagination = $('input[name="is_pagination"]').val();
				var type = $('input[name="question_type"]').val();
				var model = $('input[name="question_model"]').val();

				pagination_data(id,id_item,keyword,is_pagination,type,model);

			 	return false; 
			}
		});


		//### change select
		$('body').on('change', '.form-hoidap-select', function(){
			var id = $(this).val();
			var id_item = $('#question_id_item').val();
			var keyword = $('.form-hoidap-search').val();
			var is_pagination = $('input[name="is_pagination"]').val();
			var type = $('input[name="question_type"]').val();
			var model = $('input[name="question_model"]').val();

			/*if(id!=0){
				model = 'category';
			}*/

			pagination_data(id,id_item,keyword,is_pagination,type,model);

		});	


		//### click page number button
		$(document).on('click', '.ajax-pagination .pagination a', function(event){
			event.preventDefault();
				var page = $(this).attr('href').split('page=')[1];
				var id = $('.form-hoidap-select').val();
				var id_item = $('#question_id_item').val();
				var keyword = $('.form-hoidap-search').val();
				var is_pagination = $('input[name="is_pagination"]').val();
				var type = $('input[name="question_type"]').val();
				var model = $('input[name="question_model"]').val();

				pagination_data(id,id_item,keyword,is_pagination,type,model,page);
		});


		function pagination_data(id,id_item,keyword,is_pagination,type,model,page=0)
		{			
			$.ajax({
				url:'{{route('ajax.change.question')}}',
				type: "GET",
				dataType: 'html',
				async: true,
				data: {id:id, id_item:id_item, keyword:keyword, is_pagination:is_pagination,type:type,model:model,page:page},
				success: function(result){
					$('#show_question_ajax').html(result);
					$('#show_count_question').text($('input[name="question_count"]').val());
				},
				complete: function(){
			        //$('#loading_order').hide();
			    }
			});
		}


		$('#form-hoidap').submit(function(e){
			e.preventDefault();
			//$('#loading_order').show();

			$.ajax({
				url:'{{route('ajax.add.question')}}',
				type: "POST",
				dataType: 'json',
				async: true,
				data: $(this).serialize(),
				success: function(result){
					if(result) {
						if(result.result==true){
							Swal.fire({
							  position: 'top',
							  icon: result.icon,
							  title: '<p class="h6">'+result.text+'</p>',
							  showConfirmButton: false,
							  timer: 1500,
							  toast: true
						  	});
							//$('.form-hoidap-modal').removeClass('form-hoidap-active');
							window.location = window.location.href;//CONFIG_BASE + "";
						}
					}
				},
				complete: function(){
			        //$('#loading_order').hide();
			    }
			});
		});
	</script>
@endpush
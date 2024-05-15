<input type="hidden" name="question_count" value="{{count($question)}}">
@if($question)	
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
					<span class="box-hoidap-cate ml-2">{{$danhmuc['tenvi']}}
				@endif
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

	@if(!is_array($question))
		<div class="clear"></div>
	    <div class="row">
	       <div class="col-sm-12 dev-center dev-paginator ajax-pagination">{{ $question->links() }}</div>           
	    </div>
    @endif
@endif
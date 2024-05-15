@if($categories)
	@php
		$arr_idsparent = (isset($ids_parent)) ? explode(',', $ids_parent) : array();	
	@endphp

	@foreach($categories as $k=>$v)
		<li class="">
			<div class="custom-checkbox">
				<input type="checkbox" class="custom-control-input hienthi-checkbox multy-checkbox" name="ids_level[{{$level}}][]" id="multy-checkbox-{{$level}}-{{$k}}" value="{{$v['id']}}" {{(in_array($v['id'], $arr_idsparent)) ? 'checked' : '' }}>				
            	<label for="multy-checkbox-{{$level}}-{{$k}}" class="custom-control-label">{{$v['tenvi']}}</label>
            </div>
		</li>
	@endforeach
@else
	<li value="0" class="miko-li-multy-select" style="padding-left:20px;">Chọn danh mục</li>
@endif
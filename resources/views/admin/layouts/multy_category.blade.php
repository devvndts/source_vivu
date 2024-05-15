<div class="p-0 mb-3 text-sm card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">{{ __('Danh mục') }} {{$level}}</h3>
    </div>
    <div class="card-body">
        <div class="miko-multy-category-select">
            <i class="far fa-angle-down miko-angle-down"></i>
            <input type="text" value="" data-level="{{$level}}" class="miko-multy-category-list miko-multy-category-list-{{$level}}" placeholder="{{ __('Chọn danh mục') }}" readonly="">
            <input type="hidden" name="id_multy_parent" class="miko-multy-category-id" value="">
            <ul class="miko-multy-category-ul miko-multy-category-ul-{{$level}}" data-url="{{url()->current()}}">
                @if($categories)
                    @php
                        $arr_idsparent = (isset($category_data) && count($category_data)>0) ? explode(',', $category_data['ids_level_'.$level]) : array();   
                        
                    @endphp

                    @foreach($categories as $k=>$v)
                        <li class="">
                            <div class="custom-checkbox">
                                <input type="checkbox" class="custom-control-input hienthi-checkbox multy-checkbox" name="ids_level[{{$level}}][]" id="multy-checkbox-{{$level}}-{{$k}}" data-name="{{$v['tenvi']}}" value="{{$v['id']}}" {{(in_array($v['id'], $arr_idsparent)) ? 'checked' : '' }}>
                                <label for="multy-checkbox-{{$level}}-{{$k}}" class="custom-control-label">{{$v['tenvi']}}</label>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li value="0" class="miko-li-multy-select" style="padding-left:20px;">{{ __('Chọn danh mục') }}</li>
                @endif
            </ul>
        </div>
    </div>
</div>
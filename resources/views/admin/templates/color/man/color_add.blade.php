@extends('admin.master')
@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];

$urlSave = route('admin.color.save', ['man', $type]);
$urlMan = route('admin.color.show', ['man', $type]);
$urlOption = '';
$isShowOption = false;
@endphp
@section('content')
<form class="validation-form" novalidate method="post" action="{{ $urlSave }}" enctype="multipart/form-data">
	@csrf
    <x-backend_shared.action_buttons
        :urlMan=$urlMan
        :urlOption=$urlOption
        :isShowOption=$isShowOption
    />
    <div class="row">
        <div class="col-xl-8">
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header >
                    {{ __('Màu sắc') }} {{ __($config[$type]['title_main']) }}
                </x-backend_shared.card_header>
                <div class="card-body">
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

                    <x-backend_form.group>
                        <x-backend_form.label isInlineBlock class="{{ $sttLabelClass }}" >{{ __('Số thứ tự') }}: </x-backend_form.label>
                        <x-backend_form.input type="number" name="data[stt]"
                        id="stt" value="{{ $rowItem['stt'] ?? 1 }}" class="{{ $sttInputClass }}" />
                    </x-backend_form.group>

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
                        <div class="card-body card-article">
                            <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                @foreach(config('config_all.lang') as $k => $v)
                                    <div class="tab-pane fade show {{($k=='vi')?'active':''}}" id="tabs-lang-{{$k}}" role="tabpanel" aria-labelledby="tabs-lang">
                                        @php
                                            $class = "for-seo ";
                                        @endphp
                                        <x-backend_form.group >
                                            <x-backend_form.label >{{ __('Tiêu đề') }} ({{ $k }}): </x-backend_form.label>
                                            <x-backend_form.input type="text" name="data[ten{{ $k }}]" id="ten{{ $k }}" value="{{ $rowItem['ten' . $k] ?? '' }}" required />
                                        </x-backend_form.group>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        @if(isset($config[$type]['mau_mau']) && $config[$type]['mau_mau'])
                            <x-backend_form.group >
                                <x-backend_form.label >{{ __('Màu sắc') }} ({{ $k }}): </x-backend_form.label>
                                <x-backend_form.input type="text" class="jscolor" name="data[mau]" id="mau" maxlength="7" value="{{ $rowItem['mau'] ?? '#000000' }}" />
                            </x-backend_form.group>
                        @endif

                        @if((isset($config[$type]['mau_loai']) && $config[$type]['mau_loai']) && (isset($config[$type]['mau_images']) && $config[$type]['mau_images']))
                            <div class="form-group col-md-3 col-sm-4">
                                <label for="loaihienthi">Loại hiển thị:</label>
                                <select class="form-control" name="data[loaihienthi]" id="loaihienthi">
                                    <option value="0">Chọn loại hiển thị</option>
                                    <option {{ (isset($rowItem['loaihienthi']) && $rowItem['loaihienthi'] == 0)?"selected":"" }} value="0">Màu sắc</option>
                                    <option {{ (isset($rowItem['loaihienthi']) && $rowItem['loaihienthi'] == 1)?"selected":"" }} value="1">Hình ảnh</option>
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            @if(isset($config[$type]['mau_images']) && $config[$type]['mau_images'])
                <div class="text-sm card card-primary card-outline">
                    <x-backend_shared.card_header isShowMinus>
                        {{ __('Hình đại diện') }}
                    </x-backend_shared.card_header>
                    <div class="card-body">
                        <div class="photoUpload-zone">
                            @if(config('config_all.fileupload')==true)
                                @php
                                    $amount_images = 1;
                                    for($i=0;$i<$amount_images;$i++){
                                        TableManipulation::AddFieldToTable('color','photo'.(($i>0) ? $i : ''), 'string');
                                        TableManipulation::AddFieldToTable('color','idphoto'.(($i>0) ? $i : ''));
                                    }
                                @endphp
                                @include('admin.layouts.devimage')

                                <div class=""><strong>{{ "Width: ".$config[$type]['width_mau']." px - Height: ".$config[$type]['height_mau']." px (".$config[$type]['img_type_mau'].")" }}</strong></div>
                                <input type="hidden" name="width" value="{{$config[$type]['width_mau']}}" />
                                <input type="hidden" name="height" value="{{$config[$type]['height_mau']}}" />
                            @else
                                @php
                                    $rowPhoto = $rowItem['photo'] ?? '';
                                    $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                                    $photoWidth = $config[$type]['width_mau'] ?? null;
                                    $photoHeight = $config[$type]['height_mau'] ?? null;
                                    $photoRatio = $config[$type]['ratio_mau'] ?? null;
                                @endphp
                                <x-backend_shared.photo_upload :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight :photoRatio=$photoRatio />
                            @endif
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

@endsection

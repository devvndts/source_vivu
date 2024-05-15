@extends('admin.master')
@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];

$urlSave = route('admin.size.save', ['man', $type]);
$urlMan = route('admin.size.show', ['man', $type]);
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
    <div class="card card-primary card-outline text-sm">
        <x-backend_shared.card_header >
            {{ __('Kích thước') }} {{ __($config[$type]['title_main']) }}
        </x-backend_shared.card_header>
        <div class="card-body">
			@if(isset($config[$type]['size_images']) && $config[$type]['size_images'] == true)
                <div class="form-group">
                    <label class="change-photo" for="file">
                        <p>Upload hình ảnh:</p>
                        <div class="rounded">
                            <img class="rounded img-upload" src="{{ (isset($rowItem['photo']))?config('config_upload.UPLOAD_SIZE').$rowItem['photo']:'' }}" onerror=src="{{asset('img/noimage.png')}}" alt="Alt Photo"/>
                            <strong>
                                <b class="text-sm text-split"></b>
                                <span class="btn btn-sm bg-gradient-success"><i class="fas fa-camera mr-2"></i>Chọn hình</span>
                            </strong>
                        </div>
                    </label>
                    <strong class="d-block mt-2 mb-2 text-sm">{{ "Width: ".$config[$type]['width_size']." px - Height: ".$config[$type]['height_size']." px (".$config[$type]['img_type_size'].")" }}</strong>
                    <div class="custom-file my-custom-file d-none">
                        <input type="file" class="custom-file-input" name="file" id="file">
                        <label class="custom-file-label" for="file">Chọn file</label>
                    </div>
                </div>
			@endif

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
        </div>
    </div>
    <input type="hidden" name="id" value="{{ $rowItem['id'] ?? '' }}">
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection

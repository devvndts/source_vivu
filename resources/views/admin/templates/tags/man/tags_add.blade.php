@extends('admin.master')
@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];

$urlSave = route('admin.tags.save', ['man', $type]);
$urlMan = route('admin.tags.show', ['man', $type]);
$urlOption = '';
$isShowOption = false;
$isShowDropdown = true;
@endphp
@section('content')
<form class="validation-form" novalidate method="post" action="{{ $urlSave }}" enctype="multipart/form-data">
	@csrf
    <x-backend_shared.action_buttons
        :urlMan=$urlMan
        :urlOption=$urlOption
        :isShowOption=$isShowOption
        :isShowDropdown=$isShowDropdown
    />

    <div class="row">
        <div class="col-xl-8">
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header >
                    {{ __($config[$type]['title_main']) }}
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

                    @if(isset($config[$type]['slug']) && $config[$type]['slug'])
                        @include('admin.layouts.slug')
                    @endif
                    
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

                                        @if(isset($config[$type]['mota']) && $config[$type]['mota'])
                                            @php
                                                $class = "for-seo ";
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

                                        @if(isset($config[$type]['noidung']) && $config[$type]['noidung'])
                                            @php
                                                $class = "for-seo form-control-ckeditor ";
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
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            @if(isset($config[$type]['show_images']) && $config[$type]['show_images'] == true)
                <div class="text-sm card card-primary card-outline">
                    <x-backend_shared.card_header isShowMinus>
                        {{ __('Hình đại diện') }}
                    </x-backend_shared.card_header>
                    <div class="card-body">
                        @php
                            $rowPhoto = $rowItem['photo'] ?? '';
                            $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                            $photoWidth = $config[$type]['width'] ?? null;
                            $photoHeight = $config[$type]['height'] ?? null;
                            $photoRatio = $config[$type]['ratio'] ?? null;
                        @endphp
                        <x-backend_shared.photo_upload :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight :photoRatio=$photoRatio />
                    </div>
                </div>
            @endif

            @if(isset($config[$type]['seo']) && $config[$type]['seo'])
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header >
                    {{ __('Nội dung') }} SEO
                    <x-slot name="other_info">
                        <a class="float-right text-white btn btn-sm bg-gradient-success d-inline-block create-seo"
                        >{{ __('Tạo') }} SEO</a>
                    </x-slot>
                </x-backend_shared.card_header>
                <div class="card-body">
                    @include('admin.layouts.seo')
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <input type="hidden" name="id" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection

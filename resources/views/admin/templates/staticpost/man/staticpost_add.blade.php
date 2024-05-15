@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];

$urlSave = route('admin.staticpost.save', [$category, $type]);
$urlMan = '';
$urlOption = '';
$isShowOption = false;
$isShowDropdown = false;
@endphp
@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{ $urlSave }}" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <x-backend_shared.action_buttons 
            :urlMan=$urlMan
            :urlOption=$urlOption
            :isShowDropdown=$isShowDropdown
            :isShowOption=$isShowOption
        />
    <div class="row">
        <div class="col-xl-8">
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header isShowMinus>
                    {{ __('Nội dung') }} {{ __($config[$type]['title_main']) }}
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
                    
                    @if((isset($config[$type]['tieude']) && $config[$type]['tieude'] == true) || (isset($config[$type]['mota']) && $config[$type]['mota'] == true) || (isset($config[$type]['noidung']) && $config[$type]['noidung'] == true))
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
                                            
                                            @if (isset($config[$type]['mota']) && $config[$type]['mota'])
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
                                                <x-backend_form.textarea class="{{ $class }}" name="data[mota{{ $k }}]" id="mota{{ $k }}" rows="5">{{ $rowItem['mota' . $k] ?? '' }}</x-backend_form.textarea>
                                            </x-backend_form.group>
                                            @endif

                                            @if (isset($config[$type]['noidung']) && $config[$type]['noidung'])
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
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            @if(isset($config[$type]['images']) && $config[$type]['images'])
                <div class="text-sm card card-primary card-outline">
                    <x-backend_shared.card_header isShowMinus>
                        {{ __('Hình đại diện') }}
                    </x-backend_shared.card_header>
                    <div class="card-body">
                        @if(config('config_all.fileupload')==true)
                            @php
                                $amount_images = $config[$type]['amount_images'];
                                for($i=0;$i<$amount_images;$i++){
                                    TableManipulation::AddFieldToTable('static','photo'.(($i>0) ? $i : ''), 'string');
                                    TableManipulation::AddFieldToTable('static','idphoto'.(($i>0) ? $i : ''));
                                }
                            @endphp
                            @include('admin.layouts.devimage')
                        @else
                            @php
                                $rowPhoto = $rowItem['photo'] ?? '';
                                $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                                $photoWidth = $config[$type]['width'] ?? null;
                                $photoHeight = $config[$type]['height'] ?? null;
                                $photoRatio = $config[$type]['ratio'] ?? null;
                            @endphp
                            <x-backend_shared.photo_upload :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight :photoRatio=$photoRatio />
                        @endif
                    </div>
                </div>
            @endif

            @if(isset($config[$type]['images2']) && $config[$type]['images2'])
                <div class="text-sm card card-primary card-outline">
                    <x-backend_shared.card_header isShowMinus>
                        {{ __('Hình ảnh') }} {{ $config[$type]['title_main'] }}
                    </x-backend_shared.card_header>
                    <div class="card-body">
                        @php
                            $rowPhoto = $rowItem['photo2'] ?? '';
                            $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                            $photoNumbering = 2;
                            $photoWidth = $config[$type]['width2'] ?? null;
                            $photoHeight = $config[$type]['height2'] ?? null;
                            $photoRatio = $config[$type]['ratio'] ?? null;
                        @endphp
                        <x-backend_shared.photo_upload :photoNumbering=$photoNumbering :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight :photoRatio=$photoRatio />
                    </div>
                </div>
            @endif

            @if(isset($config[$type]['images3']) && $config[$type]['images3'])
                <div class="text-sm card card-primary card-outline">
                    <x-backend_shared.card_header isShowMinus>
                        {{ __('Hình ảnh') }} {{ $config[$type]['title_main'] }}
                    </x-backend_shared.card_header>
                    <div class="card-body">
                        @php
                            $rowPhoto = $rowItem['photo3'] ?? '';
                            $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                            $photoNumbering = 3;
                            $photoWidth = $config[$type]['width3'] ?? null;
                            $photoHeight = $config[$type]['height3'] ?? null;
                            $photoRatio = $config[$type]['ratio'] ?? null;
                        @endphp
                        <x-backend_shared.photo_upload :photoNumbering=$photoNumbering :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight :photoRatio=$photoRatio />
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

    @if (isset($config[$type]['sl_options']) && $config[$type]['sl_options'])
        <div class="text-sm card card-primary card-outline">
            <x-backend_shared.card_header isShowMinus>
                {{ __('Thông tin') }} {{ __($config[$type]['title_main']) }}
            </x-backend_shared.card_header>
            <div class="card-body">
                <div class="row">
                    @php
                        $elements = renderBackendComponent($config[$type]['sl_options'], 'dataSlOptions', $sl_options);
                    @endphp
                    {!! FormTemplate::show($elements) !!}
                </div>
            </div>
        </div>
    @endif

    @if(isset($config[$type]['gallery']) && $config[$type]['gallery'])
        <div class="text-sm card card-primary card-outline">
            <x-backend_shared.card_header isShowMinus>
                {{ __('Bộ sưu tập') }} {{ __($config[$type]['title_main']) }}
            </x-backend_shared.card_header>
            <div class="card-body">
                @php
                    $label = sprintf('%s: %s', __('Album hình'), $config[$type]['gallery'][$type]['img_type_photo']);
                    $model = 'staticpost';
                    $gallery = $gallery ?? null;
                @endphp
                <x-backend_shared.gallery_multy_choose 
                :gallery=$gallery
                :label=$label
                :model=$model
                :type=$type
                />
            </div>
        </div>
    @endif

    <input type="hidden" name="id" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
    <input type="hidden" name="model" class="autosave-btn" value="staticpost">
    <input type="hidden" name="type" value="{{ $type }}">
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
@endsection

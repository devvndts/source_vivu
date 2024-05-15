@extends('admin.master')
@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];

$urlSave = route('admin.post.save', ['man', $type]);
$urlMan = route('admin.post.show', ['man', $type, 'id_product' => $idParent]);
$urlOption = '';
$isShowOption = false;
@endphp
@section('content')
    <form class="validation-form autosave-form" novalidate method="post" action="{{ $urlSave }}"
        enctype="multipart/form-data">
        @csrf
        <x-backend_shared.action_buttons
            :urlMan=$urlMan
            :urlOption=$urlOption
            :isShowOption=$isShowOption
        />
        <div class="row">
            <div class="col-xl-8">
                @if (isset($config[$type]['slug']) && $config[$type]['slug'])
                    @include('admin.layouts.slug')
                @endif
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

                        <x-backend_form.group>
                            <x-backend_form.label isInlineBlock class="{{ $sttLabelClass }}" >{{ __('Số thứ tự') }}: </x-backend_form.label>
                            <x-backend_form.input type="number" name="data[stt]"
                            id="stt" value="{{ $rowItem['stt'] ?? 1 }}" class="{{ $sttInputClass }}" />
                        </x-backend_form.group>

                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="p-0 card-header border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                    @foreach (config('config_all.lang') as $k => $v)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $k == 'vi' ? 'active' : '' }}" id="tabs-lang"
                                                data-toggle="pill" href="#tabs-lang-{{ $k }}" role="tab"
                                                aria-controls="tabs-lang-{{ $k }}"
                                                aria-selected="true">{{ $v }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-body card-article">
                                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                    @foreach (config('config_all.lang') as $k => $v)
                                        <div class="tab-pane fade show {{ $k == 'vi' ? 'active' : '' }}"
                                            id="tabs-lang-{{ $k }}" role="tabpanel" aria-labelledby="tabs-lang">
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
                                                <x-backend_form.textarea class="{{ $class }}" name="data[mota{{ $k }}]" id="mota{{ $k }}" rows="5">{{$rowItem['mota' . $k] ?? '' }}</x-backend_form.textarea>
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
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                @if (isset($config[$type]['dropdown']) && $config[$type]['dropdown'])
                    <div class="mb-3 form-group col-sm-12">
                        @include('admin.layouts.category')
                    </div>
                @endif
                @if (isset($config[$type]['tags']) && $config[$type]['tags'])
                    <div class="text-sm card card-primary card-outline">
                        <x-backend_shared.card_header isShowMinus>
                            {{ $config_tags[$type]['title_main'] }}
                        </x-backend_shared.card_header>
                        <div class="card-body">
                            <div class="form-group col-xl-12 col-sm-12">
                                {!! Helper::get_tags($rowItem['id'] ?? 0, 'post', $type) !!}
                            </div>
                        </div>
                    </div>
                @endif
                @if (isset($config[$type]['place']) && $config[$type]['place'])
                    @php
                        $places['city'] = $rowItem['id_city'];
                        $places['district'] = $rowItem['id_district'];
                        $places['wards'] = $rowItem['id_wards'];
                        $places = (object) $places;
                    @endphp
                    <div class="text-sm card card-primary card-outline">
                        <x-backend_shared.card_header isShowMinus>
                            {{ __('Vị trí cửa hàng') }}
                        </x-backend_shared.card_header>
                        <div class="card-body">
                            <div class="input-cart">
                                {!! Helper::get_ajax_places('places', 'places', 'list', null, $places, 'required', 'Chọn tỉnh thành') !!}
                                <div class="invalid-feedback">Vui lòng chọn tỉnh thành</div>
                            </div>
                            <div class="input-cart">
                                {!! Helper::get_ajax_places('places', 'places', 'cat', null, $places, 'required', 'Chọn quận huyện') !!}
                                <div class="invalid-feedback">Vui lòng chọn quận huyện</div>
                            </div>
                            <div class="input-cart">
                                {!! Helper::get_ajax_places('places', 'places', 'item', null, $places, 'required', 'Chọn phường xã') !!}
                                <div class="invalid-feedback">Vui lòng chọn phường/xã</div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (isset($config[$type]['rating']) && $config[$type]['rating'])
                    @php
                        $userrating = json_decode($rowItem['userrating'], true);
                    @endphp
                    <div class="text-sm card card-primary card-outline">
                        <x-backend_shared.card_header isShowMinus>
                            {{ __('Thông tin người đánh giá') }}
                        </x-backend_shared.card_header>
                        <div class="card-body">
                            <div class="card-user d-flex">
                                <div class="mr-3 card-user-image">
                                    <span>Chọn hình<br>(100x100)</span>
                                    <div id="photoUpload-user"><img
                                            src="{{ isset($userrating['photo']) ? Helper::GetFolder($folder_upload, true) . $userrating['photo'] : '' }}"
                                            width="100%"></div>
                                    <label class="photoUpload-file" id="photo-user-zone" for="file-user-zone">
                                        <input type="file" name="dataUser[photo]" id="file-user-zone">
                                    </label>
                                </div>
                                <div class="card-user-info">
                                    <input type="text" name="dataUser[ten]" placeholder="Tên:"
                                        class="card-user-input" value="{{ $userrating ? $userrating['ten'] : '' }}">
                                    <input type="text" name="dataUser[chucvu]" placeholder="Chức vụ:"
                                        class="card-user-input"
                                        value="{{ $userrating ? $userrating['chucvu'] : '' }}">
                                    <input type="hidden" name="dataUser[star]" class="card-user-star"
                                        value="{{ $userrating ? $userrating['star'] : 0 }}">
                                    <div class='rating-stars'>
                                        <ul id='stars'>
                                            <li class='star' title='Poor' data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Fair' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Excellent' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='WOW!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (isset($config[$type]['icon']) && $config[$type]['icon'])
                    <div class="text-sm card card-primary card-outline">
                        <x-backend_shared.card_header isShowMinus>
                            {{ __('Icon') }}
                        </x-backend_shared.card_header>
                        <div class="card-body">
                            @php
                                $rowPhoto = $rowItem['icon'] ?? '';
                                $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                                $photoNumbering = 3;
                                $photoWidth = $config[$type]['width_icon'] ?? null;
                                $photoHeight = $config[$type]['height_icon'] ?? null;
                                $photoRatio = $config[$type]['ratio'] ?? null;
                            @endphp
                            <x-backend_shared.photo_upload :photoNumbering=$photoNumbering :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight :photoRatio=$photoRatio />
                        </div>
                    </div>
                @endif
                @if (isset($config[$type]['images']) && $config[$type]['images'])
                    <div class="text-sm card card-primary card-outline">
                        <x-backend_shared.card_header isShowMinus>
                            {{ __('Hình đại diện') }}
                        </x-backend_shared.card_header>
                        <div class="card-body">
                            @if (config('config_all.fileupload') == true)
                                @php
                                    $amount_images = $config[$type]['amount_images'];
                                    for ($i = 0; $i < $amount_images; $i++) {
                                        TableManipulation::AddFieldToTable('post', 'photo' . ($i > 0 ? $i : ''), 'string');
                                        TableManipulation::AddFieldToTable('post', 'idphoto' . ($i > 0 ? $i : ''));
                                    }
                                @endphp
                                @include('admin.layouts.devimage')
                                @if ($request->category == 'man')
                                    <div class="mt-2">
                                        <strong>{{ 'Width: ' . $config[$type]['width'] * $config[$type]['ratio'] . ' px - Height: ' . $config[$type]['height'] * $config[$type]['ratio'] . ' px (' . $config[$type]['img_type'] . ')' }}</strong>
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <strong>{{ 'Width: ' . $config[$type]['width_' . $request->category] . ' px - Height: ' . $config[$type]['height_' . $request->category] . ' px (' . $config[$type]['img_type'] . ')' }}</strong>
                                    </div>
                                @endif
                                <input type="hidden" name="width" value="{{ $config[$type]['width'] }}" />
                                <input type="hidden" name="height" value="{{ $config[$type]['height'] }}" />
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
                @if (isset($config[$type]['seo']) && $config[$type]['seo'])
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

        @if (@$config[$type]['sl_options'])
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header isShowMinus>
                    {{ __('Thông tin') }} {{ __($config[$type]['title_main']) }}
                </x-backend_shared.card_header>
                <div class="card-body">
                    <div class="row">
                        @php
                            $elements = renderBackendComponent($config[$type]['sl_options'], 'dataSlOptions', $sl_options ?? '');
                        @endphp
                        {!! FormTemplate::show($elements) !!}
                    </div>
                </div>
            </div>
        @endif

        @if (isset($config[$type]['gallery']))
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header isShowMinus>
                    {{ __('Bộ sưu tập') }} {{ __($config[$type]['title_main']) }}
                </x-backend_shared.card_header>
                <div class="card-body">
                    @if (config('config_all.fileupload') == true)
                        @include('admin.layouts.gallery_multy')
                    @else
                        @php
                            $label = sprintf('%s: %s', __('Album hình'), $config[$type]['img_type']);
                            $model = 'post';
                            $gallery = $gallery ?? null;
                        @endphp
                        <x-backend_shared.gallery_multy_choose 
                        :gallery=$gallery
                        :label=$label
                        :model=$model
                        :type=$type
                        />
                    @endif
                </div>
            </div>
        @endif
        <input type="hidden" name="id" value="{{ isset($rowItem['id']) ? $rowItem['id'] : '' }}">
        <input type="hidden" name="type_main" value="{{ $type }}">
        <input type="hidden" name="table" value="post">
        <input type="hidden" name="id_product" value="{{ isset($idParent) ? $idParent : '' }}">
        <input type="hidden" name="model" class="autosave-btn" value="post">
        <input type="hidden" name="type" value="{{ $type }}" class="type-main">
    </form>
@endsection
@push('css')
    <style>
        /* Rating Star Widgets Style */
        .rating-stars ul {
            list-style-type: none;
            padding: 0;
            -moz-user-select: none;
            -webkit-user-select: none;
            cursor: pointer;
        }

        .rating-stars ul>li.star {
            display: inline-block;
        }

        /* Idle State of the stars */
        .rating-stars ul>li.star>i.fa {
            font-size: 1em;
            /* Change the size of the stars */
            color: #ccc;
            /* Color on idle state */
        }

        /* Hover state of the stars */
        .rating-stars ul>li.star.hover>i.fa {
            color: #FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul>li.star.selected>i.fa {
            color: #FF912C;
        }
    </style>
@endpush
<!--js thêm cho mỗi trang-->
@push('js')
    <script>
        //Auto save after 15 minute
        //AutoSave();
        $(window).on('load', function() {
            var val = $('#video').val();
            if (val) {
                youtubePreview(val, '#loadVideo');
            }
        });
        //rating if exist
        $('#stars li').on('mouseover', function() {
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e) {
                if (e < onStar) {
                    $(this).addClass('hover');
                } else {
                    $(this).removeClass('hover');
                }
            });
        }).on('mouseout', function() {
            $(this).parent().children('li.star').each(function(e) {
                $(this).removeClass('hover');
            });
        });
        /* 2. Action to perform on click */
        $('#stars li').on('click', function() {
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
            var stars = $(this).parent().children('li.star');
            for (i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass('selected');
            }
            for (i = 0; i < onStar; i++) {
                $(stars[i]).addClass('selected');
            }
            // JUST RESPONSE (Not needed)
            var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
            var msg = "";
            if (ratingValue > 1) {
                msg = ratingValue;
            } else {
                msg = ratingValue;
            }
            responseMessage(msg);
        });

        function responseMessage(msg) {
            $('.card-user-star').val(msg);
        }
        $(window).on('load', function() {
            var star_value = $('.card-user-star').val();
            $('#stars li').eq(star_value - 1).trigger('click');
        });
    </script>
@endpush

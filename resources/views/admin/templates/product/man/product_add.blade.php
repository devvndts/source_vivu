@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');

$rowItem = $rowItem ?? [];

$urlSave = route('admin.product.save', ['man', $type]);
$urlMan = route('admin.product.show', ['man', $type]);
$urlOption = route('admin.productOption.show', ['man', $type, 'id_product' => $rowItem['id'] ?? 0]);
$isShowOption = true;

if ($rowItem) {
    // $qaData = get_posts('q_a', 'vi', ['query' => ['id_product' => $rowItem['id']], 'order_by' => ['stt' => 'asc']]);
}
@endphp
@extends('admin.master')
@section('content')
    <form class="validation-form autosave-form" novalidate method="post"
        action="{{ $urlSave }}" enctype="multipart/form-data">
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
                @include('admin.templates.product.man.product-content')
                {{-- <p class="dev-option-error text-success col-xl-12"><i class="fas fa-check-circle"></i> Vào mục <a href="{{ route('admin.post.show',['man','q_a','id_product'=>$rowItem['id']]) }}" target="_blank">Quản lý câu hỏi</a> để thêm các câu hỏi</p> --}}
                {{-- @include('admin.templates.product.man.product-question') --}}
                @include('admin.layouts.gallery_taptin')
            </div>
            <div class="col-xl-4">
                @if (isset($config[$type]['dropdown']) && $config[$type]['dropdown'])
                    <div class="p-0 mb-0 form-group col-sm-12">
                        @include('admin.layouts.category')
                    </div>
                    @if (isset($config[$type]['brand']) && $config[$type]['brand'])
                        <div class="text-sm card card-primary card-outline">
                            <x-backend_shared.card_header isShowMinus>
                                {{ __('Danh mục hãng') }}
                            </x-backend_shared.card_header>
                            <div class="card-body">
                                <div class="form-group col-xl-12 col-sm-12">
                                    {!! Helper::get_brand($rowItem['id'], 'product', $type) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (isset($config[$type]['tags']) && $config[$type]['tags'])
                        <div class="text-sm card card-primary card-outline">
                            <x-backend_shared.card_header isShowMinus>
                                {{ __($config_tags[$type]['title_main']) }}
                            </x-backend_shared.card_header>
                            <div class="card-body">
                                <div class="form-group col-xl-12 col-sm-12">
                                    {!! Helper::get_tags($rowItem['id'] ?? 0, 'product', $type) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if (config('config_all.order.soluong'))
                    <div class="text-sm card card-primary card-outline">
                        <x-backend_shared.card_header isShowMinus>
                            {{ __('Thông tin số lượng sản phẩm') }}
                        </x-backend_shared.card_header>
                        <div class="card-body">
                            <div class="form-group col-md-12">
                                @if ($rowItem)
                                    <div class="form-group">
                                        <div class="mr-3 custom-control custom-radio d-inline-block text-md">
                                            <input class="custom-control-input mailertype" type="radio"
                                                id="soluong_add" name="soluong_type" value="0" checked>
                                            <label for="soluong_add"
                                                class="custom-control-label font-weight-normal">{{ __('Thêm') }}</label>
                                        </div>
                                        <div class="mr-3 custom-control custom-radio d-inline-block text-md">
                                            <input class="custom-control-input mailertype" type="radio"
                                                id="soluong_minus" name="soluong_type" value="1">
                                            <label for="soluong_minus"
                                                class="custom-control-label font-weight-normal">{{ __('Giảm') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="soluong" class="inp">
                                            <input type="hidden" name="soluong_now" value="{{ $rowItem['soluong'] }}">
                                            <input type="text" class="form-control" name="soluong" id="soluong"
                                                value="{{ $rowItem['soluong'] }}">
                                            <span class="label">{{ __('Số lượng hiện tại') }} (<span
                                                    id="soluong_span">{{ $rowItem['soluong'] }}</span>)</span>
                                            <span class="focus-bg"></span>
                                        </label>
                                    </div>
                                    <p class="mt-2 mb-2 alert-soluong text-danger d-none" id="alert-soluong-danger">
                                        <i class="mr-1 fas fa-exclamation-triangle"></i>
                                        <span>{{ __('Số lượng không hợp lệ') }}</span>
                                    </p>
                                    <p class="mt-2 mb-2 alert-soluong text-success d-none" id="alert-soluong-success">
                                        <i class="mr-1 fas fa-exclamation-triangle"></i>
                                        <span>{{ __('Xác nhận thành công') }}</span>
                                    </p>
                                    <p class="soluong_submit">{{ __('Xác nhận') }}</p>
                                @else
                                    <div class="form-group">
                                        <label class="d-block" for="soluong">{{ __('Số lượng khởi tạo') }}:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="data[soluong]"
                                                id="soluong" placeholder="" value="{{ $rowItem['soluong'] }}"
                                                value="0">
                                        </div>
                                    </div>
                                @endif
                            </div>
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
                                        TableManipulation::AddFieldToTable('product', 'photo' . ($i > 0 ? $i : ''), 'string');
                                        TableManipulation::AddFieldToTable('product', 'idphoto' . ($i > 0 ? $i : ''));
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
                            {{ __('Hình ảnh') }} {{ __($config[$type]['images2_title']) ?? '' }}
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
                            {{ __('Hình ảnh') }} {{ __($config[$type]['images3_title']) ?? '' }}
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

                @if (isset($config[$type]['cta']) && $config[$type]['cta'])
                    <div class="text-sm card card-primary card-outline">
                        <x-backend_shared.card_header >
                            {{ __('CTA link') }}
                        </x-backend_shared.card_header>
                        <div class="card-body">
                            @include('admin.templates.product.man.product_cta')
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="text-sm card card-primary card-outline">
            @include('admin.templates.product.man.product-extra')
        </div>

        @if ((isset($config[$type]['mau']) && $config[$type]['mau']) ||
            (isset($config[$type]['size']) && $config[$type]['size']))
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header >
                    {{ __('Danh mục thuộc tính') }}
                </x-backend_shared.card_header>
                <div class="card-body">
                    <div class="form-group-category row">
                        @if (isset($config[$type]['mau']) && $config[$type]['mau'])
                            <div class="form-group col-xl-3 col-sm-4">
                                <label class="d-block" for="id_mau">{{ __('Chọn danh mục màu sắc hoặc') }} <span
                                        class="btn-add-property" data-typeProp="color" data-type="{{ $type }}"
                                        data-toggle="modal" data-target="#modal_property_color"
                                        data-showElement="#show_addColor">{{ __('Thêm màu mới') }} </span></label>
                                <div id="show-select-color">{!! Helper::get_color(@$rowItem['id'], 'product', $type) !!}</div>
                            </div>
                        @endif
                        @if (isset($config[$type]['size']) && $config[$type]['size'])
                            <div class="form-group col-xl-3 col-sm-4">
                                <label class="d-block" for="id_size">{{ __('Chọn danh mục hoặc') }} <span class="btn-add-property"
                                        data-typeProp="size" data-type="{{ $type }}" data-toggle="modal"
                                        data-target="#modal_property_size" data-showElement="#show_addSize">{{ __('Thêm mới') }}
                                    </span></label>
                                <div id="show-select-size">{!! Helper::get_size(@$rowItem['id'], 'product', $type) !!}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- show phiên bản con --}}
            <p class="loading-version" style="text-align: center;">
                <img src="{{ asset('img/admin/loader.gif') }}" width="50%">
            </p>
            <div id="show_product_children"></div>
        @endif
        @if (@$config[$type]['sl_options'])
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header isShowMinus>
                    {{ __('Thông tin') }} {{ __($config[$type]['title_main']) }}
                </x-backend_shared.card_header>
                <div class="card-body">
                    <div class="row">
                        @php
                            $elements = renderBackendComponent($config[$type]['sl_options'], 'dataSlOptions', $sl_options ?? null);
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
                            $label = sprintf('%s: %s', __('Album hình'), $config[$type]['gallery'][$type]['img_type_photo']);
                            $model = 'product';
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
        <div class="group_hidden">
            <input type="hidden" name="id" value="{{ $rowItem['id'] ?? '' }}">
            <input type="hidden" name="type_main" value="{{ $type }}">
            <input type="hidden" name="table" value="product">
            <input type="hidden" name="model" class="autosave-btn" value="product">
            <input type="hidden" name="type" value="{{ $type }}" class="type-main">
        </div>
    </form>
    {{-- Show nội dung layout thêm size - color --}}
    @include('admin.layouts.add_property')
@endsection
<!--js thêm cho mỗi trang-->
@section('js_page')
    <script>
        AutoSave();
        $(window).on('load', function() {
            setTimeout(function() {
                LoadProductChildren();
            }, 500);
            //LoadProductChildren();
        });

        function LoadProductChildren() {
            var id_product = {{ isset($rowItem['id']) ? $rowItem['id'] : 0 }}
            var mau_group = $('#mau_group').val();
            var size_group = $('#size_group').val();
            var type = $('.group_hidden input[name="type"]').val(); //$('#filer-type-main').val();
            var proname = $('#tenvi').val();
            var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
            $.ajax({
                url: "{{ route('admin.ajax.properties') }}",
                type: 'POST',
                dataType: 'html',
                async: false,
                data: {
                    id_product: id_product,
                    mau_group: mau_group,
                    size_group: size_group,
                    type: type,
                    proname: proname,
                    _token: _token
                },
                success: function(result) {
                    $('#show_product_children').html(result);
                    /* Load photozone option */
                    photoZoneOption();
                    /* Check masp option*/
                    //checkMaSPoption();
                    /* Format price */
                    $(".format-price").priceFormat({
                        limit: 13,
                        prefix: '',
                        centsLimit: 0
                    });
                    $('.submit-check-option').click(function(event) {
                        var op = $(this).attr('data-position');
                        var group = $(this).attr('data-groupPos');
                        /* Check masp */
                        infoProCheck("masp_option_" + group + '_' + op,
                        true); //tham số đầu vào là tên id của div
                        var elementMasp = $('#alert-masp_option_' + group + '_' + op +
                            '-danger:not(.d-none)');
                        if (elementMasp.length) {
                            //holdonClose();
                            //return false;
                        }
                        checkMaSPoption();
                    });
                    $(".dai_option, .rong_option, .cao_option").keyup(function() {
                        var position = $(this).attr('data-position');
                        var group = $(this).attr('data-groupPos');
                        var dai = $('#dai_option_' + group + '_' + position).val();
                        var rong = $('#rong_option_' + group + '_' + position).val();
                        var cao = $('#cao_option_' + group + '_' + position).val();
                        var weight = 0;
                        if (dai == '0' || rong == '0' || cao == '0') {
                            weight = 0;
                        } else {
                            dai = dai.replace(/,/g, "");
                            rong = rong.replace(/,/g, "");
                            cao = cao.replace(/,/g, "");
                            dai = parseInt(dai);
                            rong = parseInt(rong);
                            cao = parseInt(cao);
                            weight = (dai * rong * cao) / 4000;
                            weight = weight * 1000;
                        }
                        $('#khoiluong_option_' + group + '_' + position).val(weight);
                        $(".format-price").priceFormat({
                            limit: 13,
                            prefix: '',
                            centsLimit: 0
                        });
                    })
                    $('.loading-version').addClass('d-none');
                }
            });
        }
        $('body').on('click', '.delete-option', function() {
            var op = $(this).attr('data-op');
            var id = $(this).attr('data-id');
            var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
            $('#hidden_xoatam_option_' + op).val(1);
            $('#masp_option_' + op).val(Date.now());
            $('.dev-options-item-' + op).addClass('dev-option-none');
            $.ajax({
                url: "{{ route('admin.ajax.deleteOption') }}",
                type: 'POST',
                dataType: 'html',
                async: false,
                data: {
                    id: id,
                    _token: _token
                },
                success: function(result) {}
            });
        });
        $(document).ready(function() {
            $('.soluong_submit').click(function() {
                var id = $('input[name="id"]').val();
                var table = $('input[name="table"]').val();
                var soluong_type = $('input[name="soluong_type"]:checked').val();
                var soluong_now = $('input[name="soluong_now"]').val();
                var soluong_input = $('input[name="soluong"]').val();
                var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
                if (soluong_type == 1 && (soluong_input - soluong_now) > 0) {
                    //console.log(soluong_input+'-'+soluong_now);           
                    $('#alert-soluong-danger').removeClass('d-none');
                    $('#alert-soluong-danger').addClass('d-block');
                    return false;
                } else {
                    $('#alert-soluong-danger').addClass('d-none');
                    $('#alert-soluong-danger').removeClass('d-block');
                    $.ajax({
                        url: "{{ route('admin.ajax.changeSoluong') }}",
                        type: 'POST',
                        dataType: 'json',
                        async: false,
                        data: {
                            id: id,
                            table: table,
                            soluong_type: soluong_type,
                            soluong_now: soluong_now,
                            soluong_input: soluong_input,
                            _token: _token
                        },
                        success: function(result) {
                            if (result.success == 1) {
                                //console.log('xác nhận thành công');
                                $('#alert-soluong-success').removeClass('d-none');
                                $('#alert-soluong-success').addClass('d-block');
                                $('#soluong_span').text(result.soluong_now);
                                $('input[name="soluong"]').val(result.soluong_now);
                                $('input[name="soluong_now"]').val(result.soluong_now);
                            }
                        }
                    });
                }
            });
        });
    </script>
    @if (isset($config[$type]['giakm']) && $config[$type]['giakm'] == true)
        <script type="text/javascript">
            function roundNumber(rnum, rlength) {
                return Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
            }
            $(document).ready(function() {
                $(".gia_ban, .gia_moi").keyup(function() {
                    var gia_cu = $('.gia_ban').val();
                    var gia_ban = $('.gia_moi').val();
                    var gia_km = 0;
                    if (gia_cu == '' || gia_cu == '0' || gia_ban == '' || gia_ban == '0') {
                        gia_km = 0;
                    } else {
                        gia_cu = gia_cu.replace(/,/g, "");
                        gia_ban = gia_ban.replace(/,/g, "");
                        gia_cu = parseInt(gia_cu);
                        gia_ban = parseInt(gia_ban);
                        if (gia_ban < gia_cu) {
                            gia_km = 100 - ((gia_ban * 100) / gia_cu);
                            gia_km = roundNumber(gia_km, 0);
                        } else {
                            gia_km = 0;
                        }
                    }
                    console.log(gia_ban);
                    $('.gia_km').val(gia_km);
                })
                $(".gia_cu_op, .gia_ban_op").keyup(function() {
                    var position = $(this).attr('data-position');
                    var group = $(this).attr('data-groupPos');
                    var gia_cu = $('.gia_ban_' + group + '_' + position).val();
                    var gia_ban = $('.gia_moi_' + group + '_' + position).val();
                    var gia_km = 0;
                    if (gia_cu == '' || gia_cu == '0' || gia_ban == '' || gia_ban == '0') {
                        gia_km = 0;
                    } else {
                        gia_cu = gia_cu.replace(/,/g, "");
                        gia_ban = gia_ban.replace(/,/g, "");
                        gia_cu = parseInt(gia_cu);
                        gia_ban = parseInt(gia_ban);
                        if (gia_ban < gia_cu) {
                            gia_km = 100 - ((gia_ban * 100) / gia_cu);
                            gia_km = roundNumber(gia_km, 0);
                        } else {
                            gia_km = 0;
                        }
                    }
                    $('.gia_km_' + group + '_' + position).val(gia_km);
                })
                $(".dai, .rong, .cao").keyup(function() {
                    var dai = $('.dai').val();
                    var rong = $('.rong').val();
                    var cao = $('.cao').val();
                    var weight = 0;
                    if (dai == '0' || rong == '0' || cao == '0') {
                        weight = 0;
                    } else {
                        dai = dai.replace(/,/g, "");
                        rong = rong.replace(/,/g, "");
                        cao = cao.replace(/,/g, "");
                        dai = parseInt(dai);
                        rong = parseInt(rong);
                        cao = parseInt(cao);
                        weight = (dai * rong * cao) / 4000;
                        weight = weight * 1000;
                    }
                    $('#khoiluong').val(weight);
                    $(".format-price").priceFormat({
                        limit: 13,
                        prefix: '',
                        centsLimit: 0
                    });
                })
            })
        </script>
    @endif
@endsection

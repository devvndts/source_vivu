<input type="hidden" name="option_delete" value="{{ $array_option }}">
@if (count($options_group) > 0)

    <div class="text-sm card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Phiên bản sản phẩm</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body form-group-category">
            @php
                $masp_colors = $row_product['masp_color'] ? json_decode($row_product['masp_color'], true) : null;
            @endphp

            @if (count($productOption_allXoatam) > 0 && count($all_option) > 0 && $row_product)
                <p class="dev-option-error text-success col-xl-12"><i class="fas fa-check-circle"></i> Vào mục <a
                        href="{{ route('admin.productOption.show', ['man', $row_product['type'], 'id_product' => $row_product['id']]) }}"
                        target="_blank">Quản lý phiên bản</a> để thêm các phiên bản con</p>
            @endif
            @foreach ($options_group as $g_opt => $g_option)
                @php
                    $info_color = CartHelper::get_mau_info($g_opt);
                    $options = $g_option;
                    //dd($masp_colors);
                @endphp

                <div class="dev-options-group">
                    <div class="dev-options-contain">
                        <!--Mã sp theo màu-->
                        <div class="mb-3 dev-options-group-info">
                            @if ($info_color)
                                <p class="dev-options-group-color"><span style="background:#{{ $info_color['mau'] }}"
                                        class="mr-2 dev-options-info-bg"></span> {{ $info_color['tenvi'] }}</p>
                                <div class="p-0 mb-4 form-group col-md-4 col-sm-12">
                                    <label for="masp_color_{{ $g_opt }}" class="inp">
                                        <input type="text" class="form-control for-seo"
                                            name="dataColor[{{ $g_opt }}]" id="masp_color_{{ $g_opt }}"
                                            placeholder="&nbsp;"
                                            value="{{ isset($masp_colors[$g_opt]) ? $masp_colors[$g_opt] : '' }}">
                                        <span class="label">Mã sản phẩm theo màu</span>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <!--Ds phiên bản-->
                        @foreach ($options as $op => $option)
                            @if ($option['xoatam'] == 0)
                                <div class="dev-options-item dev-options-item-{{ $op }}"
                                    data-op="{{ $op }}">
                                    <div class="dev-hidden-info">
                                        <input type="hidden"
                                            name="dataOption[{{ $g_opt }}-{{ $op }}][id]"
                                            value="{{ $option['id'] }}"
                                            id="hidden_idoption_{{ $g_opt }}_{{ $op }}">
                                        <input type="hidden"
                                            name="dataOption[{{ $g_opt }}-{{ $op }}][id_mau]"
                                            value="{{ $option['id_mau'] }}">
                                        <input type="hidden"
                                            name="dataOption[{{ $g_opt }}-{{ $op }}][id_size]"
                                            value="{{ $option['id_size'] }}">
                                        <input type="hidden"
                                            name="dataOption[{{ $g_opt }}-{{ $op }}][tenkhongdauvi]"
                                            value="{{ $option['tenkhongdauvi'] }}">
                                        <input type="hidden"
                                            name="dataOption[{{ $g_opt }}-{{ $op }}][tenvi]"
                                            value="{{ $option['tenvi'] }}">
                                        <input type="hidden"
                                            name="dataOption[{{ $g_opt }}-{{ $op }}][tenen]"
                                            value="{{ $option['tenvi'] }}">
                                    </div>

                                    <div class="dev-options-info">
                                        <div id="photoUpload-preview-{{ $op }}" class="dev-options-img">
                                            <img src="{{ config('config_upload.UPLOAD_PRODUCT') . $option['photo'] }}"
                                                onerror=src="{{ asset('img/noimage.png') }}" alt="image">
                                        </div>
                                        <div class="dev-options-main">
                                            <p class="dev-options-name">{{ $option['tenvi'] }}</p>
                                            @if ($option['id'])
                                                <div class="dev-options-main-price">
                                                    <div class="dev-options-giachange" data-id="{{ $option['id'] }}">
                                                        <span>Giá bán</span><input type="text"
                                                            class="dev-options-gia format-price gia_ban"
                                                            placeholder="Giá bán" value="{{ $option['gia'] }}">
                                                        <p class="btn-giachange" data-type="gia"><i
                                                                class="fas fa-check"></i><i class="fas fa-ban"></i>Thay
                                                            đổi</p>
                                                    </div>
                                                    <div class="dev-options-giachange" data-id="{{ $option['id'] }}">
                                                        <span>Giá mới</span><input type="text"
                                                            class="dev-options-giamoi format-price gia_moi"
                                                            placeholder="Giá mới" value="{{ $option['giamoi'] }}">
                                                        <p class="btn-giachange" data-type="giamoi"><i
                                                                class="fas fa-check"></i><i class="fas fa-ban"></i>Thay
                                                            đổi</p>
                                                    </div>
                                                </div>
                                                <a class="text-info dev-edit dev-options-edit"
                                                    href="{{ route('admin.productOption.edit', ['man', $type, $option['id']]) }}"
                                                    target="_blank"><i class="pl-1 mr-1 far fa-edit"></i></a>
                                                <a class="mr-3 text-info text-danger dev-edit delete-option dev-options-delete"
                                                    data-op="{{ $op }}" data-id="{{ $option['id'] }}"><i
                                                        class="pl-1 mr-1 far fa-trash-alt"></i></a>
                                            @else
                                                <a class="mr-3 text-info dev-edit" data-toggle="modal"
                                                    data-target="#modal_option_{{ $g_opt }}_{{ $op }}"><i
                                                        class="mr-1 far fa-edit"></i>Chỉnh sửa phiên bản</a>
                                                {{-- <p class="dev-options-error text-danger" id="load-error-{{$g_opt}}-{{$op}}"><i class="fas fa-exclamation-circle"></i> Chưa nhập mã sản phẩm</p>
		                                	<p class="dev-options-error text-danger" id="load-warning-{{$g_opt}}-{{$op}}"><i class="fas fa-exclamation-circle"></i> Mã sản phẩm đang bị trùng</p> --}}
                                            @endif

                                            <div class="modal fade"
                                                id="modal_option_{{ $g_opt }}_{{ $op }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                {{ $option['tenvi'] }}</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <!--Image-->
                                                            <div class="dev-options-image d-none">
                                                                <div class="photoUpload-zone">
                                                                    <label class="photoUpload-file"
                                                                        id="photo-zone-{{ $op }}"
                                                                        for="file-zone-{{ $op }}">
                                                                        <input type="file"
                                                                            name="file-{{ $op }}-{{ $op }}"
                                                                            id="file-zone-{{ $op }}">
                                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                                        <p class="photoUpload-drop">Kéo và thả hình vào
                                                                            đây</p>
                                                                        <p class="photoUpload-or">hoặc</p>
                                                                        <p
                                                                            class="photoUpload-choose btn btn-sm bg-gradient-success">
                                                                            Chọn hình</p>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <!--ID Hidden-->
                                                                <input type="hidden" id="id_option"
                                                                    name="dataOption[{{ $g_opt }}-{{ $op }}][masp]"
                                                                    value="{{ $op }}" required>
                                                                <input type="hidden"
                                                                    name="dataOption[{{ $g_opt }}-{{ $op }}][xoatam]"
                                                                    value="{{ $option['xoatam'] }}"
                                                                    id="hidden_xoatam_option_{{ $op }}"
                                                                    required>
                                                                <!--Mã SP-->
                                                                <div class="form-group col-md-6">
                                                                    <label class="d-block" for="masp">Mã sản
                                                                        phẩm:</label>
                                                                    <input type="text"
                                                                        class="form-control masp_option_danger"
                                                                        name="dataOption[{{ $g_opt }}-{{ $op }}][masp]"
                                                                        id="masp_option_{{ $g_opt }}_{{ $op }}"
                                                                        placeholder="Mã sản phẩm"
                                                                        value="{{ $option['masp'] ? $option['masp'] : $parent_masp . '-' . ($op + 1) }}"
                                                                        data-op="{{ $op }}"
                                                                        data-group="{{ $g_opt }}" required>
                                                                    <p class="mt-2 mb-0 alert-masp text-danger d-none"
                                                                        id="alert-masp_option_{{ $g_opt }}_{{ $op }}-danger">
                                                                        <i
                                                                            class="mr-1 fas fa-exclamation-triangle"></i>
                                                                        <span>Mã SP đã tồn tại.</span>
                                                                    </p>
                                                                    <p class="mt-2 mb-0 alert-masp text-success d-none"
                                                                        id="alert-masp_option_{{ $g_opt }}_{{ $op }}-success">
                                                                        <i class="mr-1 fas fa-check-circle"></i>
                                                                        <span>Mã SP hợp lệ.</span>
                                                                    </p>
                                                                </div>

                                                                <!--kích thước-->
                                                                <div class="form-group col-md-6">
                                                                    <label class="d-block" for="giamoi">Kích thước
                                                                        đóng gói(cm):</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control format-price dai_option"
                                                                            name="dataOption[{{ $g_opt }}-{{ $op }}][dai]"
                                                                            id="dai_option_{{ $g_opt }}_{{ $op }}"
                                                                            placeholder="Dài"
                                                                            value="{{ $option['dai'] }}"
                                                                            data-position="{{ $op }}"
                                                                            data-groupPos="{{ $g_opt }}">
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text">
                                                                                <strong>x</strong></div>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control format-price rong_option"
                                                                            name="dataOption[{{ $g_opt }}-{{ $op }}][rong]"
                                                                            id="rong_option_{{ $g_opt }}_{{ $op }}"
                                                                            placeholder="Rộng"
                                                                            value="{{ $option['rong'] }}"
                                                                            data-position="{{ $op }}"
                                                                            data-groupPos="{{ $g_opt }}">
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text">
                                                                                <strong>x</strong></div>
                                                                        </div>
                                                                        <input type="text"
                                                                            class="form-control format-price cao_option"
                                                                            name="dataOption[{{ $g_opt }}-{{ $op }}][cao]"
                                                                            id="cao_option_{{ $g_opt }}_{{ $op }}"
                                                                            placeholder="Cao"
                                                                            value="{{ $option['cao'] }}"
                                                                            data-position="{{ $op }}"
                                                                            data-groupPos="{{ $g_opt }}">
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text">
                                                                                <strong>/4000</strong></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!--KHối lượng-->
                                                                <div class="form-group col-md-6">
                                                                    <label class="d-block" for="giamoi">Khối lượng
                                                                        đóng gói:</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control format-price khoiluong_option"
                                                                            name="dataOption[{{ $g_opt }}-{{ $op }}][khoiluong]"
                                                                            id="khoiluong_option_{{ $g_opt }}_{{ $op }}"
                                                                            placeholder="Khối lượng"
                                                                            value="{{ $option['khoiluong'] }}">
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text">
                                                                                <strong>Gram</strong></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @if (isset($config[$type]['giacu']) && $config[$type]['giacu'] == true)
                                                                    <!--Giá cũ-->
                                                                    <div class="form-group col-md-6">
                                                                        <label class="d-block" for="giamoi">Giá
                                                                            cũ:</label>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control format-price gia_cu_op gia_cu_{{ $g_opt }}_{{ $op }}"
                                                                                name="dataOption[{{ $g_opt }}-{{ $op }}][giacu]"
                                                                                id="giacu_option_{{ $g_opt }}_{{ $op }}"
                                                                                placeholder="Giá cũ"
                                                                                value="{{ $option['giacu'] }}"
                                                                                data-position="{{ $op }}"
                                                                                data-groupPos="{{ $g_opt }}">
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text">
                                                                                    <strong>VNĐ</strong></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                @if (isset($config[$type]['gia']) && $config[$type]['gia'] == true)
                                                                    <!--Giá bán-->
                                                                    <div class="form-group col-md-6">
                                                                        <label class="d-block" for="gia">Giá
                                                                            bán:</label>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control format-price gia_ban_op gia_ban_{{ $g_opt }}_{{ $op }}"
                                                                                name="dataOption[{{ $g_opt }}-{{ $op }}][gia]"
                                                                                id="gia_{{ $g_opt }}_{{ $op }}"
                                                                                placeholder="Giá bán"
                                                                                value="{{ $option['gia'] }}"
                                                                                data-position="{{ $op }}"
                                                                                data-groupPos="{{ $g_opt }}">
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text">
                                                                                    <strong>VNĐ</strong></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                @if (isset($config[$type]['giamoi']) && $config[$type]['giamoi'] == true)
                                                                    <!--Giá mới-->
                                                                    <div class="form-group col-md-6">
                                                                        <label class="d-block" for="giamoi">Giá
                                                                            mới:</label>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control format-price gia_moi_{{ $g_opt }}_{{ $op }}"
                                                                                name="dataOption[{{ $g_opt }}-{{ $op }}][giamoi]"
                                                                                id="giamoi_{{ $g_opt }}_{{ $op }}"
                                                                                placeholder="Giá mới"
                                                                                value="{{ $option['giamoi'] }}">
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text">
                                                                                    <strong>VNĐ</strong></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                @if (isset($config[$type]['giacu']) && $config[$type]['giacu'] == true)
                                                                    <!--Chiết khấu-->
                                                                    <div class="form-group col-md-6">
                                                                        <label class="d-block" for="giakm">Chiết
                                                                            khấu:</label>
                                                                        <div class="input-group">
                                                                            <input type="text"
                                                                                class="form-control gia_km_op gia_km_{{ $g_opt }}_{{ $op }}"
                                                                                name="dataOption[{{ $g_opt }}-{{ $op }}][giakm]"
                                                                                id="giakm_option_{{ $g_opt }}_{{ $op }}"
                                                                                placeholder="Chiết khấu"
                                                                                value="{{ $option['giakm'] }}"
                                                                                maxlength="3" readonly
                                                                                data-position="{{ $op }}"
                                                                                data-groupPos="{{ $g_opt }}">
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text">
                                                                                    <strong>%</strong></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <!--Số lượng-->
                                                                <div class="form-group col-md-6">
                                                                    <label class="d-block" for="soluong">Số
                                                                        lượng:</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control format-price soluong_{{ $g_opt }}_{{ $op }}"
                                                                            name="dataOption[{{ $g_opt }}-{{ $op }}][soluong]"
                                                                            id="soluong_{{ $g_opt }}_{{ $op }}"
                                                                            placeholder="Số lượng"
                                                                            value="{{ $option['soluong'] }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-primary submit-check-option"
                                                                data-position="{{ $op }}"
                                                                data-dismiss="modal"
                                                                data-groupPos="{{ $g_opt }}">Xác nhận</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <!--photo upload-->
                        @if (isset($config[$type]['mau']) && $config[$type]['mau'] == true)
                            <div class="form-group col-12" id="photo-upload-group-{{ $g_opt }}">
                                <label for="filer-gallery-{{ $g_opt }}" class="mb-3 label-filer-gallery">Hình
                                    ảnh ({{ $config[$type]['gallery'][$type]['img_type_photo'] }})</label>
                                <input type="file" name="files-{{ $g_opt }}[]"
                                    id="filer-gallery-{{ $g_opt }}" class="filer-gallery-group"
                                    data-idgroup="{{ $g_opt }}" multiple="multiple">
                                <input type="hidden" class="col-filer"
                                    value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
                                <input type="hidden" class="act-filer" name="level" value="man">
                                <input type="hidden" class="folder-filer" name="model" value="product">
                                <input type="hidden" class="folder-filer" name="type"
                                    value="{{ $type }}_color">
                                <input type="hidden" name="hash_color[]" value="{{ Str::random(8) }}" />
                                <input type="hidden" name="id_photo"
                                    value="{{ $row_product ? $row_product['id'] : '' }}">
                                <input type="hidden" name="id_color" value="{{ $g_opt ? $g_opt : '' }}">
                            </div>

                            @php
                                $params = [
                                    'id_color' => $g_opt,
                                ];
                                $params['id_photo'] = $row_product ? $row_product['id'] : 0;
                                $gallery = $galleryRepo->GetAllItems('product_color', $params);
                            @endphp
                            @if (isset($gallery) && count($gallery) > 0)
                                <div
                                    class="form-group form-group-gallery form-group-gallery-{{ $g_opt }} col-12">
                                    <label class="label-filer">Hình hiện tại:</label>
                                    <div class="mb-3 action-filer d-none">
                                        <a class="mr-1 text-white btn btn-sm bg-gradient-primary check-all-filer"><i
                                                class="mr-2 far fa-square"></i>Chọn tất cả</a>
                                        <button type="button"
                                            class="mr-1 text-white btn btn-sm bg-gradient-success sort-filer"><i
                                                class="mr-2 fas fa-random"></i>Sắp xếp</button>
                                        <a class="text-white btn btn-sm bg-gradient-danger delete-all-filer"><i
                                                class="mr-2 far fa-trash-alt"></i>{{ __('Xóa tất cả') }}</a>
                                    </div>
                                    <div
                                        class="text-sm text-white alert my-alert alert-sort-filer alert-info bg-gradient-info">
                                        <i class="mr-2 fas fa-info-circle"></i>Có thể chọn nhiều hình để di chuyển
                                    </div>
                                    <div class="jFiler-items my-jFiler-items jFiler-row">
                                        <ul class="jFiler-items-list jFiler-items-grid row scroll-bar"
                                            id="jFilerSortable-{{ $g_opt }}">
                                            @foreach ($gallery as $v)
                                                {{ Helper::galleryFiler($v['stt'], $v['id'], $v['photo'], $v['tenvi'], 'product', 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6') }}
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <!--END photo upload-->

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif


<script>
    $('.btn-giachange').click(function() {
        var e_present = $(this);
        var e_parent = e_present.parents('.dev-options-giachange');
        var e_id = e_parent.attr('data-id');
        var e_val = e_parent.find('input').val();
        var e_type = e_present.attr('data-type');
        var e_table = 'productOption';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "{{ route('admin.ajax.changePrice') }}",
            data: {
                id: e_id,
                gia: e_val,
                typePrice: e_type,
                table: e_table,
                _token: $('input[name="_token"]').val()
            },
            success: function(response) {
                console.log(response.result);
                if (response.result == 'success') {
                    if (!e_present.hasClass('btn-giachange-success')) {
                        e_present.addClass('btn-giachange-success');
                        setTimeout(function() {
                            e_present.removeClass('btn-giachange-success')
                        }, 2000);
                    }
                } else {
                    if (!e_present.hasClass('btn-giachange-error')) {
                        e_present.addClass('btn-giachange-error');
                        setTimeout(function() {
                            e_present.removeClass('btn-giachange-error')
                        }, 2000);
                    }
                }
            }
        });

        console.log(e_val);
    });


    @if (count($options_group) > 0)
        @foreach ($options_group as $g_opt => $g_option)
            var val_hash = $('#photo-upload-group-{{ $g_opt }}').find('input[name="hash_color[]"]').val();
            $("#filer-gallery-{{ $g_opt }}").attr({
                'data-hash': val_hash
            });
        @endforeach


        /* Filer */
        $('.filer-gallery-group').each(function() {
            var e_idgroup = $(this).attr('data-idgroup');
            var e_parent_group = $('#photo-upload-group-' + e_idgroup);

            $(this).filer({
                    limit: null,
                    maxSize: null,
                    extensions: ["jpg", "png", "jpeg", "JPG", "PNG", "JPEG", "Png"],
                    changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Kéo và thả hình vào đây</h3> <span style="display:inline-block; margin: 15px 0">hoặc</span></div><a class="jFiler-input-choose-btn blue">Chọn hình</a></div></div>',
                    theme: "dragdropbox",
                    showThumbs: true,
                    addMore: true,
                    allowDuplicates: false,
                    clipBoardPaste: false,
                    dragDrop: {
                        dragEnter: null,
                        dragLeave: null,
                        drop: null,
                        dragContainer: null
                    },
                    captions: {
                        button: "Thêm hình",
                        feedback: "Vui lòng chọn hình ảnh",
                        feedback2: "Những hình đã được chọn",
                        drop: "Kéo hình vào đây để upload",
                        removeConfirmation: "Bạn muốn loại bỏ hình ảnh này ?",
                        errors: {
                            @verbatim
                            filesLimit: "Chỉ được upload mỗi lần {{ fi - limit }} hình ảnh",
                            filesType: "Chỉ hỗ trợ tập tin là hình ảnh có định dạng: {{ fi - extensions }}",
                            filesSize: "Hình {{ fi - name }} có kích thước quá lớn. Vui lòng upload hình ảnh có kích thước tối đa {{ fi - maxSize }} MB.",
                            filesSizeAll: "Những hình ảnh bạn chọn có kích thước quá lớn. Vui lòng chọn những hình ảnh có kích thước tối đa {{ fi - maxSize }} MB."
                        @endverbatim
                    }
                },
                afterShow: function() {
                    var jFilerItems = $(e_parent_group).find(
                        ".my-jFiler-items .jFiler-items-list li.jFiler-item");
                    var jFilerItemsLength = 0;
                    var jFilerItemsLast = 0;
                    if (jFilerItems.length) {
                        jFilerItemsLength = jFilerItems.length;
                        jFilerItemsLast = parseInt(jFilerItems.last().find("input[type=number]").val());
                    }
                    $(e_parent_group).find(".jFiler-items-list li.jFiler-item").each(function(index) {
                        var colClass = $(".col-filer").val();
                        var parent = $(this).parent();
                        if (!parent.is("#jFilerSortable-" + e_idgroup)) {
                            jFilerItemsLast += 1;
                            $(this).find("input[type=number]").val(jFilerItemsLast);
                        }
                        if (!$(this).hasClass(colClass)) $("li.jFiler-item").addClass(colClass);
                    });
                },
                uploadFile: {
                    url: "{{ route('admin.ajax.upload') }}",
                    data: {
                        data: $(this).data(),
                        id_group: e_idgroup,
                        model: $(e_parent_group).find("input[name='model']").val(),
                        level: $(e_parent_group).find("input[name='level']").val(),
                        type: $(e_parent_group).find("input[name='type']").val(),
                        id: $(e_parent_group).find("input[name='id_photo']").val(),
                        id_color: $(e_parent_group).find("input[name='id_color']").val(),
                        time: $(e_parent_group).find('input[name="folder-time"]').val(),
                        hash: $(e_parent_group).find("input[name='hash_color[]']").val(),
                        _token: $('input[name="_token"]').val()
                    },
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    dataType: 'json',
                    async: false,
                    beforeSend: function() {
                        //alert(data);
                        holdonOpen("sk-rect", "Vui lòng chờ...", "rgba(0,0,0,0.8)", "white");
                    },
                    success: function(data, el) {
                        data = JSON.parse(data);

                        if (data['success'] == true) {
                            var parent = el.find(".jFiler-jProgressBar").parent();
                            el.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                                $("<div class = \"jFiler-item-others text-success\"><i class = \"icon-jfi-check-circle\"></i> Success</div>")
                                    .hide().appendTo(parent).fadeIn("slow");
                            });
                        } else {
                            var parent = el.find(".jFiler-jProgressBar").parent();
                            el.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                                $("<div class = \"jFiler-item-others text-error\"><i class = \"icon-jfi-minus-circle\"></i> Error</div>")
                                    .hide().appendTo(parent).fadeIn("slow");
                            });
                        }
                    },
                    error: function(el) {
                        var parent = el.find(".jFiler-jProgressBar").parent();
                        el.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                            $("<div class = \"jFiler-item-others text-error\"><i class = \"icon-jfi-minus-circle\"></i> Error</div>")
                                .hide().appendTo(parent).fadeIn("slow");
                        });
                    },
                    onComplete: function() {
                        Color_refreshFiler(e_idgroup, e_parent_group);
                        if ($(e_parent_group).find(".my-jFiler-item-info").length) {
                            $(e_parent_group).find(".jFiler-items-list").first().find(".jFiler-item")
                                .remove();
                            $(e_parent_group).find(".my-jFiler-item-info").trigger("change");
                        } else {
                            Color_refreshFilerIfEmpty(e_idgroup, e_parent_group);
                        }
                        holdonClose();
                    },
                    statusCode: {},
                    onProgress: function() {},
                },

                templates: {
                    @verbatim
                    box: '<ul class="jFiler-items-list jFiler-items-grid row scroll-bar"></ul>',
                    item: '<li class="jFiler-item">\
		                        <div class="jFiler-item-container">\
		                            <div class="jFiler-item-inner">\
		                                <div class="jFiler-item-thumb">\
		                                    <div class="jFiler-item-status"></div>\
		                                    <div class="jFiler-item-thumb-overlay">\
		                                        <div class="jFiler-item-info">\
		                                            <div style="display:table-cell;vertical-align: middle;">\
		                                                <span class="jFiler-item-title"><b title="{{ fi - name }}">{{ fi - name }}</b></span>\
		                                                <span class="jFiler-item-others">{{ fi - size2 }}</span>\
		                                            </div>\
		                                        </div>\
		                                    </div>\
		                                    {{ fi - image }}\
		                                </div>\
		                                <div class="jFiler-item-assets jFiler-row">\
		                                    <ul class="list-inline pull-left">\
		                                        <li>{{ fi - progressBar }}</li>\
		                                    </ul>\
		                                    <ul class="list-inline pull-right">\
		                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
		                                    </ul>\
		                                </div>\
		                                <input type="number" class="mb-1 form-control form-control-sm" name="stt-filer[]" placeholder="Số thứ tự"/>\
		                                <input type="text" class="form-control form-control-sm" name="ten-filer[]" placeholder="Tiêu đề"/>\
		                            </div>\
		                        </div>\
		                    </li>',
                    itemAppend: '<li class="jFiler-item">\
		                            <div class="jFiler-item-container">\
		                                <div class="jFiler-item-inner">\
		                                    <div class="jFiler-item-thumb">\
		                                        <div class="jFiler-item-status"></div>\
		                                        <div class="jFiler-item-thumb-overlay">\
		                                            <div class="jFiler-item-info">\
		                                                <div style="display:table-cell;vertical-align: middle;">\
		                                                    <span class="jFiler-item-title"><b title="{{ fi - name }}">{{ fi - name }}</b></span>\
		                                                    <span class="jFiler-item-others">{{ fi - size2 }}</span>\
		                                                </div>\
		                                            </div>\
		                                        </div>\
		                                        {{ fi - image }}\
		                                    </div>\
		                                    <div class="jFiler-item-assets jFiler-row">\
		                                        <ul class="list-inline pull-left">\
		                                            <li><span class="jFiler-item-others">{{ fi - icon }}</span></li>\
		                                        </ul>\
		                                        <ul class="list-inline pull-right">\
		                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
		                                        </ul>\
		                                    </div>\
		                                    <input type="number" class="mb-1 form-control form-control-sm" name="stt-filer[]" placeholder="Số thứ tự"/>\
		                                	<input type="text" class="form-control form-control-sm" name="ten-filer[]" placeholder="Tiêu đề"/>\
		                                </div>\
		                            </div>\
		                        </li>',
                    progressBar: '<div class="bar"></div>',
                    itemAppendToEnd: true,
                    canvasImage: false,
                    removeConfirmation: true,
                    _selectors: {
                        list: '.jFiler-items-list',
                        item: '.jFiler-item',
                        progressBar: '.bar',
                        remove: '.jFiler-item-trash-action'
                    }
                @endverbatim
            }
        });
    });

    /* Refresh filer if empty */
    function Color_refreshFilerIfEmpty(e_idgroup, element_parent_group) {
        var idmuc = $('input[name="id"]').val();
        var id_color = $(element_parent_group).find("input[name='id_color']").val();
        var com = $(element_parent_group).find('input[name="model"]').val();
        var type = $(element_parent_group).find('input[name="type"]').val();
        var hash = $(element_parent_group).find('input[name="hash_color[]"]').val();
        var colfiler = $(element_parent_group).find(".col-filer").val();
        var actfiler = $(element_parent_group).find(".act-filer").val();
        var time = 1;
        if ($(element_parent_group).find('input[name="folder-time"]').length) time = $(element_parent_group).find(
            'input[name="folder-time"]').val();
        var cmd = 'refresh';
        var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu

        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "{{ route('admin.ajax.filer') }}",
            async: false,
            data: {
                idmuc: idmuc,
                id_color: id_color,
                com: com,
                kind: actfiler,
                type: type,
                colfiler: colfiler,
                time: time,
                cmd: cmd,
                hash: hash,
                _token: _token
            },
            success: function(result) {
                //console.log(result);
                //return false;

                $(element_parent_group).find(".jFiler-items-list").first().find(".jFiler-item").remove();
                Color_destroySortFiler();

                $tmp = '<div class="form-group form-group-gallery form-group-gallery-' + e_idgroup +
                    ' col-12">';
                if (time == 1) {
                    $tmp += '<label class="label-filer">Hình hiện tại:</label>' +
                        '<div class="mb-3 action-filer d-none">' +
                        '<a class="mr-1 text-white btn btn-sm bg-gradient-primary check-all-filer"><i class="mr-2 far fa-square"></i>Chọn tất cả</a>' +
                        '<button type="button" class="mr-1 text-white btn btn-sm bg-gradient-success sort-filer"><i class="mr-2 fas fa-random"></i>Sắp xếp</button>' +
                        '<a class="text-white btn btn-sm bg-gradient-danger delete-all-filer"><i class="mr-2 far fa-trash-alt"></i>Xóa tất cả</a>' +
                        '</div>' +
                        '<div class="text-sm text-white alert my-alert alert-sort-filer alert-info bg-gradient-info"><i class="mr-2 fas fa-info-circle"></i>Có thể chọn nhiều hình để di chuyển</div>';
                }
                $tmp += '<div class="jFiler-items my-jFiler-items jFiler-row">' +
                    '<ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable-' +
                    e_idgroup + '">' +
                    result +
                    '</ul></div></div>';
                $(".form-group-gallery-" + e_idgroup).remove();
                $("#filer-gallery-" + e_idgroup).parents(".form-group").after($tmp);
                //Color_createSortFiler(element_parent_group,e_idgroup);
            }
        });
    }

    /* Destroy sort filer */
    function Color_destroySortFiler() {
        try {
            var destroy = sortable.destroy();
        } catch (e) {}
    }


    /* Refresh filer when complete action */
    function Color_refreshFiler(e_idgroup, e_parent_group) {
        $(e_parent_group).find(".sort-filer, .check-all-filer").removeClass("active");
        $(e_parent_group).find(".sort-filer").attr('disabled', false);
        $(e_parent_group).find(".alert-sort-filer").hide();
        if ($(e_parent_group).find(".check-all-filer").find("i").hasClass("fas fa-check-square")) {
            $(e_parent_group).find(".check-all-filer").find("i").toggleClass("far fa-square fas fa-check-square");
        }
        $(e_parent_group).find(".my-jFiler-items .jFiler-items-list").find('input.filer-checkbox').each(function() {
            $(this).prop('checked', false);
        });
    }

    /* Create sort filer */
    var sortable;

    function Color_createSortFiler(element_parent_group, e_idgroup) {
        if ($("#jFilerSortable-" + e_idgroup).length) {
            sortable = new Sortable.create(document.getElementById('jFilerSortable'), {
                animation: 600,
                swap: true,
                disabled: true,
                // swapThreshold: 0.25,
                ghostClass: 'ghostclass',
                multiDrag: true,
                selectedClass: 'selected',
                forceFallback: false,
                fallbackTolerance: 3,
                onEnd: function() {
                    /* Get all filer sort */
                    listid = new Array();
                    jFilerItems = $("#jFilerSortable-" + e_idgroup).find('.my-jFiler-item');
                    jFilerItems.each(function(index) {
                        listid.push($(this).data("id"));
                    })

                    /* Update number */
                    var idmuc = $('input[name="id"]').val();
                    var id_color = $(element_parent_group).find("input[name='id_color']").val();
                    var com = $(element_parent_group).find('input[name="model"]').val();
                    var kind = $(element_parent_group).find('input[name="level"]').val();
                    var type = $(element_parent_group).find('input[name="type"]').val();
                    var hash = $(element_parent_group).find('input[name="hash_color[]"]').val();
                    var colfiler = $(element_parent_group).find(".col-filer").val();
                    var actfiler = $(element_parent_group).find(".act-filer").val();
                    var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
                    $.ajax({
                        url: "{{ route('admin.ajax.filer') }}",
                        type: 'POST',
                        dataType: 'json',
                        async: false,
                        data: {
                            idmuc: idmuc,
                            id_color: id_color,
                            listid: listid,
                            com: com,
                            kind: actfiler,
                            type: type,
                            colfiler: colfiler,
                            cmd: 'updateNumb',
                            hash: hash,
                            _token: _token
                        },
                        success: function(result) {
                            var arrid = result.id;
                            var arrnumb = result.numb;
                            for (var i = 0; i < arrid.length; i++) $(element_parent_group).find(
                                    '.my-jFiler-item-' + arrid[i]).find("input[type=number]")
                                .val(arrnumb[i]);
                        }
                    })
                },
            });
        }
    }
    @endif
</script>

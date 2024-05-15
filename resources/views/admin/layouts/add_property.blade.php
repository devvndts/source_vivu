{{-- Show nội dung layout thêm size - color --}}
<div class="modal fade" id="modal_property_color" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <form id="form_addColor" method="post" action="{{ route('admin.ajax.addColor') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thêm Màu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="show_addColor">
                    <input type="hidden" name="color[type]" value="{{ $type }}">
                    <div class="modal-color-main">
                        <div class="modal-color-img">
                            <span></span>
                            <div id="photoUpload-color"><img src="{{ asset('img/noimage1.png') }}" width="100%"></div>
                            <label class="photoUpload-file" id="photo-color" for="file-color">
                                <input type="file" name="color_photo" id="file-color">
                            </label>
                        </div>
                        <div class="row modal-color-info">
                            <div class="form-group col-12">
                                <label for="color_tenvi" class="inp">
                                    <input type="text" class="form-control" name="color[tenvi]" id="color_tenvi"
                                        placeholder="&nbsp;" value="">
                                    <span class="label">Tên màu</span>
                                </label>
                            </div>
                            @if (isset($config[$type]['mau_mau']) && $config[$type]['mau_mau'] == true)
                                <div class="form-group col-md-6 col-sm-12">
                                    <label class="d-block" for="mau">Màu sắc:</label>
                                    <input type="text" class="form-control jscolor" name="color[mau]" id="mau"
                                        maxlength="7" value="#000000">
                                </div>
                            @endif

                            @if (isset($config[$type]['mau_loai']) &&
                                $config[$type]['mau_loai'] == true &&
                                (isset($config[$type]['mau_images']) && $config[$type]['mau_images'] == true))
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="loaihienthi">Loại hiển thị:</label>
                                    <select class="form-control" name="color[loaihienthi]" id="loaihienthi">
                                        <option value="0">Chọn loại hiển thị</option>
                                        <option
                                            {{ isset($rowItem['loaihienthi']) && $rowItem['loaihienthi'] == 0 ? 'selected' : '' }}
                                            value="0">Màu sắc</option>
                                        <option
                                            {{ isset($rowItem['loaihienthi']) && $rowItem['loaihienthi'] == 1 ? 'selected' : '' }}
                                            value="1">Hình ảnh</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <input type="button" class="btn btn-primary submit-color">Xác nhận</button> --}}
                    <button type="submit" class="btn btn-primary submit-color">Xác nhận</button>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="modal fade" id="modal_property_size" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <form id="form_addSize" method="post" action="{{ route('admin.ajax.addSize') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thêm size</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="show_addSize">
                    <input type="hidden" name="size_type" value="{{ $type }}">
                    <div class="p-0 form-group col-12">
                        <label for="size_tenvi_0" class="inp">
                            <input type="text" class="form-control" name="size[]" id="size_tenvi_0"
                                placeholder="&nbsp;" value="">
                            <span class="label">Tên size</span>
                        </label>
                    </div>
                    <div id="modal-size-list"></div>
                    <p class="modal-size-add" data-opposite="1"></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary submit-size">Xác nhận</button>
                </div>
            </div>
        </div>
    </form>
</div>


@push('css')
    <link rel="stylesheet" href="{{ asset('css/admin/modal.css') }} ">
@endpush

@push('js')
    <script>
        /*add color*/
        $('body').on("submit", "#form_addColor", function(e) {
            e.preventDefault();
            var id = ($('input[name="id"]').val() != '') ? $('input[name="id"]').val() : 0;
            var type = $('input[name="type_main"]').val();

            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result.status == 'success') {
                        //### load select
                        CallSelectColor(id, type);
                    }
                }
            });
        })

        function CallSelectColor(id, type) {
            $.ajax({
                url: "{{ route('admin.ajax.loadColor') }}",
                type: 'GET',
                dataType: 'html',
                async: false,
                data: {
                    id: id,
                    type: type
                },
                success: function(result) {
                    if (result != '') {
                        $('#show-select-color').html(result);
                        $('#modal_property_color').modal('hide');
                        $('#mau_group').SumoSelect({
                            selectAll: true,
                            search: true,
                            searchText: 'Tìm kiếm'
                        });
                    }
                }
            });
        }


        /*add size*/
        $('.modal-size-add').click(function() {
            var opposite = $(this).attr('data-opposite');
            var str_element = '<div class="p-0 form-group col-12"><label for="size_tenvi_' + opposite +
                '" class="inp"><input type="text" class="form-control" name="size[]" id="size_tenvi_' + opposite +
                '" placeholder="&nbsp;" value=""><span class="label">Tên size</span></label></div>';
            $(this).attr('data-opposite', opposite + 1);
            $('#modal-size-list').append(str_element);
        });

        $('body').on("submit", "#form_addSize", function(e) {
            e.preventDefault();
            var id = ($('input[name="id"]').val() != '') ? $('input[name="id"]').val() : 0;
            var type = $('input[name="type_main"]').val();

            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result.status == 'success') {
                        //### load select
                        CallSelectSize(id, type);
                    }
                }
            });
        })

        function CallSelectSize(id, type) {
            $.ajax({
                url: "{{ route('admin.ajax.loadSize') }}",
                type: 'GET',
                dataType: 'html',
                async: false,
                data: {
                    id: id,
                    type: type
                },
                success: function(result) {
                    if (result != '') {
                        $('#show-select-size').html(result);
                        $('#modal_property_size').modal('hide');
                        $('#size_group').SumoSelect({
                            selectAll: true,
                            search: true,
                            searchText: 'Tìm kiếm'
                        });
                    }
                }
            });
        }
    </script>
@endpush

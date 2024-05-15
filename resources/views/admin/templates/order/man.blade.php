@extends('admin.master')
@php
    $urlAdd = route('admin.order.create', ['man']);
    $urlDeleteAll = route('admin.order.deleteAll', ['man']);
    $urlSearch = route('admin.order.show', ['man', $type]);
@endphp
@section('content')
    @csrf
    <div class="card-footer sticky-top">
        {{-- <x-backend_shared.button href="{{ $urlAdd }}">{{ __('Thêm mới') }}
        </x-backend_shared.button> --}}
        <x-backend_shared.button class="ml-1" type="danger" id="delete-all" data-url="{{ $urlDeleteAll }}"><i
                class="far fa-trash-alt"></i> {{ __('Xóa tất cả') }}
        </x-backend_shared.button>
        @if (config('config_all.order.export_excel') && config('config_all.order.export_excel'))
			<x-backend_shared.button class="ml-1 btn-export-excel" onclick="actionOrder('{{ route('admin.order.exportAll', ['man']) }}');return false;"><i
				class="far fa-trash-alt"></i> {{ __('Xuất đơn hàng Excel') }}
			</x-backend_shared.button>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <!-- tab -->
            @include('admin.layouts.tab_order')

            <div class="card miko-card">
                <div class="card-header">
                    <!-- Error -->
                    @include('admin.layouts.filter_order')
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">
                                            <div class="icheck-primary d-inline dev-check">
                                                <input type="checkbox" id="checkAll">
                                                <label for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th class="text-center align-middle">{{ __('STT') }}</th>

                                        <th class="align-middle" >{{ __('Họ tên') }}</th>
                                        <th class="text-center">{{ __('Ngày') }}</th>
                                        <th class="text-center">{{ __('Tổng giá') }}</th>
                                        <th class="text-center">{{ __('Tình trạng') }}</th>
                                        <th class="text-center">{{ __('Thao tác') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itemShow as $k => $v)
										@php
											$editUrl = route('admin.order.edit', ['man', $v['id'] ?? 0]);
											$deleteUrl = route('admin.order.delete', ['man', $v['id'] ?? 0]);
											$printUrl = route('admin.order.print', ['man', $v['id'] ?? 0]);
											$data = $v;
											$data['model'] = 'order';
											$data['level'] = 'list';
											$data['name'] = $v['tenvi'] ?? '';
											$data['edit_url'] = $editUrl ?? '';
											$data['delete_url'] = $deleteUrl ?? '';
											$data['print_url'] = $printUrl ?? '';
										@endphp
                                        <tr>
                                            <x-backend.index_select :data=$data />
                                            <x-backend.index_ordering :data=$data />

                                            <td class="dev-item-name">
                                                <a class="text-info"
                                                    href="{{ route('admin.order.edit', ['man', $v['id']]) }}">
                                                    <b>{{ $v['hoten'] }}</b>
                                                </a>
                                                <div>{{ $v['madonhang'] }}</div>
                                            </td>

                                            <td class="text-center dev-item-name">
                                                <div>{{ date('h:m', $v['ngaytao']) }}</div>
                                                {{ date('d-m-Y', $v['ngaytao']) }}
                                            </td>

                                            <td class="text-center dev-item-name"><span
                                                    class="text-danger font-weight-bold">{{ number_format($v['tonggia'], 0, ',', '.') }}đ</span>
                                            </td>

                                            <td class="text-center dev-item-name">
                                                <p class="mb-0"><span
                                                        class="badge badge-{{ config('config_all.order_status')[$v['tinhtrang']]['color'] }}">{{ __(config('config_all.order_status')[$v['tinhtrang']]['name']) }}</span>
                                                </p>
                                                <p class="mb-0"><span
                                                        class="badge badge-success">{{ $v['status_payments'] == 1 ? __('Đã thanh toán') : __('Chưa thanh toán') }}</span>
                                                </p>
                                            </td>

                                            <td class="text-center align-middle dev-item-option">
                                                <div class="dropdown show">
                                                    <a class="btn-dropdown" href="#" role="button"
                                                        id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="true">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
														@php
															$loai = 'print';
														@endphp  
														<x-backend.index_operation :data=$data :loai=$loai />
														
														@php
															$loai = 'edit';
														@endphp  
														<x-backend.index_operation :data=$data :loai=$loai />

														@php
															$loai = 'delete';
														@endphp  
														<x-backend.index_operation :data=$data :loai=$loai />
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-footer -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 dev-center dev-paginator">{{ $itemShow->links() }}</div>
                    </div>
                </div>

                <input type='hidden' name="query_str" value="{{ $query_str }}" id="query_str" />
            </div>
        </div>
    </div>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
    <script>
        function doSearch(evt, obj, url) {
            if (url == '') {
                notifyDialog($('input[name="lang_duongdankhonghople"]').val());
                return false;
            }
            if (evt.keyCode == 13 || evt.which == 13) onSearch(obj, url);
            actionOrder(url);
        }
        /* Action order (Search - Export excel - Export word) */
        function actionOrder(url) {
            var listid = "";
            var query_str = $("#query_str").val();
            var tinhtrang = parseInt($("#tinhtrang").val());
            var channel = parseInt($("#channel").val());
            var httt = parseInt($("#httt").val());
            var ngaydat = $("#ngaydat").val();
            var khoanggia = $("#khoanggia").val();
            var city = parseInt($("#id_city").val());
            var district = parseInt($("#id_district").val());
            var wards = parseInt($("#id_wards").val());
            var loaifilexuat = parseInt($("#loaifilexuat").val());
            var keyword = $("#keyword").val();

            $("input.select-checkbox").each(function() {
                if (this.checked) listid = listid + "," + this.value;
            });
            listid = listid.substr(1);
            url += "?listid=" + listid;
            url += "&loaifilexuat=" + loaifilexuat;
            if (tinhtrang) url += "&tinhtrang=" + tinhtrang;
            if (httt) url += "&httt=" + httt;
            if (channel < 6) url += "&channel=" + channel;
            if (ngaydat) url += "&ngaydat=" + ngaydat;
            if (khoanggia) url += "&khoanggia=" + khoanggia;
            if (city) url += "&city=" + city;
            if (district) url += "&district=" + district;
            if (wards) url += "&wards=" + wards;
            if (keyword) url += "&keyword=" + encodeURI(keyword);
            window.location = url;
        }

        $(document).ready(function() {
            $('#ngaydat').daterangepicker({
                callback: this.render,
                autoUpdateInput: false,
                timePicker: false,
                timePickerIncrement: 30,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            })
            $('#ngaydat').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' | ' + picker.endDate.format(
                    'YYYY-MM-DD'));
            });
            $('#ngaydat').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
            });

            /* rangeSlider */
            $('#khoanggia').ionRangeSlider({
                skin: "flat",
                min: {{ $minTotal > 0 ? $minTotal : 1 }},
                max: {{ $maxTotal > 0 ? $maxTotal : 1 }},
                from: {{ $giatu ? $giatu : 1 }},
                to: {{ $giaden ? $giaden : $maxTotal }},
                type: 'double',
                step: 1,
                postfix: ' đ',
                prettify: true,
                hasGrid: true
            })
            $('body').on("click", ".js-load-order-detail", function() {
                let id = $(this).attr('data-id');
                $('#order-detail-' + id).slideToggle();
            })
        });
    </script>
@endsection

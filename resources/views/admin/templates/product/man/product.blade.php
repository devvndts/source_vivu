@extends('admin.master')
@php
    $urlAdd = route('admin.product.add', ['man', $type]);
    $urlDeleteAll = route('admin.product.deleteAll', ['man', $type]);
    $urlSearch = route('admin.product.show', ['man', $type]);
@endphp
@section('content')
    @csrf
    <div class="card-footer sticky-top">
        <x-backend_shared.button href="{{ $urlAdd }}">{{ __('Thêm mới') }}
        </x-backend_shared.button>
        <x-backend_shared.button class="ml-1" type="danger" id="delete-all"
        data-url="{{ $urlDeleteAll }}"><i class="far fa-trash-alt"></i> {{ __('Xóa tất cả') }}
        </x-backend_shared.button>

        @if (
            config('config_all.import_exel') 
            || config('config_all.export_exel')
        )
            <div class="pl-0 ml-1 btn dropdown">
                <button class="btn btn-sm btn-info dropdown-toggle" type="button" 
                    id="dropdownMenuButton" data-toggle="dropdown" 
                    aria-haspopup="true" aria-expanded="false">
                    {{ __('Thao tác') }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @if (
                        config('config_all.import_exel') 
                        && config('config_type.product')[$type]['import_excel'] 
                    )
                        <a class="dropdown-item" 
                        href="{{ route('admin.product.exportAll', ['man', $type]) }}" >
                            <i class="mr-1 fal fa-file-excel"></i>
                            {{ __('Xuất danh sách sản phẩm') }}
                        </a>
                    @endif
                    @if (
                        config('config_all.import_exel')
                        && config('config_type.product')[$type]['export_excel']
                    )
                        <a href="{{ route('admin.product.importView', ['man', $type]) }}" class="dropdown-item"
                            >
                            <i class="mr-1 fal fa-file-excel"></i>
                            {{ __('Nhập danh sách sản phẩm') }}
                        </a>
                        <a href="{{ route('admin.product.importImages', ['man', $type]) }}" class="dropdown-item" >
                            {{ __('Upload hình ảnh') }}
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <x-backend_shared.searchbox keyword="{{ $request->keyword ?? '' }}" url="{{ $urlSearch }}" />
                        <x-backend_form.group class="col-sm-3" style="display: flex;justify-content: space-between; align-items: center;">
                            <x-backend_form.label style="flex-shrink: 0; margin-right: 10px" isInlineBlock>{{ __('Danh mục') }}
                            </x-backend_form.label>
                            @php
                                
                            @endphp
                            <x-backend_form.select_category :selectedIds="(int)($request->filter_category_value)" id="filter_category" :data=$arrCategory />
                        </x-backend_form.group>
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body /table-responsive">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">
                                            <div class="icheck-primary d-inline dev-check">
                                                <input type="checkbox" id="checkAll">
                                                <label for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th class="text-center align-middle">{{ __('STT') }}</th>

                                        @if (isset($config[$type]['show_images']) && $config[$type]['show_images'])
                                            <th>{{ __('Hình') }}</th>
                                        @endif

                                        <th>{{ __('Tiêu đề') }}</th>
                                        <th>{{ __('Danh mục') }}</th>

                                        @if (isset($config[$type]['check']) && $config[$type]['check'])
                                            @foreach ($config[$type]['check'] as $key => $value)
                                                @php
                                                    TableManipulation::AddFieldToTable('product', $key);
                                                @endphp
                                                <th class="text-center align-middle">{{ __($value) }}</th>
                                            @endforeach
                                        @endif

                                        <th class="text-center align-middle">{{ __('Hiển thị') }}</th>
                                        <th class="text-center">{{ __('Thao tác') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itemShow as $k => $v)
                                    @php
                                        $photoUrl = Thumb::Crop(UPLOAD_PRODUCT, $v['photo'], 150, 150, 3, null, 'jpg');
                                        $editUrl = route('admin.product.edit', ['man', $type, $v['id'] ?? 0]);
                                        $deleteUrl = route('admin.product.delete', ['man', $type, $v['id'] ?? 0]);
                                        $data = $v;
                                        $data['model'] = 'product';
                                        $data['level'] = 'man';
                                        $data['name'] = $v['tenvi'] ?? '';
                                        $data['edit_url'] = $editUrl ?? '';
                                        $data['delete_url'] = $deleteUrl ?? '';
                                        $data['photo_url'] =  $photoUrl;
                                    @endphp
                                        <tr>
                                            <x-backend.index_select :data=$data />
                                            <x-backend.index_ordering :data=$data />
                                            
                                            @if (isset($config[$type]['show_images']) && $config[$type]['show_images'])
                                                <x-backend.index_photo :data=$data />
                                            @endif

                                            <x-backend.index_name :data=$data />
                                            <x-backend.index_category :data=$data />
                                            
                                            @if (isset($config[$type]['check']) && $config[$type]['check'])
                                                @foreach ($config[$type]['check'] as $key => $value)
                                                    @php
                                                        $loai = $key;
                                                    @endphp                                            
                                                    <x-backend.index_checkbox :data=$data :loai=$loai />
                                                @endforeach
                                            @endif

                                            @php
                                                $loai = 'hienthi';
                                            @endphp                                            
                                            <x-backend.index_checkbox :data=$data :loai=$loai />

                                            <td class="text-center align-middle dev-item-option">
                                                <div class="dropdown show">
                                                    <a class="btn-dropdown" href="#" role="button"
                                                        id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="true">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                                                        @php
                                                        $postProduct = $config[$type]['post_product'] ?? null;
                                                        $htmlPostProduct = null;
                                                        $htmlFormat = '<a target="_blank" class="btn btn-sm d-block btn-none-css" href="%s"><i class="fas fa-pencil-alt"></i> %s</a>';
                                                        if ($postProduct) {
                                                            foreach ($postProduct as $key => $value) {
                                                                $url = route('admin.post.show', ['man', $key, 'id_product' => $v['id']]);
                                                                $htmlPostProduct .= sprintf($htmlFormat, $url, $value['title']);
                                                            }
                                                        }
                                                        @endphp
                                                        {!! $htmlPostProduct ?? '' !!}

                                                        <x-backend.index_operation :data=$data />

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

                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 dev-center dev-paginator">{{ $itemShow->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
    <script>
        /* Action order (Search - Export excel - Export word) */
        function actionOrder(url) {
            var listid = "";
            var query_str = $("#query_str").val();

            $("input.select-checkbox").each(function() {
                if (this.checked) listid = listid + "," + this.value;
            });
            listid = listid.substr(1);
            url += "?listid=" + listid;
            window.location = url + query_str;
        }

        $('.dropdown-menu').click(function(e) {
            e.stopPropagation();
        });

        $('.miko-product-grid-btn').click(function() {
            var addClass = $(this).attr('data-class');
            var type = $(this).attr('data-type');
            var e_idChanged = $('.miko-products');

            if (type == 'add') {
                if (!e_idChanged.hasClass(addClass)) {
                    e_idChanged.addClass(addClass);
                }
            } else {
                if (e_idChanged.hasClass(addClass)) {
                    e_idChanged.removeClass(addClass);
                }
            }
        });
    </script>
@endsection

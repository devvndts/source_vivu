@extends('admin.master')
@php
    $urlAdd = route('admin.category.edit', [$type]);
    $urlDeleteAll = route('admin.category.deleteAll', [$type]);
    $urlSearch = route('admin.category.show', [$type]);
@endphp
@section('content')
    @csrf
    <div class="card-footer sticky-top">
        <x-backend_shared.button href="{{ $urlAdd }}">{{ __('Thêm mới') }}
        </x-backend_shared.button>
        <x-backend_shared.button class="ml-1" type="danger" id="delete-all"
        data-url="{{ $urlDeleteAll }}"><i class="far fa-trash-alt"></i> {{ __('Xóa tất cả') }}
        </x-backend_shared.button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <x-backend_shared.searchbox keyword="{{ $request->keyword ?? '' }}" url="{{ $urlSearch }}" />
                        {{-- <div class="form-group col-xl-3 col-lg-3 col-md-3 col-sm-6 form-filter-category">
                            @include('admin.layouts.filter_category')
                        </div> --}}
                    </div>
                    {{-- <h3 class="card-title">Danh sách {{ $config[$type]['title_main_list'] }}</h3> --}}
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
                                        @if (isset($config[$type]['show_images_category']) && $config[$type]['show_images_category'] == true)
                                        <th>{{ __('Hình') }}</th>
                                        @endif
                                        <th>{{ __('Tiêu đề') }}</th>
                                        @if (isset($config[$type]['check_category']) && $config[$type]['check_category'] == true)
                                            @foreach ($config[$type]['check_category'] as $key => $value)
                                                @php
                                                    TableManipulation::AddFieldToTable('category', $key);
                                                @endphp
                                                <th class="text-center align-middle">{{ __($value) }}</th>
                                            @endforeach
                                        @endif
                                        <th class="text-center align-middle">{{ __('Hiển thị') }}</th>
                                        <th class="text-center">{{ __('Thao tác') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        /*
                                        - Show tất cả item category gọi file child_category_level kiểu đệ quy
                                        - Nếu có keyword thì không dùng đệ quy được show kiểu bình thường child_category
                                        */
                                    @endphp
                                    @foreach ($itemShow as $item)
                                        @php
                                            $level = '';
                                        @endphp
                                        @if ($request->keyword)
                                            @include('admin.templates.category.man.child_category', ['categories' => $item, 'level' => $level])
                                        @else
                                            @if ($item["level"] == 0)
                                                @include('admin.templates.category.man.child_category_level', ['categories' => $item, 'level' => $level])
                                            @endif
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!--js thêm cho mỗi trang-->
@section('js_page')
@endsection

@extends('admin.master')
@php
    $urlAdd = route('admin.post.add', ['man', $type, 'id_product' => $idParent]);
    $urlDeleteAll = route('admin.post.deleteAll', ['man', $type, 'id_product' => $idParent]);
    $urlSearch = route('admin.post.show', ['man', $type]);
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
                        {{-- @if (isset($config[$type]['dropdown']) && $config[$type]['dropdown'] == true)
                          <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-6 form-filter-category">
                            @include('admin.layouts.category')
                          </div>	
                      @endif --}}
                    </div>
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

                                        @if (isset($config[$type]['show_images']) && $config[$type]['show_images'])
                                            <th>{{ __('Hình') }}</th>
                                        @endif

                                        <th>{{ __('Tiêu đề') }}</th>
                                        @if (isset($config[$type]['check']) && $config[$type]['check'])
                                            @foreach ($config[$type]['check'] as $key => $value)
                                                @php
                                                    TableManipulation::AddFieldToTable('post', $key);
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
                                        $path_upload = config('config_all.fileupload') ? config('config_upload.UPLOAD_GALLERY') : config('config_upload.UPLOAD_POST');
                                        $photoUrl = Thumb::Crop($path_upload, $v['photo'], 150, 150, 3, null, 'jpg');
                                        $editUrl = route('admin.post.edit', ['man', $type, $v['id'] ?? 0, 'id_product' => $idParent ?? 0]);
                                        $deleteUrl = route('admin.post.delete', ['man', $type, $v['id'] ?? 0, 'id_product' => $idParent ?? 0]);
                                        $data = $v;
                                        $data['model'] = 'post';
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
                                            {{-- <x-backend.index_category :data=$data /> --}}
                                            
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
@endsection

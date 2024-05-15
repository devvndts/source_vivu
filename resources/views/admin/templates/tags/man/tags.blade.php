@extends('admin.master')
@php
    $urlAdd = route('admin.tags.add', ['man', $type]);
    $urlDeleteAll = route('admin.tags.deleteAll', ['man', $type]);
    $urlSearch = route('admin.tags.show', ['man', $type]);
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
                    </div>
                </div>
                <div class="p-0 card-body table-responsive">
                    <table class="table table-hover">
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
                            @foreach($itemShow as $k=>$v)
                                @php
                                    $photoUrl = Thumb::Crop(UPLOAD_TAGS, $v['photo'], 150, 150, 3, null, 'jpg');
                                    $editUrl = route('admin.tags.edit', ['man', $type, $v['id'] ?? 0]);
                                    $deleteUrl = route('admin.tags.delete', ['man', $type, $v['id'] ?? 0]);
                                    $data = $v;
                                    $data['model'] = 'tags';
                                    $data['level'] = 'man';
                                    $data['name'] = $v['tenvi'] ?? '';
                                    $data['edit_url'] = $editUrl ?? '';
                                    $data['delete_url'] = $deleteUrl ?? '';
                                    $data['photo_url'] = $photoUrl;
                                @endphp
                                <tr>
                                    <x-backend.index_select :data=$data />
                                    <x-backend.index_ordering :data=$data />

                                    @if (isset($config[$type]['show_images']) && $config[$type]['show_images'])
                                        <x-backend.index_photo :data=$data />
                                    @endif

                                    <x-backend.index_name :data=$data />

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
                                            <a class="btn-dropdown" href="#" role="button" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
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

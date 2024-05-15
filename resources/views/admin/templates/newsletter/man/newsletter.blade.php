@extends('admin.master')
@php
    $urlAdd = route('admin.newsletter.edit', ['man', $type]);
    $urlDeleteAll = route('admin.newsletter.deleteAll', ['man', $type]);
    $urlSearch = route('admin.newsletter.show', ['man', $type]);
@endphp
@section('content')
    @csrf
    <div class="text-sm card-footer sticky-top">
        @if (isset($config[$type]['guiemail']) && $config[$type]['guiemail'])
            <a class="text-white btn btn-sm bg-gradient-success" id="send-email" >
                <i class="mr-2 fas fa-paper-plane"></i>{{ __('Gửi email') }}</a>
        @endif
        <x-backend_shared.button href="{{ $urlAdd }}">{{ __('Thêm mới') }}
        </x-backend_shared.button>
        <x-backend_shared.button class="ml-1" type="danger" id="delete-all"
        data-url="{{ $urlDeleteAll }}"><i class="far fa-trash-alt"></i> {{ __('Xóa tất cả') }}
        </x-backend_shared.button>
    </div>
    <div class="mb-0 text-sm card card-primary card-outline">
        <x-backend_shared.card_header isShowMinus>
            {{ __('Danh sách') }} {{ __($config[$type]['title_main']) }}
            @if (isset($config[$type]['guiemail']) && $config[$type]['guiemail'])
                <p class="float-left mt-1 mb-0 d-block text-secondary w-100">{{ __('Chọn email sau đó kéo xuống dưới cùng danh sách này để có thể thiết lập nội dung email muốn gửi đi.') }}</p>
            @endif
        </x-backend_shared.card_header>
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
                        @if ($config[$type]['showten'])
                            <th class="align-middle" >{{ __('Họ tên') }}</th>
                        @endif
                        <th class="align-middle">Email</th>
                        @if ($config[$type]['showdienthoai'])
                            <th class="align-middle">{{ __('Điện thoại') }}</th>
                        @endif
                        <th class="text-center align-middle">{{ __('Tình trạng') }}</th>
                        <th class="text-center align-middle">{{ __('Đã xem') }}</th>
                        <th class="text-center align-middle">{{ __('Thao tác') }}</th>
                    </tr>
                </thead>
                @if (empty($itemShow))
                    <tbody>
                        <tr>
                            <td colspan="100" class="text-center">{{ __('Không có dữ liệu') }}</td>
                        </tr>
                    </tbody>
                @else
                    <tbody>
                        @foreach ($itemShow as $k => $v)
                            @php
                                $editUrl = route('admin.newsletter.edit', ['man', $type, $v['id'] ?? 0]);
                                $deleteUrl = route('admin.newsletter.delete', ['man', $type, $v['id'] ?? 0]);
                                $data = $v;
                                $data['model'] = 'newsletter';
                                $data['level'] = 'man';
                                $data['name'] = $v['tenvi'] ?? '';
                                $data['edit_url'] = $editUrl ?? '';
                                $data['delete_url'] = $deleteUrl ?? '';
                            @endphp
                            <tr>
                                <x-backend.index_select :data=$data />
                                <x-backend.index_ordering :data=$data />
                                @if ($config[$type]['showten'])
                                <x-backend.index_name :data=$data />
                                @endif

                                <td class="align-middle">
                                    {{ $v['email'] }}
                                </td>

                                @if ($config[$type]['showdienthoai'])
                                <td class="align-middle">
                                    {{ $v['dienthoai'] }}
                                </td>        
                                @endif

                                @if (isset($config[$type]['tinhtrang']) && count($config[$type]['tinhtrang']) > 0)
                                    <td class="text-center align-middle">{!! __(Helper::get_status_newsletter($v['tinhtrang'], $type)) !!}</td>
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
                @endif
            </table>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-sm-12 dev-center dev-paginator">{{ $itemShow->links() }}</div>
        </div>
    </div>

    @if (isset($config[$type]['guiemail']) && $config[$type]['guiemail'])
        <div class="mt-3 mb-0 text-sm card card-primary card-outline">
            <form name="frmsendemail" method="post" action="{{ route('admin.newsletter.send', ['man', $type]) }}"
                enctype="multipart/form-data">
                @csrf
                <x-backend_shared.card_header >
                    {{ __('Gửi email đến danh sách được chọn') }}
                </x-backend_shared.card_header>
                <div class="card-body">
                    <x-backend_form.group >
                        <x-backend_form.label >{{ __('Tiêu đề') }}: </x-backend_form.label>
                        <x-backend_form.input type="text" name="tieude" id="tieude" />
                    </x-backend_form.group>

                    <div class="form-group">
                        <label class="mb-1 mr-2 align-middle d-inline-block">{{ __('Upload tập tin') }}:</label>
                        <strong class="mt-2 mb-2 text-sm d-block">{{ $config[$type]['file_type'] }}</strong>
                        <div class="custom-file my-custom-file">
                            <input type="file" class="custom-file-input" name="file" id="file">
                            <label class="custom-file-label" for="file">{{ __('Chọn file') }}</label>
                        </div>
                    </div>

                    @php
                        $class = "form-control-ckeditor ";
                        $labelName = $config[$type]['noidung_title'] ?? __('Nội dung');
                    @endphp
                    <x-backend_form.group >
                        <x-backend_form.label >{{ $labelName }}: </x-backend_form.label>
                        <x-backend_form.textarea class="{{ $class }}" name="noidung" id="noidung" rows="5"></x-backend_form.textarea>
                    </x-backend_form.group>
                    
                    <input type="hidden" name="listemail" id="listemail">
                </div>
            </form>
        </div>
    @endif
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
    <script>
        /* Send email */
        $('body').on('click', '#send-email', function() {
            confirmDialog("send-email", $('input[name="lang_sendemail"]').val(), "");
        });

        /* Send email */
        function sendEmail() {
            var listemail = "";
            $("input.select-checkbox").each(function() {
                if (this.checked) listemail = listemail + "," + this.value;
            });
            listemail = listemail.substr(1);
            if (listemail == "") {
                notifyDialog($('input[name="lang_select_one"]').val());
                return false;
            }
            $("#listemail").val(listemail);
            document.frmsendemail.submit();
        }
    </script>
@endsection

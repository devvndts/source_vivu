@extends('admin.master')
@section('content')
    @csrf
    <div class="card-footer sticky-top">
        <a class="text-white btn btn-sm bg-gradient-primary" href="{{ route('admin.redirector.add') }}"
            ></i>{{ __('Thêm mới') }}</a>
        <a class="ml-1 text-white btn btn-sm bg-gradient-danger" id="delete-all"
            data-url="{{ route('admin.redirector.deleteAll') }}" ><i
                class="far fa-trash-alt"></i> {{ __('Xóa tất cả') }}</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="mb-2 align-middle form-inline col-sm-3 form-search d-inline-block">
                            <div class="input-group input-group-sm">
                                <input class="text-sm form-control form-control-navbar" type="search" id="keyword"
                                    placeholder="{{ __('Tìm kiếm') }}" aria-label="Tìm kiếm"
                                    value="{{ $request->keyword ?? '' }}"
                                    onkeypress="doEnter(event,'keyword','{{ route('admin.redirector.show') }}')">
                                <div class="input-group-append bg-primary rounded-right">
                                    <button class="text-white btn btn-navbar" type="button"
                                    onclick="onSearch('keyword','{{ route('admin.redirector.show') }}')">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body table-responsive">
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
                                        <th>{{ __('Origin') }}</th>
                                        <th>{{ __('Destination') }}</th>
                                        <th class="text-center">{{ __('Thao tác') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itemShow as $k => $v)
                                    @php
                                        $editUrl = route('admin.redirector.edit', [$v->id ?? 0]);
                                        $deleteUrl = route('admin.redirector.delete', [$v->id ?? 0]);
                                        $data = (array)$v;
                                        $data['name'] = $v->origin ?? '';
                                        $data['edit_url'] = $editUrl ?? '';
                                        $data['delete_url'] = $deleteUrl ?? '';

                                        $dataRedirector['name'] = $v->destination ?? '';
                                        $dataRedirector['edit_url'] = $editUrl ?? '';
                                        $dataRedirector['delete_url'] = $deleteUrl ?? '';
                                    @endphp
                                        <tr>
                                            <td class="text-center align-middle dev-item-checkbox">
                                                <div class="icheck-primary d-inline dev-check">
                                                    <input type="checkbox" class="select-checkbox"
                                                        id="checkItem-{{ $data['id'] }}" value="{{ $data['id'] }}">
                                                    <label for="checkItem-{{ $data['id'] }}"></label>
                                                </div>
                                            </td>
                                            <x-backend.index_name :data=$data />
                                            <x-backend.index_name :data=$dataRedirector />
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
                {{-- <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 dev-center dev-paginator">{{ $itemShow->links() }}</div>
                    </div>
                </div> --}}
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

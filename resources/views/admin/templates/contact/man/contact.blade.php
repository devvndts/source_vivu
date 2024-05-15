@extends('admin.master')
@php
    $urlAdd = route('admin.contact.edit', ['man', $type]);
    $urlDeleteAll = route('admin.contact.deleteAll', ['man', $type]);
    $urlSearch = route('admin.contact.show', ['man', $type]);
@endphp
@section('content')
    @csrf
    <div class="text-sm card-footer sticky-top">
        <x-backend_shared.button type="danger" id="delete-all" data-url="{{ $urlDeleteAll }}"><i class="far fa-trash-alt"></i>
            {{ __('Xóa tất cả') }}
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
                                <th class="align-middle" >{{ __('Họ tên') }}</th>
                                <th class="align-middle">Email</th>
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
									$editUrl = route('admin.contact.edit', ['man', $type, $v['id'] ?? 0]);
									$deleteUrl = route('admin.contact.delete', ['man', $type, $v['id'] ?? 0]);
									$data = $v;
									$data['model'] = 'contact';
									$data['level'] = 'man';
									$data['name'] = $v['tenvi'] ?? '';
									$data['edit_url'] = $editUrl ?? '';
									$data['delete_url'] = $deleteUrl ?? '';
								@endphp
                                    <tr>
										<x-backend.index_select :data=$data />
										<x-backend.index_ordering :data=$data />

                                        <x-backend.index_name :data=$data />

										<td class="align-middle">
											{{ $v['email'] }}
										</td>   

                                        @php
											$loai = 'hienthi';
										@endphp                                            
										<x-backend.index_checkbox :data=$data :loai=$loai />

                                        <td class="text-center align-middle text-md text-nowrap">
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
                        @endif
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

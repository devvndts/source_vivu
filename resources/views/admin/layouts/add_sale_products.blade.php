<div class="modal fade" id="modal_property_size" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <form id="form_addSize" method="post" action="{{route('admin.ajax.addSaleProduct')}}" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="show_addSize">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">
                                    <div class="icheck-primary d-inline dev-check">
                                        <input type="checkbox" id="checkAll">
                                        <label for="checkAll"></label>
                                    </div>
                                </th>
                                <th>Sản phẩm</th>
                                <th class="text-center">Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $k => $v)
							@php
								$item_id = $v->id;
								$item_gia = $v->gia;
								$item_tenvi = $v->tenvi;
								$item_photo = $v->photo;
								$item_masp = $v->masp;
							@endphp
                                <tr>
                                    <td class="text-center align-middle dev-item-checkbox">
                                        <div class="icheck-primary d-inline dev-check">
                                            <input type="checkbox" class="select-checkbox"
                                                id="checkItem-{{ $item_id }}" value="{{ $item_id }}">
                                            <label for="checkItem-{{ $item_id }}"></label>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="text-info" >
                                            <b>{{ $item_tenvi }}</b>
										</div>
                                        <div>{{ $item_masp }}</div>
                                    </td>
                                    <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format($item_gia, 0, ',', '.') }}đ</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        $('body').on("submit", "#form_addSize", function(e) {
            e.preventDefault();
            var id = ($('input[name="id"]').val() != '') ? $('input[name="id"]').val() : 0;
			var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
            var type = $('input[name="type_main"]').val();
			var listid = "";
			$("input.select-checkbox").each(function(){
				if(this.checked) listid = listid+","+this.value;
			});
			listid = listid.substr(1);
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                dataType: "JSON",
                data: {'listid': listid, 'id': id, _token:_token},
                success: function(result) {
                    if (result.status == 'success') {
                        //### load select
                        // CallSelectSize(id, type);
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

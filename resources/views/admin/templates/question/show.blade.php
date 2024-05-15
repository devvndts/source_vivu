@extends('admin.master')

@section('content')
	@csrf
	<div class="card-footer text-sm sticky-top">
        <div class="btn dropdown pl-0 ml-1">
          <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Thao tác
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">            
            <a class="btn btn-sm bg-gradient-primary btn-none-css" href="{{ route('admin.question.edit',['man']) }}" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
            <a class="btn btn-sm bg-gradient-danger btn-none-css" id="delete-all" data-url="{{ route('admin.question.deleteAll', ['man']) }}" title="{{ __('Xóa tất cả') }}"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a> 
          </div>
        </div>		       
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline text-sm mb-0">
                <div class="card-header">
                    <div class="form-inline form-search align-middle mb-3">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="{{ __('Tìm kiếm') }}" aria-label="Tìm kiếm" value="{{ (isset($request->keyword))?$request->keyword:'' }}" onkeypress="doEnter(event,'keyword','{{ route('admin.question.show',['man']) }}')">
                            <div class="input-group-append bg-primary rounded-right">
                                <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','{{ route('admin.question.show',['man']) }}')">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
        						<th class="align-middle text-center">
        							<div class="icheck-primary d-inline dev-check">
        								<input type="checkbox" id="checkAll">
        								<label for="checkAll"></label>
        							</div>
        						</th>
        						<th class="align-middle" >Ngày gửi</th>
        						<th class="align-middle" style="width:20%">Họ tên</th>
        						<th class="align-middle" style="width:30%">Email</th>
        						<th class="align-middle" >Số điện thoại</th>
        						<th class="align-middle text-center d-none">Đã duyệt</th>
                                <th class="align-middle text-center">Hiển thị</th>
                                <th class="align-middle text-center">Duyệt</th>
                                <th class="align-middle text-center">Thao tác</th>
                            </tr>
                        </thead>
                        @if(empty($itemShow))
                            <tbody><tr><td colspan="100" class="text-center">Không có dữ liệu</td></tr></tbody>
                        @else
                            <tbody>
                                @foreach($itemShow as $k=>$v)
                                    <tr>
        								<td class="dev-item-checkbox align-middle text-center">
        									<div class="icheck-primary d-inline dev-check">
        				                        <input type="checkbox" class="select-checkbox" id="checkItem-{{$v['id']}}" value="{{$v['id']}}">
        				                        <label for="checkItem-{{$v['id']}}"></label>
        				                    </div>
        								</td>

        								<td class="align-middle">
                                            <a class="text-green">{{date('d-m-Y',$v['ngaytao'])}}</a>
                                            <p>
                                                <span class="badge badge-danger">{{($v['duyettin']==0) ? 'Mới' : ''}}</span>
                                                <span class="badge badge-info">{{($v['answer']=='') ? 'Chưa trả lời' : ''}}</span>
                                            </p>
                                        </td>

                                        <td class="align-middle">
                                            <a class="text-info" href="{{route('admin.question.edit',['man',$v['id']])}}" title="{{$v['hoten']}}">{{$v['hoten']}}</a>
                                        </td>

        								<td class="align-middle">
                                            <a class="text-danger" href="{{route('admin.question.edit',['man',$v['id']])}}" title="{{$v['email']}}">{{$v['email']}}</a>
                                        </td>

                                        <td class="align-middle">
                                            <a class="text-dark" href="{{route('admin.question.edit',['man',$v['id']])}}" title="{{$v['dienthoai']}}">{{$v['dienthoai']}}</a>
                                        </td>

        								<td class="align-middle text-center dev-item-display show-checkbox d-none">
                                        	<div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input" data-model="question" data-level="man" data-id="{{ $v['id'] }}" data-loai="duyettin" {{($v['duyettin'])?'checked':''}}>
                                                <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                            </div>
                                        </td>

                                        <td class="align-middle text-center dev-item-display show-checkbox">
                                            <div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input" data-model="question" data-level="man" data-id="{{ $v['id'] }}" data-loai="hienthi" {{($v['hienthi'])?'checked':''}}>
                                                <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                            </div>
                                        </td>

                                        <td class="align-middle text-center dev-item-display show-checkbox">
                                            <div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input" data-model="question" data-level="man" data-id="{{ $v['id'] }}" data-loai="duyettin" {{($v['duyettin'])?'checked':''}}>
                                                <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                            </div>
                                        </td>

                                        <td class="dev-item-option align-middle text-center">
                                            <div class="dropdown show">
                                              <a class="btn-dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="fas fa-ellipsis-v" ></i>
                                              </a>

                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="btn btn-sm d-block btn-none-css" href="{{route('admin.question.edit',['man',$v['id']])}}" title="Trả lời"><i class="fas fa-comments"></i> Trả lời</a>
                                                    <a class="btn btn-sm d-block delete-item btn-none-css" data-url="{{route('admin.question.delete',['man',$v['id']])}}" title="Xóa"><i class="fas fa-trash-alt"></i> Xóa</a>
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
		$('body').on('click','#send-email', function(){
			confirmDialog("send-email","Bạn muốn gửi thông tin cho các mục đã chọn ?","");
		});

		/* Send email */
		function sendEmail(){
			var listemail="";
			$("input.select-checkbox").each(function(){
				if (this.checked) listemail = listemail+","+this.value;
			});
			listemail = listemail.substr(1);
			if(listemail == ""){
				notifyDialog("Bạn hãy chọn ít nhất 1 mục để gửi");
				return false;
			}
			$("#listemail").val(listemail);
			document.frmsendemail.submit();
		}
	</script>
@endsection

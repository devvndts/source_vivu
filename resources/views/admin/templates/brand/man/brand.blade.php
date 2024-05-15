@extends('admin.master')

@section('content')
	@csrf
	<div class="card-footer text-sm sticky-top">
    	<a class="btn btn-sm bg-gradient-primary text-white" href="{{ route('admin.brand.edit',['man',$type]) }}" title="Thêm mới"><i class="fas fa-plus mr-2"></i>Thêm mới</a>
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="{{ route('admin.brand.deleteAll', ['man', $type]) }}" title="{{ __('Xóa tất cả') }}"><i class="far fa-trash-alt mr-2"></i>{{ __('Xóa tất cả') }}</a>        
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">                
                <div class="card-header">
                    <div class="form-inline col-sm-3 form-search d-inline-block align-middle">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="{{ __('Tìm kiếm') }}" aria-label="Tìm kiếm" value="{{ (isset($request->keyword))?$request->keyword:'' }}" onkeypress="doEnter(event,'keyword','{{ route('admin.brand.show',['man', $type]) }}')">
                            <div class="input-group-append bg-primary rounded-right">
                                <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','{{ route('admin.brand.show',['man', $type]) }}')">
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
                                <th class="align-middle text-center" width="10%">STT</th>
                                @if(isset($config[$type]['mau_images']) && $config[$type]['mau_images'] == true)
                                    <th class="align-middle">Hình</th>
                                @endif
        						<th class="align-middle" style="width:30%">Tiêu đề</th>
                                @if(isset($config[$type]['check_brand']) && $config[$type]['check_brand'] == true)
                                    @foreach($config[$type]['check_brand'] as $key => $value)
                                        @php
                                            TableManipulation::AddFieldToTable('brand',$key);
                                        @endphp
                                        <th class="align-middle text-center">{{ $value }}</th>
                                    @endforeach
                                @endif
        						<th class="align-middle text-center">Hiển thị</th>
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
        				                        <input type="checkbox" class="select-checkbox" id="checkItem-{{$v['id']}}" value="<?=$v['id']?>">
        				                        <label for="checkItem-{{$v['id']}}"></label>
        				                    </div>
        								</td>
        								<td class="dev-item-stt">
        									<input type="number" class="form-control form-control-mini m-auto update-stt" min="0" value="{{$v['stt']}}" data-id="{{$v['id']}}" data-model="brand" data-level="man">
        								</td>

                                        @if(isset($config[$type]['mau_images']) && $config[$type]['mau_images'] == true)
                                            <td class="align-middle dev-item-img">
                                                <a href="{{route('admin.brand.edit',['man',$type,$v['id']])}}"><img src="{{ config('config_upload.UPLOAD_BRAND').$v['photo'] }}" onerror=src="{{asset('img/noimage.png')}}" alt="image"></a>
                                            </td>
                                        @endif
                                        <td class="align-middle">
                                            <a class="text-dark" href="{{route('admin.brand.edit',['man',$type,$v['id']])}}" title="{{$v['tenvi']}}">{{$v['tenvi']}}</a>
                                        </td>

                                        @if(isset($config[$type]['check_brand']) && $config[$type]['check_brand'] == true)
                                            @foreach($config[$type]['check_brand'] as $key => $value)
                                                <td class="align-middle text-center dev-item-display show-checkbox">
                                                    <div class="custom-control custom-checkbox my-checkbox">
                                                        <input type="checkbox" class="custom-control-input" data-model="brand" data-level="man" data-id="{{ $v['id'] }}" data-loai="{{$key}}" {{($v[$key])?'checked':''}}>
                                                        <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                            @endforeach
                                        @endif

        								<td class="align-middle text-center dev-item-display show-checkbox">
                                        	<div class="custom-control custom-checkbox my-checkbox">
                                                <input type="checkbox" class="custom-control-input" data-model="brand" data-level="man" data-id="{{ $v['id'] }}" data-loai="hienthi" {{($v['hienthi'])?'checked':''}}>
                                                <label for="show-checkbox-{{ $v['id'] }}" class="custom-control-label"></label>
                                            </div>
                                        </td>
                                        <td class="dev-item-option align-middle text-center">
                                            <div class="dropdown show">
                                              <a class="btn-dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="fas fa-ellipsis-v" ></i>
                                              </a>

                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="btn btn-sm d-block btn-none-css" href="{{route('admin.brand.edit',['man',$type,$v['id']])}}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i> Chỉnh sửa</a>
                                                    <a class="btn btn-sm d-block delete-item btn-none-css" data-url="{{route('admin.brand.delete',['man',$type,$v['id']])}}" title="Xóa"><i class="fas fa-trash-alt"></i> Xóa</a>
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

@endsection

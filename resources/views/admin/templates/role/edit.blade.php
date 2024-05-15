@extends('admin.master')

@section('content')
<form method="post" action="{{ route('admin.role.save') }}" enctype="multipart/form-data">
    @csrf
    <div class="card-footer text-sm sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
    </div>

    <div class="card card-primary card-outline text-sm">
        <div class="card-header">
            <h3 class="card-title">Thông tin chính</h3>
        </div>
        <div class="card-body">
			<div class="form-group">
				<label for="ten">Tên nhóm quyền: <span class="text-danger">*</span></label>
				<input type="text" class="form-control" name="data[name]" id="ten" placeholder="Tên nhóm quyền" value="{{(isset($rowItem['role_name']))?$rowItem['role_name']:''}}" required>
			</div>
			<div class="form-group">
				<label class="d-inline-block align-middle mb-0" for="ten">Chọn tất cả:</label>
                <div class="icheck-primary d-inline dev-check">
                    <input type="checkbox" id="selectAll">
                    <label for="selectAll"></label>
                </div>
			</div>
			<div class="form-group">
				<label for="hienthi" class="d-inline-block align-middle mb-0 mr-2">Kích hoạt:</label>
				<div class="icheck-primary d-inline dev-check">
                    <input type="checkbox" class="" name="data[hienthi]" id="hienthi-checkbox" {{(!isset($rowItem['hienthi']) || $rowItem['hienthi']==1)?'checked':''}}>
                    <label for="hienthi-checkbox"></label>
                </div>
			</div>
			<div class="form-group">
				<label for="stt" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
				<input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[stt]" id="stt" placeholder="Số thứ tự" value="{{(isset($rowItem['stt'])) ? $rowItem['stt'] : 1}}">
			</div>
            <input type="hidden" name="id" value="{{(isset($rowItem['id']))?$rowItem['id']:''}}" required>
        </div>
    </div>

    @if(config('config_type.product'))
        @foreach(config('config_type.product') as $key => $value)
            @if(isset($value['dropdown']) && $value['dropdown'] == true)
            <div class="card card-permission card-primary card-outline text-sm parent-select">
                <div class="card-header">
                    <div class="card-tools-dev">
                        <div class="icheck-primary d-inline dev-check">
                            <input type="checkbox" id="selectAll-{{$key}}" class="selectAllParent">
                            <label for="selectAll-{{$key}}">Quản lý {{$value['title_main']}}</label>
                        </div>
                    </div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($value['list']) && $value['list'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_man_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_man_list_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_add_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_add_list_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_edit_list_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_delete_list_{{$key}}">@endif

                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-list-{{$key}}">Danh mục cấp 1:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'product_man_list_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-list-view-{{$key}}" value="product_man_list_{{$key}}" {{ (isset($permissions) && in_array('product_man_list_'.$key,$permissions))?'checked':'' }} >
    		                        <label for="quyen-product-list-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_add_list_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-list-add-{{$key}}" value="product_add_list_{{$key}}" {{ (isset($permissions) && in_array('product_add_list_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-list-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_list_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-list-edit-{{$key}}" value="product_edit_list_{{$key}}" {{ (isset($permissions) && in_array('product_edit_list_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-list-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_list_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-list-delete-{{$key}}" value="product_delete_list_{{$key}}" {{ (isset($permissions) && in_array('product_delete_list_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-list-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endif

                    @if(isset($value['cat']) && $value['cat'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_man_cat_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_man_cat_{{$key}}">@endif
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_add_cat_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_add_cat_{{$key}}">@endif
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_cat_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_edit_cat_{{$key}}">@endif
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_cat_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_delete_cat_{{$key}}">@endif

                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-cat-{{$key}}">Danh mục cấp 2:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'product_man_cat_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-cat-view-{{$key}}" value="product_man_cat_{{$key}}" {{ (isset($permissions) && in_array('product_man_cat_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-cat-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_add_cat_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-cat-add-{{$key}}" value="product_add_cat_{{$key}}" {{ (isset($permissions) && in_array('product_add_cat_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-cat-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_cat_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-cat-edit-{{$key}}" value="product_edit_cat_{{$key}}" {{ (isset($permissions) && in_array('product_edit_cat_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-cat-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_cat_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-cat-delete-{{$key}}" value="product_delete_cat_{{$key}}" {{ (isset($permissions) && in_array('product_delete_cat_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-cat-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endif

    				@if(isset($value['item']) && $value['item'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_man_item_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_man_item_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_add_item_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_add_item_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_item_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_edit_item_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_item_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_delete_item_{{$key}}">@endif


                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-item-{{$key}}">Danh mục cấp 3:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'product_man_item_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-item-view-{{$key}}" value="product_man_item_{{$key}}" {{ (isset($permissions) && in_array('product_man_item_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-item-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_add_item_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-item-add-{{$key}}" value="product_add_item_{{$key}}" {{ (isset($permissions) && in_array('product_add_item_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-item-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_item_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-item-edit-{{$key}}" value="product_edit_item_{{$key}}" {{ (isset($permissions) && in_array('product_edit_item_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-item-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_item_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-item-delete-{{$key}}" value="product_delete_item_{{$key}}" {{ (isset($permissions) && in_array('product_delete_item_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-item-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endif

    				@if(isset($value['sub']) && $value['sub'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_man_sub_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_man_sub_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_add_sub_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_add_sub_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_sub_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_edit_sub_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_sub_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_delete_sub_{{$key}}">@endif


                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-sub-{{$key}}">Danh mục cấp 4:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'product_man_sub_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-sub-view-{{$key}}" value="product_man_sub_{{$key}}" {{ (isset($permissions) && in_array('product_man_sub_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-sub-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_add_sub_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-sub-add-{{$key}}" value="product_add_sub_{{$key}}" {{ (isset($permissions) && in_array('product_add_sub_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-sub-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_sub_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-sub-edit-{{$key}}" value="product_edit_sub_{{$key}}" {{ (isset($permissions) && in_array('product_edit_sub_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-sub-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_sub_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-sub-delete-{{$key}}" value="product_delete_sub_{{$key}}" {{ (isset($permissions) && in_array('product_delete_sub_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-sub-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endif

                    @if(isset($value['mau']) && $value['mau'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_man_mau_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_man_mau_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_add_mau_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_add_mau_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_mau_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_edit_mau_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_mau_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_delete_mau_{{$key}}">@endif


                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-mau-{{$key}}">Danh mục màu sắc:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'product_man_mau_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-mau-view-{{$key}}" value="product_man_mau_{{$key}}" {{ (isset($permissions) && in_array('product_man_mau_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-mau-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_add_mau_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-mau-add-{{$key}}" value="product_add_mau_{{$key}}" {{ (isset($permissions) && in_array('product_add_mau_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-mau-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_mau_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-mau-edit-{{$key}}" value="product_edit_mau_{{$key}}" {{ (isset($permissions) && in_array('product_edit_mau_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-mau-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_mau_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-mau-delete-{{$key}}" value="product_delete_mau_{{$key}}" {{ (isset($permissions) && in_array('product_delete_mau_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-mau-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
                	@endif

                    @if(isset($value['brand']) && $value['brand'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_man_brand_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_man_brand_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_add_brand_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_add_brand_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_brand_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_edit_brand_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_brand_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_delete_brand_{{$key}}">@endif

                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-brand-{{$key}}">Danh mục kích thước:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'product_man_brand_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-brand-view-{{$key}}" value="product_man_brand_{{$key}}" {{ (isset($permissions) && in_array('product_man_brand_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-brand-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_add_brand_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-brand-add-{{$key}}" value="product_add_brand_{{$key}}" {{ (isset($permissions) && in_array('product_add_brand_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-brand-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_brand_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-brand-edit-{{$key}}" value="product_edit_brand_{{$key}}" {{ (isset($permissions) && in_array('product_edit_brand_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-brand-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_brand_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-brand-delete-{{$key}}" value="product_delete_brand_{{$key}}" {{ (isset($permissions) && in_array('product_delete_brand_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-brand-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
                	@endif

                	@if(isset($value['size']) && $value['size'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_man_size_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_man_size_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_add_size_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_add_size_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_size_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_edit_size_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_size_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_delete_size_{{$key}}">@endif

                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-size-{{$key}}">Danh mục kích thước:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'product_man_size_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-size-view-{{$key}}" value="product_man_size_{{$key}}" {{ (isset($permissions) && in_array('product_man_size_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-size-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_add_size_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-size-add-{{$key}}" value="product_add_size_{{$key}}" {{ (isset($permissions) && in_array('product_add_size_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-size-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_size_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-size-edit-{{$key}}" value="product_edit_size_{{$key}}" {{ (isset($permissions) && in_array('product_edit_size_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-size-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_size_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-size-delete-{{$key}}" value="product_delete_size_{{$key}}" {{ (isset($permissions) && in_array('product_delete_size_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-product-size-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
                	@endif

    				<div class="form-group row">
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'product_deleproduct_man_te_size_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_man_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_add_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_add_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_edit_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_delete_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_import_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_import_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'product_export_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_export_{{$key}}">@endif

    					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-{{$key}}">{{$value['title_main']}}:</label>
    					<div class="col-md-7">
                            @if(Helper::CheckPermissionParent($permissions_parent,'product_man_'.$key))
    						<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-view-{{$key}}" value="product_man_{{$key}}" {{ (isset($permissions) && in_array('product_man_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-product-view-{{$key}}" class="font-weight-normal">Xem</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_add_'.$key))
    	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-add-{{$key}}" value="product_add_{{$key}}" {{ (isset($permissions) && in_array('product_add_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-product-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_'.$key))
    	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-edit-{{$key}}" value="product_edit_{{$key}}" {{ (isset($permissions) && in_array('product_edit_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-product-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_'.$key))
    	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-delete-{{$key}}" value="product_delete_{{$key}}" {{ (isset($permissions) && in_array('product_delete_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-product-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_import_'.$key))
                                @if(config('config_all.import_exel') && config('config_all.import_exel') == true  && config('config_type.product')[$key]['import_excel']  && config('config_type.product')[$key]['import_excel'] == true)
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-import-{{$key}}" value="product_import_{{$key}}" {{ (isset($permissions) && in_array('product_import_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-product-import-{{$key}}" class="font-weight-normal">Import Excel</label>
        	                    </div>
                                @endif
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_export_'.$key))
                                @if(config('config_all.export_exel') && config('config_all.export_exel') == true && config('config_type.product')[$key]['export_excel'] && config('config_type.product')[$key]['export_excel'] == true)
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-export-{{$key}}" value="product_export_{{$key}}" {{ (isset($permissions) && in_array('product_export_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-product-export-{{$key}}" class="font-weight-normal">Export Excel</label>
        	                    </div>
                                @endif
                            @endif
    					</div>
    				</div>

                </div>
            </div>
            @endif
        @endforeach

        @if(config('config_type.product.shownews'))
            <div class="card card-permission card-primary card-outline text-sm parent-select">
                <div class="card-header">
                    <div class="card-tools-dev">
                        <div class="icheck-primary d-inline dev-check">
                            <input type="checkbox" id="selectAll-{{$key}}" class="selectAllParent">
                            <label for="selectAll-{{$key}}">Quản lý sản phẩm khác</label>
                        </div>
                    </div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @foreach(config('config_type.product.shownews') as $key => $value)
        				<div class="form-group row">
                            {{-- hidden --}}
                            @if(Helper::CheckPermissionParent($permissions_parent,'product_man_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_man_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_add_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_add_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_add_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_edit_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_delete_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_import_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_import_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'product_export_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="product_export_{{$key}}">@endif

        					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-{{$key}}">{{$value['title_main']}}:</label>
        					<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'product_man_'.$key))
        						<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-view-{{$key}}" value="product_man_{{$key}}" {{ (isset($permissions) && in_array('product_man_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-product-view-{{$key}}" class="font-weight-normal">Xem</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_add_'.$key))
        	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-add-{{$key}}" value="product_add_{{$key}}" {{ (isset($permissions) && in_array('product_add_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-product-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_edit_'.$key))
        	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-edit-{{$key}}" value="product_edit_{{$key}}" {{ (isset($permissions) && in_array('product_edit_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-product-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_delete_'.$key))
        	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-delete-{{$key}}" value="product_delete_{{$key}}" {{ (isset($permissions) && in_array('product_delete_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-product-delete-{{$key}}" class="font-weight-normal">Xóa</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_import_'.$key))
                                    @if(config('config_all.import_exel') && config('config_all.import_exel') == true && config('config_type.product')[$key]['import_excel'] && config('config_type.product')[$key]['import_excel'] == true)
                                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
            	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-import-{{$key}}" value="product_import_{{$key}}" {{ (isset($permissions) && in_array('product_import_'.$key,$permissions))?'checked':'' }}>
            	                        <label for="quyen-product-import-{{$key}}" class="font-weight-normal">Import Excel</label>
            	                    </div>
                                    @endif
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'product_export_'.$key))
                                    @if(config('config_all.export_exel') && config('config_all.export_exel') == true && config('config_type.product')[$key]['export_excel'] && config('config_type.product')[$key]['export_excel'] == true)
                                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
            	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-product-export-{{$key}}" value="product_export_{{$key}}" {{ (isset($permissions) && in_array('product_export_'.$key,$permissions))?'checked':'' }}>
            	                        <label for="quyen-product-export-{{$key}}" class="font-weight-normal">Export Excel</label>
            	                    </div>
                                    @endif
                                @endif
        					</div>
        				</div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif


    @if(config('config_type.post'))
        @foreach(config('config_type.post') as $key => $value)
            @if(isset($value['dropdown']) && $value['dropdown'] == true)
            <div class="card card-permission card-primary card-outline text-sm parent-select">
                <div class="card-header">
                    <div class="card-tools-dev">
                        <div class="icheck-primary d-inline dev-check">
                            <input type="checkbox" id="selectAll-{{$key}}" class="selectAllParent">
                            <label for="selectAll-{{$key}}">Quản lý {{$value['title_main']}}</label>
                        </div>
                    </div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($value['list']) && $value['list'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'post_man_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_man_list_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_add_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_add_list_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_edit_list_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_delete_list_{{$key}}">@endif

                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-list-{{$key}}">Danh mục cấp 1:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'post_man_list_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-list-view-{{$key}}" value="post_man_list_{{$key}}" {{ (isset($permissions) && in_array('post_man_list_'.$key,$permissions))?'checked':'' }} >
    		                        <label for="quyen-post-list-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_add_list_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-list-add-{{$key}}" value="post_add_list_{{$key}}" {{ (isset($permissions) && in_array('post_add_list_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-list-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_list_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-list-edit-{{$key}}" value="post_edit_list_{{$key}}" {{ (isset($permissions) && in_array('post_edit_list_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-list-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_list_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-list-delete-{{$key}}" value="post_delete_list_{{$key}}" {{ (isset($permissions) && in_array('post_delete_list_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-list-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endif

                    @if(isset($value['cat']) && $value['cat'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'post_man_cat_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_man_cat_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_add_cat_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_add_cat_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_cat_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_edit_cat_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_cat_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_delete_cat_{{$key}}">@endif

                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-cat-{{$key}}">Danh mục cấp 2:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'post_man_cat_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-cat-view-{{$key}}" value="post_man_cat_{{$key}}" {{ (isset($permissions) && in_array('post_man_cat_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-cat-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_add_cat_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-cat-add-{{$key}}" value="post_add_cat_{{$key}}" {{ (isset($permissions) && in_array('post_add_cat_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-cat-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_cat_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-cat-edit-{{$key}}" value="post_edit_cat_{{$key}}" {{ (isset($permissions) && in_array('post_edit_cat_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-cat-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_cat_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-cat-delete-{{$key}}" value="post_delete_cat_{{$key}}" {{ (isset($permissions) && in_array('post_delete_cat_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-cat-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endif

    				@if(isset($value['item']) && $value['item'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'post_man_item_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_man_item_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_add_item_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_add_item_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_item_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_edit_item_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_item_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_delete_item_{{$key}}">@endif

                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-item-{{$key}}">Danh mục cấp 3:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'post_man_item_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-item-view-{{$key}}" value="post_man_item_{{$key}}" {{ (isset($permissions) && in_array('post_man_item_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-item-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_add_item_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-item-add-{{$key}}" value="post_add_item_{{$key}}" {{ (isset($permissions) && in_array('post_add_item_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-item-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_item_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-item-edit-{{$key}}" value="post_edit_item_{{$key}}" {{ (isset($permissions) && in_array('post_edit_item_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-item-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_item_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-item-delete-{{$key}}" value="post_delete_item_{{$key}}" {{ (isset($permissions) && in_array('post_delete_item_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-item-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endif

    				@if(isset($value['sub']) && $value['sub'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'post_man_sub_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_man_sub_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_add_sub_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_add_sub_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_sub_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_edit_sub_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_sub_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_delete_sub_{{$key}}">@endif

                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-sub-{{$key}}">Danh mục cấp 4:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'post_man_sub_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-sub-view-{{$key}}" value="post_man_sub_{{$key}}" {{ (isset($permissions) && in_array('post_man_sub_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-sub-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_add_sub_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-sub-add-{{$key}}" value="post_add_sub_{{$key}}" {{ (isset($permissions) && in_array('post_add_sub_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-sub-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_sub_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-sub-edit-{{$key}}" value="post_edit_sub_{{$key}}" {{ (isset($permissions) && in_array('post_edit_sub_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-sub-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_sub_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-sub-delete-{{$key}}" value="post_delete_sub_{{$key}}" {{ (isset($permissions) && in_array('post_delete_sub_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-sub-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endif

    				<div class="form-group row">
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'post_man_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_man_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_add_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_add_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_edit_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_delete_{{$key}}">@endif

    					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-{{$key}}">{{$value['title_main']}}:</label>
    					<div class="col-md-7">
                            @if(Helper::CheckPermissionParent($permissions_parent,'post_man_'.$key))
    						<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-view-{{$key}}" value="post_man_{{$key}}" {{ (isset($permissions) && in_array('post_man_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-post-view-{{$key}}" class="font-weight-normal">Xem</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'post_add_'.$key))
    	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-add-{{$key}}" value="post_add_{{$key}}" {{ (isset($permissions) && in_array('post_add_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-post-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_'.$key))
    	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-edit-{{$key}}" value="post_edit_{{$key}}" {{ (isset($permissions) && in_array('post_edit_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-post-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))
    	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-delete-{{$key}}" value="post_delete_{{$key}}" {{ (isset($permissions) && in_array('post_delete_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-post-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    	                    </div>
                            @endif
    					</div>
    				</div>

                </div>
            </div>
            @endif
        @endforeach

        @if(config('config_type.post.shownews'))
            <div class="card card-permission card-primary card-outline text-sm parent-select">
                <div class="card-header">
                    <div class="card-tools-dev">
                        <div class="icheck-primary d-inline dev-check">
                            <input type="checkbox" id="selectAll-{{$key}}" class="selectAllParent">
                            <label for="selectAll-{{$key}}">Quản lý bài viết</label>
                        </div>
                    </div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @foreach(config('config_type.post.shownews') as $key => $value)
        				<div class="form-group row">
                            {{-- hidden --}}
                            @if(Helper::CheckPermissionParent($permissions_parent,'post_man_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_man_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'post_add_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_add_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_edit_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="post_delete_{{$key}}">@endif

        					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-{{$key}}">{{$value['title_main']}}:</label>
        					<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'post_man_'.$key))
        						<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-view-{{$key}}" value="post_man_{{$key}}" {{ (isset($permissions) && in_array('post_man_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-post-view-{{$key}}" class="font-weight-normal">Xem</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_add_'.$key))
        	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-add-{{$key}}" value="post_add_{{$key}}" {{ (isset($permissions) && in_array('post_add_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-post-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_edit_'.$key))
        	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-edit-{{$key}}" value="post_edit_{{$key}}" {{ (isset($permissions) && in_array('post_edit_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-post-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))
        	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-delete-{{$key}}" value="post_delete_{{$key}}" {{ (isset($permissions) && in_array('post_delete_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-post-delete-{{$key}}" class="font-weight-normal">Xóa</label>
        	                    </div>
                                @endif
        					</div>
        				</div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif


    @if(config('config_type.tags'))
		<div class="card card-permission card-primary card-outline text-sm parent-select">
            <div class="card-header">
                <div class="card-tools-dev">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="selectAll-tags" class="selectAllParent">
                        <label for="selectAll-tags">Quản lý hình ảnh tĩnh - video</label>
                    </div>
                </div>
                <div class="card-tools">
                	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
            	@foreach(config('config_type.tags') as $key => $value)
					<div class="form-group row">
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="tags_man_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="tags_add_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="tags_edit_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="tags_delete_{{$key}}">@endif

						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-tags-{{$key}}">{{$value['title_main']}}:</label>
						<div class="col-md-7">
                            @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))
							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-tags-view-{{$key}}" value="tags_man_{{$key}}" {{ (isset($permissions) && in_array('tags_man_'.$key,$permissions))?'checked':'' }}>
		                        <label for="quyen-tags-view-{{$key}}" class=" font-weight-normal">Xem</label>
		                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))
		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-tags-add-{{$key}}" value="tags_add_{{$key}}" {{ (isset($permissions) && in_array('tags_add_'.$key,$permissions))?'checked':'' }}>
		                        <label for="quyen-tags-add-{{$key}}" class=" font-weight-normal">Thêm mới</label>
		                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))
		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-tags-edit-{{$key}}" value="tags_edit_{{$key}}" {{ (isset($permissions) && in_array('tags_edit_'.$key,$permissions))?'checked':'' }}>
		                        <label for="quyen-tags-edit-{{$key}}" class=" font-weight-normal">Chỉnh sửa</label>
		                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'post_delete_'.$key))
		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-tags-delete-{{$key}}" value="tags_delete_{{$key}}" {{ (isset($permissions) && in_array('tags_delete_'.$key,$permissions))?'checked':'' }}>
		                        <label for="quyen-tags-delete-{{$key}}" class=" font-weight-normal">Xóa</label>
		                    </div>
                            @endif
						</div>
					</div>
				@endforeach
            </div>
        </div>
	@endif

    @if(config('config_type.photo'))
		<div class="card card-permission card-primary card-outline text-sm parent-select">
            <div class="card-header">
                <div class="card-tools-dev">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="selectAll-static-photo" class="selectAllParent">
                        <label for="selectAll-static-photo">Quản lý hình ảnh tĩnh - video</label>
                    </div>
                </div>
                <div class="card-tools">
                	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
            	@foreach(config('config_type.photo') as $key => $value)
                    @if($value['category']=='photo_static')
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'photo_photo_static_'.$key))
                            <input type="hidden" class="custom-control-input" name="dataPermission[]" value="photo_photo_static_{{$key}}">
        					<div class="form-group row">
        						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-photo-static-{{$key}}">{{$value['title_main']}}:</label>
        						<div class="col-md-7">
        							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-photo-static-{{$key}}" value="photo_photo_static_{{$key}}" {{ (isset($permissions) && in_array('photo_photo_static_'.$key,$permissions))?'checked':'' }}>
        		                        <label for="quyen-photo-static-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
        		                    </div>
        		                </div>
        					</div>
                        @endif
                    @elseif($value['category']=='man_photo')
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'photo_man_photo_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="photo_man_photo_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'photo_add_photo_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="photo_add_photo_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'photo_edit_photo_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="photo_edit_photo_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'photo_delete_photo_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="photo_delete_photo_{{$key}}">@endif

                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-man-photo-{{$key}}">{{$value['title_main']}}:</label>
                            <div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'photo_man_photo_'.$key))
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-man-photo-view-{{$key}}" value="photo_man_photo_{{$key}}" {{ (isset($permissions) && in_array('photo_man_photo_'.$key,$permissions))?'checked':'' }}>
                                    <label for="quyen-man-photo-view-{{$key}}" class="font-weight-normal">Xem</label>
                                </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'photo_add_photo_'.$key))
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-man-photo-add-{{$key}}" value="photo_add_photo_{{$key}}" {{ (isset($permissions) && in_array('photo_add_photo_'.$key,$permissions))?'checked':'' }}>
                                    <label for="quyen-man-photo-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
                                </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'photo_edit_photo_'.$key))
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-man-photo-edit-{{$key}}" value="photo_edit_photo_{{$key}}" {{ (isset($permissions) && in_array('photo_edit_photo_'.$key,$permissions))?'checked':'' }}>
                                    <label for="quyen-man-photo-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
                                </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'photo_delete_photo_'.$key))
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
                                    <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-man-photo-delete-{{$key}}" value="photo_delete_photo_{{$key}}" {{ (isset($permissions) && in_array('photo_delete_photo_'.$key,$permissions))?'checked':'' }}>
                                    <label for="quyen-man-photo-delete-{{$key}}" class="font-weight-normal">Xóa</label>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endif
				@endforeach
            </div>
        </div>
	@endif

    @if(config('config_all.order.active')==true)
        {{-- hidden --}}
        @if(Helper::CheckPermissionParent($permissions_parent,'order_man'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="order_man">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'order_edit'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="order_edit">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'order_create'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="order_create">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'order_delete'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="order_delete">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'order_export'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="order_export">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'order_dongboall'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="order_dongboall">@endif

		<div class="card card-permission card-primary card-outline text-sm parent-select">
            <div class="card-header">
                <div class="card-tools-dev">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="selectAll-order" class="selectAllParent">
                        <label for="selectAll-order">Quản lý đơn hàng</label>
                    </div>
                </div>
                <div class="card-tools">
                	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    @if(Helper::CheckPermissionParent($permissions_parent,'order_man'))
    				<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-order-view" value="order_man" {{ (isset($permissions) && in_array('order_man',$permissions))?'checked':'' }}>
                        <label for="quyen-order-view" class="font-weight-normal">Xem</label>
                    </div>
                    @endif

                    @if(Helper::CheckPermissionParent($permissions_parent,'order_edit'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-order-edit" value="order_edit" {{ (isset($permissions) && in_array('order_edit',$permissions))?'checked':'' }}>
                        <label for="quyen-order-edit" class="font-weight-normal">Chỉnh sửa</label>
                    </div>
                    @endif

                    @if(Helper::CheckPermissionParent($permissions_parent,'order_create'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-order-create" value="order_create" {{ (isset($permissions) && in_array('order_create',$permissions))?'checked':'' }}>
                        <label for="quyen-order-create" class="font-weight-normal">Tạo đơn</label>
                    </div>
                    @endif

                    @if(Helper::CheckPermissionParent($permissions_parent,'order_delete'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-order-delete" value="order_delete" {{ (isset($permissions) && in_array('order_delete',$permissions))?'checked':'' }}>
                        <label for="quyen-order-delete" class="font-weight-normal">Xóa</label>
                    </div>
                    @endif

                    @if(Helper::CheckPermissionParent($permissions_parent,'order_dongboall'))
                        @if(config('config_all.order.dongboall') && config('config_all.order.dongboall') == true)
                        <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                            <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-order-dongboall" value="order_dongboall" {{ (isset($permissions) && in_array('order_dongboall',$permissions))?'checked':'' }}>
                            <label for="quyen-order-dongboall" class="font-weight-normal">Đồng bộ</label>
                        </div>
                        @endif
                    @endif

                    @if(Helper::CheckPermissionParent($permissions_parent,'order_export'))
                        @if(config('config_all.order.export_excel') && config('config_all.order.export_excel') == true)
                        <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
                            <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-order-export" value="order_export" {{ (isset($permissions) && in_array('order_export',$permissions))?'checked':'' }}>
                            <label for="quyen-order-export" class="font-weight-normal">Export excel</label>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
	@endif


    @if(config('config_type.album'))
        @foreach(config('config_type.album') as $key => $value)
            @if(isset($value['dropdown']) && $value['dropdown'] == true)
            <div class="card card-permission card-primary card-outline text-sm parent-select">
                <div class="card-header">
                    <div class="card-tools-dev">
                        <div class="icheck-primary d-inline dev-check">
                            <input type="checkbox" id="selectAll-{{$key}}" class="selectAllParent">
                            <label for="selectAll-{{$key}}">Quản lý {{$value['title_main']}}</label>
                        </div>
                    </div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($value['list']) && $value['list'] == true)
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'album_man_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_man_list_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'album_add_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_add_list_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'album_edit_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_edit_list_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'album_delete_list_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_delete_list_{{$key}}">@endif

                		<div class="form-group row">
    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-album-list-{{$key}}">Danh mục cấp 1:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'album_man_list_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-list-view-{{$key}}" value="album_man_list_{{$key}}" {{ (isset($permissions) && in_array('album_man_list_'.$key,$permissions))?'checked':'' }} >
    		                        <label for="quyen-album-list-view-{{$key}}" class="font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'album_add_list_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-list-add-{{$key}}" value="album_add_list_{{$key}}" {{ (isset($permissions) && in_array('album_add_list_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-album-list-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'album_edit_list_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-list-edit-{{$key}}" value="album_edit_list_{{$key}}" {{ (isset($permissions) && in_array('album_edit_list_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-album-list-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'album_delete_list_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-post-list-delete-{{$key}}" value="album_delete_list_{{$key}}" {{ (isset($permissions) && in_array('album_delete_list_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-post-list-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endif

    				<div class="form-group row">
                        {{-- hidden --}}
                        @if(Helper::CheckPermissionParent($permissions_parent,'album_man_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_man_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'album_add_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_add_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'album_edit_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_edit_{{$key}}">@endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'album_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_delete_{{$key}}">@endif

    					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-album-{{$key}}">{{$value['title_main']}}:</label>
    					<div class="col-md-7">
                            @if(Helper::CheckPermissionParent($permissions_parent,'album_man_'.$key))
    						<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-view-{{$key}}" value="album_man_{{$key}}" {{ (isset($permissions) && in_array('album_man_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-album-view-{{$key}}" class="font-weight-normal">Xem</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'album_add_'.$key))
    	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-add-{{$key}}" value="album_add_{{$key}}" {{ (isset($permissions) && in_array('album_add_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-album-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'album_edit_'.$key))
    	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-edit-{{$key}}" value="album_edit_{{$key}}" {{ (isset($permissions) && in_array('album_edit_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-album-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
    	                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'album_delete_'.$key))
    	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-delete-{{$key}}" value="album_delete_{{$key}}" {{ (isset($permissions) && in_array('album_delete_'.$key,$permissions))?'checked':'' }}>
    	                        <label for="quyen-album-delete-{{$key}}" class="font-weight-normal">Xóa</label>
    	                    </div>
                            @endif
    					</div>
    				</div>

                </div>
            </div>
            @endif
        @endforeach

        @if(config('config_type.album.shownews'))
            <div class="card card-permission card-primary card-outline text-sm parent-select">
                <div class="card-header">
                    <div class="card-tools-dev">
                        <div class="icheck-primary d-inline dev-check">
                            <input type="checkbox" id="selectAll-{{$key}}" class="selectAllParent">
                            <label for="selectAll-{{$key}}">Quản lý hình ảnh (Album)</label>
                        </div>
                    </div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @foreach(config('config_type.album.shownews') as $key => $value)
        				<div class="form-group row">
                            {{-- hidden --}}
                            @if(Helper::CheckPermissionParent($permissions_parent,'album_man_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_man_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'album_add_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_add_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'album_edit_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_edit_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'album_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="album_delete_{{$key}}">@endif

        					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-album-{{$key}}">{{$value['title_main']}}:</label>
        					<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'album_man_'.$key))
        						<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-view-{{$key}}" value="album_man_{{$key}}" {{ (isset($permissions) && in_array('album_man_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-album-view-{{$key}}" class="font-weight-normal">Xem</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'album_add_'.$key))
        	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-add-{{$key}}" value="album_add_{{$key}}" {{ (isset($permissions) && in_array('album_add_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-album-add-{{$key}}" class="font-weight-normal">Thêm mới</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'album_edit_'.$key))
        	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-edit-{{$key}}" value="album_edit_{{$key}}" {{ (isset($permissions) && in_array('album_edit_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-album-edit-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
        	                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'album_delete_'.$key))
        	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
        	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-album-delete-{{$key}}" value="album_delete_{{$key}}" {{ (isset($permissions) && in_array('album_delete_'.$key,$permissions))?'checked':'' }}>
        	                        <label for="quyen-album-delete-{{$key}}" class="font-weight-normal">Xóa</label>
        	                    </div>
                                @endif
        					</div>
        				</div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif


    @if(config('config_type.newsletter') || config('config_type.contact'))
		<div class="card card-permission card-primary card-outline text-sm parent-select">
            <div class="card-header">
                <div class="card-tools-dev">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="selectAll-dkemail" class="selectAllParent">
                        <label for="selectAll-dkemail">Quản lý đăng ký email</label>
                    </div>
                </div>
                <div class="card-tools">
                	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                @if(config('config_type.newsletter'))
                	@foreach(config('config_type.newsletter') as $key => $value)
    					<div class="form-group row">
                            {{-- hidden --}}
                            @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_man_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="newsletter_man_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_add_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="newsletter_add_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_edit_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="newsletter_edit_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="newsletter_delete_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_send_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="newsletter_send_{{$key}}">@endif

    						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-newsletter-{{$key}}">{{$value['title_main']}}:</label>
    						<div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_man_'.$key))
    							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-newsletter-view-{{$key}}" value="newsletter_man_{{$key}}" {{ (isset($permissions) && in_array('newsletter_man_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-newsletter-view-{{$key}}" class=" font-weight-normal">Xem</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_add_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-newsletter-add-{{$key}}" value="newsletter_add_{{$key}}" {{ (isset($permissions) && in_array('newsletter_add_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-newsletter-add-{{$key}}" class=" font-weight-normal">Thêm mới</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_edit_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-newsletter-edit-{{$key}}" value="newsletter_edit_{{$key}}" {{ (isset($permissions) && in_array('newsletter_edit_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-newsletter-edit-{{$key}}" class=" font-weight-normal">Chỉnh sửa</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_send_'.$key))
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-newsletter-send-{{$key}}" value="newsletter_send_{{$key}}" {{ (isset($permissions) && in_array('newsletter_send_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-newsletter-send-{{$key}}" class=" font-weight-normal">Gửi mail</label>
    		                    </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'newsletter_delete_'.$key))
    		                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
    		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-newsletter-delete-{{$key}}" value="newsletter_delete_{{$key}}" {{ (isset($permissions) && in_array('newsletter_delete_'.$key,$permissions))?'checked':'' }}>
    		                        <label for="quyen-newsletter-delete-{{$key}}" class=" font-weight-normal">Xóa</label>
    		                    </div>
                                @endif
    						</div>
    					</div>
    				@endforeach
                @endif

                @if(config('config_type.contact'))
                    @foreach(config('config_type.contact') as $key => $value)
                        <div class="form-group row">
                            {{-- hidden --}}
                            @if(Helper::CheckPermissionParent($permissions_parent,'contact_man_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="contact_man_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'contact_add_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="contact_add_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'contact_edit_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="contact_edit_{{$key}}">@endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'contact_delete_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="contact_delete_{{$key}}">@endif

                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-newsletter-{{$key}}">{{$value['title_main']}}:</label>
                            <div class="col-md-7">
                                @if(Helper::CheckPermissionParent($permissions_parent,'contact_man_'.$key))
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-contact-view-{{$key}}" value="contact_man_{{$key}}" {{ (isset($permissions) && in_array('contact_man_'.$key,$permissions))?'checked':'' }}>
                                    <label for="quyen-contact-view-{{$key}}" class=" font-weight-normal">Xem</label>
                                </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'contact_add_'.$key))
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-contact-add-{{$key}}" value="contact_add_{{$key}}" {{ (isset($permissions) && in_array('contact_add_'.$key,$permissions))?'checked':'' }}>
                                    <label for="quyen-contact-add-{{$key}}" class=" font-weight-normal">Thêm mới</label>
                                </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'contact_edit_'.$key))
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                                    <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-contact-edit-{{$key}}" value="contact_edit_{{$key}}" {{ (isset($permissions) && in_array('contact_edit_'.$key,$permissions))?'checked':'' }}>
                                    <label for="quyen-contact-edit-{{$key}}" class=" font-weight-normal">Chỉnh sửa</label>
                                </div>
                                @endif

                                @if(Helper::CheckPermissionParent($permissions_parent,'contact_delete_'.$key))
                                <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
                                    <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-contact-delete-{{$key}}" value="contact_delete_{{$key}}" {{ (isset($permissions) && in_array('contact_delete_'.$key,$permissions))?'checked':'' }}>
                                    <label for="quyen-contact-delete-{{$key}}" class=" font-weight-normal">Xóa</label>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
	@endif


    @if(config('config_type.staticpost'))
		<div class="card card-permission card-primary card-outline text-sm parent-select">
            <div class="card-header">
                <div class="card-tools-dev">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="selectAll-static-post" class="selectAllParent">
                        <label for="selectAll-static-post">Quản lý trang tĩnh</label>
                    </div>
                </div>
                <div class="card-tools">
                	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
            	@foreach(config('config_type.staticpost') as $key => $value)
                    {{-- hidden --}}
                    @if(Helper::CheckPermissionParent($permissions_parent,'staticpost_show_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="staticpost_show_{{$key}}">@endif

                    @if(Helper::CheckPermissionParent($permissions_parent,'staticpost_capnhat_'.$key))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="staticpost_capnhat_{{$key}}">@endif

					<div class="form-group row">
						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-staticpost-{{$key}}">{{$value['title_main']}}:</label>
						<div class="col-md-7">
                            @if(Helper::CheckPermissionParent($permissions_parent,'staticpost_show_'.$key))
                            <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-staticpost-show-{{$key}}" value="staticpost_show_{{$key}}" {{ (isset($permissions) && in_array('staticpost_show_'.$key,$permissions))?'checked':'' }}>
		                        <label for="quyen-staticpost-show-{{$key}}" class="font-weight-normal">Xem</label>
		                    </div>
                            @endif

                            @if(Helper::CheckPermissionParent($permissions_parent,'staticpost_capnhat_'.$key))
							<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
		                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-staticpost-capnhat-{{$key}}" value="staticpost_capnhat_{{$key}}" {{ (isset($permissions) && in_array('staticpost_capnhat_'.$key,$permissions))?'checked':'' }}>
		                        <label for="quyen-staticpost-capnhat-{{$key}}" class="font-weight-normal">Chỉnh sửa</label>
		                    </div>
                            @endif
						</div>
					</div>
				@endforeach
            </div>
        </div>
	@endif

    @if(config('config_type.setting'))
        <div class="card card-permission card-primary card-outline text-sm parent-select">
            <div class="card-header">
                <div class="card-tools-dev">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="selectAll-setting" class="selectAllParent">
                        <label for="selectAll-setting">Quản lý thông tin chung</label>
                    </div>
                </div>
                <div class="card-tools">
                	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                @foreach(config('config_type.setting') as $key => $value)
                    {{-- hidden --}}
                    @if(Helper::CheckPermissionParent($permissions_parent,'setting_capnhat_'.$key))
                        <input type="hidden" class="custom-control-input" name="dataPermission[]" value="setting_capnhat_{{$key}}">
        				<div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-setting-{{$key}}">{{$value['title_main']}}:</label>
                            <div class="col-md-7">
            					<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
            		                <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-setting-{{$key}}" value="setting_capnhat_{{$key}}" {{ (isset($permissions) && in_array('setting_capnhat_'.$key,$permissions))?'checked':'' }}>
            		                <label for="quyen-setting" class="font-weight-normal">Chỉnh sửa</label>
            		            </div>
                            </div>
        				</div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    @if(config('config_all.places'))
        <div class="card card-permission card-primary card-outline text-sm parent-select">
            <div class="card-header">
                <div class="card-tools-dev">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="selectAll-places" class="selectAllParent">
                        <label for="selectAll-places">Quản lý địa điểm</label>
                    </div>
                </div>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                {{-- city --}}
                {{-- hidden --}}
                @if(Helper::CheckPermissionParent($permissions_parent,'place_man_city'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_man_city">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_add_city'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_add_city">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_edit_city'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_edit_city">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_delete_city'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_delete_city">@endif

        		<div class="form-group row">
					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-place-city">Danh mục tỉnh thảnh:</label>
					<div class="col-md-7">
                        @if(Helper::CheckPermissionParent($permissions_parent,'place_man_city'))
						<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-place-city-man" value="place_man_city" {{ (isset($permissions) && in_array('place_man_city',$permissions))?'checked':'' }} >
	                        <label for="quyen-place-city-man" class="font-weight-normal">Xem</label>
	                    </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_add_city'))
	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-city-add" value="place_add_city" {{ (isset($permissions) && in_array('place_add_city',$permissions))?'checked':'' }}>
	                        <label for="uyen-places-city-add" class="font-weight-normal">Thêm mới</label>
	                    </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_edit_city'))
	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-city-edit" value="place_edit_city" {{ (isset($permissions) && in_array('place_edit_city',$permissions))?'checked':'' }}>
	                        <label for="quyen-places-city-edit" class="font-weight-normal">Chỉnh sửa</label>
	                    </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_delete_city'))
	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-city-delete" value="place_delete_city" {{ (isset($permissions) && in_array('place_delete_city',$permissions))?'checked':'' }}>
	                        <label for="quyen-places-city-delete" class="font-weight-normal">Xóa</label>
	                    </div>
                        @endif
					</div>
				</div>


                {{-- district --}}
                {{-- hidden --}}
                @if(Helper::CheckPermissionParent($permissions_parent,'place_man_district'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_man_district">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_add_district'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_add_district">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_edit_district'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_edit_district">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_delete_district'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_delete_district">@endif

                <div class="form-group row">
                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-place-district">Danh mục quận huyện:</label>
                    <div class="col-md-7">
                        @if(Helper::CheckPermissionParent($permissions_parent,'place_man_district'))
                        <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                            <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-place-district-man" value="place_man_district" {{ (isset($permissions) && in_array('place_man_district',$permissions))?'checked':'' }} >
                            <label for="quyen-place-district-man" class="font-weight-normal">Xem</label>
                        </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_add_district'))
                        <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                            <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-district-add" value="place_add_district" {{ (isset($permissions) && in_array('place_add_district',$permissions))?'checked':'' }}>
                            <label for="uyen-places-district-add" class="font-weight-normal">Thêm mới</label>
                        </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_delete_city'))
                        <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                            <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-district-edit" value="place_edit_district" {{ (isset($permissions) && in_array('place_edit_district',$permissions))?'checked':'' }}>
                            <label for="quyen-places-district-edit" class="font-weight-normal">Chỉnh sửa</label>
                        </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_delete_district'))
                        <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
                            <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-district-delete" value="place_delete_district" {{ (isset($permissions) && in_array('place_delete_district',$permissions))?'checked':'' }}>
                            <label for="quyen-places-district-delete" class="font-weight-normal">Xóa</label>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- ward --}}
                {{-- hidden --}}
                @if(Helper::CheckPermissionParent($permissions_parent,'place_man_ward'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_man_ward">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_add_ward'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_add_ward">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_edit_ward'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_edit_ward">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_delete_ward'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_delete_ward">@endif

        		<div class="form-group row">
					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-place-ward">Danh mục phường xã:</label>
					<div class="col-md-7">
                        @if(Helper::CheckPermissionParent($permissions_parent,'place_man_ward'))
						<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-place-ward-man" value="place_man_ward" {{ (isset($permissions) && in_array('place_man_ward',$permissions))?'checked':'' }} >
	                        <label for="quyen-place-ward-man" class="font-weight-normal">Xem</label>
	                    </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_add_ward'))
	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-ward-add" value="place_add_ward" {{ (isset($permissions) && in_array('place_add_ward',$permissions))?'checked':'' }}>
	                        <label for="uyen-places-ward-add" class="font-weight-normal">Thêm mới</label>
	                    </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_edit_ward'))
	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-ward-edit" value="place_edit_ward" {{ (isset($permissions) && in_array('place_edit_ward',$permissions))?'checked':'' }}>
	                        <label for="quyen-places-ward-edit" class="font-weight-normal">Chỉnh sửa</label>
	                    </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_delete_ward'))
	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-ward-delete" value="place_delete_ward" {{ (isset($permissions) && in_array('place_delete_ward',$permissions))?'checked':'' }}>
	                        <label for="quyen-places-ward-delete" class="font-weight-normal">Xóa</label>
	                    </div>
                        @endif
					</div>
				</div>

                {{-- street --}}
                {{-- hidden --}}
                @if(Helper::CheckPermissionParent($permissions_parent,'place_man_street'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_man_street">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_add_street'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_add_street">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_edit_street'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_edit_street">@endif

                @if(Helper::CheckPermissionParent($permissions_parent,'place_delete_street'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="place_delete_street">@endif

        		<div class="form-group row">
					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-place-city">Danh mục đường:</label>
					<div class="col-md-7">
                        @if(Helper::CheckPermissionParent($permissions_parent,'place_man_street'))
						<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-street-man" value="place_man_street" {{ (isset($permissions) && in_array('place_man_street',$permissions))?'checked':'' }} >
	                        <label for="quyen-place-street-man" class="font-weight-normal">Xem</label>
	                    </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_add_street'))
	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-street-add" value="place_add_street" {{ (isset($permissions) && in_array('place_add_street',$permissions))?'checked':'' }}>
	                        <label for="uyen-places-street-add" class="font-weight-normal">Thêm mới</label>
	                    </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_edit_street'))
	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-street-edit" value="place_edit_street" {{ (isset($permissions) && in_array('place_edit_street',$permissions))?'checked':'' }}>
	                        <label for="quyen-places-street-edit" class="font-weight-normal">Chỉnh sửa</label>
	                    </div>
                        @endif

                        @if(Helper::CheckPermissionParent($permissions_parent,'place_delete_street'))
	                    <div class="icheck-primary d-inline dev-check align-middle mb-2 text-md">
	                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-places-street-delete" value="place_delete_street" {{ (isset($permissions) && in_array('place_delete_street',$permissions))?'checked':'' }}>
	                        <label for="quyen-places-street-delete" class="font-weight-normal">Xóa</label>
	                    </div>
                        @endif
					</div>
				</div>
            </div>
        </div>
    @endif



    {{--PHÂN QUYỀN--}}
    @if(config('config_all.permission')==true)
        {{-- hidden THÀNH VIÊN--}}
        @if(Helper::CheckPermissionParent($permissions_parent,'member_man'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="member_man">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'member_edit'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="member_edit">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'member_add'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="member_add">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'member_delete'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="member_delete">@endif

        <div class="card card-permission card-primary card-outline text-sm parent-select">
            <div class="card-header">
                <div class="card-tools-dev">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="selectAll-member" class="selectAllParent">
                        <label for="selectAll-member">Quản lý thành viên admin</label>
                    </div>
                </div>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    @if(Helper::CheckPermissionParent($permissions_parent,'member_man'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-member-view" value="member_man" {{ (isset($permissions) && in_array('member_man',$permissions))?'checked':'' }}>
                        <label for="quyen-member-view" class="font-weight-normal">Xem</label>
                    </div>
                    @endif
                    @if(Helper::CheckPermissionParent($permissions_parent,'member_add'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-member-create" value="member_add" {{ (isset($permissions) && in_array('member_add',$permissions))?'checked':'' }}>
                        <label for="quyen-member-create" class="font-weight-normal">Thêm thành viên</label>
                    </div>
                    @endif
                    @if(Helper::CheckPermissionParent($permissions_parent,'member_edit'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-member-edit" value="member_edit" {{ (isset($permissions) && in_array('member_edit',$permissions))?'checked':'' }}>
                        <label for="quyen-member-edit" class="font-weight-normal">Chỉnh sửa</label>
                    </div>
                    @endif
                    @if(Helper::CheckPermissionParent($permissions_parent,'member_delete'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-member-delete" value="member_delete" {{ (isset($permissions) && in_array('member_delete',$permissions))?'checked':'' }}>
                        <label for="quyen-member-delete" class="font-weight-normal">Xóa</label>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- hidden PHÂN QUYỀN --}}
        @if(Helper::CheckPermissionParent($permissions_parent,'permission_man'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="permission_man">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'permission_edit'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="permission_edit">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'permission_create'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="permission_create">@endif

        @if(Helper::CheckPermissionParent($permissions_parent,'permission_delete'))<input type="hidden" class="custom-control-input" name="dataPermission[]" value="permission_delete">@endif

		<div class="card card-permission card-primary card-outline text-sm parent-select">
            <div class="card-header">
                <div class="card-tools-dev">
                    <div class="icheck-primary d-inline dev-check">
                        <input type="checkbox" id="selectAll-permissin" class="selectAllParent">
                        <label for="selectAll-permissin">Quản lý phân quyền</label>
                    </div>
                </div>
                <div class="card-tools">
                	<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    @if(Helper::CheckPermissionParent($permissions_parent,'permission_man'))
    				<div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-permission-view" value="permission_man" {{ (isset($permissions) && in_array('permission_man',$permissions))?'checked':'' }}>
                        <label for="quyen-permission-view" class="font-weight-normal">Xem</label>
                    </div>
                    @endif

                    @if(Helper::CheckPermissionParent($permissions_parent,'permission_create'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-permission-create" value="permission_create" {{ (isset($permissions) && in_array('permission_create',$permissions))?'checked':'' }}>
                        <label for="quyen-permission-create" class="font-weight-normal">Thêm nhóm quyền</label>
                    </div>
                    @endif

                    @if(Helper::CheckPermissionParent($permissions_parent,'permission_edit'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-permission-edit" value="permission_edit" {{ (isset($permissions) && in_array('permission_edit',$permissions))?'checked':'' }}>
                        <label for="quyen-permission-edit" class="font-weight-normal">Chỉnh sửa</label>
                    </div>
                    @endif

                    @if(Helper::CheckPermissionParent($permissions_parent,'permission_delete'))
                    <div class="icheck-primary d-inline dev-check align-middle mb-2 mr-4 text-md">
                        <input type="checkbox" class="select-checkbox" name="dataQuyen[]" id="quyen-permission-delete" value="permission_delete" {{ (isset($permissions) && in_array('permission_delete',$permissions))?'checked':'' }}>
                        <label for="quyen-permission-delete" class="font-weight-normal">Xóa</label>
                    </div>
                    @endif
                </div>
            </div>
        </div>
	@endif

    <div class="card-footer text-sm">
        <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
    </div>
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
<script type="text/javascript">
    $('body').on('click','#selectAll', function(){
        var parentTable = $(this).parents('form');
        var input = parentTable.find('input.select-checkbox');
        var inputAllParent = parentTable.find('input.selectAllParent');
        if($(this).is(':checked'))
        {
            input.each(function(){
                $(this).prop('checked',true);
            });
            inputAllParent.each(function(){
                $(this).prop('checked',true);
            });
        }
        else
        {
            input.each(function(){
                $(this).prop('checked',false);
            });
            inputAllParent.each(function(){
                $(this).prop('checked',false);
            });
        }
    });

    $('body').on('click','.selectAllParent', function(){
        var parentTable = $(this).parents('.parent-select');
        var input = parentTable.find('input.select-checkbox');
        if($(this).is(':checked'))
        {
            input.each(function(){
                $(this).prop('checked',true);
            });
        }
        else
        {
            input.each(function(){
                $(this).prop('checked',false);
            });
        }
    });

</script>
@endsection

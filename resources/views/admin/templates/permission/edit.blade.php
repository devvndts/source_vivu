@extends('admin.master')

@section('content')
<form method="post" action="{{ route('admin.permission.save') }}" enctype="multipart/form-data">
    @csrf
    <div class="card-footer text-sm sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
    </div>

    @if(config('config_type.product'))
        @foreach(config('config_type.product') as $key => $value)
        <div class="card card-permission card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Quản lý {{$value['title_main']}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                @if(isset($value['list']) && $value['list'] == true)
            		<div class="form-group row">
						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-list-{{$key}}">Danh mục cấp 1:</label>
						<div class="col-md-7">
							<div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-list-view-{{$key}}" value="product_man_list_{{$key}}">
		                        <label for="quyen-product-list-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-list-add-{{$key}}" value="product_add_list_{{$key}}">
		                        <label for="quyen-product-list-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-list-edit-{{$key}}" value="product_edit_list_{{$key}}">
		                        <label for="quyen-product-list-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-list-delete-{{$key}}" value="product_delete_list_{{$key}}">
		                        <label for="quyen-product-list-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
		                    </div>
						</div>
					</div>
				@endif

                @if(isset($value['cat']) && $value['cat'] == true)
            		<div class="form-group row">
						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-cat-{{$key}}">Danh mục cấp 2:</label>
						<div class="col-md-7">
							<div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-cat-view-{{$key}}" value="product_man_cat_{{$key}}">
		                        <label for="quyen-product-cat-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-cat-add-{{$key}}" value="product_add_cat_{{$key}}">
		                        <label for="quyen-product-cat-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-cat-edit-{{$key}}" value="product_edit_cat_{{$key}}">
		                        <label for="quyen-product-cat-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-cat-delete-{{$key}}" value="product_delete_cat_{{$key}}">
		                        <label for="quyen-product-cat-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
		                    </div>
						</div>
					</div>
				@endif

				@if(isset($value['item']) && $value['item'] == true)
            		<div class="form-group row">
						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-item-{{$key}}">Danh mục cấp 3:</label>
						<div class="col-md-7">
							<div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-item-view-{{$key}}" value="product_man_item_{{$key}}">
		                        <label for="quyen-product-item-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-item-add-{{$key}}" value="product_add_item_{{$key}}">
		                        <label for="quyen-product-item-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-item-edit-{{$key}}" value="product_edit_item_{{$key}}">
		                        <label for="quyen-product-item-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-item-delete-{{$key}}" value="product_delete_item_{{$key}}">
		                        <label for="quyen-product-item-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
		                    </div>
						</div>
					</div>
				@endif

				@if(isset($value['sub']) && $value['sub'] == true)
            		<div class="form-group row">
						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-sub-{{$key}}">Danh mục cấp 4:</label>
						<div class="col-md-7">
							<div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-sub-view-{{$key}}" value="product_man_sub_{{$key}}">
		                        <label for="quyen-product-sub-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-sub-add-{{$key}}" value="product_add_sub_{{$key}}">
		                        <label for="quyen-product-sub-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-sub-edit-{{$key}}" value="product_edit_sub_{{$key}}">
		                        <label for="quyen-product-sub-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-sub-delete-{{$key}}" value="product_delete_sub_{{$key}}">
		                        <label for="quyen-product-sub-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
		                    </div>
						</div>
					</div>
				@endif

                @if(isset($value['mau']) && $value['mau'] == true)
            		<div class="form-group row">
						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-mau-{{$key}}">Danh mục màu sắc:</label>
						<div class="col-md-7">
							<div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-mau-view-{{$key}}" value="product_man_mau_{{$key}}">
		                        <label for="quyen-product-mau-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-mau-add-{{$key}}" value="product_add_mau_{{$key}}">
		                        <label for="quyen-product-mau-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-mau-edit-{{$key}}" value="product_edit_mau_{{$key}}">
		                        <label for="quyen-product-mau-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-mau-delete-{{$key}}" value="product_delete_mau_{{$key}}">
		                        <label for="quyen-product-mau-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
		                    </div>
						</div>
					</div>
            	@endif

            	@if(isset($value['size']) && $value['size'] == true)
            		<div class="form-group row">
						<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-size-{{$key}}">Danh mục kích thước:</label>
						<div class="col-md-7">
							<div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-size-view-{{$key}}" value="product_man_size_{{$key}}">
		                        <label for="quyen-product-size-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-size-add-{{$key}}" value="product_add_size_{{$key}}">
		                        <label for="quyen-product-size-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-size-edit-{{$key}}" value="product_edit_size_{{$key}}">
		                        <label for="quyen-product-size-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
		                    </div>
		                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
		                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-size-delete-{{$key}}" value="product_delete_size_{{$key}}">
		                        <label for="quyen-product-size-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
		                    </div>
						</div>
					</div>
            	@endif

				<div class="form-group row">
					<label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-product-{{$key}}">{{$value['title_main']}}:</label>
					<div class="col-md-7">
						<div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
	                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-view-{{$key}}" value="product_man_{{$key}}">
	                        <label for="quyen-product-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
	                    </div>
	                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
	                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-add-{{$key}}" value="product_add_{{$key}}">
	                        <label for="quyen-product-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
	                    </div>
	                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
	                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-edit-{{$key}}" value="product_edit_{{$key}}">
	                        <label for="quyen-product-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
	                    </div>
	                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
	                        <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-product-delete-{{$key}}" value="product_delete_{{$key}}">
	                        <label for="quyen-product-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
	                    </div>
					</div>
				</div>
            </div>
        </div>
        @endforeach
    @endif

    @if(config('config_type.post'))
        @foreach(config('config_type.post') as $key => $value)
            @if(isset($value['dropdown']) && $value['dropdown'] == true)
            <div class="card card-permission card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Quản lý {{$value['title_main']}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($value['list']) && $value['list'] == true)
                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-list-{{$key}}">Danh mục cấp 1:</label>
                            <div class="col-md-7">
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-list-view-{{$key}}" value="post_man_list_{{$key}}">
                                    <label for="quyen-post-list-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-list-add-{{$key}}" value="post_add_list_{{$key}}">
                                    <label for="quyen-post-list-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-list-edit-{{$key}}" value="post_edit_list_{{$key}}" >
                                    <label for="quyen-post-list-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-list-delete-{{$key}}" value="post_delete_list_{{$key}}" >
                                    <label for="quyen-post-list-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($value['cat']) && $value['cat'] == true)
                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-cat-{{$key}}">Danh mục cấp 2:</label>
                            <div class="col-md-7">
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-cat-view-{{$key}}" value="post_man_cat_{{$key}}" >
                                    <label for="quyen-post-cat-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-cat-add-{{$key}}" value="post_add_cat_{{$key}}" >
                                    <label for="quyen-post-cat-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-cat-edit-{{$key}}" value="post_edit_cat_{{$key}}" >
                                    <label for="quyen-post-cat-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-cat-delete-{{$key}}" value="post_delete_cat_{{$key}}" >
                                    <label for="quyen-post-cat-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($value['item']) && $value['item'] == true)
                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-item-{{$key}}">Danh mục cấp 3:</label>
                            <div class="col-md-7">
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-item-view-{{$key}}" value="post_man_item_{{$key}}" >
                                    <label for="quyen-post-item-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-item-add-{{$key}}" value="post_add_item_{{$key}}" >
                                    <label for="quyen-post-item-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-item-edit-{{$key}}" value="post_edit_item_{{$key}}" >
                                    <label for="quyen-post-item-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-item-delete-{{$key}}" value="post_delete_item_{{$key}}" >
                                    <label for="quyen-post-item-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($value['sub']) && $value['sub'] == true)
                        <div class="form-group row">
                            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-sub-{{$key}}">Danh mục cấp 4:</label>
                            <div class="col-md-7">
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-sub-view-{{$key}}" value="post_man_sub_{{$key}}" >
                                    <label for="quyen-post-sub-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-sub-add-{{$key}}" value="post_add_sub_{{$key}}" >
                                    <label for="quyen-post-sub-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-sub-edit-{{$key}}" value="post_edit_sub_{{$key}}" >
                                    <label for="quyen-post-sub-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
                                </div>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                    <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-sub-delete-{{$key}}" value="post_delete_sub_{{$key}}" >
                                    <label for="quyen-post-sub-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3" for="quyen-post-{{$key}}">{{$value['title_main']}}:</label>
                        <div class="col-md-7">
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-view-{{$key}}" value="post_man_{{$key}}" >
                                <label for="quyen-post-view-{{$key}}" class="dev-custom-bg font-weight-normal">Xem danh sách</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-add-{{$key}}" value="post_add_{{$key}}" >
                                <label for="quyen-post-add-{{$key}}" class="dev-custom-bg font-weight-normal">Thêm mới</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 mr-4 text-md">
                                <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-edit-{{$key}}" value="post_edit_{{$key}}" >
                                <label for="quyen-post-edit-{{$key}}" class="dev-custom-bg font-weight-normal">Chỉnh sửa</label>
                            </div>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-2 text-md">
                                <input type="hidden" class="custom-control-input" name="dataQuyen[]" id="quyen-post-delete-{{$key}}" value="post_delete_{{$key}}" >
                                <label for="quyen-post-delete-{{$key}}" class="dev-custom-bg font-weight-normal">Xóa</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endif
        @endforeach
    @endif


    <div class="card-footer text-sm">
        <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
    </div>
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
<script type="text/javascript">

</script>
@endsection

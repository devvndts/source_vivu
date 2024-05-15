@extends('admin.master')

@section('content')
<div id="serialize_output">{{($desiredMenu && $desiredMenu->content!='') ? $desiredMenu->content : '[]'}}</div>
<div class="card-footer sticky-top drag-menu-sticky">
	@if(count($menus)!=0)
		<i class="fas fa-user-edit"></i> Chọn menu để chỉnh sửa
		<select class="dragmenu-select">			
			@foreach($menus as $menu)
		    @if($desiredMenu != '')
					<option value="{{$menu->id}}/{{$lang_menu}}" {{($menu->id == $desiredMenu->id) ? 'selected' : ''}}>{{$menu->title}}</option>
			  @else
					<option value="{{$menu->id}}/{{$lang_menu}}">{{$menu->title}}</option>
			  @endif
			@endforeach
	  	</select>

		<select class="dragmenu-select">
			@foreach(config('config_all.lang') as $k => $v)
				<option value="{{$menu->id}}/{{$k}}" {{ ($k==$lang_menu)? 'selected' : '' }}>{{$v}}</option>
			@endforeach
		</select>

		<span class="mx-3">Hoặc</span>
		<a class="text-white btn btn-sm bg-gradient-primary" href="{{ route('admin.menu.index',['new']) }}" title="Tạo mới menu"><i class="mr-2 fas fa-plus"></i>Tạo mới menu</a>
	@endif
</div>


<div class="row">
	<div class="col-xl-12">
		@if(config('config_all.menus')==true)
			<div class="pt-3 text-sm card card-primary card-outline">
				<div class="pb-0 card-body">
					<div class="form-group">
						<div class="mr-3 custom-control custom-radio d-inline-block text-md">
							<input class="custom-control-input mailertype" type="radio" id="menu-select" name="menu_selected" value="{{($request->id) ? $request->id : (($menus->count()>0) ? $menus[0]->id : '')}}" {{(isset($setting['menu']) && $setting['menu']==$request->id) ? 'checked' : ''}}>
							<label for="menu-select" class="custom-control-label font-weight-normal">Thể hiện ngoài website</label>
						</div>
						<input type="hidden" name="id_setting" value="{{$setting['id']}}">
					</div>
				</div>
			</div>
		@endif
	</div>
</div>


<div class="row" id="main-row">
	<div class="col-sm-3 cat-form {{(count($menus) == 0 || $is_new) ? 'disabled' : ''}}">
		<h3 class="drag-menu-title"><span>Thêm danh mục</span></h3>
		<div class="panel-group" id="menu-items">

			<!--Pages chính-->
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="#page-list" data-toggle="collapse" data-parent="#menu-items">Trang chính <i class="drag-menu-right fal fa-chevron-right"></i></a>
				</div>
				<div class="panel-collapse collapse in" id="page-list">
					<div class="panel-body">
						<div class="item-list-body">
							@foreach($pages as $p => $page)
								@if(!in_array($p,$ids_menuitems))
								<p class="icheck-primary d-block dev-check">
									<input id="checkPage-{{$p}}" type="checkbox" name="select-page[]" value="{{$p}}">
									<label for="checkPage-{{$p}}">{{$page['title'.$lang_menu]}}</label>
								</p>
								@endif
							@endforeach
						</div>
						<div class="item-list-footer">
							<label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-pages"> Chọn tất cả</label>
							<button type="button" class="pull-right btn btn-default btn-sm" id="add-pages">Thêm vào menu</button>
						</div>
					</div>
				</div>				
			</div>

			<!--Danh mục chính-->
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="#categories-list" data-toggle="collapse" data-parent="#menu-items">Danh mục chính <i class="drag-menu-right fal fa-chevron-right"></i></a>
				</div>
				<div class="panel-collapse collapse in" id="categories-list">
					<div class="panel-body">
						<div class="item-list-body">
							@foreach($categories as $c => $cat_list)
								<p class="dragmenu-item-title">{{$c}}</p>
								@foreach($cat_list as $cat)
									@if(!in_array($cat['id'],$ids_menuitems))
									<p class="icheck-primary d-block dev-check">
										<input id="checkDrag-{{$cat['id']}}" type="checkbox" name="select-category[]" value="{{$cat['id']}}">
										<label for="checkDrag-{{$cat['id']}}">{{$cat['ten'.$lang_menu]}}</label>
									</p>
									@endif
								@endforeach
							@endforeach
						</div>
						<div class="item-list-footer">
							<label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-categories"> Chọn tất cả</label>
							<button type="button" class="pull-right btn btn-default btn-sm" id="add-categories">Thêm vào menu</button>
						</div>
					</div>
				</div>				
			</div>

			<!--bài viết-->
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="#posts-list" data-toggle="collapse" data-parent="#menu-items">Bài viết <i class="drag-menu-right fal fa-chevron-right"></i></a>
				</div>
				<div class="panel-collapse collapse" id="posts-list">
					<div class="panel-body">
						<div class="item-list-body">
							@if($posts)
								@foreach($posts as $p => $post_list)
									<p class="dragmenu-item-title">{{$p}}</p>
									@foreach($post_list as $post)
										@if(!in_array($post['id'],$ids_menuitems))
										<p class="icheck-primary d-block dev-check">
											<input id="checkDragPost-{{$post['id']}}" type="checkbox" name="select-post[]" value="{{$post['id']}}">
											<label for="checkDragPost-{{$post['id']}}">{{$post['ten'.$lang_menu]}}</label>
										</p>
										@endif
									@endforeach
								@endforeach
							@endif
						</div>
						<div class="item-list-footer">
							<label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-posts"> Chọn tất cả</label>
							<button type="button" id="add-posts" class="pull-right btn btn-default btn-sm">Thêm vào menu</button>
						</div>
					</div>
				</div>
			</div>

			<!--sản phẩm-->
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="#product-list" data-toggle="collapse" data-parent="#menu-items">Sản phẩm <i class="drag-menu-right fal fa-chevron-right"></i></a>
				</div>
				<div class="panel-collapse collapse" id="product-list">
					<div class="panel-body">
						<div class="item-list-body">
							@if($products)
								@foreach($products as $p => $product_list)
									<p class="dragmenu-item-title">{{$p}}</p>
									@foreach($product_list as $product)
										@if(!in_array($product['id'],$ids_menuitems))
										<p class="icheck-primary d-block dev-check">
											<input id="checkDragProduct-{{$product['id']}}" type="checkbox" name="select-product[]" value="{{$product['id']}}">
											<label for="checkDragProduct-{{$product['id']}}">{{$product['ten'.$lang_menu]}}</label>
										</p>
										@endif
									@endforeach
								@endforeach
							@endif
						</div>
						<div class="item-list-footer">
							<label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-products"> Chọn tất cả</label>
							<button type="button" id="add-products" class="pull-right btn btn-default btn-sm">Thêm vào menu</button>
						</div>
					</div>
				</div>
			</div>

			<!--Thư viện ảnh-->
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="#album-list" data-toggle="collapse" data-parent="#menu-items">Thư viện ảnh <i class="drag-menu-right fal fa-chevron-right"></i></a>
				</div>
				<div class="panel-collapse collapse" id="album-list">
					<div class="panel-body">
						<div class="item-list-body">
							@if($albums)
								@foreach($albums as $a => $album_list)
									<p class="dragmenu-item-title">{{$a}}</p>
									@foreach($album_list as $album)
										@if(!in_array($album['id'],$ids_menuitems))
										<p class="icheck-primary d-block dev-check">
											<input id="checkDragAlbum-{{$album['id']}}" type="checkbox" name="select-album[]" value="{{$album['id']}}">
											<label for="checkDragAlbum-{{$album['id']}}">{{$album['ten'.$lang_menu]}}</label>
										</p>
										@endif
									@endforeach
								@endforeach
							@endif
						</div>
						<div class="item-list-footer">
							<label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-albums"> Chọn tất cả</label>
							<button type="button" id="add-albums" class="pull-right btn btn-default btn-sm">Thêm vào menu</button>
						</div>
					</div>
				</div>
			</div>

			<!--Links tùy chỉnh -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<a href="#custom-links" data-toggle="collapse" data-parent="#menu-items">Links tùy chỉnh <i class="drag-menu-right fal fa-chevron-right"></i></a>
				</div>
				<div class="panel-collapse collapse" id="custom-links">
					<div class="panel-body">
						<div class="item-list-body">
							<div class="form-group">
								<label>URL</label>
								<input type="url" id="url" class="form-control" placeholder="https://">
							</div>
							<div class="form-group">
								<label>Link Text</label>
								<input type="text" id="linktext" class="form-control" placeholder="">
							</div>
						</div>
						<div class="item-list-footer">
							<button type="button" class="pull-right btn btn-default btn-sm" id="add-custom-link">Thêm vào Menu</button>
						</div>
					</div>
				</div>
			</div>

			@if($desiredMenu != '')
			<div class="form-group menulocation">
			  <label><b>Vị trí đặt menu</b></label>
			  @foreach($menu_location as $k=>$v)
			  	<label><input type="radio" name="location" value="{{$k}}" @if($desiredMenu->location == $k) checked @endif> {{$v['title']}}</label>
			  @endforeach				  
			</div>
		  @endif	

		</div>
	</div>
	<div class="ml-5 col-sm-6 cat-view">
		<h3 class="drag-menu-title"><span>Cấu trúc menu</span></h3>
		@if(count($menus)== 0 || $is_new)	  	
			<form method="post" action="{{route('admin.menu.create')}}">
				@csrf
				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-10">
										<div class="form-group">
											<label for="title" class="inp">
											<input type="text" class="form-control for-seo" name="title" id="title" placeholder="&nbsp;" value="">
											<span class="label">Tên Menu</span>
											<span class="focus-bg"></span>
											</label>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">	
											<button class="text-white btn btn-sm bg-gradient-danger btn-menu-create">Tạo menu</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						@if(count($menus)==0)		
						<div class="menu-alert-danger"><i class="fas fa-exclamation-circle"></i> Chưa có menu trong danh sách hiện tại. Cần tạo ít nhất 1 menu để thao tác</div>
						@endif				  
					</div>
				</div>
			</form>
		@else
			<div id="menu-content">
			  <div>
					<p><b>Chọn danh mục bên trái để thêm vào menu</b></p>
					@if($desiredMenu != '')
						<!--menuitem show-->
						{!! $menuitems !!}
					@endif	
		    </div>

		    @if($desiredMenu != '')
		    <p>
					<a class="text-white btn btn-sm bg-gradient-danger" href="{{route('admin.menu.destroy',[$desiredMenu->id])}}">Xóa Menu</a>
					<button class="btn btn-sm btn-primary" id="saveMenu">Lưu Menu</button>
				</p>	
				@endif

			</div>
		@endif			 					
	</div>
</div>
@endsection

@push('css')
	{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
	<style>
	.item-list-body::-webkit-scrollbar {
	  display: none;
	}

	/* Hide scrollbar for IE, Edge and Firefox */
	.item-list-body {
	  -ms-overflow-style: none;  /* IE and Edge */
	  scrollbar-width: none;  /* Firefox */
	}

	.drag-menu-sticky{background-color: #fafafa !important; padding: 10px 20px !important; margin-bottom: 50px !important;}
	.drag-menu-right{float: right;margin-top: 5px;}
	.pull-right{color: rgba(38, 185, 154, 1);}

	.btn-menu-create{height: 50px;font-size: 16px; font-weight: bold;width: 100%;}
	.item-list,.info-box{background: #fff;padding: 10px;}
	.item-list-body{max-height: 300px;overflow-y: scroll;}
	.panel-body p{margin-bottom: 15px !important;}
	.info-box{margin-bottom: 15px;}
	.item-list-footer{padding-top: 10px;border-top: 1px solid #ebebeb;text-align: center;}
	.panel-heading a{display: block;color: rgba(38, 185, 154, 1); font-weight: bold;}
	.form-inline{display: inline;}
	.form-inline select{padding: 4px 10px;}
	.btn-menu-select{padding: 4px 10px}
	.disabled{pointer-events: none; opacity: 0.7;}

	.drag-menu-title{border-bottom: 2px solid rgba(38, 185, 154, 1); margin-bottom: 20px; }
	.drag-menu-title span{display: inline-block; background: rgba(38, 185, 154, 1); padding: 8px 15px; color: #fff; font-size: 18px;border-radius: 8px 8px 0 0;}

	.panel-default{border-radius: 5px;margin-bottom: 10px; border: 2px dashed #ccc;}
	.panel-heading{padding: 10px;}
	.panel-collapse{padding: 10px;border-top: 1px solid #ebebeb;}

	.item-list-footer label{margin: 0;}
	.item-list-footer .btn-default{margin: 0 3px;}

	.dragmenu-select{height: 34px;min-width: 200px; border: 1px solid #ebebeb;outline: none;}


	.menu-item-bar{background: #fafafa; padding: 8px 15px; border: 2px dashed #ebebeb; margin-bottom: 0px; width: 50%; cursor: move; display: block;}
	  #serialize_output{display: none;}
	  .menulocation label{font-weight: normal;display: block;}
	  body.dragging, body.dragging * {cursor: move !important;}
	  .dragged {position: absolute;z-index: 1;}
	  ol.example li.placeholder {position: relative;}
	  ol.example li.placeholder:before {position: absolute;}
	  #menuitem{list-style: none;}
	  #menuitem ul{list-style: none;}
	  .input-box{width:75%;background:#fafafa;padding: 10px;box-sizing: border-box;margin-bottom: 5px;border: 2px dashed #ebebeb; margin-top: -2px;}
	  .input-box .form-control{width: 100%}
	  .menulocation label{font-weight: normal;display: block;}

	  #menu-content ul{list-style-type: none;padding: 0;}
	  #menu-content li{margin-top: 5px;}
	  #menu-content li.placeholder{position: relative;}
	  #menu-content li.placeholder:before;{position: absolute;}
	  #menu-content li.dragged{position: absolute; opacity: 0.5; z-index: 2000; }

	  .menu-highlight{border: 1px dashed rgba(38, 185, 154, 0.3); font-weight: bold; font-size: 45px; background-color: rgba(38, 185, 154, 0.2);height: 41px;}
	  .dragmenu-item-title{background: #fafafa; padding: 10px 10px; margin-bottom: 0 !important; font-weight: bold; border: 1px dashed #ccc; border-radius: 5px; color: #999; text-transform: uppercase;}
	  .menulocation{background: #fafafa; padding: 15px 20px; margin-top: 15px; border: 2px dashed #ebebeb;}
	</style>
@endpush

@push('js')
	{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}

	<script>
		$('#select-all-categories').click(function(event) { 
			if(this.checked) {						
			 $('#categories-list :checkbox').each(function() {
				 this.checked = true;                        
			 });
			}else{
			 $('#categories-list :checkbox').each(function() {
				 this.checked = false;                        
			 });
			}
		});


		$('#select-all-posts').click(function(event) {   
			if(this.checked) {
			 $('#posts-list :checkbox').each(function() {
			this.checked = true;                        
			 });
			}else{
			 $('#posts-list :checkbox').each(function() {
			this.checked = false;                        
			 });
			}
		});


		$('#select-all-products').click(function(event) {   
			if(this.checked) {
			 $('#product-list :checkbox').each(function() {
			this.checked = true;                        
			 });
			}else{
			 $('#product-list :checkbox').each(function() {
			this.checked = false;                        
			 });
			}
		});

		$('#select-all-albums').click(function(event) {   
			if(this.checked) {
			 $('#album-list :checkbox').each(function() {
			this.checked = true;                        
			 });
			}else{
			 $('#album-list :checkbox').each(function() {
			this.checked = false;                        
			 });
			}
		});

		$('#select-all-pages').click(function(event) {   
			if(this.checked) {
			 $('#page-list :checkbox').each(function() {
			this.checked = true;                        
			 });
			}else{
			 $('#page-list :checkbox').each(function() {
			this.checked = false;                        
			 });
			}
		});


		$('.dragmenu-select').change(function(){
			var id = $(this).val();
			var url = "{{ route('admin.menu.index') }}/"+id;
			window.location = url;
		});
	</script>


	@if($desiredMenu)
		<script>
			$('#add-categories').click(function(){
			  var menuid = {{$desiredMenu->id}};
			  var n = $('input[name="select-category[]"]:checked').length;
			  var array = $('input[name="select-category[]"]:checked');
			  var ids = [];

			  for(i=0;i<n;i++){
			    ids[i] =  array.eq(i).val();
			  }

			  if(ids.length == 0){
					return false;
			  }

			  $.ajax({
					type:"POST",
					data: {menuid:menuid,ids:ids},
					url: "{{route('admin.menu.addCate')}}",
					success:function(res){
				      location.reload();
					}
			  })
			})

			$('#add-posts').click(function(){
			  var menuid = {{$desiredMenu->id}};
			  var n = $('input[name="select-post[]"]:checked').length;
			  var array = $('input[name="select-post[]"]:checked');
			  var ids = [];

			  for(i=0;i<n;i++){
					ids[i] =  array.eq(i).val();
			  }

			  if(ids.length == 0){
					return false;
			  }

			  $.ajax({
					type:"GET",
					data: {menuid:menuid,ids:ids},
					url: "{{route('admin.menu.addPost')}}",				
					success:function(res){
				  	  location.reload();
					}
			  })
			})


			$('#add-products').click(function(){
			  var menuid = {{$desiredMenu->id}};
			  var n = $('input[name="select-product[]"]:checked').length;
			  var array = $('input[name="select-product[]"]:checked');
			  var ids = [];

			  for(i=0;i<n;i++){
					ids[i] =  array.eq(i).val();
			  }

			  if(ids.length == 0){
					return false;
			  }

			  $.ajax({
					type:"GET",
					data: {menuid:menuid,ids:ids},
					url: "{{route('admin.menu.addProduct')}}",				
					success:function(res){
				  	  location.reload();
					}
			  })
			})


			$('#add-albums').click(function(){

			  var menuid = {{$desiredMenu->id}};
			  var n = $('input[name="select-album[]"]:checked').length;
			  var array = $('input[name="select-album[]"]:checked');
			  var ids = [];

			  for(i=0;i<n;i++){
					ids[i] =  array.eq(i).val();
			  }

			  if(ids.length == 0){
					return false;
			  }


			  $.ajax({
					type:"GET",
					data: {menuid:menuid,ids:ids},
					url: "{{route('admin.menu.addAlbum')}}",				
					success:function(res){
				  	  location.reload();
					}
			  })
			})	


			$('#add-pages').click(function(){

			  var menuid = {{$desiredMenu->id}};
			  var n = $('input[name="select-page[]"]:checked').length;
			  var array = $('input[name="select-page[]"]:checked');
			  var ids = [];

			  for(i=0;i<n;i++){
					ids[i] =  array.eq(i).val();
			  }

			  if(ids.length == 0){
					return false;
			  }


			  $.ajax({
					type:"GET",
					data: {menuid:menuid,ids:ids},
					url: "{{route('admin.menu.addPage')}}",				
					success:function(res){
				  	  location.reload();
					}
			  })
			})		


			$("#add-custom-link").click(function(){
			  var menuid = {{$desiredMenu->id}};
			  var url = $('#url').val();
			  var link = $('#linktext').val();

			  if(url.length > 0 && link.length > 0){
					$.ajax({
					  type:"GET",
					  data: {menuid:menuid,url:url,link:link},
					  url: "{{route('admin.menu.addLink')}}",				
					  success:function(res){
					    location.reload();
					  }
					})
			  }
			})
		</script>

		<script>
			$('#saveMenu').click(function(){
			  var menuid = {{$desiredMenu->id}};
			  var location = $('input[name="location"]:checked').val();			  
			  var menu_selected = $('input[name="menu_selected"]:checked').val();
			  var id_setting = $('input[name="id_setting"]').val();
			  var newText = $("#serialize_output").text();
			  var data = JSON.parse(newText);	

			  $.ajax({
			    type:"POST",
					data: {menuid:menuid,data:data,location:location,menu_selected:menu_selected,id_setting:id_setting},
					url: "{{route('admin.menu.updateMenu')}}",
					success:function(res){
					  window.location.reload();
					}
			  })	
			})
		</script>


		<script>
			$('#menuitems').on('click','.deleteMenuItem',function(e) {
			    e.stopPropagation();

			    var e_parent = $(this).closest('.parent_li').remove();
			    var data = $('#menuitems').sortable("serialize").get();
			    var jsonString = JSON.stringify(data, null, ' ');
			    var id = e_parent.attr('data-id');
			    $('#saveMenu').attr('disabled');

			    var menuid = {{$desiredMenu->id}};
				  var data = JSON.parse(jsonString);
				  $.ajax({
				    type:"POST",
						data: {id:id, menuid:menuid, data:data},
						url: "{{route('admin.menu.deleteMenuItem')}}",
						success:function(res){
							window.location.reload();
						}
				  })
			});
		</script>
	@endif

	<script src="{{ asset('js/jquery-sortable.js') }}"></script>
	<script>
		var group = $("#menuitems").sortable({
		  group: 'serialization',	
		  placeholderClass: 'placeholder',
		  placeholder: '<li class="menu-highlight"></li>',
		  onDrop: function ($item, container, _super) {
		    var data = group.sortable("serialize").get();		    
		    var jsonString = JSON.stringify(data, null, ' ');
		    $('#serialize_output').text(jsonString);
		  	  _super($item, container);
		  }
		});
	</script>	

@endpush

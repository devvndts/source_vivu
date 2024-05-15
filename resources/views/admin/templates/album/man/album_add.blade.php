@extends('admin.master')

@section('content')
<form class="validation-form autosave-form" novalidate method="post" action="{{route('admin.album.save',['man',$type])}}" enctype="multipart/form-data">
	@csrf
    <div class="text-sm card-footer sticky-top">
        <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="mr-2 far fa-save"></i>Lưu</button>
        <div class="pl-0 ml-1 btn dropdown">
          <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Thao tác
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check btn-none-css" name="savehere"><i class="mr-2 far fa-save"></i>Lưu tại trang</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary btn-none-css"><i class="mr-2 fas fa-redo"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger btn-none-css" href="{{route('admin.album.show',['man',$type])}}" title="Thoát"><i class="mr-2 fas fa-sign-out-alt"></i>Thoát</a>
          </div>
        </div>          
    </div>
    <div class="row">
        <div class="col-xl-8">
        	@if(isset($config[$type]['slug']) && $config[$type]['slug'] == true)
               @include('admin.layouts.slug')
            @endif
            <div class="text-sm card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Nội dung {{ $config[$type]['title_main'] }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="hienthi" class="mb-0 mr-2 align-middle d-inline-block">Hiển thị:</label>
                        <div class="align-middle custom-control custom-checkbox d-inline-block">
                            @if($rowItem['hienthi']==1 || !isset($rowItem))
                            <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" checked>
                            @else
                            <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox">
                            @endif
                            <label for="hienthi-checkbox" class="custom-control-label"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stt" class="mb-0 mr-2 align-middle d-inline-block">Số thứ tự:</label>
                        <input type="number" class="align-middle form-control form-control-mini d-inline-block" min="0" name="data[stt]" id="stt" placeholder="Số thứ tự" value="{{ (isset($rowItem['stt']))?$rowItem['stt']:'1' }}">
                    </div>

                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="p-0 card-header border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                @foreach(config('config_all.lang') as $k => $v)
                                    <li class="nav-item">
                                        <a class="nav-link {{($k=='vi')?'active':''}}" id="tabs-lang" data-toggle="pill" href="#tabs-lang-{{$k}}" role="tab" aria-controls="tabs-lang-{{$k}}" aria-selected="true">{{$v}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body card-article">
                            <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                @foreach(config('config_all.lang') as $k => $v)
                                    <div class="tab-pane fade show {{($k=='vi')?'active':''}}" id="tabs-lang-{{$k}}" role="tabpanel" aria-labelledby="tabs-lang">
                                        <div class="form-group">
                                            <label for="ten{{$k}}" class="inp">
                                                <input type="text" class="form-control for-seo" name="data[ten{{$k}}]" id="ten{{$k}}" placeholder="&nbsp;" value="{{ (isset($rowItem['ten'.$k]))?$rowItem['ten'.$k]:'' }}" required>
                                                <span class="label">Tiêu đề ({{$k}}):</span>
                                                <span class="focus-bg"></span>
                                            </label>
                                        </div>

                                        @if(isset($config[$type]['mota']) && $config[$type]['mota'] == true)
                                        <div class="form-group">
                                            <label for="mota{{$k}}" class="inp">
                                                <textarea class="form-control for-seo {{(isset($config[$type]['mota_cke']) && $config[$type]['mota_cke'] == true)?'form-control-ckeditor':''}}" name="data[mota{{$k}}]" id="mota{{$k}}" rows="5" placeholder="&nbsp;">{{ (isset($rowItem['mota'.$k]))?$rowItem['mota'.$k]:'' }}</textarea>
                                                <span class="label">Mô tả ({{$k}}):</span>
                                                <span class="focus-bg"></span>
                                            </label>
                                        </div>
                                        @endif

                                        @if(isset($config[$type]['noidung']) && $config[$type]['noidung'] == true)
                                        <div class="form-group">
                                            <label for="noidung<?=$k?>">Nội dung ({{$k}}):</label>
                                            <textarea class="form-control for-seo form-control-ckeditor" name="data[noidung{{$k}}]" id="noidung{{$k}}" rows="5" placeholder="Nội dung ({{$k}})">{{ (isset($rowItem['noidung'.$k]))?$rowItem['noidung'.$k]:'' }}</textarea>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="text-sm card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Danh mục sản phẩm</h3>
                </div>
                <div class="card-body">
                    <div class="form-group-category row">
                        <div class="mb-3 form-group col-sm-12">
                            @include('admin.layouts.category')
                        </div>
                        {{--
                        <div class="form-group col-sm-6">
                            <label class="d-block" for="id_list">Danh mục cấp 1:</label>
                            {!! Helper::get_ajax_category("album", "album", "list", $type, $rowItem) !!}
                        </div>--}}
                    </div>
                </div>
            </div>

            @if(isset($config[$type]['images']) && $config[$type]['images'] == true)
            <div class="text-sm card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Hình đại diện</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    @if(config('config_all.fileupload')==true)
                        @php
                            $amount_images = $config[$type]['amount_images'];
                            for($i=0;$i<$amount_images;$i++){
                                TableManipulation::AddFieldToTable('album','photo'.(($i>0) ? $i : ''), 'string');
                                TableManipulation::AddFieldToTable('album','idphoto'.(($i>0) ? $i : ''));
                            }
                        @endphp
                        @include('admin.layouts.devimage') 

                        @if($request->category=='man')
                            <div class="mt-2"><strong>{{ "Width: ".$config[$type]['width']*$config[$type]['ratio']." px - Height: ".$config[$type]['height']*$config[$type]['ratio']." px (".$config[$type]['img_type'].")" }}</strong></div>
                        @else
                            <div class="mt-2"><strong>{{ "Width: ".$config[$type]['width_'.$request->category]." px - Height: ".$config[$type]['height_'.$request->category]." px (".$config[$type]['img_type'].")" }}</strong></div>
                        @endif
                        <input type="hidden" name="width" value="{{$config[$type]['width']}}" />
                        <input type="hidden" name="height" value="{{$config[$type]['height']}}" />    
                    @else
                        @php
                            $rowPhoto = $rowItem['photo'] ?? '';
                            $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                            $photoWidth = $config[$type]['width'] ?? null;
                            $photoHeight = $config[$type]['height'] ?? null;
                            $photoRatio = $config[$type]['ratio'] ?? null;

                            if( $request->category != 'man' ) {
                                $photoWidth = $config[$type]['width_'.$request->category] ?? null;
                                $photoHeight = $config[$type]['height_'.$request->category] ?? null;
                            }
                        @endphp
                        <x-backend_shared.photo_upload :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight :photoRatio=$photoRatio />
                    @endif
                </div>
            </div>
            @endif

            @if(isset($config[$type]['seo']) && $config[$type]['seo'] == true)
            <div class="text-sm card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Nội dung SEO</h3>
                    <a class="float-right text-white btn btn-sm bg-gradient-success d-inline-block create-seo" title="Tạo SEO">Tạo SEO</a>
                </div>
                <div class="card-body">
                    @include('admin.layouts.seo')
                </div>
            </div>
            @endif
            
        </div>
    </div>

    @if(isset($config[$type]['gallery']))
        <div class="text-sm card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Bộ sưu tập {{ $config[$type]['title_main'] }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                @if(config('config_all.fileupload')==true)
                    @include('admin.layouts.gallery_multy')
                @else
                    <div class="form-group" id="photo-upload-group">
                        <label for="filer-gallery" class="mb-3 label-filer-gallery">Album hình: ({{ $config[$type]['gallery'][$type]['img_type_photo'] }})</label>
                        <input type="file" name="files[]" id="filer-gallery" multiple="multiple">
                        <input type="hidden" class="col-filer" value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
                        <input type="hidden" class="act-filer" name="level" value="man">
                        <input type="hidden" class="folder-filer" name="model" value="album">
                        <input type="hidden" class="folder-filer" name="type" value="{{ $type }}">
                        <input type="hidden" name="hash" value="{{ Helper::generateHash() }}" />
                    </div>
                    @if(isset($gallery) && count($gallery) > 0)
                        <div class="form-group form-group-gallery form-group-gallery-main">
                            {{--<label class="label-filer">Album hiện tại:</label>--}}
                            <div class="mb-3 action-filer d-none">
                                <a class="mr-1 text-white btn btn-sm bg-gradient-primary check-all-filer"><i class="mr-2 far fa-square"></i>Chọn tất cả</a>
                                <button type="button" class="mr-1 text-white btn btn-sm bg-gradient-success sort-filer"><i class="mr-2 fas fa-random"></i>Sắp xếp</button>
                                <a class="text-white btn btn-sm bg-gradient-danger delete-all-filer"><i class="mr-2 far fa-trash-alt"></i>{{ __('Xóa tất cả') }}</a>
                            </div>
                            <div class="text-sm text-white alert my-alert alert-sort-filer alert-info bg-gradient-info"><i class="mr-2 fas fa-info-circle"></i>Có thể chọn nhiều hình để di chuyển</div>
                            <div class="jFiler-items my-jFiler-items jFiler-row">
                                <ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable">
                                    @foreach($gallery as $v)
                                        {{ Helper::galleryFiler($v['stt'],$v['id'],$v['photo'],$v['tenvi'],'album','col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6') }}
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endif

    <input type="hidden" name="id" value="{{ (isset($rowItem['id']))?$rowItem['id']:'' }}">
    <input type="hidden" name="model" class="autosave-btn" value="album">
    <input type="hidden" name="type" value="{{ $type }}">
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
    <script>
        AutoSave();
    </script>
@endsection

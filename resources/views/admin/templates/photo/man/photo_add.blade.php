@extends('admin.master')
@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];

$urlSave = route('admin.photo.save', ['man_photo', $type]);
$urlMan = route('admin.photo.show', ['man_photo', $type]);
$urlOption = '';
$isShowOption = false;
@endphp
@section('content')
<form method="post" action="{{ $urlSave }}" enctype="multipart/form-data">
	@csrf
    <x-backend_shared.action_buttons
        :urlMan=$urlMan
        :urlOption=$urlOption
        :isShowOption=$isShowOption
    />
    <div class="row">
    @for($i=0;$i<$numberPhoto;$i++)
        <div class="col-xl-12">
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header isShowMinus>
                    {{ sprintf('%s: %d', __($config[$type]['title_main']), $i + 1) }}
                </x-backend_shared.card_header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3">
                        @if(isset($config[$type]['images']) && $config[$type]['images'])
                            <div class="form-group">                                
                                <label class="change-photo" for="file{{$i}}">
                                    <p>Upload hình ảnh:</p>
                                    <div class="rounded">
                                        <img class="rounded img-upload" src="" onerror=src="{{asset('img/noimage.png')}}" alt="Alt Photo"/>
                                        <strong>
                                            <b class="text-sm text-split"></b>
                                            <span class="btn btn-sm bg-gradient-success"><i class="mr-2 fas fa-camera"></i>Chọn hình</span>
                                        </strong>
                                    </div>
                                </label>

                                <div class="mt-2 form-group">
                                    <label for="hienthi<?=$i?>" class="mb-0 mr-2 align-middle d-inline-block">Hiển thị:</label>
                                    <div class="align-middle custom-control custom-checkbox d-inline-block">
                                        <input type="checkbox" class="custom-control-input hienthi-checkbox" name="dataMulti[{{$i}}][hienthi1]" id="hienthi-checkbox{{$i}}" checked>
                                        <label for="hienthi-checkbox<?=$i?>" class="custom-control-label"></label>
                                    </div>
                                </div>

                                <strong class="mt-2 mb-2 text-sm d-block">{{ "Width: ".$config[$type]['width'] * $config[$type]['ratio'] ." px - Height: ".$config[$type]['height'] * $config[$type]['ratio'] ." px (".$config[$type]['img_type'].")" }}</strong>

                                <div class="custom-file my-custom-file d-none">
                                    <input type="file" class="custom-file-input" name="file{{$i}}" id="file{{$i}}">
                                    <label class="custom-file-label" for="file{{$i}}">Chọn file</label>
                                </div>                                
                            </div>
                        @endif
                        </div>

                        @if(isset($config[$type]['background']) && $config[$type]['background']==true)
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label class="change-photo" for="background{{$i}}">
                                    <p>{{ (@$config[$type]['background_title']) ? $config[$type]['background_title'] : 'Upload hình nền' }}:</p>
                                    <div class="rounded">
                                        <img class="rounded img-upload" src="" onerror=src="{{asset('img/noimage.png')}}" alt="Alt Photo"/>
                                        <strong>
                                            <b class="text-sm text-split"></b>
                                            <span class="btn btn-sm bg-gradient-success"><i class="mr-2 fas fa-camera"></i>Chọn hình</span>
                                        </strong>
                                    </div>
                                </label>

                                <strong class="mt-2 mb-2 text-sm d-block">{{ "Width: ".$config[$type]['width_bg']." px - Height: ".$config[$type]['height_bg']." px (".$config[$type]['img_type'].")" }}</strong>

                                <div class="custom-file my-custom-file d-none">
                                    <input type="file" class="custom-file-input" name="background{{$i}}" id="background{{$i}}">
                                    <label class="custom-file-label" for="background{{$i}}">Chọn file</label>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(isset($config[$type]['another_image']) && $config[$type]['another_image']==true)
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="change-photo" for="file_model{{$i}}">
                                    <p>Ảnh sản phẩm:</p>
                                    <div class="rounded">
                                        <img class="rounded img-upload" src="" onerror=src="{{asset('img/noimage.png')}}" alt="Alt Photo"/>
                                        <strong>
                                            <b class="text-sm text-split"></b>
                                            <span class="btn btn-sm bg-gradient-success"><i class="mr-2 fas fa-camera"></i>Chọn hình</span>
                                        </strong>
                                    </div>
                                </label>

                                <div class="mt-2 form-group">
                                    <label for="hienthi<?=$i?>" class="mb-0 mr-2 align-middle d-inline-block">Hiển thị:</label>
                                    <div class="align-middle custom-control custom-checkbox d-inline-block">
                                        <input type="checkbox" class="custom-control-input hienthi-checkbox" name="dataMulti[{{$i}}][hienthi2]" id="hienthi-checkbox{{$i}}" checked>
                                        <label for="hienthi-checkbox<?=$i?>" class="custom-control-label"></label>
                                    </div>
                                </div>

                                <strong class="mt-2 mb-2 text-sm d-block">{{ "Width: ".$config[$type]['width']." px - Height: ".$config[$type]['height']." px (".$config[$type]['img_type'].")" }}</strong>                                

                                <div class="custom-file my-custom-file d-none">
                                    <input type="file" class="custom-file-input" name="file_model{{$i}}" id="file_model{{$i}}">
                                    <label class="custom-file-label" for="file{{$i}}">Chọn file</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">                           
                            <div class="form-group">
                                <label class="change-photo" for="file_banner{{$i}}">
                                    <p>Ảnh Khuyến mãi:</p>
                                    <div class="rounded">
                                        <img class="rounded img-upload" src="" onerror=src="{{asset('img/noimage.png')}}" alt="Alt Photo"/>
                                        <strong>
                                            <b class="text-sm text-split"></b>
                                            <span class="btn btn-sm bg-gradient-success"><i class="mr-2 fas fa-camera"></i>Chọn hình</span>
                                        </strong>
                                    </div>
                                </label>

                                <div class="mt-2 form-group">
                                    <label for="hienthi<?=$i?>" class="mb-0 mr-2 align-middle d-inline-block">Hiển thị:</label>
                                    <div class="align-middle custom-control custom-checkbox d-inline-block">
                                        <input type="checkbox" class="custom-control-input hienthi-checkbox" name="dataMulti[{{$i}}][hienthi3]" id="hienthi-checkbox{{$i}}" checked>
                                        <label for="hienthi-checkbox<?=$i?>" class="custom-control-label"></label>
                                    </div>
                                </div>

                                <strong class="mt-2 mb-2 text-sm d-block">{{ "Width: ".$config[$type]['width']." px - Height: ".$config[$type]['height']." px (".$config[$type]['img_type'].")" }}</strong>                                

                                <div class="custom-file my-custom-file d-none">
                                    <input type="file" class="custom-file-input" name="file_banner{{$i}}" id="file_banner{{$i}}">
                                    <label class="custom-file-label" for="file{{$i}}">Chọn file</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="form-group">
                                <label class="change-photo" for="file_descript{{$i}}">
                                    <p>Ảnh mô tả:</p>
                                    <div class="rounded">
                                        <img class="rounded img-upload" src="" onerror=src="{{asset('img/noimage.png')}}" alt="Alt Photo"/>
                                        <strong>
                                            <b class="text-sm text-split"></b>
                                            <span class="btn btn-sm bg-gradient-success"><i class="mr-2 fas fa-camera"></i>Chọn hình</span>
                                        </strong>
                                    </div>
                                </label>

                                <div class="mt-2 form-group">
                                    <label for="hienthi<?=$i?>" class="mb-0 mr-2 align-middle d-inline-block">Hiển thị:</label>
                                    <div class="align-middle custom-control custom-checkbox d-inline-block">
                                        <input type="checkbox" class="custom-control-input hienthi-checkbox" name="dataMulti[{{$i}}][hienthi4]" id="hienthi-checkbox{{$i}}" checked>
                                        <label for="hienthi-checkbox<?=$i?>" class="custom-control-label"></label>
                                    </div>
                                </div>

                                <strong class="mt-2 mb-2 text-sm d-block">{{ "Width: ".$config[$type]['width']." px - Height: ".$config[$type]['height']." px (".$config[$type]['img_type'].")" }}</strong>

                                <div class="custom-file my-custom-file d-none">
                                    <input type="file" class="custom-file-input" name="file_descript{{$i}}" id="file_descript{{$i}}">
                                    <label class="custom-file-label" for="file{{$i}}">Chọn file</label>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if(isset($config[$type]['prename']) && $config[$type]['prename'])
                        <x-backend_form.group >
                            <x-backend_form.label >{{ __('Định danh') }}: </x-backend_form.label>
                            <x-backend_form.input type="text" name="dataMulti[{{ $i }}][prename]" id="prename{{ $i }}"  />
                        </x-backend_form.group>
                    @endif

                    @if(isset($config[$type]['link']) && $config[$type]['link'])
                        <x-backend_form.group >
                            <x-backend_form.label >{{ __('Link') }}: </x-backend_form.label>
                            <x-backend_form.input type="text" name="dataMulti[{{ $i }}][link]" id="link{{ $i }}"  />
                        </x-backend_form.group>
                    @endif


                    @if(isset($config[$type]['video']) && $config[$type]['video'])
                        <x-backend_form.group >
                            <x-backend_form.label >{{ __('Video') }}: </x-backend_form.label>
                            <x-backend_form.input type="text" name="dataMulti[{{ $i }}][link_video]" id="link_video{{ $i }}" onchange="youtubePreview(this.value,'#loadVideo{{ $i }}');" />
                        </x-backend_form.group>
                        <x-backend_form.group >
                            <x-backend_form.label >{{ __('Video preview') }}: </x-backend_form.label>
                            <div><iframe id="loadVideo{{ $i }}" width="0px" height="0px" frameborder="0" allowfullscreen></iframe></div>
                        </x-backend_form.group>
                    @endif

                    @php
                        $isChecked = false;
                    @endphp
                    <x-backend_form.group>
                        <x-backend_form.label isInlineBlock class="{{ $sttLabelClass }}" >{{ __('Hiển thị') }}: </x-backend_form.label>
                        <x-backend_form.hienthi_input_group :isChecked="$isChecked" name="dataMulti[{{ $i }}][hienthi]"
                        id="hienthi-checkbox{{ $i }}" />
                    </x-backend_form.group>

                    <x-backend_form.group>
                        <x-backend_form.label isInlineBlock class="{{ $sttLabelClass }}" >{{ __('Số thứ tự') }}: </x-backend_form.label>
                        <x-backend_form.input type="number" name="dataMulti[{{ $i }}][stt]"
                        id="stt{{ $i }}" value="{{ $rowItem['stt'] ?? 1 }}" class="{{ $sttInputClass }}" />
                    </x-backend_form.group>

                    @php
                        /*
                        <div class="form-group">
                        <label for="hienthi<?=$i?>" class="mb-0 mr-2 align-middle d-inline-block">Hiển thị:</label>
                        <div class="align-middle custom-control custom-checkbox d-inline-block">
                            <input type="checkbox" class="custom-control-input hienthi-checkbox" name="dataMulti[{{$i}}][hienthi]" id="hienthi-checkbox{{$i}}" checked>
                            <label for="hienthi-checkbox<?=$i?>" class="custom-control-label"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stt{{$i}}" class="mb-0 mr-2 align-middle d-inline-block">Số thứ tự:</label>
                        <input type="number" class="align-middle form-control form-control-mini d-inline-block" min="0" name="dataMulti[{{$i}}][stt]" id="stt{{$i}}" placeholder="Số thứ tự" value="1">
                    </div>
*/
                    @endphp
                    
                    @if (@$config[$type]['sl_options'])
                    <div class="col-xl-12 ">
                        <div class="text-sm card card-primary card-outline">
                            <x-backend_shared.card_header isShowMinus>
                                {{ __('Thông tin') }} {{ __($config[$type]['title_main']) }}
                            </x-backend_shared.card_header>
                            <div class="card-body">
                                <div class="row">
                                    @php
                                        $elements = renderBackendComponent($config[$type]['sl_options'], "dataMulti[$i][options]", null);
                                    @endphp
                                    {!! FormTemplate::show($elements) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(
                        (isset($config[$type]['tieude']) && $config[$type]['tieude'])
                        || (isset($config[$type]['mota']) && $config[$type]['mota'])
                        || (isset($config[$type]['noidung']) && $config[$type]['noidung'])
                        )
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="p-0 card-header border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                    @foreach(config('config_all.lang') as $key => $value)
                                        <li class="nav-item">
                                            <a class="nav-link {{ ($key == 'vi') ? 'active' : ''}}" id="tabs-lang" data-toggle="pill" href="#tabs-lang-{{ $key }}-{{ $i }}" role="tab" aria-controls="tabs-lang-{{ $key }}-{{ $i }}" aria-selected="true">{{ $value }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                    @foreach(config('config_all.lang') as $key => $value)
                                        <div class="tab-pane fade show {{ ($key == 'vi') ? 'active' : '' }}" id="tabs-lang-{{ $key }}-{{ $i }}" role="tabpanel" aria-labelledby="tabs-lang">
                                            @if(isset($config[$type]['tieude']) && $config[$type]['tieude'])
                                                <x-backend_form.group >
                                                    <x-backend_form.label >{{ __('Tiêu đề') }} ({{ $key }}): </x-backend_form.label>
                                                    <x-backend_form.input type="text" name="dataMulti[{{ $i }}][ten{{ $key }}]" id="ten{{ $key }}{{ $i }}" />
                                                </x-backend_form.group>
                                            @endif

                                            @if(isset($config[$type]['mota']) && $config[$type]['mota'])
                                                @php
                                                    $class = "";
                                                    if (isset($config[$type]['mota_cke_custom']) 
                                                        && $config[$type]['mota_cke_custom']) {
                                                        $class .= "form-control-ckeditor-custom ";
                                                    } elseif (isset($config[$type]['mota_cke']) 
                                                        && $config[$type]['mota_cke']) {
                                                        $class .= "form-control-ckeditor ";
                                                    }
                                                @endphp
                                                <x-backend_form.group >
                                                    <x-backend_form.label >{{ __('Mô tả') }} ({{ $key }}): </x-backend_form.label>
                                                    <x-backend_form.textarea class="{{ $class }}" name="dataMulti[{{ $i }}][mota{{ $key }}]" id="mota{{ $key }}{{ $i }}" rows="5"></x-backend_form.textarea>
                                                </x-backend_form.group>
                                            @endif

                                            @if (isset($config[$type]['noidung']) && $config[$type]['noidung'])
                                            @php
                                                $class = " form-control-ckeditor";
                                                $labelName = $config[$type]['noidung_title'] ?? __('Nội dung');
                                            @endphp
                                            <x-backend_form.group >
                                                <x-backend_form.label >{{ $labelName }} ({{ $key }}): </x-backend_form.label>
                                                <x-backend_form.textarea class="{{ $class }}" name="dataMulti[{{ $i }}][noidung{{ $key }}]" id="noidung{{ $key }}{{ $i }}" rows="5"></x-backend_form.textarea>
                                            </x-backend_form.group>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    @endfor
    </div>
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection
@php
    use App\Helpers\Form as FormTemplate;
    $formLabelAttr = config('zvn.template.form_label.class');
    $formInputAttr = config('zvn.template.form_input.class');
    $sl_options = (isset($rowItem['sl_options']) && $rowItem['sl_options'] != '') ? json_decode($rowItem['sl_options'],true) : null;
    $formGroupClass = config('zvn.template.form_group.class');
    $sttInputClass = config('zvn.template.stt_form_input.class');
    $sttLabelClass = config('zvn.template.stt_form_label.class');
    $rowItem = $rowItem ?? [];

    $urlSave = route('admin.newsletter.save', ['man', $type]);
    $urlMan = route('admin.newsletter.show', ['man', $type]);
    $urlOption = '';
    $isShowOption = false;
@endphp
@extends('admin.master')

@section('content')
<form class="validation-form" novalidate method="post" action="{{ $urlSave }}" enctype="multipart/form-data">
	@csrf
    <x-backend_shared.action_buttons
        :urlMan=$urlMan
        :urlOption=$urlOption
        :isShowOption=$isShowOption
    />
    <div class="text-sm card card-primary card-outline">
        <x-backend_shared.card_header >
            {{ __('Chi tiết') }} {{ __($config[$type]['title_main']) }}
        </x-backend_shared.card_header>
        <div class="card-body">
            @if(isset($config[$type]['file']) && $config[$type]['file'])
                <div class="form-group">
                    <label class="mb-1 mr-2 change-file" for="file-taptin">
                        <p>Upload tập tin:</p>
                        <strong class="ml-2">
                            <span class="btn btn-sm bg-gradient-success"><i class="mr-2 fas fa-file-upload"></i>Chọn tập tin</span>
                            <div><b class="text-sm text-split"></b></div>
                        </strong>
                    </label>
                    <strong class="mt-2 mb-2 text-sm d-block">{{$config[$type]['file_type']}}</strong>
                    <div class="custom-file my-custom-file d-none">
                        <input type="file" class="custom-file-input" name="file-taptin" id="file-taptin">
                        <label class="custom-file-label" for="file-taptin">Chọn file</label>
                    </div>
                    @if(isset($rowItem['taptin']) && ($rowItem['taptin'] != ''))
                        <a class="p-2 mb-1 text-white align-middle rounded btn btn-sm bg-gradient-primary d-inline-block" href="{{ Helper::GetFolder($folder_upload,true).$rowItem['taptin'] }}" title="Download tập tin hiện tại"><i class="mr-2 fas fa-download"></i>Download tập tin hiện tại</a>
                    @endif
                </div>
            @endif

            @if(isset($config[$type]['file2']) && $config[$type]['file2'])
                <div class="form-group">
                    <label class="mb-1 mr-2 change-file" for="file-taptin">
                        <p>Upload tập tin:</p>
                        <strong class="ml-2">
                            <span class="btn btn-sm bg-gradient-success"><i class="mr-2 fas fa-file-upload"></i>Chọn tập tin</span>
                            <div><b class="text-sm text-split"></b></div>
                        </strong>
                    </label>
                    <strong class="mt-2 mb-2 text-sm d-block">{{$config[$type]['file_type']}}</strong>
                    <div class="custom-file my-custom-file d-none">
                        <input type="file" class="custom-file-input" name="file-taptin2" id="file-taptin">
                        <label class="custom-file-label" for="file-taptin">Chọn file</label>
                    </div>
                    @if(isset($rowItem['taptin2']) && ($rowItem['taptin2'] != ''))
                        <a class="p-2 mb-1 text-white align-middle rounded btn btn-sm bg-gradient-primary d-inline-block" href="{{ Helper::GetFolder($folder_upload,true).$rowItem['taptin2'] }}" title="Download tập tin hiện tại"><i class="mr-2 fas fa-download"></i>Download tập tin hiện tại</a>
                    @endif
                </div>
            @endif

            <div class="form-group-category row">
                @if(isset($config[$type]['ten']) && $config[$type]['ten'])
                    <x-backend_form.group class="{{ $formGroupClass }}">
                        <x-backend_form.label >{{ __('Họ tên') }}: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[tenvi]"
                        id="ten" value="{{ $rowItem['tenvi'] ?? '' }}"  />
                    </x-backend_form.group>
                @endif

                @if(isset($config[$type]['dienthoai']) && $config[$type]['dienthoai'])
                    <x-backend_form.group class="{{ $formGroupClass }}">
                        <x-backend_form.label >{{ __('Điện thoại') }}: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[dienthoai]"
                        id="dienthoai" value="{{ $rowItem['dienthoai'] ?? '' }}"  />
                    </x-backend_form.group>
                @endif

                @if(isset($config[$type]['email']) && $config[$type]['email'])
                    <x-backend_form.group class="{{ $formGroupClass }}">
                        <x-backend_form.label >Email: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[email]"
                        id="email" value="{{ $rowItem['email'] ?? '' }}"  />
                    </x-backend_form.group>
                @endif

                @if(isset($config[$type]['chieucao']) && $config[$type]['chieucao'])
                    <x-backend_form.group class="{{ $formGroupClass }}">
                        <x-backend_form.label >{{ __('Chiều cao') }}: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[chieucao]"
                        id="chieucao" value="{{ $rowItem['chieucao'] ?? '' }}"  />
                    </x-backend_form.group>
                @endif

                @if(isset($config[$type]['cannang']) && $config[$type]['cannang'])
                    <x-backend_form.group class="{{ $formGroupClass }}">
                        <x-backend_form.label >{{ __('Cân nặng') }}: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[cannang]"
                        id="cannang" value="{{ $rowItem['cannang'] ?? '' }}"  />
                    </x-backend_form.group>
                @endif

                @if(isset($config[$type]['facebook']) && $config[$type]['facebook'])
                    <x-backend_form.group class="{{ $formGroupClass }}">
                        <x-backend_form.label >Link facebook: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[facebook]"
                        id="facebook" value="{{ $rowItem['facebook'] ?? '' }}"  />
                    </x-backend_form.group>
                @endif

                @if(isset($config[$type]['diachi']) && $config[$type]['diachi'])
                    <x-backend_form.group class="{{ $formGroupClass }}">
                        <x-backend_form.label >{{ __('Địa chỉ') }}: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[diachi]"
                        id="diachi" value="{{ $rowItem['diachi'] ?? '' }}"  />
                    </x-backend_form.group>
                @endif

                @if(isset($config[$type]['chude']) && $config[$type]['chude'])
                    <x-backend_form.group class="{{ $formGroupClass }}">
                        <x-backend_form.label >{{ __('Chủ đề') }}: </x-backend_form.label>
                        <x-backend_form.input type="text" name="data[chude]"
                        id="chude" value="{{ $rowItem['chude'] ?? '' }}"  />
                    </x-backend_form.group>
                @endif

                @if(isset($config[$type]['tinhtrang']) && count($config[$type]['tinhtrang']) > 0)
                    @php
                        $data  = [
                            ["value" => 0, "title" => __('Tình trạng')]
                        ];
                        foreach ($config[$type]['tinhtrang'] as $keyTT => $valueTT) {
                            $data[] = ["value" => $keyTT, "title" => __($valueTT)];
                        }
                        $selectedIds = [$rowItem['tinhtrang']] ?? null;
                    @endphp
                    <x-backend_form.group class="{{ $formGroupClass }}">
                        <x-backend_form.label >{{ __('Tình trạng') }}: </x-backend_form.label>
                        <x-backend_form.select name="data[tinhtrang]"
                        id="tinhtrang" :data=$data :selectedIds=$selectedIds />
                    </x-backend_form.group>
                    {{-- <div class="form-group col-md-4">
                        <label for="tinhtrang">Tình trạng:</label>
                        <select id="tinhtrang" name="data[tinhtrang]" class="form-control select2">
                            <option value="0">Cập nhật tình trạng</option>
                            @foreach($config[$type]['tinhtrang'] as $key => $value)
                                <option {{(isset($rowItem['tinhtrang']) && ($rowItem['tinhtrang'] == $key)) ? "selected" : ""}} value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div> --}}
                @endif

                @if (@$config[$type]['sl_options'])
                    @php
                        $elements = renderBackendComponent($config[$type]['sl_options'], 'dataSlOptions', $sl_options);
                    @endphp
                    {!! FormTemplate::show($elements) !!}
                @endif
            </div>
            @if(isset($config[$type]['noidung']) && $config[$type]['noidung'])
                @php
                    $class = "";
                    $labelName = __('Nội dung');
                @endphp
                <x-backend_form.group >
                    <x-backend_form.label >{{ $labelName }}: </x-backend_form.label>
                    <x-backend_form.textarea name="data[noidung]" id="noidung" rows="5">{{$rowItem['noidung'] ?? '' }}</x-backend_form.textarea>
                </x-backend_form.group>
            @endif
            @if(isset($config[$type]['ghichu']) && $config[$type]['ghichu'])
                @php
                    $class = "";
                    $labelName = __('Ghi chú');
                @endphp
                <x-backend_form.group >
                    <x-backend_form.label >{{ $labelName }}: </x-backend_form.label>
                    <x-backend_form.textarea name="data[ghichu]" id="ghichu" rows="5">{{$rowItem['ghichu'] ?? '' }}</x-backend_form.textarea>
                </x-backend_form.group>
            @endif
            @php
                $isChecked = false;
                if (!isset($rowItem['hienthi']) || $rowItem['hienthi'] == 1) {
                    $isChecked = true;
                }
            @endphp
            <x-backend_form.group>
                <x-backend_form.label isInlineBlock class="{{ $sttLabelClass }}" >{{ __('Hiển thị') }}: </x-backend_form.label>
                <x-backend_form.hienthi_input_group :isChecked="$isChecked" name="data[hienthi]"
                id="hienthi-checkbox" />
            </x-backend_form.group>

            <x-backend_form.group>
                <x-backend_form.label isInlineBlock class="{{ $sttLabelClass }}" >{{ __('Số thứ tự') }}: </x-backend_form.label>
                <x-backend_form.input type="number" name="data[stt]"
                id="stt" value="{{ $rowItem['stt'] ?? 1 }}" class="{{ $sttInputClass }}" />
            </x-backend_form.group>

        </div>
    </div>
    <input type="hidden" name="id" value="{{ $rowItem['id'] ?? '' }}">
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')

@endsection

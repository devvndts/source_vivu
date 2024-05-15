@extends('admin.master')
@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];

$urlSave = route('admin.seopage.save', [$category, $type]);
$urlMan = route('admin.seopage.show', [$category, $type]);
$urlOption = '';
$isShowOption = false;
$isShowDropdown = false;
@endphp
@section('content')
<form class="validation-form" novalidate method="post" action="{{ $urlSave }}" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <x-backend_shared.action_buttons
        :urlMan=$urlMan
        :urlOption=$urlOption
        :isShowOption=$isShowOption
        :isShowDropdown=$isShowDropdown
    />

    <div class="row">
        <div class="col-xl-8">
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header >
                    {{ __('Chi tiết') }}
                </x-backend_shared.card_header>
                <div class="card-body">
                    @php
                        $rowPhoto = $rowItem['photo'] ?? '';
                        $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                        $photoWidth = $config[$type]['width'] ?? null;
                        $photoHeight = $config[$type]['height'] ?? null;
                        $photoRatio = $config[$type]['ratio'] ?? null;
                    @endphp
                    <x-backend_shared.photo_upload :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight :photoRatio=$photoRatio />
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="text-sm card card-primary card-outline">
                <x-backend_shared.card_header >
                    {{ __('Nội dung') }} SEO
                    <x-slot name="other_info">
                        <a class="float-right text-white btn btn-sm bg-gradient-success d-inline-block create-seo"
                        >{{ __('Tạo') }} SEO</a>
                    </x-slot>
                </x-backend_shared.card_header>
                <div class="card-body">
                    @include('admin.layouts.seo')
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="{{ $rowItem['id'] ?? 0 }}">
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
    <script>
        $(document).ready(function(){
            $('#ngaybatdau').datetimepicker({
                timepicker:false,
                format:'d/m/Y'
            });

            $('#ngayketthuc').datetimepicker({
                timepicker:false,
                format:'d/m/Y'
            });

            $('#thoigianbatdau').datetimepicker({
                datepicker:false,
                format:'H:i'
            });

            $('#thoigianketthuc').datetimepicker({
                datepicker:false,
                format:'H:i'
            });
        });
    </script>
@endsection

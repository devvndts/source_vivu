@extends('admin.master')
@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];

$urlSave = route('admin.member.change');
$urlMan = route('admin.member.editchange');
$urlOption = '';
$isShowOption = false;
$isShowDropdown = false;
@endphp
@section('content')
<form method="post" action="{{ $urlSave }}" enctype="multipart/form-data">
    @csrf
    <x-backend_shared.action_buttons
        :urlMan=$urlMan
        :urlOption=$urlOption
        :isShowOption=$isShowOption
        :isShowDropdown=$isShowDropdown
        />
    <div class="text-sm card card-primary card-outline">
        <x-backend_shared.card_header >
            {{ __('Thông tin admin') }}
        </x-backend_shared.card_header>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        @if(isset($info_check))
                            @if($info_check)
                                <p class="dev-option-error text-success col-xl-12"><i class="fas fa-exclamation-circle"></i> {{ $info_loading }} </p>
                            @else
                                <p class="dev-option-error text-danger col-xl-12"><i class="fas fa-exclamation-circle"></i> {{ $info_loading }} </p>
                            @endif
                        @endif

                        @php
                            $class = "col-xl-4 col-lg-6 col-md-6 ";
                        @endphp
                        <x-backend_form.group :class=$class >
                            <x-backend_form.label >{{ __('Mật khẩu cũ') }}: </x-backend_form.label>
                            <x-backend_form.input type="password" name="old_password" id="old_password" required />
                        </x-backend_form.group>

                        @php
                            $class = "col-xl-4 col-lg-6 col-md-6 ";
                        @endphp
                        <x-backend_form.group :class=$class >
                            <x-backend_form.label >{{ __('Mật khẩu mới') }}: ( <a><span class="text-sm" style="cursor: pointer;color:#26b99a" onclick="randomPassword()"><i class="mr-1 far fa-hand-point-right"></i>{{ __('Tạo ngẫu nhiên') }}</span></a> )<span class="ml-2 text-danger" id="show_password"></span></x-backend_form.label>
                            <x-backend_form.input type="password" name="new_password" id="new_password" required />
                        </x-backend_form.group>

                        @php
                            $class = "col-xl-4 col-lg-6 col-md-6 ";
                        @endphp
                        <x-backend_form.group :class=$class >
                            <x-backend_form.label >{{ __('Nhập lại mật khẩu mới') }}:</x-backend_form.label>
                            <x-backend_form.input type="password" name="renew_password" id="renew_password" required />
                        </x-backend_form.group>
                    </div>
                </div>
                {{-- <div class="col-xl-6">
                    <div class="text-sm card card-primary card-outline">
                        <x-backend_shared.card_header isShowMinus>
                            {{ __('Hình đại diện') }}
                        </x-backend_shared.card_header>
                        <div class="card-body">
                            @php
                                $rowPhoto = $rowItem['photo'] ?? '';
                                $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                                $photoWidth = 200;
                                $photoHeight = 200;
                            @endphp
                            <x-backend_shared.photo_upload :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight />
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
<script type="text/javascript">
    function randomPassword()
    {
        var chuoi = "";
        for(i=0;i<9;i++)
        {
            chuoi += "!@#$%^&*()?abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".charAt(Math.floor(Math.random()*62));
        }
        jQuery('#new_password').val(chuoi);
        jQuery('#renew_password').val(chuoi);
        jQuery('#show_password').html(chuoi);
    }
</script>
@endsection

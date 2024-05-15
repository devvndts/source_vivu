@extends('desktop.master')

@section('content')
<div class="pb-3 my-4 center-layout">
    <div class="px-3 py-2 bg-white rounded">        
        <div class="content-main contact-conatiner w-clear">
            <div class="contact-box">
                <div class="top-contact">
                    <div class="flex flex-wrap row">
                        <div class="md:w-1/2 form-group col-sm-6">
                            <div class="article-contact">{!!(isset($row_detail['noidung'.$lang]) && $row_detail['noidung'.$lang] != '') ? $row_detail['noidung'.$lang] : ''!!}</div>
                        </div>
                        <div class="form-group col-sm-6 md:w-1/2">
                            <form id="frm_contact" class="form-contact validation-contact frm_check_recaptcha" novalidate method="post" action="{{ route('sendContact') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type" value="lienhe" />
                                <div class="flex flex-wrap justify-around mb-2 row">
                                    <div class="px-1 input-contact col-sm-6 basis-1/2">
                                        <label for="ten" class="inp">
                                            <input type="text" class="form-control" name="ten" id="ten" placeholder="&nbsp;" required>
                                            <span class="label">{{hoten}}</span>
                                            <span class="focus-bg"></span>
                                            <div class="invalid-feedback">{{vuilongnhaphoten}}</div>
                                        </label>
                                    </div>
                                    <div class="px-1 input-contact col-sm-6 basis-1/2">
                                        <label for="dienthoai" class="inp">
                                            <input type="number" class="form-control" name="dienthoai" id="dienthoai" placeholder="&nbsp;" required>
                                            <span class="label">{{sodienthoai}}</span>
                                            <span class="focus-bg"></span>
                                            <div class="invalid-feedback">{{vuilongnhapsodienthoai}}</div>
                                        </label>                                        
                                    </div>
                                </div>
                                <div class="flex flex-wrap justify-around mb-2 row">
                                    <div class="px-1 input-contact col-sm-6 basis-1/2">
                                        <label for="diachi" class="inp">
                                            <input type="text" class="form-control" name="diachi" id="diachi" placeholder="&nbsp;" required>
                                            <span class="label">{{diachi}}</span>
                                            <span class="focus-bg"></span>
                                            <div class="invalid-feedback">{{vuilongnhapdiachi}}</div>
                                        </label>                                        
                                    </div>
                                    <div class="px-1 input-contact col-sm-6 basis-1/2">
                                        <label for="email" class="inp">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="&nbsp;" required>
                                            <span class="label">Email</span>
                                            <span class="focus-bg"></span>
                                            <div class="invalid-feedback">{{vuilongnhapdiachiemail}}</div>
                                        </label>                                        
                                    </div>
                                </div>
                                <div class="mb-2 input-contact">
                                    <label for="tieude" class="inp">
                                        <input type="text" class="form-control" name="tieude" id="tieude" placeholder="&nbsp;" required>
                                        <span class="label">{{chude}}</span>
                                        <span class="focus-bg"></span>
                                        <div class="invalid-feedback">{{vuilongnhapchude}}</div>
                                    </label>
                                </div>
                                <div class="mb-2 input-contact">
                                    <label for="noidung" class="inp">
                                        <textarea class="form-control" id="noidung" rows="5" name="noidung" placeholder="&nbsp;" required></textarea>
                                        <span class="label">{{noidung}}</span>
                                        <span class="focus-bg"></span>
                                        <div class="invalid-feedback">{{vuilongnhapnoidung}}</div>
                                    </label>
                                </div>

                                <div class="mb-2 input-contact col-sm-12">
                                    <input type="file" class="custom-file-input" name="file">
                                    <label class="custom-file-label" for="file" title="{{chon}}">{{dinhkemtaptin}}</label>
                                </div>
                                <input type="submit" class="btn btn-contact" name="submit-contact" value="{{gui}}" disabled />
                                <input type="reset" class="btn btn-secondary d-none" value="{{nhaplai}}" />
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-4 bottom-contact map_iframe d-none">{!!$settingOption['toado_iframe']!!}</div>
            </div>
        </div>
    </div>
</div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')
    <link href="{{asset('css/contact.css')}}" rel="stylesheet">
@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
<script src="https://www.google.com/recaptcha/api.js?render={{ config('recapcha.site_key_google') }}"></script>
<script>
    function submitContactForm() {
        window.grecaptcha.ready(function () {
            
            var $formContact = $('form[id="frm_contact"]'); 

            if ($formContact.length) {
                $formContact.submit(function (e) {
                    e.preventDefault();

                    var action = 'contact/submit';

                    window.grecaptcha.execute(SITE_KEY_GOOGLE, {action: action}).then(function (token) {
                        var $recaptchaAction = $('#recaptcha_action');
                        var $recaptchaToken = $('#recaptcha_token');

                        if ($recaptchaAction.length) {
                            $recaptchaAction.val(action);
                        } else {
                            $formContact.append('<input type="hidden" name="recaptcha_action" id="recaptcha_action" value="' + action + '" />');
                        }
                        if ($recaptchaToken.length) {
                            $recaptchaToken.val(token);
                        } else {
                            $formContact.append('<input type="hidden" name="recaptcha_token" id="recaptcha_token" value="' + token + '" />');
                        }
                        
                        $formContact.unbind('submit');//.submit();
                    });
                });
            } // End if
        })
    }
    $(document).ready(function () {
        submitContactForm();
    });
</script>
@endpush


@push('strucdata')
    @include('desktop.layouts.strucdata')
@endpush
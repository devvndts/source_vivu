@extends('desktop.master')
@php
    $randomNum = substr(str_shuffle("0123456789"), 0, 4);
    $testName = (isset($testEvn) && $testEvn) ? sprintf('test name %s', $randomNum) : '';
    $testSubject = (isset($testEvn) && $testEvn) ? sprintf('test subject %s', $randomNum) : '';
    $testPhone = (isset($testEvn) && $testEvn) ? sprintf('093839%s', $randomNum) : '';
    $testAddress = (isset($testEvn) && $testEvn) ? sprintf('test address %s', $randomNum) : '';
    $testEmail = (isset($testEvn) && $testEvn) ? sprintf('test%s@mail.test', $randomNum) : '';
    $testContent = (isset($testEvn) && $testEvn) ? sprintf('test content %s', $randomNum) : '';
@endphp
@section('content')
<div class="container max-w-screen-xl">
    <div class="py-5 md:flex md:flex-wrap md:justify-between">
        <div class="flex-1 min-w-0 mb-5">
            <div class="content-main">{!!(isset($row_detail['noidung'.$lang]) && $row_detail['noidung'.$lang] != '') ? $row_detail['noidung'.$lang] : ''!!}</div>
        </div>
        <div class="flex-1 min-w-0 md:ml-4">
            <x-buk-form id="FormContact" class="form-contact validation-contact " action="{{ route('sendContact') }}" hasFiles novalidate>
                <x-forms.input type="hidden" name="type" value="lienhe" />
                <div class="flex flex-wrap justify-between">
                    <x-forms.group class=" even:ml-4" >
                        <x-forms.label for="ten" title="{{ __('site.name') }}"  /> 
                        <x-forms.input name="ten" required="true" value="{{ 
                            $testName }}" />
                        <x-alerts.alert >{{ __('site.please_name') }}</x-alerts.alert>
                    </x-forms.group>
                    <x-forms.group class=" even:ml-4" >
                        <x-forms.label for="dienthoai" title="{{ __('site.phone') }}"  />
                        <x-forms.input name="dienthoai" required="true" value="{{ $testPhone }}" />
                        <x-alerts.alert >{{ __('site.please_phone') }}</x-alerts.alert>
                    </x-forms.group>
                </div>
                <div class="flex flex-wrap justify-between">
                    <x-forms.group class=" even:ml-4" >
                        <x-forms.label for="diachi" title="{{ __('site.address') }}" />
                        <x-forms.input name="diachi" required="true" value="{{ $testAddress }}" />
                        <x-alerts.alert >{{ __('site.please_address') }}</x-alerts.alert>
                    </x-forms.group>
                    <x-forms.group class=" even:ml-4" >
                        <x-forms.label for="Email" title="Email" />
                        <x-forms.input name="email" required="true" value="{{ $testEmail }}" />
                        <x-alerts.alert >{{ __('site.please_email') }}</x-alerts.alert>
                    </x-forms.group>
                </div>
                <div class="flex flex-wrap justify-between">
                    <x-forms.group class=" even:ml-4" >
                        <x-forms.label for="tieude" title="{{ __('site.subject') }}"  />
                        <x-forms.input name="tieude" required="true" value="{{ $testSubject }}" />
                        <x-alerts.alert >{{ __('site.please_subject') }}</x-alerts.alert>
                    </x-forms.group>
                </div>
                <div class="flex flex-wrap justify-between">
                    <x-forms.group class=" even:ml-4" >
                        <x-forms.label for="noidung" title="{{ __('site.content') }}"  />
                        <x-forms.textarea name="noidung" rows="5" required="true" >
                            {{ $testContent }}
                        </x-forms.textarea>
                        <x-alerts.alert >{{ __('site.please_content') }}</x-alerts.alert>
                    </x-forms.group>
                </div>
                <div class="flex flex-wrap justify-between">
                    <x-forms.group class=" even:ml-4" >
                        <x-forms.label for="dinhkemtaptin" title="{{ __('Đính kèm tập tin') }}" />
                        <x-forms.input type="file" name="file" />
                    </x-forms.group>
                </div>
                <div class="flex flex-wrap justify-between">
                    <x-forms.group class=" even:ml-4" >
                        <x-shared.button disabled="" class="btn-danger" type="submit" isInput name="submit-contact" title="{{ __('site.send') }}" />
                        {{-- <x-forms.input type="submit" name="submit-contact" value="{{ __('site.send') }}" /> --}}
                    </x-forms.group>
                </div>
            </x-buk-form>
        </div>
    </div>
    <div class="mb-6 aspect-w-6 aspect-h-3">
        {!! $settingOption["toado_iframe"] !!}
    </div>
</div>

@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')
    {{-- <link href="{{asset('css/contact.css')}}" rel="stylesheet"> --}}
@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
{{-- <script src="https://www.google.com/recaptcha/api.js?render={{ config('recapcha.site_key_google') }}"></script>
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
</script> --}}
@endpush


@push('strucdata')
    @include('desktop.layouts.strucdata')
@endpush
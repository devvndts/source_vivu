@php
use App\Helpers\Form as FormTemplate;
$formLabelAttr = config('zvn.template.form_label.class');
$formInputAttr = config('zvn.template.form_input.class');
$formGroupClass = config('zvn.template.form_group.class');
$sttInputClass = config('zvn.template.stt_form_input.class');
$sttLabelClass = config('zvn.template.stt_form_label.class');
$rowItem = $rowItem ?? [];
$valueOrigin = $rowItem["origin"] ?? old('data.origin');
$valueDestination = $rowItem["destination"] ?? old('data.destination');

@endphp
@extends('admin.master')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4><i class="fa fa-warning"></i>Warning!</h4>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form class="validation-form autosave-form" novalidate method="post"
        action="{{ route('admin.redirector.save') }}" enctype="multipart/form-data">
        @csrf
        <div class="text-sm card-footer sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i
                    class="mr-2 far fa-save"></i>Lưu</button>
            <div class="pl-0 ml-1 btn dropdown">
                <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Thao tác
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button type="submit" class="btn btn-sm bg-gradient-success submit-check btn-none-css"
                        name="savehere"><i class="mr-2 far fa-save"></i>{{ __('Lưu') }} tại trang</button>
                    <button type="reset" class="btn btn-sm bg-gradient-secondary btn-none-css"><i
                            class="mr-2 fas fa-redo"></i>Làm lại</button>
                    <a class="btn btn-sm bg-gradient-danger btn-none-css"
                        href="{{ route('admin.redirector.show') }}" title="Thoát"><i
                            class="mr-2 fas fa-sign-out-alt"></i>Thoát</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8">
                <div class="text-sm card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-body card-article">
                                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                    <x-backend_form.group style="padding-top: 15px;">
                                        <x-backend_form.label>{{ __('Origin') }}: </x-backend_form.label>
                                        <x-backend_form.input value="{{ $valueOrigin }}" name="data[origin]" id="data_origin" />
                                        @error('data.origin')
                                            <x-backend_shared.alert>{{ $message }}</x-backend_shared.alert>
                                        @enderror
                                    </x-backend_form.group>
                                    <x-backend_form.group style="padding-top: 15px;">
                                        <x-backend_form.label>{{ __('Destination') }}: </x-backend_form.label>
                                        <x-backend_form.input value="{{ $valueDestination }}" name="data[destination]" id="data_destination" />
                                        @error('data.destination')
                                            <x-backend_shared.alert>{{ $message }}</x-backend_shared.alert>
                                        @enderror
                                    </x-backend_form.group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
            </div>
        </div>
        <input type="hidden" name="id" value="{{ $rowItem['id'] ?? '' }}">
        <input type="hidden" name="table" value="redirector">
        <input type="hidden" name="model" class="autosave-btn" value="redirector">
    </form>
@endsection
<!--js thêm cho mỗi trang-->
@section('js_page')
    <script>
        $(document).ready(function() {
        });
    </script>
@endsection

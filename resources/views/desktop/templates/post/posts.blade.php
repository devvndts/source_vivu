@extends('desktop.master')
@section('content')
@if ($type == "du-an")
    @include('desktop.templates.post.duan')
@elseif ($type == "hoi-dap")
    @include('desktop.templates.post.hoidap')   
@elseif ($type == "feedback")
    @include('desktop.templates.post.feedback')   
@elseif ($type == "dich-vu")
    @include('desktop.templates.post.dichvu')   
@else
    @include('desktop.templates.post.tintuc')   
@endif

@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')

@endpush

@push('strucdata')
    @include('desktop.layouts.strucdata')
@endpush
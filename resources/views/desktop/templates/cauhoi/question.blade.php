@extends('desktop.master')

@section('content')
<div class="center-layout py- bortop">
    <div class="rounded py-2 px-0">
        @include('desktop.layouts.hoidap')
    </div>
</div>
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
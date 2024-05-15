@extends('desktop.master')

@section('content')
<div class="my-5 container-error">
    <div class="error-left text-primary">404</div>
    <div class="error-right">
      <h3 class="error-title">Trang hoặc bài viết này hiện không tồn tại hoặc bạn nhập sai địa chỉ</h3>
      <p class="error-info">Bạn vui lòng kiểm tra lại đường dẫn website</p>
      <div class="error-slogan">Nhập từ khóa bạn muốn tìm kiếm tại đây nhé!</div>
      <p class="error_btn"><a class="text-white bg-primary" href="{{route('home')}}">Quay lại trang chủ</a></p>
    </div>
</div>
@endsection

@push('css_page')
  <style>   
   .container-error{display: flex;max-width: var(--content-width);margin: auto;align-items: center;}
   .error-left{font-weight: bold;font-size: 250px;}
   .error-title{font-weight: bold;}
   .error-info{margin: 1rem 0;color: #999;}
   .error-slogan{font-weight: bold;display: none;}
   .error-right{padding-left: 3rem;}
   .error_btn{margin-top: 20px;}
   .error_btn a{display: inline-block; padding:8px 20px;text-decoration: none;border-radius: 30px;font-weight: bold;}

   @media screen and (max-width: 650px){
    .container-error{flex-wrap: wrap;justify-content: center;}
   }
</style>
@endpush
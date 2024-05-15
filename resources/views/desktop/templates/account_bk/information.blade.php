@extends('desktop.master')

@section('content')
<div class="center-layout pb-3">
    <div class="row justify-content-center rounded py-2 px-3 ">
        <div class="col-md-6 bg-white pt-2">
            <div class="title">{{$title_crumb}}</div>
            <div class="p-3 mb-5">
                <form class="form-user validation-user" novalidate method="post" action="{{route('account.information')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="basic-url">{{hoten}}</label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="ten" name="name" placeholder="{{nhaphoten}}" value="{{$rowItem['name']}}" required>
                            <div class="invalid-feedback">{{vuilongnhaphoten}}</div>
                        </div>
                    </div>
                    @if(empty($user_info['social_id']))
                        <div class="form-group">
                            <label for="basic-url">{{taikhoan}}</label>
                            <div class="input-group input-user">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <input type="text" class="form-control" id="username" placeholder="{{nhaptaikhoan}}" value="{{$rowItem['username']}}" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="basic-url">{{matkhaucu}}</label>
                            <div class="input-group input-user">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                </div>
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{nhapmatkhaucu}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="basic-url">{{matkhaumoi}}</label>
                            <div class="input-group input-user">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                </div>
                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="{{nhapmatkhaumoi}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="basic-url">{{nhaplaimatkhaumoi}}</label>
                            <div class="input-group input-user">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                </div>
                                <input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" placeholder="{{nhaplaimatkhaumoi}}">
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="basic-url">{{gioitinh}}</label>
                        <div class="input-group input-user">
                            <div class="radio-user custom-control custom-radio">
                                <input type="radio" id="nam" name="gioitinh" class="custom-control-input" {{($rowItem['gioitinh']==1)?'checked':''}} value="1" required>
                                <label class="custom-control-label" for="nam">{{nam}}</label>
                            </div>
                            <div class="radio-user custom-control custom-radio">
                                <input type="radio" id="nu" name="gioitinh" class="custom-control-input" {{($rowItem['gioitinh']==2)?'checked':''}} value="2" required>
                                <label class="custom-control-label" for="nu">{{nu}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="basic-url">{{ngaysinh}}</label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-birthday-cake"></i></div>
                            </div>
                            <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" placeholder="{{nhapngaysinh}}" value="{{date("Y-m-d",$rowItem['ngaysinh'])}}" required>
                            <div class="invalid-feedback">{{vuilongnhapngaysinh}}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="basic-url">Email</label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="{{nhapemail}}" value="{{$rowItem['email']}}" required>
                            <div class="invalid-feedback">{{vuilongnhapdiachiemail}}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="basic-url">{{sodienthoai}}</label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                            </div>
                            <input type="number" class="form-control" id="dienthoai" name="phonenumber" placeholder="{{nhapdienthoai}}" value="{{$rowItem['phonenumber']}}" required>
                            <div class="invalid-feedback">{{vuilongnhapsodienthoai}}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="basic-url">{{diachi}}</label>
                        <div class="input-group input-user">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-map-marker-edit"></i></div>
                            </div>
                            <input type="text" class="form-control" id="diachi" name="diachi" placeholder="{{nhapdiachi}}" value="{{$rowItem['diachi']}}" required>
                            <div class="invalid-feedback">{{vuilongnhapdiachi}}</div>
                        </div>
                    </div>
                    <div class="button-user">
                        <input type="submit" class="btn btn-primary btn-block" value="{{capnhat}}" disabled>
                    </div>
                </form>
            </div>
        </div>
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
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                    class="fas fa-toggle-on mikotech-btn-toggle"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="" class="nav-link">{{ __('Xin chào') }}, <span
                    class="text-danger font-weight-bold">{{ Auth::guard('admin')->user()->name }}</span></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="ml-auto navbar-nav">
        <!-- Notifications -->
        <li class="nav-item d-sm-inline-block">
            <a href="" target="_blank" class="nav-link"><i class="fas fa-reply"></i></a>
        </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu-info" href="#" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-cogs"></i></a>
            <ul aria-labelledby="dropdownSubMenu-info" class="border-0 shadow dropdown-menu dropdown-menu-right">
                @if (config('config_all.debug_developer') == true)
                    {{-- @if (config('config_all.permission') == true &&
    (Auth::guard('admin')->user()->role == 3 ||
        Auth::guard('admin')->user()->can('member_man'))) --}}
                    <li>
                        <a href="{{ route('admin.member.show') }}" class="dropdown-item">
                            <i class="fas fa-users"></i>
                            <span class="dev-fsize-13">{{ __('Quản lý tài khoản admin') }}</span>
                        </a>
                    </li>
                    {{-- @endif --}}


                    {{-- @if (config('config_all.permission') == true &&
    (Auth::guard('admin')->user()->role == 3 ||
        Auth::guard('admin')->user()->can('permission_man'))) --}}
                    <li>
                        <a href="{{ route('admin.role.show') }}" class="dropdown-item">
                            <i class="fas fa-user-cog"></i>
                            <span class="dev-fsize-13">{{ __('Quản lý nhóm quyền') }}</span>
                        </a>
                    </li>
                    {{-- @endif --}}
                @endif

                <li>
                    <a href="{{ route('admin.member.editchange') }}" class="dropdown-item">
                        <i class="fas fa-key"></i>
                        <span class="dev-fsize-13">{{ __('Đổi mật khẩu') }}</span>
                    </a>
                </li>

                @if (config('delivery.active') && config('config_all.debug_developer'))
                    <li>
                        @php
                            $method = config('delivery.transpost_method');
                        @endphp
                        @foreach ($method as $k => $v)
                            <a href="{{ route('admin.transpost.places', [$k]) }}" class="dropdown-item">
                                <i class="far fa-city"></i>
                                <span class="dev-fsize-13">{{ __('Cập nhật tỉnh thành') }} ({{ $k }})</span>
                            </a>
                        @endforeach
                    </li>
                @endif

                <div class="dropdown-divider"></div>

                {{-- @if (config('config_all.debug_developer') == true)
                    <li>
                        <a href="{{ route('admin.lang.show') }}" class="dropdown-item">
                            <i class="fa fa-language" aria-hidden="true"></i>
                            <span class="dev-fsize-13">{{ __('Quản lý ngôn ngữ') }}</span>
                        </a>
                    </li>
                    <div class="dropdown-divider"></div>
                @endif --}}

                <li>
                    <a href="{{ route('admin.clearCache') }}" class="dropdown-item">
                        <i class="far fa-trash-alt"></i>
                        <span class="dev-fsize-13">{{ __('Xóa bộ nhớ tạm') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.clearLog') }}" class="dropdown-item">
                        <i class="far fa-trash-alt"></i>
                        <span class="dev-fsize-13">{{ __('Xóa file logs') }}</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ route('admin.vietnamMap') }}" class="dropdown-item">
                        <i class="fas fa-download"></i>
                        <span class="dev-fsize-13">{{ __('Cài đặt dữ liệu hành chính') }}</span>
                    </a>
                </li> --}}
                <div class="dropdown-divider"></div>
            </ul>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-bell"></i>
                <span class="badge badge-danger navbar-badge">{{ Helper::CountAllInform() }}</span>
            </a>
            <div class="shadow dropdown-menu dropdown-menu-right">
                <span class="p-0 dropdown-item dropdown-header">{{ __('Thông báo') }}</span>

                @if (config('config_all.order.active') == true)
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.order.show', ['man']) }}" class="dropdown-item"><i
                            class="mr-2 fas fa-shopping-bag"></i><span
                            class="mr-1 badge badge-danger">{{ Helper::CountOrderNew() }}</span> {{ __('Đơn hàng') }}</a>
                @endif

                @if (config('config_all.question.active') == true)
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.question.show', ['man']) }}" class="dropdown-item"><i
                            class="mr-2 fas fa-question-circle"></i><span
                            class="mr-1 badge badge-danger">{{ Helper::CountQuestionNew() }}</span> {{ __('Câu hỏi') }}</a>
                @endif

                {{-- <div class="dropdown-divider"></div>
            <a href="{{ route('admin.danhgia.show',['man']) }}" class="dropdown-item"><i class="mr-2 fas fa-comments"></i><span class="mr-1 badge badge-danger">{{ Helper::CountDanhGiaNew() }}</span> Đánh giá mới</a> --}}

                @if (config('config_type.contact'))
                    <div class="dropdown-divider"></div>
                    @foreach (config('config_type.contact') as $k => $v)
                        <a href="{{ route('admin.contact.show', ['man', $k]) }}" class="dropdown-item"><i
                                class="mr-2 fas fa-envelope"></i><span
                                class="mr-1 badge badge-danger">{{ Helper::CountContact($k) }}</span>
                            {{ __($v['title_main']) }}</a>
                    @endforeach
                @endif

                @if (config('config_type.newsletter'))
                    <div class="dropdown-divider"></div>
                    @foreach (config('config_type.newsletter') as $k => $v)
                        <a href="{{ route('admin.newsletter.show', ['man', $k]) }}" class="dropdown-item"><i
                                class="mr-2 fas fa-mail-bulk"></i></i><span
                                class="mr-1 badge badge-danger">{{ Helper::CountNewsletter($k) }}</span>
                            {{ __($v['title_main']) }}</a>
                        <div class="dropdown-divider"></div>
                    @endforeach
                @endif
            </div>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.logout') }}" class="nav-link"><i class="mr-1 fas fa-sign-out-alt"></i>{{ __('Đăng xuất') }}</a>
        </li>
    </ul>
</nav>

@push('js')
    <script>
        $('.mikotech-btn-toggle').click(function() {
            if ($(this).hasClass('fa-toggle-on')) {
                $(this).removeClass('fa-toggle-on');
                $(this).addClass('fa-toggle-off');
            } else {
                $(this).addClass('fa-toggle-on');
                $(this).removeClass('fa-toggle-off');
            }
        });
    </script>
@endpush

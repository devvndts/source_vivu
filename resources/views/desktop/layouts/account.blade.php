<div id="sign-in" class="hfancybox hfancybox--400 bg-light">
    <a href="" class="himg">
        <img src="{{UPLOAD_PHOTO.$logo['photo']}}" width="120" class="mx-auto" alt="Logo">
    </a>
    <div class="hlogin__owl owl-carousel owl-theme">
        <div class="hlogin__owl-items">
            <div class="text-muted text-center py-3">{{dangnhaptaikhoan}}</div>
            <div id="js-sign-in-error"></div>
            <form id="login_form" class="hlogin-form bg-white js-account" method="post" action="{{route('account.login')}}">
                @csrf
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <input type="text" name="username" placeholder="{{tendangnhap}}" required>
                </div>
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-lock-alt"></i>
                    </div>
                    <input type="password" name="password" placeholder="{{matkhau}}" required>
                </div>
                <button type="submit" class="hlogin-form__button">{{dangnhap}}</button>
            </form>
            <div class="hlogin__option py-3">
                <button type="button" class="custom-owl-to" data-target=".hlogin__owl" data-position="1">{{dangkytaikhoan}}</button>
                <button type="button" class="custom-owl-to" data-target=".hlogin__owl" data-position="2">{{banquenmatkhau}}</button>
            </div>
        </div>
        <div class="hlogin__owl-items">
            <div class="text-muted text-center py-3">{{dangkytaikhoan}}</div>
            <div id="show-error"></div>
            <form id="signin_form" class="hlogin-form bg-white js-account" method="post" action="{{route('account.signin')}}">
                @csrf
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <input type="text" name="username" placeholder="{{tendangnhap}}" required>
                </div>
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-lock-alt"></i>
                    </div>
                    <input type="password" name="password" placeholder="{{matkhau}}" required>
                </div>
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-lock-alt"></i>
                    </div>
                    <input type="password" name="repassword" placeholder="{{nhaplaimatkhau}}" required>
                </div>
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <input type="text" name="name" placeholder="{{hoten}}" required>
                </div>
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <input type="text" name="phonenumber" placeholder="{{sodienthoai}}" required>
                </div>
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <button type="submit" class="hlogin-form__button">{{dangky}}</button>
            </form>
            <div class="hlogin__option py-3">
                <button type="button" class="custom-owl-to" data-target=".hlogin__owl" data-position="0">{{dangnhaptaikhoan}}</button>
                <button type="button" class="custom-owl-to" data-target=".hlogin__owl" data-position="2">{{banquenmatkhau}}</button>
            </div>
        </div>
        <div class="hlogin__owl-items">
            <div class="text-muted text-center py-3">{{quenmatkhauvataikhoan}}</div>
            <form id="resetAccount_form" class="hlogin-form bg-white js-account" method="post" action="{{route('account.resetAccount')}}">
                @csrf
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <input type="text" name="username" placeholder="{{tendangnhap}}" required>
                </div>
                <div class="hlogin-form__input-group">
                    <div class="hlogin-form__input-group__icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <button type="submit" class="hlogin-form__button">{{laylaimatkhau}}</button>
            </form>
            <div class="hlogin__option py-3">
                <button type="button" class="custom-owl-to" data-target=".hlogin__owl" data-position="0">{{dangnhaptaikhoan}}</button>
                <button type="button" class="custom-owl-to" data-target=".hlogin__owl" data-position="1">{{dangkytaikhoan}}</button>
            </div>
        </div>
        <div class="hlogin__owl-items"></div>
    </div>
    <div class="hlogin__with">
        <button type="button" onclick="SocialLogin('{{ route('social.login', 'facebook') }}')">
            <i class="fab fa-facebook-f"></i>
            <span>Facebook</span>
        </button>
        <button type="button" onclick="SocialLogin('{{ route('social.login', 'google') }}')">
            <i class="fab fa-google"></i>
            <span>{{dangnhapgoogle}}</span>
        </button>
    </div>
</div>

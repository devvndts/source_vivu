<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Đăng nhập</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }} ">

    <style>
        :root {
            --color-primary: #1BC1C1;
            --gradient-primary: linear-gradient(90deg, #8B0514 0, #BB254A 100%);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            color: #333333;
            padding: 0;
            margin: 0;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus {
            border: 1px solid #ebebeb;
            -webkit-text-fill-color: none;
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            ;
            /*transition: background-color 5000s ease-in-out 0s;*/
            -webkit-transition: "color 9999s ease-out, background-color 9999s ease-out";
            -webkit-transition-delay: 9999s;
        }

        input[data-autocompleted] {
            background-color: transparent !important;
        }

        .sign-in {

            min-height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sign-in__circle {
            position: absolute;
            left: -10%;
            bottom: -50%;
            background: var(--gradient-primary);
            border-radius: 50%;
            width: 100%;
            height: 50%;
            filter: blur(60px);
        }

        .sign-in__square {
            position: absolute;
            right: 0;
            top: 0;
            background: var(--gradient-primary);
            border-radius: 2rem;
            width: 200px;
            height: 200px;
            filter: blur(2rem);
            display: none;
        }

        .sign-in__content {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0px 0px 40px rgb(0 0 0 / 20%);
        }

        .sign-in__left {
            width: calc(100% - 500px);
            max-width: 800px;
        }

        .sign-in__left video {
            display: block;
            max-width: 100%;
        }

        .sign-in__left svg {
            max-width: 100%;
            max-height: 100vh;
        }

        .sign-in__right {
            width: 500px;
            padding: 1rem 3rem;
            border-radius: 1rem;
            background-color: #fff;
            position: relative;
            z-index: 9000;
        }

        .sign-in__logo {
            display: block;
            margin: 0 auto 2rem;
        }

        .sign-in__logo svg {
            display: block;
            margin: 0 auto;
        }

        .hform-control {
            margin-bottom: 1rem;
        }

        .hform-control label {
            display: block;
            font-weight: bold;
            font-size: 0.875rem;
            color: #777;
            margin-bottom: 0.5rem;
        }

        .hform-control__input input {
            display: block;
            width: 100%;
            padding: 1rem;
            border-radius: .5rem;
            border: 1px solid #ddd;
            background-color: transparent;
            transition: all .3s;
            outline: none;
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            color: #333333;
        }

        .hform-control__input input:hover,
        .hform-control__input input:focus {
            box-shadow: 0 0 0 1px var(--color-primary);
            border-color: var(--color-primary);
        }

        .hform-control__input--password {
            position: relative;
        }

        .hform-control__input--password input {
            padding-right: 50px;
        }

        .hform-control__input--password button {
            position: absolute;
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: transparent;
            border: 0;
            cursor: pointer;
            right: 8px;
            top: 6px;
        }

        .sign-in__button {
            display: block;
            width: 100%;
            padding: 0;
            height: 45px;
            background: var(--gradient-primary);
            font-size: 1rem;
            font-weight: 700;
            color: #ffffff;
            border: 0;
            border-radius: .5rem;
            margin-top: 1rem;
            cursor: pointer;
            position: relative;
            transition: all .3s;
            letter-spacing: 1px;
        }

        .sign-in__button svg {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translate(-30px, -50%);
            opacity: 0;
            transition: all .3s;
        }

        .sign-in__button:hover {
            letter-spacing: 2px;
        }

        .sign-in__button:hover svg {
            opacity: 1;
            transform: translate(0, -50%);
        }

        .sign-in__copyright {
            font-size: .75rem;
            color: #999;
            text-align: center;
            margin-top: 1rem;
        }

        .sign-in__copyright a {
            color: #BB254A;
            text-decoration: none;
        }

        .sign-in__social {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            margin-top: 1rem;
        }

        .sign-in__social b {
            font-size: 12px;
            color: #999;
            margin-right: 10px;
        }

        .footer__social {
            width: 24px;
            height: 24px;
            background: var(--color-primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: .625rem;
        }

        .footer__social:hover {
            color: #fff;
        }

        .footer__social svg {
            max-width: 100%;
        }

        .sign-in__info {
            font-size: .75rem;
            color: #777;
        }

        .sign-in__info p {
            margin: 0 0 .25rem;
        }

        .sign-in__info b {
            font-weight: 700;
        }

        .sign-in__info span,
        .sign-in__info a {
            color: #999999;
        }

        .hform-control__checkbox {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
            margin-bottom: 0;
        }

        .hform-control__checkbox {
            font-weight: 400 !important;
            font-size: .875rem;
            padding-left: 25px;
            position: relative;
        }

        .check-mask {
            position: absolute;
            width: 15px;
            height: 15px;
            border: 1px solid #999;
            border-radius: 2px;
            left: 0;
            top: 3px;
            transition: all .3s;
        }

        .brand-link img {
            width: 100px
        }

        .check-mask:after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 9px;
            height: 4px;
            border: 1px solid var(--color-primary);
            border-top: 0;
            border-right: 0;
            transform: rotate(-45deg) translate(-1px, 4px) scale(0);
            transition: all .3s;
            opacity: 0;
        }

        .sign-in__left {
            text-align: center;
        }

        .sign-in__left img {
            width: 80%;
            margin: 0 auto
        }

        .hform-control__checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .hform-control__checkbox input:checked~.check-mask {
            border-color: var(--color-primary);
        }

        .hform-control__checkbox input:checked~.check-mask:after {
            border-color: var(--color-primary);
            transform: rotate(-45deg) translate(-1px, 4px) scale(1);
            opacity: 1;
        }

        .forgot-password {
            font-size: 14px;
            color: var(--color-primary);
        }

        .line {
            display: block;
            height: 1px;
            position: relative;
            margin-top: 1.5rem;
        }

        .line:after {
            content: "";
            position: absolute;
            left: 50%;
            top: 0;
            width: 20%;
            height: 1px;
            background-color: #ddd;
            transform: translateX(-50%);
        }

        @-webkit-keyframes DrawLine {
            to {
                stroke-dashOffset: 0;
            }
        }

        @keyframes DrawLine {
            to {
                stroke-dashOffset: 0;
            }
        }

        @-webkit-keyframes FadeStroke {
            from {
                stroke-opacity: 1;
            }

            to {
                stroke-opacity: 0;
            }
        }

        @keyframes FadeStroke {
            from {
                stroke-opacity: 1;
            }

            to {
                stroke-opacity: 0;
            }
        }

        @-webkit-keyframes FillIn {
            to {
                fill-opacity: 1;
            }
        }

        @keyframes FillIn {
            to {
                fill-opacity: 1;
            }
        }

        .cls-11,
        .cls-12,
        .cls-13 {
            stroke-dasharray: 1100;
            stroke-dashoffset: 1100;
            fill-opacity: 0.2;
            -webkit-animation-timing-function: ease-in-out;
            animation-timing-function: ease-in-out;
            -webkit-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
            -webkit-animation-iteration-count: infinite;
            animation-iteration-count: infinite;
            -webkit-animation-name: DrawLine, FillIn;
            animation-name: DrawLine, FillIn;
            -webkit-animation-duration: 5s, 5s;
            animation-duration: 5s, 5s;
            -webkit-animation-delay: 0s, 0s;
            animation-delay: 0s, 0s;
            -webkit-animation-direction: alternate;
            animation-direction: alternate;
        }


        @media screen and (max-width: 1366px) {
            .sign-in__content {
                max-width: 915px;
            }

            .sign-in__left {
                width: 60%;
                max-width: 60%;
            }

            .sign-in__right {
                width: 40%;
            }
        }

        @media screen and (max-width: 650px) {
            .sign-in__left {
                display: none;
            }

            .sign-in__right {
                width: 100%;
                padding: 3rem 2rem
            }
        }
    </style>
</head>

<body>
    <div class="sign-in">
        <div class="sign-in__circle"></div>
        <div class="sign-in__square"></div>
        <div class="sign-in__content">
            <div class="sign-in__left">
                <img src="{{ asset('img/admin/nexty.jpg') }}" />
            </div>
            <div class="sign-in__right">
                <div class="sign-in__logo">
                    <!-- Brand Logo -->
                    <a href="" class="brand-link" style="text-align: center;width:100%;">
                      <img src="{{ asset('img/admin/logo.png') }}" />
                    </a>
                </div>
                <form class="sign-in__form" action="{{ route('admin.login') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="username" class="inp">
                            <input type="text" class="form-control for-seo" name="username" id="username"
                                placeholder="&nbsp;" value="" required="">
                            <span class="label">Tên đăng nhập</span>
                            <span class="focus-bg"></span>
                        </label>
                    </div>

                    <div class="hform-control hform-control__input--password form-group">
                        <label for="password" class="inp">
                            <input type="password" class="form-control for-seo" name="password" id="password"
                                placeholder="&nbsp;" value="" required="">
                            <span class="label">Mật khẩu</span>
                            <span class="focus-bg"></span>
                        </label>
                        <button type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 640 512">
                                <path
                                    d="M637 485.25L23 1.75A8 8 0 0 0 11.76 3l-10 12.51A8 8 0 0 0 3 26.75l614 483.5a8 8 0 0 0 11.25-1.25l10-12.51a8 8 0 0 0-1.25-11.24zM320 96a128.14 128.14 0 0 1 128 128c0 21.62-5.9 41.69-15.4 59.57l25.45 20C471.65 280.09 480 253.14 480 224c0-36.83-12.91-70.31-33.78-97.33A294.88 294.88 0 0 1 576.05 256a299.73 299.73 0 0 1-67.77 87.16l25.32 19.94c28.47-26.28 52.87-57.26 70.93-92.51a32.35 32.35 0 0 0 0-29.19C550.3 135.59 442.94 64 320 64a311.23 311.23 0 0 0-130.12 28.43l45.77 36C258.24 108.52 287.56 96 320 96zm60.86 146.83A63.15 63.15 0 0 0 320 160c-1 0-1.89.24-2.85.29a45.11 45.11 0 0 1-.24 32.19zm-217.62-49.16A154.29 154.29 0 0 0 160 224a159.39 159.39 0 0 0 226.27 145.29L356.69 346c-11.7 3.53-23.85 6-36.68 6A128.15 128.15 0 0 1 192 224c0-2.44.59-4.72.72-7.12zM320 416c-107.36 0-205.47-61.31-256-160 17.43-34 41.09-62.72 68.31-86.72l-25.86-20.37c-28.48 26.28-52.87 57.25-70.93 92.5a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448a311.25 311.25 0 0 0 130.12-28.43l-29.25-23C389.06 408.84 355.15 416 320 416z" />
                            </svg>
                        </button>
                    </div>






                    <button type="submit" class="sign-in__button">
                        <span>Đăng nhập</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            viewBox="0 0 448 512">
                            <path
                                d="M311.03 131.515l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L387.887 239H12c-6.627 0-12 5.373-12 12v10c0 6.627 5.373 12 12 12h375.887l-83.928 83.444c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l116.485-116c4.686-4.686 4.686-12.284 0-16.971L328 131.515c-4.686-4.687-12.284-4.687-16.97 0z" />
                        </svg>
                    </button>
                </form>
                <span class="line"></span>
                <div class="mt-4 sign-in__info">
                    <p style="font-style: italic; font-size: 11px">
                        Thời gian làm việc: Thứ Hai đến Thứ Sáu (08h30 – 17h30 )
                    </p>
                    <!-- <p>
            <b><span>Fanpage:</span> <a href="https://www.facebook.com/mikotechagency">Miko Tech Agency</a></b>
          </p> -->
                </div>
                <!-- <div class="sign-in__social">
          <b>Liên kết với chúng tôi:</b>
          <a target="_blank" href="https://www.facebook.com/mikotechagency" class="footer__social" rel="nofollow">
            <svg width="12" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50px"
              height="50px">
              <path
                d="M 9 4 C 6.2504839 4 4 6.2504839 4 9 L 4 41 C 4 43.749516 6.2504839 46 9 46 L 41 46 C 43.749516 46 46 43.749516 46 41 L 46 9 C 46 6.2504839 43.749516 4 41 4 L 9 4 z M 9 6 L 15.580078 6 C 12.00899 9.7156859 10 14.518083 10 19.5 C 10 24.66 12.110156 29.599844 15.910156 33.339844 C 16.030156 33.549844 16.129922 34.579531 15.669922 35.769531 C 15.379922 36.519531 14.799687 37.499141 13.679688 37.869141 C 13.249688 38.009141 12.97 38.430859 13 38.880859 C 13.03 39.330859 13.360781 39.710781 13.800781 39.800781 C 16.670781 40.370781 18.529297 39.510078 20.029297 38.830078 C 21.379297 38.210078 22.270625 37.789609 23.640625 38.349609 C 26.440625 39.439609 29.42 40 32.5 40 C 36.593685 40 40.531459 39.000731 44 37.113281 L 44 41 C 44 42.668484 42.668484 44 41 44 L 9 44 C 7.3315161 44 6 42.668484 6 41 L 6 9 C 6 7.3315161 7.3315161 6 9 6 z M 33 15 C 33.55 15 34 15.45 34 16 L 34 25 C 34 25.55 33.55 26 33 26 C 32.45 26 32 25.55 32 25 L 32 16 C 32 15.45 32.45 15 33 15 z M 18 16 L 23 16 C 23.36 16 23.700859 16.199531 23.880859 16.519531 C 24.050859 16.829531 24.039609 17.219297 23.849609 17.529297 L 19.800781 24 L 23 24 C 23.55 24 24 24.45 24 25 C 24 25.55 23.55 26 23 26 L 18 26 C 17.64 26 17.299141 25.800469 17.119141 25.480469 C 16.949141 25.170469 16.960391 24.780703 17.150391 24.470703 L 21.199219 18 L 18 18 C 17.45 18 17 17.55 17 17 C 17 16.45 17.45 16 18 16 z M 27.5 19 C 28.11 19 28.679453 19.169219 29.189453 19.449219 C 29.369453 19.189219 29.65 19 30 19 C 30.55 19 31 19.45 31 20 L 31 25 C 31 25.55 30.55 26 30 26 C 29.65 26 29.369453 25.810781 29.189453 25.550781 C 28.679453 25.830781 28.11 26 27.5 26 C 25.57 26 24 24.43 24 22.5 C 24 20.57 25.57 19 27.5 19 z M 38.5 19 C 40.43 19 42 20.57 42 22.5 C 42 24.43 40.43 26 38.5 26 C 36.57 26 35 24.43 35 22.5 C 35 20.57 36.57 19 38.5 19 z M 27.5 21 C 27.39625 21 27.29502 21.011309 27.197266 21.03125 C 27.001758 21.071133 26.819727 21.148164 26.660156 21.255859 C 26.500586 21.363555 26.363555 21.500586 26.255859 21.660156 C 26.148164 21.819727 26.071133 22.001758 26.03125 22.197266 C 26.011309 22.29502 26 22.39625 26 22.5 C 26 22.60375 26.011309 22.70498 26.03125 22.802734 C 26.051191 22.900488 26.079297 22.994219 26.117188 23.083984 C 26.155078 23.17375 26.202012 23.260059 26.255859 23.339844 C 26.309707 23.419629 26.371641 23.492734 26.439453 23.560547 C 26.507266 23.628359 26.580371 23.690293 26.660156 23.744141 C 26.819727 23.851836 27.001758 23.928867 27.197266 23.96875 C 27.29502 23.988691 27.39625 24 27.5 24 C 27.60375 24 27.70498 23.988691 27.802734 23.96875 C 28.487012 23.82916 29 23.22625 29 22.5 C 29 21.67 28.33 21 27.5 21 z M 38.5 21 C 38.39625 21 38.29502 21.011309 38.197266 21.03125 C 38.099512 21.051191 38.005781 21.079297 37.916016 21.117188 C 37.82625 21.155078 37.739941 21.202012 37.660156 21.255859 C 37.580371 21.309707 37.507266 21.371641 37.439453 21.439453 C 37.303828 21.575078 37.192969 21.736484 37.117188 21.916016 C 37.079297 22.005781 37.051191 22.099512 37.03125 22.197266 C 37.011309 22.29502 37 22.39625 37 22.5 C 37 22.60375 37.011309 22.70498 37.03125 22.802734 C 37.051191 22.900488 37.079297 22.994219 37.117188 23.083984 C 37.155078 23.17375 37.202012 23.260059 37.255859 23.339844 C 37.309707 23.419629 37.371641 23.492734 37.439453 23.560547 C 37.507266 23.628359 37.580371 23.690293 37.660156 23.744141 C 37.739941 23.797988 37.82625 23.844922 37.916016 23.882812 C 38.005781 23.920703 38.099512 23.948809 38.197266 23.96875 C 38.29502 23.988691 38.39625 24 38.5 24 C 38.60375 24 38.70498 23.988691 38.802734 23.96875 C 39.487012 23.82916 40 23.22625 40 22.5 C 40 21.67 39.33 21 38.5 21 z" />
            </svg>
          </a>
          <a target="_blank" href="https://www.facebook.com/mikotechagency" class="footer__social" rel="nofollow">
            <svg width="12" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 24 24"
              style="enable-background:new 0 0 24 24;" xml:space="preserve">
              <g id="logo">
                <g>
                  <path style="fill-rule:evenodd;clip-rule:evenodd;"
                    d="M12,0C5.24,0,0,4.952,0,11.64c0,3.498,1.434,6.522,3.769,8.61    c0.196,0.175,0.314,0.421,0.323,0.684l0.065,2.134c0.021,0.681,0.724,1.124,1.347,0.849l2.382-1.051    c0.202-0.089,0.428-0.105,0.641-0.047C9.621,23.12,10.786,23.28,12,23.28c6.76,0,12-4.952,12-11.64S18.76,0,12,0z M19.206,8.956    l-3.525,5.593c-0.561,0.89-1.762,1.111-2.603,0.48l-2.804-2.103c-0.257-0.193-0.611-0.192-0.867,0.003l-3.787,2.873    c-0.505,0.383-1.165-0.221-0.827-0.758l3.525-5.593c0.561-0.89,1.762-1.111,2.603-0.48l2.804,2.103    c0.257,0.193,0.611,0.192,0.867-0.003l3.787-2.873C18.885,7.815,19.544,8.419,19.206,8.956z" />
                </g>
              </g>
            </svg>
          </a>
        </div> -->
                <div class="sign-in__copyright">
                    Copyright &copy; 2023 <a href="" target="_blank">nexty.vn</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

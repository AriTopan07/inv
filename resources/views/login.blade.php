<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="shortcut icon" href="{{ asset('backend/static/umsida.jpg') }}" type="image/x-icon">
    <title>Login</title>
    <!-- CSS files -->
    <link href="{{ asset('backend/dist/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/tabler-flags.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/tabler-payments.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/demo.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/toastify-js/src/toastify.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        /* .card {
            border-radius: 12px !important;
        } */

        .welcome {
            font-size: 40px;
            margin-bottom: 40px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        .bg {
            background: #6a11cb;

            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>
</head>

<body class="bg">
    <script src="{{ asset('backend/dist/js/demo-theme.min.js?1684106062') }}"></script>
    <div class="page page-center">
        <div class="container container-normal py-4">
            <div class="row align-items-center g-4">
                {{-- <div class="col-lg d-lg-block">
                    <h1 class="text-center welcome">Selamat Datang di aplikasi Inventori</h1>
                    <img src="{{ asset('backend/static/illustrations/undraw_secure_login_pdn4.svg') }}" height="200"
                        class="d-none d-lg-block mx-auto" alt="">
                </div> --}}
                <div class="col-lg">
                    <div class="container-tight">
                        @include('sweetalert::alert')
                        <div class="card card-md card-borderless shadow-sm">
                            <div class="card-body">
                                <div class="text-center mb-2">
                                    <a href="." class="navbar-brand navbar-brand-autodark"><img
                                            src="{{ asset('uploads/aplikasi/' . $logo->logo) }}" height="100"
                                            alt="Logo"></a>
                                </div>
                                <h1 class="h1 mb-2">Login</h1>
                                <h5 class="text-secondary">Masukkan email dan password untuk mendapatkan akses</h5>
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" value="{{ request('email') }}" name="email"
                                            id="email" class="form-control @error('email') is-invalid @enderror"
                                            placeholder="your@email.com">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">
                                            Password
                                            <span class="form-label-description">
                                                {{-- <a href="./forgot-password.html">I forgot password</a> --}}
                                            </span>
                                        </label>
                                        <div class="input-group input-group-flat">
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Your password" autocomplete="off">
                                            <span class="input-group-text">
                                                <a href="#" onclick="showPassword()" class="link-secondary"
                                                    title="Show password" data-bs-toggle="tooltip">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path
                                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Login</button>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="hr-text">or</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <a href="#" class="btn w-100" onclick="pesan()">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-brand-google text-google"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M17.788 5.108a9 9 0 1 0 3.212 6.892h-8"></path>
                                            </svg>
                                            Login with Google
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        {{-- <div class="text-center text-light mt-3">
                            Belum punya akun? <a href="#" class="text-decoration-none text-light"
                                onclick="pesan()" tabindex="-1">Hubungi admin</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <script src="{{ asset('backend/dist/libs/apexcharts/dist/apexcharts.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/libs/jsvectormap/dist/maps/world.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/libs/jsvectormap/dist/maps/world-merc.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/toastify-js/src/toastify.js') }}"></script>
    <!-- Tabler Core -->
    <script src="{{ asset('backend/dist/js/tabler.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/js/demo.min.js?1684106062') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.js"></script>

    <script>
        function showPassword() {
            const input = document.getElementById('password')
            const type = input.getAttribute('type')

            if (type == 'text') {
                input.setAttribute('type', 'password')
            } else(
                input.setAttribute('type', 'text')
            )
        }

        function pesan() {
            Swal.fire({
                title: 'Informasi!',
                text: 'Mohon maaf,  Fitur belum tersedia. Hubungi admin untuk mendapatkan akun',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>
    <script>
        function message(title, success = 'true') {
            Toastify({
                text: title,
                duration: 7000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: (success) ? "#61876E" : "#F55050",
            }).showToast();
        }
    </script>
    @if (session()->has('message'))
        @php
            $message = Session::get('message');
        @endphp
        <script>
            Toastify({
                text: "{{ $message['content'] }}",
                duration: 7000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: ("{{ $message['type'] }}" == 'success') ? "#61876E" : "#F55050",
            }).showToast();
        </script>
    @endif
</body>

</html>

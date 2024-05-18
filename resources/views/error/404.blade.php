<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>404 - Not Found</title>
    <!-- CSS files -->
    <link href="{{ asset('backend/dist/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/tabler-flags.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/tabler-payments.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/demo.min.css?1684106062') }}" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" border-top-wide border-primary d-flex flex-column">
    <script src="{{ asset('backend/dist/js/demo-theme.min.js?1684106062') }}"></script>
    <div class="page page-center">
        <div class="container-tight py-4 mt-5">
            <div class="empty mt-5">
                <div class="empty-header mt-5">404</div>
                <p class="empty-subtitle text-muted">
                    Mohon maaf, halaman tidak ditemukan
                </p>
                <div class="empty-action">
                    <a href="{{ route('home.index') }}" class="btn btn-primary">
                        Bawa aku pulang
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('backend/dist/js/tabler.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/js/demo.min.js?1684106062') }}" defer></script>
</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="shortcut icon" href="{{ asset('uploads/aplikasi/' . $favicon->favicon) }}" type="image/x-icon">
    <title>{{ $title->title }}</title>

    <!-- CSS files -->
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="{{ asset('backend/dist/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/tabler-flags.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/tabler-payments.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/demo.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/toastify-js/src/toastify.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/libs/dropzone/dist/dropzone.css?1695847769') }}" rel="stylesheet" />
    <link href="{{ asset('admin-assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

    {{-- CDN --}}
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.1/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <script src="{{ asset('backend/dist/js/demo-theme.min.js?1684106062') }}"></script>
    <div class="page">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        @include('layouts.header')

        <div class="page-wrapper">
            <!-- Page body -->
            @yield('content')
            @include('layouts.alert')
            @include('sweetalert::alert')
            @include('layouts.footer')
        </div>
    </div>

    <!-- Libs JS -->
    <script src="{{ asset('backend/dist/libs/apexcharts/dist/apexcharts.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/libs/jsvectormap/dist/maps/world.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/libs/jsvectormap/dist/maps/world-merc.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/toastify-js/src/toastify.js') }}"></script>
    <script src="{{ asset('backend/dist/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('backend/dist/libs/dropzone/dist/dropzone-min.js?1695847769') }}"></script>

    <!-- Tabler Core -->
    <script src="{{ asset('backend/dist/js/tabler.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('backend/dist/js/demo.min.js?1684106062') }}" defer></script>

    {{-- CDN --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>
    <script>
        $(document).ready(function() {
            // Check if there is data in the table
            if ($('#datatables thead tbody tr td').length > 0) {
                $('#datatables').DataTable({});
            }
        });

        $(document).ready(function() {
            // Check if there is data in the table
            if ($('#datatables1 thead tbody tr td').length > 0) {
                $('#datatables1').DataTable({});
            }

            $(document).ready(function() {
                $('#datatables').DataTable();
            })

            $(document).ready(function() {
                $('#datatables1').DataTable();
            })
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
        });
    </script>
    @yield('customJs')
</body>

</html>

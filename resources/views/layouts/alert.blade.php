<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (Session::has('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
        });
    </script>
@endif

@if (Session::has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
        });
    </script>
@endif

@if (Session::has('warning'))
    <script type="text/javascript">
        window.onload = function() {
            @if (Session::has('warning'))
                Swal.fire({
                    icon: 'warning',
                    text: '{{ Session::get('warning') }}',
                    onClose: () => {
                        window.close();
                    }
                }).then((result) => {
                    if (!result.dismiss) {
                        window.close();
                    }
                });
            @endif
        }
    </script>
@endif

@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Data Pengguna
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Pengguna</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-sm-12">
                        <div class="card card-borderless">
                            <div class="card-status-top bg-primary"></div>
                            <div class="card-header">
                                <div class="card-actions">
                                    @if (NavHelper::cekAkses(Auth::user()->id, 'User', 'add') == true)
                                        <button type="button" class="btn btn-primary d-sm-inline-block fw-bold"
                                            data-bs-toggle="modal" data-bs-target="#modal_add">Tambah
                                            User</button>
                                    @endif
                                    @include('user.create')
                                </div>
                            </div>
                            <div class="card-body table-responsive" id="dynamic_content">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
@section('customJs')
    <script>
        $(document).ready(function() {

            $('#dynamic_content').html(generate_loader());

            // Jalankan fungsi load_content setelah jeda 2 detik
            setTimeout(function() {
                load_content();
            }, 1500);

            function generate_loader() {
                var output = '';
                for (var count = 0; count < 6; count++) {
                    output += '<p class="placeholder-glow">';
                    output += '<span class="placeholder col-12">';
                    output += '</span>';
                    output += '</p>';
                }
                return output;
            }

            function load_content() {
                // Gantilah kontennya sesuai kebutuhan
                var newContent = `
                                <table class="table" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Group</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->role }}</td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <span class="status status-green">
                                                            <span class="status-dot status-dot-animated"></span>
                                                            Aktif
                                                        </span>
                                                    @else
                                                        <span class="status status-red">
                                                            <span class="status-dot"></span>
                                                            Nonaktif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'User', 'edit') == true)
                                                        <a href="{{ route('change-status', ['id' => $item->id]) }}"
                                                            class="btn btn-primary btn-icon" title="Ubah Status">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </a>
                                                    @endif
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'User', 'delete') == true)
                                                        <button onclick="deletes({{ $item->id }})"
                                                            class="btn btn-danger btn-icon fw-bold" title="Hapus">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>`;
                // Perbarui kontennya
                $('#dynamic_content').html(newContent);
            }
        });
    </script>
    <script>
        function deletes(id) {
            let url = '{{ route('user.delete', 'ID') }}';
            let newUrl = url.replace('ID', id);

            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Anda tidak dapat mengembalikannya setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: newUrl,
                        type: 'delete',
                        data: {},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(results) {
                            swal.fire("Done!", results.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    });
                }
            });
        }

        $(document).ready(function() {

            $(document).on('click', '#edit', function() {
                let id = $(this).val();
                $('#modal_edit').modal('show');

                $.ajax({
                    url: 'user/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#id').val(response.data.id);
                            $('#name').val(response.data.name);
                            $('#email').val(response.data.email);
                        }
                    }
                });
            });

            $('#modal_edit').submit(function(event) {
                event.preventDefault();

                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                let id = $('#id').val();
                let formData = {
                    '_token': csrfToken,
                    'id': id,
                    'nis': $('#nis').val(),
                    'name': $('#name').val(),
                    'email': $('#email').val(),
                    'current_password': $('#current_password').val(),
                    'new_password': $('#new_password').val(),
                    'new_password_confirmation': $('#new_password_confirmation').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'user/' + id,
                    data: formData,
                    dataType: 'json',
                    success: function(results) {
                        if (results.success === true) {
                            swal.fire("Done!", results.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            swal.fire("Error!", results.message, "error");
                        }
                    }
                });
            });
        });
    </script>
@endsection
@endsection

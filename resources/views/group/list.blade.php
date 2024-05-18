@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Data Group
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Group</li>
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
                        <div class="card card-borderless shadow-sm">
                            <div class="card-header">
                                <div class="card-actions">
                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Group', 'add') == true)
                                        <button type="button" class="btn btn-primary d-sm-inline-block fw-bold"
                                            data-bs-toggle="modal" data-bs-target="#modal_add">Tambah
                                            Group</button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <!-- Default Table -->
                                <table class="table table-hover table-vcenter" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Deskripsi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    <a href="{{ route('permission.data-akses', ['id' => $item->id]) }}"
                                                        class="btn btn-dark btn-icon" title="Atur Akses"><i
                                                            class="bi bi-gear"></i></a>
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Group', 'delete') == true)
                                                        <button onclick="deletes({{ $item->id }})" type="button"
                                                            class="btn btn-danger btn-icon"><i class="bi bi-trash3"
                                                                title="Hapus"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @include('group.edit')
                                @include('group.create')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
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
                            $('#password').val(response.data.password);
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
                    'password': $('#password').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'user/' + id,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        message(data.message, data.success);
                        $('#modal_edit').modal('hide');
                        window.location.reload();
                    }
                });
            });
        });

        function deletes(id) {
            let url = '{{ route('group.delete', 'ID') }}';
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
                }
            });
        }
    </script>
@endsection

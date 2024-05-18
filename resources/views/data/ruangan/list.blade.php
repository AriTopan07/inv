@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Ruangan
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ruangan</li>
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
                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Ruangan', 'add') == true)
                                        <button type="button" class="btn btn-primary d-sm-inline-block fw-bold"
                                            data-bs-toggle="modal" data-bs-target="#modal_add">Tambah
                                            Ruangan</button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <!-- Default Table -->
                                <table class="table table-hover table-vcenter" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ruangan</th>
                                            <th>Deskripsi</th>
                                            <th>Dibuat</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['ruangan'] as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->deskripsi }}</td>
                                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <form class="statusForm">
                                                        @csrf
                                                        <input type="hidden" value="{{ $item->id }}" name="id_ruangan">
                                                        <input type="checkbox" class="form-check-input status-checkbox"
                                                            name="status" {{ $item->status == 1 ? 'checked' : '' }}>
                                                    </form>
                                                </td>
                                                <td>
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Ruangan', 'edit') == true)
                                                        <button value="{{ $item->id }}" type="button"
                                                            class="btn btn-primary btn-sm btn-icon" id="edit"
                                                            data-bs-toggle="modal" data-bs-target="#modalEdit"><i
                                                                class="bi bi-pencil" title="Edit"></i></button>
                                                    @endif
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Ruangan', 'delete') == true)
                                                        <button onclick="deletes({{ $item->id }})"
                                                            class="btn btn-danger btn-sm btn-icon fw-bold" title="Hapus">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @include('data.ruangan.edit')
                                @include('data.ruangan.create')
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
        function deletes(id) {
            let url = '{{ route('ruangan.delete', 'ID') }}';
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
                            if (results.status === true) {
                                setTimeout(function() {
                                    location.reload();
                                }, 50);
                            } else {
                                setTimeout(function() {
                                    location.reload();
                                }, 50);
                            }
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            $('.status-checkbox').change(function() {
                var status = this.checked ? 1 : 0;
                var formData = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status,
                    id_ruangan: $(this).closest('form.statusForm').find('[name="id_ruangan"]').val()
                };

                $.ajax({
                    url: '/ruangan-status',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        console.log(formData);
                        Toast.fire({
                            icon: 'success',
                            text: data.message,
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('There was an error!', error);
                    }
                });
            });
        });

        $(document).ready(function() {

            $(document).on('click', '#edit', function() {
                let id = $(this).val();
                $('#modalEdit').modal('show');

                $.ajax({
                    url: 'ruangan/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.status) {
                            $('#id').val(response.data.id);
                            $('#edit_nama').val(response.data.nama);
                            $('#edit_deskripsi').val(response.data.deskripsi);
                        }
                    }
                });
            });

            $('#modalEdit').submit(function(event) {
                event.preventDefault();

                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                let id = $('#id').val();
                let formData = {
                    '_token': csrfToken,
                    'id': id,
                    'edit_nama': $('#edit_nama').val(),
                    'edit_deskripsi': $('#edit_deskripsi').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'ruangan/' + id,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === true) {
                            setTimeout(function() {
                                location.reload();
                            }, 50);
                        } else {
                            setTimeout(function() {
                                location.reload();
                            }, 50);
                        }
                    }
                });
            });
        });

        function pesan() {
            Swal.fire({
                title: 'Informasi!',
                text: 'Mohon maaf, Fitur belum tersedia, anda tidak dapat mangakses Fitur ini.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>
@endsection

@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Barang Masuk
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Barang Masuk</li>
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
                                <div class="row">
                                    <ul class="nav nav-tabs" data-bs-toggle="tabs">
                                        <li class="nav-item">
                                            <a href="#tabs-home-1" class="nav-link active fw-bold" data-bs-toggle="tab">
                                                Permintaan Barang Masuk
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tabs-profile-1" class="nav-link fw-bold" data-bs-toggle="tab">
                                                Barang Diterima
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-actions">
                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Barang Masuk', 'verification') == true)
                                        <button onclick="verifiedAll()" class="btn btn-success">Verifikasi semua
                                            data</button>
                                    @endif
                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Barang Masuk', 'add') == true)
                                        <a href="{{ route('barang.create') }}">
                                            <button type="button" class="btn btn-primary d-sm-inline-block fw-bold">
                                                Tambah Barang
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-home-1">
                                    <div class="card-body table-responsive">
                                        <h3>Tabel permintaan barang masuk</h3>
                                        <table class="table table-hover table-vcenter" id="">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal Dibuat</th>
                                                    <th>Dibuat Oleh</th>
                                                    <th>Diedit Oleh</th>
                                                    <th>Verifikasi</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['barang'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                        <td>{{ $item->createdBy->name }}</td>
                                                        <td>
                                                            @if (!empty($item->updatedBy))
                                                                {{ $item->updatedBy->name }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>{!! $item->verified == 1
                                                            ? '<span class="badge bg-success">Terverifikasi</span>'
                                                            : '<span class="badge bg-danger">Belum diverifikasi</span>' !!}</td>
                                                        <td>
                                                            <form class="statusForm">
                                                                @csrf
                                                                <input type="hidden" value="{{ $item->id }}"
                                                                    name="id_barang">
                                                                <input type="checkbox"
                                                                    class="form-check-input status-checkbox" name="status"
                                                                    {{ $item->status == 1 ? 'checked' : '' }}>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Barang Masuk', 'detail') == true)
                                                                <a href="{{ route('barang.detail', $item->id) }}"
                                                                    class="btn btn-success btn-sm btn-icon" title="Detail">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                            @endif
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Barang Masuk', 'edit') == true)
                                                                <a href="{{ route('barang.edit', $item->id) }}"
                                                                    class="btn btn-primary btn-sm btn-icon" title="Edit">
                                                                    <i class="bi bi-pen"></i>
                                                                </a>
                                                            @endif
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Barang Masuk', 'delete') == true)
                                                                <button onclick="deletes({{ $item->id }})"
                                                                    class="btn btn-danger btn-sm btn-icon fw-bold"
                                                                    title="Delete">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-profile-1">
                                    <div class="card-body table-responsive">
                                        <h3>Tabel permintaan barang masuk yang telah diterima</h3>
                                        <table class="table table-hover table-vcenter" id="datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal Dibuat</th>
                                                    <th>Dibuat Oleh</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['acc_barang'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                        <td>{{ $item->createdBy->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        function verifiedAll() {
            Swal.fire({
                title: 'Verifikasi semua data ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Verif!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('barang.verified-all') }}',
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === true) {
                                location.reload();
                            } else {
                                Swal.fire('Gagal', 'Gagal memverifikasi semua data', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Terjadi kesalahan. Mohon coba lagi.', 'error');
                        }
                    });
                }
            });
        }

        function deletes(id) {
            let url = '{{ route('barang.delete', ':id') }}';
            let newUrl = url.replace(':id', id);

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
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(results) {
                            if (results.status === true) {
                                location.reload();
                            } else {
                                location.reload();
                            }
                        },
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
                    id_barang: $(this).closest('form.statusForm').find('[name="id_barang"]').val()
                };

                $.ajax({
                    url: '/barang-status',
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
                    url: 'kategori/' + id,
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
                    url: 'kategori/' + id,
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

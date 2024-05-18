@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Barang Keluar
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Barang Keluar</li>
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
                                                Permintaan Barang Keluar
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tabs-profile-1" class="nav-link fw-bold" data-bs-toggle="tab">
                                                Barang Diterima
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-home-1">
                                    <div class="card-body table-responsive">
                                        <h3>Tabel permintaan barang keluar</h3>
                                        <table class="table table-hover table-vcenter" id="">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Barang</th>
                                                    <th>Tanggal Dibuat</th>
                                                    <th>Keterangan</th>
                                                    <th>Dikeluarkan Oleh</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['barang_keluar'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_barang }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                        <td>{{ $item->keterangan }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Barang Keluar', 'detail') == true)
                                                                <button class="btn btn-success btn-sm" type="button"
                                                                    onclick="return terima({{ $item->id }})"
                                                                    title="Terima">Terima</button>
                                                            @endif
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Barang Keluar', 'edit') == true)
                                                                <button class="btn btn-danger btn-sm" type="button"
                                                                    onclick="return tolak({{ $item->id }})"
                                                                    title="Tolak">Tolak</button>
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
                                        <h3>Tabel permintaan barang keluar yang telah diterima</h3>
                                        <table class="table table-hover table-vcenter" id="datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Barang</th>
                                                    <th>Tanggal Dibuat</th>
                                                    <th>Keterangan</th>
                                                    <th>Dikeluarkan Oleh</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['acc_barang_keluar'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_barang }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                        <td>{{ $item->keterangan }}</td>
                                                        <td>{{ $item->name }}</td>
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

        function terima(id) {
            let url = '{{ route('barang-keluar.terima', ':id') }}';
            let newUrl = url.replace(':id', id);

            console.log(id);

            Swal.fire({
                title: 'Terima barang keluar ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: newUrl,
                        type: 'POST',
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

        function tolak(id) {
            let url = '{{ route('keluar.tolak', ':id') }}';
            let newUrl = url.replace(':id', id);

            console.log(id);

            Swal.fire({
                title: 'Tolak barang keluar ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: newUrl,
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(results) {
                            if (results.status === true) {
                                location.reload();
                                console.log(results);
                            } else {
                                console.log(results);
                                location.reload();
                            }
                        },
                    });
                }
            });
        }
    </script>
@endsection

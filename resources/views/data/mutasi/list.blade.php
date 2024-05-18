@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Mutasi Barang
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Mutasi Barang</li>
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
                                <ul class="nav nav-tabs" data-bs-toggle="tabs">
                                    <li class="nav-item">
                                        <a href="#tabs-home-1" class="nav-link active fw-bold" data-bs-toggle="tab">
                                            Permintaan Mutasi
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tabs-profile-1" class="nav-link fw-bold" data-bs-toggle="tab">
                                            Mutasi diterima
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-home-1">
                                    <div class="card-body table-responsive">
                                        <h3>Tabel permintaan mutasi barang</h3>
                                        <table class="table table-hover table-vcenter" id="">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Barang</th>
                                                    <th>Ruangan Asal</th>
                                                    <th>Ruangan Tujuan</th>
                                                    <th>Tanggal Mutasi</th>
                                                    <th>Dimutasi Oleh</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['mutasi'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_barang }}</td>
                                                        <td>{{ $item->ruangan_asal }}</td>
                                                        <td>{{ $item->ruangan_tujuan }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Mutasi Barang', 'verification') == true)
                                                                <button class="btn btn-success btn-sm" type="button"
                                                                    onclick="return terima({{ $item->id }})"
                                                                    title="Terima">Terima</button>
                                                            @endif
                                                            @if (NavHelper::cekAkses(Auth::user()->id, 'Mutasi Barang', 'verification') == true)
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
                                        <h3>Tabel mutasi barang yang telah di terima</h3>
                                        <table class="table table-hover table-vcenter" id="datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Barang</th>
                                                    <th>Ruangan Asal</th>
                                                    <th>Ruangan Tujuan</th>
                                                    <th>Tanggal Mutasi</th>
                                                    <th>Dimutasi Oleh</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['acc_mutasi'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_barang }}</td>
                                                        <td>{{ $item->ruangan_asal }}</td>
                                                        <td>{{ $item->ruangan_tujuan }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
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
        function terima(id) {
            let url = '{{ route('mutasi-barang.terima', ':id') }}';
            let newUrl = url.replace(':id', id);

            console.log(id);

            Swal.fire({
                title: 'Terima mutasi ?',
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
            let url = '{{ route('mutasi-barang.tolak', ':id') }}';
            let newUrl = url.replace(':id', id);

            console.log(id);

            Swal.fire({
                title: 'Tolak mutasi ?',
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
                            } else {
                                location.reload();
                            }
                        },
                    });
                }
            });
        }

        function verifiedAll() {
            Swal.fire({
                title: 'Verifikasi semua data ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Terima',
                cancelButtonText: 'Tolak',
                cancelButtonColor: '#d33',
                showCloseButton: true,
                closeButtonText: 'Close',
                showConfirmButton: true,
                customClass: {
                    confirmButton: 'swal-button-accept',
                    cancelButton: 'swal-button-reject',
                    closeButton: 'swal-button-close'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika tombol "Terima" ditekan
                    // Lakukan sesuatu di sini
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Jika tombol "Tolak" ditekan
                    // Lakukan sesuatu di sini
                } else {
                    // Jika tombol "Close" ditekan
                    // Lakukan sesuatu di sini
                }
            });
        }
    </script>
@endsection

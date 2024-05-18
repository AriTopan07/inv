@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Laporan
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Laporan</li>
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
                                    {{-- @if (NavHelper::cekAkses(Auth::user()->id, 'Ruangan', 'add') == true)
                                        <button type="button" class="btn btn-primary d-sm-inline-block fw-bold"
                                            data-bs-toggle="modal" data-bs-target="#modal_add">Tambah
                                            Ruangan</button>
                                    @endif --}}
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <h4>Filter range</h4>
                                <div class="col-md-6 d-flex">
                                    <div>
                                        <small for="">Tanggal Awal</small>
                                        <input type="date" name="date_start" id="date_start" class="form-control"
                                            placeholder="Tanggal Awal">
                                    </div>
                                    <div class="ms-2">
                                        <small for="">Tanggal Akhir</small>
                                        <input type="date" name="date_end" id="date_end" class="form-control">
                                    </div>
                                </div>
                                <!-- Default Table -->
                                <table class="table table-hover table-vcenter mt-4" id="">
                                    <thead>
                                        <tr>
                                            <th width="100px">No.</th>
                                            <th>Nama Laporan</th>
                                            <th width="400px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Barang Masuk</td>
                                            <td>
                                                <button class="btn btn-success" onclick="export_excel('barang_masuk')">
                                                    Download Excel
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Barang Keluar</td>
                                            <td>
                                                <button class="btn btn-success" onclick="export_excel('barang_keluar')">
                                                    Download Excel
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Mutasi Barang</td>
                                            <td>
                                                <button class="btn btn-success" onclick="export_excel('mutasi_barang')">
                                                    Download Excel
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
        function export_excel(params) {
            let date_start = $('#date_start').val();
            let date_end = $('#date_end').val();

            if (date_start == null || date_start == "") {
                Toast.fire({
                    icon: 'warning',
                    title: 'Tanggal awal belum diisi!'
                })
                return;
            }
            if (date_end == null || date_end == "") {
                Toast.fire({
                    icon: 'warning',
                    title: 'Tanggal akhir belum diisi!'
                })
                return;
            }

            let url;

            if (params === 'barang_masuk') {
                url = "{{ route('laporan.excel', ['masuk', ':date_start', ':date_end']) }}";
            } else if (params === 'barang_keluar') {
                url = "{{ route('laporan.excel', ['keluar', ':date_start', ':date_end']) }}";
            } else if (params === 'mutasi_barang') {
                url = "{{ route('laporan.excel', ['mutasi', ':date_start', ':date_end']) }}";
            }

            url = url.replace(':date_start', date_start);
            url = url.replace(':date_end', date_end);

            window.open(url);
            console.log(url);
        }
    </script>
@endsection

@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Barang
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Detail Barang</li>
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
                        <div class="card card-borderless shadow-sm table-responsive">
                            <div class="card-header">
                                <div class="page-title">
                                    <h2>Detail Barang</h2>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Barang Masuk', 'verification') == true)
                                        @if ($data['barang']->verified == 0)
                                            <div class="col-sm-12">
                                                <button class="btn btn-success mt-3 float-end" type="button"
                                                    onclick="return verifikasi({{ $data['barang']->id }})"
                                                    title="Send">Verifikasi</button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <table class="table-responsive mt-3">
                                            <tr>
                                                <td>{!! DNS2D::getBarcodeHTML('$ ' . $data['barang']->barcode, 'QRCODE', 6, 6) !!}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table-responsive mt-3">
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">Ruangan</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ $data['barang']->ruangan->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">Kategori</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ $data['barang']->kategori->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">Nama Barang</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ $data['barang']->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">Merk</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ $data['barang']->merk }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">Tipe</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ $data['barang']->tipe }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">No Seri</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ $data['barang']->no_seri }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">Harga</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ NavHelper::rupiah($data['barang']->harga) }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">Jumlah</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ $data['barang']->qty }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">Kondisi</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ $data['barang']->kondisi }}</td>
                                            </tr>
                                            <tr>
                                                <td width="150px">
                                                    <li class="fw-bold">Deskripsi</li>
                                                </td>
                                                <td width="20px" class="fw-bold">:</td>
                                                <td>{{ $data['barang']->deskripsi }}</td>
                                            </tr>
                                        </table>
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
            function verifikasi(id) {
                let url = '{{ route('barang.verified', ':id') }}';
                let newUrl = url.replace(':id', id);

                Swal.fire({
                    title: 'Verifikasi data ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Verif!'
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
        </script>
    @endsection

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
                            <li class="breadcrumb-item active">Edit Barang</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <button onclick="window.history.back()" class="btn btn-secondary mb-3">Kembali</button>
                <div class="row row-deck row-cards">
                    <div class="col-sm-12">
                        <div class="card card-borderless shadow-sm">
                            <div class="card-header">
                                <div class="page-title">
                                    <h2>Edit Barang</h2>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <form method="POST" action="{{ route('inventaris.update-barang', $data['barang']->id) }}"
                                    id="barangForm" name="barangForm">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="ruangan_id" class="col-form-label">Ruangan</label>
                                            <select class="form-control" name="ruangan_id" id="ruangan_id">
                                                <option value="">Pilih ruangan</option>
                                                @foreach ($data['ruangan'] as $ruangan)
                                                    <option value="{{ $ruangan->id }}"
                                                        {{ $ruangan->id == $data['barang']->ruangan_id ? 'selected' : '' }}>
                                                        {{ $ruangan->nama }}</option>
                                                @endforeach
                                            </select>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kategori_id" class="col-form-label">kategori</label>
                                            <select class="form-control" name="kategori_id" id="kategori_id">
                                                <option value="">Pilih kategori</option>
                                                @foreach ($data['kategori'] as $kategori)
                                                    <option value="{{ $kategori->id }}"
                                                        {{ $kategori->id == $data['barang']->kategori_id ? 'selected' : '' }}>
                                                        {{ $kategori->nama }}</option>
                                                @endforeach
                                            </select>

                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="image" class="col-form-label">Gambar</label>
                                            <input type="hidden" id="image_id" name="image_id" value="">
                                            <input type="file" name="image" id="image" class="form-control">
                                            <p class="mt-2 text-warning">*Kosongkan jika tidak memperbarui gambar</p>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="nama" class="col-form-label">Nama Barang</label>
                                            <input type="text" name="nama" id="nama" class="form-control"
                                                value="{{ $data['barang']->nama }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="merk" class="col-form-label">Merk</label>
                                            <input type="text" name="merk" id="merk" class="form-control"
                                                value="{{ $data['barang']->merk }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="tipe" class="col-form-label">Tipe</label>
                                            <input type="text" name="tipe" id="tipe" class="form-control"
                                                value="{{ $data['barang']->tipe }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="no_seri" class="col-form-label">No Seri</label>
                                            <input type="text" name="no_seri" id="no_seri" class="form-control"
                                                value="{{ $data['barang']->no_seri }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="harga" class="col-form-label">Harga</label>
                                            <input type="text" name="harga" id="harga" class="form-control"
                                                value="{{ $data['barang']->harga }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="qty" class="col-form-label">Jumlah</label>
                                            <input type="text" name="jumlah" id="jumlah" class="form-control"
                                                value="{{ $data['barang']->qty }}">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kondisi" class="col-form-label">Kondisi</label>
                                            <select class="form-control" name="kondisi" id="kondisi">
                                                <option value="baik"
                                                    {{ $data['barang']->kondisi == 'baik' ? 'selected' : '' }}>Baik
                                                </option>
                                                <option value="cukup baik"
                                                    {{ $data['barang']->kondisi == 'cukup baik' ? 'selected' : '' }}>Cukup
                                                    Baik</option>
                                                <option value="rusak"
                                                    {{ $data['barang']->kondisi == 'rusak' ? 'selected' : '' }}>Rusak
                                                </option>
                                            </select>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="deskripsi" class="col-form-label">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10">{{ $data['barang']->deskripsi }}</textarea>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary mt-3 float-end" type="button"
                                                onclick="return confirm()" title="Send">Simpan</button>
                                        </div>
                                    </div>
                                </form>
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
                // Initialize file input change event for either favicon or logo
                $('#image').on('change', function() {
                    uploadImage(this.files[0]);
                });

                function uploadImage(file) {
                    var formData = new FormData();
                    formData.append('image', file);
                    console.log(formData);

                    $.ajax({
                        url: "{{ route('temp-images.create') }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            $("#image_id").val(response['image_id']);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });

            function confirm() {
                Swal.fire({
                    title: 'Simpan data ?',
                    text: 'Anda yakin ingin menyimpan perubahan ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#barangForm').submit();
                    }
                });
            }
        </script>
    @endsection

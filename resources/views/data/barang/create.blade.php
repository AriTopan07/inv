@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Tambah Barang
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tambah Barang</li>
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
                                    <h2>Form Tambah Barang</h2>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <form method="POST" action="{{ route('barang.store') }}" id="createBarang"
                                    name="createBarang">
                                    @method('POST')
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="ruangan_id" class="col-form-label">Ruangan</label>
                                            <select class="form-control" name="ruangan_id" id="ruangan_id">
                                                <option value="">Pilih ruangan</option>
                                                @foreach ($data['ruangan'] as $ruangan)
                                                    <option value="{{ $ruangan->id }}">{{ $ruangan->nama }}</option>
                                                @endforeach
                                            </select>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kategori_id" class="col-form-label">kategori</label>
                                            <select class="form-control" name="kategori_id" id="kategori_id">
                                                <option value="">Pilih kategori</option>
                                                @foreach ($data['kategori'] as $kategori)
                                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                                @endforeach
                                            </select>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="image" class="col-form-label">Gambar</label>
                                            <input type="hidden" id="image_id" name="image_id" value="">
                                            <input type="file" name="image" id="image" class="form-control"
                                                accept="image/png,image/jpeg,image/jpg" capture>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="nama" class="col-form-label">Nama Barang</label>
                                            <input type="text" name="nama" id="nama" class="form-control">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="merk" class="col-form-label">Merk</label>
                                            <input type="text" name="merk" id="merk" class="form-control">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="tipe" class="col-form-label">Tipe</label>
                                            <input type="text" name="tipe" id="tipe" class="form-control">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="no_seri" class="col-form-label">No Seri</label>
                                            <input type="text" name="no_seri" id="no_seri" class="form-control">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="harga" class="col-form-label">Harga</label>
                                            <input type="text" name="harga" id="harga" class="form-control">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="qty" class="col-form-label">Jumlah</label>
                                            <input type="text" name="jumlah" id="jumlah" class="form-control">
                                            <p class="invalid-feedback"></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kondisi" class="col-form-label">Kondisi</label>
                                            <select class="form-control" name="kondisi" id="kondisi">
                                                <option value="baik">Baik</option>
                                                <option value="cukup baik">Cukup Baik</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="deskripsi" class="col-form-label">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea>
                                            <p class="invalid-feedback"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" value="Simpan"
                                                class="btn btn-primary fw-bold mt-3 float-end">Buat</button>
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

            $(document).ready(function() {
                $('#createBarang').submit(function(event) {
                    event.preventDefault();
                    let formData = $(this).serialize();
                    $("button[type='submit']").prop('disabled', true);

                    let spinnerHtml =
                        '<div class="spinner-border text-light" role="status"><span class="visually-hidden">Loading...</span></div>';
                    $("button[type='submit']").html(spinnerHtml);


                    $.ajax({
                        url: '{{ route('barang.store') }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $("button[type='submit']").prop('disabled', false);

                            // Hapus elemen spinner
                            $("button[type='submit']").html('Buat');
                            if (data['success'] == true) {

                                $('.invalid-feedback').removeClass('invalid-feedback').html('');
                                $("input[type='text'], select, input[type='number'], input[type='file']")
                                    .removeClass(
                                        'is-invalid');

                                window.location.href = '{{ route('barang.index') }}'

                            } else {

                                $('.invalid-feedback').removeClass('invalid-feedback').html('');
                                $("input[type='text'], select, input[type='number'], input[type='file']")
                                    .removeClass(
                                        'is-invalid');

                                $.each(data.errors, function(field, errorMessage) {
                                    $("#" + field).addClass('is-invalid')
                                        .siblings('p')
                                        .addClass('invalid-feedback')
                                        .html(errorMessage[
                                            0
                                        ]);
                                });
                            }
                        },
                        error: function() {
                            console.log('terjadi kesalahan');
                        }
                    });
                });
            });
        </script>
    @endsection

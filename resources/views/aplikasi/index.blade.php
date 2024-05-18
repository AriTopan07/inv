@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Pengaturan Aplikasi
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-sm-12">
                        <div class="card card-borderless shadow-sm">
                            <div class="card-body">
                                <div class="tab-content table-responsive">
                                    <form action="{{ route('pengaturan-aplikasi.update') }}" method="POST">
                                        @csrf
                                        <div class="tab-pane active show" id="tabs-home-1">
                                            <table class="table table-hover table-vcenter">
                                                <tr>
                                                    <th width="150px">Title</th>
                                                    <th width="20px">:</th>
                                                    <th>
                                                        <input type="text" class="form-control" name="title"
                                                            id="title" value="{{ $data->title }}">
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th width="150px">Favicon</th>
                                                    <th width="20px">:</th>
                                                    <th>
                                                        <img src="{{ asset('uploads/aplikasi/' . $data->favicon) }}"
                                                            height="55" alt="favicon">
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th width="150px">Favicon Update</th>
                                                    <th width="20px">:</th>
                                                    <th>
                                                        <input type="hidden" id="favicon_id" name="favicon_id"
                                                            value="">
                                                        <input name="favicon" id="favicon" type="file"
                                                            class="form-control" />
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th width="150px">Logo</th>
                                                    <th width="20px">:</th>
                                                    <th>
                                                        <img src="{{ asset('uploads/aplikasi/' . $data->logo) }}"
                                                            height="55" alt="logo">
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th width="150px">Logo Update</th>
                                                    <th width="20px">:</th>
                                                    <th>
                                                        <input type="hidden" id="logo_id" name="logo_id" value="">
                                                        <input name="logo" id="logo" type="file"
                                                            class="form-control" />
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th width="150px">Footer</th>
                                                    <th width="20px">:</th>
                                                    <th>
                                                        <input type="text" class="form-control" name="footer"
                                                            id="footer" value="{{ $data->footer }}">
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th width="150px">Sidebar</th>
                                                    <th width="20px">:</th>
                                                    <th>
                                                        <select name="sidebar" id="sidebar" class="form-control">
                                                            <option value="light"
                                                                @if ($data->sidebar === 'light') selected @endif>Light
                                                            </option>
                                                            <option value="dark"
                                                                @if ($data->sidebar === 'dark') selected @endif>Dark
                                                            </option>
                                                        </select>
                                                    </th>
                                                </tr>
                                            </table>
                                            <button class="btn btn-primary mt-3 w-100">Simpan Perubahan</button>
                                        </div>
                                    </form>
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
                // Initialize file input change events for both favicon and logo
                $('#favicon, #logo').on('change', function() {
                    let type = $(this).attr('id');
                    uploadImage(this.files[0], type);
                });

                function uploadImage(file, type) {
                    var formData = new FormData();
                    formData.append(type, file);

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
                            $("#" + type + "_id").val(response[type + '_id']);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        </script>
    @endsection

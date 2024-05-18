@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Data Menu
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Menu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div>
                        @if (NavHelper::cekAkses(Auth::user()->id, 'Menu', 'add') == true)
                            <button type="button" class="btn btn-primary d-sm-inline-block ms-2 fw-bold float-end"
                                data-bs-toggle="modal" data-bs-target="#modal_add">Tambah
                                Menu</button>
                            <button type="button" class="btn btn-secondary d-sm-inline-block ms-2 fw-bold float-end"
                                data-bs-toggle="modal" data-bs-target="#modal_add_section">Tambah
                                Section</button>
                        @endif
                    </div>

                    <div class="col-sm-12">
                        <div class="card card-borderless">
                            @include('menu.create-section')
                            @include('menu.edit-section')
                            @include('menu.create-menu')
                            @include('menu.edit-menu')
                            <div class="card-header">
                                <ul class="nav nav-tabs" data-bs-toggle="tabs">
                                    <li class="nav-item">
                                        <a href="#tabs-home-1" class="nav-link active fw-bold"
                                            data-bs-toggle="tab">Section</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tabs-profile-1" class="nav-link fw-bold" data-bs-toggle="tab">Menu</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active show" id="tabs-home-1">
                                        <h4>List Section</h4>
                                        <div class="card-body table-responsive">
                                            <!-- Default Table -->
                                            <table class="table table-hover table-vcenter" id="">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Section</th>
                                                        <th>Section Icons</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sections as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->name_section }}</td>
                                                            <td>{{ $item->icons }}</td>
                                                            <td>
                                                                @if (NavHelper::cekAkses(Auth::user()->id, 'Menu', 'edit') == true)
                                                                    <button value="{{ $item->id }}" type="button"
                                                                        class="btn btn-primary btn-icon" id="editSection"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#edit_section" title="Edit">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </button>
                                                                @endif
                                                                @if (NavHelper::cekAkses(Auth::user()->id, 'Menu', 'delete') == true)
                                                                    <button onclick="deleteSection({{ $item->id }})"
                                                                        class="btn btn-danger btn-icon fw-bold"
                                                                        title="Hapus">
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
                                        <h4>List Menu</h4>
                                        <div class="card-body table-responsive">
                                            <!-- Default Table -->
                                            <table class="table table-hover table-vcenter" id="">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Section</th>
                                                        <th>Menu</th>
                                                        <th>URL</th>
                                                        <th>Urutan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($menus as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td class="fw-bold">{{ $item->name_section }}</td>
                                                            <td>{{ $item->name_menu }}</td>
                                                            <td>{{ $item->url }}</td>
                                                            <td>{{ $item->order }}</td>
                                                            <td>
                                                                @if (NavHelper::cekAkses(Auth::user()->id, 'Menu', 'edit') == true)
                                                                    <button value="{{ $item->id }}" type="button"
                                                                        class="btn btn-primary btn-icon" id="editMenu"
                                                                        data-bs-toggle="modal" data-bs-target="#edit_menu"
                                                                        title="Edit">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </button>
                                                                @endif
                                                                @if (NavHelper::cekAkses(Auth::user()->id, 'Menu', 'delete') == true)
                                                                    <button onclick="deletes({{ $item->id }})"
                                                                        class="btn btn-danger btn-icon fw-bold"
                                                                        title="Hapus">
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
        $(document).ready(function() {
            $(document).on('click', '#editSection', function() {
                let id = $(this).val();
                $('#edit_section').modal('show');

                $.ajax({
                    url: 'menu/detail-section/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#id_section').val(response.data.id);
                            $('#name_section_edit').val(response.data.name_section);
                            $('#icons_edit').val(response.data.icons);
                        }
                    }
                });
            });

            $('#edit_section').submit(function(event) {
                event.preventDefault();

                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                let id = $('#id_section').val();
                let formData = {
                    '_token': csrfToken,
                    'id': id,
                    'name_section': $('#name_section_edit').val(),
                    'icons': $('#icons_edit').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'menu/update-section/' + id,
                    data: formData,
                    dataType: 'json',
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
            });
        });

        $(document).ready(function() {
            $(document).on('click', '#editMenu', function() {
                let id = $(this).val();
                $('#edit_menu').modal('show');

                $.ajax({
                    url: 'menu/detail-menu/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#id_menu').val(response.data.id);
                            $('#section_id_edit').val(response.data.section_id);
                            $('#name_menu_edit').val(response.data.name_menu);
                            $('#url_edit').val(response.data.url);
                            $('#order_edit').val(response.data.order);
                        }
                    }
                });
            });

            $('#edit_menu').submit(function(event) {
                event.preventDefault();

                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                let id = $('#id_menu').val();
                let formData = {
                    '_token': csrfToken,
                    'id': id,
                    'section_id': $('#section_id_edit').val(),
                    'name_menu': $('#name_menu_edit').val(),
                    'url': $('#url_edit').val(),
                    'order': $('#order_edit').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'menu/update-menu/' + id,
                    data: formData,
                    dataType: 'json',
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
            });
        });

        function deletes(id) {
            let url = '{{ route('menu.delete', 'ID') }}';
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

        function deleteSection(id) {
            let url = '{{ route('menu.delete-section', 'ID') }}';
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

        function pesan() {
            Swal.fire({
                title: 'Informasi!',
                text: 'Mohon maaf,  Fitur belum tersedia, anda tidak dapat mangakses Fitur ini.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>
@endsection

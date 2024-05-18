@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Hak Akses <span class="text-danger ms-2">{{ $groups->name }}</span>
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('group.index') }}">Data Group</a></li>
                            <li class="breadcrumb-item active">Hak Akses {{ $groups->name }}</li>
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
                            <div class="card-body table-responsive">
                                <!-- Default Table -->
                                <table class="table table-bordered table-hover table-vcenter" id="">
                                    <thead>
                                        <tr>
                                            <th>Section Menu</th>
                                            <th>Menu</th>
                                            <th colspan="2">Akses Menu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menu_sections as $section)
                                            @php $sectionDisplayed = false; @endphp
                                            @foreach ($menus->where('section_id', $section->id) as $menu)
                                                @csrf
                                                <tr>
                                                    @if (!$sectionDisplayed)
                                                        <td
                                                            rowspan="{{ $menus->where('section_id', $section->id)->count() }}">
                                                            <h4 class="fw-bold">
                                                                {{ $section->name_section }}
                                                            </h4>
                                                        </td>
                                                        @php $sectionDisplayed = true; @endphp
                                                    @endif
                                                    <input type="hidden" value="{{ $groups->id }}" class="group_id"
                                                        id="group_id">
                                                    <td>{{ $menu->name_menu }}</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input id="allCheck-{{ $menu->id }}"
                                                                onclick="checkAll('{{ $menu->id }}')"
                                                                class="form-check-input semua-checkbox-{{ $menu->id }} all-checked"
                                                                type="checkbox" data-menu_id="{{ $menu->id }}"
                                                                data-aksi="{{ $master_action[0]->id }}"
                                                                {{ NavHelper::switched($groups->id, $menu->id) ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="semua"><span
                                                                    class="text-success fw-bold">Semua</span></label>
                                                        </div>
                                                        @foreach ($master_action as $item)
                                                            <div class="form-check form-check-inline">
                                                                <input
                                                                    onclick="checkManual('{{ $menu->id }}', this.checked)"
                                                                    class="form-check-input checkbox-{{ $menu->id }} indiv-checked"
                                                                    type="checkbox" data-menu_id="{{ $menu->id }}"
                                                                    data-aksi="{{ $item->id }}"
                                                                    {{ NavHelper::create_checked($groups->id, $menu->id, $item->id) ? 'checked' : '' }} />
                                                                <label class="form-check-label"
                                                                    for="read">{{ $item->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
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
@endsection

@section('customJs')
    <script>
        function checkAll(menuName) {
            const switchBtn = document.getElementById(`allCheck-${menuName}`);
            const checkboxes = document.querySelectorAll(`.checkbox-${menuName}`);

            checkboxes.forEach(checkbox => {
                checkbox.checked = switchBtn.checked;
            });

            const menu_id = switchBtn.getAttribute('data-menu_id')
            const group_id = $("#group_id").val()
            const status = switchBtn.checked

            $.ajax({
                method: "post",
                url: "{{ route('permission.all-akses') }}",
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val(),
                },
                data: {
                    menu_id,
                    status,
                    group_id
                },
                success: function(data) {
                    //SweetAlert2 Toast

                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error, e.g., show an error message
                    console.error(error);
                }
            })
        }

        // Fungsi untuk memeriksa apakah semua checkbox dalam suatu kelompok aktif atau tidak
        function checkManual(menuName) {
            const checkboxes = document.querySelectorAll(`.checkbox-${menuName}`);
            const switchBtn = document.getElementById(`allCheck-${menuName}`);

            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

            switchBtn.checked = allChecked;
        }

        $(".indiv-checked").on('click', function() {
            let data = $(this).data();
            const menu_id = data.menu_id;
            const aksi = data.aksi;
            const group_id = $("#group_id").val();

            $.ajax({
                method: "post",
                url: "{{ route('permission.edit-akses') }}",
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val(),
                },
                data: {
                    menu_id,
                    aksi,
                    group_id
                },
                success: function(data) {
                    //SweetAlert2 Toast

                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error, e.g., show an error message
                    console.error(error);
                }
            });
        });

        // $.ajax({
        //     beforeSend: function() {
        //         $('#ok_button').text('Deleting...');
        //     },
        //     success: function(data) {
        //         setTimeout(function() {
        //             $('#deleteModal').modal('hide');
        //             Swal.fire(
        //                 'Deleted!',
        //                 'Your file has been deleted.',
        //                 'success'
        //             )
        //             $('#jobsTable').DataTable().ajax.reload();
        //         }, 500);
        //     }
        // });
    </script>
@endsection

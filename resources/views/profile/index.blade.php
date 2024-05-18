@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Ubah Password <span class="text-danger fw-bold ms-2">{{ $user->name }}</span>
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
                                <form action="{{ route('users.update-password', ['id' => $user->id]) }}" method="POST"
                                    id="change-password-form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ $user->name }}" readonly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" name="username" id="username" class="form-control"
                                            value="{{ $user->email }}" readonly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="password" class="form-label">Password Sekarang</label>
                                        <input type="password" name="current_password" id="current_password"
                                            class="form-control" placeholder="Password sekarang" autocomplete="off">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control"
                                            placeholder="Password baru" minlength="8" autocomplete="off">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="password" class="form-label">Konfirmasi Password Baru</label>
                                        <input type="password" name="new_password_confirmation"
                                            id="new_password_confirmation" class="form-control"
                                            placeholder="Konfirmasi password baru" minlength="8" autocomplete="off">
                                        <div id="password-mismatch" class="text-danger"></div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('new_password_confirmation');
            const passwordMismatch = document.getElementById('password-mismatch');
            const submitButton = document.querySelector('button[type="submit"]');

            confirmPassword.addEventListener('input', function() {
                if (newPassword.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity(
                        'Konfirmasi password tidak sesuai dengan password baru');
                    passwordMismatch.textContent = 'Konfirmasi password tidak sesuai dengan password baru';
                } else {
                    confirmPassword.setCustomValidity('');
                    passwordMismatch.textContent = '';
                }

                submitButton.disabled = !document.getElementById('change-password-form').checkValidity();
            });
        });
    </script>
@endsection

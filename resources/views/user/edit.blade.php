<div class="modal modal-blur modal-lg fade" id="modal_edit" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="" enctype="multipart/form-data" id="edit" name="edit">
                @csrf
                <input type="text" id="id" name="id">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label text-secondary fw-semibold">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label text-secondary fw-semibold">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" id="email" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-sm-3 col-form-label text-secondary fw-semibold">Password
                            Sekarang</label>
                        <div class="col-sm-9">
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-sm-3 col-form-label text-secondary fw-semibold">Password
                            Baru</label>
                        <div class="col-sm-9">
                            <input type="password" name="new_password" id="new_password" class="form-control"
                                minlength="8" required>
                        </div>
                    </div>
                    <div class="row">
                        <label for="password" class="col-sm-3 col-form-label text-secondary fw-semibold">Konfirmasi
                            Password Baru</label>
                        <div class="col-sm-9">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="form-control" minlength="8" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary d-none d-sm-inline-block fw-bold"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" value="Simpan"
                        class="btn btn-primary d-none d-sm-inline-block fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

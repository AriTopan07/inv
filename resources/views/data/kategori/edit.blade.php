<div class="modal modal-blur fade" id="modalEdit" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="put" action="" enctype="multipart/form-data" id="edit" name="edit">
                @method('put')
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Data Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nama" class="col-form-label text-secondary fw-semibold">Ruangan</label>
                            <input type="text" name="edit_nama" id="edit_nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="deskripsi" class="col-form-label text-secondary fw-semibold">Deskripsi</label>
                            <textarea class="form-control" name="edit_deskripsi" id="edit_deskripsi" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" value="Simpan" class="btn btn-primary fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

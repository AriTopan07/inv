<div class="modal modal-blur fade" id="modal_add" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('kategori.store') }}" enctype="multipart/form-data" id="create"
                name="create">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Data Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nama" class="col-form-label text-secondary fw-semibold">Kategori</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="deskripsi" class="col-form-label text-secondary fw-semibold">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" value="Simpan" class="btn btn-primary fw-bold">Buat</button>
                </div>
            </form>
        </div>
    </div>
</div>

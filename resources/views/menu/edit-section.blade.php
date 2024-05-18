<div class="modal modal-blur fade" id="edit_section" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="" enctype="multipart/form-data" id="create" name="create">
                @csrf
                <input type="hidden" name="id_section" id="id_section">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label text-secondary fw-semibold">Nama
                            Section</label>
                        <div class="col-sm-9">
                            <input type="text" name="name_section_edit" id="name_section_edit" class="form-control"
                                placeholder="Section baru">
                        </div>
                    </div>
                    <div class="row">
                        <label for="icon" class="col-sm-3 col-form-label text-secondary fw-semibold">Icon</label>
                        <div class="col-sm-9">
                            <input type="text" name="icons_edit" id="icons_edit" class="form-control"
                                placeholder="Icon">
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

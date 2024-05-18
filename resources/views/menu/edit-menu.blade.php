<div class="modal modal-blur fade" id="edit_menu" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data" id="create"
                name="create">
                @csrf
                <input type="hidden" name="id_menu" id="id_menu">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="section_id"
                            class="col-sm-3 col-form-label text-secondary fw-semibold">Section</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="section_id_edit" id="section_id_edit">
                                <option value="">-- Pilih section menu --</option>
                                @foreach ($sections as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_section }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label text-secondary fw-semibold">Nama
                            Menu</label>
                        <div class="col-sm-9">
                            <input type="text" name="name_menu_edit" id="name_menu_edit" class="form-control"
                                placeholder="Nama Menu">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="url" class="col-sm-3 col-form-label text-secondary fw-semibold">URL</label>
                        <div class="col-sm-9">
                            <input type="text" name="url_edit" id="url_edit" class="form-control"
                                placeholder="/url-menu">
                        </div>
                    </div>
                    <div class="row">
                        <label for="order" class="col-sm-3 col-form-label text-secondary fw-semibold">Urutan</label>
                        <div class="col-sm-9">
                            <input type="text" name="order_edit" id="order_edit" class="form-control"
                                placeholder="Urutan menu ditampilkan di sidebar">
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

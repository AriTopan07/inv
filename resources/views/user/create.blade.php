<div class="modal modal-blur fade" id="modal_add" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data" id="create"
                name="create">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label text-secondary fw-semibold">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-3 col-form-label text-secondary fw-semibold">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password"
                            class="col-sm-3 col-form-label text-secondary fw-semibold">Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" id="password" class="form-control" minlength="8"
                                required autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <label for="group_id" class="col-sm-3 col-form-label text-secondary fw-semibold">User
                            Group</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="group_id" id="group_id" class="form-control choices"
                                required>
                                @foreach ($group as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
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

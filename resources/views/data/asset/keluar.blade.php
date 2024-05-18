<div class="modal modal-lg modal-blur fade" id="keluar" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('barang-keluar.create', $data['barangs']->id) }}"
                enctype="multipart/form-data" id="barangKeluar" name="barangKeluar">
                @method('post')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Form Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nama" class="col-form-label text-secondary fw-semibold">Nama Barang</label>
                            <input type="text" name="nama_barang_keluar" id="nama_barang_keluar" class="form-control"
                                required readonly>
                            <input type="hidden" name="keluar_id" id="keluar_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nama" class="col-form-label text-secondary fw-semibold">Ruangan Asal</label>
                            <input type="text" name="ruanganAsal2" id="ruanganAsal2" class="form-control" required
                                readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="deskripsi" class="col-form-label text-secondary fw-semibold">Keterangan
                                Keluar</label>
                            <textarea class="form-control" name="keterangan_keluar" id="keterangan_keluar" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary fw-bold" onclick="return confirm()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirm() {
        Swal.fire({
            title: 'Simpan barang keluar ?',
            text: 'Anda yakin ingin menyimpan data barang keluar ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#barangKeluar').submit();
            }
        });
    }
</script>

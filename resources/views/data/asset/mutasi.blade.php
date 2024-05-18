<div class="modal modal-lg modal-blur fade" id="mutasi" tabindex="-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('mutasi-barang.create', $data['barangs']->id) }}"
                enctype="multipart/form-data" id="mutasiBarang" name="mutasiBarang">
                @method('post')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Form Mutasi Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-status bg-yellow"></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nama" class="col-form-label text-secondary fw-semibold">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" required
                                readonly>
                            <input type="hidden" name="barang_id" id="barang_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nama" class="col-form-label text-secondary fw-semibold">Ruangan Asal</label>
                            <input type="text" name="ruanganAsal" id="ruanganAsal" class="form-control" required
                                readonly>
                            <input type="hidden" name="from_ruangan_id" id="from_ruangan_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nama" class="col-form-label text-secondary fw-semibold">Ruangan
                                Tujuan</label>
                            <select class="form-control" name="ruangan_id" id="ruangan_id">
                                <option value="">Pilih ruangan tujuan</option>
                                @foreach ($data['ruangans'] as $ruangan)
                                    <option value="{{ $ruangan->id }}">{{ $ruangan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="deskripsi" class="col-form-label text-secondary fw-semibold">Keterangan
                                Mutasi</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="10"></textarea>
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
            title: 'Simpan mutasi ?',
            text: 'Anda yakin ingin menyimpan data mutasi ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Mutasi!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#mutasiBarang').submit();
            }
        });
    }
</script>

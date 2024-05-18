<table>
    <tr>
        <td><b>Laporan Barang Keluar</b></td>
    </tr>
    <tr>
        <td>Date : {{ date('d m Y', strtotime($date_start)) }} / {{ date('d m Y', strtotime($date_end)) }}</td>
    </tr>
    <tr>
        <td>User : {{ Auth::user()->name }}</td>
    </tr>
</table>
<br>
<table border="1">
    <thead>
        <tr>
            <th style="text-align: center; background-color: #40c668;"><b>No</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Ruangan</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Kategori</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Nama Barang Keluar</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Merk</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Tipe</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>No Seri</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Harga</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Jumlah</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Kondisi</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Deskripsi</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Keterangan Keluar</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->nama_ruang }}</td>
                <td>{{ $item->nama_kategori }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->merk }}</td>
                <td>{{ $item->tipe }}</td>
                <td>{{ $item->no_seri }}</td>
                <td>{{ $item->harga }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->kondisi }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

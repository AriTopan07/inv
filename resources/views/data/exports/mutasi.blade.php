<table>
    <tr>
        <td><b>Laporan Mutasi Barang</b></td>
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
            <th style="text-align: center; background-color: #40c668;"><b>Nama Barang</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Ruangan Asal</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Ruangan Tujuan</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Keterangan Mutasi</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->from_ruang }}</td>
                <td>{{ $item->to_ruang }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

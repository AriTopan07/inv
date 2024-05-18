<?php

namespace App\Http\Repository;

use Milon\Barcode\DNS2D;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportRepository
{
    public function getBarangMasuk($date_start, $date_end)
    {
        $data = DB::table('barangs')
            ->select('barangs.*', 'ruangans.nama as nama_ruang', 'kategoris.nama as nama_kategori')
            ->join('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->where('barangs.status', '=', 1)
            ->whereDate('barangs.created_at', '>=', $date_start)
            ->whereDate('barangs.created_at', '<=', $date_end)
            ->get();

        return $data;
    }

    public function getBarangKeluar($date_start, $date_end)
    {
        $data = DB::table('barang_keluars')
            ->select('barang_keluars.*', 'barangs.*', 'ruangans.nama as nama_ruang', 'kategoris.nama as nama_kategori')
            ->join('barangs', 'barang_keluars.barang_id', '=', 'barangs.id')
            ->join('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->where('barang_keluars.verified', '=', 1)
            ->whereDate('barangs.created_at', '>=', $date_start)
            ->whereDate('barangs.created_at', '<=', $date_end)
            ->get();

        return $data;
    }

    public function getMutasiBarang($date_start, $date_end)
    {
        $data = DB::table('mutasis')
            ->select('mutasis.*', 'barangs.*', 'ruangans_from.nama as from_ruang', 'ruangans_to.nama as to_ruang', 'kategoris.nama as nama_kategori')
            ->join('ruangans as ruangans_from', 'mutasis.from_ruangan_id', '=', 'ruangans_from.id')
            ->join('ruangans as ruangans_to', 'mutasis.to_ruangan_id', '=', 'ruangans_to.id')
            ->join('barangs', 'mutasis.barang_id', '=', 'barangs.id')
            ->join('ruangans as ruangans_barang', 'barangs.ruangan_id', '=', 'ruangans_barang.id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.id')
            ->where('mutasis.verified', '=', 1)
            ->whereDate('barangs.created_at', '>=', $date_start)
            ->whereDate('barangs.created_at', '<=', $date_end)
            ->get();

        return $data;
    }
}

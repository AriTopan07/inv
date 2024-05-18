<?php

namespace App\Http\Repository;

use Milon\Barcode\DNS2D;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BarangRepository
{
    public function generateBarcode()
    {
        $tanggal = date('Ymd');

        $jumlahBarangHariIni = Barang::whereDate('created_at', date('Y-m-d'))->count();

        $nomorUrut = str_pad($jumlahBarangHariIni + 1, 4, '0', STR_PAD_LEFT);

        $barcode = $tanggal . $nomorUrut;

        return $barcode;
    }

    public function generateAndSaveQRCodeImage()
    {
        $barcodeData = $this->generateBarcode();

        $storPath = public_path('/uploads/qrcode/');

        if (!file_exists($storPath)) {
            mkdir($storPath, 0777, true);
        }

        $qrCode = new DNS2D();
        $qrCode->setStorPath($storPath);

        $fileName = 'nama_file.png';
        $qrCode->getBarcodePNGPath($barcodeData, 'QRCODE', 300, 300);

        file_put_contents($storPath . $fileName, $qrCode);

        return $barcodeData;
    }

    public function getBarangByRuangan($id)
    {
        $barang =  Barang::where('ruangan_id', $id)
            ->where('verified', 1)
            ->where('status', '=', 1)
            ->latest()
            ->get();

        return $barang;
    }
}

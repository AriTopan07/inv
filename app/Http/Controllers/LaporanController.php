<?php

namespace App\Http\Controllers;

use App\Exports\BarangKeluarExport;
use App\Exports\BarangMasukExport;
use App\Exports\MutasiBarangExport;
use Illuminate\Http\Request;
use App\Http\Repository\PermissionRepository;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Repository\ExportRepository;
use PDF;

class LaporanController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/laporan');
            return $next($request);
        });
    }

    public function index()
    {
        return view('data.laporan.list');
    }

    public function download_excel(Request $request, $type)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        if ($type === "masuk") {
            return $this->download_excel_masuk($date_start, $date_end);
        } elseif ($type === "keluar") {
            return $this->download_excel_keluar($date_start, $date_end);
        } elseif ($type === "mutasi") {
            return $this->download_excel_mutasi($date_start, $date_end);
        }
    }

    public function download_pdf(Request $request, $type)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        if ($type === "masuk") {
            return $this->download_pdf_masuk($date_start, $date_end);
        } elseif ($type === "keluar") {
            return $this->download_pdf_keluar($date_start, $date_end);
        } elseif ($type === "mutasi") {
            return $this->download_pdf_mutasi($date_start, $date_end);
        }
    }

    public function download_pdf_masuk($date_start, $date_end)
    {
        $data = new ExportRepository();
        $get = $data->getBarangMasuk($date_start, $date_end);
        if ($get->isEmpty()) {
            return redirect()->back()->with('warning', 'Tidak ada data untuk diekspor.');
        }

        $pdf = PDF::loadView('data.exports.masuk-pdf', [
            'data' => $get,
            'date_start' => $date_start,
            'date_end' => $date_end
        ]);

        return $pdf->download('laporan-masuk.pdf');
    }

    public function download_pdf_keluar($date_start, $date_end)
    {
        $data = new ExportRepository();
        $get = $data->getBarangKeluar($date_start, $date_end);
        if ($get->isEmpty()) {
            return redirect()->back()->with('warning', 'Tidak ada data untuk diekspor.');
        }

        $pdf = PDF::loadView('data.exports.keluar-pdf', [
            'data' => $get,
            'date_start' => $date_start,
            'date_end' => $date_end
        ]);

        return $pdf->download('laporan-keluar.pdf');
    }

    public function download_pdf_mutasi($date_start, $date_end)
    {
        $data = new ExportRepository();
        $get = $data->getMutasiBarang($date_start, $date_end);
        if ($get->isEmpty()) {
            return redirect()->back()->with('warning', 'Tidak ada data untuk diekspor.');
        }

        $pdf = PDF::loadView('data.exports.mutasi-pdf', [
            'data' => $get,
            'date_start' => $date_start,
            'date_end' => $date_end
        ]);

        return $pdf->download('laporan-mutasi.pdf');
    }

    public function download_excel_masuk($date_start, $date_end)
    {
        $data = new ExportRepository();
        $get = $data->getBarangMasuk($date_start, $date_end);
        if ($get->isEmpty()) {
            return redirect()->back()->with('warning', 'Tidak ada data untuk diekspor.');
        }
        return Excel::download(new BarangMasukExport($date_start, $date_end), 'laporan-barang-masuk.xlsx');
    }

    public function download_excel_keluar($date_start, $date_end)
    {
        $data = new ExportRepository();
        $get = $data->getBarangKeluar($date_start, $date_end);
        if ($get->isEmpty()) {
            return redirect()->back()->with('warning', 'Tidak ada data untuk diekspor.');
        }
        return Excel::download(new BarangKeluarExport($date_start, $date_end), 'laporan-barang-keluar.xlsx');
    }

    public function download_excel_mutasi($date_start, $date_end)
    {
        $data = new ExportRepository();
        $get = $data->getMutasiBarang($date_start, $date_end);
        if ($get->isEmpty()) {
            return redirect()->back()->with('warning', 'Tidak ada data untuk diekspor.');
        }
        return Excel::download(new MutasiBarangExport($date_start, $date_end), 'laporan-mutasi-barang.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Repository\PermissionRepository;
use App\Http\Repository\BarangRepository;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    protected $permission, $barang;

    public function __construct(PermissionRepository $permission, BarangRepository $barang)
    {
        $this->permission = $permission;
        $this->barang = $barang;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/barang-keluar');
            return $next($request);
        });
    }

    public function index()
    {
        $data['barang_keluar'] = DB::table('barang_keluars')
            ->join('barangs', 'barang_keluars.barang_id', '=', 'barangs.id')
            ->join('users', 'barang_keluars.created_by', '=', 'users.id')
            ->select('barang_keluars.*', 'barangs.nama as nama_barang', 'users.name')
            ->where('barang_keluars.verified', '=', 0)
            ->get();

        $data['acc_barang_keluar'] = DB::table('barang_keluars')
            ->join('barangs', 'barang_keluars.barang_id', '=', 'barangs.id')
            ->join('users', 'barang_keluars.created_by', '=', 'users.id')
            ->select('barang_keluars.*', 'barangs.nama as nama_barang', 'users.name')
            ->where('barang_keluars.verified', '=', 1)
            ->get();

        // $data['barang'] = Barang::where('verified', 1)
        //     ->where('status', '=', 1)
        //     ->latest()
        //     ->get();

        return view('data.keluar.list', compact('data'));
    }

    public function createKeluar(Request $request, $id)
    {
        try {
            $request->validate([
                'keluar_id' => 'required|exists:barangs,id',
                'keterangan_keluar' => 'required',
            ]);

            $user = Auth::user();

            BarangKeluar::create([
                'barang_id' => $request->keluar_id,
                'keterangan' => $request->keterangan_keluar,
                'created_by' => $user->id,
            ]);

            $request->session()->flash('success', 'Harap menunggu persetujuan pengurus');

            return redirect()->back()->with('success', 'Harap menunggu persetujuan pengurus');
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function terima(Request $request, $id)
    {
        try {
            $barang = Barang::find($id);
            $barangKeluar = BarangKeluar::find($id);

            $barangKeluar->verified = 1;
            $barangKeluar->save();

            $barang->update([
                'status' => 0,
            ]);

            $request->session()->flash('success', 'Barang berhasil dikeluarkan');

            return response()->json([
                'status' => true,
                'message' => 'Barang berhasil dikeluarkan.',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal terima brang keluar.',
            ]);
        }
    }

    public function tolak(Request $request, $id)
    {
        try {
            $barangKeluar = BarangKeluar::find($id);

            if (!$barangKeluar) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data barang keluar tidak ditemukan.',
                ]);
            }

            $barangKeluar->delete();

            $request->session()->flash('success', 'Barang keluar telah ditolak');

            return response()->json([
                'status' => true,
                'message' => 'Barang keluar telah ditolak dan data berhasil dihapus.',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal barang keluar.',
            ]);
        }
    }
}

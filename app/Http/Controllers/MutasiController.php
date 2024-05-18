<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\PermissionRepository;
use App\Http\Repository\BarangRepository;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Mutasi;
use App\Models\Ruangan;
use App\Models\TempImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class MutasiController extends Controller
{
    protected $permission, $barang;

    public function __construct(PermissionRepository $permission, BarangRepository $barang)
    {
        $this->permission = $permission;
        $this->barang = $barang;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/mutasi-barang');
            return $next($request);
        });
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Mutasi Barang", "view") !== true) {
            return view('error.403');
        }

        $data['mutasi'] = DB::table('mutasis')
            ->join('barangs', 'mutasis.barang_id', '=', 'barangs.id')
            ->join('ruangans as from_ruangan', 'mutasis.from_ruangan_id', '=', 'from_ruangan.id')
            ->join('ruangans as to_ruangan', 'mutasis.to_ruangan_id', '=', 'to_ruangan.id')
            ->join('users', 'mutasis.created_by', '=', 'users.id')
            ->select('mutasis.*', 'barangs.nama as nama_barang', 'from_ruangan.nama as ruangan_asal', 'to_ruangan.nama as ruangan_tujuan', 'users.name')
            ->where('mutasis.verified', '=', 0)
            ->get();

        $data['acc_mutasi'] = DB::table('mutasis')
            ->join('barangs', 'mutasis.barang_id', '=', 'barangs.id')
            ->join('ruangans as from_ruangan', 'mutasis.from_ruangan_id', '=', 'from_ruangan.id')
            ->join('ruangans as to_ruangan', 'mutasis.to_ruangan_id', '=', 'to_ruangan.id')
            ->join('users', 'mutasis.created_by', '=', 'users.id')
            ->select('mutasis.*', 'barangs.nama as nama_barang', 'from_ruangan.nama as ruangan_asal', 'to_ruangan.nama as ruangan_tujuan', 'users.name')
            ->where('mutasis.verified', '=', 1)
            ->get();

        return view('data.mutasi.list', compact('data'));
    }

    public function createMutasi(Request $request, $id)
    {
        try {
            $request->validate([
                'barang_id' => 'required|exists:barangs,id',
                'from_ruangan_id' => 'required|exists:ruangans,id',
                'ruangan_id' => 'required|exists:ruangans,id',
                'keterangan' => 'required',
            ]);

            $user = Auth::user();
            $barang = Barang::find($id);

            Mutasi::create([
                'barang_id' => $request->barang_id,
                'from_ruangan_id' => $request->from_ruangan_id,
                'to_ruangan_id' => $request->ruangan_id,
                'keterangan' => $request->keterangan,
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
            $mutasi = Mutasi::find($id);

            $mutasi->verified = 1;
            $mutasi->save();

            $barang->update([
                'ruangan_id' => $mutasi->to_ruangan_id,
            ]);

            $request->session()->flash('success', 'Barang berhasil dimutasi');

            return response()->json([
                'status' => true,
                'message' => 'Barang berhasil dimutasi.',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal mutasi barang.',
            ]);
        }
    }

    public function tolak(Request $request, $id)
    {
        try {
            $mutasi = Mutasi::find($id);

            if (!$mutasi) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data mutasi tidak ditemukan.',
                ]);
            }

            $mutasi->delete();

            $request->session()->flash('success', 'Mutasi barang telah ditolak');

            return response()->json([
                'status' => true,
                'message' => 'Mutasi barang telah ditolak dan data berhasil dihapus.',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal mutasi barang.',
            ]);
        }
    }

    public function verifAll()
    {
        if (condition) {
            # code...
        }
    }
}

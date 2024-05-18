<?php

namespace App\Http\Controllers;

use App\Http\Repository\PermissionRepository;
use App\Models\Barang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RuanganController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/ruangan');
            return $next($request);
        });
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Ruangan", "view") !== true) {
            return view('error.403');
        }

        $data['ruangan'] = Ruangan::latest()->get();

        return view('data.ruangan.list', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                // 'deskripsi' => 'required|string'
            ]);

            Ruangan::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi ?? '',
                'status' => 1
            ]);

            $request->session()->flash('success', 'Ruangan berhasil dibuat');

            return redirect()->back();
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data = Ruangan::where('id', $id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'edit_nama' => 'required|string',
                'edit_deskripsi' => 'required|string'
            ]);

            $data = Ruangan::findOrFail($id);

            $data->update([
                'nama' => $request->edit_nama,
                'deskripsi' => $request->edit_deskripsi
            ]);

            $request->session()->flash('success', 'Ruangan berhasil diperbarui');

            return response()->json([
                'status' => true,
                'message' => 'berhasil diperbarui.',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal diperbarui.',
            ]);
        }
    }

    public function statusRuangan(Request $request)
    {
        $id = $request->input('id_ruangan');
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->status = $request->input('status');
        $ruangan->save();

        return response()->json(['message' => 'Status berhasil dirubah']);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = Ruangan::findOrFail($id);

            if (Barang::where('ruangan_id', $data->id)->exists()) {
                $request->session()->flash('error', 'Tidak dapat menghapus data ini');
                return response()->json([
                    'status' => false,
                    'message' => 'Data Ruangan terdapat data Barang, tidak dapat menghapus data Ruangan',
                ]);
            } else {
                $data->delete();

                $request->session()->flash('success', 'Berhasil dihapus');
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil dihapus'
                ]);
            }
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal diperbarui.',
            ]);
        }
    }
}

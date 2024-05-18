<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\PermissionRepository;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/kategori');
            return $next($request);
        });
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Kategori", "view") !== true) {
            return view('error.403');
        }

        $data['kategori'] = Kategori::latest()->get();

        return view('data.kategori.list', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                // 'deskripsi' => 'required|string'
            ]);

            Kategori::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi ?? '',
                'status' => 1
            ]);

            $request->session()->flash('success', 'Kategori berhasil dibuat');

            return redirect()->back();
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data = Kategori::where('id', $id)->first();

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

            $data = Kategori::findOrFail($id);

            $data->update([
                'nama' => $request->edit_nama,
                'deskripsi' => $request->edit_deskripsi
            ]);

            $request->session()->flash('success', 'kategori berhasil diperbarui');

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

    public function statusKategori(Request $request)
    {
        $id = $request->input('id_kategori');
        $kategori = Kategori::findOrFail($id);
        $kategori->status = $request->input('status');
        $kategori->save();

        return response()->json(['message' => 'Status berhasil dirubah']);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = Kategori::findOrFail($id);

            if (Barang::where('kategori_id', $data->id)->exists()) {
                $request->session()->flash('error', 'Tidak dapat menghapus data ini');
                return response()->json([
                    'status' => false,
                    'message' => 'Data kategori terdapat data Barang, tidak dapat menghapus data kategori',
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

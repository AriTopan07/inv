<?php

namespace App\Http\Controllers;

use App\Http\Repository\PermissionRepository;
use App\Http\Repository\BarangRepository;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class BarangController extends Controller
{
    protected $permission, $barang;

    public function __construct(PermissionRepository $permission, BarangRepository $barang)
    {
        $this->permission = $permission;
        $this->barang = $barang;
        $this->middleware(function ($request, $next) {
            if ($request->is('barang')) {
                Session::put('active', '/barang');
            } elseif ($request->is('inventaris')) {
                Session::put('active', '/inventaris');
            }
            return $next($request);
        });
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Barang Masuk", "view") !== true) {
            return view('error.403');
        }

        $data['barang'] = Barang::where('verified', '=', 0)->latest()->get();
        $data['acc_barang'] = Barang::where('verified', '=', 1)->latest()->get();

        return view('data.barang.list', compact('data'));
    }

    public function create()
    {
        $data['ruangan'] = Ruangan::get();
        $data['kategori'] = Kategori::get();

        return view('data.barang.create', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $pesan = [
                'required' => ':attribute wajib diisi !',
                'min' => ':attribute harus diisi minimal :min karakter !',
                'max' => ':attribute harus diisi maksimal :max karakter !',
                'numeric' => ':attribute harus diisi angka !',
                'no_seri.unique' => 'Nomor seri sudah tersedia.',
            ];

            $validator = Validator::make($request->all(), [
                'ruangan_id' => 'required',
                'kategori_id' => 'required',
                'nama' => 'required',
                'merk' => 'required',
                'tipe' => 'required',
                'no_seri' => 'required|unique:barangs,no_seri',
                'harga' => 'required',
                'jumlah' => 'required',
                'kondisi' => 'required',
            ], $pesan);

            $user = Auth::user();

            $barcode = $this->barang->generateBarcode();

            if ($validator->passes()) {

                // save barcode
                $barcode = $this->barang->generateAndSaveQRCodeImage();

                $barang = new Barang;
                $barang->ruangan_id = $request->ruangan_id;
                $barang->kategori_id = $request->kategori_id;
                $barang->barcode = $barcode;
                $barang->nama = $request->nama;
                $barang->merk = $request->merk;
                $barang->tipe = $request->tipe;
                $barang->no_seri = $request->no_seri;
                $barang->harga = $request->harga;
                $barang->qty = $request->jumlah;
                $barang->kondisi = $request->kondisi;
                $barang->deskripsi = $request->deskripsi ?? '';
                $barang->status = 1;
                $barang->created_by = $user->id;
                $barang->save();

                // save images
                if (!empty($request->image_id)) {
                    $tempImage = TempImage::find($request->image_id);
                    $extArray = explode('.', $tempImage->name);
                    $ext = last($extArray);

                    $newImageName = $barang->id . '.' . $ext;
                    $sPath = public_path() . '/temp/' . $tempImage->name;
                    $dPath = public_path() . '/uploads/barang/' . $newImageName;
                    File::copy($sPath, $dPath);

                    $barang->image = $newImageName;
                    $barang->save();
                }

                $request->session()->flash('success', 'Barang berhasil dibuat');

                return response()->json([
                    'success' => true,
                    'message' => 'Barang berhasil dibuat'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $data['barang'] = Barang::findOrFail($id);
        $data['ruangan'] = Ruangan::get();
        $data['kategori'] = Kategori::get();

        return view('data.barang.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            $pesan = [
                'required' => ':attribute wajib diisi !',
                'min' => ':attribute harus diisi minimal :min karakter !',
                'max' => ':attribute harus diisi maksimal :max karakter !',
                'numeric' => ':attribute harus diisi angka !',
                'no_seri.unique' => 'Nomor seri sudah tersedia.',
            ];

            $validator = Validator::make($request->all(), [
                'ruangan_id' => 'required',
                'kategori_id' => 'required',
                'nama' => 'required',
                'merk' => 'required',
                'tipe' => 'required',
                'no_seri' => 'required|unique:barangs,no_seri,' . $id,
                'harga' => 'required',
                'jumlah' => 'required',
                'kondisi' => 'required',
            ], $pesan);

            $user = Auth::user();

            if ($validator->passes()) {

                $barang->ruangan_id = $request->ruangan_id;
                $barang->kategori_id = $request->kategori_id;
                $barang->nama = $request->nama;
                $barang->merk = $request->merk;
                $barang->tipe = $request->tipe;
                $barang->no_seri = $request->no_seri;
                $barang->harga = $request->harga;
                $barang->qty = $request->jumlah;
                $barang->kondisi = $request->kondisi;
                $barang->deskripsi = $request->deskripsi ?? '';
                $barang->status = 1;
                $barang->updated_by = $user->id;
                $barang->save();

                $oldImage = $barang->image;

                // save images
                if (!empty($request->image_id)) {
                    $tempImage = TempImage::find($request->image_id);
                    $extArray = explode('.', $tempImage->name);
                    $ext = last($extArray);

                    $newImageName = $barang->id . '.' . $ext;
                    $sPath = public_path() . '/temp/' . $tempImage->name;
                    $dPath = public_path() . '/uploads/barang/' . $newImageName;
                    File::copy($sPath, $dPath);

                    $barang->image = $newImageName;
                    $barang->save();

                    File::delete(public_path() . '/uploads/kegiatan' . $oldImage);
                }

                // $request->session()->flash('success', 'Barang berhasil diperbarui');

                return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
            } else {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            $image = $barang->image;

            if (!empty($image)) {
                $imagePath = public_path('uploads/barang/' . $image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $barang->delete();

            $request->session()->flash('success', 'Barang berhasil dihapus');

            return response()->json([
                'status' => true,
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Exception $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal diperbarui.',
            ]);
        }
    }

    public function statusBarang(Request $request)
    {
        $id = $request->input('id_barang');
        $ruangan = Barang::findOrFail($id);
        $ruangan->status = $request->input('status');
        $ruangan->save();

        return response()->json(['message' => 'Status berhasil dirubah']);
    }

    public function detail($id)
    {
        $data['barang'] = Barang::findOrFail($id);
        $data['ruangan'] = Ruangan::get();
        $data['kategori'] = Kategori::get();

        return view('data.barang.detail', compact('data'));
    }

    public function verified(Request $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            $barang->verified = 1;

            $barang->save();

            $request->session()->flash('success', 'Barang berhasil diverifikasi');

            return response()->json(['status' => true]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function verifiedAll(Request $request)
    {
        try {
            // Verifikasi semua data
            Barang::where('verified', '=', 0)->update(['verified' => 1]);

            $request->session()->flash('success', 'Semua barang berhasil diverifikasi');

            return response()->json(['status' => true]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}

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
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    protected $permission, $barang;

    public function __construct(PermissionRepository $permission, BarangRepository $barang)
    {
        $this->permission = $permission;
        $this->barang = $barang;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/inventaris');
            return $next($request);
        });
    }

    public function index()
    {
        $data['ruangan'] = Ruangan::get();

        return view('data.asset.list', compact('data'));
    }

    public function detail($id)
    {
        $data['ruangan'] = Ruangan::find($id);
        $data['ruangans'] = Ruangan::get();
        $data['barang'] = $this->barang->getBarangByRuangan($id);
        $data['barangs'] = Barang::find($id);

        return view('data.asset.detail', compact('data'));
    }

    public function edit($id)
    {
        $data['barang'] = Barang::findOrFail($id);
        $data['ruangan'] = Ruangan::get();
        $data['kategori'] = Kategori::get();

        return view('data.asset.edit', compact('data'));
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

                return redirect()->route('inventaris.ruangan', ['id' => $barang->ruangan_id])->with('success', 'Barang berhasil diperbarui');
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

    public function getDataFor($id)
    {
        $data = DB::table('barangs')
            ->join('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
            ->select('barangs.*', 'ruangans.nama as ruangan_asal', 'ruangans.id as from_ruangan_id')
            ->where('barangs.id', $id)
            ->first();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data,
        ]);
    }
}

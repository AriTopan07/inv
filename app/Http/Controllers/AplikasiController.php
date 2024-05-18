<?php

namespace App\Http\Controllers;

use App\Http\Repository\PermissionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Aplikasi;
use App\Models\TempImage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Image;

class AplikasiController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/pengaturan-aplikasi');
            return $next($request);
        });
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "Pengaturan Aplikasi", "view") !== true) {
            return view('error.403');
        }

        $data = Aplikasi::first();

        return view('aplikasi.index', compact('data'));
    }

    public function update(Request $request)
    {
        $aplikasi = Aplikasi::first();

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'footer' => 'required',
            'sidebar' => 'required',
        ]);

        if ($validator->passes()) {
            $aplikasi->title = $request->title;
            $aplikasi->footer = $request->footer;
            $aplikasi->sidebar = $request->sidebar;
            $aplikasi->save();

            // Handle logo upload
            if (!empty($request->logo_id)) {
                $tempImageLogo = TempImage::find($request->logo_id);
                $this->handleImageUpload($tempImageLogo, 'logo', $aplikasi);
            }

            // Handle favicon upload
            if (!empty($request->favicon_id)) {
                $tempImageFavicon = TempImage::find($request->favicon_id);
                $this->handleImageUpload($tempImageFavicon, 'favicon', $aplikasi);
            }


            Alert::success('Success', 'Pengaturan Berhasil diperbarui.');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Gagal diperbarui.');
            return redirect()->back();
        }
    }

    private function handleImageUpload($tempImage, $type, $aplikasi)
    {
        $extArray = explode('.', $tempImage->name);
        $ext = last($extArray);

        $newImageName = $aplikasi->id . '-' . time() . '.' . $ext;
        $sPath = public_path() . '/temp/' . $tempImage->name;
        $dPath = public_path() . '/uploads/aplikasi/' . $newImageName;

        File::copy($sPath, $dPath);

        // Update the model with the new image
        $aplikasi->$type = $newImageName;
        $aplikasi->save();

        // Delete old image
        File::delete(public_path() . '/uploads/aplikasi/' . $tempImage->name);
    }
}

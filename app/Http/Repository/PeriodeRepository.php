<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;
use App\Models\Periode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PeriodeRepository
{

    protected $periode;

    public function __construct(Periode $con)
    {
        $this->periode = $con;
    }

    public function periode()
    {
        return DB::table('periodes')->orderBy('tahun_ajaran', 'DESC')->get();
    }

    public function detail_periode($id)
    {
        return DB::table('periodes')->where('id', $id)->first();
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'tahun_ajaran' => 'required|string|max:255'
        ]);

        if ($data->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan dalam validasi data.',
                'errors' => $data->errors()
            ], 400);
        }
    }

    public function update($request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
        ]);
    }
}

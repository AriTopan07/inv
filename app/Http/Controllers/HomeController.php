<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Session::put('active', '/');
            return $next($request);
        });
    }


    public function index()
    {
        $data = Ruangan::select('ruangans.nama as nama_ruangan')
            ->leftJoin('barangs', 'ruangans.id', '=', 'barangs.ruangan_id')
            ->selectRaw('COUNT(barangs.id) as jumlah_barang')
            ->groupBy('ruangans.id', 'ruangans.nama')
            ->get();

        return view('home', compact('data'));
    }
}

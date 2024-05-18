@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Dashboard
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="row row-cards">
                            @foreach ($data as $item)
                                <div class="col-md-3 col-lg-2 col-sm-3 col-4">
                                    <div class="card card-borderless bg-primary text-green-fg">
                                        <div class="card-stamp">
                                            <div class="card-stamp-icon bg-white text-primary">
                                                <i class="bi bi-calendar"></i>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="card-title text-center">{{ $item->nama_ruangan }}</h3>
                                            <h5 class="fw-normal text-center">Jumlah barang : {{ $item->jumlah_barang }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
@endsection

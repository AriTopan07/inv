@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Inventaris
                        </h2>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Inventaris</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="row row-cards">
                            @foreach ($data['ruangan'] as $item)
                                <div class="col-md-3 col-lg-2 col-sm-3 col-4">
                                    <a href="{{ route('inventaris.ruangan', ['id' => $item->id]) }}"
                                        class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title="Klik untuk melihat">
                                        <div class="card card-borderless bg-primary text-primary-fg">
                                            <div class="card-stamp">
                                                <div class="card-stamp-icon bg-white text-primary">
                                                    <i class="bi bi-calendar"></i>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="card-title text-center">{{ $item->nama }}</h3>
                                            </div>
                                        </div>
                                    </a>
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
    <script></script>
@endsection

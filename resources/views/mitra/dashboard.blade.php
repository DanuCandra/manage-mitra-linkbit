@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-2">TESTING FUNCTION DASHBOARD</h4>
                        <p class="mb-0">Selamat datang, <strong>{{ $mitra->nama_mitra }}</strong>!</p>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ url('') }}/assets/images/breadcrumb/ChatBc.png" alt="modernize-img"
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Total Pendapatan Bulanan -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="text-primary display-6">
                                    <i class="ti ti-currency-dollar"></i>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <h4 class="card-title fs-7 mb-1">Rp {{ number_format($pendapatanBulanan, 0, ',', '.') }}</h4>
                                <p class="card-subtitle text-primary mb-0">Pendapatan Bulanan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pelanggan -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="text-success display-6">
                                    <i class="ti ti-users"></i>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <h4 class="card-title fs-7 mb-1">{{ $totalPelanggan }}</h4>
                                <p class="card-subtitle text-success mb-0">Total Pelanggan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pelanggan Aktif -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="text-info display-6">
                                    <i class="ti ti-user-check"></i>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <h4 class="card-title fs-7 mb-1">{{ $pelangganAktif }}</h4>
                                <p class="card-subtitle text-info mb-0">Pelanggan Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pelanggan Non-Aktif -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="text-danger display-6">
                                    <i class="ti ti-user-x"></i>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <h4 class="card-title fs-7 mb-1">{{ $pelangganNonAktif }}</h4>
                                <p class="card-subtitle text-danger mb-0">Pelanggan Non-Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Total Produk -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="text-warning display-6">
                                    <i class="ti ti-package"></i>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <h4 class="card-title fs-7 mb-1">{{ $totalProduk }}</h4>
                                <p class="card-subtitle text-warning mb-0">Total Produk</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pelanggan Baru Bulan Ini -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-secondary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="text-secondary display-6">
                                    <i class="ti ti-user-plus"></i>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <h4 class="card-title fs-7 mb-1">{{ $pelangganBaru }}</h4>
                                <p class="card-subtitle text-secondary mb-0">Pelanggan Baru</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-cyan">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="text-cyan display-6">
                                    <i class="ti ti-cash"></i>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <h4 class="card-title fs-7 mb-1">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h4>
                                <p class="card-subtitle text-cyan mb-0">Pendapatan Bulan Ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Harga Produk -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-indigo">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="text-indigo display-6">
                                    <i class="ti ti-chart-bar"></i>
                                </span>
                            </div>
                            <div class="ms-auto text-end">
                                <h4 class="card-title fs-7 mb-1">Rp {{ number_format($rataRataHargaProduk, 0, ',', '.') }}</h4>
                                <p class="card-subtitle text-indigo mb-0">Rata-rata Harga</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris -->
        @if($produkTerlaris)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-trophy text-warning me-2"></i>
                            Produk Terlaris
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $produkTerlaris->nama_produk }}</h6>
                                <p class="text-muted mb-0">
                                    Bandwidth: {{ $produkTerlaris->bandwidth }} |
                                    Harga: Rp {{ number_format($produkTerlaris->harga, 0, ',', '.') }} |
                                    Pelanggan: {{ $produkTerlaris->pelanggan_count }} orang
                                </p>
                            </div>
                            <div>
                                <span class="badge bg-success fs-4">{{ $produkTerlaris->pelanggan_count }} Pelanggan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
@endsection

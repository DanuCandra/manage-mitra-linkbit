@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Detail Pelanggan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('pelanggan.manage') }}">Pelanggan</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Detail Pelanggan</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ url('') }}/assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start Form with view only -->
    <div class="card">
        <div class="card-header text-bg-primary">
            <h5 class="mb-0 text-white">Detail Informasi Pelanggan</h5>
        </div>
        <form class="form-horizontal">
            <div class="form-body">
                <div class="card-body">
                    <h5 class="card-title mb-0">Informasi Pelanggan</h5>
                </div>
                <hr class="m-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">ID Pelanggan:</label>
                                <div class="col-md-9">
                                    <p>{{ $pelanggan->id_pelanggan ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Nama Pelanggan:</label>
                                <div class="col-md-9">
                                    <p>{{ $pelanggan->nama }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">NIK:</label>
                                <div class="col-md-9">
                                    <p>{{ $pelanggan->nik }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Mulai Berlangganan:</label>
                                <div class="col-md-9">
                                    <p>{{ \Carbon\Carbon::parse($pelanggan->mulai_berlangganan)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3 col-lg-1">Alamat:</label>
                                <div class="col-md-9 col-lg-11">
                                    <p>{{ $pelanggan->alamat }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="m-0" />
                <div class="card-body">
                    <h5 class="card-title mb-0">Paket Langganan</h5>
                </div>
                <hr class="m-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Produk:</label>
                                <div class="col-md-9">
                                    <p>{{ $pelanggan->produk->nama_produk ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Bandwidth:</label>
                                <div class="col-md-9">
                                    <p>{{ $pelanggan->produk->bandwidth ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Harga:</label>
                                <div class="col-md-9">
                                    <p>Rp {{ number_format($pelanggan->produk->harga ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Status:</label>
                                <div class="col-md-9">
                                    <p>
                                        @if($pelanggan->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions border-top">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-primary">
                                            <i class="ti ti-edit fs-5"></i>
                                            Edit
                                        </a>
                                        <a href="{{ route('pelanggan.manage') }}" class="btn bg-danger-subtle text-danger ms-6">
                                            <i class="ti ti-arrow-left me-1"></i>
                                            Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

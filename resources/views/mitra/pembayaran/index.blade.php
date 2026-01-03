@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Bayar Tagihan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Bayar Tagihan</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ url('') }}/assets/images/breadcrumb/ChatBc.png" alt=""
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tagihan yang Belum Lunas</h5>
        </div>
        <div class="card-body">
            @if ($tagihanBelumLunas->isEmpty())
                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i> Tidak ada tagihan yang perlu dibayar.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No Tagihan</th>
                                <th>Tanggal</th>
                                <th>Jatuh Tempo</th>
                                <th>Total</th>
                                <th>Sisa</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihanBelumLunas as $item)
                                <tr>
                                    <td><strong>{{ $item->no_tagihan }}</strong></td>
                                    <td>{{ $item->tanggal_tagihan->format('d M Y') }}</td>
                                    <td>
                                        {{ $item->tanggal_jatuh_tempo->format('d M Y') }}
                                        @if ($item->isJatuhTempo())
                                            <br><span class="badge bg-danger">Terlambat</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->total_format }}</td>
                                    <td><strong class="text-danger">{{ $item->sisa_format }}</strong></td>
                                    <td>
                                        @if ($item->status_pembayaran === 'cicilan')
                                            <span class="badge bg-primary">Cicilan</span>
                                        @elseif($item->status_pembayaran === 'terlambat')
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-warning">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/mitra/pembayaran/create/' . $item->id) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="ti ti-credit-card"></i> Bayar Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

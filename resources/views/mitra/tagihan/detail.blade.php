@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Detail Tagihan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/mitra/tagihan') }}">Tagihan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
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

    <div class="row">
        <div class="col-md-8">
            {{-- Info Tagihan --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Tagihan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>No Tagihan:</strong></div>
                        <div class="col-md-8">
                            <span class="badge bg-primary fs-4">{{ $tagihan->no_tagihan }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Bandwidth:</strong></div>
                        <div class="col-md-8">{{ $tagihan->bandwidth }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Harga Bandwidth:</strong></div>
                        <div class="col-md-8">{{ $tagihan->harga_format }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Tagihan:</strong></div>
                        <div class="col-md-8">{{ $tagihan->tanggal_tagihan->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Jatuh Tempo:</strong></div>
                        <div class="col-md-8">
                            {{ $tagihan->tanggal_jatuh_tempo->format('d F Y') }}
                            @if ($tagihan->isJatuhTempo())
                                <span class="badge bg-danger">Terlambat</span>
                            @endif
                        </div>
                    </div>
                    @if ($tagihan->keterangan)
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Keterangan:</strong></div>
                            <div class="col-md-8">{{ $tagihan->keterangan }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Riwayat Pembayaran --}}
            @if ($tagihan->pembayaran->count() > 0)
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Riwayat Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Pembayaran</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tagihan->pembayaran as $bayar)
                                        <tr>
                                            <td>{{ $bayar->no_pembayaran }}</td>
                                            <td>{{ $bayar->tanggal_bayar->format('d M Y') }}</td>
                                            <td>{{ $bayar->jumlah_format }}</td>
                                            <td>
                                                @if ($bayar->status_verifikasi === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($bayar->status_verifikasi === 'diterima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('/mitra/riwayat-pembayaran/detail/' . $bayar->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="ti ti-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            {{-- Summary --}}
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Total Tagihan:</strong></td>
                            <td class="text-end">{{ $tagihan->total_format }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Dibayar:</strong></td>
                            <td class="text-end text-success">
                                Rp {{ number_format($tagihan->total_dibayar, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr class="border-top">
                            <td><strong>Sisa Tagihan:</strong></td>
                            <td class="text-end">
                                <h4 class="text-danger mb-0">{{ $tagihan->sisa_format }}</h4>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-3 text-center">
                        @if ($tagihan->status_pembayaran === 'lunas')
                            <span class="badge bg-success fs-4 px-4 py-2">
                                <i class="ti ti-check"></i> LUNAS
                            </span>
                        @else
                            <a href="{{ url('/mitra/pembayaran/create/' . $tagihan->id) }}" class="btn btn-success w-100">
                                <i class="ti ti-credit-card"></i> Bayar Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Status Card --}}
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Status Tagihan</h5>
                </div>
                <div class="card-body text-center">
                    @if ($tagihan->status_pembayaran === 'lunas')
                        <span class="badge bg-success fs-5 px-4 py-2">Lunas</span>
                    @elseif($tagihan->status_pembayaran === 'cicilan')
                        <span class="badge bg-primary fs-5 px-4 py-2">Cicilan</span>
                    @elseif($tagihan->status_pembayaran === 'terlambat')
                        <span class="badge bg-danger fs-5 px-4 py-2">Terlambat</span>
                    @else
                        <span class="badge bg-warning fs-5 px-4 py-2">Belum Bayar</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

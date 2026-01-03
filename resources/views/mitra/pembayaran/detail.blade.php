@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Detail Pembayaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none"
                                    href="{{ url('/mitra/riwayat-pembayaran') }}">Riwayat Pembayaran</a>
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
            {{-- Info Pembayaran --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>No Pembayaran:</strong></div>
                        <div class="col-md-8">
                            <span class="badge bg-primary fs-4">{{ $pembayaran->no_pembayaran }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>No Tagihan:</strong></div>
                        <div class="col-md-8">
                            <a href="{{ url('/mitra/tagihan/detail/' . $pembayaran->tagihan->id) }}" class="text-primary">
                                {{ $pembayaran->tagihan->no_tagihan }}
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Jenis Pembayaran:</strong></div>
                        <div class="col-md-8">
                            @if ($pembayaran->jenis_pembayaran === 'full')
                                <span class="badge bg-info">Lunas (Full)</span>
                            @else
                                <span class="badge bg-primary">Cicilan</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Jumlah Bayar:</strong></div>
                        <div class="col-md-8">
                            <h4 class="text-success mb-0">{{ $pembayaran->jumlah_format }}</h4>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Tanggal Transfer:</strong></div>
                        <div class="col-md-8">{{ $pembayaran->tanggal_bayar->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Bank Tujuan:</strong></div>
                        <div class="col-md-8">
                            {{ $pembayaran->accountBank->nama_bank }} -
                            {{ $pembayaran->accountBank->nomor_rekening }}<br>
                            <small class="text-muted">a.n {{ $pembayaran->accountBank->atas_nama }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Nama Pengirim:</strong></div>
                        <div class="col-md-8">{{ $pembayaran->nama_pengirim }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Bank Pengirim:</strong></div>
                        <div class="col-md-8">{{ $pembayaran->bank_pengirim }}</div>
                    </div>
                    @if ($pembayaran->catatan)
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Catatan:</strong></div>
                            <div class="col-md-8">{{ $pembayaran->catatan }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bukti Transfer --}}
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Bukti Transfer</h5>
                </div>
                <div class="card-body text-center">
                    @if ($pembayaran->bukti_bayar)
                        <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" alt="Bukti Transfer"
                            class="img-fluid rounded border" style="max-height: 500px;">
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" target="_blank"
                                class="btn btn-primary">
                                <i class="ti ti-download"></i> Download Bukti
                            </a>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada bukti transfer</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Status Verifikasi --}}
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Status Verifikasi</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if ($pembayaran->status_verifikasi === 'pending')
                            <span class="badge bg-warning fs-5 px-4 py-2">
                                <i class="ti ti-clock"></i> Menunggu Verifikasi
                            </span>
                            <p class="text-muted mt-3 mb-0 small">Pembayaran Anda sedang diverifikasi oleh admin. Harap
                                tunggu 1-2 hari kerja.</p>
                        @elseif($pembayaran->status_verifikasi === 'diterima')
                            <span class="badge bg-success fs-5 px-4 py-2">
                                <i class="ti ti-check"></i> Pembayaran Diterima
                            </span>
                            <p class="text-success mt-3 mb-0">Pembayaran Anda telah diverifikasi dan diterima!</p>
                        @else
                            <span class="badge bg-danger fs-5 px-4 py-2">
                                <i class="ti ti-x"></i> Pembayaran Ditolak
                            </span>
                        @endif
                    </div>

                    @if ($pembayaran->status_verifikasi !== 'pending')
                        <hr>
                        <p class="mb-2"><strong>Tanggal Verifikasi:</strong><br>
                            {{ $pembayaran->tanggal_verifikasi->format('d F Y H:i') }}</p>
                        <p class="mb-0"><strong>Diverifikasi oleh:</strong><br>
                            {{ $pembayaran->verifiedBy->name ?? '-' }}</p>

                        @if ($pembayaran->status_verifikasi === 'ditolak' && $pembayaran->alasan_ditolak)
                            <hr>
                            <div class="alert alert-danger mb-0">
                                <strong>Alasan Ditolak:</strong><br>
                                {{ $pembayaran->alasan_ditolak }}
                            </div>
                            <div class="mt-3 text-center">
                                <a href="{{ url('/mitra/pembayaran/create/' . $pembayaran->tagihan_id) }}"
                                    class="btn btn-warning w-100">
                                    <i class="ti ti-refresh"></i> Bayar Ulang
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Info Tagihan --}}
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Info Tagihan</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total Tagihan:</strong><br>
                        <span class="text-primary fs-5">{{ $pembayaran->tagihan->total_format }}</span>
                    </p>
                    <p><strong>Total Dibayar:</strong><br>
                        <span class="text-success fs-5">Rp
                            {{ number_format($pembayaran->tagihan->total_dibayar, 0, ',', '.') }}</span>
                    </p>
                    <p><strong>Sisa Tagihan:</strong><br>
                        <span class="text-danger fs-5">{{ $pembayaran->tagihan->sisa_format }}</span>
                    </p>
                    <p class="mb-0"><strong>Status Tagihan:</strong><br>
                        @if ($pembayaran->tagihan->status_pembayaran === 'lunas')
                            <span class="badge bg-success">Lunas</span>
                        @elseif($pembayaran->tagihan->status_pembayaran === 'cicilan')
                            <span class="badge bg-primary">Cicilan</span>
                        @else
                            <span class="badge bg-warning">Belum Bayar</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

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
                                <a class="text-muted text-decoration-none" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/admin/tagihan') }}">Kelola
                                    Tagihan</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Detail</li>
                        </ol>
                    </nav>
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

    {{-- Informasi Tagihan --}}
    <div class="card">
        <div class="card-header text-bg-primary">
            <h4 class="mb-0 text-white">{{ $tagihan->no_tagihan }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title mb-3">Informasi Mitra</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%"><strong>Nama Mitra</strong></td>
                            <td>: {{ $tagihan->mitra->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Brand</strong></td>
                            <td>: {{ $tagihan->mitra->nama_brand ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Bandwidth</strong></td>
                            <td>: <span class="badge bg-info">{{ $tagihan->bandwidth }}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title mb-3">Informasi Tagihan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%"><strong>Tanggal Tagihan</strong></td>
                            <td>: {{ $tagihan->tanggal_tagihan->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jatuh Tempo</strong></td>
                            <td>: {{ $tagihan->tanggal_jatuh_tempo->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Keterangan</strong></td>
                            <td>: {{ $tagihan->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title mb-3">Detail Pembayaran</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr class="table-light">
                                <td><strong>Total Tagihan</strong></td>
                                <td class="text-end"><strong>{{ $tagihan->total_format }}</strong></td>
                            </tr>
                            <tr>
                                <td>Total Dibayar</td>
                                <td class="text-end text-success">
                                    {{ $tagihan->mitra->getTotalDibayarFormatAttribute($tagihan->id) ?? 'Rp 0' }}</td>
                            </tr>
                            <tr>
                                <td>Sisa Tagihan</td>
                                <td class="text-end text-danger"><strong>{{ $tagihan->sisa_format }}</strong></td>
                            </tr>
                            <tr class="table-info">
                                <td><strong>Status Pembayaran</strong></td>
                                <td class="text-end">
                                    @if ($tagihan->status_pembayaran == 'belum_bayar')
                                        <span class="badge bg-warning">Belum Bayar</span>
                                    @elseif($tagihan->status_pembayaran == 'cicilan')
                                        <span class="badge bg-info">Cicilan</span>
                                    @elseif($tagihan->status_pembayaran == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-danger">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Riwayat Pembayaran --}}
            @if ($tagihan->pembayaran->count() > 0)
                <hr>
                <h5 class="card-title mb-3">Riwayat Pembayaran</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>No Pembayaran</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Bank Tujuan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->pembayaran as $pembayaran)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pembayaran->no_pembayaran }}</td>
                                    <td>{{ $pembayaran->tanggal_bayar->format('d M Y') }}</td>
                                    <td>{{ $pembayaran->jumlah_format }}</td>
                                    <td>{{ $pembayaran->accountBank->nama_bank ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $pembayaran->status_badge }}">
                                            {{ ucfirst($pembayaran->status_verifikasi) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/pembayaran/detail/' . $pembayaran->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="ti ti-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mt-3">
                    <i class="ti ti-alert-circle"></i> Belum ada pembayaran untuk tagihan ini.
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ url('/admin/tagihan') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

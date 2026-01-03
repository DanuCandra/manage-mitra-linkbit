@extends('layouts.main')

@section('content')
    {{-- Breadcrumb --}}
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Tagihan Saya</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tagihan</li>
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

    {{-- Stats Cards dengan Animasi --}}
    <div class="row mb-4">
        {{-- Total Tagihan (Belum Lunas) --}}
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm hover-shadow-lg transition-all"
                style="border-left: 4px solid #5D87FF !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Total Tagihan Aktif</p>
                            <h3 class="fw-bold text-primary mb-0">
                                Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="bg-primary-subtle rounded-circle p-3">
                            <i class="ti ti-file-invoice fs-6 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Dibayar --}}
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm hover-shadow-lg transition-all"
                style="border-left: 4px solid #13DEB9 !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Total Dibayar</p>
                            <h3 class="fw-bold text-success mb-0">
                                Rp {{ number_format($totalDibayar, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="bg-success-subtle rounded-circle p-3">
                            <i class="ti ti-check fs-6 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sisa Tagihan --}}
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm hover-shadow-lg transition-all"
                style="border-left: 4px solid #FA896B !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Sisa Tagihan</p>
                            <h3 class="fw-bold text-danger mb-0">
                                Rp {{ number_format($totalSisa, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="bg-danger-subtle rounded-circle p-3">
                            <i class="ti ti-alert-circle fs-6 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Belum Dibayar --}}
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm hover-shadow-lg transition-all"
                style="border-left: 4px solid #FFAE1F !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Belum Dibayar</p>
                            <h3 class="fw-bold text-warning mb-0">
                                {{ $tagihanBelumBayar }} <small class="fs-5">Tagihan</small>
                            </h3>
                        </div>
                        <div class="bg-warning-subtle rounded-circle p-3">
                            <i class="ti ti-clock fs-6 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Tagihan dengan Design Modern --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 fw-semibold">Daftar Tagihan</h5>
                    <p class="text-muted mb-0 small">Kelola semua tagihan Anda di sini</p>
                </div>
                <div>
                    <span class="badge bg-light-primary text-primary px-3 py-2">
                        Total: {{ $tagihan->total() }} Tagihan
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 50px;">No</th>
                            <th class="py-3">No Tagihan</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Jatuh Tempo</th>
                            <th class="py-3 text-end">Total Tagihan</th>
                            <th class="py-3 text-end">Dibayar</th>
                            <th class="py-3 text-end">Sisa</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center pe-4" style="width: 180px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tagihan as $index => $item)
                            <tr class="border-bottom">
                                {{-- Nomor --}}
                                <td class="ps-4">
                                    <span class="text-muted">{{ $tagihan->firstItem() + $index }}</span>
                                </td>

                                {{-- No Tagihan --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light-primary rounded p-2 me-2">
                                            <i class="ti ti-file-invoice text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <strong class="d-block">{{ $item->no_tagihan }}</strong>
                                            <small class="text-muted">{{ $item->keterangan ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Tanggal --}}
                                <td>
                                    <span class="text-dark">{{ $item->tanggal_tagihan->format('d M Y') }}</span>
                                </td>

                                {{-- Jatuh Tempo --}}
                                <td>
                                    <div>
                                        <span
                                            class="d-block text-dark">{{ $item->tanggal_jatuh_tempo->format('d M Y') }}</span>
                                        @if ($item->isJatuhTempo())
                                            <span class="badge bg-danger-subtle text-danger mt-1">
                                                <i class="ti ti-clock fs-5"></i> Terlambat
                                            </span>
                                        @else
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::now()->diffInDays($item->tanggal_jatuh_tempo) }} hari
                                                lagi
                                            </small>
                                        @endif
                                    </div>
                                </td>

                                {{-- Total Tagihan --}}
                                <td class="text-end">
                                    <strong class="text-primary">{{ $item->total_format }}</strong>
                                </td>

                                {{-- Dibayar --}}
                                <td class="text-end">
                                    @if ($item->total_dibayar > 0)
                                        <span class="text-success fw-semibold">
                                            Rp {{ number_format($item->total_dibayar, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- Sisa --}}
                                <td class="text-end">
                                    @if ($item->sisa_tagihan > 0)
                                        <strong class="text-danger">
                                            Rp {{ number_format($item->sisa_tagihan, 0, ',', '.') }}
                                        </strong>
                                    @else
                                        <span class="text-muted fw-semibold">
                                            Rp 0
                                        </span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="text-center">
                                    @if ($item->status_pembayaran === 'lunas')
                                        <span class="badge bg-success-subtle text-success px-3 py-2">
                                            <i class="ti ti-circle-check"></i> Lunas
                                        </span>
                                    @elseif($item->status_pembayaran === 'cicilan')
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                            <i class="ti ti-clock"></i> Cicilan
                                        </span>
                                    @elseif($item->status_pembayaran === 'terlambat')
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                            <i class="ti ti-alert-triangle"></i> Terlambat
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                            <i class="ti ti-alert-circle"></i> Belum Bayar
                                        </span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td class="text-center pe-4">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ url('/mitra/tagihan/detail/' . $item->id) }}"
                                            class="btn btn-sm btn-light-info text-info" data-bs-toggle="tooltip"
                                            title="Lihat Detail">
                                            <i class="ti ti-eye"></i>
                                        </a>

                                        @if ($item->status_pembayaran !== 'lunas')
                                            <a href="{{ url('/mitra/pembayaran/create/' . $item->id) }}"
                                                class="btn btn-sm btn-success" data-bs-toggle="tooltip"
                                                title="Bayar Tagihan">
                                                <i class="ti ti-credit-card"></i> Bayar
                                            </a>
                                        @else
                                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                                <i class="ti ti-check"></i> Lunas
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="my-4">
                                        <i class="ti ti-inbox fs-1 text-muted"></i>
                                        <p class="text-muted mt-3 mb-0">Belum ada tagihan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($tagihan->hasPages())
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $tagihan->firstItem() }} sampai {{ $tagihan->lastItem() }} dari
                        {{ $tagihan->total() }} tagihan
                    </div>
                    <div>
                        {{ $tagihan->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
@endsection

<style>
    /* Custom Styles */
    .hover-shadow-lg {
        transition: all 0.3s ease;
    }

    .hover-shadow-lg:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    .btn-light-info {
        background-color: rgba(93, 135, 255, 0.1);
        border: none;
    }

    .btn-light-info:hover {
        background-color: rgba(93, 135, 255, 0.2);
    }

    /* Badge Styles */
    .bg-light-primary {
        background-color: rgba(93, 135, 255, 0.1) !important;
    }

    .bg-success-subtle {
        background-color: rgba(19, 222, 185, 0.1) !important;
    }

    .bg-primary-subtle {
        background-color: rgba(93, 135, 255, 0.1) !important;
    }

    .bg-danger-subtle {
        background-color: rgba(250, 137, 107, 0.1) !important;
    }

    .bg-warning-subtle {
        background-color: rgba(255, 174, 31, 0.1) !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }

        .card-body {
            padding: 1rem !important;
        }
    }
</style>

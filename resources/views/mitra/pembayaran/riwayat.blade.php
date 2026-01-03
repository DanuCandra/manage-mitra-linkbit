@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Riwayat Pembayaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Riwayat Pembayaran</li>
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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="fw-semibold mb-1">{{ $totalPending }}</h4>
                            <p class="mb-0">Menunggu Verifikasi</p>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-warning rounded-circle p-3">
                                <i class="ti ti-clock fs-6"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="fw-semibold mb-1">{{ $totalDiterima }}</h4>
                            <p class="mb-0">Diterima</p>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-success rounded-circle p-3">
                                <i class="ti ti-check fs-6"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="fw-semibold mb-1">{{ $totalDitolak }}</h4>
                            <p class="mb-0">Ditolak</p>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-danger rounded-circle p-3">
                                <i class="ti ti-x fs-6"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Pembayaran --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablePembayaran" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Pembayaran</th>
                            <th>No Tagihan</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayaran as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $item->no_pembayaran }}</strong></td>
                                <td>{{ $item->tagihan->no_tagihan }}</td>
                                <td>{{ $item->tanggal_bayar->format('d M Y') }}</td>
                                <td>
                                    @if ($item->jenis_pembayaran === 'full')
                                        <span class="badge bg-info">Full</span>
                                    @else
                                        <span class="badge bg-primary">Cicilan</span>
                                    @endif
                                </td>
                                <td>{{ $item->jumlah_format }}</td>
                                <td>
                                    @if ($item->status_verifikasi === 'pending')
                                        <span class="badge bg-warning">
                                            <i class="ti ti-clock"></i> Pending
                                        </span>
                                    @elseif($item->status_verifikasi === 'diterima')
                                        <span class="badge bg-success">
                                            <i class="ti ti-check"></i> Diterima
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="ti ti-x"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/mitra/riwayat-pembayaran/detail/' . $item->id) }}"
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tablePembayaran').DataTable({
                "order": [
                    [3, "desc"]
                ]
            });
        });
    </script>
@endsection

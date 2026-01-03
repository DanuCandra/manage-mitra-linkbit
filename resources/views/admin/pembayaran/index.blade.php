@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Verifikasi Pembayaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/admin-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Verifikasi Pembayaran</li>
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

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter & Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="fw-semibold mb-1">{{ $pendingCount }}</h4>
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
                            <h4 class="fw-semibold mb-1">{{ $diterimaCount }}</h4>
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
                            <h4 class="fw-semibold mb-1">{{ $ditolakCount }}</h4>
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

    {{-- Filter Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ url('admin/pembayaran') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status Verifikasi</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jenis Pembayaran</label>
                    <select name="jenis" class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="full" {{ request('jenis') == 'full' ? 'selected' : '' }}>Full</option>
                        <option value="cicilan" {{ request('jenis') == 'cicilan' ? 'selected' : '' }}>Cicilan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="No Pembayaran / Nama Mitra"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search"></i> Filter
                    </button>
                </div>
            </form>
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
                            <th>Mitra</th>
                            <th>No Tagihan</th>
                            <th>Jenis</th>
                            <th>Jumlah Bayar</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayaran as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->no_pembayaran }}</strong>
                                </td>
                                <td>{{ $item->tagihan->mitra->nama_mitra ?? '-' }}</td>
                                <td>{{ $item->tagihan->no_tagihan ?? '-' }}</td>
                                <td>
                                    @if ($item->jenis_pembayaran === 'full')
                                        <span class="badge bg-info">Full</span>
                                    @else
                                        <span class="badge bg-primary">Cicilan</span>
                                    @endif
                                </td>
                                <td>{{ $item->jumlah_format }}</td>
                                <td>{{ $item->tanggal_bayar->format('d M Y') }}</td>
                                <td>
                                    @if ($item->status_verifikasi === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($item->status_verifikasi === 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/pembayaran/detail/' . $item->id) }}"
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
                    [6, "desc"]
                ],
                "pageLength": 25
            });
        });
    </script>
@endsection

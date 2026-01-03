@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Kelola Tagihan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Kelola Tagihan</li>
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

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="card-title mb-0">Semua Tagihan</h4>
                    <a href="{{ url('/admin/tagihan/create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Buat Tagihan
                    </a>
                </div>

                <p class="card-subtitle mb-3">Kelola tagihan bandwidth untuk mitra</p>

                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Tagihan</th>
                                <th>Mitra</th>
                                <th>Bandwidth</th>
                                <th>Total Tagihan</th>
                                <th>Sisa Tagihan</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $item->no_tagihan }}</strong></td>
                                    <td>{{ $item->mitra->user->name ?? '-' }}</td>
                                    <td>{{ $item->bandwidth }}</td>
                                    <td>{{ $item->total_format }}</td>
                                    <td>{{ $item->sisa_format }}</td>
                                    <td>{{ $item->tanggal_jatuh_tempo->format('d M Y') }}</td>
                                    <td>
                                        @if ($item->status_pembayaran == 'belum_bayar')
                                            <span class="badge bg-warning">Belum Bayar</span>
                                        @elseif($item->status_pembayaran == 'cicilan')
                                            <span class="badge bg-info">Cicilan</span>
                                        @elseif($item->status_pembayaran == 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-danger">Terlambat</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ url('/admin/tagihan/detail/' . $item->id) }}"
                                                class="btn mb-1 bg-info-subtle text-info px-4 fs-4">
                                                <i class="ti ti-eye"></i>
                                            </a>

                                            @if ($item->pembayaran()->count() == 0)
                                                <button type="button"
                                                    class="btn mb-1 bg-warning-subtle text-warning px-4 fs-4"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit_tagihan_{{ $item->id }}">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div id="edit_tagihan_{{ $item->id }}" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-warning text-white">
                                                <h4 class="modal-title text-white">Konfirmasi Edit Tagihan</h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin mengedit tagihan ini?</h5>
                                                <p>No Tagihan: <strong>{{ $item->no_tagihan }}</strong><br>
                                                    Mitra: <strong>{{ $item->mitra->user->name ?? '-' }}</strong></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <a href="{{ url('/admin/tagihan/edit/' . $item->id) }}"
                                                    class="btn bg-warning-subtle text-warning">Ya, Edit Sekarang</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>No Tagihan</th>
                                <th>Mitra</th>
                                <th>Bandwidth</th>
                                <th>Total Tagihan</th>
                                <th>Sisa Tagihan</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

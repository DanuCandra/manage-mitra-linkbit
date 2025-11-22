@extends('layouts.main')
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Semua Data Pelanggan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route('pelanggan.manage') }}">Pelanggan</a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="../assets/images/breadcrumb/ChatBc.png" alt="img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="datatables">
        <div class="card">
            <div class="card-body">

                <!-- Header dengan Filter yang Cantik -->
                <div class="row align-items-center mb-4">
                    <div class="col-md-6 col-12 mb-3 mb-md-0">
                        <h4 class="card-title mb-0">Semua Pelanggan</h4>
                        <p class="text-muted small mb-0 mt-1">Kelola data pelanggan Anda</p>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end justify-content-start">
                            <!-- Filter Status -->
                            <form action="{{ route('pelanggan.manage') }}" method="GET"
                                class="d-flex gap-2 grow flex-md-grow-0">
                                <div class="input-group" style="max-width: 250px;">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ti ti-filter fs-5"></i>
                                    </span>
                                    <select name="status" class="form-select border-start-0" onchange="this.form.submit()">
                                        <option value="" {{ $status == '' ? 'selected' : '' }}>Semua Status</option>
                                        <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>
                                            <i class="ti ti-circle-check"></i> Aktif
                                        </option>
                                        <option value="non-aktif" {{ $status == 'non-aktif' ? 'selected' : '' }}>
                                            <i class="ti ti-circle-x"></i> Non-Aktif
                                        </option>
                                    </select>
                                </div>

                                @if ($status != '')
                                    <a href="{{ route('pelanggan.manage') }}" class="btn btn-light border"
                                        title="Reset Filter">
                                        <i class="ti ti-x"></i>
                                    </a>
                                @endif
                            </form>

                            <!-- Tombol Tambah -->
                            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i> Tambah Pelanggan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Filter Aktif -->
                @if ($status != '')
                    <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                        <i class="ti ti-info-circle me-2"></i>
                        Menampilkan pelanggan dengan status:
                        <strong>{{ ucfirst($status) }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>Produk</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($pelanggan as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->id_pelanggan ?? '-' }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->produk->nama_produk ?? '-' }}</td>
                                    <td>
                                        @if ($p->status === 'aktif')
                                            <span class="badge bg-success">
                                                <i class="ti ti-circle-check"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="ti ti-circle-x"></i> Non-Aktif
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('pelanggan.view', $p->id) }}"
                                                    class="btn mb-1 bg-info-subtle text-info px-4 fs-4"
                                                    title="Lihat Pelanggan">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <!-- Tombol Edit -->
                                                <a type="button" class="btn mb-1 bg-warning-subtle text-warning px-4 fs-4"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit_produk_{{ $p->id }}" title="Edit Produk">
                                                    <i class="ti ti-edit"></i>
                                                </a>

                                                <!-- Tombol Hapus -->
                                                <a type="button" class="btn mb-1 bg-danger-subtle text-danger px-4 fs-4"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapus_pelanggan_{{ $p->id }}"
                                                    title="Hapus Produk">
                                                    <i class="ti ti-trash"></i>
                                                </a>

                                            </div>
                                    </td>
                                </tr>

                                <div id="edit_produk_{{ $p->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="edit_produk_label_{{ $p->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-warning text-white">
                                                <h4 class="modal-title text-white"
                                                    id="edit_produk_label_{{ $p->id }}">
                                                    Konfirmasi Edit Pelanggan
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin mengedit pelanggan
                                                    <strong>{{ $p->nama }}</strong> ?
                                                </h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <a href="{{ route('pelanggan.edit', $p->id) }}"
                                                    class="btn bg-warning-subtle text-warning">
                                                    Ya, Edit Sekarang
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div id="hapus_pelanggan_{{ $p->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="hapusPelangganLabel{{ $p->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger text-white">
                                                <h4 class="modal-title text-white">
                                                    Konfirmasi Hapus Pelanggan
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>Apakah Anda yakin ingin menghapus pelanggan
                                                    <strong>{{ $p->nama }}</strong> ?
                                                </h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Batal</button>

                                                <form action="{{ route('pelanggan.destroy', $p->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn bg-danger-subtle text-danger">
                                                        Ya, Hapus Sekarang
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>ID Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>Produk</th>
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

@extends('layouts.main')
@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Semua Data Produk</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route('produk.manage') }}">Produk</a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="../assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="datatables">
        <!-- start File export -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="card-title mb-0">Semua Produk</h4>
                    <a href="{{ url('/produk/create/') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Produk
                    </a>
                </div>

                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>

                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Bandwidth</th>
                                <th>Harga</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($produk as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->bandwidth }}</td>
                                    <td>{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">

                                            <!-- Tombol Edit -->
                                            <a type="button" class="btn mb-1 bg-warning-subtle text-warning px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#edit_produk_{{ $item->id }}"
                                                title="Edit Produk">
                                                <i class="ti ti-edit"></i>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <a type="button" class="btn mb-1 bg-danger-subtle text-danger px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#hapus_produk_{{ $item->id }}"
                                                title="Hapus Produk">
                                                <i class="ti ti-trash"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>

                                <!-- ==================== MODAL EDIT PRODUK ==================== -->
                                <div id="edit_produk_{{ $item->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="edit_produk_label_{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-warning text-white">
                                                <h4 class="modal-title text-white"
                                                    id="edit_produk_label_{{ $item->id }}">
                                                    Konfirmasi Edit Produk
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin mengedit produk
                                                    <strong>{{ $item->nama_produk }}</strong> ?
                                                </h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <a href="{{ route('produk.edit', $item->id) }}"
                                                    class="btn bg-warning-subtle text-warning">
                                                    Ya, Edit Sekarang
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ==================== MODAL HAPUS PRODUK ==================== -->
                                <div id="hapus_produk_{{ $item->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="hapus_produk_label_{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger text-white">
                                                <h4 class="modal-title text-white"
                                                    id="hapus_produk_label_{{ $item->id }}">
                                                    Konfirmasi Hapus Produk
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin menghapus produk
                                                    <strong>{{ $item->nama_produk }}</strong> ?
                                                </h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <form action="{{ route('produk.destroy', $item->id) }}" method="POST">
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
                            @endforeach

                        </tbody>
                        <tfoot>
                            <!-- start row -->
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Bandwidth</th>
                                <th>Harga</th>
                                <th>Action</th>
                            </tr>
                            <!-- end row -->
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end File export -->
@endsection

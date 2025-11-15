@extends('layouts.main')

@section('content')
    <div class="datatables">
        <!-- start File export -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="card-title mb-0">Semua Dokumen</h4>
                    <a href="{{ url('/dokumen/create/') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Dokumen
                    </a>
                </div>

                <p class="card-subtitle mb-3"></p>

                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mitra</th>
                                <th>Tahun</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dokumen as $dok)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dok->mitra->nama_mitra }}</td>
                                    <td>{{ $dok->tahun }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn mb-1 bg-warning-subtle text-warning px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#edit_user_{{ $dok->id }}"
                                                title="Edit Dokumen">
                                                <i class="ti ti-edit"></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <button type="button" class="btn mb-1 bg-danger-subtle text-danger px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#hapus_user_{{ $dok->id }}"
                                                title="Hapus Dokumen">
                                                <i class="ti ti-trash"></i>
                                            </button>

                                            <!-- Tombol View -->
                                            <a href="{{ route('dokumen.view', $dok->id) }}"
                                                class="btn mb-1 bg-info-subtle text-info px-4 fs-4" title="Lihat Dokumen">
                                                <i class="ti ti-eye"></i>
                                            </a>

                                            <!-- Tombol Download All (ZIP) -->
                                            <a href="{{ route('dokumen.downloadAll', $dok->id) }}"
                                                class="btn mb-1 bg-success-subtle text-success px-4 fs-4"
                                                title="Download Semua Dokumen (ZIP)">
                                                <i class="ti ti-download"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div id="edit_user_{{ $dok->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="edit_user_label_{{ $dok->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-warning text-white">
                                                <h4 class="modal-title text-white"
                                                    id="edit_user_label_{{ $dok->id }}">
                                                    Konfirmasi Edit Dokumen
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin mengedit data dokumen ini?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <a href="{{ url('/dokumen/edit/' . $dok->id) }}"
                                                    class="btn bg-warning-subtle text-warning">
                                                    Ya, Edit Sekarang
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div id="hapus_user_{{ $dok->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="hapus_user_label_{{ $dok->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger text-white">
                                                <h4 class="modal-title text-white"
                                                    id="hapus_user_label_{{ $dok->id }}">
                                                    Konfirmasi Hapus Dokumen
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin menghapus dokumen ini?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <form action="{{ route('dokumen.destroy', $dok->id) }}" method="POST">
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
                            <tr>
                                <th>No</th>
                                <th>Nama Mitra</th>
                                <th>Tahun</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

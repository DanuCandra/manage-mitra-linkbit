@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Account Bank</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Account Bank</li>
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
                    <h4 class="card-title mb-0">Semua Account Bank</h4>
                    <a href="{{ url('/admin/account-bank/create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Account Bank
                    </a>
                </div>

                <p class="card-subtitle mb-3">Kelola rekening bank untuk pembayaran mitra</p>

                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Atas Nama</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banks as $bank)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bank->nama_bank }}</td>
                                    <td>{{ $bank->nomor_rekening }}</td>
                                    <td>{{ $bank->atas_nama }}</td>
                                    <td>
                                        @if ($bank->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn mb-1 bg-warning-subtle text-warning px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#edit_bank_{{ $bank->id }}">
                                                <i class="ti ti-edit"></i>
                                            </button>

                                            <button type="button" class="btn mb-1 bg-danger-subtle text-danger px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#hapus_bank_{{ $bank->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div id="edit_bank_{{ $bank->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="edit_bank_label_{{ $bank->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-warning text-white">
                                                <h4 class="modal-title text-white"
                                                    id="edit_bank_label_{{ $bank->id }}">
                                                    Konfirmasi Edit Account Bank
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin mengedit data account bank ini?
                                                </h5>
                                                <p>Bank: <strong>{{ $bank->nama_bank }}</strong><br>
                                                    Nomor Rekening: <strong>{{ $bank->nomor_rekening }}</strong></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <a href="{{ url('/admin/account-bank/edit/' . $bank->id) }}"
                                                    class="btn bg-warning-subtle text-warning">
                                                    Ya, Edit Sekarang
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Hapus --}}
                                <div id="hapus_bank_{{ $bank->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="hapus_bank_label_{{ $bank->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger text-white">
                                                <h4 class="modal-title text-white"
                                                    id="hapus_bank_label_{{ $bank->id }}">
                                                    Konfirmasi Hapus Account Bank
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin menghapus account bank ini?</h5>
                                                <p>Bank: <strong>{{ $bank->nama_bank }}</strong><br>
                                                    Nomor Rekening: <strong>{{ $bank->nomor_rekening }}</strong></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <form action="{{ url('/admin/account-bank/delete/' . $bank->id) }}"
                                                    method="POST" style="display: inline;">
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
                                <th>Nama Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Atas Nama</th>
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


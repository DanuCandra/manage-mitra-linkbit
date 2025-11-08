@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manage Users</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Manage Users</li>
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
                    <h4 class="card-title mb-0">Semua Users</h4>
                    <a href="{{ url('/manage-users/create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Users
                    </a>
                </div>

                <p class="card-subtitle mb-3"></p>

                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->no_hp }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn mb-1 bg-warning-subtle text-warning px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#edit_user_{{ $user->id }}">
                                                <i class="ti ti-edit"></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <button type="button" class="btn mb-1 bg-danger-subtle text-danger px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#hapus_user_{{ $user->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div id="edit_user_{{ $user->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="edit_user_label_{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-warning text-white">
                                                <h4 class="modal-title text-white"
                                                    id="edit_user_label_{{ $user->id }}">
                                                    Konfirmasi Edit User
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin mengedit data user ini?</h5>
                                                <p>Nama User: <strong>{{ $user->name }}</strong><br>
                                                Email: <strong>{{ $user->email }}</strong></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <a href="{{ url('/manage-users/edit/' . $user->id) }}"
                                                    class="btn bg-warning-subtle text-warning">
                                                    Ya, Edit Sekarang
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div id="hapus_user_{{ $user->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="hapus_user_label_{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger text-white">
                                                <h4 class="modal-title text-white"
                                                    id="hapus_user_label_{{ $user->id }}">
                                                    Konfirmasi Hapus User
                                                </h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Apakah Anda yakin ingin menghapus user ini?</h5>
                                                <p>Nama: <strong>{{ $user->name }}</strong><br>
                                                Email: <strong>{{ $user->email }}</strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <a href="{{ url('/user/delete/' . $user->id) }}"
                                                    class="btn bg-danger-subtle text-danger">
                                                    Ya, Hapus Sekarang
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </tbody>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- Add your content here -->
@endsection

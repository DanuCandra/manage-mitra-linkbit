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
                                    <td>{{ $user->role->role_name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Tombol Edit -->
                                            <a href="{{ url('/user/edit/' . $user->id) }}" class="btn btn-m btn-warning"
                                                title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>

                                            <!-- Tombol Delete -->
                                            <a href="{{ url('/user/delete/' . $user->id) }}" class="btn btn-m btn-danger"
                                                title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
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

        <!-- Add your content here -->
    </div>
@endsection

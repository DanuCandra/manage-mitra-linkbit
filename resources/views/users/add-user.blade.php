@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Add User</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class=" breadcrumb-item"> <a class="text-muted text-decoration-none"
                                    href="{{ url('/manage-users') }}"> Manage User</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Add User</li>
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
    <div class="col-12">
        <!-- start Person Info -->
        <div class="card">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Add New User</h4>
            </div>
            <form action="{{ url('/manage-users/store') }}" method="POST">
                @csrf
                <div>
                    <div class="card-body">
                        <h4 class="card-title">Informasi User</h4>
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" value="{{ old('name') }}" name="name" class="form-control"
                                        placeholder="Nama Lengkap" required />

                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" id="lastName" name="email" class="form-control"
                                        value="{{ old('email') }}" placeholder="Email" required />
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No HP</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control"
                                        placeholder="No HP" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Password" required />

                                </div>
                            </div>
                            <!--/span-->

                            <!--/span-->
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status User</label>
                                    <select class="form-select" name="status">
                                        <option value="">Pilih Status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak
                                            Aktif</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Role User</label>
                                    <select class="form-select" name="role_id" data-placeholder="Pilih Role" tabindex="1">
                                        <option value="">Pilih Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                {{ $role->role_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr />

                    <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-primary">Simpan</button>

                            <a href="{{ url('/manage-users') }}" type="button"
                                class="btn bg-danger-subtle text-danger ms-6">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end Person Info -->
    </div>
@endsection

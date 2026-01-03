@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Edit Account Bank</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/admin/account-bank') }}">Account
                                    Bank</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Edit Account Bank</li>
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

    <div class="col-12">
        <div class="card">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Edit Account Bank</h4>
            </div>
            <form action="{{ url('/admin/account-bank/update/' . $bank->id) }}" method="POST">
                @csrf
                <div>
                    <div class="card-body">
                        <h4 class="card-title">Informasi Account Bank</h4>

                        {{-- Nama Bank & Nomor Rekening --}}
                        <div class="row pt-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Bank</label>
                                    <input type="text" name="nama_bank" value="{{ old('nama_bank', $bank->nama_bank) }}"
                                        class="form-control @error('nama_bank') is-invalid @enderror"
                                        placeholder="Contoh: BCA, Mandiri, BNI" required>
                                    @error('nama_bank')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Rekening</label>
                                    <input type="text" name="nomor_rekening"
                                        value="{{ old('nomor_rekening', $bank->nomor_rekening) }}"
                                        class="form-control @error('nomor_rekening') is-invalid @enderror"
                                        placeholder="Contoh: 1234567890" required>
                                    @error('nomor_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Atas Nama & Status --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Atas Nama</label>
                                    <input type="text" name="atas_nama" value="{{ old('atas_nama', $bank->atas_nama) }}"
                                        class="form-control @error('atas_nama') is-invalid @enderror"
                                        placeholder="Contoh: PT ISP Indonesia" required>
                                    @error('atas_nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status"
                                        required>
                                        <option value="">Pilih Status</option>
                                        <option value="aktif"
                                            {{ old('status', $bank->status) == 'aktif' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="tidak-aktif"
                                            {{ old('status', $bank->status) == 'tidak-aktif' ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url('/admin/account-bank') }}" type="button"
                                class="btn bg-danger-subtle text-danger ms-6">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

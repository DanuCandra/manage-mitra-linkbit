@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Edit Pelanggan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="text-muted text-decoration-none" href="{{ route('pelanggan.manage') }}">Pelanggan</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="" href="{{ route('pelanggan.edit', $pelanggan->id) }}">Edit Pelanggan</a>
                            </li>
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

    <div class="card">
        <div class="card-header text-bg-warning">
            <h4 class="mb-0 text-white">Edit Data Pelanggan</h4>
        </div>

        <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
            @csrf

            <div>
                <div class="card-body">
                    <h4 class="card-title">Informasi Pelanggan</h4>

                    <div class="row pt-3">
                        <!-- ID Pelanggan -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">ID Pelanggan <span class="text-muted">(Opsional)</span></label>
                                <input type="text" name="id_pelanggan" class="form-control"
                                    placeholder="Contoh: CUST001" value="{{ old('id_pelanggan', $pelanggan->id_pelanggan) }}" />
                                <small class="form-control-feedback text-muted">
                                    ID unik untuk pelanggan. Kosongkan jika ingin otomatis.
                                </small>
                            </div>
                        </div>

                        <!-- Nama Pelanggan -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control"
                                    placeholder="Contoh: Danu Candra" value="{{ old('nama', $pelanggan->nama) }}" required />
                                <small class="form-control-feedback text-muted">
                                    Masukkan nama lengkap pelanggan.
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- NIK -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK <span class="text-muted">(Opsional)</span></label>
                                <input type="text" id="nik" name="nik" class="form-control"
                                    placeholder="Contoh: 3201234567891234" maxlength="16"
                                    value="{{ old('nik', $pelanggan->nik) }}" />
                                <small class="form-control-feedback text-muted">
                                    Nomor Induk Kependudukan (16 digit).
                                </small>
                            </div>
                        </div>

                        <!-- Mulai Berlangganan -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Mulai Berlangganan <span class="text-muted">(Opsional)</span></label>
                                <input type="date" name="mulai_berlangganan" class="form-control"
                                    value="{{ old('mulai_berlangganan', $pelanggan->mulai_berlangganan) }}" />
                                <small class="form-control-feedback text-muted">
                                    Tanggal mulai berlangganan.
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Alamat <span class="text-muted">(Opsional)</span></label>
                                <textarea name="alamat" class="form-control" rows="3"
                                    placeholder="Contoh: Jl. Merdeka No. 123, Jakarta Pusat">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                                <small class="form-control-feedback text-muted">
                                    Alamat lengkap pelanggan.
                                </small>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-body border-top">
                    <h4 class="card-title">Paket Langganan</h4>

                    <div class="row pt-3">
                        <!-- Pilih Produk -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pilih Produk <span class="text-danger">*</span></label>
                                <select name="produk_id" class="form-control" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($produk as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('produk_id', $pelanggan->produk_id) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_produk }} - {{ $p->bandwidth }}
                                            (Rp {{ number_format($p->harga, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-control-feedback text-muted">
                                    Pilih paket produk untuk pelanggan.
                                </small>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status Langganan <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="aktif" {{ old('status', $pelanggan->status) == 'aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="non-aktif" {{ old('status', $pelanggan->status) == 'non-aktif' ? 'selected' : '' }}>
                                        Non-Aktif
                                    </option>
                                </select>
                                <small class="form-control-feedback text-muted">
                                    Status aktif pelanggan saat ini.
                                </small>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tombol -->
                <div class="form-actions">
                    <div class="card-body border-top">
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-device-floppy me-1"></i>
                            Update Pelanggan
                        </button>
                        <a href="{{ route('pelanggan.manage') }}" class="btn bg-danger-subtle text-danger ms-6">
                            <i class="ti ti-x me-1"></i>
                            Batal
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Format NIK (hanya angka, max 16 digit)
            const nikInput = document.getElementById('nik');

            if (nikInput) {
                nikInput.addEventListener('keyup', function(e) {
                    // Hanya angka
                    let angka = this.value.replace(/[^0-9]/g, '');

                    // Maksimal 16 digit
                    if (angka.length > 16) {
                        angka = angka.substring(0, 16);
                    }

                    this.value = angka;
                });
            }
        </script>
    @endpush
@endsection

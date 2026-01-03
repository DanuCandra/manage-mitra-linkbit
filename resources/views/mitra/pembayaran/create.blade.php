@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8 ">Form Pembayaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/mitra/pembayaran') }}">Bayar
                                    Tagihan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Form Pembayaran</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ url('') }}/assets/images/breadcrumb/ChatBc.png" alt=""
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Error!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Form Pembayaran - {{ $tagihan->no_tagihan }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('/mitra/pembayaran/store') }}" method="POST" enctype="multipart/form-data"
                        id="formPembayaran">
                        @csrf
                        <input type="hidden" name="tagihan_id" value="{{ $tagihan->id }}">

                        {{-- Jenis Pembayaran --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Jenis Pembayaran <span
                                    class="text-danger">*</span></label>

                            <div class="row g-3" id="jenisPembayaranWrapper">

                                {{-- LUNAS --}}
                                <div class="col-md-6">
                                    <label class="card p-3 cursor-pointer jenis-card">
                                        <div class="form-check">
                                            <input class="form-check-input jenis-radio" type="radio"
                                                name="jenis_pembayaran" id="jenis_full" value="full"
                                                {{ old('jenis_pembayaran') === 'full' ? 'checked' : '' }}>

                                            <span class="fw-bold d-block">Bayar Lunas</span>
                                            <small class="text-muted">
                                                Membayar seluruh sisa tagihan sekaligus
                                            </small>
                                        </div>
                                    </label>
                                </div>

                                {{-- CICILAN --}}
                                <div class="col-md-6">
                                    <label class="card p-3 cursor-pointer jenis-card">
                                        <div class="form-check">
                                            <input class="form-check-input jenis-radio" type="radio"
                                                name="jenis_pembayaran" id="jenis_cicilan" value="cicilan"
                                                {{ old('jenis_pembayaran') === 'cicilan' ? 'checked' : '' }}>

                                            <span class="fw-bold d-block">Cicilan</span>
                                            <small class="text-muted">
                                                Membayar sebagian dari sisa tagihan
                                            </small>
                                        </div>
                                    </label>
                                </div>

                            </div>

                            @error('jenis_pembayaran')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Jumlah Bayar --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Jumlah Bayar <span class="text-danger">*</span>
                            </label>

                            <input type="number" class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                name="jumlah_bayar" id="jumlah_bayar" placeholder="Masukkan jumlah pembayaran"
                                value="{{ old('jumlah_bayar') }}">

                            <small class="text-muted">
                                Sisa tagihan:
                                <strong class="text-danger">{{ $tagihan->sisa_format }}</strong>
                            </small>

                            @error('jumlah_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bank Tujuan --}}
                        <div class="mb-3">
                            <label class="form-label">Bank Tujuan Transfer <span class="text-danger">*</span></label>
                            <select class="form-select @error('account_bank_id') is-invalid @enderror"
                                name="account_bank_id" required>
                                <option value="">-- Pilih Bank Tujuan --</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}"
                                        {{ old('account_bank_id') == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->nama_bank }} - {{ $bank->nomor_rekening }} (a.n
                                        {{ $bank->atas_nama }})
                                    </option>
                                @endforeach
                            </select>
                            @error('account_bank_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Bayar --}}
                        <div class="mb-3">
                            <label class="form-label">Tanggal Transfer <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_bayar') is-invalid @enderror"
                                name="tanggal_bayar" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
                            @error('tanggal_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Pengirim --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Pengirim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_pengirim') is-invalid @enderror"
                                name="nama_pengirim" value="{{ old('nama_pengirim') }}"
                                placeholder="Nama yang tertera di rekening pengirim" required>
                            @error('nama_pengirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bank Pengirim --}}
                        <div class="mb-3">
                            <label class="form-label">Bank Pengirim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('bank_pengirim') is-invalid @enderror"
                                name="bank_pengirim" value="{{ old('bank_pengirim') }}"
                                placeholder="Contoh: BCA, Mandiri" required>
                            @error('bank_pengirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bukti Bayar --}}
                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('bukti_bayar') is-invalid @enderror"
                                name="bukti_bayar" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                            @error('bukti_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan">{{ old('catatan') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-send"></i> Kirim Pembayaran
                            </button>
                            <a href="{{ url('/mitra/pembayaran') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Info Tagihan --}}
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 text-white">Info Tagihan</h5>
                </div>
                <div class="card-body">
                    <p><strong>No Tagihan:</strong><br>{{ $tagihan->no_tagihan }}</p>
                    <p><strong>Bandwidth:</strong><br>{{ $tagihan->bandwidth }}</p>
                    <p><strong>Total Tagihan:</strong><br>
                        <span class="fs-5 text-primary">{{ $tagihan->total_format }}</span>
                    </p>
                    <p><strong>Sudah Dibayar:</strong><br>
                        <span class="fs-5 text-success">Rp
                            {{ number_format($tagihan->total_dibayar, 0, ',', '.') }}</span>
                    </p>
                    <p><strong>Sisa Tagihan:</strong><br>
                        <span class="fs-4 text-danger fw-bold">{{ $tagihan->sisa_format }}</span>
                    </p>
                    <p><strong>Jatuh Tempo:</strong><br>
                        {{ $tagihan->tanggal_jatuh_tempo->format('d F Y') }}
                        @if ($tagihan->isJatuhTempo())
                            <br><span class="badge bg-danger">Terlambat</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Panduan Pembayaran --}}
            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 text-white">Panduan</h5>
                </div>
                <div class="card-body">
                    <ol class="ps-3 mb-0">
                        <li>Pilih jenis pembayaran (Full/Cicilan)</li>
                        <li>Isi jumlah yang akan dibayar</li>
                        <li>Pilih bank tujuan transfer</li>
                        <li>Lakukan transfer ke rekening tujuan</li>
                        <li>Upload bukti transfer</li>
                        <li>Tunggu verifikasi admin (1-2 hari kerja)</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('.jenis-radio');
            const jumlahInput = document.getElementById('jumlah_bayar');
            const sisaTagihan = {{ (int) $tagihan->sisa_tagihan }};
            const cards = document.querySelectorAll('.jenis-card');

            function updateUI(value) {
                cards.forEach(card => card.classList.remove('border-primary', 'shadow'));

                if (value === 'full') {
                    jumlahInput.value = sisaTagihan;
                    jumlahInput.readOnly = true;
                    document.querySelector('#jenis_full').closest('.jenis-card')
                        .classList.add('border-primary', 'shadow');
                }

                if (value === 'cicilan') {
                    jumlahInput.value = '';
                    jumlahInput.readOnly = false;
                    document.querySelector('#jenis_cicilan').closest('.jenis-card')
                        .classList.add('border-primary', 'shadow');
                }
            }

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateUI(this.value);
                });
            });

            // Restore state on reload
            const checked = document.querySelector('.jenis-radio:checked');
            if (checked) {
                updateUI(checked.value);
            }
        });
    </script>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tableTagihan').DataTable({
                "order": [
                    [3, "asc"]
                ]
            });
        });
    </script>
@endsection

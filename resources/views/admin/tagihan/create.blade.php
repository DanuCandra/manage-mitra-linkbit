@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Buat Tagihan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/admin/tagihan') }}">Kelola
                                    Tagihan</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Buat Tagihan</li>
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
                <h4 class="mb-0 text-white">Buat Tagihan Baru</h4>
            </div>
            <form action="{{ url('/admin/tagihan/store') }}" method="POST">
                @csrf
                <div>
                    <div class="card-body">
                        <h4 class="card-title">Informasi Tagihan</h4>

                        {{-- Pilih Mitra --}}
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Mitra <span class="text-danger">*</span></label>
                                    <select name="mitra_id" id="mitra_id"
                                        class="form-select @error('mitra_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Mitra --</option>
                                        @foreach ($mitra as $m)
                                            <option value="{{ $m->id }}" data-bandwidth="{{ $m->bandwidth }}"
                                                {{ old('mitra_id') == $m->id ? 'selected' : '' }}>
                                                {{ $m->user->name ?? '-' }} - {{ $m->nama_mitra }} ({{ $m->bandwidth }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mitra_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Bandwidth (Auto) & Harga --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Bandwidth</label>
                                    <input type="text" id="bandwidth_display" class="form-control"
                                        placeholder="Pilih mitra terlebih dahulu" readonly>
                                    <small class="text-muted">Bandwidth akan otomatis terisi dari data mitra</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Harga Bandwidth <span class="text-danger">*</span></label>
                                    <input type="number" name="harga_bandwidth" value="{{ old('harga_bandwidth') }}"
                                        class="form-control @error('harga_bandwidth') is-invalid @enderror"
                                        placeholder="Contoh: 5000000" required>
                                    @error('harga_bandwidth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Tagihan Bandwidth Januari 2025">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal Tagihan & Jatuh Tempo --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Tagihan <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_tagihan"
                                        value="{{ old('tanggal_tagihan', date('Y-m-d')) }}"
                                        class="form-control @error('tanggal_tagihan') is-invalid @enderror" required>
                                    @error('tanggal_tagihan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_jatuh_tempo"
                                        value="{{ old('tanggal_jatuh_tempo') }}"
                                        class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror" required>
                                    @error('tanggal_jatuh_tempo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-primary">Buat Tagihan</button>
                            <a href="{{ url('/admin/tagihan') }}" class="btn bg-danger-subtle text-danger ms-6">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto fill bandwidth saat mitra dipilih
            document.getElementById('mitra_id').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const bandwidth = selectedOption.getAttribute('data-bandwidth');
                document.getElementById('bandwidth_display').value = bandwidth || '';
            });
        </script>
    @endpush
@endsection

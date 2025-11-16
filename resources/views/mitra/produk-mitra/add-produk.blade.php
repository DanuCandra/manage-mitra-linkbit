@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Tambah Produk</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('mitra-dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="text-muted text-decoration-none" href="{{ route('produk.manage') }}">Produk</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="" href="{{ url('produk/create') }}">Tambah Produk</a>
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
        <div class="card-header text-bg-primary">
            <h4 class="mb-0 text-white">Tambah Produk</h4>
        </div>

        <form action="{{ route('produk.store') }}" method="POST">
            @csrf

            <div>
                <div class="card-body">
                    <h4 class="card-title">Informasi Produk</h4>

                    <div class="row pt-3">
                        <!-- Nama Produk -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control"
                                    placeholder="Contoh: Paket Internet 20 Mbps" required />
                                <small class="form-control-feedback">
                                    Masukkan nama produk yang akan ditawarkan.
                                </small>
                            </div>
                        </div>

                        <!-- Bandwidth -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Bandwidth</label>
                                <input type="text" name="bandwidth" class="form-control" placeholder="Contoh: 20 Mbps"
                                    required />
                                <small class="form-control-feedback">
                                    Tulis kecepatan produk (contoh: 10 Mbps, 20 Mbps).
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Harga Produk (Rp)</label>
                                <input type="text" id="harga" name="harga" class="form-control"
                                    placeholder="Contoh: 150000" required />
                                <small class="form-control-feedback">
                                    Tulis harga produk dalam satuan rupiah.
                                </small>
                            </div>
                        </div>
                    </div>

                </div>

                <hr />

                <!-- Tombol -->
                <div class="form-actions">
                    <div class="card-body border-top">
                        <button type="submit" class="btn btn-primary">
                            Simpan Produk
                        </button>
                        <a href="{{ route('produk.manage') }}" class="btn bg-danger-subtle text-danger ms-6">
                            Batal
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            const hargaInput = document.getElementById('harga');

            hargaInput.addEventListener('keyup', function(e) {
                // Hanya angka
                let angka = this.value.replace(/[^0-9]/g, '');

                // Format angka menjadi ribuan
                let formatRupiah = angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                this.value = formatRupiah;
            });
        </script>
    @endpush
@endsection

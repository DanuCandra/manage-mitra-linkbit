@extends('layouts.main')
@section('content')
    <div class="col-12">
        <!-- start Person Info -->
        <div class="card">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Form Profil Mitra</h4>
            </div>

            <!-- arahkan ke route store_profile -->
            <form action="{{ route('store_profile') }}" method="POST">
                @csrf
                <div>
                    <div class="card-body">
                        <h4 class="card-title">Data Mitra</h4>
                        <div class="row pt-3">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Mitra</label>
                                    <input type="text" name="nama_mitra" class="form-control" placeholder="Nama Mitra"
                                        required />
                                    <small class="form-control-feedback">
                                        Masukkan nama lengkap mitra
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control"
                                        placeholder="Nomor Induk Kependudukan" />
                                    <small class="form-control-feedback">
                                        Isi NIK sesuai KTP (jika ada)
                                    </small>
                                </div>
                            </div>

                        </div>
                        <!--/row-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control" />
                                    <small class="form-control-feedback">
                                        Pilih tanggal lahir
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">NPWP</label>
                                    <input type="text" name="npwp" class="form-control" placeholder="Nomor NPWP" />
                                </div>
                            </div>
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Brand</label>
                                    <input type="text" name="nama_brand" class="form-control"
                                        placeholder="Nama brand usaha">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Karyawan</label>
                                    <input type="number" name="jml_karyawan" class="form-control"
                                        placeholder="Masukkan jumlah karyawan" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Bandwidth</label>
                                    <input type="text" name="bandwith" class="form-control"
                                        placeholder="Bandwidth akan di isi oleh admin" disabled />
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Titik Koordinat</label>
                                    <input type="text" id="tikor" name="tikor" class="form-control"
                                        placeholder="-6.973821, 110.418733">
                                    <small class="form-control-feedback">
                                        Klik lokasi pada peta untuk mengisi koordinat otomatis.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- MAP berada tepat di bawah kolom Titik Koordinat -->
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div id="map" style="height: 350px; border-radius: 10px;"></div>
                            </div>
                        </div>



                    </div>
                    <hr />

                    <div class="card-body">
                        <h4 class="card-title mb-4">Alamat</h4>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat Rumah</label>
                                    <input type="text" name="alamat" class="form-control"
                                        placeholder="Jl. Contoh No. 123, Semarang" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat Usaha</label>
                                    <input type="text" name="alamat_usaha" class="form-control"
                                        placeholder="Alamat lengkap tempat usaha" />
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title mb-4">Data Legalitas</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor NIB</label>
                                    <input type="text" name="no_nib" class="form-control"
                                        placeholder="Nomor Induk Berusaha" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Sertifikat Standar</label>
                                    <input type="text" name="no_sertif_standar" class="form-control"
                                        placeholder="Nomor Sertifikat Standar" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end Person Info -->
    </div>

    @push('scripts')
        <script>
            // Set lokasi awal peta (Semarang)
            var map = L.map('map').setView([-6.966, 110.416], 13);

            // Load Tile / Peta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            let marker;

            // Ketika peta diklik
            map.on('click', function(e) {
                const lat = e.latlng.lat.toFixed(6);
                const lng = e.latlng.lng.toFixed(6);

                // Isi ke input
                document.getElementById("tikor").value = `${lat}, ${lng}`;

                // Jika marker sudah ada → hapus dulu
                if (marker) {
                    map.removeLayer(marker);
                }

                // Tambahkan marker baru
                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);

                // Update input jika marker di-drag
                marker.on('dragend', function() {
                    const pos = marker.getLatLng();
                    document.getElementById("tikor").value =
                        `${pos.lat.toFixed(6)}, ${pos.lng.toFixed(6)}`;
                });
            });
        </script>
    @endpush
@endsection

@extends('layouts.main')

@section('content')
    <div class="col-12">
        <!-- start Person Info -->
        <div class="card">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Form Profil Mitra</h4>
            </div>

            <!-- arahkan ke route store_profile -->
            <form action="{{ route('update_profile', $mitra->id) }}" method="POST">
                @csrf
                <div>
                    <div class="card-body">
                        <h4 class="card-title">Data Mitra</h4>
                        <div class="row pt-3">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama_mitra" class="form-control" placeholder="Nama Mitra"
                                        required value="{{ $mitra->nama_mitra }}" />
                                    <small class="form-control-feedback">
                                        Masukkan nama lengkap mitra
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control"
                                        placeholder="Nomor Induk Kependudukan" value="{{ $mitra->nik }}" />

                                </div>
                            </div>

                        </div>
                        <!--/row-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control"
                                        value="{{ $mitra->tgl_lahir }}" />
                                    <small class="form-control-feedback">
                                        Pilih tanggal lahir
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">NPWP</label>
                                    <input type="text" name="npwp" class="form-control" placeholder="Nomor NPWP"
                                        value="{{ $mitra->npwp }}" />
                                    <small class="form-control-feedback">
                                        Isi NPWP sesuai dokumen (jika ada)
                                    </small>
                                </div>
                            </div>
                        </div>
                        <!--/row-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Brand</label>
                                    <input type="text" name="nama_brand" class="form-control"
                                        placeholder="Nama brand usaha" value="{{ $mitra->nama_brand }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Karyawan</label>
                                    <input type="number" name="jml_karyawan" class="form-control"
                                        placeholder="Masukkan jumlah karyawan" value="{{ $mitra->jml_karyawan }}" />
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Bandwidth</label>
                                    <input type="text" name="bandwith" class="form-control"
                                        placeholder="Jika masih kosong hubungi admin" value="{{ $mitra->bandwith }}"
                                        disabled />
                                    <small class="form-control-feedback">
                                        Untuk mengubah bandwidth, silakan hubungi admin.
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Titik Koordinat</label>
                                    <input type="text" id="tikor" name="tikor" class="form-control"
                                        placeholder="-6.973821, 110.418733" value="{{ $mitra->tikor }}" />
                                    <small class="form-control-feedback">
                                        Klik lokasi pada peta untuk mengubah koordinat otomatis.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- MAP -->
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div id="map" style="height: 350px; border-radius: 10px; z-index: 1;"></div>
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
                                        placeholder="Jl. Contoh No. 123, Semarang" value="{{ $mitra->alamat }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat Usaha</label>
                                    <input type="text" name="alamat_usaha" class="form-control"
                                        placeholder="Alamat lengkap tempat usaha" value="{{ $mitra->alamat_usaha }}" />
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title mb-4">Data Legalitas</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor NIB</label>
                                    <input type="text" name="no_nib" class="form-control"
                                        placeholder="Nomor Induk Berusaha" value="{{ $mitra->no_nib }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Sertifikat Standar</label>
                                    <input type="text" name="no_sertif_standar" class="form-control"
                                        placeholder="Nomor Sertifikat Standar" value="{{ $mitra->no_sertif_standar }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                            <a href="{{ url()->previous() }}" class="btn bg-danger-subtle text-danger ms-6">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end Person Info -->
    </div>
    @push('scripts')
        <script>
            // Ambil value awal dari database
            let initial = "{{ $mitra->tikor }}";

            let lat = -6.973821; // default Semarang
            let lng = 110.418733;

            // Jika sudah ada koordinat di database → gunakan itu
            if (initial && initial.includes(',')) {
                let parts = initial.split(',');
                lat = parseFloat(parts[0]);
                lng = parseFloat(parts[1]);
            }

            // Inisialisasi map
            var map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            // Buat marker di titik awal
            var marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            // Update input saat marker digeser
            marker.on('dragend', function(e) {
                let pos = marker.getLatLng();
                document.getElementById('tikor').value = pos.lat.toFixed(6) + ", " + pos.lng.toFixed(6);
            });

            // Klik map → pindahkan marker
            map.on('click', function(e) {
                let newLat = e.latlng.lat;
                let newLng = e.latlng.lng;

                marker.setLatLng([newLat, newLng]);

                document.getElementById('tikor').value = newLat.toFixed(6) + ", " + newLng.toFixed(6);
            });
        </script>
    @endpush
@endsection

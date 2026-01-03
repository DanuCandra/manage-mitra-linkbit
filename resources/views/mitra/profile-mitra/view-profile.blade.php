@extends('layouts.main')
@section('content')
    <!-- start Form with view only -->
    <div class="card">
        <div class="card-header text-bg-primary">
            <h5 class="mb-0 text-white">Form Mitra</h5>
        </div>
        <form class="form-horizontal">
            <div class="form-body">
                <div class="card-body">
                    <h5 class="card-title mb-0">Profil Mitra</h5>
                </div>
                <hr class="m-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Nama Mitra:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->nama_mitra }}</p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">NIK:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->nik }}</p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Tanggal Lahir:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->tgl_lahir }}</p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">NPWP:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->npwp }}</p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Nama Brand:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->nama_brand }}</p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Jumlah Karyawan:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->jml_karyawan }}</p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Bandwidth:</label>
                                <div class="col-md-9">
                                    <p class="fw-bold">{{ $mitra->bandwidth }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Titik Koordinat:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->tikor }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MAP (READONLY) -->
                    <div class="row">
                        <div class="col-md-12">
                            <div id="viewMap" style="height: 350px; border-radius: 10px; margin-top: 15px; z-index: 1; "></div>
                        </div>
                    </div>


                </div>
                <hr class="m-0" />
                <div class="card-body">
                    <h5 class="card-title mb-0">Alamat</h5>
                </div>
                <hr class="m-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Alamat:</label>
                                <div class="col-md-9">
                                    <p>
                                        {{ $mitra->alamat }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Alamat Usaha:</label>
                                <div class="col-md-9">
                                    <p>
                                        {{ $mitra->alamat_usaha }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <hr class="m-0" />
                <div class="card-body">
                    <h5 class="card-title mb-0">Data Legalitas</h5>
                </div>
                <hr class="m-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Nomor Sertif Standar:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->no_sertif_standar }}</p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="form-label text-end col-md-3">Nomor NIB:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->no_nib }}</p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                </div>
                <div class="form-actions border-top">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <a href="{{ route('edit_profile', $mitra->id) }}" type="submit"
                                            class="btn btn-primary">
                                            <i class="ti ti-edit fs-5"></i>
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- start Form with view only -->

    @push('scripts')
        <script>
            let tikor = "{{ $mitra->tikor }}";

            // Set default jika kosong
            let lat = -6.973821;
            let lng = 110.418733;

            // Jika tikor ada → pakai nilai database
            if (tikor && tikor.includes(',')) {
                let split = tikor.split(',');
                lat = parseFloat(split[0]);
                lng = parseFloat(split[1]);
            }

            // Map boleh digeser, zoom boleh
            var viewMap = L.map('viewMap', {
                zoomControl: true,
                dragging: true,
                scrollWheelZoom: true,
                doubleClickZoom: true,
                boxZoom: true,
                keyboard: true,
                touchZoom: true
            }).setView([lat, lng], 15);

            // Tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(viewMap);

            // Marker tidak draggable (tetap di tempat)
            L.marker([lat, lng], {
                draggable: false
            }).addTo(viewMap);
        </script>
    @endpush
@endsection

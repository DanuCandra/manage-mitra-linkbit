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
                                <label class="form-label text-end col-md-3">Tiktik Koordinat:</label>
                                <div class="col-md-9">
                                    <p>{{ $mitra->tikor }}</p>
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
                                    <p>{{ $mitra->bandwith }}</p>
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
                    <!--/row-->

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
                                        <a href="{{ route('edit_profile', $mitra->id) }}" type="submit" class="btn btn-primary">
                                            <i class="ti ti-edit fs-5"></i>
                                            Edit
                                        </a>
                                        <button type="button" class="btn bg-danger-subtle text-danger ms-6">
                                            Cancel
                                        </button>
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
@endsection

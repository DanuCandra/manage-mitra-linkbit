@extends('layouts.main')
@section('content')
    <div class="col-12">
        <!-- start Dokumen Upload -->
        <div class="card">
            <div class="card-header text-bg-primary">
                <h4 class="mb-0 text-white">Upload Dokumen Mitra</h4>
            </div>

            <form action="{{ route('dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="card-body">
                        <h4 class="card-title">Dokumen yang Harus Diupload</h4>

                        <!-- Row PDF -->
                        <div class="row pt-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">NIB (PDF)</label>
                                    <input type="file" name="nib" class="form-control" accept="application/pdf" />
                                    <small class="text-muted">File harus berupa PDF</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Sertifikat Standar (PDF)</label>
                                    <input type="file" name="sertif_standar" class="form-control"
                                        accept="application/pdf" />
                                    <small class="text-muted">File harus berupa PDF</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">KSO (PDF)</label>
                                    <input type="file" name="kso" class="form-control" accept="application/pdf" />
                                    <small class="text-muted">File harus berupa PDF</small>
                                </div>
                            </div>
                        </div>

                        <!-- Row FOTO -->
                        <div class="row pt-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto KTP (JPG/PNG)</label>
                                    <input type="file" name="foto_ktp" class="form-control" accept="image/*" />
                                    <small class="text-muted">Format: JPG, JPEG, PNG</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto Usaha (JPG/PNG)</label>
                                    <input type="file" name="foto_usaha" class="form-control" accept="image/*" />
                                    <small class="text-muted">Format: JPG, JPEG, PNG</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto Brosur (JPG/PNG)</label>
                                    <input type="file" name="foto_brosur" class="form-control" accept="image/*" />
                                    <small class="text-muted">Format: JPG, JPEG, PNG</small>
                                </div>
                            </div>
                        </div>

                        <!-- Tahun -->
                        <div class="row pt-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Tahun Dokumen</label>
                                    <input type="text" name="tahun" class="form-control" placeholder="Contoh: 2024"
                                        required value="{{ old('tahun', $dokumen->tahun) }}" />
                                </div>
                            </div>
                        </div>

                    </div>

                    

                    <div class="form-actions">
                        <div class="card-body border-top">
                            <button type="submit" class="btn btn-primary">Simpan Dokumen</button>

                            <a href="{{ url('/dokumen/manage-dokumen') }}" type="button"
                                class="btn bg-danger-subtle text-danger ms-6">
                                Batal
                            </a>
                        </div>
                    </div>

                </div>
            </form>

        </div>
        <!-- end Dokumen Upload -->
    </div>
@endsection

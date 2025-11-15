@extends('layouts.main')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header text-bg-primary">
            <h5 class="mb-0 text-white">
                <i class="ti ti-file-text me-2"></i>Dokumen Mitra
            </h5>
        </div>

        <div class="form-body">
            <!-- SECTION: DOKUMEN LEGALITAS -->
            <div class="card-body border-bottom">
                <h5 class="card-title mb-0">
                    <i class="ti ti-license me-2 text-primary"></i>Dokumen Legalitas Tahun <strong>{{ $dokumen->tahun }}</strong>
                </h5>
            </div>

            <div class="card-body">
                @php
                    $fileFields = [
                        'nib' => 'NIB',
                        'sertif_standar' => 'Sertifikat Standar',
                        'kso' => 'KSO',
                    ];
                @endphp

                @foreach ($fileFields as $field => $label)
                    <div class="row mb-4 align-items-start">
                        <div class="col-lg-3 col-md-4 mb-2 mb-md-0">
                            <label class="form-label fw-semibold text-md-end d-block">{{ $label }}:</label>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            @if ($dokumen->$field)
                                @if (Str::endsWith($dokumen->$field, '.pdf'))
                                    <div class="position-relative">
                                        <!-- PDF Viewer -->
                                        <iframe src="{{ asset('storage/' . $dokumen->$field) }}"
                                            class="w-100 rounded border" style="height: 500px; min-height: 300px;">
                                        </iframe>

                                        <!-- Tombol Download -->
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $dokumen->$field) }}"
                                                download="{{ $label }}.pdf" class="btn btn-primary">
                                                <i class="ti ti-download me-1"></i>Download {{ $label }}
                                            </a>
                                            <a href="{{ asset('storage/' . $dokumen->$field) }}" target="_blank"
                                                class="btn btn-outline-primary">
                                                <i class="ti ti-external-link me-1"></i>Buka di Tab Baru
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0" role="alert">
                                        <i class="ti ti-alert-circle me-2"></i>File bukan PDF
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-light mb-0" role="alert">
                                    <i class="ti ti-info-circle me-2"></i>
                                    <em>Belum diupload</em>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (!$loop->last)
                        <hr class="my-3">
                    @endif
                @endforeach
            </div>

            <!-- SECTION: FOTO DOKUMEN -->
            <div class="card-body border-top border-bottom bg-light-subtle">
                <h5 class="card-title mb-0">
                    <i class="ti ti-camera me-2 text-primary"></i>Foto Dokumen
                </h5>
            </div>

            <div class="card-body">
                @php
                    $imageFields = [
                        'foto_ktp' => 'Foto KTP',
                        'foto_usaha' => 'Foto Usaha',
                        'foto_brosur' => 'Foto Brosur',
                    ];
                @endphp

                <div class="row g-4">
                    @foreach ($imageFields as $field => $label)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-semibold">{{ $label }}</h6>
                                </div>
                                <div class="card-body text-center">
                                    @if ($dokumen->$field)
                                        <!-- Gambar dengan fungsi klik untuk popup -->
                                        <img src="{{ asset('storage/' . $dokumen->$field) }}"
                                            class="img-fluid rounded border mb-3 cursor-pointer image-preview"
                                            style="max-height: 250px; width: auto; object-fit: contain; cursor: pointer;"
                                            alt="{{ $label }}" data-bs-toggle="modal"
                                            data-bs-target="#imageModal{{ $loop->index }}"
                                            onclick="showImageModal('{{ asset('storage/' . $dokumen->$field) }}', '{{ $label }}')">

                                        <!-- Tombol Download Gambar -->
                                        <div class="d-grid gap-2">
                                            <a href="{{ asset('storage/' . $dokumen->$field) }}"
                                                download="{{ $label }}.jpg" class="btn btn-primary">
                                                <i class="ti ti-download me-1"></i>Download
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="ti ti-photo-off fs-1 text-muted mb-3 d-block"></i>
                                            <p class="text-muted fst-italic mb-0">Belum diupload</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- SECTION: ACTION BUTTONS -->
            <div class="card-body border-top bg-light">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-primary">
                        <i class="ti ti-edit me-1"></i>Edit Dokumen
                    </a>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Preview Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid" style="max-height: 80vh;" alt="Preview">
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Responsiveness untuk iframe PDF */
        @media (max-width: 768px) {
            iframe {
                height: 300px !important;
            }
        }

        /* Hover effect untuk card gambar */
        .card:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease-in-out;
        }

        /* Smooth transition untuk tombol */
        .btn {
            transition: all 0.2s ease-in-out;
        }

        /* Hover effect untuk gambar preview */
        .image-preview:hover {
            opacity: 0.8;
            transform: scale(1.02);
            transition: all 0.3s ease;
        }

        /* Modal image styling */
        #modalImage {
            object-fit: contain;
        }
    </style>

    <script>
        // Fungsi untuk menampilkan gambar di modal
        function showImageModal(imageSrc, imageTitle) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModalLabel').textContent = imageTitle;

            // Inisialisasi Bootstrap Modal
            var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
            myModal.show();
        }
    </script>
@endsection

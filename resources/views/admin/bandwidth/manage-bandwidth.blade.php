@extends('layouts.main')

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manage Bandwidth</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Manage Bandwidth</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="modernize-img"
                            class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="datatables">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Daftar Mitra & Bandwidth</h5>
                <p class="card-subtitle mb-4 text-muted">Kelola bandwidth untuk setiap mitra</p>

                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mitra</th>
                                <th>Nama Brand</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Bandwidth</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mitras as $mitra)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mitra->nama_mitra }}</td>
                                    <td>{{ $mitra->nama_brand ?? '-' }}</td>
                                    <td>{{ $mitra->user->email ?? '-' }}</td>
                                    <td>{{ $mitra->user->no_hp ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary fs-3">
                                            {{ $mitra->getFormattedBandwidth() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Button Tambah Bandwidth -->
                                            <button type="button" class="btn mb-1 bg-success-subtle text-success px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#addBandwidthModal"
                                                data-mitra-id="{{ $mitra->id }}"
                                                data-mitra-name="{{ $mitra->nama_mitra }}"
                                                data-mitra-brand="{{ $mitra->nama_brand ?? '-' }}"
                                                data-current-bandwidth="{{ $mitra->bandwidth ?? '0 Mbps' }}"
                                                title="Tambah Bandwidth">
                                                <i class="ti ti-plus fs-5"></i>
                                            </button>

                                            <!-- Button Edit Bandwidth -->
                                            <button type="button" class="btn mb-1 bg-warning-subtle text-warning px-4 fs-4"
                                                data-bs-toggle="modal" data-bs-target="#editBandwidthModal"
                                                data-mitra-id="{{ $mitra->id }}"
                                                data-mitra-name="{{ $mitra->nama_mitra }}"
                                                data-mitra-brand="{{ $mitra->nama_brand ?? '-' }}"
                                                data-current-bandwidth="{{ $mitra->bandwidth ?? '0 Mbps' }}"
                                                title="Edit Bandwidth">
                                                <i class="ti ti-edit fs-5"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data mitra</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Mitra</th>
                                <th>Nama Brand</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Bandwidth</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal TAMBAH Bandwidth -->
    <div class="modal fade" id="addBandwidthModal" tabindex="-1" aria-labelledby="addBandwidthModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="addBandwidthForm" method="POST">
                    @csrf
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white" id="addBandwidthModalLabel">
                            <i class="ti ti-plus me-2"></i>Tambah Bandwidth
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Nama Mitra</label>
                                <input type="text" class="form-control bg-light" id="addMitraName" readonly>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Nama Brand</label>
                                <input type="text" class="form-control bg-light" id="addMitraBrand" readonly>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Bandwidth Saat Ini</label>
                                <input type="text" class="form-control bg-light" id="addCurrentBandwidth" readonly>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="addBandwidthValue" class="form-label fw-semibold">
                                    Tambah Bandwidth <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="addBandwidthValue"
                                        name="bandwidth_value" min="0.01" step="0.01"
                                        placeholder="Contoh: 10 atau 1.5" required>
                                    <select class="form-select" style="max-width: 120px;" id="addBandwidthUnit"
                                        name="bandwidth_unit" required>
                                        <option value="Mbps" selected>Mbps</option>
                                        <option value="Gbps">Gbps</option>
                                    </select>
                                </div>
                                <small class="text-muted">
                                    <i class="ti ti-info-circle"></i>
                                    Bandwidth yang dimasukkan akan <strong>ditambahkan</strong> ke bandwidth saat ini
                                </small>
                            </div>
                        </div>

                        <div class="alert alert-light-success text-success border border-success" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-calculator fs-6 me-2"></i>
                                <div>
                                    <strong>Total Bandwidth Baru:</strong>
                                    <span id="addNewBandwidth" class="fs-4 fw-bold ms-2">0 Mbps</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-device-floppy me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal EDIT Bandwidth -->
    <div class="modal fade" id="editBandwidthModal" tabindex="-1" aria-labelledby="editBandwidthModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editBandwidthForm" method="POST">
                    @csrf
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-white" id="editBandwidthModalLabel">
                            <i class="ti ti-edit me-2"></i>Edit Bandwidth
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Nama Mitra</label>
                                <input type="text" class="form-control bg-light" id="editMitraName" readonly>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Nama Brand</label>
                                <input type="text" class="form-control bg-light" id="editMitraBrand" readonly>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Bandwidth Saat Ini</label>
                                <input type="text" class="form-control bg-light fw-bold text-primary"
                                    id="editCurrentBandwidth" readonly>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="editBandwidthValue" class="form-label fw-semibold">
                                    Bandwidth Baru <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="editBandwidthValue"
                                        name="bandwidth_value" min="0" step="0.01"
                                        placeholder="Contoh: 50 atau 2.5" required>
                                    <select class="form-select" style="max-width: 120px;" id="editBandwidthUnit"
                                        name="bandwidth_unit" required>
                                        <option value="Mbps">Mbps</option>
                                        <option value="Gbps">Gbps</option>
                                    </select>
                                </div>
                                <small class="text-muted">
                                    <i class="ti ti-info-circle"></i>
                                    Bandwidth saat ini akan <strong>diganti</strong> dengan nilai baru yang dimasukkan
                                </small>
                            </div>
                        </div>

                        <div class="alert alert-light-warning text-warning border border-warning" role="alert">
                            <div class="d-flex align-items-start">
                                <i class="ti ti-alert-triangle fs-6 me-2 mt-1"></i>
                                <div>
                                    <strong>Perhatian!</strong><br>
                                    <small>Bandwidth akan diubah dari <span id="editOldBandwidth" class="fw-bold">0
                                            Mbps</span>
                                        menjadi <span id="editNewBandwidthPreview" class="fw-bold">0 Mbps</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-device-floppy me-1"></i>Ubah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Helper function to parse bandwidth string
        function parseBandwidth(bandwidthStr) {
            const match = bandwidthStr.match(/(\d+(?:\.\d+)?)\s*(Mbps|Gbps)/i);
            if (!match) return {
                value: 0,
                unit: 'Mbps',
                mbps: 0
            };

            const value = parseFloat(match[1]);
            const unit = match[2];
            const mbps = unit.toLowerCase() === 'gbps' ? value * 1000 : value;

            return {
                value,
                unit,
                mbps
            };
        }

        // Helper function to format bandwidth
        function formatBandwidth(mbps) {
            if (mbps >= 1000) {
                const gbps = mbps / 1000;
                const formatted = gbps % 1 === 0 ? gbps.toFixed(0) : gbps.toFixed(2);
                return formatted + ' Gbps';
            }
            const formatted = mbps % 1 === 0 ? mbps.toFixed(0) : mbps.toFixed(2);
            return formatted + ' Mbps';
        }

        // ===== MODAL TAMBAH BANDWIDTH =====
        const addBandwidthModal = document.getElementById('addBandwidthModal');

        addBandwidthModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const mitraId = button.getAttribute('data-mitra-id');
            const mitraName = button.getAttribute('data-mitra-name');
            const mitraBrand = button.getAttribute('data-mitra-brand');
            const currentBandwidth = button.getAttribute('data-current-bandwidth');

            document.getElementById('addMitraName').value = mitraName;
            document.getElementById('addMitraBrand').value = mitraBrand;
            document.getElementById('addCurrentBandwidth').value = currentBandwidth;

            const form = document.getElementById('addBandwidthForm');
            form.action = "{{ url('/manage-bandwidth/add') }}/" + mitraId;

            document.getElementById('addBandwidthValue').value = '';
            document.getElementById('addBandwidthUnit').value = 'Mbps';
            document.getElementById('addNewBandwidth').textContent = currentBandwidth;

            const parsed = parseBandwidth(currentBandwidth);
            form.dataset.currentBandwidthMbps = parsed.mbps;
        });

        function updateAddPreview() {
            const form = document.getElementById('addBandwidthForm');
            const currentMbps = parseFloat(form.dataset.currentBandwidthMbps) || 0;
            const addValue = parseFloat(document.getElementById('addBandwidthValue').value) || 0;
            const addUnit = document.getElementById('addBandwidthUnit').value;

            const addMbps = addUnit === 'Gbps' ? addValue * 1000 : addValue;
            const newTotalMbps = currentMbps + addMbps;

            document.getElementById('addNewBandwidth').textContent = formatBandwidth(newTotalMbps);
        }

        document.getElementById('addBandwidthValue').addEventListener('input', updateAddPreview);
        document.getElementById('addBandwidthUnit').addEventListener('change', updateAddPreview);

        addBandwidthModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('addBandwidthValue').focus();
        });

        // ===== MODAL EDIT BANDWIDTH =====
        const editBandwidthModal = document.getElementById('editBandwidthModal');

        editBandwidthModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const mitraId = button.getAttribute('data-mitra-id');
            const mitraName = button.getAttribute('data-mitra-name');
            const mitraBrand = button.getAttribute('data-mitra-brand');
            const currentBandwidth = button.getAttribute('data-current-bandwidth');

            document.getElementById('editMitraName').value = mitraName;
            document.getElementById('editMitraBrand').value = mitraBrand;
            document.getElementById('editCurrentBandwidth').value = currentBandwidth;

            const form = document.getElementById('editBandwidthForm');
            form.action = "{{ url('/manage-bandwidth/update') }}/" + mitraId;

            // Parse current bandwidth
            const parsed = parseBandwidth(currentBandwidth);
            document.getElementById('editBandwidthValue').value = parsed.value;
            document.getElementById('editBandwidthUnit').value = parsed.unit;
            document.getElementById('editOldBandwidth').textContent = currentBandwidth;
            document.getElementById('editNewBandwidthPreview').textContent = currentBandwidth;

            form.dataset.currentBandwidth = currentBandwidth;
        });

        function updateEditPreview() {
            const form = document.getElementById('editBandwidthForm');
            const oldBandwidth = form.dataset.currentBandwidth;
            const newValue = parseFloat(document.getElementById('editBandwidthValue').value) || 0;
            const newUnit = document.getElementById('editBandwidthUnit').value;

            const formatted = (newValue % 1 === 0 ? newValue.toFixed(0) : newValue.toFixed(2)) + ' ' + newUnit;

            document.getElementById('editOldBandwidth').textContent = oldBandwidth;
            document.getElementById('editNewBandwidthPreview').textContent = formatted;
        }

        document.getElementById('editBandwidthValue').addEventListener('input', updateEditPreview);
        document.getElementById('editBandwidthUnit').addEventListener('change', updateEditPreview);

        editBandwidthModal.addEventListener('shown.bs.modal', function() {
            const input = document.getElementById('editBandwidthValue');
            input.focus();
            input.select();
        });
    </script>
@endpush

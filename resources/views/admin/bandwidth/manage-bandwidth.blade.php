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
                                                data-bs-toggle="modal"
                                                data-bs-target="#addBandwidthModal{{ $mitra->id }}"
                                                title="Tambah Bandwidth">
                                                <i class="ti ti-plus fs-5"></i>
                                            </button>

                                            <!-- Button Edit Bandwidth -->
                                            <button type="button" class="btn mb-1 bg-warning-subtle text-warning px-4 fs-4"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editBandwidthModal{{ $mitra->id }}"
                                                title="Edit Bandwidth">
                                                <i class="ti ti-edit fs-5"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal TAMBAH Bandwidth - Per Mitra -->
                                <div class="modal fade" id="addBandwidthModal{{ $mitra->id }}" tabindex="-1"
                                    aria-labelledby="addBandwidthModalLabel{{ $mitra->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('add-bandwidth', $mitra->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header bg-success">
                                                    <h5 class="modal-title text-white"
                                                        id="addBandwidthModalLabel{{ $mitra->id }}">
                                                        <i class="ti ti-plus me-2"></i>Tambah Bandwidth
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label fw-semibold">Nama Mitra</label>
                                                            <input type="text" class="form-control bg-light"
                                                                value="{{ $mitra->nama_mitra }}" readonly>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label fw-semibold">Nama Brand</label>
                                                            <input type="text" class="form-control bg-light"
                                                                value="{{ $mitra->nama_brand ?? '-' }}" readonly>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label fw-semibold">Bandwidth Saat Ini</label>
                                                            <input type="text" class="form-control bg-light"
                                                                value="{{ $mitra->bandwidth ?? '0 Mbps' }}" readonly>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="addBandwidthValue{{ $mitra->id }}"
                                                                class="form-label fw-semibold">
                                                                Tambah Bandwidth <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="number"
                                                                    class="form-control add-bandwidth-value"
                                                                    id="addBandwidthValue{{ $mitra->id }}"
                                                                    name="bandwidth_value" min="0.01" step="0.01"
                                                                    placeholder="Contoh: 10 atau 1.5"
                                                                    data-current-mbps="{{ $mitra->getBandwidthInMbps() }}"
                                                                    data-mitra-id="{{ $mitra->id }}" required>
                                                                <select class="form-select add-bandwidth-unit"
                                                                    style="max-width: 120px;"
                                                                    id="addBandwidthUnit{{ $mitra->id }}"
                                                                    name="bandwidth_unit"
                                                                    data-mitra-id="{{ $mitra->id }}" required>
                                                                    <option value="Mbps" selected>Mbps</option>
                                                                    <option value="Gbps">Gbps</option>
                                                                </select>
                                                            </div>
                                                            <small class="text-muted">
                                                                <i class="ti ti-info-circle"></i>
                                                                Bandwidth yang dimasukkan akan <strong>ditambahkan</strong>
                                                                ke bandwidth saat ini
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="alert alert-light-success text-success border border-success"
                                                        role="alert">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ti ti-calculator fs-6 me-2"></i>
                                                            <div>
                                                                <strong>Total Bandwidth Baru:</strong>
                                                                <span id="addNewBandwidth{{ $mitra->id }}"
                                                                    class="fs-4 fw-bold ms-2">
                                                                    {{ $mitra->bandwidth ?? '0 Mbps' }}
                                                                </span>
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

                                <!-- Modal EDIT Bandwidth - Per Mitra -->
                                <div class="modal fade" id="editBandwidthModal{{ $mitra->id }}" tabindex="-1"
                                    aria-labelledby="editBandwidthModalLabel{{ $mitra->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('update-bandwidth', $mitra->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title text-white"
                                                        id="editBandwidthModalLabel{{ $mitra->id }}">
                                                        <i class="ti ti-edit me-2"></i>Edit Bandwidth
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label fw-semibold">Nama Mitra</label>
                                                            <input type="text" class="form-control bg-light"
                                                                value="{{ $mitra->nama_mitra }}" readonly>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label fw-semibold">Nama Brand</label>
                                                            <input type="text" class="form-control bg-light"
                                                                value="{{ $mitra->nama_brand ?? '-' }}" readonly>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label fw-semibold">Bandwidth Saat
                                                                Ini</label>
                                                            <input type="text"
                                                                class="form-control bg-light fw-bold text-primary"
                                                                value="{{ $mitra->bandwidth ?? '0 Mbps' }}" readonly>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="editBandwidthValue{{ $mitra->id }}"
                                                                class="form-label fw-semibold">
                                                                Bandwidth Baru <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                @php
                                                                    $bandwidthParts = explode(
                                                                        ' ',
                                                                        $mitra->bandwidth ?? '0 Mbps',
                                                                    );
                                                                    $currentValue = floatval($bandwidthParts[0]);
                                                                    $currentUnit = $bandwidthParts[1] ?? 'Mbps';
                                                                @endphp
                                                                <input type="number"
                                                                    class="form-control edit-bandwidth-value"
                                                                    id="editBandwidthValue{{ $mitra->id }}"
                                                                    name="bandwidth_value" min="0" step="0.01"
                                                                    value="{{ $currentValue }}"
                                                                    placeholder="Contoh: 50 atau 2.5"
                                                                    data-current-bandwidth="{{ $mitra->bandwidth ?? '0 Mbps' }}"
                                                                    data-mitra-id="{{ $mitra->id }}" required>
                                                                <select class="form-select edit-bandwidth-unit"
                                                                    style="max-width: 120px;"
                                                                    id="editBandwidthUnit{{ $mitra->id }}"
                                                                    name="bandwidth_unit"
                                                                    data-mitra-id="{{ $mitra->id }}" required>
                                                                    <option value="Mbps"
                                                                        {{ $currentUnit === 'Mbps' ? 'selected' : '' }}>
                                                                        Mbps</option>
                                                                    <option value="Gbps"
                                                                        {{ $currentUnit === 'Gbps' ? 'selected' : '' }}>
                                                                        Gbps</option>
                                                                </select>
                                                            </div>
                                                            <small class="text-muted">
                                                                <i class="ti ti-info-circle"></i>
                                                                Bandwidth saat ini akan <strong>diganti</strong> dengan
                                                                nilai baru yang dimasukkan
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="alert alert-light-warning text-warning border border-warning"
                                                        role="alert">
                                                        <div class="d-flex align-items-start">
                                                            <i class="ti ti-alert-triangle fs-6 me-2 mt-1"></i>
                                                            <div>
                                                                <strong>Perhatian!</strong><br>
                                                                <small>Bandwidth akan diubah dari
                                                                    <span
                                                                        class="fw-bold">{{ $mitra->bandwidth ?? '0 Mbps' }}</span>
                                                                    menjadi <span
                                                                        id="editNewBandwidthPreview{{ $mitra->id }}"
                                                                        class="fw-bold">
                                                                        {{ $currentValue }} {{ $currentUnit }}
                                                                    </span>
                                                                </small>
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
@endsection

@push('scripts')
    <script>
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

        // Update preview for ADD modal
        document.querySelectorAll('.add-bandwidth-value, .add-bandwidth-unit').forEach(element => {
            element.addEventListener('input', function() {
                const mitraId = this.dataset.mitraId;
                const valueInput = document.getElementById(`addBandwidthValue${mitraId}`);
                const unitSelect = document.getElementById(`addBandwidthUnit${mitraId}`);
                const previewSpan = document.getElementById(`addNewBandwidth${mitraId}`);

                const currentMbps = parseFloat(valueInput.dataset.currentMbps) || 0;
                const addValue = parseFloat(valueInput.value) || 0;
                const addUnit = unitSelect.value;

                const addMbps = addUnit === 'Gbps' ? addValue * 1000 : addValue;
                const newTotalMbps = currentMbps + addMbps;

                previewSpan.textContent = formatBandwidth(newTotalMbps);
            });
        });

        // Update preview for EDIT modal
        document.querySelectorAll('.edit-bandwidth-value, .edit-bandwidth-unit').forEach(element => {
            element.addEventListener('input', function() {
                const mitraId = this.dataset.mitraId;
                const valueInput = document.getElementById(`editBandwidthValue${mitraId}`);
                const unitSelect = document.getElementById(`editBandwidthUnit${mitraId}`);
                const previewSpan = document.getElementById(`editNewBandwidthPreview${mitraId}`);

                const newValue = parseFloat(valueInput.value) || 0;
                const newUnit = unitSelect.value;

                const formatted = (newValue % 1 === 0 ? newValue.toFixed(0) : newValue.toFixed(2)) + ' ' +
                    newUnit;
                previewSpan.textContent = formatted;
            });
        });

        // Auto-focus on modal shown
        document.querySelectorAll('[id^="addBandwidthModal"]').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
                const mitraId = this.id.replace('addBandwidthModal', '');
                document.getElementById(`addBandwidthValue${mitraId}`).focus();
            });
        });

        document.querySelectorAll('[id^="editBandwidthModal"]').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
                const mitraId = this.id.replace('editBandwidthModal', '');
                const input = document.getElementById(`editBandwidthValue${mitraId}`);
                input.focus();
                input.select();
            });
        });
    </script>
@endpush

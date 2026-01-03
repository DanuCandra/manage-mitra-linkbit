@extends('layouts.main')

@section('content')
    {{-- Filter & Export --}}
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ url('/admin/laporan-keuangan') }}" id="filterForm">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="belum_bayar" {{ $statusFilter == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar
                            </option>
                            <option value="cicilan" {{ $statusFilter == 'cicilan' ? 'selected' : '' }}>Cicilan</option>
                            <option value="lunas" {{ $statusFilter == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="terlambat" {{ $statusFilter == 'terlambat' ? 'selected' : '' }}>Terlambat
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
            <div class="mt-3">
                <a href="{{ url('/admin/laporan-keuangan/export') }}?start_date={{ $startDate }}&end_date={{ $endDate }}&status={{ $statusFilter }}"
                    class="btn btn-danger">
                    <i class="ti ti-file-type-pdf me-1"></i> Export PDF
                </a>
            </div>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary-subtle p-3">
                            <i class="ti ti-file-invoice fs-6 text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fs-3 text-muted">Total Tagihan</h6>
                            <h4 class="mb-0 fw-semibold text-primary">
                                {{ 'Rp ' . number_format($totalTagihan, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success-subtle p-3">
                            <i class="ti ti-cash fs-6 text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fs-3 text-muted">Total Dibayar</h6>
                            <h4 class="mb-0 fw-semibold text-success">
                                {{ 'Rp ' . number_format($totalDibayar, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning-subtle p-3">
                            <i class="ti ti-clock fs-6 text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fs-3 text-muted">Pending</h6>
                            <h4 class="mb-0 fw-semibold text-warning">
                                {{ 'Rp ' . number_format($totalPending, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger-subtle p-3">
                            <i class="ti ti-receipt-refund fs-6 text-danger"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fs-3 text-muted">Piutang</h6>
                            <h4 class="mb-0 fw-semibold text-danger">
                                {{ 'Rp ' . number_format($totalPiutang, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row">
        {{-- Line Chart - Trend Pembayaran --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="card-title fw-semibold mb-1">Trend Pembayaran (Verified)</h5>
                            <p class="card-subtitle mb-0">Grafik pembayaran yang diterima</p>
                        </div>
                    </div>
                    <div id="lineChart"></div>
                </div>
            </div>
        </div>

        {{-- Donut Chart - Status Tagihan --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-1">Status Tagihan</h5>
                    <p class="card-subtitle mb-3">Distribusi status pembayaran</p>
                    <div id="donutChart"></div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="ti ti-circle-filled text-warning me-2 fs-2"></i>Belum Bayar</span>
                            <strong>{{ $tagihanBelumBayar }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="ti ti-circle-filled text-info me-2 fs-2"></i>Cicilan</span>
                            <strong>{{ $tagihanCicilan }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="ti ti-circle-filled text-success me-2 fs-2"></i>Lunas</span>
                            <strong>{{ $tagihanLunas }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="ti ti-circle-filled text-danger me-2 fs-2"></i>Terlambat</span>
                            <strong>{{ $tagihanTerlambat }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Mitra & Bar Chart --}}
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Top 5 Mitra (Pembayaran Tertinggi)</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            @foreach ($topMitra as $mitra)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary-subtle rounded-circle p-2 me-2">
                                                <i class="ti ti-user fs-4 text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $mitra->user->name ?? '-' }}</h6>
                                                <small class="text-muted">{{ $mitra->nama_brand ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <strong
                                            class="text-primary">{{ 'Rp ' . number_format($mitra->total_dibayar ?? 0, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-1">Perbandingan Mitra</h5>
                    <p class="card-subtitle mb-3">Total pembayaran diterima per mitra</p>
                    <div id="barChart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Tagihan Table --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-3">Detail Tagihan</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No Tagihan</th>
                            <th>Mitra</th>
                            <th class="text-end">Total Tagihan</th>
                            <th class="text-end">Dibayar</th>
                            <th class="text-end">Sisa</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tagihan as $item)
                            <tr>
                                <td>{{ $tagihan->firstItem() + $loop->index }}</td>
                                <td><strong>{{ $item->no_tagihan }}</strong></td>
                                <td>{{ $item->mitra->user->name ?? '-' }}</td>
                                <td class="text-end">{{ $item->total_format }}</td>
                                <td class="text-end text-success">
                                    <strong>{{ 'Rp ' . number_format($item->total_dibayar, 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-end text-danger"><strong>{{ $item->sisa_format }}</strong></td>
                                <td>{{ $item->tanggal_jatuh_tempo->format('d M Y') }}</td>
                                <td>
                                    @if ($item->status_pembayaran == 'belum_bayar')
                                        <span class="badge bg-warning">Belum Bayar</span>
                                    @elseif($item->status_pembayaran == 'cicilan')
                                        <span class="badge bg-info">Cicilan</span>
                                    @elseif($item->status_pembayaran == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-danger">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="ti ti-database-off fs-7"></i>
                                    <p class="mb-0 mt-2">Tidak ada data tagihan pada periode ini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Custom Pagination --}}
            @if ($tagihan->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $tagihan->firstItem() }} - {{ $tagihan->lastItem() }} dari {{ $tagihan->total() }}
                        data
                    </div>
                    <nav>
                        {{ $tagihan->appends(['start_date' => $startDate, 'end_date' => $endDate, 'status' => $statusFilter])->links('pagination::bootstrap-4') }}
                    </nav>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ url('') }}/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script>
        // 1. Line Chart - Trend Pembayaran
        var lineChartOptions = {
            series: [{
                name: "Pembayaran Diterima",
                data: @json($chartValues)
            }],
            chart: {
                height: 300,
                type: 'line',
                fontFamily: 'inherit',
                foreColor: '#adb0bb',
                toolbar: {
                    show: false
                }
            },
            colors: ['#5D87FF'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            grid: {
                borderColor: 'rgba(0,0,0,0.1)',
                strokeDashArray: 3
            },
            xaxis: {
                categories: @json($chartLabels), // Label dinamis dari controller
                labels: {
                    style: {
                        cssClass: 'grey--text lighten-2--text fill-color'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        // Format ke Juta/Ribu jika angka besar
                        if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                        if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + 'rb';
                        return val;
                    }
                }
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val) {
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            }
        };
        var lineChart = new ApexCharts(document.querySelector("#lineChart"), lineChartOptions);
        lineChart.render();

        // 2. Donut Chart - Status Tagihan
        var donutChartOptions = {
            series: @json($statusData),
            chart: {
                type: 'donut',
                height: 250,
                fontFamily: 'inherit',
                foreColor: '#adb0bb'
            },
            labels: ['Belum Bayar', 'Cicilan', 'Lunas', 'Terlambat'],
            colors: ['#FFAE1F', '#13DEB9', '#5D87FF', '#FA896B'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                show: false
            },
            tooltip: {
                theme: 'dark'
            }
        };
        var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutChartOptions);
        donutChart.render();

        // 3. Bar Chart - Top Mitra
        var barChartOptions = {
            series: [{
                name: 'Total Pembayaran',
                data: @json($mitraValues)
            }],
            chart: {
                type: 'bar',
                height: 300,
                fontFamily: 'inherit',
                foreColor: '#adb0bb',
                toolbar: {
                    show: false
                }
            },
            colors: ['#5D87FF'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    borderRadius: 4
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: @json($mitraLabels),
                labels: {
                    style: {
                        cssClass: 'grey--text lighten-2--text fill-color'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                        return val;
                    }
                }
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val) {
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            }
        };
        var barChart = new ApexCharts(document.querySelector("#barChart"), barChartOptions);
        barChart.render();
    </script>
@endpush

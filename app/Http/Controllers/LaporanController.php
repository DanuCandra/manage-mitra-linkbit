<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Set Tanggal Default (3 Bulan Kebelakang)
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        // Jika user tidak filter start_date, ambil 3 bulan sebelum end_date
        $startDate = $request->start_date ?? Carbon::parse($endDate)->subMonths(2)->startOfMonth()->format('Y-m-d');

        // Filter status
        $statusFilter = $request->status ?? 'all';

        // ========== STATISTIK UMUM (Cards) ==========

        $totalTagihan = Tagihan::whereBetween('tanggal_tagihan', [$startDate, $endDate])
            ->sum('total_tagihan');

        $totalDibayar = Pembayaran::whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->where('status_verifikasi', 'diterima')
            ->sum('jumlah_bayar');

        $totalPending = Pembayaran::whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->where('status_verifikasi', 'pending')
            ->sum('jumlah_bayar');

        $totalPiutang = Tagihan::whereBetween('tanggal_tagihan', [$startDate, $endDate])
            ->whereIn('status_pembayaran', ['belum_bayar', 'cicilan', 'terlambat'])
            ->sum('sisa_tagihan');

        // ========== STATISTIK PER STATUS (Donut Chart) ==========

        $tagihanBelumBayar = Tagihan::whereBetween('tanggal_tagihan', [$startDate, $endDate])
            ->where('status_pembayaran', 'belum_bayar')->count();

        $tagihanCicilan = Tagihan::whereBetween('tanggal_tagihan', [$startDate, $endDate])
            ->where('status_pembayaran', 'cicilan')->count();

        $tagihanLunas = Tagihan::whereBetween('tanggal_tagihan', [$startDate, $endDate])
            ->where('status_pembayaran', 'lunas')->count();

        $tagihanTerlambat = Tagihan::whereBetween('tanggal_tagihan', [$startDate, $endDate])
            ->where('status_pembayaran', 'terlambat')->count();

        $statusData = [$tagihanBelumBayar, $tagihanCicilan, $tagihanLunas, $tagihanTerlambat];

        // ========== DATA CHART TREND PEMBAYARAN (Line Chart) ==========

        // Query grouping per Tahun-Bulan agar aman lintas tahun
        $rawMonthlyData = Pembayaran::select(
            DB::raw("DATE_FORMAT(tanggal_bayar, '%Y-%m') as month_year"),
            DB::raw('SUM(jumlah_bayar) as total')
        )
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->where('status_verifikasi', 'diterima')
            ->groupBy('month_year')
            ->orderBy('month_year', 'asc')
            ->pluck('total', 'month_year')
            ->toArray();

        // Normalisasi Data: Pastikan semua bulan dalam range ada datanya (isi 0 jika kosong)
        $chartLabels = [];
        $chartValues = [];

        $period = \Carbon\CarbonPeriod::create($startDate, '1 month', $endDate);

        foreach ($period as $date) {
            $key = $date->format('Y-m');
            $label = $date->translatedFormat('M Y'); // Contoh: Jan 2025

            $chartLabels[] = $label;
            $chartValues[] = $rawMonthlyData[$key] ?? 0;
        }

        // ========== TOP 5 MITRA (Bar Chart) ==========

        $topMitra = Mitra::withSum([
            'tagihan as total_dibayar' => function ($query) use ($startDate, $endDate) {
                $query->whereHas('pembayaran', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('tanggal_bayar', [$startDate, $endDate])
                        ->where('status_verifikasi', 'diterima');
                });
            }
        ], 'total_dibayar') // Disini kita sum pembayaran yang diterima, bukan tagihan
            ->orderByDesc('total_dibayar')
            ->limit(5)
            ->get();

        // Siapkan data Bar Chart Mitra agar view lebih bersih
        $mitraLabels = $topMitra->pluck('user.name')->toArray();
        $mitraValues = $topMitra->pluck('total_dibayar')->map(function ($val) {
            return $val ?? 0;
        })->toArray();

        // ========== DETAIL TAGIHAN WITH PAGINATION ==========

        $query = Tagihan::with(['mitra.user', 'pembayaran'])
            ->whereBetween('tanggal_tagihan', [$startDate, $endDate]);

        if ($statusFilter != 'all') {
            $query->where('status_pembayaran', $statusFilter);
        }

        $tagihan = $query->orderBy('tanggal_tagihan', 'desc')->paginate(10);

        return view('admin.laporan-keuangan.index', compact(
            'totalTagihan',
            'totalDibayar',
            'totalPending',
            'totalPiutang',
            'tagihanBelumBayar',
            'tagihanCicilan',
            'tagihanLunas',
            'tagihanTerlambat',
            'tagihan',
            'topMitra',
            'startDate',
            'endDate',
            'statusFilter',
            'chartLabels',
            'chartValues',
            'statusData',
            'mitraLabels',
            'mitraValues'
        ));
    }

    public function export(Request $request)
    {
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');
        $startDate = $request->start_date ?? Carbon::parse($endDate)->subMonths(2)->startOfMonth()->format('Y-m-d');
        $statusFilter = $request->status ?? 'all';

        // Statistik
        $totalTagihan = Tagihan::whereBetween('tanggal_tagihan', [$startDate, $endDate])->sum('total_tagihan');
        $totalDibayar = Pembayaran::whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->where('status_verifikasi', 'diterima')->sum('jumlah_bayar');
        $totalPending = Pembayaran::whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->where('status_verifikasi', 'pending')->sum('jumlah_bayar');
        $totalPiutang = Tagihan::whereBetween('tanggal_tagihan', [$startDate, $endDate])
            ->whereIn('status_pembayaran', ['belum_bayar', 'cicilan', 'terlambat'])->sum('sisa_tagihan');

        // Data tagihan
        $query = Tagihan::with(['mitra.user', 'pembayaran'])
            ->whereBetween('tanggal_tagihan', [$startDate, $endDate]);

        if ($statusFilter != 'all') {
            $query->where('status_pembayaran', $statusFilter);
        }

        $tagihan = $query->orderBy('tanggal_tagihan', 'desc')->get();

        $pdf = PDF::loadView('admin.laporan-keuangan.pdf', compact(
            'tagihan',
            'startDate',
            'endDate',
            'totalTagihan',
            'totalDibayar',
            'totalPending',
            'totalPiutang'
        ));

        $filename = "laporan_keuangan_{$startDate}_to_{$endDate}.pdf";

        return $pdf->download($filename);
    }
}

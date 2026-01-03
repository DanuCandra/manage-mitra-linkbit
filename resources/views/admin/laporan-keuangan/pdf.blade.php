<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            background: #5D87FF;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
        }

        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .stat-box h3 {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }

        .stat-box .value {
            font-size: 16px;
            font-weight: bold;
            color: #5D87FF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background: #f8f9fa;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            font-weight: bold;
            font-size: 11px;
        }

        td {
            font-size: 10px;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-warning {
            background: #FFF3CD;
            color: #856404;
        }

        .badge-info {
            background: #D1ECF1;
            color: #0C5460;
        }

        .badge-success {
            background: #D4EDDA;
            color: #155724;
        }

        .badge-danger {
            background: #F8D7DA;
            color: #721C24;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN KEUANGAN</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>TOTAL TAGIHAN</h3>
            <div class="value">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <h3>TOTAL DIBAYAR</h3>
            <div class="value" style="color: #28a745;">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <h3>PENDING</h3>
            <div class="value" style="color: #ffc107;">Rp {{ number_format($totalPending, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <h3>PIUTANG</h3>
            <div class="value" style="color: #dc3545;">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Tagihan</th>
                <th>Mitra</th>
                <th class="text-end">Total Tagihan</th>
                <th class="text-end">Dibayar</th>
                <th class="text-end">Sisa</th>
                <th>Jatuh Tempo</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tagihan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_tagihan }}</td>
                    <td>{{ $item->mitra->user->name ?? '-' }}</td>
                    <td class="text-end">Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($item->total_dibayar, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($item->sisa_tagihan, 0, ',', '.') }}</td>
                    <td>{{ $item->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @if ($item->status_pembayaran == 'belum_bayar')
                            <span class="badge badge-warning">Belum Bayar</span>
                        @elseif($item->status_pembayaran == 'cicilan')
                            <span class="badge badge-info">Cicilan</span>
                        @elseif($item->status_pembayaran == 'lunas')
                            <span class="badge badge-success">Lunas</span>
                        @else
                            <span class="badge badge-danger">Terlambat</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>© {{ now()->year }} ISP Management System</p>
    </div>
</body>

</html>

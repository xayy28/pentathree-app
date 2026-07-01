<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Natasha Homestay</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            color: #2C3E35;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.45;
            margin: 0;
        }

        h1,
        h2,
        h3,
        p {
            margin: 0;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 4px;
        }

        h2 {
            color: #2B4C3F;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .muted {
            color: #6B7C72;
        }

        .header {
            border-bottom: 2px solid #2B4C3F;
            margin-bottom: 18px;
            padding-bottom: 12px;
        }

        .section {
            margin-bottom: 18px;
        }

        .summary {
            width: 100%;
            border-spacing: 8px;
            margin-left: -8px;
            margin-right: -8px;
        }

        .summary td {
            border: 1px solid #D7DED8;
            border-radius: 6px;
            padding: 12px;
            width: 25%;
            vertical-align: top;
        }

        .label {
            color: #6B7C72;
            display: block;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: .05em;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .value {
            color: #2B4C3F;
            font-size: 15px;
            font-weight: bold;
        }

        table.data {
            border-collapse: collapse;
            width: 100%;
        }

        table.data th {
            background: #F1F4F0;
            border: 1px solid #D7DED8;
            color: #4D6559;
            font-size: 10px;
            padding: 8px;
            text-align: left;
        }

        table.data td {
            border: 1px solid #D7DED8;
            padding: 8px;
            vertical-align: top;
        }

        .right {
            text-align: right;
        }

        .empty {
            background: #F8F8F5;
            border: 1px dashed #C8D1CA;
            border-radius: 6px;
            color: #6B7C72;
            padding: 12px;
            text-align: center;
        }

        .footer {
            border-top: 1px solid #D7DED8;
            color: #6B7C72;
            font-size: 9px;
            margin-top: 20px;
            padding-top: 8px;
        }
    </style>
</head>

<body>
    @php
        $statusLabels = [
            \App\Models\Pemesanan::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            \App\Models\Pemesanan::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            \App\Models\Pemesanan::STATUS_DIPROSES => 'Diproses',
            \App\Models\Pemesanan::STATUS_DIKONFIRMASI => 'Dikonfirmasi',
            \App\Models\Pemesanan::STATUS_SELESAI => 'Selesai',
            \App\Models\Pemesanan::STATUS_DIBATALKAN => 'Dibatalkan',
        ];

        $periode = $dateFrom || $dateTo
            ? ($dateFrom?->format('d M Y') ?? 'Awal').' - '.($dateTo?->format('d M Y') ?? 'Sekarang')
            : 'Semua Periode';
    @endphp

    <div class="header">
        <h1>Laporan Natasha Homestay & Harau Souvenir</h1>
        <p class="muted">Periode: {{ $periode }}</p>
        <p class="muted">Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <div class="section">
        <h2>Ringkasan</h2>
        <table class="summary">
            <tr>
                <td>
                    <span class="label">Total Pendapatan</span>
                    <span class="value">Rp {{ number_format((float) $summary['total_pendapatan'], 0, ',', '.') }}</span>
                </td>
                <td>
                    <span class="label">Pendapatan Souvenir</span>
                    <span class="value">Rp {{ number_format((float) $summary['pendapatan_souvenir'], 0, ',', '.') }}</span>
                </td>
                <td>
                    <span class="label">Pendapatan Homestay</span>
                    <span class="value">Rp {{ number_format((float) $summary['pendapatan_homestay'], 0, ',', '.') }}</span>
                </td>
                <td>
                    <span class="label">Reservasi Homestay</span>
                    <span class="value">{{ $summary['total_reservasi'] }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Penjualan Souvenir</h2>
        @if ($souvenirSales->isEmpty())
            <div class="empty">Belum ada penjualan souvenir terverifikasi pada periode ini.</div>
        @else
            <table class="data">
                <thead>
                    <tr>
                        <th>Souvenir</th>
                        <th class="right">Terjual</th>
                        <th class="right">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($souvenirSales as $item)
                        <tr>
                            <td>{{ $item->nama_item }}</td>
                            <td class="right">{{ $item->total_terjual }} pcs</td>
                            <td class="right">Rp {{ number_format((float) $item->total_penjualan, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="section">
        <h2>Status Reservasi Homestay</h2>
        <table class="data">
            <thead>
                <tr>
                    <th>Status</th>
                    <th class="right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservationStatusCounts as $status => $count)
                    <tr>
                        <td>{{ $statusLabels[$status] ?? str_replace('_', ' ', $status) }}</td>
                        <td class="right">{{ $count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Pembayaran Terverifikasi Terbaru</h2>
        @if ($recentPayments->isEmpty())
            <div class="empty">Belum ada pembayaran terverifikasi pada periode ini.</div>
        @else
            <table class="data">
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Jenis</th>
                        <th>Tanggal Bayar</th>
                        <th class="right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentPayments as $pembayaran)
                        <tr>
                            <td>{{ $pembayaran->pemesanan?->kode_pemesanan ?? '-' }}</td>
                            <td>{{ $pembayaran->pemesanan?->user?->nama ?? '-' }}</td>
                            <td>{{ ucfirst($pembayaran->pemesanan?->jenis_pemesanan ?? '-') }}</td>
                            <td>{{ $pembayaran->tanggal_pembayaran?->format('d M Y H:i') ?? '-' }}</td>
                            <td class="right">Rp {{ number_format((float) $pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="footer">
        Laporan ini dibuat otomatis dari pembayaran terverifikasi, data pemesanan, dan detail pemesanan aplikasi.
    </div>
</body>

</html>

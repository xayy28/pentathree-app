<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>{{ $invoice->nomor_invoice }}</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    line-height: 1.5;
    color: #2C3E35;
    background: #ECEAE5;
}

/* ── Outer page padding ── */
.page {
    padding: 28px 32px;
}

/* ── White card ── */
.card-table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border: 1px solid #D8D5CE;
}

/* ── Brand bar ── */
.brand-bar {
    width: 100%;
    border-collapse: collapse;
}
.brand-bar td {
    padding: 18px 28px;
    vertical-align: middle;
}
.brand-name {
    font-size: 12px;
    font-weight: bold;
    letter-spacing: .16em;
    text-transform: uppercase;
    color: #1E362C;
}
.brand-tagline {
    font-size: 9px;
    color: #7A9186;
    letter-spacing: .06em;
    margin-top: 2px;
}

/* ── Thick divider ── */
.thick-div {
    background: #1E362C;
    height: 3px;
    font-size: 0;
    line-height: 0;
}

/* ── Status badge ── */
.badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 3px;
    font-size: 9px;
    font-weight: bold;
    letter-spacing: .08em;
    text-transform: uppercase;
}
.badge-green  { background:#E8F5E9; color:#2E7D32; border:1px solid #A5D6A7; }
.badge-yellow { background:#FFFDE7; color:#F57F17; border:1px solid #FFE082; }
.badge-grey   { background:#F5F5F5; color:#616161; border:1px solid #E0E0E0; }

/* ── Main content ── */
.content {
    padding: 24px 28px 26px;
}

/* ── Invoice header ── */
.inv-hdr { width:100%; border-collapse:collapse; }
.inv-hdr td { vertical-align:top; padding:0; }

.lbl-xs {
    font-size: 8.5px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: .10em;
    color: #7A9186;
    margin-bottom: 4px;
}
.inv-num {
    font-size: 22px;
    font-weight: bold;
    color: #1E362C;
    margin: 4px 0;
    letter-spacing: .02em;
}
.brand-sub { font-size: 10px; color: #5C6E65; }

.date-big { font-size: 14px; font-weight: bold; color: #1E362C; }
.date-sub { font-size: 9.5px; color: #8A9C91; margin-top: 2px; }
.date-badge { margin-top: 8px; }

/* ── Thin HR ── */
.hr-thin {
    border: none;
    border-top: 1px solid #D8D5CE;
    margin: 16px 0;
}

/* ── Info section ── */
.info-tbl { width:100%; border-collapse:collapse; margin-bottom: 20px; }
.info-tbl td { vertical-align:top; padding:0; }

.info-box {
    background: #F9F8F5;
    border: 1px solid #E4E1DA;
    border-radius: 4px;
    padding: 12px 14px;
}
.info-name { font-size:13px; font-weight:bold; color:#1E362C; margin: 5px 0 4px; }
.info-line { font-size:10px; color:#5C6E65; margin-bottom:2px; }
.info-row  { font-size:10px; color:#2C3E35; margin-bottom:4px; }
.muted     { color:#8A9C91; }

/* ── Items table ── */
.items-wrap {
    border: 1px solid #D8D5CE;
    border-radius: 4px;
    margin-bottom: 0;
    overflow: hidden;
}
table.items {
    width: 100%;
    border-collapse: collapse;
}
table.items thead tr { background: #F0EDE6; }
table.items th {
    font-size: 8.5px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #5C6E65;
    padding: 9px 12px;
    border-bottom: 1px solid #D8D5CE;
    text-align: left;
}
table.items th.r { text-align: right; }
table.items th.c { text-align: center; }

table.items td {
    padding: 10px 12px;
    border-bottom: 1px solid #EDEBE6;
    font-size: 10.5px;
    vertical-align: middle;
    color: #2C3E35;
}
table.items tbody tr:last-child td { border-bottom: none; }
table.items td.r { text-align: right; }
table.items td.c { text-align: center; }

.item-n { font-weight: bold; font-size: 11px; color: #1E362C; }
.item-m { font-size: 9px; color: #8A9C91; margin-top: 3px; }

/* ── Totals (aligned to Subtotal column) ── */
.totals-section {
    border-top: 1px solid #D8D5CE;
    padding: 10px 12px;
}
table.totals {
    border-collapse: collapse;
    margin-left: auto;
    width: 270px;
}
table.totals td { padding: 4px 0; font-size: 11px; }
table.totals .lt { color: #5C6E65; text-align: left; padding-right: 12px; }
table.totals .rt { color: #2C3E35; text-align: right; font-variant-numeric: tabular-nums; }

.totals-divider {
    border: none;
    border-top: 1px solid #D8D5CE;
    margin: 6px 0;
}
table.totals tr.fin .lt { font-size:13px; font-weight:bold; color:#1E362C; }
table.totals tr.fin .rt { font-size:13px; font-weight:bold; color:#C0392B; }

/* ── Footer ── */
.foot {
    border-top: 1px solid #D8D5CE;
    padding-top: 12px;
    margin-top: 20px;
}
table.ft { width:100%; border-collapse:collapse; }
table.ft td { font-size: 9px; color: #9AAE9F; vertical-align:top; line-height:1.7; }
table.ft .fl { text-align:left; width:55%; }
table.ft .fr { text-align:right; width:45%; }
</style>
</head>
<body>
@php
    $pemesanan    = $invoice->pemesanan;
    $pembayaran   = $invoice->pembayaran ?? $pemesanan->pembayaran;
    $tanggalBayar = $pembayaran?->paid_at
                 ?? $pembayaran?->verified_at
                 ?? $pembayaran?->tanggal_pembayaran;

    $logoPath = public_path('images/Logo-Natasha.jpg');
    $logoB64  = file_exists($logoPath)
        ? 'data:image/jpeg;base64,'.base64_encode(file_get_contents($logoPath))
        : '';

    $statusBadge = match(strtolower($invoice->status_invoice)) {
        'terbit'    => 'badge-green',
        'menunggu'  => 'badge-yellow',
        default     => 'badge-grey',
    };
@endphp

<div class="page">
<table class="card-table">

    {{-- ── Brand bar ── --}}
    <tr>
        <td style="padding:0;">
            <table class="brand-bar">
                <tr>
                    <td style="padding:16px 28px; vertical-align:middle;">
                        <table style="border-collapse:collapse;">
                            <tr>
                                @if ($logoB64)
                                <td style="vertical-align:middle; padding-right:12px;">
                                    <img src="{{ $logoB64 }}" width="40" height="40"
                                         style="border-radius:50%; border:2px solid #2B4C3F; display:block;"
                                         alt="Logo">
                                </td>
                                @endif
                                <td style="vertical-align:middle;">
                                    <div class="brand-name">Natasha Homestay &amp; Harau Souvenir</div>
                                    <div class="brand-tagline">Lembah Harau, Sumatera Barat</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- ── Thick divider ── --}}
    <tr class="thick-div">
        <td style="background:#1E362C; height:3px; font-size:0; line-height:0;">&nbsp;</td>
    </tr>

    {{-- ── Main content ── --}}
    <tr>
        <td class="content">

            {{-- Invoice header --}}
            <table class="inv-hdr">
                <tr>
                    <td style="width:60%;">
                        <div class="lbl-xs">Invoice</div>
                        <div class="inv-num">{{ $invoice->nomor_invoice }}</div>
                        <div class="brand-sub">Natasha Homestay &amp; Harau Souvenir</div>
                    </td>
                    <td style="text-align:right;">
                        <div class="lbl-xs">Tanggal Terbit</div>
                        <div class="date-big">{{ $invoice->tanggal_invoice->format('d M Y') }}</div>
                        <div class="date-sub">{{ $invoice->tanggal_invoice->format('H:i') }} WIB</div>
                        <div class="date-badge">
                            <span class="badge {{ $statusBadge }}">{{ ucfirst($invoice->status_invoice) }}</span>
                        </div>
                    </td>
                </tr>
            </table>

            <hr class="hr-thin">

            {{-- Info section --}}
            <table class="info-tbl">
                <tr>
                    <td style="width:48%; padding-right:10px;">
                        <div class="lbl-xs">Customer</div>
                        <div class="info-box">
                            <div class="info-name">{{ $pemesanan->user->nama }}</div>
                            @if ($pemesanan->user->no_hp)
                                <div class="info-line">{{ $pemesanan->user->no_hp }}</div>
                            @endif
                            <div class="info-line">{{ $pemesanan->user->email }}</div>
                        </div>
                    </td>
                    <td style="width:52%; padding-left:10px;">
                        <div class="lbl-xs">Detail Pesanan</div>
                        <div class="info-box">
                            <div class="info-row">
                                <span class="muted">Kode&nbsp;&nbsp;&nbsp;&nbsp; : </span>
                                <strong>{{ $pemesanan->kode_pemesanan }}</strong>
                            </div>
                            <div class="info-row">
                                <span class="muted">Jenis&nbsp;&nbsp;&nbsp;&nbsp; : </span>
                                {{ ucfirst($pemesanan->jenis_pemesanan) }}
                            </div>
                            @if ($pembayaran)
                            <div class="info-row">
                                <span class="muted">Metode&nbsp;&nbsp; : </span>
                                {{ ucwords(str_replace('_', ' ', $pembayaran->metode_pembayaran)) }}
                            </div>
                            @endif
                            @if ($tanggalBayar)
                            <div class="info-row" style="margin-bottom:0;">
                                <span class="muted">Tgl Bayar : </span>
                                {{ $tanggalBayar->format('d M Y') }}
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            {{-- Items table --}}
            <div class="items-wrap">
                <table class="items">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th class="c" style="width:95px;">Qty / Durasi</th>
                            <th class="r" style="width:110px;">Harga Satuan</th>
                            <th class="r" style="width:115px;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemesanan->detailPemesanans as $detail)
                        <tr>
                            <td>
                                <div class="item-n">{{ $detail->nama_item }}</div>
                                @if ($detail->homestay_id && $detail->check_in && $detail->check_out)
                                    <div class="item-m">
                                        {{ $detail->check_in->format('d M Y') }} &ndash; {{ $detail->check_out->format('d M Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="c">
                                {{ $detail->homestay_id ? $detail->jumlah_malam.' malam' : $detail->jumlah.' item' }}
                            </td>
                            <td class="r">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="r"><strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Totals inside items-wrap, right-aligned ── --}}
                <div class="totals-section">
                    <table class="totals">
                        <tr>
                            <td class="lt">Total Pesanan</td>
                            <td class="rt">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr class="totals-divider"></td>
                        </tr>
                        <tr class="fin">
                            <td class="lt">Total Tagihan</td>
                            <td class="rt">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Footer --}}
            <div class="foot">
                <table class="ft">
                    <tr>
                        <td class="fl">
                            Dokumen ini diterbitkan secara otomatis setelah pembayaran terverifikasi.<br>
                            Natasha Homestay &amp; Harau Souvenir — Lembah Harau, Sumatera Barat
                        </td>
                        <td class="fr">
                            Dicetak: {{ now()->format('d M Y, H:i') }} WIB
                        </td>
                    </tr>
                </table>
            </div>

        </td>
    </tr>

</table>
</div>

</body>
</html>

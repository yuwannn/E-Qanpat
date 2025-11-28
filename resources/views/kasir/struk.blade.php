<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $pesanan->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Font struk jadul */
            font-size: 12px;
            margin: 0;
            padding: 10px;
            width: 300px; /* Ukuran kertas struk standar (58mm - 80mm disesuaikan px) */
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .header h2 { margin: 0; font-size: 16px; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 10px; }
        
        .info-struk {
            margin-bottom: 10px;
            font-size: 11px;
        }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td { vertical-align: top; }
        .qty { width: 30px; }
        .price { text-align: right; }
        
        .total-section {
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 13px;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }

        /* Sembunyikan tombol print saat dicetak */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>E-QANPAT</h2>
        <p>Kantin Cepat & Hemat</p>
        <p>Jl. Kampus Merdeka No. 1</p>
    </div>

    <div class="info-struk">
        <div>No: #{{ $pesanan->id }}</div>
        <div>Tgl: {{ $pesanan->created_at->format('d/m/Y H:i') }}</div>
        <div>Meja: {{ $pesanan->meja->nomor_meja }}</div>
        <div>Kasir: {{ Auth::user()->name }}</div>
    </div>

    <table>
        @foreach($pesanan->detailPesanans as $item)
        <tr>
            <td class="qty">{{ $item->jumlah }}x</td>
            <td>{{ $item->menu->nama_menu }}</td>
            <td class="price">{{ number_format($item->harga_satuan * $item->jumlah, 0) }}</td>
        </tr>
        @endforeach
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>TOTAL</span>
            <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 11px; margin-top: 5px;">
            <span>Bayar ({{ strtoupper($pesanan->metode_pembayaran) }})</span>
            <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Terima Kasih atas Kunjungan Anda!</p>
        <p>WIFI: Kanpat_Free / Pass: makanenak</p>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.close()" style="cursor: pointer; padding: 5px 10px;">Tutup</button>
    </div>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Profit</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { height: 80px; }
        .title { font-size: 18px; font-weight: bold; }
        .period { font-size: 14px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-right { text-align: right; }
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN PROFIT/LABA</div>
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Terjual</th>
                <th>Total Penjualan</th>
                <th>Total Pembelian</th>
                <th>Laba</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $key => $item)
            @php
                $sold = $item->stockOuts->sum('jumlah');
                $totalSale = $item->stockOuts->sum(function($trx) {
                    return $trx->harga_jual_per_satuan * $trx->jumlah;
                });
                $totalPurchase = $item->harga * $sold;
                $profit = $totalSale - $totalPurchase;
            @endphp
            <tr>
                <td style="text-align: center">{{ $key+1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td style="text-align: center">{{ $sold }}</td>
                <td class="text-right">Rp {{ number_format($totalSale, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalPurchase, 0, ',', '.') }}</td>
                <td class="text-right {{ $profit >= 0 ? 'text-success' : 'text-danger' }}">
                    Rp {{ number_format($profit, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</div>
    </div>
</body>
</html>
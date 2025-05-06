@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Laporan Profit/Laba</h5>
        <div class="d-flex">
            <form id="filterForm" action="{{ route('reports.profit') }}" method="GET" class="form-inline mr-3">
                <div class="input-group input-group-sm">
                    <input type="date" name="start_date" value="{{ $startDate }}" class="form-control form-control-sm">
                    <span class="input-group-text">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="form-control form-control-sm">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
            <div class="btn-group">
                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-file-export"></i> Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="exportReport('pdf')"><i class="fas fa-file-pdf text-danger"></i> PDF</a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportReport('excel')"><i class="fas fa-file-excel text-success"></i> Excel</a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportReport('word')"><i class="fas fa-file-word text-primary"></i> Word</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="reportContent">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
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
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->category->name ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $sold }}</td>
                        <td>Rp {{ number_format($totalSale, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($totalPurchase, 0, ',', '.') }}</td>
                        <td class="{{ $profit >= 0 ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($profit, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function exportReport(type) {
    const form = document.getElementById('filterForm');
    const action = "{{ route('export', ':type') }}".replace(':type', type);
    
    const exportForm = document.createElement('form');
    exportForm.method = 'GET';
    exportForm.action = action;
    
    const startDate = document.createElement('input');
    startDate.type = 'hidden';
    startDate.name = 'start_date';
    startDate.value = form.elements['start_date'].value;
    exportForm.appendChild(startDate);
    
    const endDate = document.createElement('input');
    endDate.type = 'hidden';
    endDate.name = 'end_date';
    endDate.value = form.elements['end_date'].value;
    exportForm.appendChild(endDate);
    
    document.body.appendChild(exportForm);
    exportForm.submit();
    document.body.removeChild(exportForm);
}
</script>
@endsection
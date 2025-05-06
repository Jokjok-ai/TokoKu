@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Menu Laporan</h5>
    </div>
    <div class="card-body">
        <div class="list-group">
            <a href="{{ route('reports.stock') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-boxes mr-2"></i> Laporan Stok Barang
            </a>
            <a href="{{ route('reports.transaction') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-exchange-alt mr-2"></i> Laporan Transaksi Masuk/Keluar
            </a>
            <a href="{{ route('reports.profit') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-money-bill-wave mr-2"></i> Laporan Profit/Laba
            </a>
            <a href="{{ route('reports.category') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-tags mr-2"></i> Laporan Kategori Barang
            </a>
        </div>
    </div>
</div>
@endsection
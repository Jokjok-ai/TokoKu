@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Riwayat Pergerakan Stok</h2>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Barang</th>
                    <th>Kuantitas</th>
                    <th>Pengguna</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->date->format('d/m/Y') }}</td>
                    <td>
                        @if($transaction instanceof \App\Models\StockIn)
                            <span class="badge badge-success">Masuk</span>
                        @else
                            <span class="badge badge-danger">Keluar</span>
                        @endif
                    </td>
                    <td>{{ $transaction->item->name }}</td>
                    <td>{{ number_format($transaction->quantity) }} {{ $transaction->item->unit }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>
                        @if($transaction instanceof \App\Models\StockIn)
                            Pembelian stok masuk
                        @else
                            Penjualan stok keluar
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
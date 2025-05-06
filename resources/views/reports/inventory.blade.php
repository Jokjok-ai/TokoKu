@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Laporan Stok Inventaris</h2>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ number_format($item->stock) }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>Rp {{ number_format($item->price, 2) }}</td>
                    <td>Rp {{ number_format($item->price * $item->stock, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
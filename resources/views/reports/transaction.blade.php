@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Laporan Transaksi</h5>
        <div>
            <form action="{{ route('reports.transaction') }}" method="GET" class="form-inline">
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control form-control-sm mr-2">
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control form-control-sm mr-2">
                <button type="submit" class="btn btn-sm btn-primary mr-2">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="#" onclick="window.print()" class="btn btn-sm btn-success">
                    <i class="fas fa-print"></i> Cetak
                </a>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Stok Masuk</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Beli</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stockIns as $trx)
                            <tr>
                                <td>{{ $trx->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $trx->item->nama }}</td>
                                <td>{{ $trx->jumlah }} {{ $trx->satuan_jumlah }}</td>
                                <td>Rp {{ number_format($trx->harga_per_satuan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($trx->harga_per_satuan * $trx->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="col-md-6">
                <h5>Stok Keluar</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Jual</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stockOuts as $trx)
                            <tr>
                                <td>{{ $trx->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $trx->item->nama }}</td>
                                <td>{{ $trx->jumlah }} {{ $trx->satuan_jumlah }}</td>
                                <td>Rp {{ number_format($trx->harga_jual_per_satuan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($trx->harga_jual_per_satuan * $trx->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <h5>Ringkasan Transaksi</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Jenis</th>
                                <th>Jumlah Transaksi</th>
                                <th>Total Kuantitas</th>
                                <th>Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Stok Masuk</td>
                                <td>{{ $stockIns->count() }}</td>
                                <td>{{ $stockIns->sum('jumlah') }}</td>
                                <td>Rp {{ number_format($stockIns->sum(function($trx) {
                                    return $trx->harga_per_satuan * $trx->jumlah;
                                }), 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Stok Keluar</td>
                                <td>{{ $stockOuts->count() }}</td>
                                <td>{{ $stockOuts->sum('jumlah') }}</td>
                                <td>Rp {{ number_format($stockOuts->sum(function($trx) {
                                    return $trx->harga_jual_per_satuan * $trx->jumlah;
                                }), 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
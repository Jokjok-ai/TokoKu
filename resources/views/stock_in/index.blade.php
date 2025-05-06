@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Data Stok Masuk</h5>
        <a href="{{ route('stockin.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Stok Masuk
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="stockinTable" class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Beli/Satuan</th>
                        <th>Tanggal Masuk</th>
                        <th>Keterangan</th>
                        <th>Ditambahkan Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockIns as $key => $stockIn)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $stockIn->item->nama }}</td>
                        <td>{{ $stockIn->jumlah }}</td>
                        <td>{{ $stockIn->satuan_jumlah }}</td>
                        <td>Rp {{ number_format($stockIn->harga_per_satuan, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($stockIn->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $stockIn->keterangan ?? '-' }}</td>
                        <td>{{ $stockIn->user->name }}</td>
                        <td>
                            <a href="{{ route('stockin.edit', $stockIn->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('stockin.destroy', $stockIn->id) }}" 
                                  method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#stockinTable').DataTable();
    });
</script>
@endpush
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Data Stok Keluar</h5>
        <a href="{{ route('stockout.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Stok Keluar
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="stockoutTable" class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Jual/Satuan</th>
                        <th>Tanggal Keluar</th>
                        <th>Keterangan</th>
                        <th>Ditambahkan Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockOuts as $key => $stockOut)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $stockOut->item->nama }}</td>
                        <td>{{ $stockOut->jumlah }}</td>
                        <td>{{ $stockOut->satuan_jumlah }}</td>
                        <td>Rp {{ number_format($stockOut->harga_jual_per_satuan, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($stockOut->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $stockOut->keterangan ?? '-' }}</td>
                        <td>{{ $stockOut->user->name }}</td>
                        <td>
                            <a href="{{ route('stockout.edit', $stockOut->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('stockout.destroy', $stockOut->id) }}" 
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
        $('#stockoutTable').DataTable();
    });
</script>
@endpush
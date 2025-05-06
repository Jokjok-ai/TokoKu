@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Tambah Stok Keluar
    </div>
    <div class="card-body">
        <form action="{{ route('stockout.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Barang</label>
                <select name="item_id" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Harga Jual per Satuan</label>
                <input type="number" name="harga_jual_per_satuan" class="form-control" min="0" required>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" min="1" required>
            </div>
            <div class="mb-3">
                <label>Satuan Jumlah</label>
                <input type="text" name="satuan_jumlah" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tanggal Keluar</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('stockout.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
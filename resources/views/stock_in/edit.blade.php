@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Edit Stok Masuk
    </div>
    <div class="card-body">
        <form action="{{ route('stockin.update', $stockIn->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Barang</label>
                <select name="item_id" class="form-control" required>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" {{ $stockIn->item_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Harga per Satuan</label>
                <input type="number" name="harga_per_satuan" class="form-control" 
                       value="{{ $stockIn->harga_per_satuan }}" min="0" required>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" 
                       value="{{ $stockIn->jumlah }}" min="1" required>
            </div>
            <div class="mb-3">
                <label>Satuan Jumlah</label>
                <input type="text" name="satuan_jumlah" class="form-control" 
                       value="{{ $stockIn->satuan_jumlah }}" required>
            </div>
            <div class="mb-3">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal" class="form-control" 
                       value="{{ $stockIn->tanggal->format('Y-m-d') }}" required>
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ $stockIn->keterangan }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('stockin.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
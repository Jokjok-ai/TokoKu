<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts = StockOut::with(['item', 'user'])->latest()->get();
        return view('stock_out.index', compact('stockOuts'));
    }

    public function create()
    {
        $items = Item::all();
        return view('stock_out.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'harga_jual_per_satuan' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
            'satuan_jumlah' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $stockOut = StockOut::create([
            'item_id' => $validated['item_id'],
            'harga_jual_per_satuan' => $validated['harga_jual_per_satuan'],
            'jumlah' => $validated['jumlah'],
            'satuan_jumlah' => $validated['satuan_jumlah'],
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'],
            'user_id' => Auth::id()
        ]);

        // Update stok item (dikurangi)
        $item = Item::find($validated['item_id']);
        $item->decrement('stok', $validated['jumlah']);

        return redirect()->route('stockout.index')
            ->with('success', 'Stok keluar berhasil dicatat');
    }

    public function edit(StockOut $stockOut)
    {
        $items = Item::all();
        return view('stock_out.edit', compact('stockOut', 'items'));
    }

    public function update(Request $request, StockOut $stockOut)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'harga_jual_per_satuan' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
            'satuan_jumlah' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $oldItemId = $stockOut->item_id;
        $oldJumlah = $stockOut->jumlah;

        // Update data stok keluar
        $stockOut->update([
            'item_id' => $validated['item_id'],
            'harga_jual_per_satuan' => $validated['harga_jual_per_satuan'],
            'jumlah' => $validated['jumlah'],
            'satuan_jumlah' => $validated['satuan_jumlah'],
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'],
            'user_id' => Auth::id()
        ]);

        // Jika item berubah
        if ($oldItemId != $validated['item_id']) {
            // Kembalikan stok item lama
            Item::find($oldItemId)->increment('stok', $oldJumlah);
            // Kurangi stok item baru
            Item::find($validated['item_id'])->decrement('stok', $validated['jumlah']);
        } else {
            // Jika item sama, update selisih jumlah
            $difference = $validated['jumlah'] - $oldJumlah;
            Item::find($validated['item_id'])->decrement('stok', $difference);
        }

        return redirect()->route('stockout.index')
            ->with('success', 'Stok keluar berhasil diperbarui');
    }

    public function destroy(StockOut $stockOut)
    {
        // Kembalikan stok item
        $item = $stockOut->item;
        $item->increment('stok', $stockOut->jumlah);

        $stockOut->delete();

        return redirect()->route('stockout.index')
            ->with('success', 'Stok keluar berhasil dihapus');
    }
}
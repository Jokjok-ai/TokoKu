<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockInController extends Controller
{
    public function index()
    {
        $stockIns = StockIn::with(['item', 'user'])->latest()->get();
        return view('stock_in.index', compact('stockIns'));
    }

    public function create()
    {
        $items = Item::all();
        return view('stock_in.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'harga_per_satuan' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
            'satuan_jumlah' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $stockIn = StockIn::create([
            'item_id' => $validated['item_id'],
            'harga_per_satuan' => $validated['harga_per_satuan'],
            'jumlah' => $validated['jumlah'],
            'satuan_jumlah' => $validated['satuan_jumlah'],
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'],
            'user_id' => Auth::id()
        ]);

        // Update stok item
        $item = Item::find($validated['item_id']);
        $item->increment('stok', $validated['jumlah']);

        return redirect()->route('stockin.index')
            ->with('success', 'Stok masuk berhasil dicatat');
    }

    public function edit(StockIn $stockIn)
    {
        $items = Item::all();
        return view('stock_in.edit', compact('stockIn', 'items'));
    }

    public function update(Request $request, StockIn $stockIn)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'harga_per_satuan' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:1',
            'satuan_jumlah' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $oldItemId = $stockIn->item_id;
        $oldJumlah = $stockIn->jumlah;

        // Update data stok masuk
        $stockIn->update([
            'item_id' => $validated['item_id'],
            'harga_per_satuan' => $validated['harga_per_satuan'],
            'jumlah' => $validated['jumlah'],
            'satuan_jumlah' => $validated['satuan_jumlah'],
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'],
            'user_id' => Auth::id()
        ]);

        // Jika item berubah, kembalikan stok lama lalu tambahkan stok baru
        if ($oldItemId != $validated['item_id']) {
            Item::find($oldItemId)->decrement('stok', $oldJumlah);
            Item::find($validated['item_id'])->increment('stok', $validated['jumlah']);
        } else {
            // Jika item sama, hanya update selisih jumlah
            $difference = $validated['jumlah'] - $oldJumlah;
            Item::find($validated['item_id'])->increment('stok', $difference);
        }

        return redirect()->route('stockin.index')
            ->with('success', 'Stok masuk berhasil diperbarui');
    }

    public function destroy(StockIn $stockIn)
    {
        // Kurangi stok item terkait
        $item = $stockIn->item;
        if ($item && $stockIn->jumlah <= $item->stok) {
            $item->decrement('stok', $stockIn->jumlah);
        }

        $stockIn->delete();

        return redirect()->route('stockin.index')
            ->with('success', 'Stok masuk berhasil dihapus');
    }
}

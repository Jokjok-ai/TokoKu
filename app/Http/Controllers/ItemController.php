<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        return view('data_barang.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('data_barang.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric|min:0',
            'satuan_harga' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'satuan_stok' => 'required|string|max:50',
            'keterangan' => 'nullable|string'
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Data barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('data_barang.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric|min:0',
            'satuan_harga' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'satuan_stok' => 'required|string|max:50',
            'keterangan' => 'nullable|string'
        ]);

        $item = Item::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Data barang berhasil dihapus');
    }
}
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run()
    {
        // Seed categories first
        $categories = [
            ['name' => 'Sembako', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Minuman', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Snack', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perlengkapan Mandi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rokok', 'created_at' => now(), 'updated_at' => now()],
        ];
        
        DB::table('categories')->insert($categories);

        // Seed items
        $items = [
            [
                'nama' => 'Beras Premium',
                'category_id' => 1,
                'harga' => 12500,
                'satuan_harga' => 'kg',
                'stok' => 100,
                'satuan_stok' => 'kg',
                'keterangan' => 'Beras kualitas premium',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Minyak Goreng 1L',
                'category_id' => 1,
                'harga' => 18000,
                'satuan_harga' => 'botol',
                'stok' => 50,
                'satuan_stok' => 'botol',
                'keterangan' => 'Minyak goreng kemasan botol',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Aqua Botol 600ml',
                'category_id' => 2,
                'harga' => 5000,
                'satuan_harga' => 'botol',
                'stok' => 200,
                'satuan_stok' => 'botol',
                'keterangan' => 'Air mineral kemasan botol',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Indomie Goreng',
                'category_id' => 3,
                'harga' => 3500,
                'satuan_harga' => 'bungkus',
                'stok' => 150,
                'satuan_stok' => 'bungkus',
                'keterangan' => 'Mi instan rasa goreng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Lifebuoy Sabun',
                'category_id' => 4,
                'harga' => 4500,
                'satuan_harga' => 'batang',
                'stok' => 80,
                'satuan_stok' => 'batang',
                'keterangan' => 'Sabun mandi Lifebuoy',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Sampoerna Mild',
                'category_id' => 5,
                'harga' => 32000,
                'satuan_harga' => 'bungkus',
                'stok' => 60,
                'satuan_stok' => 'bungkus',
                'keterangan' => 'Rokok Sampoerna Mild 16 batang',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        
        DB::table('items')->insert($items);

        // Seed stock_in records
        $stockIn = [
            [
                'item_id' => 1,
                'harga_per_satuan' => 12000,
                'jumlah' => 100,
                'satuan_jumlah' => 'kg',
                'keterangan' => 'Pembelian awal',
                'tanggal' => Carbon::now()->subDays(30),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_id' => 2,
                'harga_per_satuan' => 17000,
                'jumlah' => 50,
                'satuan_jumlah' => 'botol',
                'keterangan' => 'Pembelian dari supplier utama',
                'tanggal' => Carbon::now()->subDays(25),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_id' => 3,
                'harga_per_satuan' => 4500,
                'jumlah' => 10,
                'satuan_jumlah' => 'dus',
                'keterangan' => '1 dus isi 24 botol',
                'tanggal' => Carbon::now()->subDays(20),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_id' => 4,
                'harga_per_satuan' => 3000,
                'jumlah' => 5,
                'satuan_jumlah' => 'dus',
                'keterangan' => '1 dus isi 30 bungkus',
                'tanggal' => Carbon::now()->subDays(15),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_id' => 5,
                'harga_per_satuan' => 4000,
                'jumlah' => 2,
                'satuan_jumlah' => 'dus',
                'keterangan' => '1 dus isi 40 batang',
                'tanggal' => Carbon::now()->subDays(10),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        
        DB::table('stock_in')->insert($stockIn);

        // Seed stock_out records
        $stockOut = [
            [
                'item_id' => 1,
                'harga_jual_per_satuan' => 12500,
                'jumlah' => 5,
                'satuan_jumlah' => 'kg',
                'keterangan' => 'Penjualan ke pelanggan',
                'tanggal' => Carbon::now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_id' => 2,
                'harga_jual_per_satuan' => 18000,
                'jumlah' => 3,
                'satuan_jumlah' => 'botol',
                'keterangan' => 'Penjualan ke pelanggan',
                'tanggal' => Carbon::now()->subDays(4),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_id' => 3,
                'harga_jual_per_satuan' => 5000,
                'jumlah' => 10,
                'satuan_jumlah' => 'botol',
                'keterangan' => 'Penjualan ke pelanggan',
                'tanggal' => Carbon::now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_id' => 4,
                'harga_jual_per_satuan' => 3500,
                'jumlah' => 15,
                'satuan_jumlah' => 'bungkus',
                'keterangan' => 'Penjualan ke pelanggan',
                'tanggal' => Carbon::now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'item_id' => 5,
                'harga_jual_per_satuan' => 4500,
                'jumlah' => 8,
                'satuan_jumlah' => 'batang',
                'keterangan' => 'Penjualan ke pelanggan',
                'tanggal' => Carbon::now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        
        DB::table('stock_out')->insert($stockOut);
    }
}
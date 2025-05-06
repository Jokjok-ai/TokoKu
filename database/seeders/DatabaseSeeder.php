<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed users first (no dependencies)
        DB::table('users')->insert([
            [
                'name' => 'Admin Toko',
                'username' => 'admin1',
                'email' => 'admin1@tokoku.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567890',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Kasir Toko',
                'username' => 'kasir1',
                'email' => 'kasir1@tokoku.com',
                'password' => Hash::make('password123'),
                'phone' => '082345678901',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        // Seed categories (no dependencies)
        $categories = [
            ['name' => 'Sembako', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Minuman', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Snack', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Perlengkapan Mandi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Rokok', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ];
        DB::table('categories')->insert($categories);

        // Seed items (depends on categories)
        $items = [
            [
                'nama' => 'Beras Premium',
                'category_id' => 1,
                'harga' => 12500,
                'satuan_harga' => 'kg',
                'stok' => 100,
                'satuan_stok' => 'kg',
                'keterangan' => 'Beras kualitas premium',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Minyak Goreng 1L',
                'category_id' => 1,
                'harga' => 18000,
                'satuan_harga' => 'botol',
                'stok' => 50,
                'satuan_stok' => 'botol',
                'keterangan' => 'Minyak goreng kemasan botol',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Aqua Botol 600ml',
                'category_id' => 2,
                'harga' => 5000,
                'satuan_harga' => 'botol',
                'stok' => 200,
                'satuan_stok' => 'botol',
                'keterangan' => 'Air mineral kemasan botol',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Indomie Goreng',
                'category_id' => 3,
                'harga' => 3500,
                'satuan_harga' => 'bungkus',
                'stok' => 150,
                'satuan_stok' => 'bungkus',
                'keterangan' => 'Mi instan rasa goreng',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Lifebuoy Sabun',
                'category_id' => 4,
                'harga' => 4500,
                'satuan_harga' => 'batang',
                'stok' => 80,
                'satuan_stok' => 'batang',
                'keterangan' => 'Sabun mandi Lifebuoy',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        DB::table('items')->insert($items);



// Seed stock_in dan stock_out
$items = DB::table('items')->pluck('id')->toArray();
$users = DB::table('users')->pluck('id')->toArray();
$satuan = ['kg', 'botol', 'bungkus', 'batang', 'lusin', 'dus'];

for ($i = 0; $i < 50; $i++) {
    DB::table('stock_in')->insert([
        'item_id' => $items[array_rand($items)],
        'user_id' => $users[array_rand($users)],
        'harga_per_satuan' => rand(1000, 30000),
        'jumlah' => rand(1, 100),
        'satuan_jumlah' => $satuan[array_rand($satuan)],
        'keterangan' => 'Stok masuk otomatis ke-' . ($i+1),
        'tanggal' => Carbon::now()->subDays(rand(0, 90)),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);

    DB::table('stock_out')->insert([
        'item_id' => $items[array_rand($items)],
        'user_id' => $users[array_rand($users)],
        'harga_jual_per_satuan' => rand(2000, 50000),
        'jumlah' => rand(1, 80),
        'satuan_jumlah' => $satuan[array_rand($satuan)],
        'keterangan' => 'Stok keluar otomatis ke-' . ($i+1),
        'tanggal' => Carbon::now()->subDays(rand(0, 90)),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);
}
    }
}
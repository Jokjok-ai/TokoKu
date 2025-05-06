<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;
use App\Models\StockIn;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel terlebih dahulu
        DB::table('stock_in')->truncate();

        // Ambil semua item dan user yang ada
        $items = Item::all();
        $users = User::all();

        // Pastikan ada minimal 1 item dan 1 user
        if ($items->isEmpty() || $users->isEmpty()) {
            $this->command->error('Tidak bisa membuat stock_in: Item atau User kosong!');
            return;
        }

        // Data acak untuk stock_in
        $stockIns = [];
        $startDate = Carbon::now()->subMonths(3); // Rentang 3 bulan terakhir

        for ($i = 0; $i < 5; $i++) {
            $randomItem = $items->random();
            $randomUser = $users->random();
            $randomQuantity = rand(1, 100);
            $randomDate = $startDate->copy()->addDays(rand(0, 90)); // Acak tanggal dalam 3 bulan

            $stockIns[] = [
                'item_id' => $randomItem->id,
                'user_id' => $randomUser->id,
                'quantity' => $randomQuantity,
                'date' => $randomDate,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Update stok item
            $randomItem->stock += $randomQuantity;
            $randomItem->save();
        }

        // Insert data ke database
        StockIn::insert($stockIns);

        $this->command->info('Berhasil menambahkan 5 data stock_in acak!');
    }
}
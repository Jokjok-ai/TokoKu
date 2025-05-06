<?php

namespace Database\Seeders;

use App\Models\User;  // Tambahkan models user
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;  // Tambahkan hash
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
   

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Toko',
            'email' => 'admin1@tokoku.com',
            'username' => 'admin1', // Hanya sekali deklarasi
            'password' => Hash::make('password123'),
            'email_verified_at' => now(), // Lebih baik diisi timestamp jika ingin verifikasi otomatis
            'remember_token' => Str::random(10),
            'phone' => '081234567890',
            // created_at dan updated_at tidak perlu diisi, akan otomatis terisi
        ]);
    }
}

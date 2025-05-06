<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_out', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('harga_jual_per_satuan', 12, 2); // Harga jual per satuan_harga
            $table->integer('jumlah');                        // Jumlah yang dijual
            $table->string('satuan_jumlah');                 // Satuan transaksi (contoh: biji, batang)
            $table->text('keterangan')->nullable();          // Keterangan penjualan
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_out');
    }
};

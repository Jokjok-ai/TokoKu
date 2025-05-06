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
        Schema::create('stock_in', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('harga_per_satuan', 12, 2); // Harga beli per satuan_jumlah
            $table->integer('jumlah');                   // Jumlah yang dibeli
            $table->string('satuan_jumlah');            // Satuan transaksi (contoh: lusin, dus)
            $table->text('keterangan')->nullable();     // Keterangan tambahan
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in');
    }
};

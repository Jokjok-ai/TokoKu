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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('category_id')->constrained();
            $table->decimal('harga', 12, 2);      // Harga per satuan_harga
            $table->string('satuan_harga');       // Satuan untuk harga (contoh: biji, liter)
            $table->integer('stok');              // Jumlah stok
            $table->string('satuan_stok');        // Satuan untuk stok fisik (contoh: lusin, dus)
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

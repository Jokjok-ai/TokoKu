<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $table = 'stock_out';

    protected $fillable = [
        'item_id',
        'harga_jual_per_satuan',
        'jumlah',
        'satuan_jumlah',
        'keterangan',
        'tanggal',
        'user_id'
    ];

    protected $dates = ['tanggal'];
    
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // StockOut.php
public function scopeLast30Days($query)
{
    return $query->where('tanggal', '>=', now()->subDays(30));
}
}
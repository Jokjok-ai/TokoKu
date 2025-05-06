<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_in';

    protected $fillable = [
        'item_id',
        'harga_per_satuan',
        'jumlah',
        'satuan_jumlah',
        'keterangan',
        'tanggal',
        'user_id'
    ];

    protected $dates = ['tanggal'];
    // app\Models\StockIn.php
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
    // StockIn.php
public function scopeLast30Days($query)
{
    return $query->where('tanggal', '>=', now()->subDays(30));
}

}
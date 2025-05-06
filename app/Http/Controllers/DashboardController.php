<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk 12 bulan terakhir
        $months = collect(range(0, 11))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        })->reverse();

        // Data stok masuk/keluar
        $stockData = $months->map(function ($month) {
            $stockIn = StockIn::whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('jumlah');
            $stockOut = StockOut::whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('jumlah');
            
            return [
                'month' => $month->format('M Y'),
                'stock_in' => $stockIn,
                'stock_out' => $stockOut,
                'net_stock' => $stockIn - $stockOut,
                'percentage_change' => $this->calculatePercentageChange($month)
            ];
        });

        // Data untuk pie chart kategori
        $categoriesData = Category::withCount('items')
            ->orderByDesc('items_count')
            ->limit(5)
            ->get();

        // Hitung persentase kategori
        $totalItems = Item::count();
        $categoriesData->each(function ($category) use ($totalItems) {
            $category->percentage = $totalItems > 0 
                ? round(($category->items_count / $totalItems) * 100, 2)
                : 0;
        });

        // Data item dengan stok rendah
        $lowStockItems = Item::where('stok', '<', 10)
            ->orderBy('stok')
            ->limit(5)
            ->get()
            ->each(function ($item) {
                $item->percentage = ($item->stok / 10) * 100; // Persentase dari ambang batas 10
            });

        // Top 5 item paling aktif
        $activeItems = Item::withSum('stockIns as total_in', 'jumlah')
            ->withSum('stockOuts as total_out', 'jumlah')
            ->orderByDesc(DB::raw('total_in + total_out'))
            ->limit(5)
            ->get()
            ->each(function ($item) {
                $item->total_activity = $item->total_in + $item->total_out;
            });

        // Hitung total stok global
        $totalStockIn = StockIn::sum('jumlah');
        $totalStockOut = StockOut::sum('jumlah');
        $currentStock = Item::sum('stok');
        $totalTransactions = $totalStockIn + $totalStockOut;

        // Statistik
        $stats = [
            'total_items' => Item::count(),
            'stockin_30' => StockIn::last30Days()->sum('jumlah'),
            'stockout_30' => StockOut::last30Days()->sum('jumlah'),
            'low_stock' => Item::where('stok', '<', 10)->count(),
            'total_categories' => Category::count(),
            'total_stock_in' => $totalStockIn,
            'total_stock_out' => $totalStockOut,
            'current_stock' => $currentStock,
            'stock_in_percentage' => $totalTransactions > 0 ? round(($totalStockIn / $totalTransactions) * 100, 2) : 0,
            'stock_out_percentage' => $totalTransactions > 0 ? round(($totalStockOut / $totalTransactions) * 100, 2) : 0,
            'avg_daily_stockin' => StockIn::count() > 0 
                ? round($totalStockIn / StockIn::distinct('tanggal')->count(), 2)
                : 0,
            'avg_daily_stockout' => StockOut::count() > 0
                ? round($totalStockOut / StockOut::distinct('tanggal')->count(), 2)
                : 0,
        ];

        return view('dashboard.index', compact(
            'stockData',
            'stats',
            'categoriesData',
            'lowStockItems',
            'activeItems'
        ));
    }

    private function calculatePercentageChange($month)
    {
        $prevMonth = $month->copy()->subMonth();
        
        $currentIn = StockIn::whereMonth('tanggal', $month->month)
            ->whereYear('tanggal', $month->year)
            ->sum('jumlah');
        $prevIn = StockIn::whereMonth('tanggal', $prevMonth->month)
            ->whereYear('tanggal', $prevMonth->year)
            ->sum('jumlah');
        
        $currentOut = StockOut::whereMonth('tanggal', $month->month)
            ->whereYear('tanggal', $month->year)
            ->sum('jumlah');
        $prevOut = StockOut::whereMonth('tanggal', $prevMonth->month)
            ->whereYear('tanggal', $prevMonth->year)
            ->sum('jumlah');
        
        return [
            'in' => $prevIn > 0 ? round((($currentIn - $prevIn) / $prevIn) * 100, 2) : 0,
            'out' => $prevOut > 0 ? round((($currentOut - $prevOut) / $prevOut) * 100, 2) : 0
        ];
    }
}
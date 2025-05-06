@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Statistik -->
    <div class="row mb-4">
        <!-- Statistik Utama -->
        <div class="col-md-3 mb-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-primary mb-1">
                                Total Stok Masuk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_stock_in']) }}
                            </div>
                            <div class="mt-2 text-xs">
                                <span class="{{ $stats['stock_in_percentage'] > 50 ? 'text-success' : 'text-warning' }} font-weight-bold">
                                    {{ $stats['stock_in_percentage'] }}% dari total transaksi
                                </span>
                            </div>
                        </div>
                        <i class="fas fa-boxes fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-success mb-1">
                                Total Stok Keluar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_stock_out']) }}
                            </div>
                            <div class="mt-2 text-xs">
                                <span class="{{ $stats['stock_out_percentage'] > 50 ? 'text-success' : 'text-warning' }} font-weight-bold">
                                    {{ $stats['stock_out_percentage'] }}% dari total transaksi
                                </span>
                            </div>
                        </div>
                        <i class="fas fa-truck-moving fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-info mb-1">
                                Stok Saat Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['current_stock']) }}
                            </div>
                            <div class="mt-2 text-xs">
                                <span class="text-info font-weight-bold">
                                    {{ $stats['low_stock'] }} item stok rendah
                                </span>
                            </div>
                        </div>
                        <i class="fas fa-warehouse fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-warning mb-1">
                                Rata2 Harian
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $stats['avg_daily_stockin'] }} / {{ $stats['avg_daily_stockout'] }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-xs">
                                        Masuk/Keluar
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 text-xs">
                                <span class="text-warning font-weight-bold">
                                    {{ $stats['total_items'] }} item, {{ $stats['total_categories'] }} kategori
                                </span>
                            </div>
                        </div>
                        <i class="fas fa-chart-line fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris Pertama: Line Chart dan Pie Chart -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Tren Stok 12 Bulan Terakhir</h5>
                    <div class="text-xs text-muted">
                        <span class="badge badge-primary">Biru = Stok Masuk</span>
                        <span class="badge badge-danger ml-2">Merah = Stok Keluar</span>
                        <span class="badge badge-success ml-2">Hijau = Stok Bersih</span>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="lineChart" height="120"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Distribusi Kategori (Top 5)</h5>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" height="200"></canvas>
                    <div class="mt-3">
                        @foreach($categoriesData as $category)
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <span>{{ $category->name }}</span>
                                <span>{{ $category->percentage }}% ({{ $category->items_count }} item)</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $category->percentage }}%" 
                                     aria-valuenow="{{ $category->percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris Kedua: Bar Chart dan Daftar Stok -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Top 5 Item Paling Aktif</h5>
                </div>
                <div class="card-body">
                    <canvas id="barChart" height="150"></canvas>
                    <div class="mt-3">
                        @foreach($activeItems as $item)
                        <div class="mb-2">
                            <div class="d-flex justify-content-between">
                                <span>{{ $item->nama }}</span>
                                <span class="font-weight-bold">{{ $item->total_activity }} transaksi</span>
                            </div>
                            <div class="d-flex justify-content-between text-xs">
                                <span class="text-primary">+{{ $item->total_in }} masuk</span>
                                <span class="text-danger">-{{ $item->total_out }} keluar</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Item Stok Rendah</h5>
                    <span class="badge badge-danger">{{ $stats['low_stock'] }} item</span>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($lowStockItems as $item)
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $item->nama }}</h6>
                                <div>
                                    <small class="text-danger font-weight-bold">{{ $item->stok }} {{ $item->satuan_stok }}</small>
                                    <div class="progress" style="width: 60px; height: 5px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $item->percentage }}%" 
                                             aria-valuenow="{{ $item->percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">{{ $item->category->name ?? 'Tidak ada kategori' }}</small>
                                <small class="text-danger">{{ $item->percentage }}% dari ambang batas</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Line Chart
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($stockData->pluck('month')) !!},
        datasets: [{
            label: 'Stok Masuk',
            data: {!! json_encode($stockData->pluck('stock_in')) !!},
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            fill: true,
            tension: 0.3
        }, {
            label: 'Stok Keluar',
            data: {!! json_encode($stockData->pluck('stock_out')) !!},
            borderColor: '#e74a3b',
            backgroundColor: 'rgba(231, 74, 59, 0.05)',
            fill: true,
            tension: 0.3
        }, {
            label: 'Stok Bersih',
            data: {!! json_encode($stockData->pluck('net_stock')) !!},
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.05)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    afterLabel: function(context) {
                        const data = {!! json_encode($stockData) !!}[context.dataIndex];
                        return [
                            `Perubahan dari bulan sebelumnya:`,
                            `Stok Masuk: ${(data.percentage_change['in'] > 0 ? '+' : '') + data.percentage_change['in']}%`,
                            `Stok Keluar: ${(data.percentage_change['out'] > 0 ? '+' : '') + data.percentage_change['out']}%`
                        ].join('\n');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Pie Chart
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($categoriesData->map(function($cat) { 
            return $cat->name . ' (' . $cat->percentage . '%)'; 
        })) !!},
        datasets: [{
            data: {!! json_encode($categoriesData->pluck('items_count')) !!},
            backgroundColor: [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = Math.round((value / total) * 100);
                        return `${label}: ${value} item (${percentage}%)`;
                    }
                }
            }
        }
    }
});

// Bar Chart
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($activeItems->pluck('nama')) !!},
        datasets: [{
            label: 'Stok Masuk',
            data: {!! json_encode($activeItems->pluck('total_in')) !!},
            backgroundColor: '#4e73df',
            borderColor: '#2e59d9',
            borderWidth: 1
        }, {
            label: 'Stok Keluar',
            data: {!! json_encode($activeItems->pluck('total_out')) !!},
            backgroundColor: '#e74a3b',
            borderColor: '#be2617',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        indexAxis: 'y',
        plugins: {
            tooltip: {
                callbacks: {
                    afterLabel: function(context) {
                        const item = {!! json_encode($activeItems) !!}[context.dataIndex];
                        const totalTransactions = {!! $stats['total_stock_in'] + $stats['total_stock_out'] !!};
                        const percentage = totalTransactions > 0 
                            ? Math.round((item.total_activity / totalTransactions) * 100)
                            : 0;
                        return `Total: ${item.total_activity} (${percentage}% dari semua transaksi)`;
                    }
                }
            }
        },
        scales: {
            x: {
                stacked: true,
                title: {
                    display: true,
                    text: 'Jumlah Transaksi'
                }
            },
            y: {
                stacked: true
            }
        }
    }
});
</script>
@endpush

<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }
    public function profit_pdf()
{
    $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
    $endDate = Carbon::now()->format('Y-m-d');
    
    $data = [
        'startDate' => $startDate,
        'endDate' => $endDate,
        'items' => Item::with(['category', 'stockOuts' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('tanggal', [$startDate, $endDate]);
        }])
        ->whereHas('stockOuts', function($q) use ($startDate, $endDate) {
            $q->whereBetween('tanggal', [$startDate, $endDate]);
        })
        ->get()
    ];

    return view('reports.exports.profit_pdf', $data);

}

    // Laporan Stok Barang
    public function stockReport()
    {
        $items = Item::with('category')
            ->orderBy('stok', 'desc')
            ->get();
            
        $categories = Category::all();
        
        return view('reports.stock', compact('items', 'categories'));
    }

    // Laporan Transaksi Masuk/Keluar
    public function transactionReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $stockIns = StockIn::with(['item', 'user'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
            
        $stockOuts = StockOut::with(['item', 'user'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('reports.transaction', compact('stockIns', 'stockOuts', 'startDate', 'endDate'));
    }

    // Laporan Profit/Laba
    public function profitReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $items = Item::with(['stockIns', 'stockOuts' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('tanggal', [$startDate, $endDate]);
        }])->get();
        
        return view('reports.profit', compact('items', 'startDate', 'endDate'));
    }

    // Laporan Kategori Barang
    public function categoryReport()
    {
        $categories = Category::with(['items' => function($query) {
            $query->orderBy('stok', 'desc');
        }])->get();
        
        return view('reports.category', compact('categories'));
    }

    #EXPORT
    public function exportProfitReport(Request $request, $type)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'items' => Item::with(['category', 'stockOuts' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal', [$startDate, $endDate]);
            }])
            ->whereHas('stockOuts', function($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->get()
        ];

        $filename = 'Laporan_Profit_'.Carbon::parse($startDate)->format('d_m_Y').'_'.Carbon::parse($endDate)->format('d_m_Y');

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('reports.exports.profit_pdf', $data);
            return $pdf->download($filename.'.pdf');
        }

        if ($type === 'word') {
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();

            // Judul Laporan
            $section->addText(
                'LAPORAN PROFIT/LABA',
                ['bold' => true, 'size' => 16],
                ['alignment' => 'center']
            );

            // Periode Laporan
            $section->addText(
                'Periode: ' . Carbon::parse($startDate)->translatedFormat('d F Y') . ' - ' . 
                Carbon::parse($endDate)->translatedFormat('d F Y'),
                ['size' => 12],
                ['alignment' => 'center', 'spaceAfter' => 500]
            );

            // Buat Tabel
            $table = $section->addTable([
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellMargin' => 80
            ]);

            // Header Tabel
            $headers = ['No', 'Nama Barang', 'Kategori', 'Harga Beli', 'Terjual', 'Total Penjualan', 'Total Pembelian', 'Laba'];
            $table->addRow();
            foreach ($headers as $header) {
                $table->addCell(2000)->addText($header, ['bold' => true]);
            }

            // Isi Tabel
            foreach ($data['items'] as $key => $item) {
                $sold = $item->stockOuts->sum('jumlah');
                $totalSale = $item->stockOuts->sum(function($trx) {
                    return $trx->harga_jual_per_satuan * $trx->jumlah;
                });
                $totalPurchase = $item->harga * $sold;
                $profit = $totalSale - $totalPurchase;

                $table->addRow();
                $table->addCell()->addText($key + 1, null, ['alignment' => 'center']);
                $table->addCell()->addText($item->nama);
                $table->addCell()->addText($item->category->name ?? '-');
                $table->addCell()->addText('Rp ' . number_format($item->harga, 0, ',', '.'), null, ['alignment' => 'right']);
                $table->addCell()->addText($sold, null, ['alignment' => 'center']);
                $table->addCell()->addText('Rp ' . number_format($totalSale, 0, ',', '.'), null, ['alignment' => 'right']);
                $table->addCell()->addText('Rp ' . number_format($totalPurchase, 0, ',', '.'), null, ['alignment' => 'right']);
                
                // PERBAIKAN: Warna laba (hijau jika profit, merah jika rugi)
                $textRun = $table->addCell()->addTextRun(['alignment' => 'right']);
                if ($profit >= 0) {
                    $textRun->addText('Rp ' . number_format($profit, 0, ',', '.'), ['color' => '2d862d']);
                } else {
                    $textRun->addText('Rp ' . number_format($profit, 0, ',', '.'), ['color' => 'cc0000']);
                }
            }

            // Footer (Tanggal Cetak)
            $section->addTextBreak(2);
            $section->addText(
                'Dicetak pada: ' . Carbon::now()->translatedFormat('d F Y H:i'),
                ['italic' => true],
                ['alignment' => 'right']
            );

            // Simpan ke File Sementara
            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($tempFile);

            // Download dan Hapus File Sementara
            return response()->download($tempFile, $filename . '.docx')->deleteFileAfterSend(true);
        }
    }
}
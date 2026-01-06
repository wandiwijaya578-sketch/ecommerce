<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\SalesReportExport;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Halaman laporan penjualan (Browser)
     */
    public function sales(Request $request)
    {
        // 1. Default tanggal
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to   ?? now()->toDateString();

        // ✅ Gunakan status yang ada di DB, contoh: 'completed'
        $validStatuses = ['completed'];

        // 2. Data tabel transaksi
        $orders = Order::with(['items', 'user'])
            ->whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo   . ' 23:59:59',
            ])
            ->whereIn('status', $validStatuses)
            ->latest()
            ->paginate(20);

        // 3. Summary (total order & omset)
        $summary = Order::whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo   . ' 23:59:59',
            ])
            ->whereIn('status', $validStatuses)
            ->selectRaw('COUNT(*) as total_orders, COALESCE(SUM(total_amount),0) as total_revenue')
            ->first();

        // 4. Analitik penjualan per kategori
        $byCategory = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereBetween('orders.created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo   . ' 23:59:59',
            ])
            ->whereIn('orders.status', $validStatuses)
            ->groupBy('categories.id', 'categories.name')
            ->select(
                'categories.name',
                DB::raw('SUM(order_items.subtotal) as total')
            )
            ->orderByDesc('total')
            ->get();

        return view(
            'admin.reports.sales',
            compact('orders', 'summary', 'byCategory', 'dateFrom', 'dateTo')
        );
    }

    /**
     * Download Excel laporan penjualan
     */
    public function exportSales(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to   ?? now()->toDateString();

        // Gunakan status yang sama dengan sales() agar data konsisten
        return Excel::download(
            new SalesReportExport($dateFrom, $dateTo),
            "laporan-penjualan-{$dateFrom}-sd-{$dateTo}.xlsx"
        );
    }
}

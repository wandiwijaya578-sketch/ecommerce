<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Exports\SalesReportExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Halaman laporan penjualan
     */
    public function sales(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to ?? now()->toDateString();

        // =========================
        // DATA TABEL (PAGINATION)
        // =========================
        $orders = Order::with(['items', 'user'])
            ->whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59',
            ])
            ->where('status', 'paid') // ✅ FIX
            ->latest()
            ->paginate(20);

        // =========================
        // SUMMARY
        // =========================
        $summary = Order::whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59',
            ])
            ->where('status', 'paid') // ✅ FIX
            ->selectRaw('COUNT(*) as total_orders, COALESCE(SUM(total_amount),0) as total_revenue')
            ->first();

        // =========================
        // ANALITIK PER KATEGORI
        // =========================
        $byCategory = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereBetween('orders.created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59',
            ])
            ->where('orders.status', 'paid') // ✅ FIX
            ->groupBy('categories.name')
            ->select(
                'categories.name',
                DB::raw('SUM(order_items.subtotal) as total')
            )
            ->orderByDesc('total')
            ->get();

        return view('admin.reports.sales', compact(
            'orders',
            'summary',
            'byCategory',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * EXPORT EXCEL
     */
    public function exportSales(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to ?? now()->toDateString();

        return Excel::download(
            new SalesReportExport($dateFrom, $dateTo),
            "laporan-penjualan-{$dateFrom}-sd-{$dateTo}.xlsx"
        );
    }
}

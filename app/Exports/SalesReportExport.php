<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    protected string $dateFrom;
    protected string $dateTo;

    public function __construct(string $dateFrom, string $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
    }

    /**
     * QUERY DATA (INI YANG DIPERBAIKI)
     */
    public function query()
    {
        return Order::query()
            ->with(['user', 'items'])
            ->whereBetween('created_at', [
                $this->dateFrom . ' 00:00:00',
                $this->dateTo   . ' 23:59:59',
            ])
            ->whereIn('status', ['paid', 'completed'])
            ->orderBy('created_at', 'asc');
    }

    /**
     * HEADER EXCEL
     */
    public function headings(): array
    {
        return [
            'No. Order',
            'Tanggal Transaksi',
            'Nama Customer',
            'Email',
            'Jumlah Item',
            'Total Belanja (Rp)',
            'Status',
        ];
    }

    /**
     * MAPPING DATA
     */
    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('d/m/Y H:i'),
            optional($order->user)->name,
            optional($order->user)->email,
            $order->items->sum('quantity'),
            $order->total_amount,
            ucfirst($order->status),
        ];
    }

    /**
     * STYLE EXCEL
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

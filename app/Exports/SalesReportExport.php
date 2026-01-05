<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected string $dateFrom;
    protected string $dateTo;

    public function __construct(string $dateFrom, string $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
    }

    public function query()
    {
        return Order::query()
            ->with(['user', 'items'])
            ->whereBetween('created_at', [
                $this->dateFrom . ' 00:00:00',
                $this->dateTo . ' 23:59:59',
            ])
            ->where('payment_status', 'paid')
            ->orderBy('created_at');
    }

    public function headings(): array
    {
        return [
            'No Order',
            'Tanggal',
            'Customer',
            'Email',
            'Jumlah Item',
            'Total (Rp)',
            'Status',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('d/m/Y H:i'),
            $order->user->name ?? '-',
            $order->user->email ?? '-',
            $order->items->sum('quantity'),
            $order->total_amount,
            ucfirst($order->payment_status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

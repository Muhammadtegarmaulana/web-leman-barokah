<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        // Default: Ambil data bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Ambil pesanan yang sudah SELESAI (Completed) atau SUDAH BAYAR (Paid)
        // Tergantung kebijakanmu, biasanya omset dihitung dari yang sudah 'paid'
        $orders = Order::where('payment_status', 'paid')
                        ->whereDate('created_at', '>=', $startDate)
                        ->whereDate('created_at', '<=', $endDate)
                        ->latest()
                        ->get();

        // Hitung Total Pendapatan
        $totalRevenue = $orders->sum('total_price');

        return view('admin.reports.index', compact('orders', 'totalRevenue', 'startDate', 'endDate'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $query = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);

        // Hitung total revenue dari seluruh hasil filter (sebelum dipaginate)
        $totalRevenue = $query->sum('total_price');

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.reports.index', compact('orders', 'totalRevenue', 'startDate', 'endDate'));
    }
}
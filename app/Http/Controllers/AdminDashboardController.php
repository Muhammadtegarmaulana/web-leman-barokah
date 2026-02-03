<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Pendapatan Hari Ini
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
                             ->where('payment_status', 'paid')
                             ->sum('total_price');

        // 2. Jumlah Pesanan Hari Ini
        $todayOrdersCount = Order::whereDate('created_at', Carbon::today())->count();

        // 3. Pesanan yang "Perlu Diproses" (Pending / Processing)
        $activeOrders = Order::whereIn('order_status', ['pending', 'processing'])->count();

        // 4. Total Menu
        $totalMenus = Menu::count();

        // 5. 5 Pesanan Terbaru
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'todayRevenue', 
            'todayOrdersCount', 
            'activeOrders', 
            'totalMenus',
            'latestOrders'
        ));
    }
}
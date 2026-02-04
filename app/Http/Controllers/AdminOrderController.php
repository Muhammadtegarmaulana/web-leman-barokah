<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminOrderController extends Controller
{
    // 1. LIHAT DAFTAR PESANAN
    public function index(Request $request)
    {
        $query = Order::with('user')->where('order_status', '!=', 'completed');

        // Search by Name or ID
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('user', function($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%');
                })->orWhere('id', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by Status
        if ($request->status && $request->status != 'semua') {
            $query->where('order_status', $request->status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    // 2. LIHAT DETAIL PESANAN
    public function show($id)
    {
        $order = Order::with('orderItems.menu', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. LOGIKA VALIDASI PEMBAYARAN (GENERATE ANTRIAN)
    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);

        // Cek jika sudah lunas, jangan generate lagi
        if ($order->payment_status == 'paid') {
            return redirect()->back()->with('error', 'Pesanan ini sudah lunas!');
        }

        // --- LOGIKA NOMOR ANTRIAN ---
        // Hitung jumlah antrian HARI INI yang sudah punya nomor
        $todayOrders = Order::whereDate('created_at', Carbon::today())
                            ->whereNotNull('queue_number')
                            ->count();
        
        // Nomor antrian berikutnya = Jumlah + 1
        // Kita format jadi "A-001", "A-002", dst.
        $nextQueueNumber = 'A-' . str_pad($todayOrders + 1, 3, '0', STR_PAD_LEFT);

        // Update Database
        $order->update([
            'payment_status' => 'paid',
            'queue_number' => $nextQueueNumber,
            'order_status' => 'processing', // Langsung masuk dapur
        ]);

        return redirect()->back()->with('success', "Pembayaran Dikonfirmasi! No. Antrian: $nextQueueNumber");
    }

    // 4. UPDATE STATUS PESANAN (DAPUR)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $order->update([
            'order_status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui!');
    }
    
    // 5. SELESAIKAN PESANAN (ARSIP)
    public function completeOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['order_status' => 'completed']);
        
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan selesai dan masuk riwayat.');
    }
}
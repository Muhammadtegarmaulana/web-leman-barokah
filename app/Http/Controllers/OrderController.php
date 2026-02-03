<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. DASHBOARD: Katalog Menu
    public function index()
    {
        $menus = Menu::where('is_available', true)->get();
        return view('customer.dashboard', compact('menus'));
    }

    // 2. KERANJANG: Tambah Item
    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
                "image" => $menu->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Berhasil masuk keranjang! 🛒');
    }

    // 3. KERANJANG: Halaman List
    public function cart()
    {
        return view('customer.cart');
    }

    // 4. KERANJANG: Hapus Item
    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Item dihapus dari keranjang.');
        }
    }

    // 5. CHECKOUT: Halaman Form
    public function checkout()
    {
        $cart = session()->get('cart');
        if(!$cart || count($cart) == 0) {
            return redirect()->route('customer.dashboard')->with('error', 'Keranjangmu kosong, pesan dulu yuk!');
        }
        return view('customer.checkout');
    }

    // 6. PROSES ORDER: Simpan ke Database
    public function storeOrder(Request $request)
    {
        $request->validate([
            'order_type' => 'required',
            'payment_method' => 'required',
            'payment_proof' => 'required_if:payment_method,transfer|image|max:2048',
            'table_number' => 'required_if:order_type,dine_in',
        ]);

        DB::transaction(function () use ($request) {
            $cart = session()->get('cart');
            $total = 0;
            foreach($cart as $details) {
                $total += $details['price'] * $details['quantity'];
            }

            // Upload Bukti TF
            $proofPath = null;
            if ($request->hasFile('payment_proof')) {
                $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
            }

            // Buat Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_type' => $request->order_type,
                'table_number' => $request->table_number,
                'payment_method' => $request->payment_method,
                'payment_proof' => $proofPath,
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'total_price' => $total,
            ]);

            // Buat Detail Item
            foreach($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            // Kosongkan Keranjang
            session()->forget('cart');
        });

        return redirect()->route('customer.orders.index')->with('success', 'Pesanan berhasil dibuat! Mohon tunggu konfirmasi Admin.');
    }

    // 7. RIWAYAT: List Pesanan
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('customer.orders.index', compact('orders'));
    }

    // TAMBAHAN: UPDATE QUANTITY (AJAX)
    public function updateCart(Request $request)
    {
        if($request->id && $request->action) {
            $cart = session()->get('cart');
            
            if(isset($cart[$request->id])) {
                
                // Jika tombol tambah ditekan
                if($request->action == 'plus') {
                    $cart[$request->id]['quantity']++;
                } 
                // Jika tombol kurang ditekan
                elseif ($request->action == 'minus') {
                    $cart[$request->id]['quantity']--;
                }

                // Cek apakah quantity jadi 0 atau kurang? Jika ya, hapus item
                if($cart[$request->id]['quantity'] < 1) {
                    unset($cart[$request->id]);
                    session()->put('cart', $cart);
                    session()->flash('success', 'Item dihapus dari keranjang.');
                } else {
                    // Jika tidak 0, simpan update quantity
                    session()->put('cart', $cart);
                }
            }
        }
    }
}
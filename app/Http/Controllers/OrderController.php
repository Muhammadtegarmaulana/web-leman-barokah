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
    public function index(Request $request)
    {
        $query = Menu::where('is_available', true);

        // Filter Pencarian Nama
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter Kategori
        if ($request->has('category') && $request->category != 'semua') {
            $query->where('category', $request->category);
        }

        $menus = $query->get();
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
        // 1. Validasi (Hapus dd($request->all()) jika masih ada!)
        $request->validate([
            'order_type' => 'required',
            'payment_method' => 'required',
            'payment_proof' => 'required_if:payment_method,transfer|image|max:2048',
            'table_number' => 'required_if:order_type,dine_in',
        ]);

        return DB::transaction(function () use ($request) {
            $cart = session()->get('cart');
            $total = 0;
            foreach($cart as $details) {
                $total += $details['price'] * $details['quantity'];
            }

            // 2. Inisialisasi Model secara Manual (Tanpa Order::create)
            $order = new Order();
            $order->user_id = Auth::id();
            $order->order_type = $request->order_type;
            $order->table_number = $request->table_number;
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'unpaid';
            $order->order_status = 'pending';
            $order->total_price = $total;

            // 3. PROSES UPLOAD (Kita simpan path-nya langsung ke object $order)
            if ($request->hasFile('payment_proof')) {
                // Gunakan storeAs agar kita tahu nama filenya
                $file = $request->file('payment_proof');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('payment-proofs', $fileName, 'public');
                
                // ISI LANGSUNG KE PROPERTI
                $order->payment_proof = $path;
            }

            // 4. PAKSA SIMPAN
            $order->save();

            // 5. Buat Detail Item
            foreach($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            session()->forget('cart');

            return redirect()->route('customer.orders.index')->with('success', 'Pesanan berhasil dibuat!');
        });
    }

    // 7. RIWAYAT: List Pesanan
    public function history(Request $request)
    {
        $sort = $request->input('sort', 'terbaru'); // Default terbaru
        $query = Order::where('user_id', Auth::id());

        if ($sort == 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        // Pagination maksimal 10 data
        $orders = $query->paginate(10)->withQueryString();
        
        return view('customer.orders.index', compact('orders', 'sort'));
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

    public function activeOrders()
    {
        // Mengambil pesanan milik user yang login yang statusnya belum 'completed'
        $orders = Order::where('user_id', Auth::id())
            ->where('order_status', '!=', 'completed')
            ->with('items.menu') // Eager loading untuk mengambil detail menu
            ->latest()
            ->get();

        return view('customer.orders.active', compact('orders'));
    }
}
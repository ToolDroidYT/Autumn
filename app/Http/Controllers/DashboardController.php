<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with('items.product', 'payments')->latest()->take(5)->get();

        return view('dashboard', [
            'orders' => $orders,
            'stats' => [
                'Orders' => $user->orders()->count(),
                'Pending Payments' => $user->orders()->where('payment_status', 'unpaid')->count(),
                'Receipts' => $user->orders()->has('receipt')->count(),
            ],
        ]);
    }

    public function orders()
    {
        return view('orders.index', [
            'orders' => Auth::user()->orders()->with('items.product', 'receipt')->latest()->paginate(10),
        ]);
    }

    public function order(Order $order)
    {
        abort_unless($order->user_id === Auth::id() || Auth::user()->isAdmin(), 403);
        $order->load('items.product.images', 'payments', 'receipt');

        return view('orders.show', compact('order'));
    }

    public function receipt(Order $order)
    {
        abort_unless($order->user_id === Auth::id() || Auth::user()->isAdmin(), 403);
        $order->load('items.product', 'user', 'receipt');
        abort_unless($order->receipt, 404);

        return view('receipts.show', compact('order'));
    }
}

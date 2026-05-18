<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index', ['cart' => $this->cartLines()]);
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'size' => ['nullable', 'string', 'max:20'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $batch = $product->batches()->where('status', 'open')->first();
        if (! $batch) {
            return back()->withErrors(['quantity' => 'No open batch is available for this product.']);
        }

        $key = $product->id.':'.($data['size'] ?? 'One Size');
        $cart = session('cart', []);
        $cart[$key] = [
            'product_id' => $product->id,
            'batch_id' => $batch->id,
            'size' => $data['size'] ?? 'One Size',
            'quantity' => ($cart[$key]['quantity'] ?? 0) + $data['quantity'],
        ];
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('toast', 'Added to cart.');
    }

    public function update(Request $request, string $key)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:10']]);
        $cart = session('cart', []);
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $data['quantity'];
            session(['cart' => $cart]);
        }

        return back()->with('toast', 'Cart updated.');
    }

    public function remove(string $key)
    {
        $cart = session('cart', []);
        unset($cart[$key]);
        session(['cart' => $cart]);

        return back()->with('toast', 'Item removed.');
    }

    public function checkout()
    {
        $cart = $this->cartLines();
        if ($cart['items']->isEmpty()) {
            return redirect()->route('products.index')->with('toast', 'Cart is empty.');
        }

        return view('checkout.index', ['cart' => $cart]);
    }

    public function place(Request $request)
    {
        $request->validate(['notes' => ['nullable', 'string', 'max:1000']]);
        $cart = $this->cartLines();

        if ($cart['items']->isEmpty()) {
            return redirect()->route('products.index');
        }

        $order = DB::transaction(function () use ($cart, $request) {
            $total = $cart['total'];
            $order = Order::query()->create([
                'user_id' => Auth::id(),
                'order_code' => 'AUT-'.now()->format('Ymd').'-'.strtoupper(Str::random(6)),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total_amount' => $total,
                'downpayment_amount' => round($total * 0.5, 2),
                'balance_amount' => round($total * 0.5, 2),
                'notes' => $request->notes,
            ]);

            foreach ($cart['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'batch_id' => $item['batch']->id,
                    'size' => $item['size'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'line_total' => $item['line_total'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('toast', 'Order placed. Upload your payment proof to lock the order.');
    }

    private function cartLines(): array
    {
        $raw = session('cart', []);
        $items = collect($raw)->map(function ($line, $key) {
            $product = Product::query()->with('images')->find($line['product_id']);
            $batch = Batch::query()->find($line['batch_id']);
            if (! $product || ! $batch) {
                return null;
            }
            $price = (float) ($batch->price_override ?? $product->price);
            $quantity = (int) $line['quantity'];

            return [
                'key' => $key,
                'product' => $product,
                'batch' => $batch,
                'size' => $line['size'],
                'quantity' => $quantity,
                'price' => $price,
                'line_total' => $price * $quantity,
            ];
        })->filter()->values();

        return ['items' => $items, 'total' => $items->sum('line_total')];
    }
}

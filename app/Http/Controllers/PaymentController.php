<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function upload(Request $request, Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'method' => ['required', 'string', 'max:40'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'proof' => ['nullable', 'image', 'max:5120'],
        ]);

        $path = $request->file('proof')?->store('payment-proofs', 'public');

        $order->payments()->create([
            'user_id' => Auth::id(),
            'amount' => $data['amount'],
            'method' => $data['method'],
            'reference_number' => $data['reference_number'] ?? null,
            'proof_path' => $path,
            'status' => 'pending_verification',
        ]);

        $order->update(['payment_status' => 'pending_verification']);

        return back()->with('toast', 'Payment proof submitted for verification.');
    }
}

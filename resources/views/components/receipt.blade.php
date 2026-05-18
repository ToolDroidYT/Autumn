@props(['order'])
<div class="receipt">
    <div style="display:flex;justify-content:space-between;gap:24px;align-items:start;border-bottom:1px solid #ddd;padding-bottom:18px;margin-bottom:20px;">
        <div><h1 style="margin:0;font-family:Arial Black, sans-serif;letter-spacing:.08em;">AUTUMN RECEIPT</h1><p>Automated Unified Merchandise Network</p></div>
        <div style="text-align:right;"><strong>{{ $order->receipt->receipt_number }}</strong><br><span>{{ optional($order->receipt->issued_at)->format('M j, Y h:i A') }}</span></div>
    </div>
    <p><strong>Order:</strong> {{ $order->order_code }}<br><strong>Student:</strong> {{ $order->user->name }} · {{ $order->user->program }}<br><strong>Email:</strong> {{ $order->user->email }}</p>
    <table>
        <thead><tr><th>Item</th><th>Size</th><th>Qty</th><th>Total</th></tr></thead>
        <tbody>@foreach($order->items as $item)<tr><td>{{ $item->product->name }}</td><td>{{ $item->size }}</td><td>{{ $item->quantity }}</td><td>₱{{ number_format($item->line_total, 2) }}</td></tr>@endforeach</tbody>
    </table>
    <h2 style="text-align:right;">₱{{ number_format($order->total_amount, 2) }}</h2>
    <p style="font-size:13px;color:#555;">Verification hash: {{ $order->receipt->verification_hash }}</p>
</div>

<x-app-layout title="Cart">
    <section class="section"><div class="container"><div class="section-head"><x-badge>Cart</x-badge><h1 class="section-title">Order <span class="accent-red">Cart</span></h1></div>
    @if($cart['items']->isEmpty())<x-empty-state title="Cart is empty" message="Add merchandise from the catalog before checkout."><x-button href="{{ route('products.index') }}">Browse Products</x-button></x-empty-state>@else
    <x-table><table><thead><tr><th>Product</th><th>Batch</th><th>Size</th><th>Qty</th><th>Total</th><th></th></tr></thead><tbody>
    @foreach($cart['items'] as $item)<tr><td>{{ $item['product']->name }}</td><td>{{ $item['batch']->name }}</td><td>{{ $item['size'] }}</td><td><form method="POST" action="{{ route('cart.update', $item['key']) }}">@csrf @method('PATCH')<input class="input" style="width:90px;" name="quantity" type="number" min="1" max="10" value="{{ $item['quantity'] }}"><button class="btn btn-outline">Update</button></form></td><td>₱{{ number_format($item['line_total'], 2) }}</td><td><form method="POST" action="{{ route('cart.remove', $item['key']) }}" data-confirm="Remove this item?">@csrf @method('DELETE')<button class="btn btn-danger">Remove</button></form></td></tr>@endforeach
    </tbody></table></x-table><div style="display:flex;justify-content:space-between;align-items:center;margin-top:24px;"><h2>Total: ₱{{ number_format($cart['total'], 2) }}</h2><x-button href="{{ route('checkout.index') }}">Checkout</x-button></div>@endif
    </div></section>
</x-app-layout>

@props(['product'])
<article class="card product-card">
    <img src="{{ asset($product->primary_image) }}" alt="{{ $product->name }}">
    <div class="product-body">
        <div class="meta-row"><x-badge>{{ $product->program }}</x-badge><span class="price">₱{{ number_format($product->price, 2) }}</span></div>
        <h3 class="product-title">{{ $product->name }}</h3>
        <p>{{ Str::limit($product->description, 96) }}</p>
        <x-button href="{{ route('products.show', $product) }}" variant="outline">View Product</x-button>
    </div>
</article>

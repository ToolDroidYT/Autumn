@props(['product'])
<article class="card product-card">
    <img src="{{ asset($product->primary_image) }}" alt="{{ $product->name }}">
    <div class="product-body">
        <div class="meta-row">
            <span class="meta-label"><x-icon name="users" class="h-4 w-4" />{{ $product->program }}</span>
            <span class="price">₱{{ number_format($product->price, 2) }}</span>
        </div>
        <h3 class="product-title">{{ $product->name }}</h3>
        <p>{{ Str::limit($product->description, 96) }}</p>
        <x-button href="{{ route('products.show', $product) }}" variant="outline"><x-icon name="eye" class="h-4 w-4" />View Product</x-button>
    </div>
</article>

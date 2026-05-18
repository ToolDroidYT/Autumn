<x-app-layout :title="$product->name">
    <section class="section">
        <div class="container grid grid-2">
            <div class="card"><img src="{{ asset($product->primary_image) }}" alt="{{ $product->name }}" style="width:100%;height:520px;object-fit:cover;border-radius:18px;"></div>
            <div>
                <x-badge>{{ $product->program }}</x-badge>
                <h1 class="section-title" style="text-align:left;">{{ $product->name }}</h1>
                <p class="section-copy" style="margin-inline:0;">{{ $product->description }}</p>
                <p class="price" style="font-size:30px;">₱{{ number_format($product->price, 2) }}</p>
                @php($batch = $product->activeBatch())
                @if($batch)
                    <x-card>
                        <div class="meta-row"><strong>{{ $batch->name }}</strong><x-status-pill :status="$batch->status" /></div>
                        <p>Deadline: {{ optional($batch->deadline)->format('M j, Y') }} · Slots left: {{ $batch->remaining_slots }}</p>
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <x-select label="Size" name="size" :options="collect($product->sizes ?? ['One Size'])->mapWithKeys(fn($s)=>[$s=>$s])->all()" />
                            <x-input label="Quantity" name="quantity" type="number" value="1" min="1" max="10" />
                            <x-button type="submit">Add to Cart</x-button>
                        </form>
                    </x-card>
                @else
                    <x-empty-state title="No open batch" message="This item is visible but cannot be ordered until an admin opens a batch." />
                @endif
            </div>
        </div>
    </section>
</x-app-layout>

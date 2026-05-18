<x-app-layout title="Products">
    <section class="section">
        <div class="container">
            <div class="section-head"><x-badge>Catalog</x-badge><h1 class="section-title">Merchandise <span class="accent-red">Catalog</span></h1></div>
            <x-card style="margin-bottom:24px;">
                <form class="grid grid-3" method="GET">
                    <x-input label="Search" name="q" value="{{ request('q') }}" />
                    <x-select label="Program" name="program" :selected="request('program')" :options="[''=>'All programs','DCE'=>'DCE','IT'=>'IT','CS'=>'CS','CSIT/DCE'=>'CSIT/DCE','CODES'=>'CODES']" />
                    <div class="field"><label>&nbsp;</label><x-button type="submit">Filter</x-button></div>
                </form>
            </x-card>
            @if($products->count())
                <div class="grid grid-3">@foreach($products as $product)<x-product-card :product="$product" />@endforeach</div>
                {{ $products->links() }}
            @else
                <x-empty-state title="No matching products" message="Change filters or check back when a new batch opens." />
            @endif
        </div>
    </section>
</x-app-layout>

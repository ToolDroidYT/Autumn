@props(['program', 'title', 'subtitle', 'items' => [], 'image' => '', 'color' => 'var(--orange)'])
<a class="program-card" href="{{ route('products.index', ['program' => $program]) }}" style="--image:url('{{ asset($image) }}');--program-color:{{ $color }};">
    <div class="program-image"></div>
    <div class="program-body">
        <h3>{{ $title }}</h3>
        <div style="color:var(--muted);font-size:13px;">{{ $subtitle }}</div>
        <ul>@foreach($items as $item)<li>{{ $item }}</li>@endforeach</ul>
    </div>
</a>

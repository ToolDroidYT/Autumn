<aside class="card admin-sidebar" aria-label="Admin navigation">
    @foreach([
        'admin.index' => ['Overview', 'home'],
        'admin.products' => ['Products', 'shopping-bag'],
        'admin.batches' => ['Batches', 'package'],
        'admin.orders' => ['Orders', 'receipt'],
        'admin.payments' => ['Payments', 'shield'],
        'admin.announcements' => ['Announcements', 'bell'],
        'admin.voting' => ['Voting', 'vote'],
        'admin.users' => ['Users', 'users'],
    ] as $route => [$label, $icon])
        <a href="{{ route($route) }}" @class(['active' => request()->routeIs($route)])><x-icon :name="$icon" class="h-4 w-4" />{{ $label }}</a>
    @endforeach
</aside>

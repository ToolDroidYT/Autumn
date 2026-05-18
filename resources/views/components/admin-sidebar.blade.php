<aside class="card admin-sidebar">
    @foreach([
        'admin.index' => 'Overview',
        'admin.products' => 'Products',
        'admin.batches' => 'Batches',
        'admin.orders' => 'Orders',
        'admin.payments' => 'Payments',
        'admin.announcements' => 'Announcements',
        'admin.voting' => 'Voting',
        'admin.users' => 'Users',
    ] as $route => $label)
        <a href="{{ route($route) }}" @class(['active' => request()->routeIs($route)])>{{ $label }}</a>
    @endforeach
</aside>

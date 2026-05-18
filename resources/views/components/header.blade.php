<header class="header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo" aria-label="AUTUMN home"><span class="logo-leaf">⌁</span><span>AUT</span><span class="accent-red">UM</span><span>N</span></a>
        <nav class="nav" aria-label="Main navigation">
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('home') }}#about">About</a>
            <a href="{{ route('faq') }}">FAQ</a>
            <a href="{{ route('announcements.index') }}">Announcements</a>
        </nav>
        <div class="actions">
            @auth
                @if(auth()->user()->isAdmin())
                    <x-button href="{{ route('admin.index') }}" variant="outline">Admin</x-button>
                @endif
                <x-button href="{{ route('dashboard') }}" variant="outline">Dashboard</x-button>
                <form method="POST" action="{{ route('logout') }}" data-confirm="Sign out of AUTUMN?">@csrf <x-button type="submit">Sign Out</x-button></form>
            @else
                <x-button href="{{ route('login') }}">↪ Sign In</x-button>
            @endauth
            <button class="btn btn-outline mobile-toggle" type="button" data-mobile-toggle>Menu</button>
        </div>
    </div>
    <div class="mobile-panel" data-mobile-panel>
        <a href="{{ route('products.index') }}">Products</a>
        <a href="{{ route('home') }}#about">About</a>
        <a href="{{ route('faq') }}">FAQ</a>
        <a href="{{ route('announcements.index') }}">Announcements</a>
    </div>
</header>

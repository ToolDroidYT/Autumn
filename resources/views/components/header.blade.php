<header class="header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="logo" aria-label="AUTUMN home">
            <x-icon name="leaf" class="logo-leaf h-5 w-5" />
            <span class="logo-word">AUT<span class="accent-red">UM</span>N</span>
        </a>

        <nav class="nav" aria-label="Main navigation">
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('home') }}#about">About</a>
            <a href="{{ route('faq') }}">FAQ</a>
            <a href="{{ route('announcements.index') }}">Announcements</a>
        </nav>

        <div class="actions header-actions">
            @auth
                @if(auth()->user()->isAdmin())
                    <x-button href="{{ route('admin.index') }}" variant="outline"><x-icon name="settings" class="h-4 w-4" />Admin</x-button>
                @endif
                <x-button href="{{ route('dashboard') }}" variant="outline"><x-icon name="user" class="h-4 w-4" />Dashboard</x-button>
                <form method="POST" action="{{ route('logout') }}" data-confirm="Sign out of AUTUMN?">
                    @csrf
                    <x-button type="submit"><x-icon name="log-out" class="h-4 w-4" />Sign Out</x-button>
                </form>
            @else
                <x-button href="{{ route('login') }}"><x-icon name="log-in" class="h-4 w-4" />Sign In</x-button>
            @endauth

            <button
                class="btn btn-outline mobile-toggle"
                type="button"
                data-mobile-toggle
                aria-label="Open menu"
                aria-controls="mobile-menu"
                aria-expanded="false"
            >
                <x-icon name="menu" class="h-5 w-5" />
                <span class="sr-only">Menu</span>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="mobile-panel" data-mobile-panel>
        <a href="{{ route('products.index') }}"><x-icon name="shopping-bag" class="h-4 w-4" />Products</a>
        <a href="{{ route('home') }}#about"><x-icon name="home" class="h-4 w-4" />About</a>
        <a href="{{ route('faq') }}"><x-icon name="search" class="h-4 w-4" />FAQ</a>
        <a href="{{ route('announcements.index') }}"><x-icon name="bell" class="h-4 w-4" />Announcements</a>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.index') }}"><x-icon name="settings" class="h-4 w-4" />Admin</a>
            @endif
            <a href="{{ route('dashboard') }}"><x-icon name="user" class="h-4 w-4" />Dashboard</a>
        @else
            <a href="{{ route('login') }}"><x-icon name="log-in" class="h-4 w-4" />Sign In</a>
        @endauth
    </div>
</header>

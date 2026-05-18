<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="logo" aria-label="AUTUMN home">
                    <x-icon name="leaf" class="logo-leaf h-5 w-5" />
                    <span class="logo-word">AUT<span class="accent-red">UM</span>N</span>
                </a>
                <p>Automated Unified Merchandise Network for the Department of Computing Education, UMTC.</p>
            </div>
            <div>
                <h4>Navigation</h4>
                <a href="{{ route('products.index') }}">Products</a>
                <a href="{{ route('home') }}#about">About</a>
                <a href="{{ route('faq') }}">FAQ</a>
                <a href="{{ route('announcements.index') }}">Announcements</a>
            </div>
            <div>
                <h4>Programs</h4>
                <a href="{{ route('products.index', ['program' => 'IT']) }}">IT</a>
                <a href="{{ route('products.index', ['program' => 'CS']) }}">CS</a>
                <a href="{{ route('products.index', ['program' => 'CSIT/DCE']) }}">CSIT/DCE</a>
                <a href="{{ route('products.index', ['program' => 'CODES']) }}">CODES</a>
            </div>
        </div>
        <p class="footer-note">© {{ date('Y') }} AUTUMN · Department of Computing Education, UMTC. All rights reserved.</p>
    </div>
</footer>

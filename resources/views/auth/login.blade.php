<x-guest-layout title="Sign In">
    <section class="form-shell">
        <x-card>
            <x-badge>Access</x-badge>
            <h1 class="section-title" style="font-size:44px;text-align:left;">Sign <span class="accent-red">In</span></h1>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <x-input label="University Email" name="email" type="email" required autofocus />
                <x-input label="Password" name="password" type="password" required />
                <label style="display:flex;gap:8px;color:var(--muted);margin-bottom:18px;"><input type="checkbox" name="remember" value="1"> Remember me</label>
                <x-button type="submit"><x-icon name="log-in" class="h-4 w-4" />Sign In</x-button>
                <x-button href="{{ route('register') }}" variant="ghost"><x-icon name="plus" class="h-4 w-4" />Create account</x-button>
            </form>
        </x-card>
    </section>
</x-guest-layout>

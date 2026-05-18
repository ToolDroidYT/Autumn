<x-guest-layout title="Register">
    <section class="form-shell">
        <x-card>
            <x-badge>University Access</x-badge>
            <h1 class="section-title" style="font-size:44px;text-align:left;">Create <span class="accent-red">Account</span></h1>
            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <x-input label="Full Name" name="name" required />
                <x-input label="University Email" name="email" type="email" required />
                <x-select label="Program" name="program" :options="['DCE'=>'DCE','IT'=>'IT','CS'=>'CS','CSIT/DCE'=>'CSIT/DCE','CODES'=>'CODES']" />
                <x-input label="Password" name="password" type="password" required />
                <x-input label="Confirm Password" name="password_confirmation" type="password" required />
                <x-button type="submit"><x-icon name="plus" class="h-4 w-4" />Register</x-button>
                <x-button href="{{ route('login') }}" variant="ghost"><x-icon name="log-in" class="h-4 w-4" />Already have an account</x-button>
            </form>
        </x-card>
    </section>
</x-guest-layout>

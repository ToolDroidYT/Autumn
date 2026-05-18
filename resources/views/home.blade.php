<x-app-layout title="Home">
    <section class="hero">
        <div class="hero-content">
            <x-badge>Department of Computing Education · UMTC</x-badge>
            <h1 class="hero-title">AUT<span class="accent-red">UM</span>N</h1>
            <div class="hero-kicker">Automated Unified Merchandise Network</div>
            <p class="hero-subtitle">Your one-stop platform for DCE merchandise — order, track, vote on designs, and receive e-receipts, all in one place.</p>
            <div class="actions" style="justify-content:center;"><x-button href="{{ route('login') }}">↪ Sign In</x-button><x-button href="#products" variant="outline">Browse Products</x-button></div>
            <div class="hero-stats"><div class="hero-stat"><strong>4</strong><span>Programs</span></div><div class="hero-stat"><strong>100%</strong><span>Digital</span></div><div class="hero-stat"><strong>24/7</strong><span>Access</span></div></div>
        </div>
        <a href="#products" class="down-cue">⌄</a>
    </section>

    <section id="products" class="section">
        <div class="container">
            <div class="section-head"><x-badge>Merchandise</x-badge><h2 class="section-title">Shop by <span class="accent-red">Program</span></h2><p class="section-copy">Products are curated specifically for your program. Sign in to access merch exclusive to your department.</p></div>
            <div class="grid grid-4">
                <x-program-card program="IT" title="IT" subtitle="Information Technology" image="images/programs/it.svg" color="#4f7cff" :items="['Polo Shirt','Hoodie','Sticker Pack']" />
                <x-program-card program="CS" title="CS" subtitle="Computer Science" image="images/programs/cs.svg" color="#22c55e" :items="['Polo Shirt','Cap','Event Jersey']" />
                <x-program-card program="CSIT/DCE" title="CSIT/DCE" subtitle="Computing Education" image="images/programs/dce.svg" color="#f97316" :items="['Jacket','Shirt','Lanyard']" />
                <x-program-card program="CODES" title="CODES" subtitle="CODES Organization" image="images/programs/codes.svg" color="#a855f7" :items="['Exclusive Tee','Sticker Pack','Starter Pack']" />
            </div>
        </div>
    </section>

    <section class="section section-surface">
        <div class="container">
            <div class="section-head"><x-badge>Features</x-badge><h2 class="section-title">Everything you <span class="accent-red">Need</span></h2></div>
            <div class="grid grid-3">
                @foreach([
                    ['Batch Ordering','Order within open batch slots. Slot-based system ensures fairness across all students.'],
                    ['Design Voting','Participate in design elections. Vote counts are hidden until final 24 hours to ensure a fair process.'],
                    ['Secure Payments','GCash, Maya, or in-person payment options. Upload proof and receive a QR-verified digital receipt.'],
                    ['E-Receipts','Tamper-evident digital receipts with embedded QR codes linked to verified order records.'],
                    ['Program-Based Access','IT, CS, CSIT/DCE, and CODES merch — only visible to authorized members of each program.'],
                    ['Real-Time Availability','Live slot tracking shows available quantities per size in each active batch.'],
                ] as [$title, $copy])
                    <x-card><div class="feature-icon">▣</div><h3>{{ $title }}</h3><p>{{ $copy }}</p></x-card>
                @endforeach
            </div>
        </div>
    </section>

    <section id="about" class="section">
        <div class="container about-grid">
            <div>
                <x-badge>About AUTUMN</x-badge>
                <h2 class="section-title" style="text-align:left;">Built for the <span class="accent-red">DCE Community</span></h2>
                <p class="section-copy" style="margin-inline:0;">AUTUMN — the <strong style="color:var(--orange);">Automated Unified Merchandise Network</strong> — is a centralized web-based system exclusive to the Department of Computing Education at UMTC.</p>
                <p class="section-copy" style="margin-inline:0;">It replaces fragmented manual processes by letting students browse, order, pay, track, and receive receipts while giving organizers full administrative control.</p>
                <ul class="list-check"><li>University Gmail-based authentication</li><li>Program-filtered product visibility</li><li>Role-based admin dashboards</li><li>Transparent design voting system</li></ul>
            </div>
            <div class="about-visual"><div><h3 class="logo"><span>AUT</span><span class="accent-red">UM</span><span>N</span></h3><p>Department of Computing Education</p></div><div class="float-stat"><strong style="font-size:28px;">4</strong><br><span>Programs Served</span></div></div>
        </div>
    </section>

    <section class="section section-surface">
        <div class="container">
            <div class="section-head"><x-badge>Updates</x-badge><h2 class="section-title"><span class="accent-red">Announcements</span></h2></div>
            <div class="grid grid-3">@foreach($announcements as $announcement)<x-announcement-card :announcement="$announcement" />@endforeach</div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head"><x-badge>Help</x-badge><h2 class="section-title">Frequently Asked <span class="accent-red">Questions</span></h2></div>
            <div class="faq-list">
                <x-faq-item question="Who can register for AUTUMN?">Only users with an @umindanao.edu.ph email can register. Students choose their program during registration.</x-faq-item>
                <x-faq-item question="What is a batch order and how does it work?">A batch order groups merchandise requests within a deadline and slot limit before production starts.</x-faq-item>
                <x-faq-item question="Can I cancel my order after placing it?">Orders can be cancelled while pending. Once payment is confirmed, cancellation is locked and must be handled by admins.</x-faq-item>
                <x-faq-item question="How does design voting work?">Admins create voting entries and students choose from available design options before the closing date.</x-faq-item>
                <x-faq-item question="What payment methods are accepted?">GCash, Maya, and in-person payments are supported for demo workflows.</x-faq-item>
                <x-faq-item question="What merch can I see if I'm a CODES member?">CODES members can see DCE-wide products and CODES-exclusive organization merchandise.</x-faq-item>
            </div>
        </div>
    </section>

    <section class="section cta-band">
        <div class="container"><h2 class="section-title">Ready to <span class="accent-red">Order?</span></h2><p class="section-copy">Join the DCE merchandise system. Sign in with your university Gmail to get started.</p><x-button href="{{ route('login') }}">↪ Sign In</x-button></div>
    </section>
</x-app-layout>

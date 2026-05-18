@props(['announcement'])
<article class="card card-pad announcement-card">
    <div>
        <div class="meta-row"><x-badge>{{ $announcement->category }}</x-badge><span>{{ optional($announcement->published_at)->format('M j, Y') }}</span></div>
        <h3>{{ $announcement->title }}</h3>
        <p>{{ Str::limit($announcement->body, 132) }}</p>
    </div>
    <a href="{{ route('announcements.show', $announcement) }}" style="color:var(--orange);font-weight:800;font-size:13px;">Read more</a>
</article>

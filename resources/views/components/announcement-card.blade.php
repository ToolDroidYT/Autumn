@props(['announcement'])
<article class="card card-pad announcement-card">
    <div>
        <div class="meta-row">
            <span class="meta-label"><x-icon name="bell" class="h-4 w-4" />{{ $announcement->category }}</span>
            <span>{{ optional($announcement->published_at)->format('M j, Y') }}</span>
        </div>
        <h3>{{ $announcement->title }}</h3>
        <p>{{ Str::limit($announcement->body, 132) }}</p>
    </div>
    <a href="{{ route('announcements.show', $announcement) }}" class="text-link"><x-icon name="chevron-right" class="h-4 w-4" />Read more</a>
</article>

@props(['title' => 'Nothing here yet', 'message' => 'There is no data to show.'])
<div class="empty">
    <h3>{{ $title }}</h3>
    <p>{{ $message }}</p>
    {{ $slot }}
</div>

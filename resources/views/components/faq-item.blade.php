@props(['question'])
<div class="faq-item" data-faq-item>
    <button class="faq-trigger" type="button" data-faq-trigger aria-expanded="false">
        <span>{{ $question }}</span>
        <x-icon name="chevron-down" class="faq-icon h-4 w-4" />
    </button>
    <div class="faq-answer">{{ $slot }}</div>
</div>

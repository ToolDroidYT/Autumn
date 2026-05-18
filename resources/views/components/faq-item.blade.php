@props(['question'])
<div class="faq-item" data-faq-item>
    <button class="faq-trigger" type="button" data-faq-trigger><span>{{ $question }}</span><span style="color:var(--orange);">⌄</span></button>
    <div class="faq-answer">{{ $slot }}</div>
</div>

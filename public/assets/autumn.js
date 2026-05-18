(() => {
    const $ = (selector, root = document) => root.querySelector(selector);
    const $$ = (selector, root = document) => [...root.querySelectorAll(selector)];

    const toast = $('#toast');
    const bodyToast = document.body.dataset.toast;
    const showToast = (message) => {
        if (!toast || !message) return;
        toast.textContent = message;
        toast.classList.add('is-visible');
        setTimeout(() => toast.classList.remove('is-visible'), 3400);
    };
    showToast(bodyToast);

    $('[data-mobile-toggle]')?.addEventListener('click', () => {
        $('[data-mobile-panel]')?.classList.toggle('is-open');
    });

    $$('[data-faq-trigger]').forEach((button) => {
        button.addEventListener('click', () => button.closest('[data-faq-item]')?.classList.toggle('is-open'));
    });

    $$('[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const message = form.dataset.confirm || 'Continue with this action?';
            if (!window.confirm(message)) event.preventDefault();
        });
    });

    $$('[data-preview-input]').forEach((input) => {
        input.addEventListener('change', () => {
            const target = document.querySelector(input.dataset.previewInput);
            const file = input.files?.[0];
            if (!target || !file) return;
            target.src = URL.createObjectURL(file);
            target.hidden = false;
        });
    });

    $$('[data-print]').forEach((button) => button.addEventListener('click', () => window.print()));

    $$('[data-tab]').forEach((button) => {
        button.addEventListener('click', () => {
            const group = button.dataset.tabGroup;
            $$(`[data-tab-group="${group}"]`).forEach((node) => node.classList.remove('is-active'));
            $$(`[data-tab-panel][data-tab-group="${group}"]`).forEach((node) => node.hidden = true);
            button.classList.add('is-active');
            const panel = $(`[data-tab-panel="${button.dataset.tab}"][data-tab-group="${group}"]`);
            if (panel) panel.hidden = false;
        });
    });
})();

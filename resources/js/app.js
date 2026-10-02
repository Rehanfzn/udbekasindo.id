document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initCalculator();
    initConfirmForms();
    initWhatsAppPopup();
});

function initWhatsAppPopup() {
    const root = document.querySelector('[data-wa-popup]');
    if (!root) return;

    const toggle = root.querySelector('[data-wa-toggle]');
    const panel = root.querySelector('[data-wa-panel]');
    const close = root.querySelector('[data-wa-close]');
    if (!toggle || !panel) return;

    const setOpen = (open) => {
        panel.classList.toggle('hidden', !open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    toggle.addEventListener('click', () => setOpen(panel.classList.contains('hidden')));
    close?.addEventListener('click', () => setOpen(false));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setOpen(false);
    });
}

function initMobileMenu() {
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
}

function initConfirmForms() {
    document.querySelectorAll('[data-confirm]').forEach((el) => {
        el.addEventListener('submit', (event) => {
            if (!window.confirm(el.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });
}

function initCalculator() {
    const form = document.getElementById('calculator-form');
    if (!form) return;

    const resultBox = document.getElementById('calculator-result');
    const errorBox = document.getElementById('calculator-errors');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    let debounceTimer = null;

    const activeShape = () => form.querySelector('input[name="shape"]:checked')?.value ?? 'plat';

    const syncPanels = () => {
        const shape = activeShape();

        form.querySelectorAll('[data-shape-panel]').forEach((panel) => {
            const isActive = panel.dataset.shapePanel === shape;
            panel.classList.toggle('hidden', !isActive);

            panel.querySelectorAll('input, select').forEach((field) => {
                field.disabled = !isActive;
            });
        });
    };

    const showErrors = (errors) => {
        if (!errorBox) return;
        const messages = Array.isArray(errors) ? errors : Object.values(errors).flat();

        if (messages.length === 0) {
            errorBox.classList.add('hidden');
            errorBox.innerHTML = '';
            return;
        }

        errorBox.innerHTML =
            '<ul class="list-inside list-disc space-y-1">' +
            messages.map((message) => `<li>${escapeHtml(message)}</li>`).join('') +
            '</ul>';
        errorBox.classList.remove('hidden');
    };

    const updateDescription = () => {
        const active = form.querySelector('input[name="shape"]:checked');
        if (!active) return;

        const description = document.querySelector('[data-shape-description]');
        const formula = document.querySelector('[data-shape-formula]');
        if (description) description.textContent = active.dataset.description ?? '';
        if (formula) formula.textContent = `— ${active.dataset.formula ?? ''}`;
    };

    const calculate = async () => {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        });

        const payload = await response.json().catch(() => ({}));

        if (response.ok && payload.html) {
            showErrors([]);
            resultBox.innerHTML = payload.html;
            resultBox.classList.remove('hidden');
        } else if (payload.errors) {
            showErrors(payload.errors);
        }
    };

    const schedule = () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(calculate, 500);
    };

    form.querySelectorAll('input[name="shape"]').forEach((input) => {
        input.addEventListener('change', () => {
            syncPanels();
            updateDescription();
            schedule();
        });
    });

    form.querySelectorAll('select, input[type="number"]').forEach((field) => {
        field.addEventListener('input', schedule);
        field.addEventListener('change', schedule);
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        clearTimeout(debounceTimer);
        calculate();
    });

    syncPanels();
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value;
    return div.innerHTML;
}

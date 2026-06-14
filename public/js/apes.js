const revealSelector = [
    '.hero-panel',
    '.dashboard-card',
    '.stat-card',
    '.mini-metric',
    '.activity-item',
    '.ranking-item',
    '.timeline-row',
    '.component-row',
    '.quick-action',
].join(', ');

function animateNumber(element) {
    const raw = element.textContent.trim();
    const match = raw.match(/^(\d+(?:\.\d+)?)(%)?$/);

    if (!match) {
        return;
    }

    const target = Number.parseFloat(match[1]);
    const suffix = match[2] ?? '';
    const duration = 900;
    const start = performance.now();

    const tick = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const value = target * (0.15 + (0.85 * progress));
        const formatted = Number.isInteger(target) ? Math.round(value) : value.toFixed(1);

        element.textContent = `${formatted}${suffix}`;

        if (progress < 1) {
            window.requestAnimationFrame(tick);
            return;
        }

        element.textContent = `${Number.isInteger(target) ? Math.round(target) : target.toFixed(1)}${suffix}`;
    };

    element.textContent = `0${suffix}`;
    window.requestAnimationFrame(tick);
}

function revealElements() {
    const items = Array.from(document.querySelectorAll(revealSelector));

    if (!items.length) {
        return;
    }

    items.forEach((item) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(12px)';
        item.style.transition = 'opacity 420ms ease, transform 420ms ease';
        item.style.willChange = 'opacity, transform';
    });

    const showItem = (item, delay) => {
        item.style.transitionDelay = `${delay}ms`;
        window.requestAnimationFrame(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        });
    };

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const index = Number(entry.target.dataset.revealIndex ?? 0);
                showItem(entry.target, Math.min(index, 12) * 32);
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.14 });

        items.forEach((item, index) => {
            item.dataset.revealIndex = String(index);
            observer.observe(item);
        });
        return;
    }

    items.forEach((item, index) => showItem(item, index * 24));
}

function animateCounters() {
    const counters = document.querySelectorAll('.stat-card-value, .mini-metric strong, .summary-chip strong');
    counters.forEach((counter) => animateNumber(counter));
}

function bindTopbarScrollState() {
    const topbar = document.querySelector('.topbar');

    if (!topbar) {
        return;
    }

    const sync = () => {
        topbar.classList.toggle('is-scrolled', window.scrollY > 8);
    };

    sync();
    window.addEventListener('scroll', sync, { passive: true });
}

function bindAssessmentForm() {
    const form = document.querySelector('[data-assessment-form]');

    if (!form) {
        return;
    }

    const groups = Array.from(form.querySelectorAll('[data-score-group]'));
    const progressCount = form.querySelector('[data-progress-count]');
    const progressTotal = form.querySelector('[data-progress-total]');
    const progressBar = form.querySelector('[data-progress-bar]');
    const total = groups.length;

    if (progressTotal) {
        progressTotal.textContent = String(total);
    }

    const syncGroup = (group) => {
        const checked = group.querySelector('input[type="radio"]:checked');

        group.querySelectorAll('[data-score-button]').forEach((button) => {
            button.classList.toggle('is-active', button.contains(checked));
        });
    };

    const syncProgress = () => {
        let completed = 0;

        groups.forEach((group) => {
            const checked = group.querySelector('input[type="radio"]:checked');
            if (checked) {
                completed += 1;
            }

            syncGroup(group);
        });

        if (progressCount) {
            progressCount.textContent = String(completed);
        }

        if (progressBar) {
            progressBar.style.width = `${total > 0 ? Math.round((completed / total) * 100) : 0}%`;
        }
    };

    form.addEventListener('change', (event) => {
        if (!event.target.matches('input[type="radio"]')) {
            return;
        }

        const group = event.target.closest('[data-score-group]');
        if (group) {
            syncGroup(group);
        }

        syncProgress();
    });

    syncProgress();
}

document.addEventListener('DOMContentLoaded', () => {
    document.body.classList.add('js-ready');
    revealElements();
    animateCounters();
    bindTopbarScrollState();
    bindAssessmentForm();
});

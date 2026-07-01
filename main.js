/* ============================================================
   HAVEN HANDS — main.js
   Enhanced: sticky nav, mobile menu, scroll animations,
             FAQ accordion, worker filter, contact form, WhatsApp
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Lucide Icons ── */
    if (typeof lucide !== 'undefined') lucide.createIcons();

    /* ── Sticky Header ── */
    const header = document.getElementById('header');
    if (header) {
        const onScroll = () => {
            header.classList.toggle('scrolled', window.scrollY > 40);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    /* ── Mobile Menu ── */
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks   = document.querySelector('.nav-links');

    function closeNav() {
        if (!menuToggle || !navLinks) return;
        menuToggle.classList.remove('open');
        navLinks.classList.remove('open');
        menuToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (menuToggle && navLinks) {
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = navLinks.classList.toggle('open');
            menuToggle.classList.toggle('open', isOpen);
            menuToggle.setAttribute('aria-expanded', String(isOpen));
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });
        navLinks.querySelectorAll('a').forEach(a => a.addEventListener('click', closeNav));
        document.addEventListener('click', (e) => { if (!e.target.closest('#header')) closeNav(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeNav(); });
    }

    /* ── Active nav link ── */
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav-links a').forEach(a => {
        const href = a.getAttribute('href');
        if (href && (href === currentPage || href.includes(currentPage))) {
            a.classList.add('active');
        }
    });

    /* ── Scroll Reveal Animations ── */
    const revealEls = document.querySelectorAll('[data-reveal]');
    if (revealEls.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });
        revealEls.forEach(el => observer.observe(el));
    }

    /* ── FAQ Accordion ── */
    document.querySelectorAll('.faq-q').forEach(q => {
        q.addEventListener('click', () => {
            const item = q.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            // Close all
            document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
            // Toggle clicked
            if (!isOpen) item.classList.add('open');
        });
    });

    /* ── Worker / Caregiver Filter ── */
    const filterTabs = document.querySelectorAll('.filter-tab');
    const workerCards = document.querySelectorAll('.worker-card[data-type]');

    if (filterTabs.length && workerCards.length) {
        filterTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                filterTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                const type = tab.dataset.filter;
                workerCards.forEach(card => {
                    if (type === 'all' || card.dataset.type === type) {
                        card.style.display = '';
                        setTimeout(() => { card.style.opacity = '1'; card.style.transform = ''; }, 10);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';
                        setTimeout(() => { card.style.display = 'none'; }, 350);
                    }
                });
            });
        });
    }

    /* ── Contact Form (EmailJS) ── */
    const form = document.getElementById('contactForm');
    if (form) {
        // Init EmailJS if config available
        if (typeof emailjs !== 'undefined' && typeof EMAILJS_CONFIG !== 'undefined') {
            emailjs.init(EMAILJS_CONFIG.PUBLIC_KEY);
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = form.querySelector('[type="submit"]');
            const successMsg = document.getElementById('formSuccess');
            const errorMsg   = document.getElementById('formError');

            btn.disabled = true;
            btn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="spin"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Sending…`;

            const formData = {
                from_name:    form.querySelector('#name')?.value    || '',
                from_email:   form.querySelector('#email')?.value   || '',
                phone:        form.querySelector('#phone')?.value   || '',
                service:      form.querySelector('#service')?.value || '',
                message:      form.querySelector('#message')?.value || '',
            };

            try {
                if (typeof emailjs !== 'undefined' && typeof EMAILJS_CONFIG !== 'undefined') {
                    await emailjs.send(EMAILJS_CONFIG.SERVICE_ID, EMAILJS_CONFIG.TEMPLATE_ID, formData);
                } else {
                    // Simulate success for demo
                    await new Promise(r => setTimeout(r, 1500));
                }
                form.reset();
                btn.disabled = false;
                btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Message Sent!`;
                if (successMsg) { successMsg.style.display = 'block'; }
                if (errorMsg)   { errorMsg.style.display = 'none'; }
                setTimeout(() => {
                    btn.innerHTML = 'Send Message <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
                    if (successMsg) successMsg.style.display = 'none';
                }, 5000);
            } catch (err) {
                console.error('Form error:', err);
                btn.disabled = false;
                btn.innerHTML = 'Try Again';
                if (errorMsg) { errorMsg.style.display = 'block'; }
                setTimeout(() => {
                    btn.innerHTML = 'Send Message';
                    if (errorMsg) errorMsg.style.display = 'none';
                }, 4000);
            }
        });
    }

    /* ── Smooth scroll for anchor links ── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', (e) => {
            const id = a.getAttribute('href').slice(1);
            const target = document.getElementById(id);
            if (target) {
                e.preventDefault();
                closeNav();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    /* ── Stats Counter Animation ── */
    const statValues = document.querySelectorAll('.stat-value[data-target]');
    if (statValues.length) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        statValues.forEach(el => counterObserver.observe(el));
    }

    function animateCounter(el) {
        const target = parseInt(el.dataset.target, 10);
        const suffix = el.dataset.suffix || '';
        const duration = 1800;
        const start = performance.now();
        const update = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target) + suffix;
            if (progress < 1) requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
    }

    /* ── Blog search (blog listing page) ── */
    const blogSearch = document.getElementById('blogSearch');
    const blogCards  = document.querySelectorAll('.blog-card[data-title]');
    if (blogSearch && blogCards.length) {
        blogSearch.addEventListener('input', () => {
            const q = blogSearch.value.toLowerCase();
            blogCards.forEach(card => {
                const visible = card.dataset.title.toLowerCase().includes(q);
                card.style.display = visible ? '' : 'none';
            });
        });
    }

    /* ── iOS horizontal scroll fix ── */
    window.addEventListener('scroll', () => {
        if (window.innerWidth <= 768 && window.scrollX !== 0) {
            window.scrollTo(0, window.scrollY);
        }
    }, { passive: false });

});

/* ── Spinner CSS injected via JS (for button loading state) ── */
(function() {
    const style = document.createElement('style');
    style.textContent = `.spin { animation: spin 0.8s linear infinite; } @keyframes spin { to { transform: rotate(360deg); } }`;
    document.head.appendChild(style);
})();

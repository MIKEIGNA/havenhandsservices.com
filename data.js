/* ============================================================
   HAVEN HANDS — data.js
   Google Sheets → Dynamic Content
   ============================================================ */

const HH = (() => {

    /* ── CONFIG ── */
    // Replace these URLs with your Google Sheet published CSV URLs
    // To get these: Google Sheet → File → Share → Publish to web → Select tab → CSV → Publish
    const SHEETS = {
        caregivers:  'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ1vX4eHvu037FL79437YcIuokjAiTgjgDdhIVsNLfjFII6nhDmElVZ5grXyXXFMF6AAsV_tSHHKNpV/pub?gid=0&single=true&output=csv',  // e.g. 'https://docs.google.com/spreadsheets/d/SHEET_ID/pub?gid=0&single=true&output=csv'
        pricing:     'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ1vX4eHvu037FL79437YcIuokjAiTgjgDdhIVsNLfjFII6nhDmElVZ5grXyXXFMF6AAsV_tSHHKNpV/pub?gid=1379263939&single=true&output=csv',  // e.g. 'https://docs.google.com/spreadsheets/d/SHEET_ID/pub?gid=1&single=true&output=csv'
        blog:        'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ1vX4eHvu037FL79437YcIuokjAiTgjgDdhIVsNLfjFII6nhDmElVZ5grXyXXFMF6AAsV_tSHHKNpV/pub?gid=2020416238&single=true&output=csv',  // e.g. 'https://docs.google.com/spreadsheets/d/SHEET_ID/pub?gid=2&single=true&output=csv'
        testimonials:'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ1vX4eHvu037FL79437YcIuokjAiTgjgDdhIVsNLfjFII6nhDmElVZ5grXyXXFMF6AAsV_tSHHKNpV/pub?gid=1481590388&single=true&output=csv',  // e.g. 'https://docs.google.com/spreadsheets/d/SHEET_ID/pub?gid=3&single=true&output=csv'
        faq:         'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ1vX4eHvu037FL79437YcIuokjAiTgjgDdhIVsNLfjFII6nhDmElVZ5grXyXXFMF6AAsV_tSHHKNpV/pub?gid=2100583341&single=true&output=csv',  // e.g. 'https://docs.google.com/spreadsheets/d/SHEET_ID/pub?gid=4&single=true&output=csv'
    };

    const CACHE_TTL = 6 * 60 * 60 * 1000; // 6 hours
    const WHATSAPP_NUMBER = '254118971254';

    /* ── CSV Parser ── */
    function parseCSV(text) {
        const rows = [];
        const lines = text.split('\n');
        if (lines.length < 2) return rows;

        const headers = lines[0].split(',').map(h => h.trim().replace(/^"|"$/g, ''));

        for (let i = 1; i < lines.length; i++) {
            const line = lines[i].trim();
            if (!line) continue;

            const values = [];
            let current = '';
            let inQuotes = false;

            for (let j = 0; j < line.length; j++) {
                const ch = line[j];
                if (ch === '"') {
                    inQuotes = !inQuotes;
                } else if (ch === ',' && !inQuotes) {
                    values.push(current.trim());
                    current = '';
                } else {
                    current += ch;
                }
            }
            values.push(current.trim());

            const row = {};
            headers.forEach((h, idx) => {
                row[h] = values[idx] || '';
            });
            rows.push(row);
        }
        return rows;
    }

    /* ── Fetch with Cache ── */
    async function fetchSheet(key) {
        const url = SHEETS[key];
        if (!url) return [];

        const cacheKey = `hh_${key}`;
        const cached = localStorage.getItem(cacheKey);
        if (cached) {
            const { data, timestamp } = JSON.parse(cached);
            if (Date.now() - timestamp < CACHE_TTL) return data;
        }

        try {
            const res = await fetch(url);
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const text = await res.text();
            const data = parseCSV(text);
            localStorage.setItem(cacheKey, JSON.stringify({ data, timestamp: Date.now() }));
            return data;
        } catch (err) {
            console.warn(`Failed to fetch ${key}:`, err);
            if (cached) return JSON.parse(cached).data;
            return [];
        }
    }

    /* ── WhatsApp URL Builder ── */
    function waUrl(name, role) {
        const msg = `Hello Haven Hands, I'd like to request an interview with ${name} for a ${role} role.`;
        return `https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(msg)}`;
    }

    /* ── Render: Caregivers ── */
    function renderCaregivers(container, options = {}) {
        const { featuredOnly = false, limit = 0 } = options;
        return async () => {
            const data = await fetchSheet('caregivers');
            if (!data.length) return;

            let filtered = data.filter(r => r.name && r.name.trim());
            if (featuredOnly) filtered = filtered.filter(r => r.featured === 'yes');
            if (limit > 0) filtered = filtered.slice(0, limit);
            filtered.sort((a, b) => (parseInt(a.order) || 99) - (parseInt(b.order) || 99));

            const html = filtered.map(row => {
                const statusClass = (row.status || 'available').toLowerCase().replace(/\s+/g, '-');
                const statusLabel = row.status || 'Available';
                const typeLower = (row.type || 'househelp').toLowerCase().replace(/\s+/g, '-');
                const isLocked = statusClass === 'matched' || statusClass === 'not-available';
                const cardClass = isLocked ? 'worker-card locked' : 'worker-card';
                const imgSrc = row.image || 'worker-1.jpg';
                const altText = row.alt || `${row.name} - ${row.type}`;
                const exp = row.experience || '1 year experience';
                const desc = row.description || '';
                const typeLabel = row.type || 'House Help';

                let actionHtml = '';
                if (isLocked && statusClass === 'matched') {
                    actionHtml = `<a href="#" class="btn btn-outline btn-full" style="pointer-events:none; opacity:0.5;">Currently Matched</a>`;
                } else if (isLocked) {
                    actionHtml = `<a href="https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent('Hello Haven Hands, I\'d like to inquire about ' + row.name + '.')}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-full">Inquire</a>`;
                } else {
                    actionHtml = `<a href="${waUrl(row.name, typeLabel)}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-full">Request Interview</a>`;
                }

                return `
                    <div class="${cardClass}" data-type="${typeLower}">
                        <div class="worker-img-wrap">
                            <img src="${imgSrc}" alt="${altText}" class="worker-img">
                        </div>
                        <div class="worker-info">
                            <span class="worker-type">${typeLabel}</span>
                            <span class="worker-status ${statusClass}">${statusLabel}</span>
                            <div class="worker-name">${row.name}</div>
                            <div class="worker-exp">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                ${exp}
                            </div>
                            <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 1rem;">${desc}</p>
                            <div class="worker-actions">${actionHtml}</div>
                        </div>
                    </div>`;
            }).join('');

            container.innerHTML = html;
            container.querySelectorAll('.worker-card').forEach(c => c.style.opacity = '1');
        };
    }

    /* ── Render: Pricing ── */
    function renderPricing(container, section = 'employers') {
        return async () => {
            const data = await fetchSheet('pricing');
            if (!data.length) return;

            let filtered = data.filter(r => r.name && r.name.trim() && r.section === section);
            filtered.sort((a, b) => (parseInt(a.order) || 99) - (parseInt(b.order) || 99));

            const html = filtered.map(row => {
                const isFeatured = row.featured === 'yes';
                const cardClass = isFeatured ? 'pricing-card featured' : 'pricing-card';
                const features = (row.features || '').split('|').filter(f => f.trim());
                const btnClass = row.buttonStyle === 'primary' ? 'btn btn-primary btn-full' : 'btn btn-outline btn-full';
                const btnLink = row.buttonLink || 'contact.html';
                const btnText = row.buttonText || 'Get Started';

                const featuresHtml = features.map(f => `
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        ${f.trim()}
                    </li>`).join('');

                return `
                    <div class="${cardClass}">
                        ${isFeatured ? '<div class="pricing-badge">Most Popular</div>' : ''}
                        <div class="pricing-header">
                            <h3>${row.name}</h3>
                            <div class="price">${row.price}<sub>${row.unit || ''}</sub></div>
                        </div>
                        <div class="pricing-body">
                            <ul class="pricing-features">${featuresHtml}</ul>
                        </div>
                        <div class="pricing-footer">
                            <a href="${btnLink}" class="${btnClass}">${btnText}</a>
                        </div>
                    </div>`;
            }).join('');

            container.innerHTML = html;
        };
    }

    /* ── Render: Blog Listing ── */
    function renderBlogListing(container) {
        return async () => {
            const data = await fetchSheet('blog');
            if (!data.length) return;

            let posts = data.filter(r => r.title && r.title.trim());
            posts.sort((a, b) => (parseInt(a.order) || 99) - (parseInt(b.order) || 99));

            const html = posts.map(row => {
                const imgSrc = row.image || 'blog-featured.jpg';
                const slug = row.slug || 'post-1';
                const isFeatured = row.featured === 'yes';
                const cat = row.category || 'General';
                const date = row.date || '';
                const excerpt = row.excerpt || '';
                const postUrl = `post.html?slug=${slug}`;

                if (isFeatured) {
                    return `
                        <div class="blog-featured">
                            <div class="blog-card-img-wrap" style="height: 100%;">
                                <img src="../${imgSrc}" alt="${row.title}" class="blog-card-img">
                            </div>
                            <div class="blog-featured-body">
                                <span class="blog-cat">${cat}</span>
                                <h2 class="blog-title" style="font-size: 1.6rem; margin: 0.5rem 0 1rem;">
                                    <a href="${postUrl}">${row.title}</a>
                                </h2>
                                <p class="blog-excerpt" style="margin-bottom: 1.5rem;">${excerpt}</p>
                                <div class="blog-meta" style="border: none; padding-top: 0;">
                                    <span>${date}</span>
                                    <a href="${postUrl}" class="read-more">Read Full Article <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
                                </div>
                            </div>
                        </div>`;
                }

                return `
                    <article class="blog-card" data-title="${row.title}">
                        <div class="blog-card-img-wrap">
                            <img src="../${imgSrc}" alt="${row.title}" class="blog-card-img" loading="lazy">
                        </div>
                        <div class="blog-card-body">
                            <div class="blog-cat">${cat}</div>
                            <h3 class="blog-title">${row.title}</h3>
                            <p class="blog-excerpt">${excerpt}</p>
                            <div class="blog-meta">
                                <span>${date}</span>
                                <a href="${postUrl}" class="read-more">
                                    Read More
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>`;
            }).join('');

            container.innerHTML = html;
        };
    }

    /* ── Render: Blog Post (single) ── */
    function renderBlogPost(container) {
        return async () => {
            const params = new URLSearchParams(window.location.search);
            const slug = params.get('slug');
            if (!slug) { container.innerHTML = '<p>Post not found.</p>'; return; }

            const data = await fetchSheet('blog');
            const post = data.find(r => r.slug === slug);
            if (!post) { container.innerHTML = '<p>Post not found.</p>'; return; }

            document.title = `${post.title} | Haven Hands Blog`;

            const imgSrc = post.image || 'blog-featured.jpg';
            const content = post.content || '<p>Content coming soon.</p>';

            container.innerHTML = `
                <article class="article-layout">
                    <div class="article-header">
                        <span class="blog-cat">${post.category || 'General'}</span>
                        <h1>${post.title}</h1>
                        <div class="blog-meta" style="justify-content: flex-start; gap: 1.5rem;">
                            <span>${post.date || ''}</span>
                        </div>
                    </div>
                    ${post.image ? `<img src="../${imgSrc}" alt="${post.title}" class="article-hero-img">` : ''}
                    <div class="article-content">${content}</div>
                </article>`;
        };
    }

    /* ── Render: Homepage Blog Preview ── */
    function renderBlogPreview(container) {
        return async () => {
            const data = await fetchSheet('blog');
            if (!data.length) return;

            let posts = data.filter(r => r.title && r.title.trim());
            posts.sort((a, b) => (parseInt(a.order) || 99) - (parseInt(b.order) || 99));
            posts = posts.slice(0, 3);

            const html = posts.map(row => {
                const imgSrc = row.image || 'blog-featured.jpg';
                const slug = row.slug || 'post-1';
                const postUrl = `blog/post.html?slug=${slug}`;

                return `
                    <article class="blog-card">
                        <div class="blog-card-img-wrap">
                            <img src="${imgSrc}" alt="${row.title}" class="blog-card-img" loading="lazy">
                        </div>
                        <div class="blog-card-body">
                            <div class="blog-cat">${row.category || 'General'}</div>
                            <h3 class="blog-title">${row.title}</h3>
                            <p class="blog-excerpt">${row.excerpt || ''}</p>
                            <div class="blog-meta">
                                <span>${row.date || ''}</span>
                                <a href="${postUrl}" class="read-more">
                                    Read More
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>`;
            }).join('');

            container.innerHTML = html;
        };
    }

    /* ── Render: Testimonials ── */
    function renderTestimonials(container) {
        return async () => {
            const data = await fetchSheet('testimonials');
            if (!data.length) return;

            let items = data.filter(r => r.quote && r.quote.trim() && r.active !== 'no');
            items.sort((a, b) => (parseInt(a.order) || 99) - (parseInt(b.order) || 99));

            const html = items.map(row => {
                const name = row.authorName || '';
                const initials = name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
                const loc = row.authorLocation || '';

                return `
                    <div class="testimonial-card">
                        <p class="t-text">"${row.quote}"</p>
                        <div class="t-author">
                            <div class="t-avatar">${initials}</div>
                            <div>
                                <div class="t-author-name">${name}</div>
                                <div class="t-author-loc">${loc}</div>
                            </div>
                        </div>
                    </div>`;
            }).join('');

            container.innerHTML = html;
        };
    }

    /* ── Render: FAQ ── */
    function renderFAQ(container, section = 'index') {
        return async () => {
            const data = await fetchSheet('faq');
            if (!data.length) return;

            let items = data.filter(r => r.question && r.question.trim() && (r.section || 'index') === section);
            items.sort((a, b) => (parseInt(a.order) || 99) - (parseInt(b.order) || 99));

            const faqIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>`;

            const html = items.map(row => {
                const openClass = row.openByDefault === 'yes' ? ' open' : '';
                return `
                    <div class="faq-item${openClass}">
                        <div class="faq-q">
                            <span>${row.question}</span>
                            <span class="faq-icon">${faqIcon}</span>
                        </div>
                        <div class="faq-a"><p>${row.answer}</p></div>
                    </div>`;
            }).join('');

            container.innerHTML = html;

            // Re-bind FAQ accordion
            container.querySelectorAll('.faq-q').forEach(q => {
                q.addEventListener('click', () => {
                    const item = q.closest('.faq-item');
                    const isOpen = item.classList.contains('open');
                    container.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
                    if (!isOpen) item.classList.add('open');
                });
            });
        };
    }

    /* ── Skeleton Loaders ── */
    function showSkeleton(container, type, count = 3) {
        const skeletons = {
            caregiver: `<div class="worker-card skeleton-card"><div class="skeleton-img"></div><div class="worker-info"><div class="skeleton-line short"></div><div class="skeleton-line"></div><div class="skeleton-line medium"></div><div class="skeleton-line long"></div></div></div>`,
            pricing: `<div class="pricing-card skeleton-card"><div class="skeleton-line short"></div><div class="skeleton-line medium"></div><div class="skeleton-line"></div><div class="skeleton-line long"></div></div>`,
            blog: `<div class="blog-card skeleton-card"><div class="skeleton-img"></div><div class="blog-card-body"><div class="skeleton-line short"></div><div class="skeleton-line"></div><div class="skeleton-line medium"></div></div></div>`,
            testimonial: `<div class="testimonial-card skeleton-card"><div class="skeleton-line long"></div><div class="skeleton-line medium"></div><div class="skeleton-line short"></div></div>`,
            faq: `<div class="faq-item skeleton-card"><div class="skeleton-line"></div><div class="skeleton-line long"></div></div>`,
        };
        container.innerHTML = Array(count).fill(skeletons[type] || skeletons.caregiver).join('');
    }

    /* ── Init: Auto-render on page load ── */
    function init() {
        const page = currentPage();

        // Homepage
        if (page === 'index.html' || page === '') {
            runIfContainer('featured-workers', renderCaregivers, { featuredOnly: true, limit: 3 });
            runIfContainer('testimonials-grid', renderTestimonials);
            runIfContainer('blog-grid', renderBlogPreview);
            runIfContainer('faq-list', renderFAQ, 'index');
        }

        // Workers
        if (page === 'workers.html') {
            runIfContainer('workers-grid', renderCaregivers);
        }

        // Pricing
        if (page === 'pricing.html') {
            runIfContainer('pricing-employers', renderPricing, 'employers');
            runIfContainer('pricing-training', renderPricing, 'training');
        }

        // Blog listing
        if (page === 'blog/index.html' || page === 'blog') {
            runIfContainer('blog-listing', renderBlogListing);
        }

        // Blog post
        if (page === 'blog/post.html' || page === 'blog/post') {
            runIfContainer('blog-post-content', renderBlogPost);
        }
    }

    function currentPage() {
        return window.location.pathname.split('/').pop() || 'index.html';
    }

    function runIfContainer(id, renderFn, options) {
        const el = document.getElementById(id);
        if (!el) return;
        showSkeleton(el, guessType(id), guessCount(id));
        const render = renderFn(el, options);
        render().catch(err => {
            console.error('Render error:', err);
            el.innerHTML = '<p style="text-align:center; color: var(--text-muted);">Content loading...</p>';
        });
    }

    function guessType(id) {
        if (id.includes('worker')) return 'caregiver';
        if (id.includes('pricing')) return 'pricing';
        if (id.includes('blog')) return 'blog';
        if (id.includes('testimonial')) return 'testimonial';
        if (id.includes('faq')) return 'faq';
        return 'caregiver';
    }

    function guessCount(id) {
        if (id.includes('faq')) return 3;
        return 3;
    }

    /* ── Public API ── */
    return {
        init,
        fetchSheet,
        renderCaregivers,
        renderPricing,
        renderBlogListing,
        renderBlogPost,
        renderBlogPreview,
        renderTestimonials,
        renderFAQ,
        clearCache: () => Object.keys(SHEETS).forEach(k => localStorage.removeItem(`hh_${k}`)),
    };

})();

document.addEventListener('DOMContentLoaded', HH.init);

/* Allscented theme JS — adapted from v20 preview for WordPress multi-page */
(function(){
    'use strict';

    /* ── Mobile menu ── */
    var menu = document.getElementById('mobile-menu');
    var toggle = document.getElementById('mobile-menu-toggle');
    var icon = document.getElementById('menu-icon');
    if (toggle && menu) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            var isOpen = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            document.body.style.overflow = isOpen ? '' : 'hidden';
            if (icon) icon.textContent = isOpen ? 'menu' : 'close';
        });
    }
    document.querySelectorAll('.mobile-nav-link').forEach(function(link) {
        link.addEventListener('click', function() {
            menu.classList.add('hidden');
            document.body.style.overflow = '';
            if (icon) icon.textContent = 'menu';
        });
    });
    window.addEventListener('scroll', function() {
        if (menu && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
            document.body.style.overflow = '';
            if (icon) icon.textContent = 'menu';
        }
    });

    /* ── Aura mist ── */
    var aura = document.getElementById('aura-mist');
    if (aura && window.matchMedia('(pointer:fine)').matches) {
        var rafId = null;
        document.addEventListener('mousemove', function(e) {
            if (rafId) return;
            rafId = requestAnimationFrame(function() {
                var lastX = (e.clientX / window.innerWidth) * 100;
                var lastY = (e.clientY / window.innerHeight) * 100;
                aura.style.background = 'radial-gradient(circle at ' + lastX + '% ' + lastY + '%, #d7c6fe 0%, transparent 40%), radial-gradient(circle at 80% 20%, #d3e5f1 0%, transparent 40%), radial-gradient(circle at 10% 80%, #f1f9ff 0%, transparent 40%)';
                rafId = null;
            });
        });
    }

    /* ── Filters + pagination (atelier: 6 per page, auto-pagination; archive: no pagination UI) ── */
    function setupFilteredPagination(itemSelector, pagId, perPage) {
        var btns = document.querySelectorAll('.filter-btn');
        var items = document.querySelectorAll(itemSelector);
        if (!btns.length || !items.length) return;
        var pag = pagId ? document.getElementById(pagId) : null;
        var nums = pagId ? document.getElementById(pagId + '-pages') : null;
        var prev = pag ? pag.querySelector('[data-dir="-1"]') : null;
        var next = pag ? pag.querySelector('[data-dir="1"]') : null;
        var currentFilter = 'all';
        var currentPage = 1;
        function visible() {
            var arr = [];
            items.forEach(function(item) {
                var cat = item.getAttribute('data-category');
                if (currentFilter === 'all' || cat === currentFilter) arr.push(item);
            });
            return arr;
        }
        function render() {
            var v = visible();
            var pages = Math.max(1, Math.ceil(v.length / perPage));
            if (currentPage > pages) currentPage = pages;
            items.forEach(function(item) { item.style.display = 'none'; });
            var start = (currentPage - 1) * perPage;
            var end = Math.min(start + perPage, v.length);
            for (var i = start; i < end; i++) v[i].style.display = '';
            if (!pag || !nums) return;
            if (pages < 2) { pag.style.display = 'none'; return; }
            pag.style.display = 'flex';
            nums.innerHTML = '';
            for (var p = 1; p <= pages; p++) {
                (function(pg) {
                    var b = document.createElement('button');
                    b.textContent = pg;
                    b.setAttribute('data-page', pg);
                    var active = pg === currentPage;
                    b.style.cssText = 'padding:6px 13px;border-radius:999px;border:1px solid ' + (active ? 'var(--secondary)' : 'var(--outline-variant)') + ';color:' + (active ? 'var(--secondary)' : 'var(--on-surface-variant)') + ';background:' + (active ? 'color-mix(in srgb,var(--secondary)12%,transparent)' : 'transparent') + ';font-size:12px;cursor:pointer;transition:all .25s';
                    b.addEventListener('click', function() { currentPage = pg; render(); });
                    nums.appendChild(b);
                })(p);
            }
            if (prev) prev.style.color = currentPage === 1 ? 'var(--outline-variant)' : 'var(--on-surface-variant)';
            if (next) next.style.color = currentPage === pages ? 'var(--outline-variant)' : 'var(--on-surface-variant)';
        }
        btns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                btns.forEach(function(b) {
                    b.style.color = 'var(--on-surface-variant)';
                    b.style.borderColor = 'var(--outline-variant)';
                    b.style.background = 'transparent';
                });
                btn.style.color = 'var(--secondary)';
                btn.style.borderColor = 'var(--secondary)';
                btn.style.background = 'color-mix(in srgb,var(--secondary)12%,transparent)';
                currentFilter = btn.getAttribute('data-filter');
                currentPage = 1;
                render();
            });
        });
        if (pag && prev) prev.addEventListener('click', function() { if (currentPage > 1) { currentPage--; render(); } });
        if (pag && next) next.addEventListener('click', function() { var v = visible(); var pages = Math.max(1, Math.ceil(v.length / perPage)); if (currentPage < pages) { currentPage++; render(); } });
        var first = document.querySelector('.filter-btn');
        if (first) first.click();
    }
    setupFilteredPagination('.shop-item', 'atelier-pagination', 6);
    setupFilteredPagination('.archive-item', null, 6);

    /* ── Sample consultation tabs (AI page) ── */
    function initSampleTabs() {
        document.querySelectorAll('.sample-tab').forEach(function(tab) {
            tab.addEventListener('click', function() {
                var sample = this.getAttribute('data-sample');
                document.querySelectorAll('.sample-tab').forEach(function(t) {
                    t.style.borderColor = 'var(--outline-variant)';
                    t.style.color = 'var(--on-surface-variant)';
                    t.style.background = 'transparent';
                });
                this.style.borderColor = 'var(--secondary)';
                this.style.color = 'var(--secondary)';
                this.style.background = 'color-mix(in srgb,var(--secondary)15%,transparent)';
                document.querySelectorAll('.sample-content').forEach(function(c) {
                    c.style.display = 'none';
                });
                var target = document.querySelector('.sample-content[data-sample="' + sample + '"]');
                if (target) target.style.display = 'block';
            });
        });
    }

    /* ── Recommendations pagination (AI page) ── */
    var totalPages = 0, currentPage = 1, pageOffsets = [];
    function initPagination() {
        var pages = document.querySelectorAll('.rec-page');
        totalPages = pages.length;
        var wrapper = document.getElementById('pagination-wrapper');
        var indicator = document.getElementById('page-indicator-wrapper');
        var counter = document.getElementById('page-counter-wrapper');
        pageOffsets = [];
        var totalItems = 0;
        pages.forEach(function(p) {
            var cards = p.querySelectorAll('.aura-glass');
            var count = cards.length;
            pageOffsets.push({ start: totalItems + 1, end: totalItems + count });
            totalItems += count;
        });
        if (totalItems === 0) {
            pageOffsets = [];
            var lastPageCards = pages[totalPages - 1] ? pages[totalPages - 1].querySelectorAll('.aura-glass').length : 3;
            totalItems = (totalPages - 1) * 3 + lastPageCards;
            for (var i = 0; i < totalPages; i++) {
                var start = i * 3 + 1;
                var end = Math.min(start + 2, totalItems);
                pageOffsets.push({ start: start, end: end });
            }
        }
        if (totalPages < 2) {
            if (wrapper) wrapper.style.display = 'none';
            if (indicator) indicator.style.display = 'none';
            if (counter) counter.style.display = 'none';
            return;
        }
        if (counter) counter.style.display = 'block';
        var totalEl = document.getElementById('page-counter-total');
        if (totalEl) totalEl.textContent = totalItems;
        var dotsContainer = document.getElementById('pagination-dots');
        if (!dotsContainer) return;
        dotsContainer.innerHTML = '';
        for (var i = 1; i <= totalPages; i++) {
            var dot = document.createElement('span');
            dot.className = 'page-dot' + (i === 1 ? ' active' : '');
            dot.style.cssText = 'width:8px;height:8px;border-radius:999px;background:' + (i === 1 ? 'var(--secondary)' : 'var(--outline-variant)') + ';cursor:pointer;transition:all .3s';
            dot.setAttribute('data-page', i);
            dot.onclick = (function(p) { return function() { window.goToPage(p); }; })(i);
            dotsContainer.appendChild(dot);
        }
        var tp = document.getElementById('total-pages');
        if (tp) tp.textContent = totalPages;
        updatePageCounter(1);
    }
    window.changePage = function(delta) {
        var newPage = currentPage + delta;
        if (newPage < 1 || newPage > totalPages) return;
        window.goToPage(newPage);
    };
    function updatePageCounter(page) {
        var start = document.getElementById('page-counter-start');
        var end = document.getElementById('page-counter-end');
        if (!start || !end) return;
        var offset = pageOffsets[page - 1];
        if (offset) {
            start.textContent = offset.start;
            end.textContent = offset.end;
        } else {
            start.textContent = ((page - 1) * 3 + 1);
            var total = parseInt((document.getElementById('page-counter-total') || {}).textContent || '0');
            var pageEnd = page * 3;
            if (pageEnd > total) pageEnd = total;
            end.textContent = pageEnd;
        }
    }
    window.goToPage = function(page) {
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        document.querySelectorAll('.rec-page').forEach(function(el) { el.style.display = 'none'; });
        var target = document.querySelector('.rec-page[data-page="' + page + '"]');
        if (target) target.style.display = 'grid';
        document.querySelectorAll('.page-dot').forEach(function(dot) {
            var dp = parseInt(dot.getAttribute('data-page'));
            if (dp === page) {
                dot.style.background = 'var(--secondary)';
                dot.style.transform = 'scale(1.2)';
            } else {
                dot.style.background = 'var(--outline-variant)';
                dot.style.transform = 'scale(1)';
            }
        });
        var indicator = document.getElementById('page-indicator');
        if (indicator) indicator.textContent = page;
        updatePageCounter(page);
    };

    /* ── Init ── */
    /* ── Journal cover inline editor ── */
    function initCoverEditor() {
        if (typeof allscented_ajax === 'undefined') return;
        var coverBtn = document.querySelector('.journal-edit-cover');
        if (!coverBtn) return;
        document.querySelectorAll('.journal-edit-cover').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var postId = btn.getAttribute('data-post-id');
                if (!postId) return;
                var frame = wp.media({
                    title: allscented_ajax.strings.select_cover,
                    button: { text: allscented_ajax.strings.use_image },
                    library: { type: 'image' },
                    multiple: false
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    var attachmentId = attachment.id;
                    btn.textContent = '...';
                    btn.style.opacity = '0.6';
                    var formData = new FormData();
                    formData.append('action', 'allscented_update_cover');
                    formData.append('nonce', allscented_ajax.nonce);
                    formData.append('post_id', postId);
                    formData.append('attachment_id', attachmentId);
                    fetch(allscented_ajax.ajax_url, {
                        method: 'POST',
                        body: formData,
                        credentials: 'same-origin'
                    }).then(function(r) { return r.json(); }).then(function(data) {
                        btn.textContent = '编辑封面';
                        btn.style.opacity = '';
                        if (!data.success) {
                            alert(data.data || 'Failed to update cover.');
                            return;
                        }
                        var cover = btn.closest('.journal-cover, .journal-hero-cover');
                        if (!cover) return;
                        var img = cover.querySelector('img');
                        if (img) {
                            img.src = data.data.url;
                            img.removeAttribute('srcset');
                        } else {
                            var fallback = cover.querySelector('.journal-cover-img');
                            if (fallback && fallback.tagName === 'DIV') {
                                var newImg = document.createElement('img');
                                newImg.src = data.data.url;
                                var card = cover.closest('article');
                                newImg.alt = card ? card.querySelector('h3').textContent : '';
                                newImg.className = 'journal-cover-img';
                                newImg.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .4s ease;';
                                fallback.parentNode.replaceChild(newImg, fallback);
                            } else if (cover.classList.contains('journal-hero-cover')) {
                                var ring = cover.querySelector('.ring');
                                var cap = cover.querySelector('.cap');
                                if (ring) ring.remove();
                                if (cap) cap.remove();
                                var heroImg = document.createElement('img');
                                heroImg.src = data.data.url;
                                var heroText = cover.closest('.journal-hero');
                                heroImg.alt = heroText ? heroText.querySelector('h2').textContent : '';
                                heroImg.className = 'journal-hero-img';
                                heroImg.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;';
                                cover.insertBefore(heroImg, cover.firstChild);
                            }
                        }
                    }).catch(function(err) {
                        btn.textContent = '编辑封面';
                        btn.style.opacity = '';
                        alert('Network error: ' + err.message);
                    });
                });
                frame.open();
            });
        });
    }


    /* ── Product gallery / video switching ── */
    function initProductMedia() {
        var media = document.getElementById('product-main-media');
        if (!media) return;
        var image = document.getElementById('product-main-image');
        var video = document.getElementById('product-main-video');
        var toggle = document.getElementById('product-video-toggle');
        function showVideo() {
            if (!video) return;
            if (image) image.classList.add('product-media-hidden');
            video.classList.remove('product-media-hidden');
            if (toggle) toggle.classList.add('product-video-toggle-active');
            if (video.paused) {
                try { var playPromise = video.play(); if (playPromise && playPromise.catch) playPromise.catch(function(){}); } catch (err) {}
            }
        }
        function showImage(src, alt) {
            if (image && src) {
                image.src = src;
                if (alt) image.alt = alt;
                image.classList.remove('product-media-hidden');
            }
            if (video) video.classList.add('product-media-hidden');
            if (toggle) toggle.classList.remove('product-video-toggle-active');
        }
        document.addEventListener('click', function(e) {
            var thumb = e.target.closest ? e.target.closest('.product-thumbnails a, .product-thumbnails img, .flex-control-thumbs a, .flex-control-thumbs img, .product-thumb, .product-thumb a') : null;
            if (!thumb) return;
            var link = thumb.closest('a[href]');
            if (!link || !link.getAttribute('href')) return;
            e.preventDefault();
            var alt = thumb.getAttribute('alt') || '';
            showImage(link.getAttribute('href'), alt);
            var thumbs = document.querySelectorAll('.product-thumbnails .woocommerce-product-gallery__image, .product-thumbnails .flex-control-thumbs li, .product-thumb');
            var active = link.closest('.woocommerce-product-gallery__image') || link.closest('li') || thumb;
            thumbs.forEach(function(el) {
                el.classList.remove('product-thumb-active');
            });
            if (active) active.classList.add('product-thumb-active');
        });
        if (toggle) toggle.addEventListener('click', showVideo);
    }

    document.addEventListener('DOMContentLoaded', function() {
        /* Scroll reveal */
        var revealEls = document.querySelectorAll('.scroll-reveal');
        if (revealEls.length) {
            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0 });
                revealEls.forEach(function(el) { observer.observe(el); });
            } else {
                revealEls.forEach(function(el) { el.classList.add('visible'); });
            }
            setTimeout(function() {
                revealEls.forEach(function(el) {
                    if (!el.classList.contains('visible')) {
                        el.classList.add('visible');
                    }
                });
            }, 3000);
        }
        try {
            initPagination();
        } catch (err) {
            console.error('initPagination failed:', err);
        }
        try {
            initSampleTabs();
        } catch (err) {
            console.error('initSampleTabs failed:', err);
        }
        initCoverEditor();
        try {
            initProductMedia();
        } catch (err) {
            console.error('initProductMedia failed:', err);
        }
    });
})();

/* ── AI Synthesis v2.0 conversation engine ── */
var AIChatEngine = (function () {
    'use strict';

    var state = {
        personaId: null,
        config: null,
        products: [],
        affiliates: [],
        round: 0,
        maxRounds: 5,
        answers: [],
        slotValues: {},
        busy: false
    };

    var els = {};
    var cached = { ready: false };

    function byId(id) {
        return document.getElementById(id);
    }

    function readJson(id) {
        var node = byId(id);
        if (!node) return null;
        try {
            return JSON.parse(node.textContent || 'null');
        } catch (err) {
            return null;
        }
    }

    function loadData() {
        if (cached.ready) return;
        cached.defaults = readJson('ai-engine-defaults') || {};
        cached.products = readJson('ai-wc-products') || [];
        cached.affiliates = readJson('ai-affiliates') || [];
        cached.ready = true;
    }

    function bind() {
        els.section = byId('ai-chat-section');
        els.summarySection = byId('ai-summary-section');
        els.bubbles = byId('ai-chat-bubbles');
        els.options = byId('ai-chat-options');
        els.headerAvatar = byId('ai-chat-avatar');
        els.headerName = byId('ai-chat-name');
        els.headerRole = byId('ai-chat-role');
        els.progress = byId('ai-chat-progress');
        els.summaryCard = byId('ai-summary-card');
    }

    function createEl(tag, className, text) {
        var el = document.createElement(tag);
        if (className) el.className = className;
        if (text !== undefined && text !== null) el.textContent = text;
        return el;
    }

    function scrollToBottom() {
        if (els.bubbles) els.bubbles.scrollTop = els.bubbles.scrollHeight;
    }

    function scrollToChat() {
        if (els.section && els.section.scrollIntoView) {
            els.section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function clearOptions() {
        if (els.options) els.options.innerHTML = '';
    }

    function disableOptions() {
        if (!els.options) return;
        var buttons = els.options.querySelectorAll('button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].disabled = true;
        }
    }

    function normalizeOption(option) {
        if (typeof option === 'string') {
            var key = option.replace(/\s*\(.*$/, '').trim().toLowerCase();
            return { label: option, key: key };
        }
        var label = option && option.label ? option.label : '';
        return {
            label: label,
            key: (option && option.key) || label.replace(/\s*\(.*$/, '').trim().toLowerCase()
        };
    }

    function toArray(value) {
        if (Array.isArray(value)) return value;
        if (!value) return [];
        return String(value).split(',').map(function (item) {
            return String(item).trim();
        }).filter(Boolean);
    }

    function renderProgress() {
        if (!els.progress) return;
        var label = state.round < state.maxRounds
            ? 'Round ' + (state.round + 1) + '/' + state.maxRounds
            : 'SYNTHESIS READY';
        els.progress.textContent = label;
        els.progress.setAttribute('aria-label', label);
    }

    function setHeader() {
        if (!els.headerName || !state.config) return;
        els.headerName.textContent = state.config.name || 'AI Guide';
        els.headerRole.textContent = state.config.role || 'Professional guide';
        if (!els.headerAvatar) return;
        els.headerAvatar.innerHTML = '';
        if (state.config.avatar) {
            var img = document.createElement('img');
            img.src = state.config.avatar;
            img.alt = '';
            els.headerAvatar.appendChild(img);
        } else {
            var icon = document.createElement('span');
            icon.className = 'material-symbols-outlined';
            icon.textContent = state.config.icon || 'chat';
            els.headerAvatar.appendChild(icon);
        }
    }

    function renderUser(text) {
        var row = createEl('div', 'ai-chat-row ai-chat-row-user');
        var bubble = createEl('div', 'ai-chat-bubble ai-chat-bubble-user', text);
        row.appendChild(bubble);
        els.bubbles.appendChild(row);
        scrollToBottom();
    }

    function addAiMessage(text, knowledge, animate) {
        return new Promise(function (resolve) {
            var row = createEl('div', 'ai-chat-row ai-chat-row-ai');
            var bubble = createEl('div', 'ai-chat-bubble ai-chat-bubble-ai');
            var body = createEl('div', 'ai-chat-bubble-text');
            bubble.appendChild(body);
            row.appendChild(bubble);
            els.bubbles.appendChild(row);
            scrollToBottom();

            function finish() {
                if (knowledge) {
                    var card = createEl('div', 'ai-knowledge-card');
                    var label = createEl('span', 'ai-knowledge-label', 'PROFESSIONAL NOTE');
                    var quote = createEl('blockquote', '', knowledge);
                    card.appendChild(label);
                    card.appendChild(quote);
                    bubble.appendChild(card);
                    scrollToBottom();
                }
                resolve();
            }

            if (!animate || !text) {
                body.textContent = text || '';
                finish();
                return;
            }

            var duration = text.length > 220 ? 800 : 500;
            var step = Math.max(5, Math.floor(duration / Math.max(1, text.length)));
            var index = 0;
            var timer = setInterval(function () {
                index += 1;
                body.textContent = text.slice(0, index);
                scrollToBottom();
                if (index >= text.length) {
                    clearInterval(timer);
                    finish();
                }
            }, step);
        });
    }

    function renderOptions(options) {
        clearOptions();
        if (!els.options || !Array.isArray(options)) return;
        options.slice(0, 7).forEach(function (option, index) {
            var normalized = normalizeOption(option);
            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'ai-chat-option';
            button.textContent = normalized.label;
            button.setAttribute('data-option', index);
            button.addEventListener('click', function () {
                handleAnswer(option);
            });
            els.options.appendChild(button);
        });
    }

    function renderGreeting() {
        state.busy = true;
        clearOptions();
        renderProgress();
        addAiMessage(state.config.greeting, null, true).then(function () {
            state.busy = false;
            renderRound();
        });
    }

    function renderRound() {
        if (!state.config) return;
        var round = state.config.rounds[state.round];
        if (!round) {
            endConversation();
            return;
        }
        renderProgress();
        addAiMessage(round.question, null, true).then(function () {
            renderOptions(round.options);
            scrollToBottom();
        });
    }

    function getKnowledge(round, normalized) {
        var base = round && round.knowledge ? round.knowledge : '';
        if (state.config.meanings && state.config.meanings[normalized.label]) {
            base = state.config.meanings[normalized.label] + ' ' + base;
        }
        return base.trim();
    }

    function getTransition(normalized) {
        var persona = state.config ? state.config.id : '';
        if (persona === 'luna') {
            return 'Logged: ' + normalized.label + '. I am narrowing the aromatherapy shortlist to match that intake signal.';
        }
        if (persona === 'echo') {
            return 'The ' + normalized.label + ' is reflected in the reading. I am translating it into a scent direction, not a prediction.';
        }
        return 'Constraint logged: ' + normalized.label + '. That changes the diffusion and intensity profile.';
    }

    function handleAnswer(option) {
        if (state.busy) return;
        state.busy = true;
        var normalized = normalizeOption(option);
        state.answers.push({ label: normalized.label, key: normalized.key });
        if (state.config.slots && state.config.slots[state.round]) {
            state.slotValues[state.config.slots[state.round]] = normalized.label;
        }
        renderUser(normalized.label);
        disableOptions();
        var round = state.config.rounds[state.round];
        var knowledge = getKnowledge(round, normalized);
        addAiMessage(getTransition(normalized), knowledge, true).then(function () {
            state.round += 1;
            renderProgress();
            if (state.round >= state.maxRounds) {
                endConversation();
            } else {
                state.busy = false;
                renderRound();
            }
        });
    }

    function endConversation() {
        addAiMessage(state.config.closing || 'Your synthesis is ready.', null, true).then(function () {
            state.busy = false;
            renderSummary();
        });
    }

    function matchedKeywords() {
        var selected = state.answers.map(function (answer) {
            return (answer.label + ' ' + answer.key).toLowerCase();
        }).join(' ');
        var found = [];
        (state.config.mappings || []).forEach(function (mapping) {
            toArray(mapping.keywords).forEach(function (keyword) {
                var kw = String(keyword).toLowerCase();
                if (kw && selected.indexOf(kw) !== -1 && found.indexOf(kw) === -1) {
                    found.push(kw);
                }
            });
        });
        return found;
    }

    function computeSynthesis() {
        var completeness = Math.min(state.answers.length, state.maxRounds) / state.maxRounds;
        var matchCount = Math.min(matchedKeywords().length, 10);
        var score = Math.round(82 + completeness * 8 + matchCount * 0.9);
        return Math.min(98, Math.max(72, score));
    }

    function fillTemplate(template) {
        var out = String(template || '');
        Object.keys(state.slotValues).forEach(function (key) {
            out = out.split('{' + key + '}').join(state.slotValues[key] || 'your selection');
        });
        return out;
    }

    function productKey(product) {
        return String(product.slug || product.name || product.id || '');
    }

    function bumpScore(scores, reasons, product, points, reason) {
        var key = productKey(product);
        if (!key) return;
        scores[key] = (scores[key] || 0) + points;
        if (reason && !reasons[key]) reasons[key] = reason;
    }

    function recommendProducts() {
        var selected = state.answers.map(function (answer) {
            return (answer.label + ' ' + answer.key).toLowerCase();
        }).join(' ');
        var scores = {};
        var reasons = {};

        (state.products || []).forEach(function (product) {
            bumpScore(scores, reasons, product, 0, '');
        });

        (state.config.mappings || []).forEach(function (mapping) {
            var keywords = toArray(mapping.keywords);
            var matched = keywords.some(function (keyword) {
                var kw = String(keyword).toLowerCase();
                return kw && selected.indexOf(kw) !== -1;
            });
            if (!matched) return;
            var categoryTargets = toArray(mapping.categories);
            var productTargets = toArray(mapping.products);
            (state.products || []).forEach(function (product) {
                var hay = ((product.name || '') + ' ' + (product.slug || '') + ' ' + (product.excerpt || '') + ' ' + (product.categories || []).join(' ')).toLowerCase();
                var refMatch = productTargets.some(function (target) {
                    return hay.indexOf(String(target).toLowerCase()) !== -1;
                });
                var catMatch = categoryTargets.some(function (category) {
                    return product.cat === category || (product.categories || []).indexOf(category) !== -1;
                });
                if (refMatch) {
                    bumpScore(scores, reasons, product, 5, mapping.reason || '');
                } else if (catMatch) {
                    bumpScore(scores, reasons, product, 2, mapping.reason || '');
                }
            });
        });

        (state.products || []).forEach(function (product) {
            var hay = ((product.name || '') + ' ' + (product.slug || '') + ' ' + (product.excerpt || '') + ' ' + (product.categories || []).join(' ')).toLowerCase();
            selected.split(/\s+/).forEach(function (word) {
                if (word.length > 2 && hay.indexOf(word) !== -1) {
                    bumpScore(scores, reasons, product, 1, 'Your choices include ' + word + '; this product matches that cue.');
                }
            });
        });

        var sorted = (state.products || []).slice().sort(function (a, b) {
            return (scores[productKey(b)] || 0) - (scores[productKey(a)] || 0);
        });

        var top = sorted.filter(function (product) {
            return (scores[productKey(product)] || 0) > 0;
        }).slice(0, 3);

        if (top.length) {
            return top.map(function (product) {
                return Object.assign({}, product, {
                    reason: reasons[productKey(product)] || (state.config.fallback_reason || 'Best available match for your persona.')
                });
            });
        }

        var categories = state.config.fallback_categories || [];
        var fallback = sorted.filter(function (product) {
            return categories.indexOf(product.cat) !== -1;
        }).slice(0, 3);
        if (!fallback.length) fallback = sorted.slice(0, 3);
        return fallback.map(function (product) {
            return Object.assign({}, product, {
                reason: state.config.fallback_reason || 'Best available match for your persona.'
            });
        });
    }

    function recommendAffiliates(products) {
        var siteNames = products.map(function (product) {
            return String(product.name || '').toLowerCase();
        });
        return (state.affiliates || []).filter(function (affiliate) {
            if (!affiliate || (!affiliate.name && !affiliate.url)) return false;
            var name = String(affiliate.name || '').toLowerCase();
            return name === '' || siteNames.indexOf(name) === -1;
        }).slice(0, 2);
    }

    function buildProductCard(product) {
        var card = createEl('article', 'ai-recommendation-card');
        if (product.img) {
            var media = createEl('div', 'ai-recommendation-media');
            var img = createEl('img', '');
            img.src = product.img;
            img.alt = product.name || '';
            img.loading = 'lazy';
            media.appendChild(img);
            card.appendChild(media);
        }
        var body = createEl('div', 'ai-recommendation-body');
        body.appendChild(createEl('h4', 'ai-recommendation-name', product.name || 'Product'));
        if (product.price) body.appendChild(createEl('span', 'ai-recommendation-price', product.price));
        if (product.reason) body.appendChild(createEl('p', 'ai-recommendation-reason', product.reason));
        if (product.link) {
            var link = createEl('a', 'ai-recommendation-link', 'View Product →');
            link.href = product.link;
            body.appendChild(link);
        } else {
            body.appendChild(createEl('span', 'ai-coming-soon-inline', 'Coming Soon'));
        }
        card.appendChild(body);
        return card;
    }

    function buildProductSection(products) {
        var section = createEl('section', 'ai-recommendation-section');
        section.appendChild(createEl('h3', 'ai-recommendation-heading', 'ON-SITE RECOMMENDATIONS'));
        var grid = createEl('div', 'ai-products-grid');
        if (!products.length) {
            grid.appendChild(createEl('div', 'ai-coming-soon', 'Coming Soon — new products are on the way.'));
        } else {
            products.forEach(function (product) {
                grid.appendChild(buildProductCard(product));
            });
        }
        section.appendChild(grid);
        return section;
    }

    function buildAffiliateCard(affiliate) {
        var card = createEl('article', 'ai-affiliate-card');
        if (affiliate.image) {
            var media = createEl('div', 'ai-affiliate-media');
            var img = createEl('img', '');
            img.src = affiliate.image;
            img.alt = affiliate.name || 'Affiliate product';
            img.loading = 'lazy';
            media.appendChild(img);
            card.appendChild(media);
        }
        var body = createEl('div', 'ai-affiliate-body');
        body.appendChild(createEl('h4', 'ai-affiliate-name', affiliate.name || 'Affiliate pick'));
        if (affiliate.price) body.appendChild(createEl('span', 'ai-affiliate-price', affiliate.price));
        if (affiliate.note) body.appendChild(createEl('p', 'ai-affiliate-note', affiliate.note));
        var link = createEl('a', 'ai-affiliate-link', 'View on Amazon →');
        link.href = affiliate.url || '#';
        link.target = '_blank';
        link.rel = 'noopener nofollow';
        body.appendChild(link);
        card.appendChild(body);
        return card;
    }

    function buildAffiliateSection(affiliates) {
        var section = createEl('section', 'ai-affiliate-section');
        section.appendChild(createEl('h3', 'ai-affiliate-heading', 'AFFILIATE PICKS'));
        var grid = createEl('div', 'ai-affiliate-grid');
        if (!affiliates.length) {
            var empty = createEl('div', 'ai-affiliate-empty');
            var icon = createEl('span', 'material-symbols-outlined ai-affiliate-empty-icon', 'shopping_bag');
            empty.appendChild(icon);
            empty.appendChild(createEl('p', '', 'Curated picks are on their way — check back soon'));
            grid.appendChild(empty);
        } else {
            affiliates.forEach(function (affiliate) {
                grid.appendChild(buildAffiliateCard(affiliate));
            });
        }
        section.appendChild(grid);
        return section;
    }

    function renderSummary() {
        if (!els.summaryCard) return;
        els.summaryCard.innerHTML = '';
        els.summarySection.style.display = 'block';

        var products = recommendProducts();
        var affiliates = recommendAffiliates(products);
        var card = createEl('div', 'ai-summary-inner');
        var top = createEl('div', 'ai-summary-top');
        top.appendChild(createEl('span', 'ai-summary-eyebrow', 'YOUR PERSONALIZED SYNTHESIS'));
        top.appendChild(createEl('div', 'ai-summary-pct', computeSynthesis() + '% SYNTHESIS'));
        top.appendChild(createEl('h2', 'ai-summary-title', state.config.name));
        card.appendChild(top);

        card.appendChild(createEl('p', 'ai-summary-copy', fillTemplate(state.config.summary_template)));

        var why = createEl('div', 'ai-why-list');
        why.appendChild(createEl('h3', 'ai-why-title', 'Why this match'));
        var whyList = createEl('ul', '');
        (state.config.why_lines || []).slice(0, 3).forEach(function (line) {
            whyList.appendChild(createEl('li', '', fillTemplate(line)));
        });
        why.appendChild(whyList);
        card.appendChild(why);

        if (state.config.safety_note) {
            card.appendChild(createEl('p', 'ai-safety-note', state.config.safety_note));
        }

        card.appendChild(buildProductSection(products));
        card.appendChild(buildAffiliateSection(affiliates));

        var actions = createEl('div', 'ai-summary-actions');
        var restart = createEl('button', 'ai-start-over', 'Start Over');
        restart.type = 'button';
        restart.addEventListener('click', function () {
            resetChat();
        });
        actions.appendChild(restart);
        card.appendChild(actions);

        els.summaryCard.appendChild(card);
        if (els.summarySection.scrollIntoView) {
            els.summarySection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function init(personaId) {
        loadData();
        if (!cached.defaults[personaId]) return;
        if (!els.bubbles) bind();
        if (!els.bubbles) return;

        state = {
            personaId: personaId,
            config: cached.defaults[personaId],
            products: cached.products,
            affiliates: cached.affiliates,
            round: 0,
            maxRounds: 5,
            answers: [],
            slotValues: {},
            busy: false
        };

        els.bubbles.innerHTML = '';
        clearOptions();
        els.summaryCard.innerHTML = '';
        els.summarySection.style.display = 'none';
        els.section.style.display = 'block';
        setHeader();
        renderProgress();
        scrollToChat();
        renderGreeting();
    }

    function reset() {
        state = {
            personaId: null,
            config: null,
            products: [],
            affiliates: [],
            round: 0,
            maxRounds: 5,
            answers: [],
            slotValues: {},
            busy: false
        };
        if (els.bubbles) els.bubbles.innerHTML = '';
        clearOptions();
        if (els.summaryCard) els.summaryCard.innerHTML = '';
        if (els.section) els.section.style.display = 'none';
        if (els.summarySection) els.summarySection.style.display = 'none';
        if (els.progress) els.progress.textContent = '';
        var cards = document.querySelector('.char-cards-grid');
        if (cards && cards.scrollIntoView) {
            cards.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    return {
        init: init,
        reset: reset,
        bind: bind
    };
})();

window.startChat = function (personaId) {
    AIChatEngine.init(personaId);
};

window.resetChat = function () {
    AIChatEngine.reset();
};

document.addEventListener('DOMContentLoaded', function () {
    AIChatEngine.bind();
});

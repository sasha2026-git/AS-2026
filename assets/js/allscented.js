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

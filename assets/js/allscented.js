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

    /* ── Filters (per page: atelier .shop-item / archive .archive-item) ── */
    function setupFilters(itemSelector) {
        var btns = document.querySelectorAll('.filter-btn');
        var items = document.querySelectorAll(itemSelector);
        if (!btns.length || !items.length) return;
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
                var f = btn.getAttribute('data-filter');
                items.forEach(function(item) {
                    var cat = item.getAttribute('data-category');
                    item.style.display = (f === 'all' || cat === f) ? '' : 'none';
                });
            });
        });
        var first = document.querySelector('.filter-btn');
        if (first) first.click();
    }
    setupFilters('.shop-item');
    setupFilters('.archive-item');

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
    document.addEventListener('DOMContentLoaded', function() {
        initPagination();
        initSampleTabs();
        /* Scroll reveal */
        var revealEls = document.querySelectorAll('.scroll-reveal');
        if (revealEls.length && 'IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            revealEls.forEach(function(el) { observer.observe(el); });
        }
    });
})();

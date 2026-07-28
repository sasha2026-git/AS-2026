/**
 * Allscented — Digital Romanticism
 * Micro-interactions & UI Behaviors
 */

(function() {
    'use strict';

    /**
     * Scroll Reveal
     */
    function initScrollReveal() {
        const reveals = document.querySelectorAll('.reveal');
        if (!reveals.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                }
            });
        }, { threshold: 0.1 });

        reveals.forEach(el => observer.observe(el));
    }

    /**
     * Parallax Effect
     */
    function initParallax() {
        const parallaxEls = document.querySelectorAll('.parallax-inner');
        if (!parallaxEls.length) return;

        window.addEventListener('scroll', () => {
            const scrollY = window.pageYOffset;
            parallaxEls.forEach(el => {
                const speed = parseFloat(el.dataset.speed) || 0.3;
                const rect = el.getBoundingClientRect();
                const centerY = rect.top + rect.height / 2;
                if (centerY < window.innerHeight && rect.bottom > 0) {
                    el.style.transform = `translateY(${scrollY * speed * 0.1}px)`;
                }
            });
        }, { passive: true });
    }

    /**
     * Radar Chart Drawing
     */
    function initRadarChart(canvasId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        // Default values — can be overridden via data attributes
        const labels = ['Floral', 'Spicy', 'Woody', 'Fresh', 'Mineral', 'Gourmand'];
        const values = canvas.dataset.values
            ? canvas.dataset.values.split(',').map(Number)
            : [60, 40, 50, 90, 85, 30];
        const colorSecondary = getComputedStyle(document.documentElement)
            .getPropertyValue('--color-secondary').trim() || '#645787';

        function drawRadar() {
            const size = canvas.width;
            const center = size / 2;
            const radius = size * 0.4;
            const dpr = window.devicePixelRatio || 1;

            // Handle retina
            if (canvas.width !== canvas.offsetWidth * dpr) {
                canvas.width = canvas.offsetWidth * dpr;
                canvas.height = canvas.offsetHeight * dpr;
                ctx.scale(dpr, dpr);
            }

            ctx.clearRect(0, 0, canvas.offsetWidth, canvas.offsetHeight);

            const w = canvas.offsetWidth;
            const c = w / 2;
            const r = w * 0.4;

            // Background circles
            ctx.strokeStyle = 'rgba(119, 119, 123, 0.1)';
            for (let i = 1; i <= 5; i++) {
                ctx.beginPath();
                ctx.arc(c, c, (r / 5) * i, 0, Math.PI * 2);
                ctx.stroke();
            }

            // Spokes + Labels
            labels.forEach((label, i) => {
                const angle = (Math.PI * 2 * i) / labels.length - Math.PI / 2;
                const x = c + Math.cos(angle) * r;
                const y = c + Math.sin(angle) * r;

                ctx.beginPath();
                ctx.moveTo(c, c);
                ctx.lineTo(x, y);
                ctx.stroke();

                // Labels
                ctx.fillStyle = '#46464b';
                ctx.font = '600 10px Hanken Grotesk';
                ctx.textAlign = 'center';
                const lx = c + Math.cos(angle) * (r + 25);
                const ly = c + Math.sin(angle) * (r + 25);
                ctx.fillText(label.toUpperCase(), lx, ly);
            });

            // Data polygon
            ctx.beginPath();
            ctx.strokeStyle = colorSecondary;
            ctx.fillStyle = 'rgba(216, 199, 255, 0.4)';
            ctx.lineWidth = 2;

            const scaled = values.map(v => v > 1 ? v : v * 100); // normalize 0-100
            scaled.forEach((val, i) => {
                const angle = (Math.PI * 2 * i) / labels.length - Math.PI / 2;
                const x = c + Math.cos(angle) * (r * (val / 100));
                const y = c + Math.sin(angle) * (r * (val / 100));

                if (i === 0) ctx.moveTo(x, y);
                else ctx.lineTo(x, y);
            });
            ctx.closePath();
            ctx.fill();
            ctx.stroke();

            // Data points
            scaled.forEach((val, i) => {
                const angle = (Math.PI * 2 * i) / labels.length - Math.PI / 2;
                const x = c + Math.cos(angle) * (r * (val / 100));
                const y = c + Math.sin(angle) * (r * (val / 100));

                ctx.beginPath();
                ctx.fillStyle = colorSecondary;
                ctx.arc(x, y, 4, 0, Math.PI * 2);
                ctx.fill();
            });
        }

        drawRadar();

        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(drawRadar, 150);
        });
    }

    /**
     * Micro-interactions: Click feedback
     */
    function initMicroInteractions() {
        document.querySelectorAll('.click-feedback, .btn-primary, .btn-outline')
            .forEach(el => {
                el.addEventListener('mousedown', () => el.classList.add('scale-95'));
                el.addEventListener('mouseup', () => el.classList.remove('scale-95'));
                el.addEventListener('mouseleave', () => el.classList.remove('scale-95'));

                // Touch support
                el.addEventListener('touchstart', () => el.classList.add('scale-95'), { passive: true });
                el.addEventListener('touchend', () => el.classList.remove('scale-95'));
            });

        // Comparison card click
        document.querySelectorAll('.compare-card-click').forEach(el => {
            el.addEventListener('click', function() {
                this.classList.toggle('compare-expanded');
            });
        });
    }

    /**
     * Scent Quiz Steps
     */
    function initQuizSteps() {
        const quiz = document.querySelector('.scent-quiz-form');
        if (!quiz) return;

        const steps = quiz.querySelectorAll('.quiz-step');
        const nextBtns = quiz.querySelectorAll('.btn-next');
        const prevBtns = quiz.querySelectorAll('.btn-prev');
        let currentStep = 0;

        function showStep(index) {
            steps.forEach((s, i) => {
                s.classList.toggle('active', i === index);
            });
            currentStep = index;
        }

        nextBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentStep < steps.length - 1) {
                    showStep(currentStep + 1);
                } else {
                    // Submit quiz
                    quiz.dispatchEvent(new Event('quiz-complete'));
                }
            });
        });

        prevBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentStep > 0) {
                    showStep(currentStep - 1);
                }
            });
        });

        showStep(0);
    }

    /**
     * Mobile Nav Toggle
     */
    function initMobileNav() {
        const toggle = document.querySelector('.mobile-nav-toggle');
        const panel = document.querySelector('.mobile-nav-panel');
        if (!toggle || !panel) return;

        toggle.addEventListener('click', () => {
            const isVisible = panel.style.display === 'block';
            panel.style.display = isVisible ? 'none' : 'block';
            toggle.classList.toggle('is-active');
        });

        // Close on link click
        panel.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                panel.style.display = 'none';
                toggle.classList.remove('is-active');
            });
        });
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }

    /**
     * Animate counters on scroll
     */
    function initCounters() {
        document.querySelectorAll('.counter').forEach(counter => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = parseInt(counter.dataset.target) || 0;
                        animateCounter(counter, target);
                        observer.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(counter);
        });
    }

    function animateCounter(el, target) {
        let current = 0;
        const step = Math.ceil(target / 60);
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = current;
        }, 16);
    }

    // =========================================
    // Initialize on DOM ready
    // =========================================
    document.addEventListener('DOMContentLoaded', function() {
        initScrollReveal();
        initParallax();
        initRadarChart('scentRadar');
        initMicroInteractions();
        initQuizSteps();
        initMobileNav();
        initSmoothScroll();
        initCounters();
    });

})();

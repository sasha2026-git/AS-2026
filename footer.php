<?php wp_footer(); ?>

<!-- Scroll Reveal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Scroll Reveal ---
    const revealElements = document.querySelectorAll('.scroll-reveal');
    if (revealElements.length > 0) {
        const revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
        );
        revealElements.forEach(el => revealObserver.observe(el));
    }

    // --- Mobile Menu Toggle ---
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            if (menuIcon) {
                menuIcon.textContent = isOpen ? 'menu' : 'close';
            }
        });
        // Close on link click
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                if (menuIcon) menuIcon.textContent = 'menu';
            });
        });
        // Close on outside click
        document.addEventListener('click', function(e) {
            if (!mobileMenu.classList.contains('hidden') &&
                !mobileMenu.contains(e.target) &&
                !menuToggle.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                if (menuIcon) menuIcon.textContent = 'menu';
            }
        });
    }

    // --- Aura Mist Mouse Tracking (optional enhancement) ---
    const auraMist = document.getElementById('aura-mist');
    if (auraMist) {
        document.addEventListener('mousemove', function(e) {
            const x = (e.clientX / window.innerWidth) * 100;
            const y = (e.clientY / window.innerHeight) * 100;
            auraMist.style.setProperty('--mouse-x', x + '%');
            auraMist.style.setProperty('--mouse-y', y + '%');
        });
    }
});
</script>

<!-- Footer -->
<footer style="border-top:1px solid rgba(199,198,203,0.1);padding:48px 0 24px;margin-top:64px;">
    <div class="container-max px-margin-desktop">
        <div class="flex flex-col md:flex-row justify-between items-start gap-8 mb-12">
            <div>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="font-headline-md text-headline-md tracking-tighter" style="text-decoration:none;color:var(--on-surface);">
                    All<span style="color:var(--secondary);">scented</span>
                </a>
                <p class="font-body-md text-body-md text-on-surface-variant mt-4 max-w-sm">Where memory becomes molecule. AI-powered fragrance curation, crafted for your digital aura.</p>
            </div>
            <div class="flex gap-12">
                <div>
                    <span class="font-label-caps text-label-caps text-on-surface font-semibold mb-4 block" style="margin-bottom:16px;">EXPLORE</span>
                    <?php
                    $footer_links = array(
                        'Discover' => home_url('/'),
                        'The Atelier' => home_url('/the-atelier/'),
                        'AI Synthesis' => home_url('/ai-synthesis/'),
                        'Archive' => home_url('/archive/'),
                    );
                    foreach ($footer_links as $label => $url) : ?>
                        <a href="<?php echo esc_url($url); ?>" class="font-body-md text-body-md text-on-surface-variant block mb-2 transition-colors hover:text-secondary" style="text-decoration:none;"><?php echo esc_html($label); ?></a>
                    <?php endforeach; ?>
                </div>
                <div>
                    <span class="font-label-caps text-label-caps text-on-surface font-semibold mb-4 block" style="margin-bottom:16px;">CONNECT</span>
                    <?php
                    $social_links = array(
                        'Instagram' => '#',
                        'Twitter' => '#',
                        'Contact' => '#',
                    );
                    foreach ($social_links as $label => $url) : ?>
                        <a href="<?php echo esc_url($url); ?>" class="font-body-md text-body-md text-on-surface-variant block mb-2 transition-colors hover:text-secondary" style="text-decoration:none;"><?php echo esc_html($label); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div style="border-top:1px solid rgba(199,198,203,0.1);padding-top:24px;">
            <p class="font-body-md text-body-md text-on-surface-variant text-center">&copy; <?php echo date('Y'); ?> Allscented. All rights reserved. Powered by neural alchemy.</p>
        </div>
    </div>
</footer>

</body>
</html>

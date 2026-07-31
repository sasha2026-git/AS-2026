</main>

<footer style="border-top:1px solid color-mix(in srgb,var(--outline-variant)20%,transparent);padding:32px 0 24px;margin-top:40px">
    <div class="container-max px-margin-desktop px-margin-mobile" style="display:flex;flex-direction:column;gap:28px">
        <div style="display:flex;flex-wrap:wrap;gap:40px;justify-content:space-between">
            <div style="max-width:280px">
                <?php if (file_exists(get_stylesheet_directory() . '/assets/images/logo.png')) : ?>
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/logo.png'); ?>" alt="Allscented" style="height:22px;width:auto;display:block">
                <?php else : ?>
                    <div class="font-headline-md" style="font-size:16px;letter-spacing:.22em;font-weight:600;color:var(--on-surface)">ALLSCENTED</div>
                <?php endif; ?>
                <div class="font-body-md text-body-md" style="font-size:12px;color:var(--on-surface-variant);margin-top:10px;line-height:1.7">Sensory intelligence, bottled. AI-synthesized fragrances from your most intimate narratives.</div>
            </div>
            <div style="display:flex;gap:48px;flex-wrap:wrap">
                <div>
                    <div class="font-label-caps text-label-caps" style="font-size:9px;letter-spacing:.16em;color:var(--on-surface-variant);margin-bottom:12px">EXPLORE</div>
                    <div style="display:flex;flex-direction:column;gap:8px">
                        <a href="<?php echo esc_url(home_url('/')); ?>" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">Discover</a>
                        <a href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">AI Synthesis</a>
                        <a href="<?php echo esc_url(home_url('/archive/')); ?>" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">Archive</a>
                        <a href="<?php echo esc_url(home_url('/the-atelier/')); ?>" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">The Atelier</a>
                    </div>
                </div>
                <div>
                    <div class="font-label-caps text-label-caps" style="font-size:9px;letter-spacing:.16em;color:var(--on-surface-variant);margin-bottom:12px">LEGAL</div>
                    <div style="display:flex;flex-direction:column;gap:8px">
                        <a href="#" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">Privacy Policy</a>
                        <a href="#" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">Terms of Service</a>
                        <a href="#" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">Shipping & Returns</a>
                    </div>
                </div>
            </div>
        </div>
        <div style="border-top:1px solid color-mix(in srgb,var(--outline-variant)15%,transparent);padding-top:16px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px">
            <span class="font-label-caps text-label-caps" style="font-size:9px;color:var(--on-surface-variant);letter-spacing:.12em">© <?php echo esc_html(date('Y')); ?> ALLSCENTED — ALL RIGHTS RESERVED</span>
            <span class="font-label-caps text-label-caps" style="font-size:9px;color:var(--on-surface-variant);letter-spacing:.12em">CRAFTED WITH AI INTELLIGENCE</span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

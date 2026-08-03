</main>

<footer style="border-top:1px solid color-mix(in srgb,var(--outline-variant)20%,transparent);padding:32px 0 24px;margin-top:40px">
    <div class="container-max px-margin-desktop px-margin-mobile" style="display:flex;flex-direction:column;gap:28px">
        <div style="display:flex;flex-wrap:wrap;gap:40px;justify-content:space-between">
            <div style="max-width:280px">
                <?php
                $allscented_footer_logo  = get_theme_mod('allscented_footer_logo', '');
                $allscented_footer_brand = get_theme_mod('allscented_brand_text', 'ALLSCENTED');
                $allscented_footer_tag   = get_theme_mod('allscented_footer_tagline', 'Sensory intelligence, bottled. AI-synthesized fragrances from your most intimate narratives.');
                $allscented_logo_file    = get_stylesheet_directory() . '/assets/images/logo.png';
                ?>
                <?php if ($allscented_footer_logo) : ?>
                    <img src="<?php echo esc_url($allscented_footer_logo); ?>" alt="Allscented" style="height:22px;width:auto;display:block">
                <?php elseif (file_exists($allscented_logo_file)) : ?>
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/logo.png'); ?>" alt="Allscented" style="height:22px;width:auto;display:block">
                <?php else : ?>
                    <div class="font-headline-md" style="font-size:16px;letter-spacing:.22em;font-weight:600;color:var(--on-surface)"><?php echo esc_html($allscented_footer_brand); ?></div>
                <?php endif; ?>
                <div class="font-body-md text-body-md" style="font-size:12px;color:var(--on-surface-variant);margin-top:10px;line-height:1.7"><?php echo esc_html($allscented_footer_tag); ?></div>
            </div>
            <div style="display:flex;gap:48px;flex-wrap:wrap">
                <div>
                    <div class="font-label-caps text-label-caps" style="font-size:11px;letter-spacing:.16em;color:var(--on-surface-variant);margin-bottom:12px">EXPLORE</div>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_explore',
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'fallback_cb'    => function() {
                            echo '<ul class="footer-menu">';
                            $links = array(
                                'Discover'     => home_url('/'),
                                'AI Synthesis' => home_url('/ai-synthesis/'),
                                'Journal'      => home_url('/archive/'),
                                'The Atelier'  => home_url('/the-atelier/'),
                            );
                            foreach ($links as $label => $url) {
                                echo '<li><a href="' . esc_url($url) . '" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">' . esc_html($label) . '</a></li>';
                            }
                            echo '</ul>';
                        },
                    ));
                    ?>
                </div>
                <div>
                    <div class="font-label-caps text-label-caps" style="font-size:11px;letter-spacing:.16em;color:var(--on-surface-variant);margin-bottom:12px">CONTACT</div>
                    <ul class="footer-menu">
                        <li><a href="mailto:info@allscented.com" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">info@allscented.com</a></li>
                        <li><a href="tel:+85246090901" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">+852 46090901</a></li>
                    </ul>
                </div>
                <div>
                    <div class="font-label-caps text-label-caps" style="font-size:11px;letter-spacing:.16em;color:var(--on-surface-variant);margin-bottom:12px">LEGAL</div>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_legal',
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'fallback_cb'    => function() {
                            echo '<ul class="footer-menu">';
                            $links = array(
                                'Privacy Policy'    => home_url('/privacy/'),
                                'Terms of Service'  => home_url('/terms-of-service/'),
                                'Shipping & Returns' => home_url('/shipping-returns/'),
                            );
                            foreach ($links as $label => $url) {
                                echo '<li><a href="' . esc_url($url) . '" style="font-size:12px;color:var(--on-surface-variant);text-decoration:none">' . esc_html($label) . '</a></li>';
                            }
                            echo '</ul>';
                        },
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div style="border-top:1px solid color-mix(in srgb,var(--outline-variant)15%,transparent);padding-top:16px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px">
            <span class="font-label-caps text-label-caps" style="font-size:11px;color:var(--on-surface-variant);letter-spacing:.12em">&copy; <?php echo esc_html(date('Y')); ?> <?php echo esc_html(get_theme_mod('allscented_footer_copyright', 'ALLSCENTED — ALL RIGHTS RESERVED')); ?></span>
            <span class="font-label-caps text-label-caps" style="font-size:11px;color:var(--on-surface-variant);letter-spacing:.12em"><?php echo esc_html(get_theme_mod('allscented_footer_badge', 'CRAFTED WITH AI INTELLIGENCE')); ?></span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
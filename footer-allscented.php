<?php
/**
 * Footer: Allscented
 * Digital Romanticism – Light, minimal footer
 */
?>
<footer class="site-footer">
    <div class="footer-inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
            <?php bloginfo('name'); ?>
        </a>
        <nav class="footer-nav">
            <a href="<?php echo esc_url(home_url('/archive')); ?>"><?php esc_html_e('Archives', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/compare')); ?>"><?php esc_html_e('Comparison Hub', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Our Scents', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/privacy')); ?>"><?php esc_html_e('Privacy', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/shipping')); ?>"><?php esc_html_e('Shipping', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact', 'allscents'); ?></a>
        </nav>
        <div class="footer-copy">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('Digital Romanticism. All rights reserved.', 'allscents'); ?></p>
            <div style="display: flex; gap: 16px; justify-content: center; margin-top: 16px;">
                <span class="material-symbols-outlined click-feedback" style="cursor: pointer; color: var(--color-on-surface-variant);">public</span>
                <span class="material-symbols-outlined click-feedback" style="cursor: pointer; color: var(--color-on-surface-variant);">camera_alt</span>
                <span class="material-symbols-outlined click-feedback" style="cursor: pointer; color: var(--color-on-surface-variant);">alternate_email</span>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

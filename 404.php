<?php
/**
 * Template: 404
 * Digital Romanticism – Lost in the aura
 */

get_header('allscented');
?>

<main style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 140px 20px 80px;">
    <div style="text-align: center; max-width: 480px;">
        <div style="position: relative; margin-bottom: 32px;">
            <span class="material-symbols-outlined" style="font-size: 80px; color: var(--color-outline);">blur_on</span>
            <span class="material-symbols-outlined" style="font-size: 40px; color: var(--color-secondary); position: absolute; top: 20px; right: 20px; opacity: 0.3;">question_mark</span>
        </div>
        <h1 class="font-headline-xl text-headline-xl" style="margin-bottom: 16px;">
            <?php esc_html_e('Lost in the Aura', 'allscents'); ?>
        </h1>
        <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); margin-bottom: 32px;">
            <?php esc_html_e('This page has evaporated. Try a different scent direction.', 'allscents'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
            <?php esc_html_e('Return Home', 'allscents'); ?>
        </a>
    </div>
</main>

<?php get_footer('allscented'); ?>

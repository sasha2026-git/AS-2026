<?php
/**
 * WooCommerce Archive Product (Shop page) Override
 * Allscented Digital Romanticism
 */

if (!defined('ABSPATH')) exit;

get_header('allscented');
?>

<div style="padding: 140px var(--margin-desktop) 64px; max-width: var(--container-max); margin: 0 auto;">
    <!-- Page Title -->
    <div style="text-align: center; margin-bottom: 64px;">
        <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block; letter-spacing: 0.2em;">
            <?php esc_html_e('THE OFFICIAL BOUTIQUE', 'allscents'); ?>
        </span>
        <h1 class="font-headline-xl text-headline-xl">
            <?php woocommerce_page_title(); ?>
        </h1>
        <?php if (have_posts() && function_exists('woocommerce_product_loop_start')) : ?>
            <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); max-width: 540px; margin: 16px auto 0;">
                <?php esc_html_e('Each scent in our collection is AI-molecular-matched for aura preservation and emotional resonance.', 'allscents'); ?>
            </p>
        <?php endif; ?>
    </div>

    <?php
    if (woocommerce_product_loop()) {
        echo '<div class="product-grid">';
        woocommerce_product_loop_start();

        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();
                do_action('woocommerce_shop_loop');
                wc_get_template_part('content', 'product');
            }
        }

        woocommerce_product_loop_end();
        echo '</div>';

        do_action('woocommerce_after_shop_loop');
    } else {
        do_action('woocommerce_no_products_found');
    }
    ?>
</div>

<?php
get_footer('allscented');

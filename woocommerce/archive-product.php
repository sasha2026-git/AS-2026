<?php
/**
 * WooCommerce Archive Product
 * Used when the WooCommerce Shop page is set instead of "The Atelier" page template.
 * Matches the Digital Romanticism design.
 */

get_header('shop');
?>

<section class="px-margin-desktop container-max mb-24 scroll-reveal">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-gutter">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary mb-4 block">THE ATELIER</span>
            <h1 class="font-headline-xl text-headline-xl mb-6"><?php woocommerce_page_title(); ?></h1>
            <?php if (function_exists('woocommerce_result_count')) : ?>
                <p class="font-body-lg text-body-lg text-on-surface-variant"><?php woocommerce_result_count(); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
if (woocommerce_product_loop()) {
    woocommerce_product_loop_start();

    if (wc_get_loop_prop('total')) {
        while (have_posts()) {
            the_post();
            do_action('woocommerce_shop_loop');
            wc_get_template_part('content', 'product');
        }
    }

    woocommerce_product_loop_end();

    // Pagination
    do_action('woocommerce_after_shop_loop');
} else {
    do_action('woocommerce_no_products_found');
}
?>

<?php
get_footer('shop');

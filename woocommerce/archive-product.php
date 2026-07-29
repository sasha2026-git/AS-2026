<?php
/**
 * WooCommerce Archive Product
 * v15 Atelier uniform grid — Matches page-the-atelier.php design
 */

get_header('shop');
?>

<section class="px-margin-desktop container-max scroll-reveal mb-12">
    <span class="font-label-caps text-label-caps text-secondary mb-2 block">THE ATELIER</span>
    <h1 class="font-headline-lg text-headline-lg mb-4"><?php woocommerce_page_title(); ?></h1>
    <?php if (function_exists('woocommerce_result_count')) : ?>
        <p class="font-body-lg text-body-lg text-on-surface-variant"><?php woocommerce_result_count(); ?></p>
    <?php endif; ?>
</section>

<section class="px-margin-desktop container-max scroll-reveal mb-32">
    <?php
    if (woocommerce_product_loop()) {
        echo '<div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">';

        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();
                do_action('woocommerce_shop_loop');
                wc_get_template_part('content', 'product');
            }
        }

        echo '</div>';

        // Pagination
        do_action('woocommerce_after_shop_loop');
    } else {
        do_action('woocommerce_no_products_found');
    }
    ?>
</section>

<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="bg-on-surface text-surface p-12 md:p-16 rounded-3xl text-center">
        <span class="font-label-caps text-label-caps text-secondary-fixed mb-4 block">AI CONCIERGE</span>
        <h2 class="font-headline-lg text-headline-lg mb-6 italic">Let AI find your signature.</h2>
        <p class="font-body-lg text-body-lg mb-8 text-surface-variant max-w-xl mx-auto">Not sure which scent fits you? Our neural stylist analyzes your preferences in seconds — no guesswork, just molecular precision.</p>
        <a href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>" class="iridescent-btn px-10 py-4 rounded-full font-label-caps text-label-caps tracking-widest uppercase" style="text-decoration:none;">
            Begin AI Synthesis
            <span class="material-symbols-outlined ml-2" style="font-size:16px;">auto_awesome</span>
        </a>
    </div>
</section>

<?php
get_footer('shop');

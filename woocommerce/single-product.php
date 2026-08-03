<?php
/**
 * WooCommerce Single Product
 * Shopify-style landing layout: breadcrumb, sticky gallery, summary, clean details.
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<section class="px-margin-desktop container-max py-16 scroll-reveal" style="padding-top:64px;padding-bottom:96px;">
    <?php
    while (have_posts()) :
        the_post();
        global $product;
        $product_id = get_the_ID();
        $categories = get_the_terms($product_id, 'product_cat');
        $primary_category = ($categories && !is_wp_error($categories)) ? reset($categories) : false;
        $category_link = $primary_category ? get_term_link($primary_category) : false;
        $short_description = apply_filters('woocommerce_short_description', $product ? $product->get_short_description() : '');
    ?>

    <nav aria-label="Breadcrumb" style="display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-bottom:28px;font-family:'Hanken Grotesk',sans-serif;font-size:12px;letter-spacing:.08em;color:var(--on-surface-variant);text-transform:uppercase;">
        <a href="<?php echo esc_url(home_url('/')); ?>" style="text-decoration:none;color:inherit;">AllScented</a>
        <?php if ($primary_category && !is_wp_error($category_link)) : ?>
            <span aria-hidden="true" style="color:#775a19;">/</span>
            <a href="<?php echo esc_url($category_link); ?>" style="text-decoration:none;color:inherit;"><?php echo esc_html($primary_category->name); ?></a>
        <?php endif; ?>
        <span aria-hidden="true" style="color:#775a19;">/</span>
        <span aria-current="page" style="color:var(--on-surface);"><?php echo esc_html(get_the_title()); ?></span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12" style="align-items:start;">
        <div style="position:sticky;top:32px;">
            <div class="aura-glass rounded-2xl p-8 aspect-[4/5] flex items-center justify-center mb-6">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('woocommerce_single', array('class' => 'w-full h-full object-contain transition-transform duration-500 hover:scale-105')); ?>
                <?php endif; ?>
            </div>
            <?php do_action('woocommerce_product_thumbnails'); ?>
        </div>

        <div>
            <?php if ($primary_category && !is_wp_error($category_link)) : ?>
                <a class="font-label-caps text-label-caps" href="<?php echo esc_url($category_link); ?>" style="display:block;margin-bottom:8px;color:#775a19;letter-spacing:.12em;text-decoration:none;"><?php echo esc_html($primary_category->name); ?></a>
            <?php endif; ?>
            <span class="font-label-caps text-label-caps" style="display:block;margin-bottom:10px;color:var(--on-surface-variant);letter-spacing:.12em;">Allscented</span>
            <h1 class="font-headline-md text-headline-md" style="margin:0 0 16px;"><?php echo esc_html(get_the_title()); ?></h1>
            <div class="font-headline-md" style="margin:0 0 24px;color:#775a19;"><?php echo $product ? $product->get_price_html() : ''; ?></div>

            <?php if ($short_description) : ?>
                <div class="font-body-lg text-body-lg" style="margin-bottom:32px;color:var(--on-surface-variant);"><?php echo $short_description; ?></div>
            <?php endif; ?>

            <div style="margin-bottom:32px;">
                <?php if ($product) woocommerce_template_single_add_to_cart(); ?>
            </div>

            <div style="display:flex;flex-wrap:wrap;gap:18px;border-top:1px solid color-mix(in srgb,var(--outline-variant)25%,transparent);padding-top:20px;font-family:'Hanken Grotesk',sans-serif;font-size:12px;letter-spacing:.04em;color:var(--on-surface-variant);">
                <div style="display:flex;align-items:center;gap:6px;">
                    <span class="material-symbols-outlined" style="font-size:16px;color:#775a19;" aria-hidden="true">local_shipping</span>
                    <span>Free Shipping</span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <span class="material-symbols-outlined" style="font-size:16px;color:#775a19;" aria-hidden="true">autorenew</span>
                    <span>Easy Returns</span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <span class="material-symbols-outlined" style="font-size:16px;color:#775a19;" aria-hidden="true">lock</span>
                    <span>Secure Checkout</span>
                </div>
            </div>
        </div>
    </div>

    <?php
    $product_details = allscented_clean_product_description((string) $product->get_description());
    if ($product_details !== '') :
    ?>
    <div style="border-top:1px solid #775a19;max-width:120px;margin:80px auto 24px;"></div>
    <h2 class="font-label-caps text-label-caps" style="text-align:center;margin:0 0 32px;color:#775a19;letter-spacing:.14em;">The Details</h2>
    <div class="product-details-content"><?php echo $product_details; ?></div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_single_product_summary'); ?>
    <?php endwhile; ?>
</section>

<?php
get_footer('shop');

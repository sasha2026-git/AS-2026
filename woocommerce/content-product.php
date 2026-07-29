<?php
/**
 * WooCommerce content-product template
 * Single product card — v15 Atelier uniform grid
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}

$product_categories = wc_get_product_category_list($product->get_id(), ', ', '');
?>
<div <?php wc_product_class('flex flex-col shop-item aura-glass rounded-xl overflow-hidden transition-all hover:shadow-lg group', $product); ?>>
    <div class="aspect-[3/4] overflow-hidden bg-surface-container-high">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover transition-all duration-500 group-hover:scale-105')); ?>
            <?php else : ?>
                <div class="w-full h-full flex items-center justify-center">
                    <span class="font-label-caps text-label-caps text-on-surface-variant/30">No Image</span>
                </div>
            <?php endif; ?>
        </a>
    </div>
    <div class="p-4 flex flex-col gap-1 flex-1">
        <?php
        $terms = get_the_terms(get_the_ID(), 'product_cat');
        if ($terms && !is_wp_error($terms)) :
            $term_names = wp_list_pluck($terms, 'name');
            ?>
            <span class="font-label-caps text-label-caps text-secondary"><?php echo esc_html(implode(', ', array_slice($term_names, 0, 2))); ?></span>
        <?php endif; ?>
        <h3 class="font-headline-md" style="font-size:18px;"><?php the_title(); ?></h3>
        <span class="font-headline-md text-on-surface-variant" style="font-size:16px;"><?php echo $product->get_price_html(); ?></span>
    </div>
</div>

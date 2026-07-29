<?php
/**
 * WooCommerce content-product template
 * Single product card in the shop grid
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}

$product_categories = wc_get_product_category_list($product->get_id(), ' ', '');
?>
<div <?php wc_product_class('flex flex-col group product-card scroll-reveal', $product); ?>>
    <a href="<?php the_permalink(); ?>" class="relative w-full aspect-[3/4] aura-glass rounded-xl mb-6 overflow-hidden flex items-center justify-center cursor-pointer">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('woocommerce_single', array('class' => 'w-2/3 h-2/3 object-contain transition-transform duration-700 group-hover:scale-110', 'loading' => 'lazy')); ?>
        <?php else : ?>
            <div class="w-2/3 h-2/3 bg-surface-container-high rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-on-surface-variant/30" style="font-size: 64px;">spa</span>
            </div>
        <?php endif; ?>
        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
            <span class="material-symbols-outlined text-secondary">favorite</span>
        </div>
        <?php if ($product->is_on_sale()) : ?>
            <div class="absolute top-4 left-4">
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary text-surface rounded-full">SALE</span>
            </div>
        <?php endif; ?>
    </a>

    <div class="flex justify-between items-start mb-2">
        <div>
            <span class="font-label-caps text-label-caps text-secondary">Allscented</span>
            <h3 class="font-headline-md text-[20px] italic"><?php the_title(); ?></h3>
        </div>
        <span class="font-body-md text-primary whitespace-nowrap"><?php echo $product->get_price_html(); ?></span>
    </div>

    <div class="flex gap-2 mb-4 flex-wrap">
        <?php
        $tags = get_the_terms(get_the_ID(), 'product_tag');
        if ($tags && !is_wp_error($tags)) :
            foreach (array_slice($tags, 0, 3) as $tag) : ?>
                <span class="font-label-caps text-[10px] px-2 py-1 bg-secondary-container/20 rounded text-on-surface-variant"><?php echo esc_html(strtoupper($tag->name)); ?></span>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <p class="font-body-md text-body-md text-on-surface-variant mb-4"><?php echo get_the_excerpt() ?: 'A signature Allscented creation.'; ?></p>

    <a class="font-label-caps text-label-caps text-secondary border-b border-secondary pb-1 self-start hover:gap-1 transition-all" href="<?php the_permalink(); ?>">DISCOVER</a>
</div>

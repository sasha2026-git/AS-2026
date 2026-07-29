<?php
/**
 * WooCommerce Single Product
 * Digital Romanticism design for product detail pages
 */

get_header('shop');
?>

<section class="px-margin-desktop container-max py-24 scroll-reveal">
    <?php
    while (have_posts()) :
        the_post();
        global $product;
    ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
        <!-- Product Image Gallery -->
        <div class="sticky top-32">
            <div class="aura-glass rounded-2xl p-8 aspect-[4/5] flex items-center justify-center mb-6">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('woocommerce_single', array('class' => 'w-3/4 h-3/4 object-contain transition-transform duration-500 hover:scale-105')); ?>
                <?php endif; ?>
            </div>
            <?php do_action('woocommerce_product_thumbnails'); ?>
        </div>

        <!-- Product Details -->
        <div>
            <?php
            $categories = get_the_term_list(get_the_ID(), 'product_cat', '', ', ');
            if ($categories) : ?>
                <span class="font-label-caps text-label-caps text-secondary mb-4 block"><?php echo strip_tags($categories); ?></span>
            <?php endif; ?>

            <span class="font-label-caps text-label-caps text-on-surface-variant/60 mb-1 block">Allscented</span>
            <h1 class="font-headline-xl text-headline-xl mb-4"><?php the_title(); ?></h1>

            <div class="font-headline-md text-headline-md text-secondary mb-8">
                <?php echo $product->get_price_html(); ?>
            </div>

            <div class="font-body-lg text-body-lg text-on-surface-variant mb-8 leading-relaxed">
                <?php echo apply_filters('woocommerce_short_description', $product->get_short_description() ?: $post->post_excerpt); ?>
            </div>

            <div class="flex flex-wrap gap-4 mb-10">
                <?php
                $tags = get_the_terms(get_the_ID(), 'product_tag');
                if ($tags && !is_wp_error($tags)) :
                    foreach ($tags as $tag) : ?>
                        <span class="font-label-caps text-label-caps px-4 py-2 bg-secondary-container/20 rounded-full text-secondary"><?php echo esc_html(strtoupper($tag->name)); ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-4">
                <?php woocommerce_template_single_add_to_cart(); ?>
            </div>

            <div class="mt-12 pt-12 border-t border-outline-variant/10">
                <div class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    <?php the_content(); ?>
                </div>
            </div>

            <?php do_action('woocommerce_after_single_product_summary'); ?>
        </div>
    </div>

    <?php endwhile; ?>
</section>

<?php
get_footer('shop');

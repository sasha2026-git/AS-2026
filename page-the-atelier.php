<?php
/**
 * Template Name: The Atelier
 * Description: AllScented Shop — WooCommerce Product Grid (Uniform, v15)
 */

get_header();

// Get current category filter from URL
$current_cat = !empty($_GET['category']) ? sanitize_text_field($_GET['category']) : 'all';
?>

<!-- ============================================ -->
<!-- ATELIER HERO                                 -->
<!-- ============================================ -->
<section class="px-margin-desktop container-max scroll-reveal mb-12">
    <span class="font-label-caps text-label-caps text-secondary mb-2 block"><?php echo esc_html(get_field('allscented_atelier_hero_subtitle') ?: 'THE ATELIER'); ?></span>
    <h1 class="font-headline-lg text-headline-lg mb-4"><?php echo esc_html(get_field('allscented_atelier_hero_title') ?: 'Shop the Collection'); ?></h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl"><?php echo esc_html(get_field('allscented_atelier_hero_desc') ?: 'Curated for your DNA. Every bottle, an echo of your digital aura.'); ?></p>
</section>

<!-- ============================================ -->
<!-- CATEGORY FILTER TABS                         -->
<!-- ============================================ -->
<section class="px-margin-desktop container-max scroll-reveal mb-8">
    <div class="flex gap-3 flex-wrap overflow-x-auto no-scrollbar pb-2" id="atelier-filters">
        <a href="<?php echo esc_url(get_permalink()); ?>"
           class="font-label-caps text-label-caps px-5 py-2 rounded-full border transition-all duration-300"
           style="border-color:<?php echo $current_cat === 'all' ? 'var(--secondary)' : 'var(--outline-variant)'; ?>;color:<?php echo $current_cat === 'all' ? 'var(--secondary)' : 'var(--on-surface-variant)'; ?>;cursor:pointer;flex-shrink:0;font-size:11px;text-decoration:none;display:inline-block;">
            All
        </a>
        <?php
        $product_categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'parent' => 0,
        ));
        foreach ($product_categories as $cat) :
            $filter_url = add_query_arg('category', $cat->slug, get_permalink());
            $is_active = $current_cat === $cat->slug;
            ?>
            <a href="<?php echo esc_url($filter_url); ?>"
               class="font-label-caps text-label-caps px-5 py-2 rounded-full border transition-all duration-300"
               style="border-color:<?php echo $is_active ? 'var(--secondary)' : 'var(--outline-variant)'; ?>;color:<?php echo $is_active ? 'var(--secondary)' : 'var(--on-surface-variant)'; ?>;cursor:pointer;flex-shrink:0;font-size:11px;text-decoration:none;display:inline-block;">
                <?php echo esc_html($cat->name); ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- ============================================ -->
<!-- PRODUCT GRID — Uniform (No 1+2 Pattern)     -->
<!-- ============================================ -->
<section class="px-margin-desktop container-max scroll-reveal mb-32">
    <?php
    // WooCommerce product query
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 6,
        'paged' => $paged,
    );
    if ($current_cat !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $current_cat,
            ),
        );
    }
    $products = new WP_Query($args);

    if ($products->have_posts()) : ?>
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6" id="atelier-grid">
            <?php while ($products->have_posts()) : $products->the_post();
                global $product;
                $product_cats = wp_get_post_terms(get_the_ID(), 'product_cat', array('fields' => 'slugs'));
                ?>
                <div class="shop-item flex flex-col aura-glass rounded-xl overflow-hidden transition-all hover:shadow-lg group"
                     data-category="<?php echo esc_attr(implode(' ', $product_cats)); ?>">
                    <div class="aspect-[3/4] overflow-hidden bg-surface-container-high">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover transition-all duration-500 group-hover:scale-105')); ?>
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center font-label-caps text-label-caps text-on-surface-variant">No Image</div>
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
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-16">
            <?php
            // Custom pagination
            $total_pages = $products->max_num_pages;
            if ($total_pages > 1) :
                $current_page = max(1, $paged);
                $paginate_args = array(
                    'base' => add_query_arg('paged', '%#%'),
                    'format' => '',
                    'current' => $current_page,
                    'total' => $total_pages,
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                    'type' => 'list',
                );
                echo '<nav class="woocommerce-pagination">';
                echo paginate_links($paginate_args);
                echo '</nav>';
            endif;
            ?>
        </div>
    <?php else : ?>
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-4 block">inventory_2</span>
            <p class="font-body-lg text-body-lg text-on-surface-variant">No products found in this category. <a href="<?php echo esc_url(get_permalink()); ?>" style="color:var(--secondary);text-decoration:underline;">View all</a></p>
        </div>
    <?php endif;
    wp_reset_postdata(); ?>
</section>

<!-- ============================================ -->
<!-- CTA — AI Concierge                          -->
<!-- ============================================ -->
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
get_footer();

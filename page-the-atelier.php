<?php
/**
 * Template Name: The Atelier
 * Description: WooCommerce shop — AI-fragrance boutique with 6 per page pagination
 */

get_header();

// Get ACF fields
$hero_subtitle = get_field('allscented_atelier_hero_subtitle') ?: 'THE ATELIER';
$hero_title = get_field('allscented_atelier_hero_title') ?: 'Signature Molecules';
$hero_desc = get_field('allscented_atelier_hero_desc') ?: 'Curated for your DNA. Every bottle, an echo of your digital aura.';
?>

<!-- Hero Section -->
<section class="px-margin-desktop container-max mb-24 scroll-reveal">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-gutter">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary mb-4 block"><?php echo esc_html($hero_subtitle); ?></span>
            <h1 class="font-headline-xl text-headline-xl mb-6"><?php echo esc_html($hero_title); ?></h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant"><?php echo esc_html($hero_desc); ?></p>
        </div>
    </div>
</section>

<!-- Category Tabs (Filter by category) -->
<?php
$product_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
));
if (!empty($product_categories) && !is_wp_error($product_categories)) : ?>
<div class="sticky top-[72px] z-40 bg-surface/40 backdrop-blur-md py-4 mb-16 border-y border-outline-variant/10">
    <div class="px-margin-desktop container-max flex gap-12 overflow-x-auto no-scrollbar">
        <button class="font-label-caps text-label-caps whitespace-nowrap text-secondary border-b-2 border-secondary pb-1 transition-colors filter-btn active" data-filter="all">ALL</button>
        <?php foreach ($product_categories as $cat) : ?>
            <button class="font-label-caps text-label-caps whitespace-nowrap text-on-surface hover:text-secondary transition-colors pb-1 filter-btn" data-filter="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html(strtoupper($cat->name)); ?></button>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- WooCommerce Product Loop with Pagination -->
<section class="px-margin-desktop container-max mb-16">
    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 6,
        'paged'          => $paged,
        'post_status'    => 'publish',
    );
    $products = new WP_Query($args);

    if ($products->have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter" id="product-grid">
            <?php while ($products->have_posts()) : $products->the_post();
                global $product; ?>
                <div class="flex flex-col group product-card" data-category="<?php echo esc_attr(wc_get_product_category_list($product->get_id(), ' ', '')); ?>">
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
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-20 flex justify-center">
            <div class="flex items-center gap-4">
                <?php
                $big = 999999999;
                $paginate_args = array(
                    'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'    => '?paged=%#%',
                    'current'   => max(1, $paged),
                    'total'     => $products->max_num_pages,
                    'prev_text' => '<span class="font-label-caps text-label-caps text-on-surface-variant hover:text-secondary transition-colors">← PREV</span>',
                    'next_text' => '<span class="font-label-caps text-label-caps text-on-surface-variant hover:text-secondary transition-colors">NEXT →</span>',
                    'type'      => 'array',
                    'end_size'  => 1,
                    'mid_size'  => 1,
                );
                $pages = paginate_links($paginate_args);
                if ($pages) :
                    foreach ($pages as $page) :
                        // Add styling classes
                        $page = str_replace('page-numbers current', 'page-numbers current font-label-caps text-label-caps text-secondary border-b-2 border-secondary pb-1', $page);
                        $page = str_replace('page-numbers', 'page-numbers font-label-caps text-label-caps text-on-surface-variant hover:text-secondary transition-colors border-b border-transparent hover:border-secondary pb-1', $page);
                        echo $page;
                    endforeach;
                endif;
                ?>
            </div>
        </div>

    <?php else : ?>
        <div class="text-center py-32">
            <span class="material-symbols-outlined text-on-surface-variant/30" style="font-size: 64px;">spa</span>
            <h2 class="font-headline-md text-headline-md mt-4 mb-2 italic">The Atelier is being curated</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Products will appear here once they are added.</p>
        </div>
    <?php endif;
    wp_reset_postdata(); ?>
</section>

<!-- Custom Synthesis CTA -->
<section class="px-margin-desktop container-max mb-32 scroll-reveal">
    <div class="bg-on-surface text-surface p-12 md:p-24 rounded-3xl relative overflow-hidden">
        <div class="relative z-10 text-center max-w-2xl mx-auto">
            <span class="font-label-caps text-label-caps text-secondary-fixed mb-4 block">THE ATELIER STUDIO</span>
            <h2 class="font-headline-lg text-headline-lg mb-6 italic">Can't find your signature?</h2>
            <p class="font-body-lg text-body-lg mb-8 text-surface-variant">Commission a bespoke synthesis. Our perfumers and AI engineers co-create a scent that belongs only to you.</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <input class="bg-surface/10 border-b border-surface/30 px-6 py-4 font-body-md text-surface focus:outline-none focus:border-secondary transition-colors w-full md:w-96 placeholder:text-surface/40" placeholder="Describe your ideal scent..." type="text">
                <a href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>" class="iridescent-btn px-10 py-4 rounded-full font-label-caps text-label-caps tracking-widest uppercase inline-block text-center">Start Your Brief</a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var filterBtns = document.querySelectorAll('.filter-btn');
        var productCards = document.querySelectorAll('.product-card');
        filterBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                filterBtns.forEach(function(b) {
                    b.classList.remove('text-secondary', 'border-b-2', 'border-secondary');
                    b.classList.add('text-on-surface');
                });
                this.classList.add('text-secondary', 'border-b-2', 'border-secondary');
                this.classList.remove('text-on-surface');
                var filter = this.getAttribute('data-filter');
                productCards.forEach(function(card) {
                    if (filter === 'all' || card.getAttribute('data-category') && card.getAttribute('data-category').toLowerCase().indexOf(filter) !== -1) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

<?php
get_footer();

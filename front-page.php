<?php
/**
 * Template Name: Allscented Home
 * Digital Romanticism – AI Scent Discovery & Boutique Showcase
 */

get_header('allscented');
?>

<!-- ============================================
     Hero: Find Your Scent Signature
     ============================================ -->
<section class="hero-section">
    <div class="hero-bg-blur"></div>

    <div class="hero-content w-full md:w-3/5">
        <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block; letter-spacing: 0.2em;">
            <?php esc_html_e('THE FUTURE OF FRAGRANCE', 'allscents'); ?>
        </span>
        <h1 class="font-headline-xl text-headline-xl" style="margin-bottom: 24px;">
            <?php esc_html_e('Find Your Invisible Signature.', 'allscents'); ?>
        </h1>
        <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); max-width: 540px; margin-bottom: 48px;">
            <?php esc_html_e('An AI-powered scent analysis that decodes your aura and matches it to our curated collection of luxury home fragrances. No algorithms, just alchemy.', 'allscents'); ?>
        </p>
        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <a href="<?php echo esc_url(home_url('/ai-scent-finder')); ?>" class="btn-primary">
                <?php esc_html_e('Analyze Your Aura', 'allscents'); ?>
                <span class="material-symbols-outlined" style="margin-left: 8px; font-size: 18px;">arrow_forward</span>
            </a>
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn-outline">
                <?php esc_html_e('Shop Collection', 'allscents'); ?>
            </a>
        </div>
    </div>
</section>

<!-- ============================================
     Featured Products / Bestsellers
     ============================================ -->
<section class="section-wrapper" style="padding: 80px var(--margin-desktop); max-width: var(--container-max); margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 64px;">
        <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 12px; display: block;">
            <?php esc_html_e('CURATED COLLECTION', 'allscents'); ?>
        </span>
        <h2 class="font-headline-lg text-headline-lg">
            <?php esc_html_e('Our Signature Scents', 'allscents'); ?>
        </h2>
    </div>

    <?php if (class_exists('WooCommerce')) : ?>
        <div class="product-grid">
            <?php
            $featured_products = wc_get_products([
                'limit'   => 6,
                'featured' => true,
                'status'  => 'publish',
            ]);

            if (empty($featured_products)) {
                // Fallback: show recent products
                $featured_products = wc_get_products([
                    'limit'  => 6,
                    'status' => 'publish',
                    'orderby' => 'date',
                    'order'   => 'DESC',
                ]);
            }

            foreach ($featured_products as $product) :
                $product_id = $product->get_id();
                $image_id   = $product->get_image_id();
                $image_url  = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
                $categories = wc_get_product_category_list($product_id, ', ');
                $price      = $product->get_price_html();
                $permalink  = $product->get_permalink();
            ?>
            <div class="product-card reveal">
                <a href="<?php echo esc_url($permalink); ?>" class="product-image">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" loading="lazy">
                    <?php else : ?>
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--color-outline);">
                            <span class="material-symbols-outlined" style="font-size: 48px;">image</span>
                        </div>
                    <?php endif; ?>
                </a>
                <div class="product-info">
                    <?php if ($categories) : ?>
                        <span class="product-category"><?php echo wp_kses_post($categories); ?></span>
                    <?php endif; ?>
                    <h3 class="product-title">
                        <a href="<?php echo esc_url($permalink); ?>" style="color: inherit; text-decoration: none;">
                            <?php echo esc_html($product->get_name()); ?>
                        </a>
                    </h3>
                    <div class="product-price"><?php echo wp_kses_post($price); ?></div>
                </div>
                <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="btn-add-to-cart" data-product_id="<?php echo esc_attr($product_id); ?>">
                    <?php echo esc_html($product->add_to_cart_text()); ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="glass-card" style="padding: 40px; text-align: center; border-radius: var(--radius-xl);">
            <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant);">
                <?php esc_html_e('WooCommerce is required for the shop to display. Please install and activate WooCommerce.', 'allscents'); ?>
            </p>
        </div>
    <?php endif; ?>
</section>

<!-- ============================================
     Scent Stories / Editorial
     ============================================ -->
<section style="padding: 96px var(--margin-desktop); max-width: var(--container-max); margin: 0 auto; position: relative;">
    <div style="text-align: center; margin-bottom: 64px;">
        <h2 class="font-headline-lg text-headline-lg">
            <?php esc_html_e('Scent Stories', 'allscents'); ?>
        </h2>
        <p class="font-body-md text-body-md" style="color: var(--color-on-surface-variant); max-width: 540px; margin: 16px auto 0;">
            <?php esc_html_e('Explore our fragrance archive, comparisons, and AI-powered scent analysis.', 'allscents'); ?>
        </p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--gutter);">
        <?php
        $stories = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 2,
            'category_name'  => 'scent-stories',
        ]);

        if ($stories->have_posts()) :
            while ($stories->have_posts()) : $stories->the_post();
                $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
        ?>
        <div class="glass-card reveal" style="border-radius: var(--radius-xl); overflow: hidden;">
            <?php if ($thumb) : ?>
            <div style="aspect-ratio: 16 / 9; overflow: hidden;">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy"
                     style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"
                     onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <?php endif; ?>
            <div style="padding: 32px;">
                <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 8px; display: block;">
                    <?php 
                    $cats = get_the_category();
                    echo !empty($cats) ? esc_html($cats[0]->name) : __('Scent Story', 'allscents');
                    ?>
                </span>
                <h3 class="font-headline-md text-headline-md" style="margin-bottom: 12px;">
                    <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <p style="color: var(--color-on-surface-variant); line-height: 1.6;">
                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                </p>
            </div>
        </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
        <div class="glass-card" style="padding: 32px; border-radius: var(--radius-xl); grid-column: 1 / -1; text-align: center;">
            <p style="color: var(--color-on-surface-variant);">
                <?php esc_html_e('No scent stories yet. Create a "scent-stories" category and add some posts!', 'allscents'); ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================
     Features Bento Grid
     ============================================ -->
<section style="padding: 80px var(--margin-desktop); max-width: var(--container-max); margin: 0 auto;">
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: var(--gutter);">
        <div class="glass-card reveal" style="padding: 40px; border-radius: var(--radius-xl); text-align: center;">
            <span class="material-symbols-outlined" style="font-size: 40px; color: var(--color-secondary); margin-bottom: 16px;">auto_awesome</span>
            <h3 class="font-headline-md text-headline-md" style="margin-bottom: 8px;"><?php esc_html_e('AI Scent Finder', 'allscents'); ?></h3>
            <p style="color: var(--color-on-surface-variant);"><?php esc_html_e('Answer a few questions and let AI match you to your perfect scent profile.', 'allscents'); ?></p>
        </div>
        <div class="glass-card reveal" style="padding: 40px; border-radius: var(--radius-xl); text-align: center;">
            <span class="material-symbols-outlined" style="font-size: 40px; color: var(--color-secondary); margin-bottom: 16px;">compare_arrows</span>
            <h3 class="font-headline-md text-headline-md" style="margin-bottom: 8px;"><?php esc_html_e('Compare Scents', 'allscents'); ?></h3>
            <p style="color: var(--color-on-surface-variant);"><?php esc_html_e('Side-by-side molecular analysis of our fragrance collection.', 'allscents'); ?></p>
        </div>
        <div class="glass-card reveal" style="padding: 40px; border-radius: var(--radius-xl); text-align: center;">
            <span class="material-symbols-outlined" style="font-size: 40px; color: var(--color-secondary); margin-bottom: 16px;">menu_book</span>
            <h3 class="font-headline-md text-headline-md" style="margin-bottom: 8px;"><?php esc_html_e('Scent Archive', 'allscents'); ?></h3>
            <p style="color: var(--color-on-surface-variant);"><?php esc_html_e('Deep dives into each fragrance: notes, stories, and AI sentiment analysis.', 'allscents'); ?></p>
        </div>
    </div>
</section>

<!-- ============================================
     Newsletter / CTA
     ============================================ -->
<section style="padding: 96px var(--margin-desktop); max-width: 720px; margin: 0 auto;">
    <div class="glass-card iridescent-aura" style="padding: 64px 48px; border-radius: var(--radius-2xl); text-align: center;">
        <h2 class="font-headline-lg text-headline-lg" style="margin-bottom: 16px;"><?php esc_html_e('Join the Aura', 'allscents'); ?></h2>
        <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); margin-bottom: 32px;">
            <?php esc_html_e('Be the first to explore new scent profiles, limited editions, and AI-curated recommendations.', 'allscents'); ?>
        </p>
        <form style="display: flex; gap: 12px; max-width: 480px; margin: 0 auto;">
            <input type="email" placeholder="<?php esc_attr_e('Your email address', 'allscents'); ?>" required
                   style="flex: 1; padding: 16px 20px; border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); background: rgba(255,255,255,0.6); font-family: var(--font-body); font-size: var(--text-body-md); outline: none;">
            <button type="submit" class="btn-primary" style="padding: 16px 32px; white-space: nowrap;">
                <?php esc_html_e('Subscribe', 'allscents'); ?>
            </button>
        </form>
    </div>
</section>

<?php
get_footer('allscented');

<?php
/**
 * Template Name: Allscented Shop / Boutique
 * Digital Romanticism – Product Grid
 * Falls back to WooCommerce default if WC active
 */

get_header('allscented');
?>

<section style="padding: 140px var(--margin-desktop) 64px; max-width: var(--container-max); margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 64px;">
        <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block; letter-spacing: 0.2em;">
            <?php esc_html_e('THE OFFICIAL BOUTIQUE', 'allscents'); ?>
        </span>
        <h1 class="font-headline-xl text-headline-xl">
            <?php esc_html_e('Curated Fragrance', 'allscents'); ?>
        </h1>
        <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); max-width: 540px; margin: 16px auto 0;">
            <?php esc_html_e('Each scent in our collection is AI-molecular-matched for aura preservation and emotional resonance.', 'allscents'); ?>
        </p>
    </div>

    <?php if (class_exists('WooCommerce')) : ?>
        <div class="product-grid">
            <?php
            $all_products = wc_get_products([
                'limit'  => -1,
                'status' => 'publish',
            ]);

            foreach ($all_products as $product) :
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
        <!-- Static fallback if WooCommerce not active -->
        <div class="product-grid">
            <?php
            $static_products = [
                [
                    'name' => 'Extra Large Reed Diffuser (2800ml)',
                    'price' => '$399.00',
                    'cat' => 'Best Choice for Large Rooms',
                    'img' => 'Diffuser_for_luxury_spaces',
                ],
                [
                    'name' => 'Leopard Glass Candle',
                    'price' => '$45.00',
                    'cat' => 'Signature Collection',
                    'img' => 'leopard-candle',
                ],
                [
                    'name' => 'Puppy Salon Candle Set',
                    'price' => '$68.00',
                    'cat' => 'Limited Edition',
                    'img' => 'puppy-salon',
                ],
                [
                    'name' => 'Dessert-Shaped Scented Candle',
                    'price' => '$38.00',
                    'cat' => 'Novelty Collection',
                    'img' => 'dessert-candle',
                ],
                [
                    'name' => 'Reed Diffuser – Honey & Currant Leaves',
                    'price' => '$28.00',
                    'cat' => 'Diffuser Refills',
                    'img' => 'reed-diffuser-refill',
                ],
                [
                    'name' => '4-Pack Donut Candles',
                    'price' => '$42.00',
                    'cat' => 'Gift Sets',
                    'img' => 'donut-candles',
                ],
            ];

            foreach ($static_products as $p) :
            ?>
            <div class="product-card reveal">
                <a href="#" class="product-image">
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: var(--color-surface-container); color: var(--color-outline);">
                        <div style="text-align: center;">
                            <span class="material-symbols-outlined" style="font-size: 40px; display: block; margin-bottom: 8px;">spa</span>
                            <span class="font-label-caps"><?php echo esc_html($p['img']); ?></span>
                        </div>
                    </div>
                </a>
                <div class="product-info">
                    <span class="product-category"><?php echo esc_html($p['cat']); ?></span>
                    <h3 class="product-title"><?php echo esc_html($p['name']); ?></h3>
                    <div class="product-price"><?php echo esc_html($p['price']); ?></div>
                </div>
                <button class="btn-add-to-cart"><?php esc_html_e('Add to Bag', 'allscents'); ?></button>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php get_footer('allscented'); ?>

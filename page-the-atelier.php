<?php
/**
 * Template Name: The Atelier
 */
get_header();

// ===== ACF fields (header + CTA) =====
$t_eyebrow = allscented_field('allscented_atelier_eyebrow', 'THE ATELIER');
$t_title   = allscented_field('allscented_atelier_title', 'Shop the Collection');
$t_desc    = allscented_field('allscented_atelier_desc', 'Each fragrance is AI-synthesized and hand-finished. Free shipping on all orders.');

// ===== Products: WooCommerce primary, ACF defaults fallback =====
$products = array();
$use_woo  = class_exists('WooCommerce');

$cta_eyebrow = allscented_field('allscented_atelier_cta_eyebrow', 'WHOLESALE');
$cta_title   = allscented_field('allscented_atelier_cta_title', 'For Your Space');
$cta_desc    = allscented_field('allscented_atelier_cta_desc', 'Curate a signature scent for your boutique, hotel, or private residence.');
$cta_btn     = allscented_field('allscented_atelier_cta_btn', 'Request Consultation');
?>
<div id="page-the-atelier">
    <section class="atelier-promo-bar" aria-label="Shipping promotion">
        <p>Enjoy free shipping with purchases over $79 — it's just $10 otherwise.</p>
    </section>
    <?php
    // ── Product data: WooCommerce → ACF fallback ──
    if ($use_woo) :
        $q = new WP_Query(array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order date',
            'order'          => 'ASC',
        ));
        foreach ($q->posts as $pitem) :
            // Category: personal > home > commercial priority, default home
            $cat_terms = wp_get_post_terms($pitem->ID, 'product_cat', array('fields' => 'slugs'));
            $cat = 'home';
            if (in_array('personal', $cat_terms, true)) {
                $cat = 'personal';
            } elseif (in_array('home', $cat_terms, true)) {
                $cat = 'home';
            } elseif (in_array('commercial', $cat_terms, true)) {
                $cat = 'commercial';
            }

            // Price: hide element when empty
            $price_raw = get_post_meta($pitem->ID, '_regular_price', true);
            $price = '';
            if ($price_raw !== '' && $price_raw !== false && $price_raw !== null) {
                $price = '$' . number_format((float)$price_raw, 2);
            }

            // Featured image: hide block when absent
            $img_id = get_post_thumbnail_id($pitem->ID);
            $img = $img_id ? wp_get_attachment_image_url($img_id, 'large') : '';

            $link = get_permalink($pitem->ID);

            $sub_raw = trim((string) $pitem->post_excerpt);
            $sub = $sub_raw !== '' ? wp_trim_words(wp_strip_all_tags($sub_raw), 20, '...') : '';
            $products[] = array(
                'name'  => $pitem->post_title,
                'sub'   => $sub,
                'price' => $price,
                'img'   => $img,
                'cat'   => $cat,
                'link'  => $link,
            );
        endforeach;
    endif;

    // Fallback: no WooCommerce or no products → ACF + hardcoded defaults (23 slots preserved)
    if (empty($products)) {
        $acf_products = array();
        for ($i = 1; $i <= 23; $i++) {
            $acf_products[$i] = array(
                'img'   => allscented_image_url("allscented_atelier_p{$i}_img", ''),
                'name'  => allscented_field("allscented_atelier_p{$i}_name", ''),
                'sub'   => allscented_field("allscented_atelier_p{$i}_sub", ''),
                'price' => allscented_field("allscented_atelier_p{$i}_price", ''),
                'cat'   => allscented_field("allscented_atelier_p{$i}_cat", ''),
            );
        }
        $p_defaults = array(
            1 => array('img' => 'https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=400&q=80', 'name' => 'Aura No. 1', 'sub' => 'Personal · Ozone', 'price' => '$185.00', 'cat' => 'personal'),
            2 => array('img' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=400&q=80', 'name' => 'Aura No. 2', 'sub' => 'Personal · Oud', 'price' => '$210.00', 'cat' => 'personal'),
            3 => array('img' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&q=80', 'name' => 'Atmospheric Flux', 'sub' => 'Home · Adaptive', 'price' => '$240.00', 'cat' => 'home'),
            4 => array('img' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400&q=80', 'name' => 'Spatial Bloom', 'sub' => 'Commercial · Ambient', 'price' => '$320.00', 'cat' => 'commercial'),
            5 => array('img' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=400&q=80', 'name' => 'Vesper Muse', 'sub' => 'Personal · Floral', 'price' => '$185.00', 'cat' => 'personal'),
            6 => array('img' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=400&q=80', 'name' => 'Nordic Noir', 'sub' => 'Commercial · Forest', 'price' => '$280.00', 'cat' => 'commercial'),
            7 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/leopard-candle.webp', 'name' => 'Leopard Glass Candle', 'sub' => 'Home · Soy Candle', 'price' => '$55.00', 'cat' => 'home'),
            8 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/leopard-diffuser-vessel.webp', 'name' => 'Leopard Diffuser Vessel', 'sub' => 'Home · Reed Diffuser', 'price' => '$45.00', 'cat' => 'home'),
            9 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/steel-diffuser-bottle.webp', 'name' => 'Steel Diffuser Bottle', 'sub' => 'Home · Diffuser Bottle', 'price' => '$35.00', 'cat' => 'home'),
            10 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/dessert-candle.webp', 'name' => 'Dessert Candle', 'sub' => 'Home · Scented Candle', 'price' => '$37.00', 'cat' => 'home'),
            11 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/refill-cinnamon-brandy.webp', 'name' => 'Cinnamon & Brandy Refill', 'sub' => 'Commercial · 300ml', 'price' => '$59.00', 'cat' => 'commercial'),
            12 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/refill-honey-currant.webp', 'name' => 'Honey & Currant Refill', 'sub' => 'Commercial · 300ml', 'price' => '$59.00', 'cat' => 'commercial'),
            13 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/refill-nutmeg-freesia.webp', 'name' => 'Nutmeg & Freesia Refill', 'sub' => 'Commercial · 300ml', 'price' => '$59.00', 'cat' => 'commercial'),
            14 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/extra-large-diffuser.webp', 'name' => 'Extra Large Reed Diffuser', 'sub' => 'Commercial · 2800ml', 'price' => '$399.00', 'cat' => 'commercial'),
            15 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/donut-candle.png', 'name' => '4 Pack Donut Candle Set', 'sub' => 'Home · Scented Candle', 'price' => '$37.00', 'cat' => 'home'),
            16 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/puppy-salon-scented-tablet.webp', 'name' => 'Puppy Salon Scented Tablet Set', 'sub' => 'Personal · Scented Tablet', 'price' => '$18.50', 'cat' => 'personal'),
            17 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/puppy-elephants-reed-diffuser.webp', 'name' => 'Puppy Salon Reed Diffuser — Elephants', 'sub' => 'Home · Reed Diffuser', 'price' => '$48.00', 'cat' => 'home'),
            18 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/puppy-cat-reed-diffuser.webp', 'name' => 'Puppy Salon Reed Diffuser — Cat', 'sub' => 'Home · Reed Diffuser', 'price' => '$48.00', 'cat' => 'home'),
            19 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/puppy-52hertz-reed-diffuser.webp', 'name' => 'Puppy Salon Reed Diffuser — 52 Hertz', 'sub' => 'Home · Reed Diffuser', 'price' => '$48.00', 'cat' => 'home'),
            20 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/puppy-dog-candle.webp', 'name' => 'Puppy Salon Candle — I\'m Your Eyes', 'sub' => 'Personal · Scented Candle', 'price' => '$59.00', 'cat' => 'personal'),
            21 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/puppy-whale-candle.png', 'name' => 'Puppy Salon Candle — Whale Song', 'sub' => 'Personal · Scented Candle', 'price' => '$49.00', 'cat' => 'personal'),
            22 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/puppy-cat-candle.png', 'name' => 'Puppy Salon Candle — Cat Series', 'sub' => 'Personal · Scented Candle', 'price' => '$49.00', 'cat' => 'personal'),
            23 => array('img' => get_stylesheet_directory_uri() . '/assets/images/products/puppy-elephant-candle.webp', 'name' => 'Puppy Salon Candle — Elephant', 'sub' => 'Personal · Scented Candle', 'price' => '$49.00', 'cat' => 'personal'),
        );
        foreach ($p_defaults as $i => $d) {
            foreach ($d as $k => $v) {
                if (empty($acf_products[$i][$k])) $acf_products[$i][$k] = $v;
            }
        }
        $products = array_values($acf_products);
        // Fallback products have no links
        foreach ($products as &$fp) { $fp['link'] = ''; }
        unset($fp);
    }
    ?>
    <section class="px-margin-desktop container-max" style="padding-top:24px;padding-bottom:12px">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px"><?php echo esc_html($t_eyebrow); ?></span>
            <h1 class="font-headline-xl text-headline-xl" style="margin-bottom:4px"><?php echo esc_html($t_title); ?></h1>
            <p class="font-body-lg text-on-surface-variant" style="font-size:14px"><?php echo esc_html($t_desc); ?></p>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="display:flex;gap:8px;overflow-x:auto;-webkit-overflow-scrolling:touch;padding-bottom:4px;margin-bottom:20px">
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--secondary);color:var(--secondary);background:none;white-space:nowrap;font-size:12px" data-filter="all">All</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:12px" data-filter="personal">Personal</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:12px" data-filter="home">Home</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:12px" data-filter="commercial">Commercial</button>
        </div>
        <!-- Uniform 2-col mobile / 3-col desktop grid -->
        <div id="atelier-grid">
            <?php foreach ($products as $pitem) :
                $has_link = !empty($pitem['link']);
            ?>
            <<?php echo $has_link ? 'a href="' . esc_url($pitem['link']) . '" style="text-decoration:none;color:inherit;display:block"' : 'div'; ?> class="shop-item" data-category="<?php echo esc_attr($pitem['cat']); ?>" style="text-align:center">
                <?php if (!empty($pitem['img'])) : ?>
                <div class="aura-glass" style="aspect-ratio:1;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="<?php echo esc_url($pitem['img']); ?>" alt="<?php echo esc_attr($pitem['name']); ?>" style="width:66%;height:66%;object-fit:contain;transition:transform .5s" loading="lazy">
                </div>
                <?php endif; ?>
                <h4 class="font-headline-md" style="font-size:15px;margin-bottom:2px;font-style:italic"><?php echo esc_html($pitem['name']); ?></h4>
                <?php if (!empty($pitem['sub'])) : ?>
                <p class="font-label-caps text-label-caps" style="color:var(--secondary);font-size:11px;margin-bottom:4px"><?php echo esc_html($pitem['sub']); ?></p>
                <?php endif; ?>
                <?php if ($pitem['price'] !== '') : ?>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px"><?php echo esc_html($pitem['price']); ?></span>
                <?php endif; ?>
            </<?php echo $has_link ? 'a' : 'div'; ?>>
            <?php endforeach; ?>
            <?php if (empty($products)) : ?>
            <!-- Graceful empty state when no products exist at all -->
            <div class="shop-item" data-category="home" style="text-align:center;grid-column:1/-1;padding:40px 16px">
                <div class="aura-glass" style="aspect-ratio:1;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center;opacity:.4">
                    <img src="https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=400&q=80" alt="Coming Soon" style="width:66%;height:66%;object-fit:contain" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:15px;margin-bottom:2px;font-style:italic">Coming Soon</h4>
                <p class="font-label-caps text-label-caps" style="color:var(--secondary);font-size:11px;margin-bottom:4px">New products are on the way</p>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px">&mdash;</span>
            </div>
            <?php endif; ?>
        </div>
        <!-- Pagination: 6 per page, auto-appears when a category has more than 6 -->
        <div id="atelier-pagination" style="display:none;justify-content:center;align-items:center;gap:8px;margin-top:26px">
            <button class="atelier-page-nav" data-dir="-1" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;font-size:14px;cursor:pointer">&lsaquo;</button>
            <div id="atelier-pagination-pages" style="display:flex;gap:6px"></div>
            <button class="atelier-page-nav" data-dir="1" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;font-size:14px;cursor:pointer">&rsaquo;</button>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div class="bg-on-surface" style="border-radius:24px;padding:24px;text-align:center;color:var(--surface)">
            <span class="font-label-caps text-label-caps" style="color:var(--secondary-fixed);margin-bottom:4px;display:block"><?php echo esc_html($cta_eyebrow); ?></span>
            <h2 class="font-headline-lg text-headline-lg" style="margin-bottom:6px;font-style:italic"><?php echo esc_html($cta_title); ?></h2>
            <p class="font-body-md" style="margin-bottom:12px;color:var(--surface-variant);font-size:13px"><?php echo esc_html($cta_desc); ?></p>
            <a class="iridescent-btn font-label-caps text-label-caps" style="padding:10px 24px;border-radius:999px;font-size:12px" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php echo esc_html($cta_btn); ?></a>
        </div>
    </section>
</div>

<?php get_footer(); ?>

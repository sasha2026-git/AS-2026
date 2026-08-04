<?php
/**
 * WooCommerce Single Product
 * Stitch-inspired product detail page with optional ACF media and storytelling blocks.
 */

defined('ABSPATH') || exit;

get_header('shop');

$use_stitch = function_exists('allscented_field') ? allscented_field('product_use_stitch', false, get_the_ID()) : false;
if ($use_stitch) {
    get_template_part(
        'template-parts/stitch-product-detail',
        null,
        array('stitch_product_id' => get_the_ID(), 'context' => 'product')
    );
    get_footer('shop');
    return;
}
?>

<section class="product-page px-margin-desktop container-max scroll-reveal" style="padding-top:64px;padding-bottom:96px;">
    <?php
    while (have_posts()) :
        the_post();
        global $product;
        $product_id = get_the_ID();
        $categories = get_the_terms($product_id, 'product_cat');
        $primary_category = ($categories && !is_wp_error($categories)) ? reset($categories) : false;
        $category_link = $primary_category ? get_term_link($primary_category) : false;
        $short_description = apply_filters('woocommerce_short_description', $product ? $product->get_short_description() : '');

        $product_video_url = allscented_field('product_video_url', '', $product_id);
        $product_video_label = allscented_field('product_video_label', 'Cinematic Preview', $product_id);
        $chip_for = allscented_field('product_chip_for', '', $product_id);
        $chip_mood = allscented_field('product_chip_mood', '', $product_id);
        $chip_scene = allscented_field('product_chip_scene', '', $product_id);

        $chips = array_filter(array(
            'for'   => $chip_for !== '' ? 'For ' . $chip_for : '',
            'mood'  => $chip_mood !== '' ? 'Mood: ' . $chip_mood : '',
            'scene' => $chip_scene !== '' ? 'Scene: ' . $chip_scene : '',
        ));

        $journey = function_exists('get_field') ? get_field('product_journey', $product_id) : array();
        $journey = is_array($journey) ? array_values(array_filter($journey, function($row) {
            return !empty($row['stage']) || !empty($row['notes']);
        })) : array();
        $scenarios = function_exists('get_field') ? get_field('product_scenarios', $product_id) : array();
        $scenarios = is_array($scenarios) ? array_values(array_filter($scenarios, function($row) {
            return !empty($row['title']) || !empty($row['desc']) || !empty($row['image']);
        })) : array();
        $dna = function_exists('get_field') ? get_field('product_dna', $product_id) : array();
        $dna = is_array($dna) ? array_values(array_filter($dna, function($row) {
            return !empty($row['title']) || !empty($row['desc']);
        })) : array();
        $specs = function_exists('get_field') ? get_field('product_specs', $product_id) : array();
        $specs = is_array($specs) ? array_values(array_filter($specs, function($row) {
            return !empty($row['label']) || !empty($row['value']);
        })) : array();

        $featured_id = get_post_thumbnail_id($product_id);
        $featured_url = $featured_id ? wp_get_attachment_image_url($featured_id, 'woocommerce_single') : '';
        $featured_alt = $featured_id ? get_post_meta($featured_id, '_wp_attachment_image_alt', true) : '';
        $has_media = ($featured_id || $product_video_url !== '');
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

    <div class="product-layout">
        <div class="product-media-column">
            <?php if ($has_media) : ?>
            <div class="aura-glass product-media-panel" id="product-main-media" data-video-url="<?php echo esc_attr($product_video_url); ?>">
                <?php if ($product_video_url !== '') : ?>
                    <video id="product-main-video" class="product-main-media product-main-video" controls preload="metadata" poster="<?php echo esc_url($featured_url); ?>" src="<?php echo esc_url($product_video_url); ?>"></video>
                    <button id="product-video-toggle" class="product-video-toggle" type="button" aria-label="Play cinematic preview">
                        <span class="material-symbols-outlined" aria-hidden="true">play_circle</span>
                        <span><?php echo esc_html($product_video_label); ?></span>
                    </button>
                <?php endif; ?>
                <?php if ($featured_id) : ?>
                    <img id="product-main-image" class="product-main-media product-main-image<?php echo $product_video_url !== '' ? ' product-media-hidden' : ''; ?>" src="<?php echo esc_url($featured_url); ?>" alt="<?php echo esc_attr($featured_alt); ?>">
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="product-thumbnails"><?php do_action('woocommerce_product_thumbnails'); ?></div>
        </div>

        <div class="product-summary-column">
            <?php if ($chips) : ?>
                <div class="product-chips" aria-label="Product attributes">
                    <?php foreach ($chips as $chip) : ?>
                        <span class="product-chip font-label-caps text-label-caps"><?php echo esc_html($chip); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

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

    <?php if ($journey) : $journey_title = allscented_field('product_journey_title', 'The Olfactory Journey', $product_id); $journey_intro = allscented_field('product_journey_intro', '', $product_id); ?>
    <section class="product-section">
        <div class="product-section-heading">
            <h2 class="font-headline-md text-headline-md"><?php echo esc_html($journey_title); ?></h2>
            <?php if ($journey_intro !== '') : ?><p class="product-section-intro font-body-md text-body-md"><?php echo nl2br(esc_html($journey_intro)); ?></p><?php endif; ?>
        </div>
        <div class="product-journey-grid">
            <?php foreach ($journey as $row) : ?>
            <div class="aura-glass product-journey-card">
                <?php if (!empty($row['stage'])) : ?><span class="font-label-caps text-label-caps product-journey-stage"><?php echo esc_html($row['stage']); ?></span><?php endif; ?>
                <?php if (!empty($row['notes'])) : ?><ul class="product-journey-notes font-body-md">
                    <?php
                    $journey_note_lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $row['notes'])), 'strlen'));
                    foreach ($journey_note_lines as $note_line) :
                    ?>
                    <li><?php echo esc_html($note_line); ?></li>
                    <?php endforeach; ?>
                </ul><?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($scenarios) : $scenarios_title = allscented_field('product_scenarios_title', 'Atmospheric Resonance', $product_id); $scenarios_intro = allscented_field('product_scenarios_intro', '', $product_id); ?>
    <section class="product-section">
        <div class="product-section-heading">
            <h2 class="font-headline-md text-headline-md"><?php echo esc_html($scenarios_title); ?></h2>
            <?php if ($scenarios_intro !== '') : ?><p class="product-section-intro font-body-md text-body-md"><?php echo nl2br(esc_html($scenarios_intro)); ?></p><?php endif; ?>
        </div>
        <div class="product-scenario-grid">
            <?php foreach ($scenarios as $row) :
                $scenario_image = allscented_acf_media_url(isset($row['image']) ? $row['image'] : '');
            ?>
            <article class="product-scenario-card">
                <?php if ($scenario_image !== '') : ?>
                <div class="product-scenario-media">
                    <img src="<?php echo esc_url($scenario_image); ?>" alt="<?php echo esc_attr(isset($row['title']) ? $row['title'] : ''); ?>" loading="lazy">
                </div>
                <?php endif; ?>
                <div class="product-scenario-body">
                    <?php if (!empty($row['title'])) : ?><h3 class="font-headline-md product-scenario-title"><?php echo esc_html($row['title']); ?></h3><?php endif; ?>
                    <?php if (!empty($row['desc'])) : ?><p class="product-scenario-desc font-body-md"><?php echo nl2br(esc_html($row['desc'])); ?></p><?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($dna) : $dna_title = allscented_field('product_dna_title', 'Product DNA', $product_id); $dna_intro = allscented_field('product_dna_intro', '', $product_id); ?>
    <section class="product-section">
        <div class="product-section-heading">
            <h2 class="font-headline-md text-headline-md"><?php echo esc_html($dna_title); ?></h2>
            <?php if ($dna_intro !== '') : ?><p class="product-section-intro font-body-md text-body-md"><?php echo nl2br(esc_html($dna_intro)); ?></p><?php endif; ?>
        </div>
        <div class="product-dna-grid">
            <?php foreach ($dna as $row) : $dna_icon = !empty($row['icon']) ? $row['icon'] : ''; ?>
            <div class="aura-glass product-dna-card<?php echo $dna_icon === '' ? ' product-dna-card-no-icon' : ''; ?>">
                <?php if ($dna_icon !== '') : ?><span class="product-dna-icon" aria-hidden="true"><span class="material-symbols-outlined"><?php echo esc_html($dna_icon); ?></span></span><?php endif; ?>
                <div>
                    <?php if (!empty($row['title'])) : ?><h3 class="font-body-lg product-dna-title"><?php echo esc_html($row['title']); ?></h3><?php endif; ?>
                    <?php if (!empty($row['desc'])) : ?><p class="product-dna-desc font-body-md"><?php echo nl2br(esc_html($row['desc'])); ?></p><?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($specs) : $specs_title = allscented_field('product_specs_title', 'Technical Specs', $product_id); ?>
    <section class="product-section">
        <div class="product-section-heading">
            <h2 class="font-label-caps text-label-caps product-section-title-label"><?php echo esc_html($specs_title); ?></h2>
        </div>
        <div class="aura-glass product-specs-card">
            <ul class="product-specs-list">
                <?php foreach ($specs as $row) : ?>
                <li class="product-specs-row">
                    <span class="product-specs-label font-body-md"><?php echo esc_html(isset($row['label']) ? $row['label'] : ''); ?></span>
                    <span class="product-specs-value font-body-md"><?php echo esc_html(isset($row['value']) ? $row['value'] : ''); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>

    <?php do_action('woocommerce_after_single_product_summary'); ?>
<?php
$related_ids = array();
if (function_exists('wc_get_related_products')) {
    $related_ids = (array) wc_get_related_products($product_id, 3);
}
$related_title = allscented_field('product_related_title', 'You May Also Like', $product_id);
$related_intro = allscented_field('product_related_intro', '', $product_id);
if (!empty($related_ids)) :
?>
<section class="related-products-section product-section" aria-labelledby="related-products-heading">
    <div class="product-section-heading">
        <h2 id="related-products-heading" class="font-headline-md text-headline-md"><?php echo esc_html($related_title); ?></h2>
        <?php if ($related_intro !== '') : ?><p class="product-section-intro font-body-md text-body-md"><?php echo nl2br(esc_html($related_intro)); ?></p><?php endif; ?>
    </div>
    <div class="related-products-grid">
        <?php
        $original_product = $product;
        foreach ($related_ids as $related_id) {
            $related_product = function_exists('wc_get_product') ? wc_get_product($related_id) : false;
            if (!$related_product) {
                continue;
            }
            $related_permalink = get_permalink($related_id);
            $related_name = $related_product->get_name();
            $related_image = get_the_post_thumbnail($related_id, 'woocommerce_thumbnail', array('class' => 'related-product-image', 'loading' => 'lazy'));
        ?>
        <article class="related-product-card aura-glass">
            <div class="related-product-media">
                <?php if ($related_image) : echo $related_image; else : ?>
                    <span class="related-product-placeholder" aria-hidden="true"><span class="material-symbols-outlined">image</span></span>
                <?php endif; ?>
            </div>
            <div class="related-product-body">
                <h3 class="related-product-title font-headline-md"><a href="<?php echo esc_url($related_permalink); ?>"><?php echo esc_html($related_name); ?></a></h3>
                <div class="related-product-price font-headline-md"><?php echo $related_product->get_price_html(); ?></div>
                <div class="related-product-actions">
                    <?php
                    $product = $related_product;
                    if (function_exists('woocommerce_template_loop_add_to_cart')) {
                        woocommerce_template_loop_add_to_cart();
                    }
                    $product = $original_product;
                    ?>
                </div>
            </div>
        </article>
        <?php
        }
        $product = $original_product;
        ?>
    </div>
</section>
<?php endif; ?>
    <?php endwhile; ?>
</section>

<?php
get_footer('shop');

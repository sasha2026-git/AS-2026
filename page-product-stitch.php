<?php
/**
 * Template Name: Product Detail – Stitch
 * Independent Stitch design product detail page for AllScented.
 * Product source: ?product=ID, then page ACF stitch_product, then empty state.
 */

defined('ABSPATH') || exit;

get_header();

$page_id = (int) get_the_ID();
$requested_product_id = isset($_GET['product']) ? absint($_GET['product']) : 0;

$acf_product_id = 0;
if (function_exists('get_field')) {
    $acf_value = get_field('stitch_product', $page_id);
    if (is_numeric($acf_value)) {
        $acf_product_id = absint($acf_value);
    } elseif (is_array($acf_value) && !empty($acf_value['ID'])) {
        $acf_product_id = absint($acf_value['ID']);
    }
}

$product_id = $requested_product_id ? $requested_product_id : $acf_product_id;
$product = $product_id && function_exists('wc_get_product') ? wc_get_product($product_id) : false;

if (!$product) {
    echo '<section class="stitch-page stitch-empty">';
    echo '<p>Please select a product in the page settings, or append ?product=ID to the URL.</p>';
    echo '</section>';
    get_footer();
    return;
}

$GLOBALS['product'] = $product;
$product_title = get_the_title($product_id);
$product_price_html = $product->get_price_html();

$chip_for = allscented_field('product_chip_for', '', $product_id);
$chip_mood = allscented_field('product_chip_mood', '', $product_id);
$chip_scene = allscented_field('product_chip_scene', '', $product_id);
$chips = array();
if ($chip_for !== '') {
    $chips[] = 'For ' . $chip_for;
}
if ($chip_mood !== '') {
    $chips[] = 'Mood: ' . $chip_mood;
}
if ($chip_scene !== '') {
    $chips[] = 'Scene: ' . $chip_scene;
}

$product_size_note = allscented_field('product_size_note', '', $product_id);
$short_description = apply_filters('woocommerce_short_description', (string) $product->get_short_description());

$product_video_url = allscented_field('product_video_url', '', $product_id);
$product_video_label = allscented_field('product_video_label', 'Cinematic Preview', $product_id);
$featured_id = get_post_thumbnail_id($product_id);
$featured_url = $featured_id ? wp_get_attachment_image_url($featured_id, 'woocommerce_single') : '';
$featured_alt = $featured_id ? get_post_meta($featured_id, '_wp_attachment_image_alt', true) : '';
$featured_alt = $featured_alt !== '' ? $featured_alt : $product_title;
$has_image = (bool) $featured_url;
$has_video = $product_video_url !== '';
$has_media = $has_image || $has_video;
$show_preview_bar = $has_video && $has_image;

$journey_raw = function_exists('get_field') ? get_field('product_journey', $product_id) : array();
$journey = array();
if (is_array($journey_raw)) {
    foreach (array_values($journey_raw) as $row) {
        if (is_array($row) && (!empty($row['stage']) || !empty($row['notes']))) {
            $journey[] = $row;
        }
    }
}
$journey = array_slice($journey, 0, 3);
$journey_title = allscented_field('product_journey_title', 'The Olfactory Journey', $product_id);
$journey_intro = allscented_field('product_journey_intro', '', $product_id);
$journey_fallbacks = array(
    array('air', 'Top Notes'),
    array('local_florist', 'Heart Notes'),
    array('diamond', 'Base Notes'),
);

$scenarios_raw = function_exists('get_field') ? get_field('product_scenarios', $product_id) : array();
$scenarios = array();
if (is_array($scenarios_raw)) {
    foreach (array_values($scenarios_raw) as $row) {
        if (is_array($row) && (!empty($row['title']) || !empty($row['desc']) || !empty($row['image']))) {
            $scenarios[] = $row;
        }
    }
}
$scenarios_title = allscented_field('product_scenarios_title', 'Atmospheric Resonance', $product_id);
$scenarios_intro = allscented_field('product_scenarios_intro', '', $product_id);

$philosophy_title = allscented_field('product_philosophy_title', 'Brand Philosophy', $product_id);
$philosophy_text = allscented_field('product_philosophy_text', '', $product_id);
$soul_title = allscented_field('product_soul_title', 'The Soul of ' . $product_title, $product_id);
$soul_text = allscented_field('product_soul_text', '', $product_id);
$has_philosophy = $philosophy_text !== '' || $soul_text !== '';

$dna_raw = function_exists('get_field') ? get_field('product_dna', $product_id) : array();
$dna_rows = array();
if (is_array($dna_raw)) {
    foreach (array_values($dna_raw) as $row) {
        if (is_array($row) && (!empty($row['title']) || !empty($row['desc']))) {
            $dna_rows[] = $row;
        }
    }
}
$dna_rows = array_slice($dna_rows, 0, 3);
$has_dna = !empty($dna_rows);
$dna_title = allscented_field('product_dna_title', 'Product DNA', $product_id);

$specs_raw = function_exists('get_field') ? get_field('product_specs', $product_id) : array();
$specs_rows = array();
if (is_array($specs_raw)) {
    foreach (array_values($specs_raw) as $row) {
        if (is_array($row) && (!empty($row['label']) || !empty($row['value']))) {
            $specs_rows[] = $row;
        }
    }
}
$specs_title = allscented_field('product_specs_title', 'Technical Specs', $product_id);
$specs_footer = allscented_field('product_specs_footer', '', $product_id);
$has_specs = !empty($specs_rows) || $specs_footer !== '';
$dna_class = ($has_dna && $has_specs) ? 'stitch-col-7' : 'stitch-col-12';
$specs_class = ($has_dna && $has_specs) ? 'stitch-col-5' : 'stitch-col-12';

$related_ids = function_exists('wc_get_related_products') ? (array) wc_get_related_products($product_id, 3) : array();
$related_products = array();
foreach ($related_ids as $related_id) {
    $related_product = function_exists('wc_get_product') ? wc_get_product($related_id) : false;
    if ($related_product) {
        $related_products[] = $related_product;
    }
}
$related_title = allscented_field('product_related_title', 'You May Also Like', $product_id);
$related_intro = allscented_field('product_related_intro', '', $product_id);
?>

<div class="stitch-page" id="stitch-page">
    <div class="stitch-ambient-glow stitch-ambient-glow-one" aria-hidden="true"></div>
    <div class="stitch-ambient-glow stitch-ambient-glow-two" aria-hidden="true"></div>

    <section class="stitch-section stitch-hero">
        <div class="stitch-grid<?php echo $has_media ? '' : ' stitch-hero-details-only'; ?>">
            <?php if ($has_media) : ?>
            <div class="stitch-col-7 stitch-hero-media-column">
                <div class="stitch-glass stitch-hero-media" id="stitch-main-media">
                    <div class="stitch-hero-overlay" aria-hidden="true"></div>
                    <?php if ($has_video) : ?>
                        <video id="stitch-main-video" class="stitch-main-video<?php echo $has_image ? ' stitch-media-hidden' : ''; ?>" src="<?php echo esc_url($product_video_url); ?>" poster="<?php echo esc_url($featured_url); ?>" controls autoplay playsinline preload="metadata"></video>
                    <?php endif; ?>
                    <?php if ($has_image) : ?>
                        <img id="stitch-main-image" class="stitch-main-image" src="<?php echo esc_url($featured_url); ?>" alt="<?php echo esc_attr($featured_alt); ?>">
                    <?php endif; ?>
                </div>
                <?php if ($show_preview_bar) : ?>
                <button id="stitch-video-toggle" class="stitch-glass stitch-video-toggle" type="button" aria-pressed="false" aria-controls="stitch-main-media">
                    <span class="material-symbols-outlined" aria-hidden="true">play_circle</span>
                    <span class="stitch-video-label"><?php echo esc_html($product_video_label); ?></span>
                </button>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="<?php echo $has_media ? 'stitch-col-5' : 'stitch-col-12'; ?> stitch-hero-details">
                <?php if ($chips) : ?>
                <div class="stitch-chips" aria-label="Product attributes">
                    <?php foreach ($chips as $chip) : ?>
                        <span class="stitch-chip"><?php echo esc_html($chip); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="stitch-hero-detail-block">
                    <h1 class="stitch-product-title"><?php echo esc_html($product_title); ?></h1>
                    <?php if ($product_price_html !== '' || $product_size_note !== '') : ?>
                    <p class="stitch-price-row">
                        <?php if ($product_price_html !== '') : ?>
                            <span class="stitch-price"><?php echo wp_kses_post($product_price_html); ?></span>
                        <?php endif; ?>
                        <?php if ($product_size_note !== '') : ?>
                            <span class="stitch-size-note"><?php echo esc_html($product_size_note); ?></span>
                        <?php endif; ?>
                    </p>
                    <?php endif; ?>
                </div>

                <?php if ($short_description !== '') : ?>
                <div class="stitch-short-description"><?php echo wp_kses_post($short_description); ?></div>
                <?php endif; ?>

                <div class="stitch-add-to-cart">
                    <?php
                    if (function_exists('woocommerce_template_single_add_to_cart')) {
                        $GLOBALS['allscented_stitch_add_to_cart_text'] = 'Add to Atelier';
                        $allscented_stitch_cart_text = function ($text) {
                            return !empty($GLOBALS['allscented_stitch_add_to_cart_text']) ? $GLOBALS['allscented_stitch_add_to_cart_text'] : $text;
                        };
                        add_filter('woocommerce_product_single_add_to_cart_text', $allscented_stitch_cart_text, 20);
                        add_filter('woocommerce_product_add_to_cart_text', $allscented_stitch_cart_text, 20);
                        woocommerce_template_single_add_to_cart();
                        remove_filter('woocommerce_product_single_add_to_cart_text', $allscented_stitch_cart_text, 20);
                        remove_filter('woocommerce_product_add_to_cart_text', $allscented_stitch_cart_text, 20);
                        unset($GLOBALS['allscented_stitch_add_to_cart_text'], $allscented_stitch_cart_text);
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php if ($journey) : ?>
    <section class="stitch-section stitch-journey">
        <?php if ($journey_title !== '' || $journey_intro !== '') : ?>
        <div class="stitch-journey-heading">
            <?php if ($journey_title !== '') : ?>
                <h2><?php echo esc_html($journey_title); ?></h2>
            <?php endif; ?>
            <?php if ($journey_intro !== '') : ?>
                <p><?php echo nl2br(esc_html($journey_intro)); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="stitch-journey-grid">
            <?php foreach ($journey as $index => $row) : ?>
                <?php
                $fallback = $journey_fallbacks[$index % count($journey_fallbacks)];
                $journey_icon = !empty($row['icon']) ? (string) $row['icon'] : $fallback[0];
                $journey_label = !empty($row['label']) ? (string) $row['label'] : $fallback[1];
                $journey_stage = !empty($row['stage']) ? (string) $row['stage'] : $journey_label;
                $journey_notes = isset($row['notes']) ? (string) $row['notes'] : '';
                $journey_note_lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $journey_notes)), 'strlen'));
                ?>
                <div class="stitch-glass stitch-journey-card">
                    <span class="stitch-journey-icon" aria-hidden="true"><span class="material-symbols-outlined"><?php echo esc_html($journey_icon); ?></span></span>
                    <div class="stitch-journey-copy">
                        <h3 class="stitch-journey-stage"><?php echo esc_html($journey_stage); ?></h3>
                        <p class="stitch-journey-label"><?php echo esc_html($journey_label); ?></p>
                        <?php if ($journey_note_lines) : ?>
                        <ul class="stitch-journey-notes">
                            <?php foreach ($journey_note_lines as $note_line) : ?>
                                <li><?php echo esc_html($note_line); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($scenarios) : ?>
    <section class="stitch-section stitch-scenarios">
        <?php if ($scenarios_title !== '' || $scenarios_intro !== '') : ?>
        <div class="stitch-scenarios-heading">
            <?php if ($scenarios_title !== '') : ?>
                <h2><?php echo esc_html($scenarios_title); ?></h2>
            <?php endif; ?>
            <?php if ($scenarios_intro !== '') : ?>
                <p><?php echo nl2br(esc_html($scenarios_intro)); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="stitch-scenarios-grid">
            <?php foreach ($scenarios as $index => $scenario) : ?>
                <?php
                $scenario_image = isset($scenario['image']) ? allscented_acf_media_url($scenario['image'], '') : '';
                $scenario_title = isset($scenario['title']) ? (string) $scenario['title'] : '';
                $scenario_desc = isset($scenario['desc']) ? (string) $scenario['desc'] : '';
                ?>
                <article class="stitch-scenario-card">
                    <div class="stitch-scenario-media<?php echo $scenario_image === '' ? ' stitch-scenario-media-empty' : ''; ?>">
                        <?php if ($scenario_image !== '') : ?>
                            <img src="<?php echo esc_url($scenario_image); ?>" alt="<?php echo esc_attr($scenario_title); ?>" loading="lazy">
                        <?php else : ?>
                            <span class="material-symbols-outlined" aria-hidden="true">image</span>
                        <?php endif; ?>
                        <div class="stitch-scenario-overlay" aria-hidden="true"></div>
                    </div>
                    <div class="stitch-scenario-body">
                        <h3 class="stitch-scenario-label"><?php echo esc_html(sprintf('Scenario %02d', $index + 1)); ?></h3>
                        <?php if ($scenario_title !== '') : ?>
                            <h4 class="stitch-scenario-title"><?php echo esc_html($scenario_title); ?></h4>
                        <?php endif; ?>
                        <?php if ($scenario_desc !== '') : ?>
                            <p class="stitch-scenario-desc"><?php echo nl2br(esc_html($scenario_desc)); ?></p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($has_philosophy) : ?>
    <section class="stitch-section stitch-philosophy">
        <h2 class="stitch-philosophy-heading">A Synthesis of Emotion and Algorithm</h2>
        <div class="stitch-philosophy-columns<?php echo ($philosophy_text === '' || $soul_text === '') ? ' stitch-philosophy-columns-single' : ''; ?>">
            <?php if ($philosophy_text !== '') : ?>
            <div class="stitch-philosophy-column">
                <h3><?php echo esc_html($philosophy_title); ?></h3>
                <p><?php echo nl2br(esc_html($philosophy_text)); ?></p>
            </div>
            <?php endif; ?>
            <?php if ($soul_text !== '') : ?>
            <div class="stitch-philosophy-column">
                <h3><?php echo esc_html($soul_title); ?></h3>
                <p><?php echo nl2br(esc_html($soul_text)); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($has_dna || $has_specs) : ?>
    <section class="stitch-section stitch-dna-specs">
        <div class="stitch-grid">
            <?php if ($has_dna) : ?>
            <div class="<?php echo esc_attr($dna_class); ?> stitch-dna-column">
                <h2 class="stitch-dna-title"><?php echo esc_html($dna_title); ?></h2>
                <?php foreach ($dna_rows as $index => $dna_row) : ?>
                    <?php
                    $dna_icon = !empty($dna_row['icon']) ? (string) $dna_row['icon'] : '';
                    $dna_row_title = !empty($dna_row['title']) ? (string) $dna_row['title'] : '';
                    $dna_row_desc = !empty($dna_row['desc']) ? (string) $dna_row['desc'] : '';
                    ?>
                    <div class="stitch-glass stitch-dna-card stitch-dna-tone-<?php echo esc_attr($index % 3); ?>">
                        <?php if ($dna_icon !== '') : ?>
                        <span class="stitch-dna-icon" aria-hidden="true"><span class="material-symbols-outlined"><?php echo esc_html($dna_icon); ?></span></span>
                        <?php endif; ?>
                        <div class="stitch-dna-body">
                            <?php if ($dna_row_title !== '') : ?>
                                <h4><?php echo esc_html($dna_row_title); ?></h4>
                            <?php endif; ?>
                            <?php if ($dna_row_desc !== '') : ?>
                                <p><?php echo nl2br(esc_html($dna_row_desc)); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($has_specs) : ?>
            <div class="<?php echo esc_attr($specs_class); ?> stitch-specs-column">
                <div class="stitch-glass stitch-specs-panel">
                    <h3 class="stitch-specs-heading"><?php echo esc_html($specs_title); ?></h3>
                    <?php if ($specs_rows) : ?>
                    <ul class="stitch-specs-list">
                        <?php foreach ($specs_rows as $spec_row) : ?>
                        <li class="stitch-specs-row">
                            <span class="stitch-specs-label"><?php echo esc_html(isset($spec_row['label']) ? (string) $spec_row['label'] : ''); ?></span>
                            <span class="stitch-specs-value"><?php echo esc_html(isset($spec_row['value']) ? (string) $spec_row['value'] : ''); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <?php if ($specs_footer !== '') : ?>
                    <div class="stitch-specs-footer">
                        <span class="material-symbols-outlined" aria-hidden="true">radar</span>
                        <p><?php echo esc_html($specs_footer); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($related_products) : ?>
    <section class="stitch-section stitch-related-section"<?php echo $related_title !== '' ? ' aria-labelledby="stitch-related-heading"' : ''; ?>>
        <?php if ($related_title !== '' || $related_intro !== '') : ?>
        <div class="stitch-related-heading">
            <?php if ($related_title !== '') : ?>
                <h2 id="stitch-related-heading"><?php echo esc_html($related_title); ?></h2>
            <?php endif; ?>
            <?php if ($related_intro !== '') : ?>
                <p><?php echo nl2br(esc_html($related_intro)); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="stitch-related-grid">
            <?php
            $original_product = $product;
            foreach ($related_products as $related_product) {
                $related_id = $related_product->get_id();
                $related_name = $related_product->get_name();
                $related_permalink = get_permalink($related_id);
                $related_image = get_the_post_thumbnail($related_id, 'woocommerce_thumbnail', array('class' => 'stitch-related-image', 'loading' => 'lazy'));
            ?>
            <article class="stitch-glass stitch-related-card">
                <div class="stitch-related-media">
                    <?php if ($related_image) : ?>
                        <?php echo $related_image; ?>
                    <?php else : ?>
                        <span class="stitch-related-placeholder" aria-hidden="true"><span class="material-symbols-outlined">image</span></span>
                    <?php endif; ?>
                </div>
                <div class="stitch-related-body">
                    <h3 class="stitch-related-title">
                        <a class="stitch-related-title-link" href="<?php echo esc_url($related_permalink); ?>"><?php echo esc_html($related_name); ?></a>
                    </h3>
                    <div class="stitch-related-price"><?php echo wp_kses_post($related_product->get_price_html()); ?></div>
                    <div class="stitch-related-actions">
                        <?php
                        $GLOBALS['product'] = $related_product;
                        if (function_exists('woocommerce_template_loop_add_to_cart')) {
                            woocommerce_template_loop_add_to_cart();
                        }
                        $GLOBALS['product'] = $original_product;
                        ?>
                    </div>
                </div>
            </article>
            <?php
            }
            $product = $original_product;
            $GLOBALS['product'] = $original_product;
            ?>
        </div>
    </section>
    <?php endif; ?>
</div>

<script>
(function () {
    var media = document.getElementById('stitch-main-media');
    var image = document.getElementById('stitch-main-image');
    var video = document.getElementById('stitch-main-video');
    var toggle = document.getElementById('stitch-video-toggle');

    if (!media || !image || !video || !toggle) {
        return;
    }

    toggle.addEventListener('click', function () {
        var showingVideo = !video.classList.contains('stitch-media-hidden');
        video.classList.toggle('stitch-media-hidden', showingVideo);
        image.classList.toggle('stitch-media-hidden', !showingVideo);
        toggle.setAttribute('aria-pressed', showingVideo ? 'false' : 'true');

        if (!showingVideo && typeof video.play === 'function') {
            video.play().catch(function () {});
        } else if (typeof video.pause === 'function') {
            video.pause();
        }
    });
})();
</script>

<?php
get_footer();

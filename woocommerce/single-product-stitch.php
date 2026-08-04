<?php
/**
 * WooCommerce Single Product — Stitch Variant
 * Luxury split-layout product detail page inspired by Google Stitch design.
 * Activated via ?tpl=stitch URL parameter for A/B comparison.
 *
 * Same ACF fields as the default template — drop-in alternative.
 */

defined('ABSPATH') || exit;

get_header('shop');

while (have_posts()) :
    the_post();
    global $product;
    $product_id = get_the_ID();

    /* ── Product Data ───────────────────────────────────── */
    $categories      = get_the_terms($product_id, 'product_cat');
    $primary_category = ($categories && !is_wp_error($categories)) ? reset($categories) : false;
    $category_link   = $primary_category ? get_term_link($primary_category) : false;
    $short_desc      = apply_filters('woocommerce_short_description', $product ? $product->get_short_description() : '');

    $video_url   = allscented_field('product_video_url', '', $product_id);
    $video_label = allscented_field('product_video_label', 'Cinematic Preview', $product_id);
    $chip_for    = allscented_field('product_chip_for', '', $product_id);
    $chip_mood   = allscented_field('product_chip_mood', '', $product_id);
    $chip_scene  = allscented_field('product_chip_scene', '', $product_id);

    $chips = array_filter(array(
        'for'   => $chip_for !== '' ? 'For ' . $chip_for : '',
        'mood'  => $chip_mood !== '' ? 'Mood: ' . $chip_mood : '',
        'scene' => $chip_scene !== '' ? 'Scene: ' . $chip_scene : '',
    ));

    $journey   = function_exists('get_field') ? get_field('product_journey', $product_id) : array();
    $journey   = is_array($journey) ? array_values(array_filter($journey, fn($r) => !empty($r['stage']) || !empty($r['notes']))) : array();
    $scenarios = function_exists('get_field') ? get_field('product_scenarios', $product_id) : array();
    $scenarios = is_array($scenarios) ? array_values(array_filter($scenarios, fn($r) => !empty($r['title']) || !empty($r['desc']))) : array();
    $dna       = function_exists('get_field') ? get_field('product_dna', $product_id) : array();
    $dna       = is_array($dna) ? array_values(array_filter($dna, fn($r) => !empty($r['title']) || !empty($r['desc']))) : array();
    $specs     = function_exists('get_field') ? get_field('product_specs', $product_id) : array();
    $specs     = is_array($specs) ? array_values(array_filter($specs, fn($r) => !empty($r['label']) || !empty($r['value']))) : array();

    $featured_id  = get_post_thumbnail_id($product_id);
    $featured_url = $featured_id ? wp_get_attachment_image_url($featured_id, 'woocommerce_single') : '';
    $featured_alt = $featured_id ? get_post_meta($featured_id, '_wp_attachment_image_alt', true) : '';
    $has_media    = ($featured_id || $video_url !== '');
?>

<style>
/* ── Stitch Variant Scoped Styles ─────────────────── */
.stitch-page{padding-top:64px;padding-bottom:0;overflow:hidden}
.stitch-hero{display:flex;flex-direction:row;min-height:90vh;align-items:stretch}
.stitch-hero-visual{position:relative;width:55%;background:#1a1c1c;display:flex;align-items:center;justify-content:center;overflow:hidden}
.stitch-hero-visual::after{content:'';position:absolute;inset:0;background:url('https://www.transparenttextures.com/patterns/dark-matter.png');opacity:.08;pointer-events:none}
.stitch-hero-visual img,.stitch-hero-visual video{width:100%;height:100%;object-fit:cover;transition:filter 1s}
.stitch-hero-visual:hover img{filter:grayscale(0)!important}
.stitch-hero-frame{position:absolute;inset:24px;border:1px solid rgba(233,193,118,.2);pointer-events:none}
.stitch-hero-info{width:45%;display:flex;flex-direction:column;justify-content:center;padding:80px 64px}
.stitch-hero-label{font-family:'Hanken Grotesk',sans-serif;font-size:11px;letter-spacing:.25em;text-transform:uppercase;color:#775a19;margin-bottom:24px}
.stitch-hero-title{font-family:'Playfair Display',serif;font-size:clamp(36px,5vw,64px);font-weight:600;line-height:1.1;margin:0 0 28px;color:var(--on-surface)}
.stitch-hero-quote{font-family:'Playfair Display',serif;font-style:italic;font-size:17px;line-height:1.7;color:var(--on-surface-variant);border-left:2px solid rgba(119,90,25,.3);padding-left:20px;margin:0 0 40px}
.stitch-specs-grid{display:grid;grid-template-columns:1fr 1fr;gap:28px 32px;margin-bottom:40px}
.stitch-spec-label{font-family:'Hanken Grotesk',sans-serif;font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--on-surface-variant);margin-bottom:6px}
.stitch-spec-value{font-family:'Playfair Display',serif;font-size:22px;font-weight:500;color:var(--on-surface)}
.stitch-cta-group{display:flex;gap:16px;align-items:center;flex-wrap:wrap}
.stitch-cta-primary{display:inline-flex;align-items:center;gap:8px;background:var(--on-surface);color:var(--surface-bright);font-family:'Hanken Grotesk',sans-serif;font-size:13px;letter-spacing:.1em;text-transform:uppercase;padding:16px 36px;border-radius:999px;text-decoration:none;border:none;cursor:pointer;transition:all .3s}
.stitch-cta-primary:hover{opacity:.85;transform:scale(.97)}
.stitch-cta-secondary{display:inline-flex;align-items:center;gap:6px;font-family:'Hanken Grotesk',sans-serif;font-size:13px;letter-spacing:.1em;text-transform:uppercase;color:var(--on-surface);text-decoration:none;border-bottom:1px solid rgba(0,0,0,.2);padding-bottom:4px;transition:border-color .3s}
.stitch-cta-secondary:hover{border-color:var(--secondary)}
.stitch-divider{width:80px;height:1px;background:#775a19;margin:0 auto}

/* ── Feature Section ──────────────────────────────── */
.stitch-features{padding:100px 0;background:var(--surface-container-low)}
.stitch-features-inner{max-width:1200px;margin:0 auto;padding:0 40px}
.stitch-section-header{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:60px;gap:24px;flex-wrap:wrap}
.stitch-section-header h2{font-family:'Playfair Display',serif;font-size:clamp(28px,3.5vw,48px);font-weight:600;margin:0;color:var(--on-surface)}
.stitch-section-header p{font-size:16px;color:var(--on-surface-variant);margin:0;max-width:560px}
.stitch-features-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1px;background:rgba(196,199,199,.3)}
.stitch-feature-cell{background:var(--surface-bright);padding:48px 36px;transition:background .4s}
.stitch-feature-cell:hover{background:var(--surface-container)}
.stitch-feature-icon{font-size:28px;color:#775a19;margin-bottom:28px}
.stitch-feature-title{font-family:'Playfair Display',serif;font-size:22px;font-weight:500;margin:0 0 14px;color:var(--on-surface)}
.stitch-feature-desc{font-size:14px;line-height:1.7;color:var(--on-surface-variant);margin:0 0 16px}
.stitch-feature-value{font-family:'Hanken Grotesk',sans-serif;font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:#775a19}

/* ── Story Section (Journey / Scenarios / DNA) ────── */
.stitch-story{padding:100px 0;background:var(--on-surface);color:var(--surface-bright)}
.stitch-story-inner{max-width:1200px;margin:0 auto;padding:0 40px}
.stitch-story-header{text-align:center;margin-bottom:60px}
.stitch-story-header h2{font-family:'Playfair Display',serif;font-size:clamp(28px,3.5vw,48px);font-weight:600;margin:0 0 12px;color:var(--surface-bright)}
.stitch-story-header p{font-size:16px;color:rgba(255,255,255,.6);margin:0}
.stitch-story-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:32px}
.stitch-story-card{border:1px solid rgba(255,255,255,.08);padding:40px;position:relative;transition:border-color .4s}
.stitch-story-card:hover{border-color:rgba(233,193,118,.3)}
.stitch-story-stage{font-family:'Hanken Grotesk',sans-serif;font-size:11px;letter-spacing:.18em;text-transform:uppercase;color:#e9c176;margin-bottom:16px;display:block}
.stitch-story-title{font-family:'Playfair Display',serif;font-size:24px;font-weight:500;margin:0 0 14px;color:var(--surface-bright)}
.stitch-story-desc{font-size:14px;line-height:1.75;color:rgba(255,255,255,.65);margin:0}

/* ── Specs Table (Dark) ──────────────────────────── */
.stitch-specs{padding:100px 0;background:var(--on-surface)}
.stitch-specs-inner{max-width:1200px;margin:0 auto;padding:0 40px}
.stitch-specs-table{display:grid;grid-template-columns:1fr 1fr;border:1px solid rgba(255,255,255,.08)}
.stitch-specs-cell{padding:28px 32px;border-bottom:1px solid rgba(255,255,255,.08);display:flex;justify-content:space-between;align-items:center}
.stitch-specs-cell:nth-child(odd){border-right:1px solid rgba(255,255,255,.08)}
.stitch-specs-cell .label{font-family:'Hanken Grotesk',sans-serif;font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.4)}
.stitch-specs-cell .value{font-family:'Playfair Display',serif;font-size:20px;color:var(--surface-bright)}

/* ── Related Products ────────────────────────────── */
.stitch-related{padding:100px 0;background:var(--surface-bright)}
.stitch-related-inner{max-width:1200px;margin:0 auto;padding:0 40px}
.stitch-related-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.stitch-related-card{display:block;text-decoration:none;color:inherit;transition:transform .4s}
.stitch-related-card:hover{transform:translateY(-4px)}
.stitch-related-media{aspect-ratio:4/5;border-radius:12px;overflow:hidden;background:var(--surface-container);margin-bottom:20px}
.stitch-related-media img{width:100%;height:100%;object-fit:cover;filter:grayscale(15%);transition:filter .6s,transform .6s}
.stitch-related-card:hover .stitch-related-media img{filter:grayscale(0);transform:scale(1.04)}
.stitch-related-name{font-family:'Playfair Display',serif;font-size:18px;font-weight:500;margin:0 0 6px;color:var(--on-surface)}
.stitch-related-price{font-size:14px;color:#775a19;margin:0}

/* ── Sticky Buy Bar (Mobile) ─────────────────────── */
.stitch-buy-bar{display:none;position:fixed;bottom:0;left:0;right:0;z-index:50;background:var(--surface-bright);border-top:1px solid var(--outline-variant);padding:12px 20px;align-items:center;justify-content:space-between;gap:12px}
.stitch-buy-bar-title{font-family:'Playfair Display',serif;font-size:15px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:45%}
.stitch-buy-bar-price{font-size:14px;color:#775a19;font-weight:600;white-space:nowrap}
.stitch-buy-bar-btn{background:var(--on-surface);color:var(--surface-bright);font-family:'Hanken Grotesk',sans-serif;font-size:12px;letter-spacing:.1em;text-transform:uppercase;padding:10px 24px;border-radius:999px;border:none;cursor:pointer;white-space:nowrap}

/* ── Breadcrumb (Stitch) ─────────────────────────── */
.stitch-breadcrumb{padding:24px 40px 0;max-width:1200px;margin:0 auto}
.stitch-breadcrumb nav{font-family:'Hanken Grotesk',sans-serif;font-size:11px;letter-spacing:.08em;color:var(--on-surface-variant);text-transform:uppercase;display:flex;flex-wrap:wrap;gap:6px;align-items:center}
.stitch-breadcrumb a{color:inherit;text-decoration:none}
.stitch-breadcrumb a:hover{color:var(--secondary)}
.stitch-breadcrumb .sep{color:#775a19}

/* ── Responsive ──────────────────────────────────── */
@media(max-width:900px){
    .stitch-hero{flex-direction:column;min-height:auto}
    .stitch-hero-visual{width:100%;height:50vh}
    .stitch-hero-info{width:100%;padding:40px 24px}
    .stitch-specs-grid{grid-template-columns:1fr 1fr;gap:20px}
    .stitch-features-grid{grid-template-columns:1fr}
    .stitch-story-grid{grid-template-columns:1fr}
    .stitch-specs-table{grid-template-columns:1fr}
    .stitch-specs-cell:nth-child(odd){border-right:none}
    .stitch-related-grid{grid-template-columns:1fr 1fr;gap:16px}
    .stitch-buy-bar{display:flex}
    .stitch-page{padding-bottom:70px}
}
@media(max-width:480px){
    .stitch-related-grid{grid-template-columns:1fr}
    .stitch-hero-info{padding:32px 20px}
}

/* ── Scroll Reveal ───────────────────────────────── */
.stitch-reveal{opacity:0;transform:translateY(24px);transition:opacity .7s ease,transform .7s ease}
.stitch-reveal.visible{opacity:1;transform:none}

/* ── Product Details Content (from default template) */
.stitch-details{padding:80px 0;background:var(--surface-bright)}
.stitch-details-inner{max-width:760px;margin:0 auto;padding:0 24px}
.stitch-details-content p{margin:0 0 18px;line-height:1.8;color:var(--on-surface-variant);font-size:15px}
.stitch-details-content ul{padding-left:20px;margin:0 0 18px}
.stitch-details-content li{margin-bottom:8px;line-height:1.7;color:var(--on-surface-variant);font-size:15px}
.stitch-details-content strong{color:var(--on-surface);font-weight:600}
.stitch-details-content img{width:100%;border-radius:12px;margin:24px 0}
</style>

<div class="stitch-page">

    <!-- Breadcrumb -->
    <div class="stitch-breadcrumb">
        <nav aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">AllScented</a>
            <?php if ($primary_category && !is_wp_error($category_link)) : ?>
                <span class="sep" aria-hidden="true">/</span>
                <a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($primary_category->name); ?></a>
            <?php endif; ?>
            <span class="sep" aria-hidden="true">/</span>
            <span aria-current="page"><?php echo esc_html(get_the_title()); ?></span>
        </nav>
    </div>

    <!-- ═══ Hero Section: 55/45 Split ═══ -->
    <section class="stitch-hero stitch-reveal">
        <div class="stitch-hero-visual">
            <?php if ($has_media) : ?>
                <?php if ($video_url !== '') : ?>
                    <video controls preload="metadata" poster="<?php echo esc_url($featured_url); ?>" src="<?php echo esc_url($video_url); ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"></video>
                <?php elseif ($featured_url) : ?>
                    <img src="<?php echo esc_url($featured_url); ?>" alt="<?php echo esc_attr($featured_alt); ?>" style="filter:grayscale(15%)">
                <?php endif; ?>
            <?php endif; ?>
            <div class="stitch-hero-frame"></div>
        </div>

        <div class="stitch-hero-info">
            <?php if ($primary_category && !is_wp_error($category_link)) : ?>
                <div class="stitch-hero-label"><?php echo esc_html($primary_category->name); ?></div>
            <?php else : ?>
                <div class="stitch-hero-label">Allscented</div>
            <?php endif; ?>

            <h1 class="stitch-hero-title"><?php echo esc_html(get_the_title()); ?></h1>

            <?php if ($short_desc) : ?>
                <p class="stitch-hero-quote"><?php echo wp_kses_post($short_desc); ?></p>
            <?php endif; ?>

            <!-- Specs Grid -->
            <?php if ($specs) : ?>
            <div class="stitch-specs-grid">
                <?php foreach (array_slice($specs, 0, 4) as $spec) : ?>
                <div>
                    <div class="stitch-spec-label"><?php echo esc_html($spec['label'] ?? ''); ?></div>
                    <div class="stitch-spec-value"><?php echo esc_html($spec['value'] ?? ''); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Price -->
            <?php if ($product) : ?>
            <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:#775a19;margin-bottom:32px;">
                <?php echo $product->get_price_html(); ?>
            </div>
            <?php endif; ?>

            <!-- Add to Cart -->
            <div class="stitch-cta-group">
                <?php if ($product) : ?>
                    <?php woocommerce_template_single_add_to_cart(); ?>
                <?php endif; ?>
                <?php if ($specs) : ?>
                    <a class="stitch-cta-secondary" href="#stitch-specs">
                        <span class="material-symbols-outlined" style="font-size:16px;">info</span>
                        Specs
                    </a>
                <?php endif; ?>
            </div>

            <!-- Trust Badges -->
            <div style="display:flex;flex-wrap:wrap;gap:16px;margin-top:28px;border-top:1px solid rgba(196,199,199,.3);padding-top:20px;font-family:'Hanken Grotesk',sans-serif;font-size:11px;letter-spacing:.06em;color:var(--on-surface-variant);">
                <div style="display:flex;align-items:center;gap:5px;">
                    <span class="material-symbols-outlined" style="font-size:15px;color:#775a19;">local_shipping</span>
                    Free Shipping
                </div>
                <div style="display:flex;align-items:center;gap:5px;">
                    <span class="material-symbols-outlined" style="font-size:15px;color:#775a19;">autorenew</span>
                    Easy Returns
                </div>
                <div style="display:flex;align-items:center;gap:5px;">
                    <span class="material-symbols-outlined" style="font-size:15px;color:#775a19;">lock</span>
                    Secure Checkout
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ Product Details (Description) ═══ -->
    <?php
    $product_details = allscented_clean_product_description((string) ($product ? $product->get_description() : ''));
    if ($product_details !== '') :
    ?>
    <section class="stitch-details stitch-reveal">
        <div class="stitch-section-header" style="justify-content:center;text-align:center;margin-bottom:40px;">
            <h2 style="font-family:'Hanken Grotesk',sans-serif;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#775a19;">The Details</h2>
        </div>
        <div class="stitch-divider" style="margin-bottom:40px;"></div>
        <div class="stitch-details-content"><?php echo $product_details; ?></div>
    </section>
    <?php endif; ?>

    <!-- ═══ Features Grid ═══ -->
    <?php if ($dna) : $dna_title = allscented_field('product_dna_title', 'Signature Elements', $product_id); $dna_intro = allscented_field('product_dna_intro', '', $product_id); ?>
    <section class="stitch-features stitch-reveal">
        <div class="stitch-features-inner">
            <div class="stitch-section-header">
                <div>
                    <h2><?php echo esc_html($dna_title); ?></h2>
                    <?php if ($dna_intro !== '') : ?><p><?php echo nl2br(esc_html($dna_intro)); ?></p><?php endif; ?>
                </div>
            </div>
            <div class="stitch-features-grid">
                <?php foreach ($dna as $row) : $dna_icon = !empty($row['icon']) ? $row['icon'] : 'auto_awesome'; ?>
                <div class="stitch-feature-cell">
                    <div class="stitch-feature-icon"><span class="material-symbols-outlined"><?php echo esc_html($dna_icon); ?></span></div>
                    <?php if (!empty($row['title'])) : ?><h3 class="stitch-feature-title"><?php echo esc_html($row['title']); ?></h3><?php endif; ?>
                    <?php if (!empty($row['desc'])) : ?><p class="stitch-feature-desc"><?php echo nl2br(esc_html($row['desc'])); ?></p><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ═══ Journey / Scenarios (Dark Section) ═══ -->
    <?php if ($journey || $scenarios) :
        $journey_title = allscented_field('product_journey_title', 'The Olfactory Journey', $product_id);
    ?>
    <section class="stitch-story stitch-reveal">
        <div class="stitch-story-inner">
            <div class="stitch-story-header">
                <h2><?php echo esc_html($journey_title); ?></h2>
            </div>

            <?php if ($journey) : ?>
            <div class="stitch-story-grid" style="margin-bottom:60px;">
                <?php foreach ($journey as $row) : ?>
                <div class="stitch-story-card">
                    <?php if (!empty($row['stage'])) : ?><span class="stitch-story-stage"><?php echo esc_html($row['stage']); ?></span><?php endif; ?>
                    <?php if (!empty($row['notes'])) :
                        $note_lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $row['notes'])), 'strlen'));
                    ?>
                    <ul class="stitch-story-desc" style="list-style:none;padding:0;">
                        <?php foreach ($note_lines as $line) : ?>
                        <li style="padding:4px 0;border-bottom:1px solid rgba(255,255,255,.05);"><?php echo esc_html($line); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($scenarios) :
                $scenarios_title = allscented_field('product_scenarios_title', 'Atmospheric Resonance', $product_id);
            ?>
            <div class="stitch-story-header" style="margin-top:60px;">
                <h2><?php echo esc_html($scenarios_title); ?></h2>
            </div>
            <div class="stitch-story-grid">
                <?php foreach ($scenarios as $row) :
                    $scenario_image = allscented_acf_media_url(isset($row['image']) ? $row['image'] : '');
                ?>
                <div class="stitch-story-card">
                    <?php if ($scenario_image !== '') : ?>
                    <div style="border-radius:8px;overflow:hidden;margin-bottom:20px;aspect-ratio:16/10;">
                        <img src="<?php echo esc_url($scenario_image); ?>" alt="<?php echo esc_attr($row['title'] ?? ''); ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($row['title'])) : ?><h3 class="stitch-story-title"><?php echo esc_html($row['title']); ?></h3><?php endif; ?>
                    <?php if (!empty($row['desc'])) : ?><p class="stitch-story-desc"><?php echo nl2br(esc_html($row['desc'])); ?></p><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ═══ Technical Specs (Dark) ═══ -->
    <?php if ($specs) : $specs_title = allscented_field('product_specs_title', 'Technical Specs', $product_id); ?>
    <section class="stitch-specs stitch-reveal" id="stitch-specs">
        <div class="stitch-specs-inner">
            <div class="stitch-story-header" style="margin-bottom:40px;">
                <h2 style="font-size:11px;letter-spacing:.18em;text-transform:uppercase;font-family:'Hanken Grotesk',sans-serif;font-weight:600;"><?php echo esc_html($specs_title); ?></h2>
            </div>
            <div class="stitch-specs-table">
                <?php foreach ($specs as $spec) : ?>
                <div class="stitch-specs-cell">
                    <span class="label"><?php echo esc_html($spec['label'] ?? ''); ?></span>
                    <span class="value"><?php echo esc_html($spec['value'] ?? ''); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ═══ You May Also Like ═══ -->
    <?php
    $related_ids = function_exists('wc_get_related_products') ? (array) wc_get_related_products($product_id, 3) : array();
    $related_title = allscented_field('product_related_title', 'You May Also Like', $product_id);
    $related_intro = allscented_field('product_related_intro', '', $product_id);
    if (!empty($related_ids)) :
    ?>
    <section class="stitch-related stitch-reveal">
        <div class="stitch-related-inner">
            <div class="stitch-section-header" style="justify-content:center;text-align:center;">
                <div>
                    <h2><?php echo esc_html($related_title); ?></h2>
                    <?php if ($related_intro !== '') : ?><p><?php echo nl2br(esc_html($related_intro)); ?></p><?php endif; ?>
                </div>
            </div>
            <div class="stitch-related-grid">
                <?php
                $original_product = $product;
                foreach ($related_ids as $rid) :
                    $rp = function_exists('wc_get_product') ? wc_get_product($rid) : false;
                    if (!$rp) continue;
                    $r_thumb = get_the_post_thumbnail($rid, 'woocommerce_thumbnail', array('loading' => 'lazy'));
                ?>
                <a href="<?php echo esc_url(get_permalink($rid)); ?>" class="stitch-related-card">
                    <div class="stitch-related-media">
                        <?php if ($r_thumb) : echo $r_thumb; else : ?>
                            <span style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--outline-variant);"><span class="material-symbols-outlined" style="font-size:32px;">image</span></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="stitch-related-name"><?php echo esc_html($rp->get_name()); ?></h3>
                    <div class="stitch-related-price"><?php echo $rp->get_price_html(); ?></div>
                </a>
                <?php endforeach; $product = $original_product; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php do_action('woocommerce_after_single_product_summary'); ?>

    <!-- Sticky Buy Bar (Mobile) -->
    <div class="stitch-buy-bar" id="stitch-buy-bar">
        <span class="stitch-buy-bar-title"><?php echo esc_html(get_the_title()); ?></span>
        <span class="stitch-buy-bar-price"><?php echo $product ? $product->get_price_html() : ''; ?></span>
        <button class="stitch-buy-bar-btn" onclick="document.querySelector('.single_add_to_cart_button')?.click()">Add to Cart</button>
    </div>

</div><!-- .stitch-page -->

<script>
(function(){
    /* Scroll Reveal */
    var obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){ if(e.isIntersecting) e.target.classList.add('visible'); });
    },{threshold:0.08,rootMargin:'0px 0px -40px 0px'});
    document.querySelectorAll('.stitch-reveal').forEach(function(el){ obs.observe(el); });

    /* Sticky buy bar: show after scrolling past hero */
    var bar = document.getElementById('stitch-buy-bar');
    if(bar){
        var hero = document.querySelector('.stitch-hero');
        if(hero){
            var ro = new IntersectionObserver(function(entries){
                bar.style.display = entries[0].isIntersecting ? 'none' : 'flex';
            },{threshold:0});
            ro.observe(hero);
        }
    }
})();
</script>

<?php endwhile; ?>

<?php get_footer('shop'); ?>

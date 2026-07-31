<?php
/**
 * Template Name: Archive
 */
get_header();

// ===== ACF fields =====
$arc_eyebrow = allscented_field('allscented_archive_eyebrow', 'FRAGRANCE ARCHIVE');
$arc_title   = allscented_field('allscented_archive_title', 'Browse by Category');
$arc_desc    = allscented_field('allscented_archive_desc', 'Explore our complete library of AI-synthesized scents, curated for every space and experience.');

$products = array();
for ($i = 1; $i <= 4; $i++) {
    $products[$i] = array(
        'img'    => allscented_image_url("allscented_archive_p{$i}_img", ''),
        'name'   => allscented_field("allscented_archive_p{$i}_name", ''),
        'desc'   => allscented_field("allscented_archive_p{$i}_desc", ''),
        'tag1'   => allscented_field("allscented_archive_p{$i}_tag1", ''),
        'tag2'   => allscented_field("allscented_archive_p{$i}_tag2", ''),
        'price'  => allscented_field("allscented_archive_p{$i}_price", ''),
        'cat'    => allscented_field("allscented_archive_p{$i}_cat", ''),
        'custom' => allscented_field("allscented_archive_p{$i}_custom", ''),
    );
}
$p_defaults = array(
    1 => array('img' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=300&q=80', 'name' => 'Vesper Muse', 'desc' => 'Night-blooming jasmine, metallic aldehydes, grey amber.', 'tag1' => 'INTIMATE', 'tag2' => 'EVENING', 'price' => '$185.00', 'cat' => 'personal', 'custom' => ''),
    2 => array('img' => 'https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=300&q=80', 'name' => 'Aura No. 1', 'desc' => 'Ozone, white musk, sea salt. A morning walk through coastal mist.', 'tag1' => 'SERENE', 'tag2' => 'MORNING', 'price' => '$185.00', 'cat' => 'personal', 'custom' => ''),
    3 => array('img' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=300&q=80', 'name' => 'Atmospheric Flux', 'desc' => 'Cedarwood, amber, petrichor. Adapts to light cycles and biometric data.', 'tag1' => 'ADAPTIVE', 'tag2' => 'SPACE', 'price' => '$240.00', 'cat' => 'home', 'custom' => ''),
    4 => array('img' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=300&q=80', 'name' => 'Brand Osmosis', 'desc' => 'Saffron, leather, smoke. Architectural scenting for luxury retail environments.', 'tag1' => 'LUXURY', 'tag2' => 'RETAIL', 'price' => '', 'cat' => 'commercial', 'custom' => 'CUSTOM'),
);
foreach ($p_defaults as $i => $d) {
    foreach ($d as $k => $v) {
        if (empty($products[$i][$k])) $products[$i][$k] = $v;
    }
}

$cta_eyebrow = allscented_field('allscented_archive_cta_eyebrow', 'CURIOUS?');
$cta_title   = allscented_field('allscented_archive_cta_title', "Can't find what you're looking for?");
$cta_desc    = allscented_field('allscented_archive_cta_desc', 'Our AI can create a bespoke scent from a single word. Describe what you imagine.');
$cta_btn     = allscented_field('allscented_archive_cta_btn', 'Begin Your Brief');

// Group products by category
$by_cat = array('personal' => array(), 'home' => array(), 'commercial' => array());
foreach ($products as $p) {
    $cat = !empty($p['cat']) ? $p['cat'] : 'personal';
    $by_cat[$cat][] = $p;
}
$cat_labels = array('personal' => 'FOR PERSONAL', 'home' => 'FOR HOME', 'commercial' => 'FOR COMMERCIAL');
?>
<div id="page-archive">
    <section class="px-margin-desktop container-max" style="padding-top:24px;padding-bottom:12px">
        <div class="max-w-2xl">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px"><?php echo esc_html($arc_eyebrow); ?></span>
            <h1 class="font-headline-xl text-headline-xl" style="margin-bottom:4px"><?php echo esc_html($arc_title); ?></h1>
            <p class="font-body-lg text-on-surface-variant" style="font-size:14px"><?php echo esc_html($arc_desc); ?></p>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="display:flex;gap:8px;overflow-x:auto;-webkit-overflow-scrolling:touch;padding-bottom:4px;margin-bottom:20px">
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--secondary);color:var(--secondary);background:none;white-space:nowrap;font-size:12px" data-filter="all">All</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:12px" data-filter="personal">Personal</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:12px" data-filter="home">Home</button>
            <button class="font-label-caps text-label-caps filter-btn" style="padding:6px 14px;border-radius:999px;border:1px solid var(--outline-variant);color:var(--on-surface-variant);background:none;white-space:nowrap;font-size:12px" data-filter="commercial">Commercial</button>
        </div>
        <?php foreach ($by_cat as $cat_key => $items) : if (empty($items)) continue; ?>
        <div id="archive-<?php echo esc_attr($cat_key); ?>" style="margin-bottom:24px">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:12px"><?php echo esc_html($cat_labels[$cat_key]); ?></span>
                <div style="flex:1;height:1px;background:color-mix(in srgb,var(--outline-variant)30%,transparent)"></div>
            </div>
            <div class="archive-items-grid">
                <?php foreach ($items as $p) : ?>
                <div class="aura-glass archive-item" style="border-radius:12px;padding:14px;display:flex;gap:12px" data-category="<?php echo esc_attr($cat_key); ?>">
                    <div style="width:104px;height:104px;border-radius:8px;overflow:hidden;flex-shrink:0">
                        <img src="<?php echo esc_url($p['img']); ?>" alt="<?php echo esc_attr($p['name']); ?>" style="width:100%;height:100%;object-fit:cover" loading="lazy">
                    </div>
                    <div style="flex:1;min-width:0">
                        <h3 class="font-headline-md" style="font-size:15px;font-style:italic;margin-bottom:2px"><?php echo esc_html($p['name']); ?></h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:11px;margin-bottom:4px"><?php echo esc_html($p['desc']); ?></p>
                        <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:4px">
                            <?php if (!empty($p['tag1'])) : ?>
                            <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)"><?php echo esc_html($p['tag1']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($p['tag2'])) : ?>
                            <span class="font-label-caps" style="font-size:11px;padding:2px 6px;border-radius:4px;background:var(--surface-container-high);color:var(--on-surface-variant)"><?php echo esc_html($p['tag2']); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($p['price'])) : ?>
                        <span class="font-body-md" style="color:var(--on-surface);font-size:13px"><?php echo esc_html($p['price']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($p['custom'])) : ?>
                        <span class="font-label-caps" style="font-size:11px;padding:2px 8px;border-radius:4px;background:color-mix(in srgb,var(--secondary-container)30%,transparent);color:var(--secondary)"><?php echo esc_html($p['custom']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div class="bg-on-surface" style="border-radius:24px;padding:24px;text-align:center;color:var(--surface)">
            <span class="font-label-caps text-label-caps" style="color:var(--secondary-fixed);margin-bottom:4px;display:block"><?php echo esc_html($cta_eyebrow); ?></span>
            <h2 class="font-headline-lg text-headline-lg" style="margin-bottom:6px;font-style:italic"><?php echo esc_html($cta_title); ?></h2>
            <p class="font-body-md" style="margin-bottom:12px;color:var(--surface-variant);font-size:13px"><?php echo esc_html($cta_desc); ?></p>
            <a class="iridescent-btn font-label-caps text-label-caps" style="padding:10px 24px;border-radius:999px;font-size:12px" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>"><?php echo esc_html($cta_btn); ?></a>
        </div>
    </section>
</div>
<!-- ===== THE ATELIER ===== -->

<?php get_footer(); ?>

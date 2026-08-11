<?php
/**
 * Template Name: Front Page
 */
get_header();

// ===== Home page ID (fields are stored on page slug 'home' / static front page) =====
$allscented_home_id = (int) get_option('page_on_front');
if (!$allscented_home_id) {
    $allscented_home_page = get_page_by_path('home');
    $allscented_home_id = $allscented_home_page ? (int) $allscented_home_page->ID : 0;
}
$allscented_home_id = $allscented_home_id ? $allscented_home_id : false;

// ===== ACF fields (fallback to defaults if not set) =====
$h_hero_badge   = allscented_field('allscented_home_hero_badge', 'ALLSCENTED · SENSORY INTELLIGENCE', $allscented_home_id);
$h_hero_title   = allscented_field('allscented_home_hero_title', 'Where Memory Becomes Scent', $allscented_home_id);
$h_hero_sub     = allscented_field('allscented_home_hero_subtitle', 'AI-powered fragrance synthesis from your most intimate narratives', $allscented_home_id);
$h_hero_cta     = allscented_field('allscented_home_hero_cta', 'BEGIN YOUR AI SYNTHESIS', $allscented_home_id);
$h_hero_img     = allscented_image_url('allscented_home_hero_image', 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=1500&q=85', $allscented_home_id);

$guides = array();
for ($i = 1; $i <= 3; $i++) {
    $guides[$i] = array(
        'icon'   => allscented_group_field("allscented_home_g{$i}", 'icon', '', $allscented_home_id),
        'avatar' => allscented_group_field("allscented_home_g{$i}", 'avatar', '', $allscented_home_id),
        'label'  => allscented_group_field("allscented_home_g{$i}", 'label', '', $allscented_home_id),
        'name'   => allscented_group_field("allscented_home_g{$i}", 'name', '', $allscented_home_id),
        'desc'   => allscented_group_field("allscented_home_g{$i}", 'desc', '', $allscented_home_id),
        'tag1'   => allscented_group_field("allscented_home_g{$i}", 'tag1', '', $allscented_home_id),
        'tag2'   => allscented_group_field("allscented_home_g{$i}", 'tag2', '', $allscented_home_id),
        'cta'    => allscented_group_field("allscented_home_g{$i}", 'cta', '', $allscented_home_id),
    );
}
// Fill fallbacks if fields empty
$guide_defaults = array(
    1 => array('icon' => 'spa', 'avatar' => '', 'label' => 'AI SCENT THERAPIST · LUNÁ', 'name' => 'The Healer', 'desc' => 'Tell me how you feel today. I listen, I understand — and I find a fragrance that speaks to your heart.', 'tag1' => 'EMOTIONAL', 'tag2' => 'THERAPEUTIC', 'cta' => 'Start consultation'),
    2 => array('icon' => 'auto_awesome', 'avatar' => '', 'label' => 'AI SCENT FORTUNE TELLER · ECHO', 'name' => 'The Mystic', 'desc' => 'Curious what the universe has in store for you? Let the stars guide your scent — for fun, for hope, for destiny.', 'tag1' => 'DIVINATION', 'tag2' => 'RITUAL', 'cta' => 'Cast your fortune'),
    3 => array('icon' => 'business_center', 'avatar' => '', 'label' => 'SCENT MEMORY CONSULTANT · SAGE', 'name' => 'The Strategist', 'desc' => 'For hotels, boutiques, and brands. I design a scent strategy that becomes part of your identity and drives results.', 'tag1' => 'COMMERCIAL', 'tag2' => 'BRANDING', 'cta' => 'Request consultation'),
);
foreach ($guide_defaults as $i => $d) {
    foreach ($d as $k => $v) {
        if (empty($guides[$i][$k])) $guides[$i][$k] = $v;
    }
}

$arc_eyebrow = allscented_field('allscented_home_arc_eyebrow', 'THE JOURNAL', $allscented_home_id);
$arc_title   = allscented_field('allscented_home_arc_title', 'Curated Synthetics', $allscented_home_id);
$arc_btn     = allscented_field('allscented_home_arc_btn', 'Explore Journal', $allscented_home_id);

$arc_cards = array();
for ($i = 1; $i <= 3; $i++) {
    $arc_cards[$i] = array(
        'img'   => allscented_image_url("allscented_home_arc{$i}_img", '', $allscented_home_id),
        'tag'   => allscented_field("allscented_home_arc{$i}_tag", '', $allscented_home_id),
        'title' => allscented_field("allscented_home_arc{$i}_title", '', $allscented_home_id),
        'desc'  => allscented_field("allscented_home_arc{$i}_desc", '', $allscented_home_id),
        'link'  => allscented_field("allscented_home_arc{$i}_link", '', $allscented_home_id),
    );
}
$arc_defaults = array(
    1 => array('img' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=800&q=80', 'tag' => 'FOR PERSONAL', 'title' => 'The Intimate Narrative', 'desc' => 'How AI decoded the scent of childhood nostalgia for a private collection.', 'link' => home_url('/journal/')),
    2 => array('img' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&q=80', 'tag' => 'FOR HOME', 'title' => 'Atmospheric Flux', 'desc' => 'Scents that adapt to light cycles and biometric data.', 'link' => home_url('/journal/')),
    3 => array('img' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=800&q=80', 'tag' => 'FOR COMMERCIAL', 'title' => 'Brand Osmosis', 'desc' => 'Architectural scenting for luxury retail.', 'link' => home_url('/journal/')),
);
foreach ($arc_defaults as $i => $d) {
    foreach ($d as $k => $v) {
        if (empty($arc_cards[$i][$k])) $arc_cards[$i][$k] = $v;
    }
}

$col_eyebrow  = allscented_field('allscented_home_col_eyebrow', 'THE COLLECTION', $allscented_home_id);
$col_title    = allscented_field('allscented_home_col_title', 'Signature Molecules', $allscented_home_id);
$col_main_img = allscented_image_url('allscented_home_col_main_img', 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=800&q=80', $allscented_home_id);
$col_main_lbl = allscented_field('allscented_home_col_main_label', 'THE ATELIER', $allscented_home_id);
$col_main_ttl = allscented_field('allscented_home_col_main_title', 'AI-Designed for You', $allscented_home_id);
$col_cta      = allscented_field('allscented_home_col_cta', 'SHOP THE ATELIER', $allscented_home_id);
$col_main_link = allscented_field('allscented_home_col_main_link', '', $allscented_home_id);
if (empty($col_main_link)) $col_main_link = home_url('/the-atelier/');

$col_products = array();
for ($i = 1; $i <= 2; $i++) {
    $col_products[$i] = array(
        'img'   => allscented_image_url("allscented_home_colp{$i}_img", '', $allscented_home_id),
        'name'  => allscented_field("allscented_home_colp{$i}_name", '', $allscented_home_id),
        'tag1'  => allscented_field("allscented_home_colp{$i}_tag1", '', $allscented_home_id),
        'tag2'  => allscented_field("allscented_home_colp{$i}_tag2", '', $allscented_home_id),
        'price' => allscented_field("allscented_home_colp{$i}_price", '', $allscented_home_id),
        'link'  => allscented_field("allscented_home_colp{$i}_link", '', $allscented_home_id),
    );
}
$colp_defaults = array(
    1 => array('img' => 'https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?w=400&q=80', 'name' => 'Aura No. 1', 'tag1' => 'SERENE', 'tag2' => 'MORNING', 'price' => '$185.00', 'link' => home_url('/the-atelier/')),
    2 => array('img' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=400&q=80', 'name' => 'Aura No. 2', 'tag1' => 'SEDUCTIVE', 'tag2' => 'TWILIGHT', 'price' => '$210.00', 'link' => home_url('/the-atelier/')),
);
foreach ($colp_defaults as $i => $d) {
    foreach ($d as $k => $v) {
        if (empty($col_products[$i][$k])) $col_products[$i][$k] = $v;
    }
}

// Guide color map (avatar bg / text color)
$guide_colors = array(
    1 => array('bg' => 'var(--secondary-container)', 'fg' => 'var(--secondary)', 'chip' => 'var(--secondary)'),
    2 => array('bg' => 'var(--tertiary-container)', 'fg' => 'var(--tertiary)', 'chip' => 'var(--tertiary)'),
    3 => array('bg' => 'var(--primary-container)', 'fg' => 'var(--primary)', 'chip' => 'var(--on-primary-fixed-variant)'),
);
?>
<div id="page-discover">
    <section class="hero-section" style="position:relative;width:100%;overflow:hidden;margin-bottom:12px">
        <div class="hero-bg" style="width:100%;min-height:clamp(240px,40vh,480px);position:relative;display:flex;align-items:center;justify-content:center">
            <img src="<?php echo esc_url($h_hero_img); ?>" alt="Artisanal fragrance concept" style="display:block" class="hero-image">
            <div style="position:absolute;inset:0;background:linear-gradient(180deg, rgba(28,27,27,0.45) 0%, rgba(28,27,27,0.15) 45%, rgba(28,27,27,0.75) 100%);z-index:1"></div>
            <div style="position:absolute;inset:0;z-index:2;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;text-align:center;padding:24px 16px clamp(32px,7vh,80px);max-width:600px;margin:0 auto">
                <span class="font-label-caps" style="font-size:clamp(10px,2vw,13px);letter-spacing:.15em;color:rgba(255,255,255,0.7);display:block;margin-bottom:8px;text-transform:uppercase"><?php echo esc_html($h_hero_badge); ?></span>
                <h1 class="hero-title" style="font-family:'Playfair Display',serif;font-weight:500;font-style:italic;font-size:clamp(30.8px,5.5vw,61.6px);line-height:1.1;color:#fff;margin:0 0 12px"><?php echo esc_html($h_hero_title); ?></h1>
                <p class="hero-subtitle" style="font-family:'Hanken Grotesk',sans-serif;font-weight:300;font-size:clamp(13px,1.5vw,16px);color:rgba(255,255,255,0.8);margin:0 0 20px;max-width:480px;margin-left:auto;margin-right:auto"><?php echo esc_html($h_hero_sub); ?></p>
                <div style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap">
                    <a href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>" class="iridescent-btn" style="padding:10px 28px;border-radius:999px;font-family:'Hanken Grotesk',sans-serif;font-size:13px;font-weight:500;letter-spacing:.06em;color:#fff;text-decoration:none">
                        <?php echo esc_html($h_hero_cta); ?>
                    </a>
                </div>
            </div>
        </div>
        <div style="position:relative;z-index:3;margin-top:-2px;line-height:0">
            <svg viewBox="0 0 1440 60" preserveAspectRatio="none" style="width:100%;height:clamp(24px,4vw,60px);display:block">
                <path d="M0,40 C240,0 480,60 720,30 C960,0 1200,60 1440,30 L1440,60 L0,60 Z" fill="var(--surface)"/>
            </svg>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-top:12px;padding-bottom:12px">
        <div class="max-w-3xl">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px;font-size:11px;letter-spacing:.12em">MEET YOUR GUIDES</span>
            <h2 class="font-headline-lg text-headline-lg" style="margin-bottom:16px">Three ways to <span class="italic text-secondary">find your scent.</span></h2>
        </div>
        <div class="char-cards-grid" style="margin-bottom:0">
            <?php foreach ($guides as $i => $g) : $c = $guide_colors[$i]; ?>
            <div class="aura-glass char-card" style="border-radius:16px;padding:20px;display:flex;flex-direction:column;cursor:pointer">
                <div class="char-avatar" style="border-radius:999px;overflow:hidden;margin-bottom:12px;<?php echo $g['avatar'] ? '' : 'background:color-mix(in srgb,' . $c['bg'] . '40%,transparent);display:flex;align-items:center;justify-content:center;'; ?>">
                    <?php if (!empty($g['avatar'])) : ?>
                        <img src="<?php echo esc_url($g['avatar']); ?>" alt="<?php echo esc_attr($g['name']); ?>" style="width:100%;height:100%;object-fit:cover;border-radius:999px">
                    <?php else : ?>
                        <span class="material-symbols-outlined" style="color:<?php echo $c['fg']; ?>"><?php echo esc_html($g['icon']); ?></span>
                    <?php endif; ?>
                </div>
                <span class="font-label-caps text-label-caps text-secondary" style="font-size:12px;margin-bottom:2px;letter-spacing:.12em"><?php echo esc_html($g['label']); ?></span>
                <h3 class="font-headline-md" style="font-size:18px;margin-bottom:4px"><?php echo esc_html($g['name']); ?></h3>
                <p class="font-body-md guide-desc" style="font-size:13px;color:var(--on-surface-variant);flex:1;margin-bottom:10px"><?php echo esc_html($g['desc']); ?></p>
                <div style="display:flex;gap:4px;flex-wrap:wrap;margin-bottom:10px">
                    <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,<?php echo $c['bg']; ?>30%,transparent);color:<?php echo $c['chip']; ?>"><?php echo esc_html($g['tag1']); ?></span>
                    <span class="font-label-caps" style="font-size:11px;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,<?php echo $c['bg']; ?>30%,transparent);color:<?php echo $c['chip']; ?>"><?php echo esc_html($g['tag2']); ?></span>
                </div>
                <a class="font-label-caps guide-cta" style="font-size:12px;color:<?php echo $c['fg']; ?>;display:inline-flex;align-items:center;gap:4px;margin-top:auto;cursor:pointer" aria-label="<?php echo esc_attr($g['cta']); ?>" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>"><?php echo esc_html($g['cta']); ?> <span class="material-symbols-outlined" style="font-size:12px">arrow_forward</span></a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="background:color-mix(in srgb,var(--secondary-container)8%,transparent);border-radius:24px;padding:32px 16px 24px;margin-top:4px;margin-bottom:24px">
            <div style="text-align:center">
                <span class="font-label-caps" style="color:var(--secondary);font-size:14px;letter-spacing:.08em;display:block;margin-bottom:4px"><?php echo esc_html($arc_eyebrow); ?></span>
                <h2 style="font-family:'Playfair Display',serif;font-size:clamp(28px,4.5vw,48px);font-weight:600;color:var(--on-background);margin-top:6px"><?php echo esc_html($arc_title); ?></h2>
            </div>
            <div style="text-align:center;margin-bottom:16px">
                <a href="<?php echo esc_url(home_url('/journal/')); ?>" style="display:inline-flex;align-items:center;gap:6px;padding:12px 28px;border-radius:999px;border:1px solid var(--secondary);color:var(--secondary);text-decoration:none;font-family:'Hanken Grotesk',sans-serif;font-size:13px;font-weight:500;letter-spacing:.03em;transition:all .3s" onmouseover="this.style.borderColor='var(--primary)';this.style.color='var(--primary)'" onmouseout="this.style.borderColor='var(--secondary)';this.style.color='var(--secondary)'">
                    <?php echo esc_html($arc_btn); ?>
                    <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle">arrow_forward</span>
                </a>
            </div>
            <div id="home-archive-grid">
                <?php foreach ($arc_cards as $i => $card) : $card_link = !empty($card['link']) ? $card['link'] : home_url('/journal/'); ?>
                <a href="<?php echo esc_url($card_link); ?>" class="aura-glass archive-card" style="border-radius:12px;overflow:hidden;cursor:pointer;display:block;text-decoration:none;color:inherit">
                    <div style="aspect-ratio:4/3;overflow:hidden" class="group">
                        <img style="width:100%;height:100%;object-fit:cover;transition:transform .8s" class="group-hover:scale-105" src="<?php echo esc_url($card['img']); ?>" alt="<?php echo esc_attr($card['title']); ?>" loading="lazy">
                    </div>
                    <div class="archive-card-body" style="padding:16px 18px 18px">
                        <span class="font-label-caps text-label-caps text-secondary" style="display:block;margin-bottom:4px"><?php echo esc_html($card['tag']); ?></span>
                        <h3 class="font-headline-md" style="font-size:18px;margin-bottom:4px;font-style:italic"><?php echo esc_html($card['title']); ?></h3>
                        <p class="font-body-md text-on-surface-variant" style="font-size:12px;line-height:1.5"><?php echo esc_html($card['desc']); ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section class="px-margin-desktop container-max" style="padding-bottom:36px">
        <div style="text-align:center;margin-bottom:24px">
            <span class="font-label-caps text-label-caps text-secondary block" style="margin-bottom:4px"><?php echo esc_html($col_eyebrow); ?></span>
            <h2 class="font-headline-lg text-headline-lg"><?php echo esc_html($col_title); ?></h2>
        </div>
        <div class="collection-layout">
            <a href="<?php echo esc_url($col_main_link); ?>" class="collection-main" style="border-radius:16px;overflow:hidden;position:relative;display:block;text-decoration:none;color:inherit">
                <img src="<?php echo esc_url($col_main_img); ?>" alt="AllScented Collection" style="width:100%;height:100%;object-fit:cover;display:block" loading="lazy">
                <div style="position:absolute;inset:0;background:linear-gradient(to top,color-mix(in srgb,var(--surface)70%,transparent)0%,transparent 50%)"></div>
                <div style="position:absolute;bottom:16px;left:16px;right:16px">
                    <span class="font-label-caps text-label-caps" style="color:var(--surface);font-size:12px;letter-spacing:.12em"><?php echo esc_html($col_main_lbl); ?></span>
                    <h3 class="font-headline-lg text-headline-lg" style="color:var(--surface);font-style:italic;font-size:20px"><?php echo esc_html($col_main_ttl); ?></h3>
                </div>
            </a>
            <div class="collection-side">
            <?php foreach ($col_products as $i => $p) : $p_link = !empty($p['link']) ? $p['link'] : home_url('/the-atelier/'); ?>
            <a href="<?php echo esc_url($p_link); ?>" style="text-align:center;display:block;text-decoration:none;color:inherit" class="group">
                <div class="aura-glass" style="aspect-ratio:3/4;border-radius:12px;margin-bottom:8px;overflow:hidden;display:flex;align-items:center;justify-content:center">
                    <img src="<?php echo esc_url($p['img']); ?>" alt="<?php echo esc_attr($p['name']); ?>" style="width:60%;height:60%;object-fit:contain;transition:transform .6s" class="group-hover:scale-110" loading="lazy">
                </div>
                <h4 class="font-headline-md" style="font-size:16px;margin-bottom:4px;font-style:italic"><?php echo esc_html($p['name']); ?></h4>
                <div style="display:flex;gap:4px;justify-content:center;flex-wrap:wrap;margin-bottom:4px">
                    <span class="font-label-caps" style="font-size:11px;letter-spacing:.1em;padding:2px 6px;background:var(--surface-container-high);border-radius:4px;color:var(--on-surface-variant)"><?php echo esc_html($p['tag1']); ?></span>
                    <span class="font-label-caps" style="font-size:11px;letter-spacing:.1em;padding:2px 6px;background:var(--surface-container-high);border-radius:4px;color:var(--on-surface-variant)"><?php echo esc_html($p['tag2']); ?></span>
                </div>
                <span class="font-body-md" style="color:var(--on-surface);font-size:13px"><?php echo esc_html($p['price']); ?></span>
            </a>
            <?php endforeach; ?>
            </div>
        </div>
        <div style="text-align:center;margin-top:24px">
            <a class="iridescent-btn font-label-caps text-label-caps" style="padding:10px 28px;border-radius:999px;display:inline-block" href="<?php echo esc_url(home_url('/the-atelier/')); ?>"><?php echo esc_html($col_cta); ?></a>
        </div>
    </section>
</div>
<!-- ===== AI SYNTHESIS (Three Characters) ===== -->

<?php get_footer(); ?>

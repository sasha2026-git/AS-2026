<?php
/**
 * Template Name: Archive
 * Journal — magazine editorial grid of blog posts.
 * Replaces old ACF product-driven archive with dynamic WP_Query.
 */
get_header();

// ===== Page header ACF fields (eyebrow / title / desc) =====
$arc_eyebrow = allscented_field('allscented_archive_eyebrow', 'THE JOURNAL');
$arc_title   = allscented_field('allscented_archive_title', 'The Journal');
$arc_desc    = allscented_field('allscented_archive_desc', 'Craft, atmosphere, and the art of fragrance — told by our advisors.');

// ===== CTA ACF fields =====
$cta_eyebrow = allscented_field('allscented_archive_cta_eyebrow', 'STAY CONNECTED');
$cta_title   = allscented_field('allscented_archive_cta_title', 'Join the Journal');
$cta_desc    = allscented_field('allscented_archive_cta_desc', 'New stories arrive as we publish — scent notes, craft essays, and quiet observations from the Atelier.');
$cta_btn     = allscented_field('allscented_archive_cta_btn', 'Subscribe');

// ===== WP_Query: blog posts =====
$paged = get_query_var('paged') ? max(1, (int) get_query_var('paged')) : 1;
$posts_per_page = 12;
$journal_query = new WP_Query(array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
));

$posts_list = array();
while ($journal_query->have_posts()) {
    $journal_query->the_post();
    $pid = get_the_ID();
    $cats = get_the_category($pid);
    $cat_slugs = array();
    $advisor = '';
    $scene   = '';
    foreach ($cats as $c) {
        $slug = $c->slug;
        $cat_slugs[] = $slug;
        if (in_array($slug, array('luna','echo','sage'), true)) {
            $advisor = $c->name;
        } elseif (in_array($slug, array('personal','home','commercial'), true)) {
            $scene = $c->name;
        }
    }
    $posts_list[] = array(
        'id'           => $pid,
        'title'        => get_the_title(),
        'excerpt'      => has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 28, '…'),
        'date'         => get_the_date('M j, Y'),
        'permalink'    => get_permalink(),
        'thumbnail'    => get_the_post_thumbnail_url($pid, 'large') ?: '',
        'cat_slugs'    => $cat_slugs,
        'advisor'      => $advisor,
        'scene'        => $scene,
    );
}
wp_reset_postdata();

$total_posts = count($posts_list);
$hero_post   = ($total_posts > 0) ? $posts_list[0] : null;
$grid_posts  = ($total_posts > 1) ? array_slice($posts_list, 1) : array();

// ===== Advisor & Scene slugs (always visible when posts exist) =====
$advisor_slugs = array('echo', 'luna', 'sage');
$scene_slugs   = array('personal', 'home', 'commercial');

$advisor_labels = array(
    'echo' => 'Echo · Mystic',
    'luna' => 'Luna · Healer',
    'sage' => 'Sage · Advisor',
);
$scene_labels = array(
    'personal'   => 'Personal',
    'home'       => 'Home',
    'commercial' => 'Commercial',
);

// ===== Art gradient classes for cards without thumbnails =====
$art_classes = array('art-1','art-2','art-3','art-4','art-5','art-6','art-7','art-8','art-9');
// ===== Admin shortcut for cover editing =====
$is_admin = is_user_logged_in() && current_user_can('edit_posts');
?>
<div id="page-archive">

  <!-- ── Masthead ── -->
  <section class="journal-masthead">
    <h1><?php echo esc_html($arc_title); ?></h1>
    <div class="journal-tag"><?php echo esc_html($arc_desc); ?></div>
  </section>

  <?php if ($hero_post) : ?>
  <!-- ── Hero: latest post auto-promoted ── -->
  <section class="journal-hero">
    <div class="journal-hero-text">
      <div class="journal-eyebrow">Latest Story<?php echo $hero_post['advisor'] ? ' · ' . esc_html($hero_post['advisor']) : ''; ?></div>
      <h2><?php echo esc_html($hero_post['title']); ?></h2>
      <p class="journal-lead"><?php echo esc_html($hero_post['excerpt']); ?></p>
      <div class="journal-meta">
        <span><b><?php echo esc_html($hero_post['date']); ?></b></span>
        <?php if ($hero_post['scene']) : ?><span><?php echo esc_html($hero_post['scene']); ?></span><?php endif; ?>
        <?php if ($hero_post['advisor']) : ?><span><?php echo esc_html($hero_post['advisor']); ?></span><?php endif; ?>
      </div>
      <a class="journal-btn" href="<?php echo esc_url($hero_post['permalink']); ?>">Read Story →</a>
    </div>
    <div class="journal-hero-cover<?php echo $hero_post['thumbnail'] ? '' : ' art-1'; ?>">
      <?php if ($hero_post['thumbnail']) : ?>
        <img src="<?php echo esc_url($hero_post['thumbnail']); ?>" alt="<?php echo esc_attr($hero_post['title']); ?>" class="journal-hero-img">
      <?php else : ?>
        <div class="ring"></div>
        <div class="cap">Allscented Journal</div>
      <?php endif; ?>
      <?php if ($is_admin) : ?><button class="journal-edit-cover" data-post-id="<?php echo (int)$hero_post["id"]; ?>">编辑封面</button><?php endif; ?>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($total_posts > 0) : ?>
  <!-- ── Filters ── -->
  <div class="journal-filters">
    <div class="journal-frow">
      <span class="journal-flabel">Advisor</span>
      <button class="journal-pill on" data-f="all">All</button>
      <?php foreach ($advisor_slugs as $s) : ?>
      <button class="journal-pill" data-f="<?php echo esc_attr($s); ?>"><?php echo esc_html($advisor_labels[$s] ?? ucfirst($s)); ?></button>
      <?php endforeach; ?>
    </div>
    <div class="journal-frow">
      <span class="journal-flabel">Scene</span>
      <button class="journal-pill on" data-s="all">All</button>
      <?php foreach ($scene_slugs as $s) : ?>
      <button class="journal-pill" data-s="<?php echo esc_attr($s); ?>"><?php echo esc_html($scene_labels[$s] ?? ucfirst($s)); ?></button>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

  <?php if (!empty($grid_posts)) : ?>
  <!-- ── Editorial Grid (12-column magazine layout) ── -->
  <main class="journal-grid" id="journal-grid">
    <?php
    $grid_idx = 0;
    $grid_total = count($grid_posts);
    // Grid pattern: 7+5, 4+4+4, 7+5, 4+4+4, ...
    $round = 0;
    while ($grid_idx < $grid_total) :
        $is_wide_tall = ($round % 2 === 0);
        if ($is_wide_tall) {
            // Wide (span 7) + Tall (span 5) = 12
            $w = $grid_posts[$grid_idx] ?? null;
            $t = isset($grid_posts[$grid_idx + 1]) ? $grid_posts[$grid_idx + 1] : null;
            if ($w) {
                $art = $art_classes[($grid_idx + 1) % 9];
                $w_cats = implode(' ', $w['cat_slugs']);
                ?>
                <article class="journal-card wide" data-cat="<?php echo esc_attr($w_cats); ?>">
                  <div class="journal-cover<?php echo $w['thumbnail'] ? '' : ' ' . $art; ?>">
                    <?php if ($w['thumbnail']) : ?>
                      <img src="<?php echo esc_url($w['thumbnail']); ?>" alt="<?php echo esc_attr($w['title']); ?>" class="journal-cover-img" loading="lazy">
                    <?php else : ?>
                      <div class="journal-cover-img"></div>
                    <?php endif; ?>
                    <div class="journal-num">No. <?php echo str_pad($grid_idx + 2, 2, '0', STR_PAD_LEFT); ?></div>
                    <?php if ($w['advisor']) : ?><div class="journal-tagchip"><?php echo esc_html($w['advisor']); ?></div><?php endif; ?>
                    <?php if ($is_admin) : ?><button class="journal-edit-cover" data-post-id="<?php echo (int)$w["id"]; ?>">编辑封面</button><?php endif; ?>
                  </div>
                  <div class="journal-ct"><?php echo ($w['advisor'] ? esc_html($w['advisor']) . ' · ' : '') . ($w['scene'] ? esc_html($w['scene']) : ''); ?></div>
                  <h3><?php echo esc_html($w['title']); ?></h3>
                  <p><?php echo esc_html($w['excerpt']); ?></p>
                  <div class="journal-meta"><span><b><?php echo esc_html($w['date']); ?></b></span></div>
                </article>
                <?php
            }
            if ($t) {
                $art = $art_classes[($grid_idx + 2) % 9];
                $t_cats = implode(' ', $t['cat_slugs']);
                ?>
                <article class="journal-card tall" data-cat="<?php echo esc_attr($t_cats); ?>">
                  <div class="journal-cover<?php echo $t['thumbnail'] ? '' : ' ' . $art; ?>">
                    <?php if ($t['thumbnail']) : ?>
                      <img src="<?php echo esc_url($t['thumbnail']); ?>" alt="<?php echo esc_attr($t['title']); ?>" class="journal-cover-img" loading="lazy">
                    <?php else : ?>
                      <div class="journal-cover-img"></div>
                    <?php endif; ?>
                    <div class="journal-num">No. <?php echo str_pad($grid_idx + 3, 2, '0', STR_PAD_LEFT); ?></div>
                    <?php if ($is_admin) : ?><button class="journal-edit-cover" data-post-id="<?php echo (int)$t["id"]; ?>">编辑封面</button><?php endif; ?>
                    <?php if ($t['advisor']) : ?><div class="journal-tagchip"><?php echo esc_html($t['advisor']); ?></div><?php endif; ?>
                  </div>
                  <div class="journal-ct"><?php echo ($t['advisor'] ? esc_html($t['advisor']) . ' · ' : '') . ($t['scene'] ? esc_html($t['scene']) : ''); ?></div>
                  <h3><?php echo esc_html($t['title']); ?></h3>
                  <p><?php echo esc_html($t['excerpt']); ?></p>
                  <div class="journal-meta"><span><b><?php echo esc_html($t['date']); ?></b></span></div>
                </article>
                <?php
            }
            $grid_idx += 2;
        } else {
            // 4 + 4 + 4 = 12
            for ($k = 0; $k < 3 && $grid_idx < $grid_total; $k++, $grid_idx++) {
                $p = $grid_posts[$grid_idx];
                $art = $art_classes[($grid_idx + 1) % 9];
                $p_cats = implode(' ', $p['cat_slugs']);
                ?>
                <article class="journal-card" data-cat="<?php echo esc_attr($p_cats); ?>">
                  <div class="journal-cover<?php echo $p['thumbnail'] ? '' : ' ' . $art; ?>">
                    <?php if ($p['thumbnail']) : ?>
                      <img src="<?php echo esc_url($p['thumbnail']); ?>" alt="<?php echo esc_attr($p['title']); ?>" class="journal-cover-img" loading="lazy">
                    <?php else : ?>
                      <div class="journal-cover-img"></div>
                    <?php endif; ?>
                    <?php if ($is_admin) : ?><button class="journal-edit-cover" data-post-id="<?php echo (int)$p["id"]; ?>">编辑封面</button><?php endif; ?>
                    <div class="journal-num">No. <?php echo str_pad($grid_idx + 2, 2, '0', STR_PAD_LEFT); ?></div>
                    <?php if ($p['advisor']) : ?><div class="journal-tagchip"><?php echo esc_html($p['advisor']); ?></div><?php endif; ?>
                  </div>
                  <div class="journal-ct"><?php echo ($p['advisor'] ? esc_html($p['advisor']) . ' · ' : '') . ($p['scene'] ? esc_html($p['scene']) : ''); ?></div>
                  <h3><?php echo esc_html($p['title']); ?></h3>
                  <p><?php echo esc_html($p['excerpt']); ?></p>
                  <div class="journal-meta"><span><b><?php echo esc_html($p['date']); ?></b></span></div>
                </article>
                <?php
            }
        }
        $round++;
    endwhile;
    ?>
  </main>
  <?php elseif (empty($grid_posts) && !$hero_post) : ?>
  <!-- ── Empty state ── -->
  <main class="journal-grid" id="journal-grid" style="min-height:200px;display:flex;align-items:center;justify-content:center">
    <p style="color:var(--on-surface-variant);font-family:var(--font-serif, 'Playfair Display', serif);font-style:italic;font-size:18px">Stories are brewing. Check back soon.</p>
  </main>
  <?php endif; ?>

  <!-- ── Filter empty state ── -->
  <div class="journal-empty" id="journal-empty" style="display:none">
    <p class="journal-lead">No stories in this category yet — check back soon.</p>
  </div>

  <!-- ── Subscribe strip ── -->
  <section class="journal-join">
    <div>
      <h4><?php echo esc_html($cta_title); ?></h4>
      <p><?php echo esc_html($cta_desc); ?></p>
    </div>
    <a class="journal-btn" href="#"><?php echo esc_html($cta_btn); ?> →</a>
  </section>

  <!-- ── Pagination ── -->
  <?php if ($journal_query->max_num_pages > 1) : ?>
  <nav class="journal-pagination">
    <?php
    $big = 999999999;
    $paginate = paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => $paged,
        'total'     => $journal_query->max_num_pages,
        'prev_text' => '←',
        'next_text' => '→',
        'type'      => 'array',
    ));
    if ($paginate) {
        echo '<div class="journal-pagination-inner">';
        foreach ($paginate as $link) {
            if (strpos($link, 'current') !== false) {
                $num = strip_tags($link);
                echo '<span class="journal-pg on">' . $num . '</span>';
            } elseif (strpos($link, 'dots') !== false) {
                echo '<span class="dots">…</span>';
            } elseif (strpos($link, 'prev') !== false || strpos($link, 'next') !== false) {
                $link = preg_replace('/class="[^"]*"/', 'class="journal-pg dir"', $link);
                echo $link;
            } else {
                $link = preg_replace('/class="[^"]*"/', 'class="journal-pg"', $link);
                echo $link;
            }
        }
        echo '</div>';
    }
    ?>
  </nav>
  <?php endif; ?>

</div><!-- /#page-archive -->

<!-- ═══════════════ Journal-specific styles ═══════════════ -->
<style>
  /* ── Masthead ── */
  .journal-masthead {
    border-bottom: 1px solid var(--outline-variant);
    padding: 26px var(--margin-desktop) 22px;
    display: flex; align-items: baseline; justify-content: space-between;
    gap: 20px; flex-wrap: wrap;
    max-width: var(--container-max);
    margin: 0 auto;
  }
  .journal-masthead h1 {
    font-family: 'Playfair Display', serif; font-weight: 600;
    font-size: clamp(34px, 5vw, 52px); letter-spacing: .02em; color: var(--on-surface);
    margin: 0;
  }
  .journal-tag {
    font-size: 11px; letter-spacing: .22em; text-transform: uppercase;
    color: var(--on-surface-variant);
  }
  .journal-tag b { color: var(--secondary); font-weight: 600; }

  /* ── Hero ── */
  .journal-hero {
    display: grid; grid-template-columns: 1.05fr .95fr; gap: 0;
    border-bottom: 1px solid var(--outline-variant);
  }
  .journal-hero-text {
    padding: clamp(32px, 5vw, 72px) var(--margin-desktop);
    display: flex; flex-direction: column; justify-content: center; gap: 18px;
  }
  .journal-eyebrow {
    font-size: 11px; letter-spacing: .24em; text-transform: uppercase;
    color: var(--secondary); font-weight: 600;
    display: flex; align-items: center; gap: 10px;
  }
  .journal-eyebrow::before { content: ""; width: 34px; height: 1px; background: var(--secondary); }
  .journal-hero-text h2 {
    font-family: 'Playfair Display', serif; font-weight: 600;
    font-size: clamp(30px, 4vw, 46px); line-height: 1.12; letter-spacing: .01em;
    color: var(--on-surface); margin: 0;
  }
  .journal-lead {
    color: var(--on-surface-variant); font-size: 15px;
    max-width: 46ch; font-weight: 300; margin: 0;
  }
  .journal-meta {
    display: flex; gap: 16px; font-size: 11px; letter-spacing: .14em;
    text-transform: uppercase; color: var(--on-surface-variant);
  }
  .journal-meta span b { color: var(--on-surface); font-weight: 600; }
  .journal-btn {
    display: inline-flex; align-items: center; gap: 10px; margin-top: 6px;
    font-size: 11px; letter-spacing: .2em; text-transform: uppercase;
    color: var(--on-surface); border-bottom: 1px solid var(--secondary);
    padding-bottom: 6px; width: fit-content; font-weight: 600;
    transition: color .2s;
  }
  .journal-btn:hover { color: var(--secondary); }
  .journal-hero-cover {
    position: relative; min-height: 420px; overflow: hidden;
  }
  .journal-hero-img {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }
  .journal-hero-cover .ring {
    position: absolute; z-index: 2;
    width: min(340px, 62%); aspect-ratio: 1; border-radius: 50%;
    border: 1px solid rgba(215, 198, 254, .45);
    top: 50%; left: 50%; transform: translate(-50%, -50%);
  }
  .journal-hero-cover .ring::after {
    content: ""; position: absolute; inset: 26px; border-radius: 50%;
    border: 1px solid rgba(215, 198, 254, .3);
  }
  .journal-hero-cover .cap {
    position: absolute; z-index: 2; left: 32px; bottom: 26px;
    color: rgba(255, 255, 255, .82); font-size: 10px;
    letter-spacing: .26em; text-transform: uppercase;
  }

  /* ── Filters ── */
  .journal-filters {
    padding: 26px var(--margin-desktop) 8px;
    border-bottom: 1px solid var(--outline-variant);
    max-width: var(--container-max); margin: 0 auto;
  }
  .journal-frow {
    display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    padding-bottom: 14px;
  }
  .journal-flabel {
    font-size: 10px; letter-spacing: .22em; text-transform: uppercase;
    color: var(--on-surface-variant); width: 88px; flex: none;
  }
  .journal-pill {
    font-size: 11px; letter-spacing: .14em; text-transform: uppercase;
    padding: 7px 16px; border: 1px solid var(--outline-variant);
    border-radius: 999px; cursor: pointer; color: var(--on-surface-variant);
    background: transparent; transition: all .2s;
    font-family: 'Hanken Grotesk', sans-serif;
  }
  .journal-pill:hover { border-color: var(--secondary); color: var(--secondary); }
  .journal-pill.on {
    background: var(--on-surface); border-color: var(--on-surface);
    color: var(--surface);
  }

  /* ── Grid ── */
  .journal-grid {
    padding: clamp(28px, 4vw, 56px) var(--margin-desktop) 0;
    display: grid; grid-template-columns: repeat(12, 1fr);
    gap: clamp(22px, 3vw, 40px);
    max-width: var(--container-max); margin: 0 auto;
  }
  .journal-card {
    grid-column: span 4; display: flex; flex-direction: column; gap: 14px;
    cursor: pointer;
  }
  .journal-card.is-hidden { display: none; }
  .journal-card:hover .journal-cover-img { transform: scale(1.03); }
  .journal-card:hover h3 { color: var(--secondary); }
  .journal-card.wide { grid-column: span 7; }
  .journal-card.tall { grid-column: span 5; }
  .journal-card.feature {
    grid-column: span 12; display: grid; grid-template-columns: 1fr 1fr;
    gap: clamp(24px, 3vw, 48px); align-items: center;
    padding: clamp(24px, 3vw, 44px) 0;
    border-top: 1px solid var(--outline-variant);
  }
  .journal-card.feature .journal-cover { aspect-ratio: 16/9; }

  .journal-cover {
    position: relative; aspect-ratio: 4/5; overflow: hidden; border-radius: 4px;
  }
  .journal-card.wide .journal-cover { aspect-ratio: 16/9; }
  .journal-card.tall .journal-cover { aspect-ratio: 3/4; }
  .journal-cover-img {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; transition: transform .4s ease;
  }
  .journal-num {
    position: absolute; top: 14px; left: 16px;
    font-family: 'Playfair Display', serif; font-style: italic;
    color: var(--secondary-container); font-size: 13px; letter-spacing: .08em;
    z-index: 2;
  }
  .journal-tagchip {
    position: absolute; top: 12px; right: 12px;
    font-size: 9px; letter-spacing: .2em; text-transform: uppercase;
    background: rgba(252, 249, 248, .9); color: var(--on-surface);
    padding: 5px 10px; border-radius: 999px; z-index: 2;
  }
  .journal-ct {
    font-size: 10px; letter-spacing: .2em; text-transform: uppercase;
    color: var(--secondary); font-weight: 600;
  }
  .journal-card h3 {
    font-family: 'Playfair Display', serif; font-weight: 600;
    font-size: clamp(19px, 1.6vw, 24px); line-height: 1.2;
    color: var(--on-surface); margin: 0; transition: color .2s;
  }
  .journal-card p {
    font-size: 13px; color: var(--on-surface-variant); font-weight: 300; margin: 0;
  }
  .journal-card .journal-meta { margin-top: auto; padding-top: 8px; }

  /* ── Cover art gradients (no thumbnail fallback) ── */
  .art-1 { background: linear-gradient(160deg, #2d2a3a, #4a3f68 55%, #645787); }
  .art-1::after { content:""; position:absolute; inset:0; background:radial-gradient(circle at 70% 30%, rgba(215,198,254,.4), transparent 45%); border-radius:inherit; }
  .art-2 { background: linear-gradient(200deg, #f4f0f8, #d7c6fe 130%); }
  .art-2::after { content:""; position:absolute; width:70%; height:70%; border:1px solid rgba(100,87,135,.35); border-radius:50%; top:15%; left:15%; }
  .art-3 { background: linear-gradient(150deg, #3d4a50, #50616b); }
  .art-3::after { content:""; position:absolute; inset:0; background:radial-gradient(circle at 25% 75%, rgba(211,229,241,.3), transparent 40%); border-radius:inherit; }
  .art-4 { background: linear-gradient(160deg, #e8e4f0, #c4b8dc); }
  .art-4::after { content:""; position:absolute; width:120px; height:120px; border-radius:50%; background:radial-gradient(circle at 30% 30%, rgba(100,87,135,.45), transparent 70%); top:50%; left:50%; transform:translate(-50%,-50%); }
  .art-5 { background: linear-gradient(135deg, #262235, #4a3f68 60%, #645787); }
  .art-5::after { content:""; position:absolute; inset:0; background:repeating-linear-gradient(115deg, transparent 0 34px, rgba(215,198,254,.12) 34px 36px); border-radius:inherit; }
  .art-6 { background: linear-gradient(170deg, #f6f4f8, #d4cbe0); }
  .art-6::after { content:""; position:absolute; width:52%; height:52%; border-radius:50%; border:1px solid rgba(100,87,135,.4); top:24%; left:24%; }
  .art-7 { background: linear-gradient(140deg, #2b3035, #3d4a50); }
  .art-7::after { content:""; position:absolute; inset:0; background:radial-gradient(circle at 80% 80%, rgba(211,229,241,.4), transparent 50%); border-radius:inherit; }
  .art-8 { background: linear-gradient(200deg, #d7c6fe, #8b7aaa); }
  .art-8::after { content:""; position:absolute; width:40%; height:40%; border:1px solid rgba(255,255,255,.5); border-radius:50%; top:30%; left:30%; }
  .art-9 { background: linear-gradient(150deg, #3a3642, #5a4d6e 70%, #7b6b93); }
  .art-9::after { content:""; position:absolute; inset:0; background:radial-gradient(circle at 30% 20%, rgba(215,198,254,.35), transparent 40%); border-radius:inherit; }

  /* Hero cover "No. 01" overlay (after art classes to override art-1::after content) */
  .journal-hero-cover::after {
    content: "No. 01";
    position: absolute;
    top: 28px;
    right: 32px;
    font-family: "Playfair Display", serif;
    font-style: italic;
    font-size: 15px;
    color: rgba(215, 198, 254, 0.85);
    letter-spacing: 0.1em;
    z-index: 2;
    inset: auto;
    background: none;
  }

  /* ── Subscribe ── */
  .journal-join {
    margin: clamp(40px, 6vw, 72px) var(--margin-desktop) 0;
    border: 1px solid var(--outline-variant);
    background: rgba(252, 249, 248, .55);
    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    display: flex; align-items: center; justify-content: space-between;
    gap: 24px; padding: clamp(24px, 4vw, 44px); flex-wrap: wrap;
    max-width: var(--container-max); margin-left: auto; margin-right: auto;
  }
  .journal-join h4 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(20px, 2.4vw, 28px); font-weight: 600;
    color: var(--on-surface); margin: 0;
  }
  .journal-join p {
    color: var(--on-surface-variant); font-size: 13px;
    max-width: 44ch; font-weight: 300; margin-top: 6px;
  }
  .journal-join .journal-btn { margin-top: 0; }

  /* ── Pagination ── */
  .journal-pagination {
    padding: clamp(32px, 5vw, 56px) var(--margin-desktop);
    max-width: var(--container-max); margin: 0 auto;
  }
  .journal-pagination-inner {
    display: flex; align-items: center; justify-content: center; gap: 8px;
  }
  .journal-pg {
    width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;
    border: 1px solid var(--outline-variant);
    font-family: 'Playfair Display', serif; font-size: 15px;
    color: var(--on-surface-variant); cursor: pointer;
    transition: all .2s; text-decoration: none;
  }
  .journal-pg:hover { border-color: var(--secondary); color: var(--secondary); }
  .journal-pg.on {
    background: var(--on-surface); border-color: var(--on-surface);
    color: var(--surface);
  }
  .journal-pg.dir { font-size: 12px; letter-spacing: .1em; }
  .journal-pagination .dots { border: none; cursor: default; }
  .journal-pagination .dots:hover { color: var(--on-surface-variant); }

  /* ── Responsive ── */
  @media (max-width: 1023px) {
    .journal-hero { grid-template-columns: 1fr; }
    .journal-hero-cover { min-height: 300px; }
    .journal-card, .journal-card.wide, .journal-card.tall { grid-column: span 6; }
    .journal-card.feature { grid-column: span 12; grid-template-columns: 1fr; }
    .journal-card.wide .journal-cover { aspect-ratio: 4/5; }
    .journal-card.tall .journal-cover { aspect-ratio: 4/5; }
  }
  @media (max-width: 560px) {
    .journal-card, .journal-card.wide, .journal-card.tall { grid-column: span 12; }
    .journal-masthead { padding: 20px var(--margin-mobile) 16px; flex-direction: column; align-items: flex-start; }
    .journal-masthead .journal-tag { max-width: 100%; }
    .journal-hero-text { padding: 24px var(--margin-mobile); }
    .journal-filters { padding: 18px var(--margin-mobile) 4px; }
    .journal-grid { padding: 24px var(--margin-mobile) 0; }
    .journal-join { margin: 32px var(--margin-mobile) 0; }
    .journal-pagination { padding: 28px var(--margin-mobile); }
  }
  .journal-empty{text-align:center;padding:clamp(32px,5vw,56px) var(--margin-desktop);max-width:var(--container-max);margin:0 auto}
  .journal-edit-cover{position:absolute;bottom:12px;right:12px;z-index:5;background:rgba(28,27,27,.72);color:#fff;font-size:11px;letter-spacing:.05em;text-transform:uppercase;padding:5px 10px;border-radius:4px;text-decoration:none;font-family:'Hanken Grotesk',sans-serif;transition:background .2s}
  .journal-edit-cover:hover{background:rgba(100,87,135,.92)}
  button.journal-edit-cover{border:none;cursor:pointer;outline:none;font-family:'Hanken Grotesk',sans-serif}
</style>

<!-- ═══════════════ Filter JS ═══════════════ -->
<?php if ($total_posts > 0) : ?>
<script>
(function(){
  var pillsF = document.querySelectorAll('.journal-filters .journal-frow:first-of-type .journal-pill');
  var pillsS = document.querySelectorAll('.journal-filters .journal-frow:last-of-type .journal-pill');
  var cards = document.querySelectorAll('#journal-grid .journal-card');
  var emptyEl = document.getElementById('journal-empty');
  if (!pillsF.length && !pillsS.length) return;
  var curF = 'all', curS = 'all';

  function apply() {
    var anyVisible = false;
    cards.forEach(function(c) {
      var cats = (c.getAttribute('data-cat') || '').split(/\s+/);
      var okF = (curF === 'all' || cats.indexOf(curF) !== -1);
      var okS = (curS === 'all' || cats.indexOf(curS) !== -1);
      var show = okF && okS;
      c.classList.toggle('is-hidden', !show);
      if (show) anyVisible = true;
    });
    if (emptyEl) {
      emptyEl.style.display = anyVisible ? 'none' : '';
    }
  }

  if (pillsF.length) pillsF.forEach(function(p) {
    p.addEventListener('click', function() {
      pillsF.forEach(function(x) { x.classList.remove('on'); });
      p.classList.add('on');
      curF = p.getAttribute('data-f');
      apply();
    });
  });

  if (pillsS.length) pillsS.forEach(function(p) {
    p.addEventListener('click', function() {
      pillsS.forEach(function(x) { x.classList.remove('on'); });
      p.classList.add('on');
      curS = p.getAttribute('data-s');
      apply();
    });
  });
})();
</script>
<?php endif; ?>

<?php get_footer(); ?>

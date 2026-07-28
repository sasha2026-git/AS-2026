<?php
/**
 * Template Name: Allscented Archives & Fragrance Library
 * Digital Romanticism – Content Archive / Blog
 */

get_header('allscented');
?>

<section style="padding: 140px var(--margin-desktop) 64px; max-width: var(--container-max); margin: 0 auto;">
    <div style="display: flex; flex-direction: column; gap: 80px;">
        <!-- Hero -->
        <div style="max-width: 680px;">
            <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block; letter-spacing: 0.2em;">
                <?php esc_html_e('THE FRAGRANCE ARCHIVES', 'allscents'); ?>
            </span>
            <h1 class="font-headline-xl text-headline-xl">
                <?php esc_html_e('A Library of Scent & Memory', 'allscents'); ?>
            </h1>
            <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); margin-top: 16px;">
                <?php esc_html_e('Explore our curated content: scent comparisons, archival entries, and AI-powered fragrance analysis.', 'allscents'); ?>
            </p>
        </div>

        <!-- Latest Archives Grid (Posts) -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 32px;">
                <h2 class="font-headline-lg text-headline-lg"><?php esc_html_e('Latest Archives', 'allscents'); ?></h2>
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="font-label-caps text-label-caps" style="color: var(--color-secondary);">
                    <?php esc_html_e('VIEW ALL →', 'allscents'); ?>
                </a>
            </div>

            <div class="archive-grid">
                <?php
                $latest_posts = new WP_Query([
                    'posts_per_page' => 5,
                    'post_status'    => 'publish',
                ]);

                if ($latest_posts->have_posts()) :
                    $count = 0;
                    while ($latest_posts->have_posts()) : $latest_posts->the_post();
                        $count++;
                        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $cats = get_the_category();
                        $cat_name = !empty($cats) ? $cats[0]->name : get_post_type();
                        $featured = $count === 1; // first post is featured (large)
                ?>
                <div class="archive-card reveal" style="<?php echo $featured ? 'grid-column: 1 / -1; display: grid; grid-template-columns: 1fr 1fr;' : ''; ?>">
                    <?php if ($thumb) : ?>
                    <div class="archive-image" style="<?php echo $featured ? 'height: 100%; min-height: 400px;' : ''; ?>">
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                    </div>
                    <?php endif; ?>
                    <div class="archive-content" style="display: flex; flex-direction: column; justify-content: center;">
                        <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 8px; display: block;">
                            <?php echo esc_html(strtoupper($cat_name)); ?>
                        </span>
                        <h3 style="font-family: var(--font-headline); font-size: <?php echo $featured ? 'var(--text-headline-lg)' : 'var(--text-headline-md)'; ?>; margin-bottom: 12px;">
                            <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p style="color: var(--color-on-surface-variant);"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        <a href="<?php the_permalink(); ?>" style="margin-top: 16px; color: var(--color-secondary); font-weight: 500;">
                            <?php esc_html_e('Read more →', 'allscents'); ?>
                        </a>
                    </div>
                </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <div class="glass-card" style="grid-column: 1 / -1; padding: 64px; text-align: center; border-radius: var(--radius-xl);">
                    <span class="material-symbols-outlined" style="font-size: 48px; color: var(--color-outline); margin-bottom: 16px; display: block;">menu_book</span>
                    <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant);">
                        <?php esc_html_e('No archive entries yet. Start writing about your scent discoveries!', 'allscents'); ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Comparison Section Preview -->
        <div class="glass-card" style="padding: 48px; border-radius: var(--radius-2xl); text-align: center;">
            <span class="material-symbols-outlined icon-fill" style="font-size: 48px; color: var(--color-secondary); margin-bottom: 16px;">compare_arrows</span>
            <h2 class="font-headline-lg text-headline-lg" style="margin-bottom: 16px;">
                <?php esc_html_e('The Scent Comparison Hub', 'allscents'); ?>
            </h2>
            <p class="font-body-lg text-body-lg" style="color: var(--color-on-surface-variant); max-width: 480px; margin: 0 auto 32px;">
                <?php esc_html_e('See how fragrances stack up: molecular metrics, sillage, longevity, and AI verdicts.', 'allscents'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/compare')); ?>" class="btn-primary">
                <?php esc_html_e('Enter the Arena', 'allscents'); ?>
                <span class="material-symbols-outlined" style="margin-left: 8px; font-size: 18px;">compare_arrows</span>
            </a>
        </div>

        <!-- Newsletter -->
        <div style="text-align: center; max-width: 480px; margin: 0 auto;">
            <h2 class="font-headline-md text-headline-md" style="margin-bottom: 8px;">
                <?php esc_html_e('Stay in the Aura', 'allscents'); ?>
            </h2>
            <p class="font-body-md text-body-md" style="color: var(--color-on-surface-variant); margin-bottom: 24px;">
                <?php esc_html_e('Get new scent profiles and AI analysis delivered.', 'allscents'); ?>
            </p>
            <form style="display: flex; gap: 12px;">
                <input type="email" placeholder="<?php esc_attr_e('Your email', 'allscents'); ?>" required
                       style="flex: 1; padding: 14px 20px; border: 1px solid var(--color-outline-variant); border-radius: var(--radius-lg); background: rgba(255,255,255,0.6); font-family: var(--font-body);">
                <button type="submit" class="btn-primary" style="padding: 14px 28px;"><?php esc_html_e('Subscribe', 'allscents'); ?></button>
            </form>
        </div>
    </div>
</section>

<?php get_footer('allscented'); ?>

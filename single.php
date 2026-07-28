<?php
/**
 * Template: Allscented Single Post / Archive Entry
 * Digital Romanticism – Single content view
 */

get_header('allscented');
?>

<main style="padding: 140px var(--margin-desktop) 80px; max-width: var(--container-max); margin: 0 auto;">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <!-- Header -->
            <header style="max-width: 800px; margin: 0 auto 48px;">
                <span class="font-label-caps text-label-caps" style="color: var(--color-secondary); margin-bottom: 16px; display: block; letter-spacing: 0.2em;">
                    <?php
                    $cats = get_the_category();
                    echo !empty($cats) ? esc_html(strtoupper($cats[0]->name)) : esc_html__('JOURNAL', 'allscents');
                    ?>
                </span>
                <h1 class="font-headline-xl text-headline-xl" style="margin-bottom: 24px;"><?php the_title(); ?></h1>
                <div style="display: flex; gap: 24px; flex-wrap: wrap; color: var(--color-on-surface-variant);">
                    <span class="font-label-caps text-label-caps"><?php echo get_the_date('F j, Y'); ?></span>
                    <span class="font-label-caps text-label-caps"><?php esc_html_e('By', 'allscents'); ?> <?php the_author(); ?></span>
                    <?php if (has_tag()) : ?>
                        <span class="font-label-caps text-label-caps"><?php the_tags('', ', '); ?></span>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
            <div style="aspect-ratio: 16 / 9; overflow: hidden; border-radius: var(--radius-xl); margin-bottom: 64px; box-shadow: var(--shadow-aura);">
                <?php the_post_thumbnail('full', [
                    'style' => 'width: 100%; height: 100%; object-fit: cover;',
                    'loading' => 'eager',
                ]); ?>
            </div>
            <?php endif; ?>

            <!-- Content -->
            <div style="max-width: 720px; margin: 0 auto;">
                <div class="allscents-content" style="font-size: var(--text-body-lg); line-height: 1.8; color: var(--color-on-surface);">
                    <?php the_content(); ?>
                </div>

                <!-- Pagination -->
                <div style="display: flex; justify-content: space-between; margin-top: 64px; padding-top: 32px; border-top: 1px solid var(--color-outline-variant);">
                    <div>
                        <?php previous_post_link('%link', '← %title'); ?>
                    </div>
                    <div>
                        <?php next_post_link('%link', '%title →'); ?>
                    </div>
                </div>
            </div>
        </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer('allscented'); ?>

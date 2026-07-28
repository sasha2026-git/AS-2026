<?php
/**
 * Template: Allscented Default Page
 * Digital Romanticism – Fallback page template
 */

get_header('allscented');
?>

<main style="padding: 140px var(--margin-desktop) 80px; max-width: var(--container-max); margin: 0 auto;">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <header style="max-width: 720px; margin: 0 auto 48px; text-align: center;">
                <h1 class="font-headline-xl text-headline-xl"><?php the_title(); ?></h1>
            </header>
            <div style="max-width: 720px; margin: 0 auto;">
                <div class="allscents-content" style="font-size: var(--text-body-lg); line-height: 1.8;">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer('allscented'); ?>

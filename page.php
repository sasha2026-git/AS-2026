<?php
/**
 * Default page template
 */

get_header();
?>

<section class="px-margin-desktop container-max py-32 min-h-screen">
    <?php while (have_posts()) : the_post(); ?>
        <span class="font-label-caps text-label-caps text-secondary mb-4 block">PAGE</span>
        <h1 class="font-headline-xl text-headline-xl mb-8"><?php the_title(); ?></h1>
        <div class="font-body-lg text-body-lg text-on-surface-variant max-w-3xl">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
</section>

<?php
get_footer();

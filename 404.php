<?php
/**
 * 404 Template
 */

get_header();
?>

<section class="px-margin-desktop container-max min-h-screen flex flex-col items-center justify-center text-center">
    <span class="font-headline-xl text-headline-xl text-secondary mb-8">404</span>
    <h1 class="font-headline-lg text-headline-lg mb-6">Scent not found</h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant mb-12 max-w-md">This page has evaporated. Perhaps it was never meant to be contained.</p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="iridescent-btn px-10 py-4 rounded-full font-label-caps text-label-caps tracking-widest uppercase">
        Return to Discover
    </a>
</section>

<?php
get_footer();

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="light">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-body-md'); ?>>
<?php wp_body_open(); ?>

<!-- Aura Mist Background -->
<div class="aura-mist" id="aura-mist"></div>

<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 bg-surface/70 backdrop-blur-xl border-b border-outline-variant/20 shadow-sm">
    <div class="flex justify-between items-center px-margin-desktop py-4 container-max">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="font-headline-md text-headline-md text-on-surface tracking-tighter">AuraAI</a>
        <div class="hidden md:flex gap-gutter items-center">
            <a class="font-body-md text-body-md tracking-wide <?php echo is_front_page() ? 'text-secondary border-b border-secondary pb-1' : 'text-on-surface-variant hover:text-primary transition-colors'; ?>" href="<?php echo esc_url(home_url('/')); ?>">Discover</a>
            <a class="font-body-md text-body-md tracking-wide <?php echo is_page_template('page-ai-synthesis.php') ? 'text-secondary border-b border-secondary pb-1' : 'text-on-surface-variant hover:text-primary transition-colors'; ?>" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>">AI Synthesis</a>
            <a class="font-body-md text-body-md tracking-wide <?php echo is_page_template('page-boutique.php') ? 'text-secondary border-b border-secondary pb-1' : 'text-on-surface-variant hover:text-primary transition-colors'; ?>" href="<?php echo esc_url(home_url('/boutique/')); ?>">The Atelier</a>
            <a class="font-body-md text-body-md tracking-wide <?php echo is_page_template('page-archive.php') ? 'text-secondary border-b border-secondary pb-1' : 'text-on-surface-variant hover:text-primary transition-colors'; ?>" href="<?php echo esc_url(home_url('/archive/')); ?>">Archive</a>
        </div>
        <div class="flex items-center gap-6">
            <button class="cursor-pointer active:scale-95 transition-transform text-on-surface-variant" aria-label="Shopping bag">
                <span class="material-symbols-outlined">shopping_bag</span>
            </button>
            <button class="cursor-pointer active:scale-95 transition-transform text-on-surface-variant" aria-label="Account">
                <span class="material-symbols-outlined">account_circle</span>
            </button>
            <!-- Mobile menu toggle -->
            <button class="md:hidden cursor-pointer active:scale-95 transition-transform text-on-surface-variant" id="mobile-menu-toggle" aria-label="Toggle menu">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div class="md:hidden hidden px-margin-mobile pb-6" id="mobile-menu">
        <div class="flex flex-col gap-4 mt-4">
            <a class="font-body-md text-body-md text-on-surface-variant" href="<?php echo esc_url(home_url('/')); ?>">Discover</a>
            <a class="font-body-md text-body-md text-on-surface-variant" href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>">AI Synthesis</a>
            <a class="font-body-md text-body-md text-on-surface-variant" href="<?php echo esc_url(home_url('/boutique/')); ?>">The Atelier</a>
            <a class="font-body-md text-body-md text-on-surface-variant" href="<?php echo esc_url(home_url('/archive/')); ?>">Archive</a>
        </div>
    </div>
</nav>

<main class="pt-32">

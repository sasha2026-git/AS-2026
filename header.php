<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        /* Prevent layout shift from scrollbar */
        html { scrollbar-gutter: stable; }
    </style>
</head>
<body <?php body_class('antialiased'); ?>>
<?php wp_body_open(); ?>

<!-- Aura Mist Background -->
<div id="aura-mist" class="aura-mist"></div>

<!-- Fixed Navigation -->
<nav class="fixed top-0 left-0 w-full z-50" style="background:rgba(252,249,248,0.8);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(199,198,203,0.1);">
    <div class="container-max mx-auto flex items-center justify-between px-margin-desktop" style="height:64px;">
        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="font-headline-md text-headline-md tracking-tighter" style="text-decoration:none;color:var(--on-surface);">
            All<span style="color:var(--secondary);">scented</span>
        </a>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-8">
            <?php
            $nav_items = array(
                'Discover' => home_url('/'),
                'The Atelier' => home_url('/the-atelier/'),
                'AI Synthesis' => home_url('/ai-synthesis/'),
                'Archive' => home_url('/archive/'),
            );
            $current_url = trailingslashit((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            foreach ($nav_items as $label => $url) : 
                $is_active = trailingslashit($url) === $current_url || (is_front_page() && $url === home_url('/'));
                ?>
                <a href="<?php echo esc_url($url); ?>"
                   class="font-label-caps text-label-caps transition-all duration-300"
                   style="text-decoration:none;color:<?php echo $is_active ? 'var(--secondary)' : 'var(--on-surface-variant)'; ?>;<?php echo $is_active ? 'border-bottom:2px solid var(--secondary);padding-bottom:2px;' : ''; ?>">
                    <?php echo esc_html($label); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Shopping icons + Hamburger -->
        <div class="flex items-center gap-4 md:gap-6">
            <a href="<?php echo function_exists('wc_get_cart_url') ? esc_url(wc_get_cart_url()) : '#'; ?>" class="text-on-surface-variant hover:text-secondary transition-colors" style="text-decoration:none;">
                <span class="material-symbols-outlined">shopping_bag</span>
            </a>
            <button id="mobile-menu-toggle" class="mobile-only flex items-center justify-center bg-transparent border-none cursor-pointer p-1" style="line-height:1;">
                <span class="material-symbols-outlined text-on-surface" id="menu-icon" style="font-size:28px;line-height:1;">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden" style="padding:16px var(--margin-mobile);border-top:1px solid rgba(199,198,203,0.1);">
        <?php foreach ($nav_items as $label => $url) : 
            $is_active = trailingslashit($url) === $current_url || (is_front_page() && $url === home_url('/'));
            ?>
            <a href="<?php echo esc_url($url); ?>"
               class="block font-label-caps text-label-caps py-3 transition-all duration-300"
               style="text-decoration:none;color:<?php echo $is_active ? 'var(--secondary)' : 'var(--on-surface-variant)'; ?>;">
                <?php echo esc_html($label); ?>
            </a>
        <?php endforeach; ?>
    </div>
</nav>

<!-- Spacer for fixed nav -->
<div style="height:64px;"></div>

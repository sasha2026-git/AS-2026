<?php
/**
 * Allscented header — v20 design
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">Skip to content</a>

<div class="aura-mist" id="aura-mist" aria-hidden="true"></div>

<?php
$current_path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
$is_active = function($key) use ($current_path) {
    if ($key === 'discover') {
        return (is_front_page() || is_home()) ? ' active-nav' : '';
    }
    return is_page($key) ? ' active-nav' : '';
};
$cart_url = class_exists('WooCommerce') ? wc_get_cart_url() : '#';
$account_url = class_exists('WooCommerce') ? get_permalink(get_option('woocommerce_myaccount_page_id')) : '#';
?>

<header style="z-index:100;background:color-mix(in srgb,var(--surface)85%,transparent);backdrop-filter:blur(12px);border-bottom:1px solid color-mix(in srgb,var(--outline-variant)25%,transparent)">
    <nav class="px-margin-desktop px-margin-mobile" style="width:100%;height:50px;display:flex;align-items:center;justify-content:space-between;gap:16px" aria-label="Main navigation">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="font-headline-md" style="font-size:17px;letter-spacing:.22em;font-weight:600;color:var(--on-surface);text-decoration:none;display:flex;align-items:center;gap:8px">
            <?php
            $allscented_logo = get_stylesheet_directory() . '/assets/images/logo.png';
            if (file_exists($allscented_logo)) :
            ?>
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/logo.png'); ?>" alt="Allscented" style="height:30px;width:auto;display:block">
            <?php else : ?>
                <span class="material-symbols-outlined" style="font-size:20px;color:var(--secondary)">auto_awesome</span>
                ALLSCENTED
            <?php endif; ?>
        </a>

        <div class="desktop-only" style="display:flex;align-items:center;gap:22px">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link font-label-caps text-label-caps<?php echo $is_active('discover'); ?>" data-page="discover" style="font-size:10px;letter-spacing:.14em;color:var(--on-surface-variant);text-decoration:none;transition:color .3s">Discover</a>
            <a href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>" class="nav-link font-label-caps text-label-caps<?php echo $is_active('ai-synthesis'); ?>" data-page="ai-synthesis" style="font-size:10px;letter-spacing:.14em;color:var(--on-surface-variant);text-decoration:none;transition:color .3s">AI Synthesis</a>
            <a href="<?php echo esc_url(home_url('/archive/')); ?>" class="nav-link font-label-caps text-label-caps<?php echo $is_active('archive'); ?>" data-page="archive" style="font-size:10px;letter-spacing:.14em;color:var(--on-surface-variant);text-decoration:none;transition:color .3s">Archive</a>
            <a href="<?php echo esc_url(home_url('/the-atelier/')); ?>" class="nav-link font-label-caps text-label-caps<?php echo $is_active('the-atelier'); ?>" data-page="the-atelier" style="font-size:10px;letter-spacing:.14em;color:var(--on-surface-variant);text-decoration:none;transition:color .3s">The Atelier</a>
        </div>

        <div style="display:flex;align-items:center;gap:6px">
            <a href="<?php echo esc_url($account_url); ?>" class="icon-btn" style="width:34px;height:34px;border-radius:999px;display:flex;align-items:center;justify-content:center;color:var(--on-surface-variant);text-decoration:none;transition:all .3s" aria-label="Account">
                <span class="material-symbols-outlined" style="font-size:20px">account_circle</span>
            </a>
            <a href="<?php echo esc_url($cart_url); ?>" class="icon-btn" style="width:34px;height:34px;border-radius:999px;display:flex;align-items:center;justify-content:center;color:var(--on-surface-variant);text-decoration:none;transition:all .3s" aria-label="Cart">
                <span class="material-symbols-outlined" style="font-size:20px">shopping_bag</span>
            </a>
            <a href="#" id="mobile-menu-toggle" class="mobile-only" style="width:34px;height:34px;border-radius:999px;display:flex;align-items:center;justify-content:center;color:var(--on-surface);text-decoration:none" aria-label="Menu">
                <span class="material-symbols-outlined" id="menu-icon" style="font-size:22px">menu</span>
            </a>
        </div>
    </nav>
</header>

<div id="mobile-menu" class="hidden mobile-only" style="position:fixed;inset:0;top:50px;z-index:99;background:var(--surface);display:flex;flex-direction:column;padding:24px;gap:8px">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-link font-headline-md" style="font-size:22px;padding:14px 0;border-bottom:1px solid color-mix(in srgb,var(--outline-variant)20%,transparent);text-decoration:none;color:var(--on-surface)">Discover</a>
    <a href="<?php echo esc_url(home_url('/ai-synthesis/')); ?>" class="mobile-nav-link font-headline-md" style="font-size:22px;padding:14px 0;border-bottom:1px solid color-mix(in srgb,var(--outline-variant)20%,transparent);text-decoration:none;color:var(--on-surface)">AI Synthesis</a>
    <a href="<?php echo esc_url(home_url('/archive/')); ?>" class="mobile-nav-link font-headline-md" style="font-size:22px;padding:14px 0;border-bottom:1px solid color-mix(in srgb,var(--outline-variant)20%,transparent);text-decoration:none;color:var(--on-surface)">Archive</a>
    <a href="<?php echo esc_url(home_url('/the-atelier/')); ?>" class="mobile-nav-link font-headline-md" style="font-size:22px;padding:14px 0;border-bottom:1px solid color-mix(in srgb,var(--outline-variant)20%,transparent);text-decoration:none;color:var(--on-surface)">The Atelier</a>
    <div style="flex:1"></div>
    <div class="font-label-caps text-label-caps" style="font-size:9px;color:var(--on-surface-variant);letter-spacing:.18em">ALLSCENTED — SENSORY INTELLIGENCE</div>
</div>

<main id="main-content">

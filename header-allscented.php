<?php
/**
 * Header: Allscented
 * Digital Romanticism – Fixed nav with glassmorphism
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-inner">
        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
            <?php
            $logo_id = get_theme_mod('custom_logo');
            if ($logo_id) :
                echo wp_get_attachment_image($logo_id, 'medium', false, [
                    'style' => 'max-height: 48px; width: auto;',
                    'alt'   => get_bloginfo('name'),
                ]);
            else :
                bloginfo('name');
            endif;
            ?>
        </a>

        <!-- Desktop Navigation -->
        <nav class="primary-nav">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Discover', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/ai-scent-finder')); ?>"><?php esc_html_e('AI Scent Finder', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/compare')); ?>"><?php esc_html_e('Compare', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/archive')); ?>"><?php esc_html_e('Archive', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Shop', 'allscents'); ?></a>
        </nav>

        <!-- Header Icons -->
        <div class="header-icons">
            <button class="click-feedback" style="background: none; border: none; cursor: pointer;" onclick="window.location.href='<?php echo esc_js(wc_get_cart_url() ?: home_url('/cart')); ?>'">
                <span class="material-symbols-outlined">shopping_bag</span>
            </button>
            <button class="click-feedback" style="background: none; border: none; cursor: pointer;" onclick="window.location.href='<?php echo esc_js(get_permalink(get_option('woocommerce_myaccount_page_id')) ?: home_url('/my-account')); ?>'">
                <span class="material-symbols-outlined">account_circle</span>
            </button>
            <!-- Mobile Toggle -->
            <button class="mobile-nav-toggle" aria-label="<?php esc_attr_e('Toggle menu', 'allscents'); ?>">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
    <!-- Mobile nav dropdown -->
    <div class="mobile-nav-panel" style="display: none; padding: 20px; background: var(--color-surface); border-top: 1px solid var(--color-outline-variant); position: absolute; width: 100%; top: 80px; left: 0; z-index: 49;">
        <nav style="display: flex; flex-direction: column; gap: 16px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="font-family: var(--font-body); font-size: var(--text-body-lg); color: var(--color-on-surface-variant); text-decoration: none;"><?php esc_html_e('Discover', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/ai-scent-finder')); ?>" style="font-family: var(--font-body); font-size: var(--text-body-lg); color: var(--color-on-surface-variant); text-decoration: none;"><?php esc_html_e('AI Scent Finder', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/compare')); ?>" style="font-family: var(--font-body); font-size: var(--text-body-lg); color: var(--color-on-surface-variant); text-decoration: none;"><?php esc_html_e('Compare', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/archive')); ?>" style="font-family: var(--font-body); font-size: var(--text-body-lg); color: var(--color-on-surface-variant); text-decoration: none;"><?php esc_html_e('Archive', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/shop')); ?>" style="font-family: var(--font-body); font-size: var(--text-body-lg); color: var(--color-on-surface-variant); text-decoration: none;"><?php esc_html_e('Shop', 'allscents'); ?></a>
            <hr style="border: none; border-top: 1px solid var(--color-outline-variant); margin: 8px 0;">
            <a href="<?php echo esc_url(home_url('/cart')); ?>" style="font-family: var(--font-body); font-size: var(--text-body-md); color: var(--color-on-surface-variant); text-decoration: none;"><?php esc_html_e('Cart', 'allscents'); ?></a>
            <a href="<?php echo esc_url(home_url('/my-account')); ?>" style="font-family: var(--font-body); font-size: var(--text-body-md); color: var(--color-on-surface-variant); text-decoration: none;"><?php esc_html_e('Account', 'allscents'); ?></a>
        </nav>
    </div>
</header>

<div style="height: 80px;"></div> <!-- header spacer -->

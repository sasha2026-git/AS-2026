<?php
/**
 * Allscented Child Theme Functions
 * Digital Romanticism for Hello Elementor
 * 
 * Brand: Allscented
 * Design: AuraAI → Allscented adapted
 */

// Enqueue parent + child styles
add_action('wp_enqueue_scripts', 'allscents_enqueue_assets');
function allscents_enqueue_assets() {
    // Parent style
    wp_enqueue_style('hello-elementor-parent', get_template_directory_uri() . '/style.css');

    // Google Fonts: Playfair Display + Hanken Grotesk
    wp_enqueue_style('allscents-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Hanken+Grotesk:wght@300;400;500;600&display=swap', [], null);

    // Material Symbols
    wp_enqueue_style('allscents-icons', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', [], null);

    // Main child theme CSS
    wp_enqueue_style('allscents-style', get_stylesheet_directory_uri() . '/assets/css/allscents.css', ['hello-elementor-parent'], '1.0.0');

    // Theme JS
    wp_enqueue_script('allscents-scripts', get_stylesheet_directory_uri() . '/assets/js/scripts.js', [], '1.0.0', true);

    // Localize for AJAX if needed
    wp_localize_script('allscents-scripts', 'allscentsData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('allscents_nonce'),
        'homeUrl' => home_url(),
    ]);
}

// Theme setup
add_action('after_setup_theme', 'allscents_theme_setup');
function allscents_theme_setup() {
    // Support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Support for ACF
    add_theme_support('acf');

    // Register nav menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'allscents'),
        'footer'  => __('Footer Menu', 'allscents'),
    ]);
}

// Load ACF field groups from JSON
add_filter('acf/settings/load_json', 'allscents_acf_json_load_point');
function allscents_acf_json_load_point($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}

// Save ACF field groups to JSON
add_filter('acf/settings/save_json', 'allscents_acf_json_save_point');
function allscents_acf_json_save_point($path) {
    return get_stylesheet_directory() . '/acf-json';
}

// =============================================
// WooCommerce Overrides
// =============================================

// Remove default WooCommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Custom shop page (if not using Elementor)
add_action('after_setup_theme', 'allscents_add_woocommerce_support');

/**
 * Add SVG and webp support
 */
add_filter('upload_mimes', 'allscents_mime_types');
function allscents_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}

/**
 * Custom body classes
 */
add_filter('body_class', 'allscents_body_classes');
function allscents_body_classes($classes) {
    $classes[] = 'allscents-theme';
    $classes[] = 'digital-romanticism';
    return $classes;
}

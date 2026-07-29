<?php
/**
 * Allscented Child Theme Functions
 * Parent: Hello Elementor
 * Brand: Allscented — AI-Powered Fragrance
 * Design: Digital Romanticism
 */

// ============================================
// Enqueue Styles
// ============================================
function allscented_enqueue_styles() {
    // Parent style
    wp_enqueue_style(
        'hello-elementor',
        get_template_directory_uri() . '/style.min.css'
    );

    // Child theme style (all CSS in one file)
    wp_enqueue_style(
        'allscented-child',
        get_stylesheet_uri(),
        array('hello-elementor'),
        wp_get_theme()->get('Version')
    );

    // Google Fonts
    wp_enqueue_style(
        'allscented-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Hanken+Grotesk:wght@100..900&display=swap',
        array(),
        null
    );

    // Material Symbols
    wp_enqueue_style(
        'allscented-icons',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'allscented_enqueue_styles');

// Remove Hello Elementor header/footer so we use custom ones
add_action('after_setup_theme', function() {
    add_theme_support('hello-elementor-header-footer');
});

// ============================================
// Theme Support
// ============================================
add_action('after_setup_theme', function() {
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Post thumbnails
    add_theme_support('post-thumbnails');

    // Title tag
    add_theme_support('title-tag');

    // Custom logo
    add_theme_support('custom-logo');

    // Register nav menu
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'allscented'),
    ));
});

// ============================================
// WooCommerce: 6 products per page + pagination
// ============================================
add_filter('loop_shop_per_page', function($cols) {
    return 6;
}, 20);

// Remove default WooCommerce wrappers and replace with ours
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', function() {
    echo '<section class="px-margin-desktop container-max">';
});

add_action('woocommerce_after_main_content', function() {
    echo '</section>';
});

// Customize WooCommerce pagination to match design
add_filter('woocommerce_pagination_args', function($args) {
    $args['prev_text'] = '← Prev';
    $args['next_text'] = 'Next →';
    $args['end_size'] = 1;
    $args['mid_size'] = 1;
    return $args;
});

// ============================================
// ACF Field Registration
// ============================================
if (function_exists('acf_add_local_field_group')) {

    // --- Home Page Fields ---
    acf_add_local_field_group(array(
        'key' => 'group_allscented_home',
        'title' => 'Allscented Home Page',
        'fields' => array(
            array(
                'key' => 'field_allscented_hero_title',
                'label' => 'Hero Title',
                'name' => 'allscented_hero_title',
                'type' => 'text',
                'default_value' => 'Describe the scent of your deepest memory.',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_allscented_hero_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'allscented_hero_subtitle',
                'type' => 'text',
                'default_value' => 'SENSORY INTELLIGENCE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_allscented_hero_placeholder',
                'label' => 'Textarea Placeholder',
                'name' => 'allscented_hero_placeholder',
                'type' => 'text',
                'default_value' => 'Tell me a story... \'A rainy afternoon in Kyoto, cedarwood and wet stone...\'',
            ),
            array(
                'key' => 'field_allscented_featured_products',
                'label' => 'Featured Products (Home)',
                'name' => 'allscented_featured_products',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_allscented_fp_name',
                        'label' => 'Product Name',
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_allscented_fp_price',
                        'label' => 'Price',
                        'name' => 'price',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_allscented_fp_mood',
                        'label' => 'Mood Tag',
                        'name' => 'mood',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_allscented_fp_scene',
                        'label' => 'Scene Tag',
                        'name' => 'scene',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_allscented_fp_note',
                        'label' => 'Note Tag',
                        'name' => 'note',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_allscented_fp_image',
                        'label' => 'Product Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
    ));

    // --- The Atelier Page Fields (WooCommerce Shop) ---
    acf_add_local_field_group(array(
        'key' => 'group_allscented_atelier',
        'title' => 'The Atelier — Shop Page',
        'fields' => array(
            array(
                'key' => 'field_allscented_atelier_hero_title',
                'label' => 'Hero Title',
                'name' => 'allscented_atelier_hero_title',
                'type' => 'text',
                'default_value' => 'Signature Molecules',
            ),
            array(
                'key' => 'field_allscented_atelier_hero_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'allscented_atelier_hero_subtitle',
                'type' => 'text',
                'default_value' => 'THE ATELIER',
            ),
            array(
                'key' => 'field_allscented_atelier_hero_desc',
                'label' => 'Hero Description',
                'name' => 'allscented_atelier_hero_desc',
                'type' => 'textarea',
                'default_value' => 'Curated for your DNA. Every bottle, an echo of your digital aura.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-the-atelier.php',
                ),
            ),
        ),
    ));
}

// ============================================
// Page Templates Registration
// ============================================
function allscented_page_templates($templates) {
    $templates['page-the-atelier.php'] = 'The Atelier';
    $templates['page-ai-synthesis.php'] = 'AI Synthesis';
    $templates['page-archive.php'] = 'Archive';
    return $templates;
}
add_filter('theme_page_templates', 'allscented_page_templates');

function allscented_template_include($template) {
    if (is_page_template('page-the-atelier.php')) {
        $new = locate_template(array('page-the-atelier.php'));
        if ($new) return $new;
    }
    if (is_page_template('page-ai-synthesis.php')) {
        $new = locate_template(array('page-ai-synthesis.php'));
        if ($new) return $new;
    }
    if (is_page_template('page-archive.php')) {
        $new = locate_template(array('page-archive.php'));
        if ($new) return $new;
    }
    return $template;
}
add_filter('template_include', 'allscented_template_include');

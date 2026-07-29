<?php
/**
 * AuraAI Child Theme Functions
 * Parent: Hello Elementor
 */

// Enqueue parent + child styles
function auraai_enqueue_styles() {
    // Parent style
    wp_enqueue_style(
        'hello-elementor',
        get_template_directory_uri() . '/style.min.css'
    );

    // Child theme style (all CSS in one file)
    wp_enqueue_style(
        'auraai-child',
        get_stylesheet_uri(),
        array('hello-elementor'),
        wp_get_theme()->get('Version')
    );

    // Google Fonts (also loaded via @import in style.css, but this is for reliability)
    wp_enqueue_style(
        'auraai-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Hanken+Grotesk:wght@100..900&display=swap',
        array(),
        null
    );

    // Material Symbols
    wp_enqueue_style(
        'auraai-icons',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'auraai_enqueue_styles');

// Remove Hello Elementor header/footer so we can use custom ones
add_action('after_setup_theme', function() {
    // Tell Hello Elementor we handle the header/footer ourselves
    add_theme_support('hello-elementor-header-footer');
});

// ============================================
// ACF Field Registration
// ============================================
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_auraai_home',
        'title' => 'AuraAI Home Page',
        'fields' => array(
            array(
                'key' => 'field_auraai_hero_title',
                'label' => 'Hero Title',
                'name' => 'auraai_hero_title',
                'type' => 'text',
                'default_value' => 'Describe the scent of your deepest memory.',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_auraai_hero_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'auraai_hero_subtitle',
                'type' => 'text',
                'default_value' => 'SENSORY INTELLIGENCE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_auraai_hero_placeholder',
                'label' => 'Textarea Placeholder',
                'name' => 'auraai_hero_placeholder',
                'type' => 'text',
                'default_value' => 'Tell me a story... \'A rainy afternoon in Kyoto, cedarwood and wet stone...\'',
            ),
            array(
                'key' => 'field_auraai_featured_products',
                'label' => 'Featured Products (Home)',
                'name' => 'auraai_featured_products',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_auraai_fp_name',
                        'label' => 'Product Name',
                        'name' => 'auraai_fp_name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_auraai_fp_price',
                        'label' => 'Price',
                        'name' => 'auraai_fp_price',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_auraai_fp_mood',
                        'label' => 'Mood Tag',
                        'name' => 'auraai_fp_mood',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_auraai_fp_scene',
                        'label' => 'Scene Tag',
                        'name' => 'auraai_fp_scene',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_auraai_fp_note',
                        'label' => 'Note Tag',
                        'name' => 'auraai_fp_note',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_auraai_fp_image',
                        'label' => 'Product Image',
                        'name' => 'auraai_fp_image',
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

    acf_add_local_field_group(array(
        'key' => 'group_auraai_boutique',
        'title' => 'AuraAI Boutique',
        'fields' => array(
            array(
                'key' => 'field_auraai_boutique_hero_title',
                'label' => 'Hero Title',
                'name' => 'auraai_boutique_hero_title',
                'type' => 'text',
                'default_value' => 'Curated for your DNA. Every bottle, an echo of your digital aura.',
            ),
            array(
                'key' => 'field_auraai_boutique_products',
                'label' => 'Product Grid',
                'name' => 'auraai_boutique_products',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_auraai_bp_brand',
                        'label' => 'Brand',
                        'name' => 'auraai_bp_brand',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_auraai_bp_name',
                        'label' => 'Product Name',
                        'name' => 'auraai_bp_name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_auraai_bp_category',
                        'label' => 'Category',
                        'name' => 'auraai_bp_category',
                        'type' => 'text',
                        'instructions' => 'For Personal, For Home, or For Commercial',
                    ),
                    array(
                        'key' => 'field_auraai_bp_price',
                        'label' => 'Price',
                        'name' => 'auraai_bp_price',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_auraai_bp_buy_link',
                        'label' => 'Buy Link',
                        'name' => 'auraai_bp_buy_link',
                        'type' => 'url',
                    ),
                    array(
                        'key' => 'field_auraai_bp_image',
                        'label' => 'Product Image',
                        'name' => 'auraai_bp_image',
                        'type' => 'image',
                        'return_format' => 'array',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-boutique.php',
                ),
            ),
        ),
    ));
}

// Add custom page templates
function auraai_page_templates($templates) {
    $templates['page-boutique.php'] = 'Boutique';
    $templates['page-ai-synthesis.php'] = 'AI Synthesis';
    $templates['page-archive.php'] = 'Archive';
    return $templates;
}
add_filter('theme_page_templates', 'auraai_page_templates');

// Template include
function auraai_template_include($template) {
    if (is_page_template('page-boutique.php')) {
        $new_template = locate_template(array('page-boutique.php'));
        if ($new_template) return $new_template;
    }
    if (is_page_template('page-ai-synthesis.php')) {
        $new_template = locate_template(array('page-ai-synthesis.php'));
        if ($new_template) return $new_template;
    }
    if (is_page_template('page-archive.php')) {
        $new_template = locate_template(array('page-archive.php'));
        if ($new_template) return $new_template;
    }
    return $template;
}
add_filter('template_include', 'auraai_template_include');

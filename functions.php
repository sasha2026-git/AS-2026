<?php
/**
 * Allscented Child Theme Functions
 * Parent: Hello Elementor
 * Brand: Allscented — AI-Powered Fragrance
 * Design: Digital Romanticism
 */

// ============================================
// GitHub Auto-Updater (Plugin Update Checker)
// Push to GitHub → tag → Release → WP 后台一键更新
// ============================================
require_once __DIR__ . '/lib/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$allscented_update_checker = PucFactory::buildUpdateChecker(
    'https://github.com/sasha2026-git/allscented/',
    get_stylesheet_directory() . '/style.css',
    'allscented'
);

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
// ============================================
// Enqueue Scripts
// ============================================
function allscented_enqueue_scripts() {
    wp_enqueue_script(
        'allscented-js',
        get_stylesheet_directory_uri() . '/assets/js/allscented.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'allscented_enqueue_scripts');


// ============================================
// ACF Field Helpers (text + image, with fallback defaults)
// Safe when ACF plugin is missing or field is empty
// ============================================
function allscented_field($name, $default = '') {
    if (function_exists('get_field')) {
        $val = get_field($name);
        if ($val !== null && $val !== '' && $val !== false) {
            return $val;
        }
    }
    return $default;
}

function allscented_image_url($name, $default = '') {
    if (function_exists('get_field')) {
        $val = get_field($name);
        if (!empty($val)) {
            if (is_array($val) && !empty($val['url'])) {
                return $val['url'];
            }
            if (is_numeric($val)) {
                $src = wp_get_attachment_image_url((int) $val, 'full');
                if ($src) {
                    return $src;
                }
            }
            if (is_string($val) && filter_var($val, FILTER_VALIDATE_URL)) {
                return $val;
            }
        }
    }
    return $default;
}



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
// ACF Field Registration (ACF Free compatible)
// ============================================
/**
 * Allscented — ACF Field Groups (ACF Free compatible: text/textarea/image/group/select/tab only)
 * Registered via PHP so fields appear automatically after theme activation.
 * No repeater fields (requires ACF Pro) — each product is a fixed group.
 */
if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group(array(
        'key' => 'group_allscented_home',
        'title' => '🏠 首页内容（AllScented Home）',
        'fields' => array(
            array(
                'key' => 'tab_hero',
                'label' => 'Hero',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_h_hero_badge',
                'label' => 'Hero 顶部小字',
                'name' => 'allscented_home_hero_badge',
                'type' => 'text',
                'default_value' => 'ALLSCENTED · SENSORY INTELLIGENCE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_hero_title',
                'label' => 'Hero 大标题',
                'name' => 'allscented_home_hero_title',
                'type' => 'text',
                'default_value' => 'Where Memory Becomes Scent',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_hero_subtitle',
                'label' => 'Hero 副标题',
                'name' => 'allscented_home_hero_subtitle',
                'type' => 'textarea',
                'default_value' => 'AI-powered fragrance synthesis from your most intimate narratives',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_h_hero_cta',
                'label' => 'Hero 按钮文字',
                'name' => 'allscented_home_hero_cta',
                'type' => 'text',
                'default_value' => 'BEGIN YOUR AI SYNTHESIS',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_hero_image',
                'label' => 'Hero 背景图',
                'name' => 'allscented_home_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '50',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'tab_ai_顾问卡片',
                'label' => 'AI 顾问卡片',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_h_g1_icon',
                'label' => '顾问 1 图标(图标名)',
                'name' => 'allscented_home_g1_icon',
                'type' => 'text',
                'default_value' => 'spa',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_g1_label',
                'label' => '顾问 1 小标签',
                'name' => 'allscented_home_g1_label',
                'type' => 'text',
                'default_value' => 'AI SCENT THERAPIST · LUNÁ',
                'wrapper' => array('width' => 75),
            ),
            array(
                'key' => 'field_h_g1_name',
                'label' => '顾问 1 名字',
                'name' => 'allscented_home_g1_name',
                'type' => 'text',
                'default_value' => 'The Healer',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_g1_desc',
                'label' => '顾问 1 描述',
                'name' => 'allscented_home_g1_desc',
                'type' => 'textarea',
                'default_value' => 'Tell me how you feel today. I listen, I understand — and I find a fragrance that speaks to your heart.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_g1_tag1',
                'label' => '顾问 1 标签1',
                'name' => 'allscented_home_g1_tag1',
                'type' => 'text',
                'default_value' => 'EMOTIONAL',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_g1_tag2',
                'label' => '顾问 1 标签2',
                'name' => 'allscented_home_g1_tag2',
                'type' => 'text',
                'default_value' => 'THERAPEUTIC',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_g1_cta',
                'label' => '顾问 1 按钮文字',
                'name' => 'allscented_home_g1_cta',
                'type' => 'text',
                'default_value' => 'Start consultation',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_g2_icon',
                'label' => '顾问 2 图标(图标名)',
                'name' => 'allscented_home_g2_icon',
                'type' => 'text',
                'default_value' => 'auto_awesome',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_g2_label',
                'label' => '顾问 2 小标签',
                'name' => 'allscented_home_g2_label',
                'type' => 'text',
                'default_value' => 'AI SCENT FORTUNE TELLER · ECHO',
                'wrapper' => array('width' => 75),
            ),
            array(
                'key' => 'field_h_g2_name',
                'label' => '顾问 2 名字',
                'name' => 'allscented_home_g2_name',
                'type' => 'text',
                'default_value' => 'The Mystic',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_g2_desc',
                'label' => '顾问 2 描述',
                'name' => 'allscented_home_g2_desc',
                'type' => 'textarea',
                'default_value' => 'Curious what the universe has in store for you? Let the stars guide your scent — for fun, for hope, for destiny.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_g2_tag1',
                'label' => '顾问 2 标签1',
                'name' => 'allscented_home_g2_tag1',
                'type' => 'text',
                'default_value' => 'DIVINATION',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_g2_tag2',
                'label' => '顾问 2 标签2',
                'name' => 'allscented_home_g2_tag2',
                'type' => 'text',
                'default_value' => 'RITUAL',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_g2_cta',
                'label' => '顾问 2 按钮文字',
                'name' => 'allscented_home_g2_cta',
                'type' => 'text',
                'default_value' => 'Cast your fortune',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_g3_icon',
                'label' => '顾问 3 图标(图标名)',
                'name' => 'allscented_home_g3_icon',
                'type' => 'text',
                'default_value' => 'business_center',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_g3_label',
                'label' => '顾问 3 小标签',
                'name' => 'allscented_home_g3_label',
                'type' => 'text',
                'default_value' => 'SCENT MEMORY CONSULTANT · SAGE',
                'wrapper' => array('width' => 75),
            ),
            array(
                'key' => 'field_h_g3_name',
                'label' => '顾问 3 名字',
                'name' => 'allscented_home_g3_name',
                'type' => 'text',
                'default_value' => 'The Strategist',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_g3_desc',
                'label' => '顾问 3 描述',
                'name' => 'allscented_home_g3_desc',
                'type' => 'textarea',
                'default_value' => 'For hotels, boutiques, and brands. I design a scent strategy that becomes part of your identity and drives results.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_g3_tag1',
                'label' => '顾问 3 标签1',
                'name' => 'allscented_home_g3_tag1',
                'type' => 'text',
                'default_value' => 'COMMERCIAL',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_g3_tag2',
                'label' => '顾问 3 标签2',
                'name' => 'allscented_home_g3_tag2',
                'type' => 'text',
                'default_value' => 'BRANDING',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_g3_cta',
                'label' => '顾问 3 按钮文字',
                'name' => 'allscented_home_g3_cta',
                'type' => 'text',
                'default_value' => 'Request consultation',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'tab_the_archive_板块',
                'label' => 'THE ARCHIVE 板块',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_h_arc_eyebrow',
                'label' => 'ARCHIVE 顶部小字',
                'name' => 'allscented_home_arc_eyebrow',
                'type' => 'text',
                'default_value' => 'THE ARCHIVE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc_title',
                'label' => 'ARCHIVE 标题',
                'name' => 'allscented_home_arc_title',
                'type' => 'text',
                'default_value' => 'Curated Synthetics',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc_btn',
                'label' => 'ARCHIVE 按钮文字',
                'name' => 'allscented_home_arc_btn',
                'type' => 'text',
                'default_value' => 'Explore More',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc1_img',
                'label' => '卡片 1 图片',
                'name' => 'allscented_home_arc1_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '50',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc1_tag',
                'label' => '卡片 1 标签',
                'name' => 'allscented_home_arc1_tag',
                'type' => 'text',
                'default_value' => 'FOR PERSONAL',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc1_title',
                'label' => '卡片 1 标题',
                'name' => 'allscented_home_arc1_title',
                'type' => 'text',
                'default_value' => 'The Intimate Narrative',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc1_desc',
                'label' => '卡片 1 描述',
                'name' => 'allscented_home_arc1_desc',
                'type' => 'textarea',
                'default_value' => 'How AI decoded the scent of childhood nostalgia for a private collection.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc2_img',
                'label' => '卡片 2 图片',
                'name' => 'allscented_home_arc2_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '50',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc2_tag',
                'label' => '卡片 2 标签',
                'name' => 'allscented_home_arc2_tag',
                'type' => 'text',
                'default_value' => 'FOR HOME',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc2_title',
                'label' => '卡片 2 标题',
                'name' => 'allscented_home_arc2_title',
                'type' => 'text',
                'default_value' => 'Atmospheric Flux',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc2_desc',
                'label' => '卡片 2 描述',
                'name' => 'allscented_home_arc2_desc',
                'type' => 'textarea',
                'default_value' => 'Scents that adapt to light cycles and biometric data.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc3_img',
                'label' => '卡片 3 图片',
                'name' => 'allscented_home_arc3_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '50',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc3_tag',
                'label' => '卡片 3 标签',
                'name' => 'allscented_home_arc3_tag',
                'type' => 'text',
                'default_value' => 'FOR COMMERCIAL',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc3_title',
                'label' => '卡片 3 标题',
                'name' => 'allscented_home_arc3_title',
                'type' => 'text',
                'default_value' => 'Brand Osmosis',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_arc3_desc',
                'label' => '卡片 3 描述',
                'name' => 'allscented_home_arc3_desc',
                'type' => 'textarea',
                'default_value' => 'Architectural scenting for luxury retail.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'tab_the_collection_板块',
                'label' => 'THE COLLECTION 板块',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_h_col_eyebrow',
                'label' => 'COLLECTION 顶部小字',
                'name' => 'allscented_home_col_eyebrow',
                'type' => 'text',
                'default_value' => 'THE COLLECTION',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_col_title',
                'label' => 'COLLECTION 标题',
                'name' => 'allscented_home_col_title',
                'type' => 'text',
                'default_value' => 'Signature Molecules',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_col_main_img',
                'label' => '左侧大图',
                'name' => 'allscented_home_col_main_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=800&q=80',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_col_main_label',
                'label' => '大图上小字',
                'name' => 'allscented_home_col_main_label',
                'type' => 'text',
                'default_value' => 'THE ATELIER',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_col_main_title',
                'label' => '大图标题',
                'name' => 'allscented_home_col_main_title',
                'type' => 'text',
                'default_value' => 'AI-Designed for You',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_colp1_img',
                'label' => '右侧产品 1 图片',
                'name' => 'allscented_home_colp1_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '50',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_colp1_name',
                'label' => '右侧产品 1 名字',
                'name' => 'allscented_home_colp1_name',
                'type' => 'text',
                'default_value' => 'Aura No. 1',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_colp1_tag1',
                'label' => '产品 1 标签1',
                'name' => 'allscented_home_colp1_tag1',
                'type' => 'text',
                'default_value' => 'SERENE',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_colp1_tag2',
                'label' => '产品 1 标签2',
                'name' => 'allscented_home_colp1_tag2',
                'type' => 'text',
                'default_value' => 'MORNING',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_colp1_price',
                'label' => '产品 1 价格',
                'name' => 'allscented_home_colp1_price',
                'type' => 'text',
                'default_value' => '$185.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_colp2_img',
                'label' => '右侧产品 2 图片',
                'name' => 'allscented_home_colp2_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '50',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_colp2_name',
                'label' => '右侧产品 2 名字',
                'name' => 'allscented_home_colp2_name',
                'type' => 'text',
                'default_value' => 'Aura No. 2',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_colp2_tag1',
                'label' => '产品 2 标签1',
                'name' => 'allscented_home_colp2_tag1',
                'type' => 'text',
                'default_value' => 'SEDUCTIVE',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_colp2_tag2',
                'label' => '产品 2 标签2',
                'name' => 'allscented_home_colp2_tag2',
                'type' => 'text',
                'default_value' => 'TWILIGHT',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_h_colp2_price',
                'label' => '产品 2 价格',
                'name' => 'allscented_home_colp2_price',
                'type' => 'text',
                'default_value' => '$210.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_h_col_cta',
                'label' => 'COLLECTION 按钮文字',
                'name' => 'allscented_home_col_cta',
                'type' => 'text',
                'default_value' => 'SHOP THE ATELIER',
                'wrapper' => array('width' => 50),
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
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'front-page.php',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'home',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'front-page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_allscented_archive',
        'title' => '🗂️ Archive 页内容',
        'fields' => array(
            array(
                'key' => 'tab_页面标题区',
                'label' => '页面标题区',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_a_eyebrow',
                'label' => '顶部小字',
                'name' => 'allscented_archive_eyebrow',
                'type' => 'text',
                'default_value' => 'FRAGRANCE ARCHIVE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_a_title',
                'label' => '大标题',
                'name' => 'allscented_archive_title',
                'type' => 'text',
                'default_value' => 'Browse by Category',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_a_desc',
                'label' => '描述文字',
                'name' => 'allscented_archive_desc',
                'type' => 'textarea',
                'default_value' => 'Explore our complete library of AI-synthesized fragrances.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'tab_产品_1-4',
                'label' => '产品 1-4',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_a_p1_img',
                'label' => '产品 1 图片',
                'name' => 'allscented_archive_p1_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_a_p1_name',
                'label' => '产品 1 名字',
                'name' => 'allscented_archive_p1_name',
                'type' => 'text',
                'default_value' => 'Vesper Muse',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_a_p1_desc',
                'label' => '产品 1 描述',
                'name' => 'allscented_archive_p1_desc',
                'type' => 'textarea',
                'default_value' => 'Night-blooming jasmine, metallic aldehydes, grey amber.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_a_p1_tag1',
                'label' => '产品 1 标签1',
                'name' => 'allscented_archive_p1_tag1',
                'type' => 'text',
                'default_value' => 'INTIMATE',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p1_tag2',
                'label' => '产品 1 标签2',
                'name' => 'allscented_archive_p1_tag2',
                'type' => 'text',
                'default_value' => 'EVENING',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p1_price',
                'label' => '产品 1 价格',
                'name' => 'allscented_archive_p1_price',
                'type' => 'text',
                'default_value' => '$185.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p1_cat',
                'label' => '产品 1 分类',
                'name' => 'allscented_archive_p1_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p1_custom',
                'label' => '产品 1 CUSTOM 标(留空=不显示)',
                'name' => 'allscented_archive_p1_custom',
                'type' => 'text',
                'default_value' => '',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p2_img',
                'label' => '产品 2 图片',
                'name' => 'allscented_archive_p2_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_a_p2_name',
                'label' => '产品 2 名字',
                'name' => 'allscented_archive_p2_name',
                'type' => 'text',
                'default_value' => 'Aura No. 1',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_a_p2_desc',
                'label' => '产品 2 描述',
                'name' => 'allscented_archive_p2_desc',
                'type' => 'textarea',
                'default_value' => 'Ozone, white musk, sea salt. A morning walk through coastal mist.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_a_p2_tag1',
                'label' => '产品 2 标签1',
                'name' => 'allscented_archive_p2_tag1',
                'type' => 'text',
                'default_value' => 'SERENE',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p2_tag2',
                'label' => '产品 2 标签2',
                'name' => 'allscented_archive_p2_tag2',
                'type' => 'text',
                'default_value' => 'MORNING',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p2_price',
                'label' => '产品 2 价格',
                'name' => 'allscented_archive_p2_price',
                'type' => 'text',
                'default_value' => '$185.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p2_cat',
                'label' => '产品 2 分类',
                'name' => 'allscented_archive_p2_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p2_custom',
                'label' => '产品 2 CUSTOM 标(留空=不显示)',
                'name' => 'allscented_archive_p2_custom',
                'type' => 'text',
                'default_value' => '',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p3_img',
                'label' => '产品 3 图片',
                'name' => 'allscented_archive_p3_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_a_p3_name',
                'label' => '产品 3 名字',
                'name' => 'allscented_archive_p3_name',
                'type' => 'text',
                'default_value' => 'Atmospheric Flux',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_a_p3_desc',
                'label' => '产品 3 描述',
                'name' => 'allscented_archive_p3_desc',
                'type' => 'textarea',
                'default_value' => 'Cedarwood, amber, petrichor. Adapts to light cycles and biometric data.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_a_p3_tag1',
                'label' => '产品 3 标签1',
                'name' => 'allscented_archive_p3_tag1',
                'type' => 'text',
                'default_value' => 'ADAPTIVE',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p3_tag2',
                'label' => '产品 3 标签2',
                'name' => 'allscented_archive_p3_tag2',
                'type' => 'text',
                'default_value' => 'SPACE',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p3_price',
                'label' => '产品 3 价格',
                'name' => 'allscented_archive_p3_price',
                'type' => 'text',
                'default_value' => '$240.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p3_cat',
                'label' => '产品 3 分类',
                'name' => 'allscented_archive_p3_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p3_custom',
                'label' => '产品 3 CUSTOM 标(留空=不显示)',
                'name' => 'allscented_archive_p3_custom',
                'type' => 'text',
                'default_value' => '',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p4_img',
                'label' => '产品 4 图片',
                'name' => 'allscented_archive_p4_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_a_p4_name',
                'label' => '产品 4 名字',
                'name' => 'allscented_archive_p4_name',
                'type' => 'text',
                'default_value' => 'Brand Osmosis',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_a_p4_desc',
                'label' => '产品 4 描述',
                'name' => 'allscented_archive_p4_desc',
                'type' => 'textarea',
                'default_value' => 'Saffron, leather, smoke. Architectural scenting for luxury retail environments.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_a_p4_tag1',
                'label' => '产品 4 标签1',
                'name' => 'allscented_archive_p4_tag1',
                'type' => 'text',
                'default_value' => 'LUXURY',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p4_tag2',
                'label' => '产品 4 标签2',
                'name' => 'allscented_archive_p4_tag2',
                'type' => 'text',
                'default_value' => 'RETAIL',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p4_price',
                'label' => '产品 4 价格',
                'name' => 'allscented_archive_p4_price',
                'type' => 'text',
                'default_value' => '',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p4_cat',
                'label' => '产品 4 分类',
                'name' => 'allscented_archive_p4_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'commercial',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_a_p4_custom',
                'label' => '产品 4 CUSTOM 标(留空=不显示)',
                'name' => 'allscented_archive_p4_custom',
                'type' => 'text',
                'default_value' => 'CUSTOM',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'tab_底部_cta',
                'label' => '底部 CTA',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_a_cta_eyebrow',
                'label' => 'CTA 小字',
                'name' => 'allscented_archive_cta_eyebrow',
                'type' => 'text',
                'default_value' => 'WHOLESALE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_a_cta_title',
                'label' => 'CTA 标题',
                'name' => 'allscented_archive_cta_title',
                'type' => 'text',
                'default_value' => 'For Your Space',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_a_cta_desc',
                'label' => 'CTA 描述',
                'name' => 'allscented_archive_cta_desc',
                'type' => 'textarea',
                'default_value' => 'Curate a signature scent for your boutique, hotel, or private residence.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_a_cta_btn',
                'label' => 'CTA 按钮文字',
                'name' => 'allscented_archive_cta_btn',
                'type' => 'text',
                'default_value' => 'Begin Your Brief',
                'wrapper' => array('width' => 50),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-archive.php',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'archive',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_allscented_atelier',
        'title' => '🛍️ The Atelier 页内容',
        'fields' => array(
            array(
                'key' => 'tab_页面标题区',
                'label' => '页面标题区',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_t_eyebrow',
                'label' => '顶部小字',
                'name' => 'allscented_atelier_eyebrow',
                'type' => 'text',
                'default_value' => 'THE ATELIER',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_title',
                'label' => '大标题',
                'name' => 'allscented_atelier_title',
                'type' => 'text',
                'default_value' => 'Shop the Collection',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_desc',
                'label' => '描述文字',
                'name' => 'allscented_atelier_desc',
                'type' => 'textarea',
                'default_value' => 'Each fragrance is AI-synthesized and hand-finished. Free shipping on all orders.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'tab_产品_1-6',
                'label' => '产品 1-6',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_t_p1_img',
                'label' => '产品 1 图片',
                'name' => 'allscented_atelier_p1_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p1_name',
                'label' => '产品 1 名字',
                'name' => 'allscented_atelier_p1_name',
                'type' => 'text',
                'default_value' => 'Aura No. 1',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_t_p1_sub',
                'label' => '产品 1 副标签',
                'name' => 'allscented_atelier_p1_sub',
                'type' => 'text',
                'default_value' => 'Personal · Ozone',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p1_price',
                'label' => '产品 1 价格',
                'name' => 'allscented_atelier_p1_price',
                'type' => 'text',
                'default_value' => '$185.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p1_cat',
                'label' => '产品 1 分类',
                'name' => 'allscented_atelier_p1_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p2_img',
                'label' => '产品 2 图片',
                'name' => 'allscented_atelier_p2_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p2_name',
                'label' => '产品 2 名字',
                'name' => 'allscented_atelier_p2_name',
                'type' => 'text',
                'default_value' => 'Aura No. 2',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_t_p2_sub',
                'label' => '产品 2 副标签',
                'name' => 'allscented_atelier_p2_sub',
                'type' => 'text',
                'default_value' => 'Personal · Oud',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p2_price',
                'label' => '产品 2 价格',
                'name' => 'allscented_atelier_p2_price',
                'type' => 'text',
                'default_value' => '$210.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p2_cat',
                'label' => '产品 2 分类',
                'name' => 'allscented_atelier_p2_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p3_img',
                'label' => '产品 3 图片',
                'name' => 'allscented_atelier_p3_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p3_name',
                'label' => '产品 3 名字',
                'name' => 'allscented_atelier_p3_name',
                'type' => 'text',
                'default_value' => 'Atmospheric Flux',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_t_p3_sub',
                'label' => '产品 3 副标签',
                'name' => 'allscented_atelier_p3_sub',
                'type' => 'text',
                'default_value' => 'Home · Adaptive',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p3_price',
                'label' => '产品 3 价格',
                'name' => 'allscented_atelier_p3_price',
                'type' => 'text',
                'default_value' => '$240.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p3_cat',
                'label' => '产品 3 分类',
                'name' => 'allscented_atelier_p3_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p4_img',
                'label' => '产品 4 图片',
                'name' => 'allscented_atelier_p4_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p4_name',
                'label' => '产品 4 名字',
                'name' => 'allscented_atelier_p4_name',
                'type' => 'text',
                'default_value' => 'Spatial Bloom',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_t_p4_sub',
                'label' => '产品 4 副标签',
                'name' => 'allscented_atelier_p4_sub',
                'type' => 'text',
                'default_value' => 'Commercial · Ambient',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p4_price',
                'label' => '产品 4 价格',
                'name' => 'allscented_atelier_p4_price',
                'type' => 'text',
                'default_value' => '$320.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p4_cat',
                'label' => '产品 4 分类',
                'name' => 'allscented_atelier_p4_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'commercial',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p5_img',
                'label' => '产品 5 图片',
                'name' => 'allscented_atelier_p5_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p5_name',
                'label' => '产品 5 名字',
                'name' => 'allscented_atelier_p5_name',
                'type' => 'text',
                'default_value' => 'Vesper Muse',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_t_p5_sub',
                'label' => '产品 5 副标签',
                'name' => 'allscented_atelier_p5_sub',
                'type' => 'text',
                'default_value' => 'Personal · Floral',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p5_price',
                'label' => '产品 5 价格',
                'name' => 'allscented_atelier_p5_price',
                'type' => 'text',
                'default_value' => '$185.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p5_cat',
                'label' => '产品 5 分类',
                'name' => 'allscented_atelier_p5_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p6_img',
                'label' => '产品 6 图片',
                'name' => 'allscented_atelier_p6_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p6_name',
                'label' => '产品 6 名字',
                'name' => 'allscented_atelier_p6_name',
                'type' => 'text',
                'default_value' => 'Nordic Noir',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_t_p6_sub',
                'label' => '产品 6 副标签',
                'name' => 'allscented_atelier_p6_sub',
                'type' => 'text',
                'default_value' => 'Commercial · Forest',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_p6_price',
                'label' => '产品 6 价格',
                'name' => 'allscented_atelier_p6_price',
                'type' => 'text',
                'default_value' => '$280.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p6_cat',
                'label' => '产品 6 分类',
                'name' => 'allscented_atelier_p6_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'commercial',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'tab_底部_cta',
                'label' => '底部 CTA',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_t_cta_eyebrow',
                'label' => 'CTA 小字',
                'name' => 'allscented_atelier_cta_eyebrow',
                'type' => 'text',
                'default_value' => 'WHOLESALE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_cta_title',
                'label' => 'CTA 标题',
                'name' => 'allscented_atelier_cta_title',
                'type' => 'text',
                'default_value' => 'For Your Space',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_t_cta_desc',
                'label' => 'CTA 描述',
                'name' => 'allscented_atelier_cta_desc',
                'type' => 'textarea',
                'default_value' => 'Curate a signature scent for your boutique, hotel, or private residence.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_t_cta_btn',
                'label' => 'CTA 按钮文字',
                'name' => 'allscented_atelier_cta_btn',
                'type' => 'text',
                'default_value' => 'Request Consultation',
                'wrapper' => array('width' => 50),
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
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'the-atelier',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_allscented_ai',
        'title' => '✨ AI Synthesis 页内容',
        'fields' => array(
            array(
                'key' => 'tab_页面标题区',
                'label' => '页面标题区',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_s_eyebrow',
                'label' => '顶部小字',
                'name' => 'allscented_ai_eyebrow',
                'type' => 'text',
                'default_value' => 'AI SYNTHESIS',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_title',
                'label' => '大标题',
                'name' => 'allscented_ai_title',
                'type' => 'text',
                'default_value' => 'Meet your scent guides.',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_desc',
                'label' => '描述文字',
                'name' => 'allscented_ai_desc',
                'type' => 'textarea',
                'default_value' => 'Three ways to find your fragrance — each with a different purpose, a different voice.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'tab_ai_顾问',
                'label' => 'AI 顾问',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_s_g1_name',
                'label' => '顾问 1 名字',
                'name' => 'allscented_ai_g1_name',
                'type' => 'text',
                'default_value' => 'The Healer',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_g1_desc',
                'label' => '顾问 1 描述',
                'name' => 'allscented_ai_g1_desc',
                'type' => 'textarea',
                'default_value' => 'Tell me how you feel today. I listen, I understand — and I find a fragrance that speaks to your heart. Because scent is not just smell, it\'s comfort.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_g2_name',
                'label' => '顾问 2 名字',
                'name' => 'allscented_ai_g2_name',
                'type' => 'text',
                'default_value' => 'The Mystic',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_g2_desc',
                'label' => '顾问 2 描述',
                'name' => 'allscented_ai_g2_desc',
                'type' => 'textarea',
                'default_value' => 'Curious what the universe has in store for you? Let the stars guide your scent — from incense and agarwood to sacred resins. For fun, for hope, for destiny.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_g3_name',
                'label' => '顾问 3 名字',
                'name' => 'allscented_ai_g3_name',
                'type' => 'text',
                'default_value' => 'The Strategist',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_g3_desc',
                'label' => '顾问 3 描述',
                'name' => 'allscented_ai_g3_desc',
                'type' => 'textarea',
                'default_value' => 'For hotels, boutiques, and brands. Backed by real case studies and AI data — I design a scent strategy that becomes part of your identity and drives results.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'tab_产品卡（第1页）',
                'label' => '产品卡（第1页）',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_s_p1_1_img',
                'label' => '产品 1 图片',
                'name' => 'allscented_ai_p1_1_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p1_1_name',
                'label' => '产品 1 名字',
                'name' => 'allscented_ai_p1_1_name',
                'type' => 'text',
                'default_value' => 'Aura No. 2',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_s_p1_1_notes',
                'label' => '产品 1 香调说明',
                'name' => 'allscented_ai_p1_1_notes',
                'type' => 'textarea',
                'default_value' => 'Saffron, Oud, Labdanum — a smoky, deep signature for the bold spirit.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p1_1_price',
                'label' => '产品 1 价格',
                'name' => 'allscented_ai_p1_1_price',
                'type' => 'text',
                'default_value' => '$210.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p1_1_why',
                'label' => '产品 1 WHY THIS MATCHES YOU',
                'name' => 'allscented_ai_p1_1_why',
                'type' => 'textarea',
                'default_value' => 'The deep, smoky warmth of this fragrance mirrors your craving for security and transformation. The labdanum base creates a lingering sense of comfort that lasts through autumn evenings — like being wrapped in something both bold and tender.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p1_1_btn',
                'label' => '产品 1 按钮文字',
                'name' => 'allscented_ai_p1_1_btn',
                'type' => 'text',
                'default_value' => 'View on Amazon',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p1_2_img',
                'label' => '产品 2 图片',
                'name' => 'allscented_ai_p1_2_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p1_2_name',
                'label' => '产品 2 名字',
                'name' => 'allscented_ai_p1_2_name',
                'type' => 'text',
                'default_value' => 'Comforting Embrace',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_s_p1_2_notes',
                'label' => '产品 2 香调说明',
                'name' => 'allscented_ai_p1_2_notes',
                'type' => 'textarea',
                'default_value' => 'Chamomile, Lavender, Soft Musk — a warm blanket for the soul.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p1_2_price',
                'label' => '产品 2 价格',
                'name' => 'allscented_ai_p1_2_price',
                'type' => 'text',
                'default_value' => '$145.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p1_2_why',
                'label' => '产品 2 WHY THIS MATCHES YOU',
                'name' => 'allscented_ai_p1_2_why',
                'type' => 'textarea',
                'default_value' => 'The chamomile and lavender echoes your desire for softness and warmth. The soft musk base keeps the scent intimate and close to the skin — exactly what you described wanting. Think of it as a cashmere blanket, not a spotlight.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p1_2_btn',
                'label' => '产品 2 按钮文字',
                'name' => 'allscented_ai_p1_2_btn',
                'type' => 'text',
                'default_value' => 'View on Amazon',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p1_3_img',
                'label' => '产品 3 图片',
                'name' => 'allscented_ai_p1_3_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p1_3_name',
                'label' => '产品 3 名字',
                'name' => 'allscented_ai_p1_3_name',
                'type' => 'text',
                'default_value' => 'Vesper Muse',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_s_p1_3_notes',
                'label' => '产品 3 香调说明',
                'name' => 'allscented_ai_p1_3_notes',
                'type' => 'textarea',
                'default_value' => 'Night-blooming jasmine, metallic aldehydes, grey amber — an evening ritual.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p1_3_price',
                'label' => '产品 3 价格',
                'name' => 'allscented_ai_p1_3_price',
                'type' => 'text',
                'default_value' => '$85.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p1_3_why',
                'label' => '产品 3 WHY THIS MATCHES YOU',
                'name' => 'allscented_ai_p1_3_why',
                'type' => 'textarea',
                'default_value' => 'The night-blooming jasmine speaks to the introspective side of your autumn mood, while the grey amber adds a touch of mystery. An affordable option that still carries emotional depth — perfect for your quiet evening rituals.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p1_3_btn',
                'label' => '产品 3 按钮文字',
                'name' => 'allscented_ai_p1_3_btn',
                'type' => 'text',
                'default_value' => 'View on Amazon',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'tab_产品卡（第2页）',
                'label' => '产品卡（第2页）',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_s_p2_1_img',
                'label' => '产品 1 图片',
                'name' => 'allscented_ai_p2_1_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p2_1_name',
                'label' => '产品 1 名字',
                'name' => 'allscented_ai_p2_1_name',
                'type' => 'text',
                'default_value' => 'Aura No. 1',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_s_p2_1_notes',
                'label' => '产品 1 香调说明',
                'name' => 'allscented_ai_p2_1_notes',
                'type' => 'textarea',
                'default_value' => 'Ozone, white musk, sea salt — a morning walk through coastal mist.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p2_1_price',
                'label' => '产品 1 价格',
                'name' => 'allscented_ai_p2_1_price',
                'type' => 'text',
                'default_value' => '$185.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p2_1_why',
                'label' => '产品 1 WHY THIS MATCHES YOU',
                'name' => 'allscented_ai_p2_1_why',
                'type' => 'textarea',
                'default_value' => 'The cleansing ozone and white musk align with the cards\' message of renewal — a burning away of the old. This scent clears the energy and opens the heart to new beginnings, like walking through coastal mist at dawn after a spiritual practice.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p2_1_btn',
                'label' => '产品 1 按钮文字',
                'name' => 'allscented_ai_p2_1_btn',
                'type' => 'text',
                'default_value' => 'View on Amazon',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p2_2_img',
                'label' => '产品 2 图片',
                'name' => 'allscented_ai_p2_2_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p2_2_name',
                'label' => '产品 2 名字',
                'name' => 'allscented_ai_p2_2_name',
                'type' => 'text',
                'default_value' => 'Sacred Resin',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_s_p2_2_notes',
                'label' => '产品 2 香调说明',
                'name' => 'allscented_ai_p2_2_notes',
                'type' => 'textarea',
                'default_value' => 'Incense, agarwood, saffron — a ritual wrapped in a bottle.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p2_2_price',
                'label' => '产品 2 价格',
                'name' => 'allscented_ai_p2_2_price',
                'type' => 'text',
                'default_value' => '$95.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p2_2_why',
                'label' => '产品 2 WHY THIS MATCHES YOU',
                'name' => 'allscented_ai_p2_2_why',
                'type' => 'textarea',
                'default_value' => 'The incense and agarwood directly mirror the cards\' divination of fire and smoke. This fragrance embodies the sacred-wild duality — affordable enough to explore without commitment, deep enough to ground your spiritual practice.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p2_2_btn',
                'label' => '产品 2 按钮文字',
                'name' => 'allscented_ai_p2_2_btn',
                'type' => 'text',
                'default_value' => 'View on Amazon',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p2_3_img',
                'label' => '产品 3 图片',
                'name' => 'allscented_ai_p2_3_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p2_3_name',
                'label' => '产品 3 名字',
                'name' => 'allscented_ai_p2_3_name',
                'type' => 'text',
                'default_value' => 'Midnight Prayer',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_s_p2_3_notes',
                'label' => '产品 3 香调说明',
                'name' => 'allscented_ai_p2_3_notes',
                'type' => 'textarea',
                'default_value' => 'Black amber, labdanum, benzoin — the scent of midnight prayers.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p2_3_price',
                'label' => '产品 3 价格',
                'name' => 'allscented_ai_p2_3_price',
                'type' => 'text',
                'default_value' => '$260.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p2_3_why',
                'label' => '产品 3 WHY THIS MATCHES YOU',
                'name' => 'allscented_ai_p2_3_why',
                'type' => 'textarea',
                'default_value' => 'The black amber and benzoin align with your craving for transformation. This is the invest-in-yourself option — a premium ritual scent that matches the depth of the shift you\'re experiencing. The universe whispers yes.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p2_3_btn',
                'label' => '产品 3 按钮文字',
                'name' => 'allscented_ai_p2_3_btn',
                'type' => 'text',
                'default_value' => 'View on Amazon',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'tab_产品卡（第3页）',
                'label' => '产品卡（第3页）',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_s_p3_1_img',
                'label' => '产品 1 图片',
                'name' => 'allscented_ai_p3_1_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p3_1_name',
                'label' => '产品 1 名字',
                'name' => 'allscented_ai_p3_1_name',
                'type' => 'text',
                'default_value' => 'White Linen',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_s_p3_1_notes',
                'label' => '产品 1 香调说明',
                'name' => 'allscented_ai_p3_1_notes',
                'type' => 'textarea',
                'default_value' => 'Bergamot, linen, white tea — a clean slate.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p3_1_price',
                'label' => '产品 1 价格',
                'name' => 'allscented_ai_p3_1_price',
                'type' => 'text',
                'default_value' => '$120.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p3_1_why',
                'label' => '产品 1 WHY THIS MATCHES YOU',
                'name' => 'allscented_ai_p3_1_why',
                'type' => 'textarea',
                'default_value' => 'The clean, fresh notes balance the heaviness of autumn — a bright counterpoint to your reflective mood. Think of it as a morning breath after a long night.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p3_1_btn',
                'label' => '产品 1 按钮文字',
                'name' => 'allscented_ai_p3_1_btn',
                'type' => 'text',
                'default_value' => 'View on Amazon',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p3_2_img',
                'label' => '产品 2 图片',
                'name' => 'allscented_ai_p3_2_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p3_2_name',
                'label' => '产品 2 名字',
                'name' => 'allscented_ai_p3_2_name',
                'type' => 'text',
                'default_value' => 'Fig Leaf Study',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_s_p3_2_notes',
                'label' => '产品 2 香调说明',
                'name' => 'allscented_ai_p3_2_notes',
                'type' => 'textarea',
                'default_value' => 'Fig, black tea, leather — contemplative depths.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p3_2_price',
                'label' => '产品 2 价格',
                'name' => 'allscented_ai_p3_2_price',
                'type' => 'text',
                'default_value' => '$155.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p3_2_why',
                'label' => '产品 2 WHY THIS MATCHES YOU',
                'name' => 'allscented_ai_p3_2_why',
                'type' => 'textarea',
                'default_value' => 'The fig and black tea evoke quiet afternoons with a book — perfect for the introspective season you\'re in. Leather adds a grounded, sensual touch.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p3_2_btn',
                'label' => '产品 2 按钮文字',
                'name' => 'allscented_ai_p3_2_btn',
                'type' => 'text',
                'default_value' => 'View on Amazon',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p3_3_img',
                'label' => '产品 3 图片',
                'name' => 'allscented_ai_p3_3_img',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => '选择图片上传，或粘贴图片 URL（图片地址会自动显示）',
                'default_value' => '40',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p3_3_name',
                'label' => '产品 3 名字',
                'name' => 'allscented_ai_p3_3_name',
                'type' => 'text',
                'default_value' => 'Pear & Freesia',
                'wrapper' => array('width' => 60),
            ),
            array(
                'key' => 'field_s_p3_3_notes',
                'label' => '产品 3 香调说明',
                'name' => 'allscented_ai_p3_3_notes',
                'type' => 'textarea',
                'default_value' => 'Pear, freesia, white cedar — fresh and approachable.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p3_3_price',
                'label' => '产品 3 价格',
                'name' => 'allscented_ai_p3_3_price',
                'type' => 'text',
                'default_value' => '$75.00',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_p3_3_why',
                'label' => '产品 3 WHY THIS MATCHES YOU',
                'name' => 'allscented_ai_p3_3_why',
                'type' => 'textarea',
                'default_value' => 'A great entry point if you\'re not ready to commit to a heavy scent. Bright, uplifting, and effortless — like a gentle nudge toward joy on grey days.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_s_p3_3_btn',
                'label' => '产品 3 按钮文字',
                'name' => 'allscented_ai_p3_3_btn',
                'type' => 'text',
                'default_value' => 'View on Amazon',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'tab_底部_cta',
                'label' => '底部 CTA',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_s_cta_title',
                'label' => 'CTA 标题',
                'name' => 'allscented_ai_cta_title',
                'type' => 'text',
                'default_value' => 'Not sure where to start?',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_s_cta_desc',
                'label' => 'CTA 描述',
                'name' => 'allscented_ai_cta_desc',
                'type' => 'textarea',
                'default_value' => 'Tell us a little about yourself — your mood, your curiosity, or your business. One of our guides will find the perfect match.',
                'rows' => 2,
                'new_lines' => 'br',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_digital_tab',
                'label' => '数字人 & 对话（可上传头像图片、修改文字）',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_ai_g1_avatar',
                'label' => '顾问1 头像（数字人头像）',
                'name' => 'allscented_ai_g1_avatar',
                'type' => 'image',
                'instructions' => '上传后替代默认图标；建议方形图片，自动裁圆',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g1_role',
                'label' => '顾问1 角色标签',
                'name' => 'allscented_ai_g1_role',
                'type' => 'text',
                'default_value' => 'AI SCENT THERAPIST · LUNÁ',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g1_shortname',
                'label' => '顾问1 短名',
                'name' => 'allscented_ai_g1_shortname',
                'type' => 'text',
                'default_value' => 'Luná',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g1_cta',
                'label' => '顾问1 按钮文字',
                'name' => 'allscented_ai_g1_cta',
                'type' => 'text',
                'default_value' => 'SHARE YOUR MOOD',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g2_avatar',
                'label' => '顾问2 头像（数字人头像）',
                'name' => 'allscented_ai_g2_avatar',
                'type' => 'image',
                'instructions' => '上传后替代默认图标；建议方形图片，自动裁圆',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g2_role',
                'label' => '顾问2 角色标签',
                'name' => 'allscented_ai_g2_role',
                'type' => 'text',
                'default_value' => 'AI SCENT FORTUNE TELLER · ECHO',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g2_shortname',
                'label' => '顾问2 短名',
                'name' => 'allscented_ai_g2_shortname',
                'type' => 'text',
                'default_value' => 'Echo',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g2_cta',
                'label' => '顾问2 按钮文字',
                'name' => 'allscented_ai_g2_cta',
                'type' => 'text',
                'default_value' => 'CAST YOUR FORTUNE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g3_avatar',
                'label' => '顾问3 头像（数字人头像）',
                'name' => 'allscented_ai_g3_avatar',
                'type' => 'image',
                'instructions' => '上传后替代默认图标；建议方形图片，自动裁圆',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g3_role',
                'label' => '顾问3 角色标签',
                'name' => 'allscented_ai_g3_role',
                'type' => 'text',
                'default_value' => 'SCENT MEMORY CONSULTANT · SAGE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g3_shortname',
                'label' => '顾问3 短名',
                'name' => 'allscented_ai_g3_shortname',
                'type' => 'text',
                'default_value' => 'Sage',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_g3_cta',
                'label' => '顾问3 按钮文字',
                'name' => 'allscented_ai_g3_cta',
                'type' => 'text',
                'default_value' => 'REQUEST CONSULTATION',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_chat_user',
                'label' => '对话-用户头像（Alice）',
                'name' => 'allscented_ai_chat_user_avatar',
                'type' => 'image',
                'instructions' => '三个对话预览共用；建议 100x100 以上方形图',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_ai_chat_g1',
                'label' => '对话-Luná 头像',
                'name' => 'allscented_ai_chat_g1_avatar',
                'type' => 'image',
                'instructions' => '对话预览中的顾问头像',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_ai_chat_g2',
                'label' => '对话-Echo 头像',
                'name' => 'allscented_ai_chat_g2_avatar',
                'type' => 'image',
                'instructions' => '对话预览中的顾问头像',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_ai_chat_g3',
                'label' => '对话-Sage 头像',
                'name' => 'allscented_ai_chat_g3_avatar',
                'type' => 'image',
                'instructions' => '对话预览中的顾问头像',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_ai_cases_tab',
                'label' => '案例卡片（Sample Consultations）',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_ai_case1_avatar',
                'label' => '案例1 头像',
                'name' => 'allscented_ai_case1_avatar',
                'type' => 'image',
                'instructions' => '疗愈师案例卡片头像',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case1_label',
                'label' => '案例1 标签',
                'name' => 'allscented_ai_case1_label',
                'type' => 'text',
                'default_value' => 'AI SCENT THERAPIST',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case1_pct',
                'label' => '案例1 合成度',
                'name' => 'allscented_ai_case1_pct',
                'type' => 'text',
                'default_value' => '96% SYNTHESIS',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case1_title',
                'label' => '案例1 标题',
                'name' => 'allscented_ai_case1_title',
                'type' => 'text',
                'default_value' => '"You need to feel held."',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case1_summary',
                'label' => '案例1 总结文字',
                'name' => 'allscented_ai_case1_summary',
                'type' => 'textarea',
                'default_value' => 'After our conversation, I know you need something soft, warm, and tender. Chamomile to soothe. Rice steam to comfort. Lavender to release. A fragrance that stays close to the skin — like a cashmere blanket, not a spotlight.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_ai_case2_avatar',
                'label' => '案例2 头像',
                'name' => 'allscented_ai_case2_avatar',
                'type' => 'image',
                'instructions' => '占卜师案例卡片头像',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case2_label',
                'label' => '案例2 标签',
                'name' => 'allscented_ai_case2_label',
                'type' => 'text',
                'default_value' => 'AI SCENT FORTUNE TELLER · ECHO',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case2_pct',
                'label' => '案例2 合成度',
                'name' => 'allscented_ai_case2_pct',
                'type' => 'text',
                'default_value' => '92% SYNTHESIS',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case2_title',
                'label' => '案例2 标题',
                'name' => 'allscented_ai_case2_title',
                'type' => 'text',
                'default_value' => '"The universe whispers in amber."',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case2_summary',
                'label' => '案例2 总结文字',
                'name' => 'allscented_ai_case2_summary',
                'type' => 'textarea',
                'default_value' => 'Your birth chart says you\'re craving transformation under this waning crescent. The cards reveal fire and smoke — but not destruction. A burning away of the old. I see incense. I see oud. I see a fragrance that knows what it means to be both sacred and wild.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_ai_case3_avatar',
                'label' => '案例3 头像',
                'name' => 'allscented_ai_case3_avatar',
                'type' => 'image',
                'instructions' => '顾问案例卡片头像',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case3_label',
                'label' => '案例3 标签',
                'name' => 'allscented_ai_case3_label',
                'type' => 'text',
                'default_value' => 'SCENT MEMORY CONSULTANT · SAGE',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case3_pct',
                'label' => '案例3 合成度',
                'name' => 'allscented_ai_case3_pct',
                'type' => 'text',
                'default_value' => '88% SYNTHESIS',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case3_title',
                'label' => '案例3 标题',
                'name' => 'allscented_ai_case3_title',
                'type' => 'text',
                'default_value' => '"Your brand needs a signature."',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_ai_case3_summary',
                'label' => '案例3 总结文字',
                'name' => 'allscented_ai_case3_summary',
                'type' => 'textarea',
                'default_value' => 'You described a boutique hotel in Dali with 12 rooms, whitewashed walls, and a courtyard full of jasmine. Based on 3 case studies with similar spatial profiles, I recommend an adaptive scent system: calming jasmine-green tea for the rooms, a crisp petrichor-ozone for the lobby, and warm sandalwood for the lounge.',
                'rows' => 3,
                'new_lines' => 'br',
                'wrapper' => array('width' => 100),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-ai-synthesis.php',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'ai-synthesis',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
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

// ============================================
// 页眉 / 页脚 可视化编辑（外观 → 自定义）
// ============================================
add_action('customize_register', 'allscented_customize_register');
function allscented_customize_register($wp_customize) {
    // —— 页眉设置 ——
    $wp_customize->add_section('allscented_header_settings', array(
        'title'    => '页眉设置（Header）',
        'priority' => 30,
    ));
    $wp_customize->add_setting('allscented_header_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'allscented_header_logo', array(
        'label'       => '页眉 Logo 图片',
        'description' => '上传后替代默认 Logo（建议透明背景 PNG，高度约 30px）。不填则显示默认 Logo / 品牌文字。',
        'section'     => 'allscented_header_settings',
    )));
    $wp_customize->add_setting('allscented_brand_text', array(
        'default'           => 'ALLSCENTED',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('allscented_brand_text', array(
        'label'   => '品牌文字（无 Logo 图片时显示）',
        'section' => 'allscented_header_settings',
        'type'    => 'text',
    ));

    // —— 页脚设置 ——
    $wp_customize->add_section('allscented_footer_settings', array(
        'title'    => '页脚设置（Footer）',
        'priority' => 31,
    ));
    $wp_customize->add_setting('allscented_footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'allscented_footer_logo', array(
        'label'       => '页脚 Logo 图片',
        'description' => '建议透明背景 PNG，高度约 24px。不填则沿用页眉 Logo / 品牌文字。',
        'section'     => 'allscented_footer_settings',
    )));
    $wp_customize->add_setting('allscented_footer_tagline', array(
        'default'           => 'Sensory intelligence, bottled. AI-synthesized fragrances from your most intimate narratives.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('allscented_footer_tagline', array(
        'label'   => '页脚标语文字',
        'section' => 'allscented_footer_settings',
        'type'    => 'textarea',
    ));
    $wp_customize->add_setting('allscented_footer_copyright', array(
        'default'           => 'ALLSCENTED — ALL RIGHTS RESERVED',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('allscented_footer_copyright', array(
        'label'   => '版权文字（自动带 © 年份）',
        'section' => 'allscented_footer_settings',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('allscented_footer_badge', array(
        'default'           => 'CRAFTED WITH AI INTELLIGENCE',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('allscented_footer_badge', array(
        'label'   => '底部徽标文字',
        'section' => 'allscented_footer_settings',
        'type'    => 'text',
    ));
}

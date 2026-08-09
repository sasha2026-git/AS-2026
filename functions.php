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
    'https://github.com/sasha2026-git/AS-2026/',
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
        get_template_directory_uri() . '/style.css'
    );

    // Child theme style (all CSS in one file)
    wp_enqueue_style(
        'allscented-child',
        get_stylesheet_uri(),
        array('hello-elementor'),
        wp_get_theme()->get('Version')
    );

    // Local fonts
    wp_enqueue_style(
        'allscented-fonts',
        get_stylesheet_directory_uri() . '/assets/css/fonts.css',
        array('allscented-child'),
        wp_get_theme()->get('Version')
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

    // Enqueue media library + localize AJAX data for cover editing
    if (current_user_can('edit_posts')) {
        wp_enqueue_media();
        wp_localize_script('allscented-js', 'allscented_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('allscented_cover_nonce'),
            'strings'  => array(
                'select_cover' => __('Select Cover Image', 'allscented'),
                'use_image'    => __('Use as Cover', 'allscented'),
            ),
        ));
    }
}
add_action('wp_enqueue_scripts', 'allscented_enqueue_scripts');


// ============================================
// ACF Field Helpers (text + image, with fallback defaults)
// Safe when ACF plugin is missing or field is empty
// ============================================
function allscented_field($name, $default = '', $post_id = false) {
    if (function_exists('get_field')) {
        $val = get_field($name, $post_id);
        if ($val !== null && $val !== '' && $val !== false) {
            return $val;
        }
    }
    return $default;
}

function allscented_image_url($name, $default = '', $post_id = false) {
    if (function_exists('get_field')) {
        $val = get_field($name, $post_id);
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

function allscented_group_field($group, $sub, $default = '', $post_id = false) {
    if (function_exists('get_field')) {
        $val = get_field($group, $post_id);
        if (is_array($val) && isset($val[$sub]) && $val[$sub] !== '' && $val[$sub] !== null && $val[$sub] !== false) {
            return $val[$sub];
        }
    }
    return $default;
}



function allscented_acf_media_url($value, $default = '') {
    if (is_array($value)) {
        return isset($value['url']) && $value['url'] !== '' ? $value['url'] : $default;
    }
    if (is_numeric($value)) {
        $url = wp_get_attachment_image_url((int) $value, 'large');
        return $url ? $url : $default;
    }
    if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
        return $value;
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
        'footer_explore' => __('Footer Explore', 'allscented'),
        'footer_legal'   => __('Footer Legal', 'allscented'),
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
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

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
// Product description cleanup (Shopify -> clean HTML)
// ============================================
/**
 * 清洗 Shopify 导入的产品长描述：去掉 Polaris/div 残留、展示性属性与多余 br，
 * 仅保留 p/img/strong/em/ul/li，并给商品图统一 product-detail-img class。
 * 优先使用 DOMDocument；当前环境没有 DOM 扩展时自动走正则兜底。
 */
function allscented_clean_product_description($content = '') {
    if (!is_string($content)) {
        return '';
    }

    ob_start();
    echo $content;
    $html = ob_get_clean();

    if (trim($html) === '') {
        return '';
    }

    $html = allscented_clean_product_description_prepare($html);

    if (class_exists('DOMDocument')) {
        return allscented_clean_product_description_with_dom($html);
    }

    return allscented_clean_product_description_with_regex($html);
}

function allscented_clean_product_description_prepare($html) {
    $html = preg_replace('~<!--.*?-->~s', '', $html);
    $html = preg_replace('~<script\b[^>]*>.*?</script>~is', '', $html);
    $html = preg_replace('~<style\b[^>]*>.*?</style>~is', '', $html);

    $html = preg_replace('~(?:<br\b[^>]*>\s*){2,}~i', '<br>', $html);
    $html = preg_replace('~<br\b[^>]*>\s*(?=</(?:p|li|div|span|strong|em)>)~i', '', $html);

    return $html;
}

function allscented_clean_product_description_is_empty($html) {
    if (strpos($html, '<img') !== false) {
        return false;
    }

    $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return trim(preg_replace('/\s/u', '', $text)) === '';
}

function allscented_clean_product_description_attr($value) {
    return htmlspecialchars(html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES, 'UTF-8');
}

function allscented_clean_product_description_with_dom($html) {
    $dom = new DOMDocument();
    $previous = libxml_use_internal_errors(true);
    $dom->loadHTML('<meta charset="utf-8">' . $html);
    libxml_clear_errors();
    libxml_use_internal_errors($previous);

    $body = $dom->getElementsByTagName('body')->item(0);
    if (!$body) {
        return '';
    }

    $output = '';
    foreach ($body->childNodes as $child) {
        $output .= allscented_clean_product_description_dom_node($child);
    }

    return trim($output);
}

function allscented_clean_product_description_dom_node($node) {
    $output = '';

    foreach ($node->childNodes as $child) {
        if ($child->nodeType === XML_TEXT_NODE) {
            $text = trim($child->nodeValue);
            if ($text !== '') {
                $output .= $text;
            }
            continue;
        }

        if ($child->nodeType !== XML_ELEMENT_NODE) {
            continue;
        }

        $tag = strtolower($child->nodeName);

        if (in_array($tag, array('script', 'style', 'iframe', 'object', 'embed', 'svg'), true)) {
            continue;
        }

        if ($tag === 'br') {
            continue;
        }

        $inner = allscented_clean_product_description_dom_node($child);

        if ($tag === 'img') {
            $src = trim($child->getAttribute('src'));
            $alt = trim($child->getAttribute('alt'));
            if ($src === '') {
                continue;
            }
            $output .= '<img class="product-detail-img" src="' . allscented_clean_product_description_attr($src) . '" alt="' . allscented_clean_product_description_attr($alt) . '">';
            continue;
        }

        if (in_array($tag, array('p', 'strong', 'em', 'ul', 'li'), true)) {
            if (!allscented_clean_product_description_is_empty($inner)) {
                $output .= '<' . $tag . '>' . $inner . '</' . $tag . '>';
            }
            continue;
        }

        $output .= $inner;
    }

    return $output;
}

function allscented_clean_product_description_with_regex($html) {
    $html = preg_replace_callback('~<(/?)(p|img|strong|em|ul|li)\b([^>]*)>~i', function($match) {
        $closing = $match[1] === '/';
        $tag = strtolower($match[2]);

        if ($closing || $tag !== 'img') {
            return '<' . $match[1] . $tag . '>';
        }

        $src = '';
        if (preg_match('~\bsrc\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))~i', $match[3], $src_match)) {
            if (isset($src_match[1]) && $src_match[1] !== '') {
                $src = $src_match[1];
            } elseif (isset($src_match[2]) && $src_match[2] !== '') {
                $src = $src_match[2];
            } elseif (isset($src_match[3]) && $src_match[3] !== '') {
                $src = $src_match[3];
            }
        }

        $alt = '';
        if (preg_match('~\balt\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))~i', $match[3], $alt_match)) {
            if (isset($alt_match[1]) && $alt_match[1] !== '') {
                $alt = $alt_match[1];
            } elseif (isset($alt_match[2]) && $alt_match[2] !== '') {
                $alt = $alt_match[2];
            } elseif (isset($alt_match[3]) && $alt_match[3] !== '') {
                $alt = $alt_match[3];
            }
        }

        if ($src === '') {
            return '';
        }

        return '<img class="product-detail-img" src="' . allscented_clean_product_description_attr($src) . '" alt="' . allscented_clean_product_description_attr($alt) . '">';
    }, $html);

    $html = preg_replace_callback('~<(p|li)\b[^>]*>([\s\S]*?)</\1>~i', function($match) {
        $tag = strtolower($match[1]);
        $parts = preg_split('~<br\b[^>]*>~i', $match[2]);
        $parts = array_map(function($part) {
            return trim($part);
        }, $parts);
        $parts = array_values(array_filter($parts, function($part) {
            return !allscented_clean_product_description_is_empty($part);
        }));

        if (!$parts) {
            return '';
        }

        return '<' . $tag . '>' . implode('</' . $tag . '><' . $tag . '>', $parts) . '</' . $tag . '>';
    }, $html);

    $html = preg_replace_callback('~</?([a-zA-Z][a-zA-Z0-9]*)\b[^>]*>~', function($match) {
        $tag = strtolower($match[1]);
        if (in_array($tag, array('p', 'img', 'strong', 'em', 'ul', 'li'), true)) {
            return $match[0];
        }
        return '';
    }, $html);

    for ($i = 0; $i < 10; $i++) {
        $before = $html;
        $html = preg_replace_callback('~<(p|strong|em|ul|li)\b[^>]*>([\s\S]*?)</\1>~i', function($match) {
            return allscented_clean_product_description_is_empty($match[2]) ? '' : $match[0];
        }, $html);
        if ($before === $html) {
            break;
        }
    }

    return trim($html);
}

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
                'key' => 'field_h_g1_group',
                'label' => '顾问 1 · Luná（The Healer）',
                'name' => 'allscented_home_g1',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_h_g1_icon',
                        'label' => '图标（图标名，默认 spa）',
                        'name' => 'icon',
                        'type' => 'text',
                        'default_value' => 'spa',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g1_avatar',
                        'label' => '头像图片（可选，上传后替代图标）',
                        'name' => 'avatar',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'medium',
                        'instructions' => '上传数字人头像图片；留空则显示默认图标',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g1_label',
                        'label' => '小标签',
                        'name' => 'label',
                        'type' => 'text',
                        'default_value' => 'AI SCENT THERAPIST · LUNÁ',
                        'wrapper' => array('width' => 100),
                    ),
                    array(
                        'key' => 'field_h_g1_name',
                        'label' => '名字',
                        'name' => 'name',
                        'type' => 'text',
                        'default_value' => 'The Healer',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g1_desc',
                        'label' => '描述',
                        'name' => 'desc',
                        'type' => 'textarea',
                        'default_value' => 'Tell me how you feel today. I listen, I understand — and I find a fragrance that speaks to your heart.',
                        'rows' => 3,
                        'new_lines' => 'br',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g1_tag1',
                        'label' => '标签 1',
                        'name' => 'tag1',
                        'type' => 'text',
                        'default_value' => 'EMOTIONAL',
                        'wrapper' => array('width' => 25),
                    ),
                    array(
                        'key' => 'field_h_g1_tag2',
                        'label' => '标签 2',
                        'name' => 'tag2',
                        'type' => 'text',
                        'default_value' => 'THERAPEUTIC',
                        'wrapper' => array('width' => 25),
                    ),
                    array(
                        'key' => 'field_h_g1_cta',
                        'label' => '按钮文字',
                        'name' => 'cta',
                        'type' => 'text',
                        'default_value' => 'Start consultation',
                        'wrapper' => array('width' => 50),
                    ),
                ),
            ),
            array(
                'key' => 'field_h_g2_group',
                'label' => '顾问 2 · Echo（The Mystic）',
                'name' => 'allscented_home_g2',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_h_g2_icon',
                        'label' => '图标（图标名，默认 auto_awesome）',
                        'name' => 'icon',
                        'type' => 'text',
                        'default_value' => 'auto_awesome',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g2_avatar',
                        'label' => '头像图片（可选，上传后替代图标）',
                        'name' => 'avatar',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'medium',
                        'instructions' => '上传数字人头像图片；留空则显示默认图标',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g2_label',
                        'label' => '小标签',
                        'name' => 'label',
                        'type' => 'text',
                        'default_value' => 'AI SCENT FORTUNE TELLER · ECHO',
                        'wrapper' => array('width' => 100),
                    ),
                    array(
                        'key' => 'field_h_g2_name',
                        'label' => '名字',
                        'name' => 'name',
                        'type' => 'text',
                        'default_value' => 'The Mystic',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g2_desc',
                        'label' => '描述',
                        'name' => 'desc',
                        'type' => 'textarea',
                        'default_value' => 'Curious what the universe has in store for you? Let the stars guide your scent — for fun, for hope, for destiny.',
                        'rows' => 3,
                        'new_lines' => 'br',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g2_tag1',
                        'label' => '标签 1',
                        'name' => 'tag1',
                        'type' => 'text',
                        'default_value' => 'DIVINATION',
                        'wrapper' => array('width' => 25),
                    ),
                    array(
                        'key' => 'field_h_g2_tag2',
                        'label' => '标签 2',
                        'name' => 'tag2',
                        'type' => 'text',
                        'default_value' => 'RITUAL',
                        'wrapper' => array('width' => 25),
                    ),
                    array(
                        'key' => 'field_h_g2_cta',
                        'label' => '按钮文字',
                        'name' => 'cta',
                        'type' => 'text',
                        'default_value' => 'Cast your fortune',
                        'wrapper' => array('width' => 50),
                    ),
                ),
            ),
            array(
                'key' => 'field_h_g3_group',
                'label' => '顾问 3 · Sage（The Strategist）',
                'name' => 'allscented_home_g3',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_h_g3_icon',
                        'label' => '图标（图标名，默认 business_center）',
                        'name' => 'icon',
                        'type' => 'text',
                        'default_value' => 'business_center',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g3_avatar',
                        'label' => '头像图片（可选，上传后替代图标）',
                        'name' => 'avatar',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'medium',
                        'instructions' => '上传数字人头像图片；留空则显示默认图标',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g3_label',
                        'label' => '小标签',
                        'name' => 'label',
                        'type' => 'text',
                        'default_value' => 'SCENT MEMORY CONSULTANT · SAGE',
                        'wrapper' => array('width' => 100),
                    ),
                    array(
                        'key' => 'field_h_g3_name',
                        'label' => '名字',
                        'name' => 'name',
                        'type' => 'text',
                        'default_value' => 'The Strategist',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g3_desc',
                        'label' => '描述',
                        'name' => 'desc',
                        'type' => 'textarea',
                        'default_value' => 'For hotels, boutiques, and brands. I design a scent strategy that becomes part of your identity and drives results.',
                        'rows' => 3,
                        'new_lines' => 'br',
                        'wrapper' => array('width' => 50),
                    ),
                    array(
                        'key' => 'field_h_g3_tag1',
                        'label' => '标签 1',
                        'name' => 'tag1',
                        'type' => 'text',
                        'default_value' => 'COMMERCIAL',
                        'wrapper' => array('width' => 25),
                    ),
                    array(
                        'key' => 'field_h_g3_tag2',
                        'label' => '标签 2',
                        'name' => 'tag2',
                        'type' => 'text',
                        'default_value' => 'BRANDING',
                        'wrapper' => array('width' => 25),
                    ),
                    array(
                        'key' => 'field_h_g3_cta',
                        'label' => '按钮文字',
                        'name' => 'cta',
                        'type' => 'text',
                        'default_value' => 'Request consultation',
                        'wrapper' => array('width' => 50),
                    ),
                ),
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
                    'param' => 'page_type', 'operator' => '==', 'value' => 'front_page',
                ),
            ),
            array(
                array(
                    'param' => 'page', 'operator' => '==', 'value' => 'home',
                ),
            ),
            array(
                array(
                    'param' => 'page', 'operator' => '==', 'value' => 'front-page',
                ),
            ),
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'front-page.php',
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
                'key' => 'field_t_p1_show',
                'label' => '产品 1 显示',
                'name' => 'allscented_atelier_p1_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p1_link',
                'label' => '产品 1 链接',
                'name' => 'allscented_atelier_p1_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
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
                'key' => 'field_t_p2_show',
                'label' => '产品 2 显示',
                'name' => 'allscented_atelier_p2_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p2_link',
                'label' => '产品 2 链接',
                'name' => 'allscented_atelier_p2_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
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
                'key' => 'field_t_p3_show',
                'label' => '产品 3 显示',
                'name' => 'allscented_atelier_p3_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p3_link',
                'label' => '产品 3 链接',
                'name' => 'allscented_atelier_p3_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
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
                'key' => 'field_t_p4_show',
                'label' => '产品 4 显示',
                'name' => 'allscented_atelier_p4_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p4_link',
                'label' => '产品 4 链接',
                'name' => 'allscented_atelier_p4_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
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
                'key' => 'field_t_p5_show',
                'label' => '产品 5 显示',
                'name' => 'allscented_atelier_p5_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p5_link',
                'label' => '产品 5 链接',
                'name' => 'allscented_atelier_p5_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
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
                'key' => 'field_t_p6_show',
                'label' => '产品 6 显示',
                'name' => 'allscented_atelier_p6_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p6_link',
                'label' => '产品 6 链接',
                'name' => 'allscented_atelier_p6_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'tab_产品_7-14',
                'label' => '产品 7-14',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_t_p7_img',
                'label' => '产品 7 图片',
                'name' => 'allscented_atelier_p7_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p7_name',
                'label' => '产品 7 名称',
                'name' => 'allscented_atelier_p7_name',
                'type' => 'text',
                'default_value' => 'Leopard Glass Candle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p7_sub',
                'label' => '产品 7 副标题',
                'name' => 'allscented_atelier_p7_sub',
                'type' => 'text',
                'default_value' => 'Home · Soy Candle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p7_price',
                'label' => '产品 7 价格',
                'name' => 'allscented_atelier_p7_price',
                'type' => 'text',
                'default_value' => '$55.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p7_cat',
                'label' => '产品 7 分类',
                'name' => 'allscented_atelier_p7_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p7_show',
                'label' => '产品 7 显示',
                'name' => 'allscented_atelier_p7_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p7_link',
                'label' => '产品 7 链接',
                'name' => 'allscented_atelier_p7_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p8_img',
                'label' => '产品 8 图片',
                'name' => 'allscented_atelier_p8_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p8_name',
                'label' => '产品 8 名称',
                'name' => 'allscented_atelier_p8_name',
                'type' => 'text',
                'default_value' => 'Leopard Diffuser Vessel',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p8_sub',
                'label' => '产品 8 副标题',
                'name' => 'allscented_atelier_p8_sub',
                'type' => 'text',
                'default_value' => 'Home · Reed Diffuser',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p8_price',
                'label' => '产品 8 价格',
                'name' => 'allscented_atelier_p8_price',
                'type' => 'text',
                'default_value' => '$45.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p8_cat',
                'label' => '产品 8 分类',
                'name' => 'allscented_atelier_p8_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p8_show',
                'label' => '产品 8 显示',
                'name' => 'allscented_atelier_p8_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p8_link',
                'label' => '产品 8 链接',
                'name' => 'allscented_atelier_p8_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p9_img',
                'label' => '产品 9 图片',
                'name' => 'allscented_atelier_p9_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p9_name',
                'label' => '产品 9 名称',
                'name' => 'allscented_atelier_p9_name',
                'type' => 'text',
                'default_value' => 'Steel Diffuser Bottle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p9_sub',
                'label' => '产品 9 副标题',
                'name' => 'allscented_atelier_p9_sub',
                'type' => 'text',
                'default_value' => 'Home · Diffuser Bottle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p9_price',
                'label' => '产品 9 价格',
                'name' => 'allscented_atelier_p9_price',
                'type' => 'text',
                'default_value' => '$35.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p9_cat',
                'label' => '产品 9 分类',
                'name' => 'allscented_atelier_p9_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p9_show',
                'label' => '产品 9 显示',
                'name' => 'allscented_atelier_p9_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p9_link',
                'label' => '产品 9 链接',
                'name' => 'allscented_atelier_p9_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p10_img',
                'label' => '产品 10 图片',
                'name' => 'allscented_atelier_p10_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p10_name',
                'label' => '产品 10 名称',
                'name' => 'allscented_atelier_p10_name',
                'type' => 'text',
                'default_value' => 'Dessert Candle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p10_sub',
                'label' => '产品 10 副标题',
                'name' => 'allscented_atelier_p10_sub',
                'type' => 'text',
                'default_value' => 'Home · Scented Candle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p10_price',
                'label' => '产品 10 价格',
                'name' => 'allscented_atelier_p10_price',
                'type' => 'text',
                'default_value' => '$37.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p10_cat',
                'label' => '产品 10 分类',
                'name' => 'allscented_atelier_p10_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p10_show',
                'label' => '产品 10 显示',
                'name' => 'allscented_atelier_p10_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p10_link',
                'label' => '产品 10 链接',
                'name' => 'allscented_atelier_p10_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p11_img',
                'label' => '产品 11 图片',
                'name' => 'allscented_atelier_p11_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p11_name',
                'label' => '产品 11 名称',
                'name' => 'allscented_atelier_p11_name',
                'type' => 'text',
                'default_value' => 'Cinnamon & Brandy Refill',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p11_sub',
                'label' => '产品 11 副标题',
                'name' => 'allscented_atelier_p11_sub',
                'type' => 'text',
                'default_value' => 'Commercial · 300ml',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p11_price',
                'label' => '产品 11 价格',
                'name' => 'allscented_atelier_p11_price',
                'type' => 'text',
                'default_value' => '$59.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p11_cat',
                'label' => '产品 11 分类',
                'name' => 'allscented_atelier_p11_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'commercial',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p11_show',
                'label' => '产品 11 显示',
                'name' => 'allscented_atelier_p11_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p11_link',
                'label' => '产品 11 链接',
                'name' => 'allscented_atelier_p11_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p12_img',
                'label' => '产品 12 图片',
                'name' => 'allscented_atelier_p12_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p12_name',
                'label' => '产品 12 名称',
                'name' => 'allscented_atelier_p12_name',
                'type' => 'text',
                'default_value' => 'Honey & Currant Refill',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p12_sub',
                'label' => '产品 12 副标题',
                'name' => 'allscented_atelier_p12_sub',
                'type' => 'text',
                'default_value' => 'Commercial · 300ml',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p12_price',
                'label' => '产品 12 价格',
                'name' => 'allscented_atelier_p12_price',
                'type' => 'text',
                'default_value' => '$59.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p12_cat',
                'label' => '产品 12 分类',
                'name' => 'allscented_atelier_p12_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'commercial',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p12_show',
                'label' => '产品 12 显示',
                'name' => 'allscented_atelier_p12_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p12_link',
                'label' => '产品 12 链接',
                'name' => 'allscented_atelier_p12_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p13_img',
                'label' => '产品 13 图片',
                'name' => 'allscented_atelier_p13_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p13_name',
                'label' => '产品 13 名称',
                'name' => 'allscented_atelier_p13_name',
                'type' => 'text',
                'default_value' => 'Nutmeg & Freesia Refill',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p13_sub',
                'label' => '产品 13 副标题',
                'name' => 'allscented_atelier_p13_sub',
                'type' => 'text',
                'default_value' => 'Commercial · 300ml',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p13_price',
                'label' => '产品 13 价格',
                'name' => 'allscented_atelier_p13_price',
                'type' => 'text',
                'default_value' => '$59.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p13_cat',
                'label' => '产品 13 分类',
                'name' => 'allscented_atelier_p13_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'commercial',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p13_show',
                'label' => '产品 13 显示',
                'name' => 'allscented_atelier_p13_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p13_link',
                'label' => '产品 13 链接',
                'name' => 'allscented_atelier_p13_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p14_img',
                'label' => '产品 14 图片',
                'name' => 'allscented_atelier_p14_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p14_name',
                'label' => '产品 14 名称',
                'name' => 'allscented_atelier_p14_name',
                'type' => 'text',
                'default_value' => 'Extra Large Reed Diffuser',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p14_sub',
                'label' => '产品 14 副标题',
                'name' => 'allscented_atelier_p14_sub',
                'type' => 'text',
                'default_value' => 'Commercial · 2800ml',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p14_price',
                'label' => '产品 14 价格',
                'name' => 'allscented_atelier_p14_price',
                'type' => 'text',
                'default_value' => '$399.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p14_cat',
                'label' => '产品 14 分类',
                'name' => 'allscented_atelier_p14_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'commercial',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p14_show',
                'label' => '产品 14 显示',
                'name' => 'allscented_atelier_p14_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p14_link',
                'label' => '产品 14 链接',
                'name' => 'allscented_atelier_p14_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'tab_产品_15-23',
                'label' => '产品 15-23',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_t_p15_img',
                'label' => '产品 15 图片',
                'name' => 'allscented_atelier_p15_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p15_name',
                'label' => '产品 15 名称',
                'name' => 'allscented_atelier_p15_name',
                'type' => 'text',
                'default_value' => '4 Pack Donut Candle Set',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p15_sub',
                'label' => '产品 15 副标题',
                'name' => 'allscented_atelier_p15_sub',
                'type' => 'text',
                'default_value' => 'Home · Scented Candle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p15_price',
                'label' => '产品 15 价格',
                'name' => 'allscented_atelier_p15_price',
                'type' => 'text',
                'default_value' => '$37.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p15_cat',
                'label' => '产品 15 分类',
                'name' => 'allscented_atelier_p15_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p15_show',
                'label' => '产品 15 显示',
                'name' => 'allscented_atelier_p15_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p15_link',
                'label' => '产品 15 链接',
                'name' => 'allscented_atelier_p15_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p16_img',
                'label' => '产品 16 图片',
                'name' => 'allscented_atelier_p16_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p16_name',
                'label' => '产品 16 名称',
                'name' => 'allscented_atelier_p16_name',
                'type' => 'text',
                'default_value' => 'Puppy Salon Scented Tablet Set',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p16_sub',
                'label' => '产品 16 副标题',
                'name' => 'allscented_atelier_p16_sub',
                'type' => 'text',
                'default_value' => 'Personal · Scented Tablet',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p16_price',
                'label' => '产品 16 价格',
                'name' => 'allscented_atelier_p16_price',
                'type' => 'text',
                'default_value' => '$18.50',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p16_cat',
                'label' => '产品 16 分类',
                'name' => 'allscented_atelier_p16_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p16_show',
                'label' => '产品 16 显示',
                'name' => 'allscented_atelier_p16_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p16_link',
                'label' => '产品 16 链接',
                'name' => 'allscented_atelier_p16_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p17_img',
                'label' => '产品 17 图片',
                'name' => 'allscented_atelier_p17_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p17_name',
                'label' => '产品 17 名称',
                'name' => 'allscented_atelier_p17_name',
                'type' => 'text',
                'default_value' => 'Puppy Salon Reed Diffuser — Elephants',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p17_sub',
                'label' => '产品 17 副标题',
                'name' => 'allscented_atelier_p17_sub',
                'type' => 'text',
                'default_value' => 'Home · Reed Diffuser',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p17_price',
                'label' => '产品 17 价格',
                'name' => 'allscented_atelier_p17_price',
                'type' => 'text',
                'default_value' => '$48.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p17_cat',
                'label' => '产品 17 分类',
                'name' => 'allscented_atelier_p17_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p17_show',
                'label' => '产品 17 显示',
                'name' => 'allscented_atelier_p17_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p17_link',
                'label' => '产品 17 链接',
                'name' => 'allscented_atelier_p17_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p18_img',
                'label' => '产品 18 图片',
                'name' => 'allscented_atelier_p18_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p18_name',
                'label' => '产品 18 名称',
                'name' => 'allscented_atelier_p18_name',
                'type' => 'text',
                'default_value' => 'Puppy Salon Reed Diffuser — Cat',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p18_sub',
                'label' => '产品 18 副标题',
                'name' => 'allscented_atelier_p18_sub',
                'type' => 'text',
                'default_value' => 'Home · Reed Diffuser',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p18_price',
                'label' => '产品 18 价格',
                'name' => 'allscented_atelier_p18_price',
                'type' => 'text',
                'default_value' => '$48.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p18_cat',
                'label' => '产品 18 分类',
                'name' => 'allscented_atelier_p18_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p18_show',
                'label' => '产品 18 显示',
                'name' => 'allscented_atelier_p18_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p18_link',
                'label' => '产品 18 链接',
                'name' => 'allscented_atelier_p18_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p19_img',
                'label' => '产品 19 图片',
                'name' => 'allscented_atelier_p19_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p19_name',
                'label' => '产品 19 名称',
                'name' => 'allscented_atelier_p19_name',
                'type' => 'text',
                'default_value' => 'Puppy Salon Reed Diffuser — 52 Hertz',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p19_sub',
                'label' => '产品 19 副标题',
                'name' => 'allscented_atelier_p19_sub',
                'type' => 'text',
                'default_value' => 'Home · Reed Diffuser',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p19_price',
                'label' => '产品 19 价格',
                'name' => 'allscented_atelier_p19_price',
                'type' => 'text',
                'default_value' => '$48.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p19_cat',
                'label' => '产品 19 分类',
                'name' => 'allscented_atelier_p19_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'home',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p19_show',
                'label' => '产品 19 显示',
                'name' => 'allscented_atelier_p19_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p19_link',
                'label' => '产品 19 链接',
                'name' => 'allscented_atelier_p19_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p20_img',
                'label' => '产品 20 图片',
                'name' => 'allscented_atelier_p20_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p20_name',
                'label' => '产品 20 名称',
                'name' => 'allscented_atelier_p20_name',
                'type' => 'text',
                'default_value' => 'Puppy Salon Candle — I\'m Your Eyes',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p20_sub',
                'label' => '产品 20 副标题',
                'name' => 'allscented_atelier_p20_sub',
                'type' => 'text',
                'default_value' => 'Personal · Scented Candle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p20_price',
                'label' => '产品 20 价格',
                'name' => 'allscented_atelier_p20_price',
                'type' => 'text',
                'default_value' => '$59.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p20_cat',
                'label' => '产品 20 分类',
                'name' => 'allscented_atelier_p20_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p20_show',
                'label' => '产品 20 显示',
                'name' => 'allscented_atelier_p20_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p20_link',
                'label' => '产品 20 链接',
                'name' => 'allscented_atelier_p20_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p21_img',
                'label' => '产品 21 图片',
                'name' => 'allscented_atelier_p21_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p21_name',
                'label' => '产品 21 名称',
                'name' => 'allscented_atelier_p21_name',
                'type' => 'text',
                'default_value' => 'Puppy Salon Candle — Whale Song',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p21_sub',
                'label' => '产品 21 副标题',
                'name' => 'allscented_atelier_p21_sub',
                'type' => 'text',
                'default_value' => 'Personal · Scented Candle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p21_price',
                'label' => '产品 21 价格',
                'name' => 'allscented_atelier_p21_price',
                'type' => 'text',
                'default_value' => '$49.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p21_cat',
                'label' => '产品 21 分类',
                'name' => 'allscented_atelier_p21_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p21_show',
                'label' => '产品 21 显示',
                'name' => 'allscented_atelier_p21_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p21_link',
                'label' => '产品 21 链接',
                'name' => 'allscented_atelier_p21_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p22_img',
                'label' => '产品 22 图片',
                'name' => 'allscented_atelier_p22_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p22_name',
                'label' => '产品 22 名称',
                'name' => 'allscented_atelier_p22_name',
                'type' => 'text',
                'default_value' => 'Puppy Salon Candle — Cat Series',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p22_sub',
                'label' => '产品 22 副标题',
                'name' => 'allscented_atelier_p22_sub',
                'type' => 'text',
                'default_value' => 'Personal · Scented Candle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p22_price',
                'label' => '产品 22 价格',
                'name' => 'allscented_atelier_p22_price',
                'type' => 'text',
                'default_value' => '$49.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p22_cat',
                'label' => '产品 22 分类',
                'name' => 'allscented_atelier_p22_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p22_show',
                'label' => '产品 22 显示',
                'name' => 'allscented_atelier_p22_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p22_link',
                'label' => '产品 22 链接',
                'name' => 'allscented_atelier_p22_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
            ),

            array(
                'key' => 'field_t_p23_img',
                'label' => '产品 23 图片',
                'name' => 'allscented_atelier_p23_img',
                'type' => 'image',
                'return_format' => 'url',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p23_name',
                'label' => '产品 23 名称',
                'name' => 'allscented_atelier_p23_name',
                'type' => 'text',
                'default_value' => 'Puppy Salon Candle — Elephant',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p23_sub',
                'label' => '产品 23 副标题',
                'name' => 'allscented_atelier_p23_sub',
                'type' => 'text',
                'default_value' => 'Personal · Scented Candle',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p23_price',
                'label' => '产品 23 价格',
                'name' => 'allscented_atelier_p23_price',
                'type' => 'text',
                'default_value' => '$49.00',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p23_cat',
                'label' => '产品 23 分类',
                'name' => 'allscented_atelier_p23_cat',
                'type' => 'select',
                'choices' => array('personal' => 'personal', 'home' => 'home', 'commercial' => 'commercial'),
                'default_value' => 'personal',
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p23_show',
                'label' => '产品 23 显示',
                'name' => 'allscented_atelier_p23_show',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array('width' => 25),
            ),
            array(
                'key' => 'field_t_p23_link',
                'label' => '产品 23 链接',
                'name' => 'allscented_atelier_p23_link',
                'type' => 'url',
                'instructions' => '留空则不显示链接；填写 WooCommerce 产品 URL 后卡片可点击跳转',
                'wrapper' => array('width' => 50),
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

if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group(array(
        'key' => 'group_allscented_product',
        'title' => 'Product Page Details',
        'fields' => array(
            array(
                'key' => 'tab_product_media',
                'label' => 'Media & Chips',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_product_video_url',
                'label' => 'Product Video URL',
                'name' => 'product_video_url',
                'type' => 'url',
                'instructions' => 'Optional MP4/WebM URL. When filled, the main media panel shows a video with the featured image as poster; leave empty to use the WooCommerce featured image.',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_video_label',
                'label' => 'Video Preview Label',
                'name' => 'product_video_label',
                'type' => 'text',
                'default_value' => 'Cinematic Preview',
                'instructions' => 'Visible label shown over the main media when a product video is provided.',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_chip_for',
                'label' => 'Chip: For',
                'name' => 'product_chip_for',
                'type' => 'text',
                'instructions' => 'Example: Personal. Rendered as "For Personal" when filled.',
                'wrapper' => array('width' => 33),
            ),
            array(
                'key' => 'field_product_chip_mood',
                'label' => 'Chip: Mood',
                'name' => 'product_chip_mood',
                'type' => 'text',
                'instructions' => 'Example: Serene. Rendered as "Mood: Serene".',
                'wrapper' => array('width' => 33),
            ),
            array(
                'key' => 'field_product_chip_scene',
                'label' => 'Chip: Scene',
                'name' => 'product_chip_scene',
                'type' => 'text',
                'instructions' => 'Example: Digital Sunrise. Rendered as "Scene: Digital Sunrise".',
                'wrapper' => array('width' => 34),
            ),
            array(
                'key' => 'tab_product_journey',
                'label' => 'The Olfactory Journey',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_product_journey_title',
                'label' => 'Section Title',
                'name' => 'product_journey_title',
                'type' => 'text',
                'default_value' => 'The Olfactory Journey',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_journey_intro',
                'label' => 'Section Intro',
                'name' => 'product_journey_intro',
                'type' => 'textarea',
                'default_value' => 'A technical synthesis of atmospheric elements and engineered botanical compounds, unfolding in three precise acts.',
                'rows' => 3,
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_journey_stage_1',
                'label' => 'Stage 1 — Label',
                'name' => 'product_journey_stage_1',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_journey_notes_1',
                'label' => 'Stage 1 — Notes',
                'name' => 'product_journey_notes_1',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'field_product_journey_icon_1',
                'label' => 'Stage 1 — Icon',
                'name' => 'product_journey_icon_1',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_journey_label_1',
                'label' => 'Stage 1 — Notes Label',
                'name' => 'product_journey_label_1',
                'type' => 'text',
                'instructions' => 'Leave stage + notes empty to hide this card.',
            ),
            array(
                'key' => 'field_product_journey_stage_2',
                'label' => 'Stage 2 — Label',
                'name' => 'product_journey_stage_2',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_journey_notes_2',
                'label' => 'Stage 2 — Notes',
                'name' => 'product_journey_notes_2',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'field_product_journey_icon_2',
                'label' => 'Stage 2 — Icon',
                'name' => 'product_journey_icon_2',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_journey_label_2',
                'label' => 'Stage 2 — Notes Label',
                'name' => 'product_journey_label_2',
                'type' => 'text',
                'instructions' => 'Leave stage + notes empty to hide this card.',
            ),
            array(
                'key' => 'field_product_journey_stage_3',
                'label' => 'Stage 3 — Label',
                'name' => 'product_journey_stage_3',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_journey_notes_3',
                'label' => 'Stage 3 — Notes',
                'name' => 'product_journey_notes_3',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'field_product_journey_icon_3',
                'label' => 'Stage 3 — Icon',
                'name' => 'product_journey_icon_3',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_journey_label_3',
                'label' => 'Stage 3 — Notes Label',
                'name' => 'product_journey_label_3',
                'type' => 'text',
                'instructions' => 'Leave stage + notes empty to hide this card.',
            ),
            array(
                'key' => 'tab_product_scenarios',
                'label' => 'Atmospheric Resonance',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_product_scenarios_title',
                'label' => 'Section Title',
                'name' => 'product_scenarios_title',
                'type' => 'text',
                'default_value' => 'Atmospheric Resonance',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_scenarios_intro',
                'label' => 'Section Intro',
                'name' => 'product_scenarios_intro',
                'type' => 'textarea',
                'default_value' => 'Curated environments where the fragrance achieves maximum sensory impact.',
                'rows' => 3,
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_scenarios_image_1',
                'label' => 'Scenario 1 — Image',
                'name' => 'product_scenarios_image_1',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_product_scenarios_title_1',
                'label' => 'Scenario 1 — Title',
                'name' => 'product_scenarios_title_1',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_scenarios_desc_1',
                'label' => 'Scenario 1 — Description',
                'name' => 'product_scenarios_desc_1',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'field_product_scenarios_image_2',
                'label' => 'Scenario 2 — Image',
                'name' => 'product_scenarios_image_2',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_product_scenarios_title_2',
                'label' => 'Scenario 2 — Title',
                'name' => 'product_scenarios_title_2',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_scenarios_desc_2',
                'label' => 'Scenario 2 — Description',
                'name' => 'product_scenarios_desc_2',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'tab_product_dna',
                'label' => 'Product DNA',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_product_dna_title',
                'label' => 'Section Title',
                'name' => 'product_dna_title',
                'type' => 'text',
                'default_value' => 'Product DNA',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_dna_intro',
                'label' => 'Section Intro',
                'name' => 'product_dna_intro',
                'type' => 'textarea',
                'default_value' => 'What makes this formulation distinctive.',
                'rows' => 3,
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_dna_icon_1',
                'label' => 'DNA 1 — Icon',
                'name' => 'product_dna_icon_1',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_dna_title_1',
                'label' => 'DNA 1 — Title',
                'name' => 'product_dna_title_1',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_dna_desc_1',
                'label' => 'DNA 1 — Description',
                'name' => 'product_dna_desc_1',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_product_dna_icon_2',
                'label' => 'DNA 2 — Icon',
                'name' => 'product_dna_icon_2',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_dna_title_2',
                'label' => 'DNA 2 — Title',
                'name' => 'product_dna_title_2',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_dna_desc_2',
                'label' => 'DNA 2 — Description',
                'name' => 'product_dna_desc_2',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_product_dna_icon_3',
                'label' => 'DNA 3 — Icon',
                'name' => 'product_dna_icon_3',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_dna_title_3',
                'label' => 'DNA 3 — Title',
                'name' => 'product_dna_title_3',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_dna_desc_3',
                'label' => 'DNA 3 — Description',
                'name' => 'product_dna_desc_3',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'tab_product_specs',
                'label' => 'Technical Specs',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_product_specs_title',
                'label' => 'Section Title',
                'name' => 'product_specs_title',
                'type' => 'text',
                'default_value' => 'Technical Specs',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_specs_label_1',
                'label' => 'Spec 1 — Label',
                'name' => 'product_specs_label_1',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_specs_value_1',
                'label' => 'Spec 1 — Value',
                'name' => 'product_specs_value_1',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_specs_label_2',
                'label' => 'Spec 2 — Label',
                'name' => 'product_specs_label_2',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_specs_value_2',
                'label' => 'Spec 2 — Value',
                'name' => 'product_specs_value_2',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_specs_label_3',
                'label' => 'Spec 3 — Label',
                'name' => 'product_specs_label_3',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_specs_value_3',
                'label' => 'Spec 3 — Value',
                'name' => 'product_specs_value_3',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_specs_label_4',
                'label' => 'Spec 4 — Label',
                'name' => 'product_specs_label_4',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_specs_value_4',
                'label' => 'Spec 4 — Value',
                'name' => 'product_specs_value_4',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_specs_label_5',
                'label' => 'Spec 5 — Label',
                'name' => 'product_specs_label_5',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_specs_value_5',
                'label' => 'Spec 5 — Value',
                'name' => 'product_specs_value_5',
                'type' => 'text',
            ),
            array(
                'key' => 'tab_product_stitch',
                'label' => 'Stitch 版专属',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_product_use_stitch',
                'label' => '详情页使用 Stitch 模板',
                'name' => 'product_use_stitch',
                'type' => 'true_false',
                'instructions' => '开启后，该商品自己的详情页 URL 将以 Stitch 设计渲染（不再使用默认单商品模板）',
                'default_value' => 0,
                'ui' => 1,
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_size_note',
                'label' => 'Size Note',
                'name' => 'product_size_note',
                'type' => 'text',
                'instructions' => 'Optional text shown beside the price, e.g. / 50ml Extrait de Parfum.',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_philosophy_title',
                'label' => 'Brand Philosophy Title',
                'name' => 'product_philosophy_title',
                'type' => 'text',
                'default_value' => 'Brand Philosophy',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_product_philosophy_text',
                'label' => 'Brand Philosophy Text',
                'name' => 'product_philosophy_text',
                'type' => 'textarea',
                'rows' => 4,
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_soul_title',
                'label' => 'The Soul Title',
                'name' => 'product_soul_title',
                'type' => 'text',
                'instructions' => 'Leave empty to use "The Soul of [product name]".',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_product_soul_text',
                'label' => 'The Soul Text',
                'name' => 'product_soul_text',
                'type' => 'textarea',
                'rows' => 4,
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_specs_footer',
                'label' => 'Technical Specs Footer',
                'name' => 'product_specs_footer',
                'type' => 'text',
                'default_value' => '',
                'instructions' => 'Optional caption below Technical Specs, e.g. Matched via AuraNet. Hidden when empty.',
                'wrapper' => array('width' => 100),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 5,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_allscented_contact',
        'title' => 'Contact Page',
        'fields' => array(
            array(
                'key' => 'field_contact_label',
                'label' => 'Hero Label',
                'name' => 'allscented_contact_label',
                'type' => 'text',
                'default_value' => 'GET IN TOUCH',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_contact_heading',
                'label' => 'Heading',
                'name' => 'allscented_contact_heading',
                'type' => 'text',
                'default_value' => 'Contact',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_contact_intro',
                'label' => 'Intro',
                'name' => 'allscented_contact_intro',
                'type' => 'textarea',
                'default_value' => 'Questions about our fragrances, orders, or collaborations — we\'d love to hear from you.',
                'rows' => 3,
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_contact_info_label',
                'label' => 'Contact Details Label',
                'name' => 'allscented_contact_info_label',
                'type' => 'text',
                'default_value' => 'CONTACT DETAILS',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_contact_email',
                'label' => 'Email',
                'name' => 'allscented_contact_email',
                'type' => 'email',
                'default_value' => 'info@allscented.com',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_contact_phone',
                'label' => 'Phone',
                'name' => 'allscented_contact_phone',
                'type' => 'text',
                'default_value' => '+852 46090901',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_contact_address',
                'label' => 'Address',
                'name' => 'allscented_contact_address',
                'type' => 'textarea',
                'rows' => 3,
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_contact_image',
                'label' => 'Contact Image',
                'name' => 'allscented_contact_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_contact_form_label',
                'label' => 'Form Heading',
                'name' => 'allscented_contact_form_label',
                'type' => 'text',
                'default_value' => 'SEND A MESSAGE',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_contact_form_intro',
                'label' => 'Form Intro',
                'name' => 'allscented_contact_form_intro',
                'type' => 'textarea',
                'default_value' => '',
                'rows' => 2,
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_contact_name_label',
                'label' => 'Name Field Label',
                'name' => 'allscented_contact_name_label',
                'type' => 'text',
                'default_value' => 'Name',
                'wrapper' => array('width' => 33),
            ),
            array(
                'key' => 'field_contact_email_label',
                'label' => 'Email Field Label',
                'name' => 'allscented_contact_email_label',
                'type' => 'text',
                'default_value' => 'Email',
                'wrapper' => array('width' => 34),
            ),
            array(
                'key' => 'field_contact_message_label',
                'label' => 'Message Field Label',
                'name' => 'allscented_contact_message_label',
                'type' => 'text',
                'default_value' => 'Message',
                'wrapper' => array('width' => 33),
            ),
            array(
                'key' => 'field_contact_submit_label',
                'label' => 'Submit Button Label',
                'name' => 'allscented_contact_submit_label',
                'type' => 'text',
                'default_value' => 'Send Message',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_contact_success_message',
                'label' => 'Success Message',
                'name' => 'allscented_contact_success_message',
                'type' => 'text',
                'default_value' => 'Thank you. Your message has been sent.',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_contact_error_message',
                'label' => 'Error Message',
                'name' => 'allscented_contact_error_message',
                'type' => 'text',
                'default_value' => 'Sorry, your message could not be sent. Please try again.',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_contact_facebook',
                'label' => 'Facebook URL',
                'name' => 'allscented_contact_facebook_url',
                'type' => 'url',
                'wrapper' => array('width' => 50),
            ),
            array(
                'key' => 'field_contact_instagram',
                'label' => 'Instagram URL',
                'name' => 'allscented_contact_instagram_url',
                'type' => 'url',
                'wrapper' => array('width' => 50),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-contact.php',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'contact',
                ),
            ),
        ),
        'menu_order' => 5,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

}

// ============================================
// Contact form handler
// ============================================
add_action('admin_post_allscented_contact', 'allscented_handle_contact_form');
add_action('admin_post_nopriv_allscented_contact', 'allscented_handle_contact_form');
function allscented_handle_contact_form() {
    if (!isset($_POST['allscented_contact_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['allscented_contact_nonce'])), 'allscented_contact_action')) {
        allscented_contact_redirect('failed');
    }

    $honeypot = isset($_POST['allscented_website']) ? sanitize_text_field(wp_unslash($_POST['allscented_website'])) : '';
    if ($honeypot !== '') {
        allscented_contact_redirect('success');
    }

    $name    = isset($_POST['allscented_name']) ? sanitize_text_field(wp_unslash($_POST['allscented_name'])) : '';
    $email   = isset($_POST['allscented_email']) ? sanitize_email(wp_unslash($_POST['allscented_email'])) : '';
    $message = isset($_POST['allscented_message']) ? sanitize_textarea_field(wp_unslash($_POST['allscented_message'])) : '';

    if ($name === '' || $email === '' || $message === '' || !is_email($email)) {
        allscented_contact_redirect('failed');
    }

    $to = 'info@allscented.com';
    $subject = '[AllScented 官网] 新表单提交 - ' . $name;
    $body = "Name: " . $name . "\nEmail: " . $email . "\n\nMessage:\n" . $message;
    $headers = array(
        'Reply-To: ' . $name . ' <' . $email . '>',
        'Content-Type: text/plain; charset=UTF-8',
    );

    $GLOBALS['allscented_contact_mail_context'] = 'wp_mail failed for info@allscented.com';
    $sent = wp_mail($to, $subject, $body, $headers);
    unset($GLOBALS['allscented_contact_mail_context']);
    allscented_contact_redirect($sent ? 'success' : 'failed');
}

add_action('wp_mail_failed', 'allscented_log_contact_mail_failure');
function allscented_log_contact_mail_failure($wp_error) {
    if (empty($GLOBALS['allscented_contact_mail_context'])) {
        return;
    }

    error_log('[AllScented Contact Form] ' . $GLOBALS['allscented_contact_mail_context'] . ': ' . $wp_error->get_error_message());
}

function allscented_contact_redirect($status) {
    $url = wp_get_referer();
    if (!$url) {
        $url = home_url('/contact/');
    }
    wp_safe_redirect(add_query_arg('contact_status', $status, $url));
    exit;
}


// ============================================
// Page Templates Registration
// ============================================
function allscented_page_templates($templates) {
    $templates['page-the-atelier.php'] = 'The Atelier';
    $templates['page-ai-synthesis.php'] = 'AI Synthesis';
    $templates['page-archive.php'] = 'Archive';
    $templates['page-contact.php'] = 'Contact';
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
    if (is_page_template('page-contact.php')) {
        $new = locate_template(array('page-contact.php'));
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
}

// ============================================
// Journal Cover AJAX Editor
// ============================================
add_action('wp_ajax_allscented_update_cover', 'allscented_ajax_update_cover');
function allscented_ajax_update_cover() {
    check_ajax_referer('allscented_cover_nonce', 'nonce');

    $post_id       = isset($_POST['post_id'])       ? intval($_POST['post_id'])       : 0;
    $attachment_id = isset($_POST['attachment_id']) ? intval($_POST['attachment_id']) : 0;

    if (!$post_id || !$attachment_id) {
        wp_send_json_error(__('Missing post or image ID.', 'allscented'));
    }

    if (!current_user_can('edit_post', $post_id)) {
        wp_send_json_error(__('Permission denied.', 'allscented'));
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'post') {
        wp_send_json_error(__('Invalid post.', 'allscented'));
    }

    $attachment = get_post($attachment_id);
    if (!$attachment || $attachment->post_type !== 'attachment') {
        wp_send_json_error(__('Invalid attachment.', 'allscented'));
    }

    $result = set_post_thumbnail($post_id, $attachment_id);
    if (!$result) {
        wp_send_json_error(__('Failed to update cover.', 'allscented'));
    }

    $url = wp_get_attachment_image_url($attachment_id, 'large');
    wp_send_json_success(array(
        'url'     => $url,
        'post_id' => $post_id,
    ));
}


if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group(array(
        'key' => 'group_allscented_product_related',
        'title' => 'Product Related Section',
        'fields' => array(
            array(
                'key' => 'field_product_related_title',
                'label' => 'Section Title',
                'name' => 'product_related_title',
                'type' => 'text',
                'default_value' => 'You May Also Like',
                'instructions' => 'Heading shown above WooCommerce related products. The whole section stays hidden when no related products exist.',
                'wrapper' => array('width' => 100),
            ),
            array(
                'key' => 'field_product_related_intro',
                'label' => 'Section Intro',
                'name' => 'product_related_intro',
                'type' => 'textarea',
                'default_value' => '',
                'rows' => 3,
                'wrapper' => array('width' => 100),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 6,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}


if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group(array(
        'key' => 'group_allscented_stitch_page',
        'title' => 'Stitch Product Page',
        'fields' => array(
            array(
                'key' => 'field_stitch_product',
                'label' => 'Product',
                'name' => 'stitch_product',
                'type' => 'post_object',
                'post_type' => array('product'),
                'return_format' => 'id',
                'allow_null' => 1,
                'instructions' => 'Select the product this page displays, or append ?product=ID to the URL.',
                'wrapper' => array('width' => 100),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
        'menu_order' => 7,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}

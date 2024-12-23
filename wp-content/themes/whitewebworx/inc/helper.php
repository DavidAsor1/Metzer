<?php

function get_setting_field($settingName)
{
    $cache_key = 'website_setting_key';
    $cached_value = get_transient($cache_key);

    if ($cached_value !== false) {
        return $cached_value[$settingName];
    }

    $settings = get_field('website_settings', 'option');
    $value = $settings[$settingName];

    set_transient($cache_key, $settings, DAY_IN_SECONDS);

    return $value;
}

function load_image($input, $class = null, $lazy = true, $alt = null, $title = null)
{
    $image = '';

    // If input is array, use direct values
    if (is_array($input)) {
        $img_src = $input['url'] ?? '';
        $width = $input['width'] ?? '';
        $alt = $alt ?? $input['alt'] ?? '';
        $title = $title ?? $input['title'] ?? '';

        // Handle sizes differently for SVG
        if (isset($input['mime_type']) && $input['mime_type'] === 'image/svg+xml') {
            $image = '<img class="' . $class . '" 
                src="' . esc_url($img_src) . '"
                alt="' . esc_attr($alt) . '"
                title="' . esc_attr($title) . '"
                ' . ($lazy ? 'loading="lazy"' : 'rel="prefetch"') . '>';
        } else {
            // For regular images, include srcset and sizes if available
            $srcset = '';
            $sizes = '';

            if (!empty($input['sizes'])) {
                $sizesArr = [];
                foreach ($input['sizes'] as $size => $url) {
                    if (!str_ends_with($size, '-width') && !str_ends_with($size, '-height')) {
                        $width = $input['sizes'][$size . '-width'] ?? '';
                        if ($width) {
                            $sizesArr[] = esc_url($url) . ' ' . $width . 'w';
                        }
                    }
                }
                $srcset = implode(', ', $sizesArr);
            }

            $image = '<img class="' . $class . '" 
                src="' . esc_url($img_src) . '"
                ' . ($width ? 'width="' . esc_attr($width) . '"' : '') . '
                alt="' . esc_attr($alt) . '"
                title="' . esc_attr($title) . '"
                ' . ($srcset ? 'srcset="' . esc_attr($srcset) . '"' : '') . '
                ' . ($sizes ? 'sizes="' . esc_attr($sizes) . '"' : '') . '
                ' . ($lazy ? 'loading="lazy"' : 'rel="prefetch"') . '>';
        }
    }
    // If input is ID, use original WordPress functions
    elseif ($input != null) {
        $alt = $alt ?? get_post_meta($input, '_wp_attachment_image_alt', true);
        $metadata = get_post_meta($input, '_wp_attachment_metadata', true);
        $width = $metadata['width'] ?? '';
        $img_src = wp_get_attachment_image_url($input, 'full');
        $img_srcset = wp_get_attachment_image_srcset($input, 'full');
        $img_sizes = wp_get_attachment_image_sizes($input, 'full');

        $image = '<img class="' . $class . '" 
            src="' . esc_url($img_src) . '"
            ' . ($width ? 'width="' . esc_attr($width) . '"' : '') . '
            alt="' . esc_attr($alt) . '"
            title="' . esc_attr($title) . '"
            ' . ($img_srcset ? 'srcset="' . esc_attr($img_srcset) . '"' : '') . '
            ' . ($img_sizes ? 'sizes="' . esc_attr($img_sizes) . '"' : '') . '
            ' . ($lazy ? 'loading="lazy"' : 'rel="prefetch"') . '>';
    }

    return $image ?: false;
}

function metzer_search_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'placeholder' => 'Search...',
        'submit_text' => 'Go',
        'class' => 'search-form'
    ), $atts);

    $icon_src = get_theme_file_uri('/assets/images/search-icon.svg');
    $icon_alt = 'Search Icon';

    $form_html = '<img src="' . esc_url($icon_src) . '" alt="' . esc_attr($icon_alt) . '" class="search-icon">';
    $form_html .= '<form class="position-absolute d-none align-items-center shadow bg-white gap-3 ' . esc_attr($atts['class']) . '" action="' . esc_url(home_url('/')) . '" method="get">';
    $form_html .= '<input class="search-input-icon" type="search" name="s" placeholder="' . esc_attr($atts['placeholder']) . '" value="' . get_search_query() . '" style="background-image: url(' . esc_url($icon_src) . ');">';
    $form_html .= '<button class="btn btn-primary" type="submit">' . esc_html($atts['submit_text']) . '</button>';
    $form_html .= '<div class="close-search pe-2"><img src="' . esc_url(get_theme_file_uri('/assets/images/close-x-icon.svg')) . '" alt="' . esc_attr($icon_alt) . '" class="close-icon"></div>';
    $form_html .= '</form>';

    return $form_html;
}
add_shortcode('metzer_search', 'metzer_search_shortcode');

function get_video_type($url)
{
    if (strpos($url, 'vimeo.com') !== false) {
        return 'vimeo';
    }

    $video_type = 'video/mp4';
    $video_extension = pathinfo($url, PATHINFO_EXTENSION);

    switch ($video_extension) {
        case 'mp4':
            $video_type = 'video/mp4';
            break;
        case 'webm':
            $video_type = 'video/webm';
            break;
        case 'ogg':
            $video_type = 'video/ogg';
            break;
        default:
            break;
    }

    return $video_type;
}

function get_owl_navigation_arrows($name)
{
    ob_start();
?>
    <div class="custom-nav custom-nav-<?= $name ?> d-flex gap-2 justify-content-end">
        <div class="custom-prev-<?= $name ?>">
            <div class="rounded-circle">
                <i class="fa fa-regular fa-chevron-left"></i>
            </div>
        </div>
        <div class="custom-next-<?= $name ?>">
            <div class="rounded-circle">
                <i class="fa fa-regular fa-chevron-right"></i>
            </div>
        </div>
    </div>
<?php
    $html = ob_get_clean();
    return $html;
}

function get_social_icons()
{
    $social_links = get_setting_field('social_repeater');
    $html = '';
    if (!empty($social_links)) {
        $html .= '<div class="footer-social d-flex gap-2 justify-content-end">';
        foreach ($social_links as $social_link) {
            $icon_obj = $social_link['icon'] ?? [];
            $link = $social_link['link'] ?? '';
            $select_target = $social_link['select_target'] ?? '';
            $icon = load_image($icon_obj, 'img-fluid', 1);
            $html .= '<a href="' . esc_url($link) . '" target="' . esc_attr($select_target) . '" rel="noopener noreferrer">' . $icon . '</a>';
        }
        $html .= '</div>';
    }
    return $html;
}

function get_language_selector_html()
{
    ob_start();
?>
    <div class="lang-icon-wrap ms-auto">
        <?php
        $languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
        $current_lang = apply_filters('wpml_current_language', NULL);
        $current_lang_country_flag_url = $languages[$current_lang]['country_flag_url'] ?? '';
        ?>
        <?php if (isset($languages[$current_lang]['country_flag_url']) && pathinfo($languages[$current_lang]['country_flag_url'], PATHINFO_EXTENSION) === 'svg') : ?>
            <?php echo file_get_contents(esc_url($current_lang_country_flag_url)); ?>
        <?php else : ?>
            <img src="<?= esc_url($current_lang_country_flag_url); ?>" alt="lang-flag">
        <?php endif; ?>
    </div>
    <div class="current-wpml-lang">
        <?= strtoupper(esc_html($current_lang)); ?>
    </div>
<?php
    return ob_get_clean();
}

function get_modal($file_path, $id)
{
    return get_template_part('template-parts/modal/base-modal', null, [
        'file' => $file_path,
        'id'   => $id,
    ]);
}

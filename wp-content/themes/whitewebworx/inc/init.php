<?php

function my_max_image_size($file)
{
    $size = $file['size'];
    $size = $size / 1024;
    $type = $file['type'];
    $is_image = strpos($type, 'image') !== false;
    $limit = 690;
    $limit_output = '750kb';
    if ($is_image && $size > $limit) {
        $file['error'] = 'המשקל של התמונה צריך להיות קטן מ ' . $limit_output;
    }
    return $file;
}

// add_filter('wp_handle_upload_prefilter', 'my_max_image_size');


function setup()
{

    add_theme_support('title-tag');
    add_theme_support('responsive-embeds');
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1568, 9999);
    add_image_size('product-thumb', 800, 800, true);
    add_image_size('product-thumb-medium', 400, 300, true);
    add_image_size('product-thumb-small', 70, 60, true);

    register_nav_menus(
        array(
            'header' => __('Header', 'leon'),
            'footer' => __('Footer', 'leon'),
        )
    );

    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
        )
    );

    add_theme_support(
        'custom-logo',
        array(
            'height' => 236,
            'width' => 44,
            'flex-width' => false,
            'flex-height' => false,
        )
    );
}

add_action('after_setup_theme', 'setup');

function scripts()
{
    wp_enqueue_script('jquery');


    wp_enqueue_style('bootstrap-style', get_theme_file_uri('/assets/css/bootstrap.min.css'), array(), wp_get_theme()->get('Version'), '');
    wp_enqueue_style('font-vietnam', get_theme_file_uri('/assets/fonts/be-vietnam-pro/be-vietnam-pro.css'), array(), wp_get_theme()->get('Version'), '');
    wp_enqueue_style('font-source-sans-pro', get_theme_file_uri('/assets/fonts/source-sans-pro/source-sans-pro.css'), array(), wp_get_theme()->get('Version'), '');

    // wp_enqueue_script('fontawesome-js', 'https://kit.fontawesome.com/56b531fbc9.js', array(), wp_get_theme()->get('Version'), true);
    // wp_enqueue_style('fonts', 'https://use.typekit.net/ynz8xgn.css', array(), wp_get_theme()->get('Version'), '');
   
    wp_enqueue_style('owl-carousel-style', get_theme_file_uri('/assets/css/owl.carousel.min.css'), array(), wp_get_theme()->get('Version'), '');
    wp_enqueue_style('owl-carousel-theme-style', get_theme_file_uri('/assets/css/owl.theme.default.min.css'), array(), wp_get_theme()->get('Version'), '');
    wp_enqueue_script('owl-carousel', get_theme_file_uri('/assets/js/owl.carousel.min.js'), array(), time(), true);
    wp_enqueue_script('bootstrap-js', get_theme_file_uri('/assets/js/bootstrap.bundle.min.js'), array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('font-awesome-js', get_theme_file_uri('/assets/fonts/font-awesome/font-awesome.js'), array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('vimeo-js', 'https://player.vimeo.com/api/player.js', array(), wp_get_theme()->get('Version'), true);

    wp_enqueue_style('style', get_stylesheet_uri(), array(), time());
    wp_enqueue_script('custom-js', get_theme_file_uri('/assets/js/custom.js'), array(), time(), '');
}
add_action('wp_enqueue_scripts', 'scripts');



function disable_emojis_tinymce($plugins)
{

    if (is_array($plugins)) {

        return array_diff($plugins, array('wpemoji'));
    } else {

        return array();
    }
}

remove_action('wp_head', 'wp_generator');

function example_add_dashboard_widgets()
{
    wp_add_dashboard_widget(
        'WhiteWebWorx_contact_details',
        'WhiteWebWorx',
        'WhiteWebWorx_dashboard_widget_function'
    );
}

add_action('wp_dashboard_setup', 'example_add_dashboard_widgets');

function WhiteWebWorx_dashboard_widget_function()
{
    $output = '<div id="contact_logo" align="center"><a href="//whiteweb.co.il" target="_blank">

    <img src="//whiteweb.co.il/images/logo/logo.gif" style="max-width:100%"></a></div>';

    $output .= '<div>';

    $output .= '<div class="contact">For Support: </div>';

    $output .= '<div class="contact">WhiteWebWorx</div>';

    $output .= '<div class="contact"><a href="mailto:support@whiteweb.co.il">support@whiteweb.co.il</a></div>';

    $output .= '</div>';

    echo $output;
}

function custom_admin_logo()
{

    echo '<style type="text/css">#header-logo { background-image: url(//whiteweb.co.il/images/logo/logo.gif) !important; }</style>';
}

add_action('admin_head', 'custom_admin_logo');

function my_login_logo()
{

    echo '

    <style type="text/css">

        #login h1 a {

            background-image: url(//whiteweb.co.il/images/logo/logo.gif);

            background-size: 100% 100%;

            width: 80%;

        }

    </style>

    ';
}

add_action('login_enqueue_scripts', 'my_login_logo');


add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4);

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function fix_svg()
{
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action('admin_head', 'fix_svg');

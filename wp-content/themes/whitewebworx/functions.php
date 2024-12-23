<?php

define('DEFAULT_TEXT_DOMAIN', 'metzer');
define('DEFAULT_IMAGE_PATH', get_template_directory_uri() . '/assets/images/default/image.jpg');

function pre($array)
{
    if ($_SERVER['REMOTE_ADDR'] === '82.81.76.144' || current_user_can('administrator')) {
        echo "<pre class='text-start p-2' dir='ltr' style='background:black;color:yellow'>";
        print_r($array);
        echo "</pre>";
    }
}


require get_template_directory() . '/inc/init.php';
require get_template_directory() . '/inc/cpts.php';
require get_template_directory() . '/inc/helper.php';
require get_template_directory() . '/inc/comments-helper.php';
require get_template_directory() . '/inc/buttons-fn.php';
require get_template_directory() . '/inc/bootstrap_menu_extend.php';
require get_template_directory() . '/inc/acf-functions.php';


// add_filter('show_admin_bar', '__return_false');

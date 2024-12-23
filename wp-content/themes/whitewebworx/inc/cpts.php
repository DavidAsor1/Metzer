<?php
// Return an array of all CPT definitions
function get_cpts()
{
    return [
        [
            'name'   => 'Solutions',
            'single' => 'Solution',
            'slug'   => 'solutions',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
            'rewrite' => ['slug' => 'solutions', 'with_front' => false],
            'menu_icon' => 'dashicons-hammer',
            'has_archive' => true
        ],
        [
            'name'   => 'Crop Insights',
            'single' => 'Crop Insight',
            'slug'   => 'crop_insights',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
            'rewrite' => ['slug' => 'crop-insights', 'with_front' => false],
            'menu_icon' => 'dashicons-carrot',
            'has_archive' => true
        ],
        [
            'name'   => 'Projects',
            'single' => 'Project',
            'slug'   => 'projects',
            'supports' => ['title', 'thumbnail', 'custom-fields'],
            'rewrite' => ['slug' => 'projects', 'with_front' => false],
            'menu_icon' => 'dashicons-portfolio',
            'has_archive' => true
        ],
        [
            'name'   => 'Products',
            'single' => 'Product',
            'slug'   => 'products',
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'rewrite' => ['slug' => 'products', 'with_front' => false],
            'menu_icon' => 'dashicons-cart',
            'has_archive' => true
        ],
        [
            'name'   => 'Events',
            'single' => 'Event',
            'slug'   => 'events',
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'rewrite' => ['slug' => 'events', 'with_front' => false],
            'menu_icon' => 'dashicons-calendar-alt',
            'has_archive' => true
        ],
    ];
}

// Return an array of all taxonomy definitions
function get_taxonomies_definitions()
{
    return [
        [
            'name'       => 'Solution Categories',
            'single'     => 'Solution Category',
            'slug'       => 'solution_category',
            'post_types' => ['solutions'],
            'hierarchical' => true,
            'options_page' => false
        ],
        [
            'name'       => 'Product Categories',
            'single'     => 'Product Category',
            'slug'       => 'product_category',
            'post_types' => ['products'],
            'hierarchical' => true,
            'options_page' => false
        ],
        [
            'name'       => 'Product Brands',
            'single'     => 'Product Brand',
            'slug'       => 'product_brand',
            'post_types' => ['products'],
            'hierarchical' => false,
            'options_page' => false
        ],
        [
            'name'       => 'Crop Categories',
            'single'     => 'Crop Category',
            'slug'       => 'crop_insight_category',
            'post_types' => ['crop_insights'],
            'hierarchical' => true,
            'options_page' => true
        ],
        [
            'name'       => 'Product Types',
            'single'     => 'Product Type',
            'slug'       => 'product_type',
            'post_types' => ['products'],
            'hierarchical' => true
        ],
        [
            'name'       => 'Locations',
            'single'     => 'Location',
            'slug'       => 'locations',
            'post_types' => ['projects', 'post'],
            'hierarchical' => true,
            'options_page' => true
        ],
        [
            'name'       => 'Hectare',
            'single'     => 'Hectare',
            'slug'       => 'hectares',
            'post_types' => ['projects'],
            'hierarchical' => true,
            'options_page' => true,
        ],
        [
            'name'       => 'Event Categories',
            'single'     => 'Event Category',
            'slug'       => 'event_category',
            'post_types' => ['events'],
            'hierarchical' => true,
            'options_page' => true
        ],
        [
            'name'       => 'Event Tags',
            'single'     => 'Event Tag',
            'slug'       => 'event_tag',
            'post_types' => ['events'],
            'hierarchical' => false,
            'options_page' => true
        ],

    ];
}

// Register all CPTs by looping through the array returned by get_cpts()
function create_post_types()
{
    $cpts = get_cpts();
    $menu_position = 20;

    foreach ($cpts as $custom_post) {
        $labels = [
            'name'                  => _x($custom_post['name'], 'Post Type General Name'),
            'singular_name'         => _x($custom_post['single'], 'Post Type Singular Name'),
            'menu_name'             => __($custom_post['name']),
            'name_admin_bar'        => __($custom_post['single']),
            'archives'              => __($custom_post['single'] . ' Archives'),
            'attributes'            => __($custom_post['single'] . ' Attributes'),
            'parent_item_colon'     => __('Parent ' . $custom_post['single']),
            'all_items'             => __('All ' . $custom_post['name']),
            'add_new_item'          => __('Add New ' . $custom_post['single']),
            'add_new'               => __('Add New'),
            'new_item'              => __('New ' . $custom_post['single']),
            'edit_item'             => __('Edit ' . $custom_post['single']),
            'update_item'           => __('Update ' . $custom_post['single']),
            'view_item'             => __('View ' . $custom_post['single']),
            'view_items'            => __('View ' . $custom_post['name']),
            'search_items'          => __('Search ' . $custom_post['single']),
            'not_found'             => __('Not found'),
            'not_found_in_trash'    => __('Not found in Trash'),
            'featured_image'        => __('Featured Image'),
            'set_featured_image'    => __('Set featured image'),
            'remove_featured_image' => __('Remove featured image'),
            'use_featured_image'    => __('Use as featured image'),
            'insert_into_item'      => __('Insert into ' . $custom_post['single']),
            'uploaded_to_this_item' => __('Uploaded to this ' . $custom_post['single']),
            'items_list'            => __($custom_post['name'] . ' list'),
            'items_list_navigation' => __($custom_post['name'] . ' list navigation'),
            'filter_items_list'     => __('Filter ' . $custom_post['name'] . ' list'),
        ];

        $args = [
            'label'               => __($custom_post['single']),
            'description'         => __($custom_post['single'] . ' Description'),
            'labels'              => $labels,
            'supports'            => isset($custom_post['supports']) ? $custom_post['supports'] : ['title', 'editor'],
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => $menu_position,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => isset($custom_post['has_archive']) ? $custom_post['has_archive'] : false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_in_rest'        => true,
            'capability_type'     => 'post',
            'menu_icon'           => isset($custom_post['menu_icon']) ? $custom_post['menu_icon'] : 'dashicons-admin-post',
            'rewrite'             => isset($custom_post['rewrite']) ? $custom_post['rewrite'] : ['slug' => $custom_post['slug']],
        ];

        register_post_type($custom_post['slug'], $args);

        $menu_position++;
    }
}
add_action('init', 'create_post_types', 0);

// Register all taxonomies by looping through the array returned by get_taxonomies_definitions()
function create_taxonomies()
{
    $taxonomies = get_taxonomies_definitions();

    foreach ($taxonomies as $tax) {
        $labels = [
            'name'              => _x($tax['name'], 'taxonomy general name'),
            'singular_name'     => _x($tax['single'], 'taxonomy singular name'),
            'search_items'      => __('Search ' . $tax['name']),
            'all_items'         => __('All ' . $tax['name']),
            'parent_item'       => __('Parent ' . $tax['single']),
            'parent_item_colon' => __('Parent ' . $tax['single'] . ':'),
            'edit_item'         => __('Edit ' . $tax['single']),
            'update_item'       => __('Update ' . $tax['single']),
            'add_new_item'      => __('Add New ' . $tax['single']),
            'new_item_name'     => __('New ' . $tax['single'] . ' Name'),
            'menu_name'         => __($tax['name']),
        ];

        $args = [
            'hierarchical'      => $tax['hierarchical'],
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
            'rewrite'           => ['slug' => $tax['slug'], 'with_front' => false, 'hierarchical' => $tax['hierarchical']],
        ];

        register_taxonomy($tax['slug'], $tax['post_types'], $args);
    }
}
add_action('init', 'create_taxonomies', 0);

// add_action('acf/init', 'add_taxonomy_options_pages');
// function add_taxonomy_options_pages()
// {
//     if (!function_exists('acf_add_options_sub_page')) {
//         return;
//     }

//     $taxonomies = get_taxonomies_definitions();

//     foreach ($taxonomies as $tax) {
//         if (empty($tax['options_page']) || !$tax['options_page']) {
//             continue;
//         }

//         acf_add_options_sub_page(array(
//             'page_title'  => $tax['name'] . ' Settings',
//             'menu_title'  => $tax['name'] . ' Settings',
//             'parent_slug' => 'website-general-settings',
//             'capability'  => 'manage_options',
//             'redirect'    => false
//         ));
//     }
// }

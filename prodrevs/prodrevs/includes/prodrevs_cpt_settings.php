<?php

/*
 * All settings related to Products custom post type 
 * including "Target Groups" Taxonomy definition
 */

// Register products post type
function register_product_type() {
    register_post_type('products', array(
        'labels' => array(
            'name' => esc_html__('Products'),
            'singular_name' => esc_html__('Product')
        ),
        'public' => true,
        'menu_icon' => 'dashicons-smiley',
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'supports' => array('title', 'thumbnail', 'editor', 'page-attributes')
            )
    );
}

add_action('init', 'register_product_type', 10);


// Create Taxonomy for Custom Post Type
add_action('init', 'prodrevs_create_products_custom_taxonomy', 0);

// Create "Target Groups" taxonomy for CPT "Products"
function prodrevs_create_products_custom_taxonomy() {

    $labels = array(
        'name' => _x('Target Groups', 'taxonomy general name'),
        'singular_name' => _x('Target Group', 'taxonomy singular name'),
        'search_items' => __('Search Target Groups'),
        'all_items' => __('All Target Groups'),
        'parent_item' => __('Parent Target Group'),
        'parent_item_colon' => __('Parent Target Group:'),
        'edit_item' => __('Edit Target Group'),
        'update_item' => __('Update Target Group'),
        'add_new_item' => __('Add New Target Group'),
        'new_item_name' => __('New Target Group Name'),
        'menu_name' => __('Target Groups')
    );

    register_taxonomy('target_groups', array('products'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'target_groups'),
        'menu_position' => 0
    ));
}

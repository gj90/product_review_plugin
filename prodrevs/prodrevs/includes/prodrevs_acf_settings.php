<?php

/*
 * All ACF settings can be found here (including predefined fields)
 */

// Hide ACF from menu
define('ACF_LITE', true);

if( !class_exists('Acf') )
{
    define( 'ACF_LITE' , true ); // Hide it from admin
    include_once('advanced-custom-fields/acf.php' );
}


// Add predefined ACF field group
add_action('acf/init', 'prodrevs_create_field_group');

function prodrevs_create_field_group() {
    if (function_exists('register_field_group')):

        $fields_to_import = array(
            'key' => 'group_5c7eda91bfc71',
            'title' => 'Product Fields',
            'fields' => array(
                array(
                    'key' => 'field_5c7edaa32c552',
                    'label' => 'Product Rating',
                    'name' => 'product_rating',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 1,
                    'max' => 5,
                    'step' => '',
                ),
                array(
                    'key' => 'field_5c7edab82c553',
                    'label' => 'Product Image',
                    'name' => 'product_image',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'int',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'products',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'acf_after_title',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
            ),
            'active' => true,
            'description' => '',
        );

        register_field_group($fields_to_import);

    endif;
}

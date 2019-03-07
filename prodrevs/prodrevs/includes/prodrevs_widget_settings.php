<?php
/*
 * All settings related to the widget are here
 */

// Register and load the widget
function prodrevs_load_widget() {
    register_widget('prodrevs_widget');
}

add_action('widgets_init', 'prodrevs_load_widget');

// Creating the widget - backend
class prodrevs_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'prodrevs_widget', __('Product List', 'prodrevs_widget_domain'), array('description' => __('Shows first 5 products sorted star ratings', 'prodrevs_widget_domain'),)
        );
    }

// Creating the widget - dashboard interface    
    public function form( $instance ) {
        if(empty(get_option('default-target-group')) || !prodrevs_check_term(get_option('default-target-group')) ){
            echo "<p>Please <a href='" . admin_url( 'admin.php?page=prodrevs%2Fincludes%2Fprodrevs_general_settings.php' ) . "'>click here</a> to setup the default target group. ";
        }else{
            echo "<p>Default Target Group to show: <a href='" . admin_url( 'admin.php?page=prodrevs%2Fincludes%2Fprodrevs_general_settings.php' ) . "'>".get_option('default-target-group')."</a>. ";
        }
    }

// Creating the widget - front-end

    function widget($args, $instance) {

        /* Fetch target parameter and setup session to remember target group
         * or fallback to default option set in settings
        */

        if (isset($_GET['target']) && !empty($_GET['target']) && prodrevs_check_term($_GET['target'])) {
            $target = $_GET['target'];
            $_SESSION['target_group'] = $target;
        } elseif (( (!isset($_GET['target']) && empty($_GET['target']) ) || !prodrevs_check_term($_GET['target']) ) && !empty($_SESSION['target_group'])) {
            $target = $_SESSION['target_group'];
        } else {
            $target = esc_attr(get_option('default-target-group'));
        }

        
        $query_args = array(
            'numberposts' => 5,
            'post_type' => 'products',
            'tax_query' => array(
                array(
                    'taxonomy' => 'target_groups',
                    'field' => 'slug',
                    'terms' => array($target),
                )
            ),
            'meta_key' => 'product_rating',
            'orderby' => 'meta_value',
            'order' => 'DESC',
        );

        $posts_found = get_posts($query_args);
        prodrevs_render_results($posts_found);
    }

}

/**
 * 
 * Rendering widget display on frontend
 * 
 * @param Object $posts_found Input posts object
 */
function prodrevs_render_results($posts_found) {
    if ($posts_found):
        echo "<h2>Products List</h2>";
        foreach ($posts_found as $post_found):
            ?>
            <section>
                <?php
                $image = get_field('product_image', $post_found->ID);
                $size = 'medium';

                if ($image) {
                    echo wp_get_attachment_image($image, $size);
                }
                ?>
                <p><?php prodrevs_star_rating_visual(get_field('product_rating', $post_found->ID)); ?></p>
                <p><a href="<?php echo get_permalink($post_found->ID); ?>"><?php echo get_the_title($post_found->ID); ?></a></p><hr>
            </section>

            <?php
        endforeach;
        wp_reset_postdata();
        ?>
        <?php
    endif;
}

/**
 * 
 * Performs a check whether input term exists in "target_groups"
 * 
 * @param String $input_term Taxonomy Term to search
 * @return boolean
 */
function prodrevs_check_term($input_term) {
    $term = term_exists($input_term, 'target_groups');
    if (0 !== $term && null !== $term) {
        return true;
    }
    return false;
}

/**
 * 
 * Calculates and returns star icons as trings
 * 
 * @param Integer $rating Input star rating
 * @return String Echo out spans with icons
 */
function prodrevs_star_rating_visual($rating) {
    $max_rating = 5;
    $blank_stars = $max_rating - $rating;
    for ($i = 0; $i < $rating; $i++) {
        // Shows filled stars
        echo "<span class='dashicons dashicons-star-filled'></span>";
    }

    for ($j = 0; $j < $blank_stars; $j++) {
        // Shows empty stars
        echo "<span class='dashicons dashicons-star-empty'></span>";
    }
}

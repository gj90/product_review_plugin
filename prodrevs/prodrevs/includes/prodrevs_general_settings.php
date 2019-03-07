<?php
/*
 * All general settings and misc functions used by plugin
 * 
 */


define('PRODREVS__PLUGIN_DIR', plugin_dir_path(__FILE__));

// Enable session storing
add_action('init', 'prodrevs_start_session', 1);
add_action('wp_logout', 'prodrevs_end_session');
add_action('wp_login', 'prodrevs_end_session');
function prodrevs_start_session() {
    if (!session_id()) {
        session_start();
    }
}
function prodrevs_end_session() {
    session_destroy();
}

// Enable the display of dashicons on frontend
add_action('wp_enqueue_scripts', 'prodrevs_load_dashicons_front_end');
function prodrevs_load_dashicons_front_end() {
    wp_enqueue_style('dashicons');
}

// Create plugin settings page
add_action('admin_menu', 'prodrevs_create_menu');
function prodrevs_create_menu() {
    add_menu_page('Products Settings', 'Products Settings', 'administrator', __FILE__, 'prodrevs_settings_page', 'dashicons-smiley', 0);
    add_action('admin_init', 'register_prodrevs_settings');
}

// Register settings
function register_prodrevs_settings() {
    register_setting('prodrevs-settings-group', 'default-target-group');
}

// Render settings page
function prodrevs_settings_page() {
    ?>
    <div class="wrap">
        <h1>Products Settings</h1>

        <form method="post" action="options.php">
            <?php settings_fields('prodrevs-settings-group'); ?>
            <?php do_settings_sections('prodrevs-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Default Target Group: </th>
                    <td>
                        <select name="default-target-group" required >
                            <?php if (!empty(get_option('default-target-group')) && prodrevs_check_term(get_option('default-target-group'))) { ?>
                                <option value="<?php echo esc_attr(get_option('default-target-group')); ?>"><?php echo esc_attr(get_option('default-target-group')); ?></option>
                            <?php } else { ?>
                                <option value="" disabled selected>Select Target Group</option>
                                <?php
                            }
                            // Fetch all target groups
                            $terms = get_terms('target_groups');
                            if (!empty($terms) && !is_wp_error($terms)) {
                                foreach ($terms as $term) {
                                    echo "<option value=" . $term->slug . ">" . $term->slug . "</option>";                                    
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

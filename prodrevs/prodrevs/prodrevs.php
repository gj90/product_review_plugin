<?php
/**
 * @package prodrevs
 */
/*
Plugin Name: Product Reviews
Plugin URI: https://domain.com
Description: A plugin that creates CPT Products with Title, Star Rating and Image field (by ACF Lite). Plugin creates custom taxonomy and a widget. Products can be in one or more Target Groups which is used for their categorization and as a parameter for their filtering in widget. Filtering can be done via url ?target=target-group-slug. Default target group to be displayed can be set via Products Settings page.
Version: 1.0
Author: Goran Jovanovic
Author URI: https://domain.com
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

/*
Copyright 2019 Goran Jovanovic
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

include_once('includes/advanced-custom-fields/acf.php' );
include_once('includes/prodrevs_general_settings.php' );
include_once('includes/prodrevs_cpt_settings.php' );
include_once('includes/prodrevs_acf_settings.php' );
include_once('includes/prodrevs_widget_settings.php' );


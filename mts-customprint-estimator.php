<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://profiles.wordpress.org/webmvw/
 * @since             1.0.0
 * @package           Mts_Customprint_Estimator
 *
 * @wordpress-plugin
 * Plugin Name:       Mts CustomPrint Estimator
 * Plugin URI:        https://https://wordpress.org/plugins/mts-customprint-estimator
 * Description:       CustomPrint Estimator is a powerful WooCommerce extension that allows customers to customize their product’s print area by entering the width and height on the product page. The plugin calculates the price based on the area and adjusts for single or double-sided printing options. Easily integrate custom pricing logic into your store and offer a seamless pricing experience for print-based products.
 * Version:           1.0.0
 * Author:            webmvw
 * Author URI:        https://https://profiles.wordpress.org/webmvw//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mts-customprint-estimator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MTS_CUSTOMPRINT_ESTIMATOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mts-customprint-estimator-activator.php
 */
function activate_mts_customprint_estimator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mts-customprint-estimator-activator.php';
	Mts_Customprint_Estimator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mts-customprint-estimator-deactivator.php
 */
function deactivate_mts_customprint_estimator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mts-customprint-estimator-deactivator.php';
	Mts_Customprint_Estimator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mts_customprint_estimator' );
register_deactivation_hook( __FILE__, 'deactivate_mts_customprint_estimator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mts-customprint-estimator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mts_customprint_estimator() {

	$plugin = new Mts_Customprint_Estimator();
	$plugin->run();

}
run_mts_customprint_estimator();

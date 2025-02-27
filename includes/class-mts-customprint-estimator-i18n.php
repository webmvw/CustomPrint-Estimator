<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://profiles.wordpress.org/webmvw/
 * @since      1.0.0
 *
 * @package    Mts_Customprint_Estimator
 * @subpackage Mts_Customprint_Estimator/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mts_Customprint_Estimator
 * @subpackage Mts_Customprint_Estimator/includes
 * @author     webmvw <masudrana.bbpi@gmail.com>
 */
class Mts_Customprint_Estimator_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mts-customprint-estimator',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

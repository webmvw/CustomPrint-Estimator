<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://profiles.wordpress.org/webmvw/
 * @since      1.0.0
 *
 * @package    Mts_Customprint_Estimator
 * @subpackage Mts_Customprint_Estimator/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mts_Customprint_Estimator
 * @subpackage Mts_Customprint_Estimator/includes
 * @author     webmvw <masudrana.bbpi@gmail.com>
 */
class Mts_Customprint_Estimator {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mts_Customprint_Estimator_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MTS_CUSTOMPRINT_ESTIMATOR_VERSION' ) ) {
			$this->version = MTS_CUSTOMPRINT_ESTIMATOR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mts-customprint-estimator';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mts_Customprint_Estimator_Loader. Orchestrates the hooks of the plugin.
	 * - Mts_Customprint_Estimator_i18n. Defines internationalization functionality.
	 * - Mts_Customprint_Estimator_Admin. Defines all hooks for the admin area.
	 * - Mts_Customprint_Estimator_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mts-customprint-estimator-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mts-customprint-estimator-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mts-customprint-estimator-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mts-customprint-estimator-public.php';

		$this->loader = new Mts_Customprint_Estimator_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mts_Customprint_Estimator_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mts_Customprint_Estimator_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Mts_Customprint_Estimator_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Mts_Customprint_Estimator_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );


		$this->loader->add_action('woocommerce_before_add_to_cart_button', $plugin_public, 'mts_customprint_estimator_before_add_to_cart');
		$this->loader->add_action('woocommerce_add_cart_item_data', $plugin_public, 'mts_customprint_estimator_update_cart_item_price', 10, 2);
		$this->loader->add_action('woocommerce_before_calculate_totals', $plugin_public, 'mts_customprint_estimator_update_cart_item_price_in_cart', 10, 1);

		$this->loader->add_filter('woocommerce_get_item_data', $plugin_public, 'mts_customprint_estimator_display_custom_cart_item_data', 10, 2);

		$this->loader->add_action('woocommerce_checkout_create_order_line_item', $plugin_public, 'mts_customprint_estimator_save_custom_data_to_order_items', 10, 4);

		$this->loader->add_action('add_meta_boxes', $plugin_public, 'mts_customprint_estimator_add_custom_meta_box');

		$this->loader->add_action('save_post', $plugin_public, 'mts_customprint_estimator_save_custom_meta_box');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mts_Customprint_Estimator_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

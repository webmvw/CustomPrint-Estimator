<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://profiles.wordpress.org/webmvw/
 * @since      1.0.0
 *
 * @package    Mts_Customprint_Estimator
 * @subpackage Mts_Customprint_Estimator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mts_Customprint_Estimator
 * @subpackage Mts_Customprint_Estimator/public
 * @author     webmvw <masudrana.bbpi@gmail.com>
 */
class Mts_Customprint_Estimator_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mts_Customprint_Estimator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mts_Customprint_Estimator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mts-customprint-estimator-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mts_Customprint_Estimator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mts_Customprint_Estimator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mts-customprint-estimator-public.js', array( 'jquery' ), $this->version, true );

	}



	/**
	 * Customprint Extimator content
	 *
	 * @since    1.0.0
	 */
	public function mts_customprint_estimator_before_add_to_cart(){
		ob_start();
		require_once(plugin_dir_path( __FILE__ ).'partials/mts-customprint-estimator-public-display.php');
		$template = ob_get_contents();
		ob_clean();
		echo $template;

	}



	/**
	 * Adjust the price in the cart based on the selected dimensions
	 *
	 * @since    1.0.0
	 */
	public function mts_customprint_estimator_update_cart_item_price($cart_item_data, $product_id){

		if ( isset( $_POST['mts_banner_width_ft'] ) && isset( $_POST['mts_banner_width_in'] ) && isset( $_POST['mts_banner_height_ft'] ) && isset( $_POST['mts_banner_height_in'] ) && isset( $_POST['mts_customprint_estimator_of_side'] ) && isset( $_POST['mts_customprint_estimator_hem'] ) && isset( $_POST['mts_customprint_estimator_grommet'] ) ) {

	   
	        $width_ft = isset( $_POST['mts_banner_width_ft'] ) ? floatval( sanitize_text_field( wp_unslash( $_POST['mts_banner_width_ft'] ) ) ) : '';
	        $width_in = isset( $_POST['mts_banner_width_in'] ) ? floatval( sanitize_text_field( wp_unslash( $_POST['mts_banner_width_in'] ) ) ) : '';
	        $height_ft = isset( $_POST['mts_banner_height_ft'] ) ? floatval( sanitize_text_field( wp_unslash( $_POST['mts_banner_height_ft'] ) ) ) : '';
	        $height_in = isset( $_POST['mts_banner_height_in'] ) ? floatval( sanitize_text_field( wp_unslash( $_POST['mts_banner_height_in'] ) ) ) : '';


	        $side = isset( $_POST['mts_customprint_estimator_of_side'] ) ? floatval( sanitize_text_field( wp_unslash( $_POST['mts_customprint_estimator_of_side'] ) ) ) : '';
	        $hem = isset( $_POST['mts_customprint_estimator_hem'] ) ? sanitize_text_field( wp_unslash( $_POST['mts_customprint_estimator_hem'] ) ) : '';
	        $grommet = isset( $_POST['mts_customprint_estimator_grommet'] ) ? sanitize_text_field( wp_unslash( $_POST['mts_customprint_estimator_grommet'] ) ) : '';


	        $width_ft_to_in = $width_ft*12;
	        $total_width_with_in = $width_ft_to_in+$width_in;


	        $height_ft_to_in = $height_ft*12;
	        $total_height_with_in = $height_ft_to_in+$height_in;

	        $area_with_in = $total_width_with_in * $total_height_with_in;

	        
	        // Calculate the area
	        $final_area_with_ft = $area_with_in/144;
	        
	        // Get the base price of the product
	        $base_price = get_post_meta( $product_id, '_price', true );
	        
	        // Calculate the total price
	        $new_price = intval(($base_price * $final_area_with_ft) * $side);
	        
	        // Add new price to the cart item
	        $cart_item_data['mts_customprint_estimator_custom_price'] = $new_price;

	        // add custom data
	        $cart_item_data['estimator_banner_width'] = $width_ft.'ft '.$width_in.'in';
	        $cart_item_data['estimator_banner_height'] = $height_ft.'ft '.$height_in.'in';
	        $cart_item_data['estimator_banner_side'] = ($side == 2) ? '2 Sides' : '1 Side';
	        $cart_item_data['estimator_banner_hem'] = $hem;
	        $cart_item_data['estimator_banner_grommet'] = $grommet;
	    }
	    
	    return $cart_item_data;

	}



	/**
	 * Display the updated price in the cart and checkout
	 *
	 * @since    1.0.0
	 */
	public function mts_customprint_estimator_update_cart_item_price_in_cart($cart){
		foreach ( $cart->get_cart() as $cart_item ) {
	        if ( isset( $cart_item['mts_customprint_estimator_custom_price'] ) ) {
	            $cart_item['data']->set_price( $cart_item['mts_customprint_estimator_custom_price'] );
	        }
	    }
	}


	/**
	 * show the custom data in the cart & checkout page
	 *
	 * @since    1.0.0
	 */
	public function mts_customprint_estimator_display_custom_cart_item_data($item_data, $cart_item){
		if ( isset( $cart_item['estimator_banner_width'] ) ) {
	        $item_data[] = array(
	            'name'  => 'Banner Width', // Label in the cart
	            'value' => sanitize_text_field( $cart_item['estimator_banner_width'] ),
	        );
	    }
	    if ( isset( $cart_item['estimator_banner_height'] ) ) {
	        $item_data[] = array(
	            'name'  => 'Banner Height', // Label in the cart
	            'value' => sanitize_text_field( $cart_item['estimator_banner_height'] ),
	        );
	    }
	    if ( isset( $cart_item['estimator_banner_side'] ) ) {
	        $item_data[] = array(
	            'name'  => 'Banner of Sides', // Label in the cart
	            'value' => sanitize_text_field( $cart_item['estimator_banner_side'] ),
	        );
	    }
	    if ( isset( $cart_item['estimator_banner_hem'] ) ) {
	        $item_data[] = array(
	            'name'  => 'Banner Hem', // Label in the cart
	            'value' => sanitize_text_field( $cart_item['estimator_banner_hem'] ),
	        );
	    }
	    if ( isset( $cart_item['estimator_banner_grommet'] ) ) {
	        $item_data[] = array(
	            'name'  => 'Grommet', // Label in the cart
	            'value' => sanitize_text_field( $cart_item['estimator_banner_grommet'] ),
	        );
	    }
	    return $item_data;

	}



	/**
	 * to store custom data in the WooCommerce order
	 *
	 * @since    1.0.0
	 */
	public function mts_customprint_estimator_save_custom_data_to_order_items($item, $cart_item_key, $values, $order){
		if ( isset( $values['estimator_banner_width'] ) ) {
	        $item->add_meta_data( 'Banner Width', $values['estimator_banner_width'], true );
	    }
	    if ( isset( $values['estimator_banner_height'] ) ) {
	        $item->add_meta_data( 'Banner Height', $values['estimator_banner_height'], true );
	    }
	    if ( isset( $values['estimator_banner_side'] ) ) {
	        $item->add_meta_data( 'Banner of Sides', $values['estimator_banner_side'], true );
	    }
	    if ( isset( $values['estimator_banner_hem'] ) ) {
	        $item->add_meta_data( 'Banner Hem', $values['estimator_banner_hem'], true );
	    }
	    if ( isset( $values['estimator_banner_grommet'] ) ) {
	        $item->add_meta_data( 'Grommet', $values['estimator_banner_grommet'], true );
	    }
	}




	/**
	 * Custom Meta Fields for Products
	 *
	 * @since    1.0.0
	 */
	public function mts_customprint_estimator_add_custom_meta_box(){
		add_meta_box(
	        'mts_estimator_banner_toggle', // Unique ID
	        'Enable Estimator Banner', // Title
	        [$this, 'mts_display_custom_meta_box'], // Callback to display content
	        'product', // Post type (WooCommerce product)
	        'side', // Context (position in the edit screen)
	        'high' // Priority
	    );
	}

	public function mts_display_custom_meta_box($post){
		$value = get_post_meta($post->ID, '_product_estimator_banner_enabled', true);
	    ?>
	    <label for="mts_estimator_banner_enabled"><?php esc_html_e('Enable Estimator Banner Feature:'); ?></label>
	    <select name="mts_estimator_banner_enabled" id="mts_estimator_banner_enabled">
	    	<option>Select Option</option>
	        <option value="yes" <?php selected($value, 'yes'); ?>>Yes</option>
	        <option value="no" <?php selected($value, 'no'); ?>>No</option>
	    </select>
	    <?php
	}


	public function mts_customprint_estimator_save_custom_meta_box($post_id){
		if (isset($_POST['mts_estimator_banner_enabled'])) {
	        update_post_meta($post_id, '_product_estimator_banner_enabled', sanitize_text_field($_POST['mts_estimator_banner_enabled']));
	    }
	}


}

<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://https://profiles.wordpress.org/webmvw/
 * @since      1.0.0
 *
 * @package    Mts_Customprint_Estimator
 * @subpackage Mts_Customprint_Estimator/public/partials
 */



// Get the current product ID
$product_id = get_the_ID();

// Get the meta value for '_product_estimator_banner_enabled'
$estimator_banner_enabled = get_post_meta($product_id, '_product_estimator_banner_enabled', true);

// Check if the value is 'yes' or 'no'
if ($estimator_banner_enabled === 'yes') {
?>

	<div class="mts_customprint_estimator_modal">
		<div class="mts_customprint_estimator_form">
		  <div class="mts_customprint_estimator_form_info">
		  	<div class="input_container">
		  		<label class="input_label"><?php esc_html_e('Width', 'mts-customprint-estimator'); ?></label>
		  		<div class="split">
		  			<div class="mts_banner_ft">
		  				<input name="mts_banner_width_ft" class="input_field" type="number" id="mts_banner_width_ft" value="0"  min="1" required>
		  				<span>ft</span>
		  			</div>
		  			<div class="mts_banner_ft">
		  				<input name="mts_banner_width_in" class="input_field" type="number" id="mts_banner_width_in" value="0" min="1" max="11" required>
		  				<span>in</span>
		  			</div>
		  		</div>
		  	</div>

		  	<div class="input_container">
		  		<label class="input_label"><?php esc_html_e('Height', 'mts-customprint-estimator'); ?></label>
		  		<div class="split">
		  			<div class="mts_banner_ft">
		  				<input name="mts_banner_height_ft" class="input_field" type="number" id="mts_banner_height_ft" value="0"  min="1" required>
		  				<span>ft</span>
		  			</div>
		  			<div class="mts_banner_ft">
		  				<input name="mts_banner_height_in" class="input_field" type="number" id="mts_banner_height_in" value="0" min="1" max="11" required>
		  				<span>in</span>
		  			</div>
		  		</div>
		  	</div>
		  	<div class="input_container">
		  		<label class="input_label"><span id="mts_banner_width">0</span> x <span id="mts_banner_height">0</span> = <span id="mts_banner_area">0</span> ft<sup>2</sup></label>
		  	</div>
		    <div class="input_container">
		      <label class="input_label"><?php esc_html_e('# of Sides' ,'mts-customprint-estimator') ?></label>
		      <select name="mts_customprint_estimator_of_side" id="mts_customprint_estimator_of_side" class="input_field">
		      	<option value="1" selected>1 Side</option>
		      	<option value="2">2 Sides</option>
		      </select>
		    </div>
		    <div class="input_container">
		      <label class="input_label"><?php esc_html_e('Hem', 'mts-customprint-estimator'); ?></label>
		      <select name="mts_customprint_estimator_hem" id="mts_customprint_estimator_hem" class="input_field">
		      	<option value="All Sides" selected>All Sides</option>
		      	<option value="No Hem">No Hem</option>
		      </select>
		    </div>
		    <div class="input_container">
		      <label class="input_label"><?php esc_html_e('Grommet', 'mts-customprint-estimator') ?></label>
		      <select name="mts_customprint_estimator_grommet" id="mts_customprint_estimator_grommet" class="input_field">
		      	<option value="Every 2' All Sides" selected>Every 2' All Sides</option>
		      	<option value="Every 2' Top & Bottom">Every 2' Top & Bottom</option>
		      	<option value="Every 2' Left & Right">Every 2' Left & Right</option>
		      	<option value="4 Corner Only">4 Corner Only</option>
		      	<option value="No Grommet">No Grommet</option>
		      </select>
		    </div>
		  </div>
		   <span id="mts_customprice_estimator_value" class="mts_customprint_estimator--btn">Total Price</span>
		</div>   
	</div>


<?php 

}
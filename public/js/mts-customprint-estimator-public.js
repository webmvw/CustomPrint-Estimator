(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */



	// Function to calculate and update price
	function update_price(){
		var width_ft = parseFloat( $('#mts_banner_width_ft').val() );
		var width_in = parseFloat( $('#mts_banner_width_in').val() );
		var height_ft = parseFloat( $('#mts_banner_height_ft').val() );
		var height_in = parseFloat( $('#mts_banner_height_in').val() );
		var side = parseFloat( $('#mts_customprint_estimator_of_side').val() );

		// check if both value are valid
		if(width_ft > 0 && height_ft > 0){

			var width_ft_to_in = width_ft*12;
			var total_width_with_in = width_ft_to_in+width_in;

			var height_ft_to_in = height_ft*12;
			var total_height_with_in = height_ft_to_in+height_in;

			var area_with_in = total_width_with_in * total_height_with_in;

			var final_area_with_ft = area_with_in/144;

			var base_price = parseFloat($('.price .amount').text().replace('$', '').replace(',', '')); // Get the base price from the page

			var total_price = (base_price * final_area_with_ft) * side; // multiply the base price by the area and side

			// update the displayed price
			$('#mts_customprice_estimator_value').text('Total Price: $' + total_price.toFixed(2));

			$('#mts_banner_width').text(total_width_with_in);
			$('#mts_banner_height').text(total_height_with_in);
			$('#mts_banner_area').text(final_area_with_ft.toFixed(2));
		}
	}


	// Trigger price udpate on input chage
	$('#mts_banner_width_ft, #mts_banner_width_in, #mts_banner_height_ft, #mts_banner_height_in').on('input', function(){
		update_price();
	});

	$('#mts_customprint_estimator_of_side').on('change', function(){
        update_price();
    });


})( jQuery );

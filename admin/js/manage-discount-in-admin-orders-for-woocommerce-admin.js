(function( $ ) {
	'use strict';

	$( document ).ready(function() {
		
		if( $( '#hellodev-discount-manager-apply-discount' ).length > 0 ) {
		
			function apply_discount() {
			
				var answer = confirm(wmdaoa_locales.confirm_apply_discount);

				if (!answer) {
					return false;
				}
			
				var discount = jQuery( '#hellodev-discount-manager-apply-discount' ).find( 'input[name=discount]' ).val();
				
				if (discount.length == 0) {
					discount = 0;
				}
			
				$( '#order_line_items' ).find( 'tr.item' ).each(function (i, element) {
					var original_total = jQuery( element ).find( '.line_subtotal' ).val();
					original_total = original_total.replace( ',', '.' );
					var new_total = original_total - ( original_total / 100 * discount );
					$( element ).find( '.line_total' ).val( new_total );
				});
			
				$( '#woocommerce-order-items' ).find( 'button.button.button-primary.save-action' ).click();
				
				$( '#hellodev-discount-manager-apply-discount-percentage' ).val('');
				
				return false;
			}
		
			$( '.calculate-discount-order' ).click( function(e) {
				e.preventDefault();
				apply_discount();
			});
	
		}
		
		if( $( '#woocommerce-order-actions-hide' ).length > 0 ) {
		
			function discount_per_item() {
			
				var discount = $( this ).val();
			
				if( discount >= 0 && discount <= 100 ) {
					var original_total = $( this ).closest( 'tr' ).find( '.line_subtotal' ).val();
					original_total = original_total.replace( ',', '.' );
					var new_total = original_total - ( original_total / 100 * discount );
					$( this ).closest( 'tr' ).find( '.line_total' ).val( new_total );
					$( '#woocommerce-order-items' ).find( 'button.button.button-primary.save-action' ).click();
				} else {
					alert(wmdaoa_locales.apply_error_message);
				}
			
			}
			
			$( '.hellodev-discount-manager-apply-discount-percentage' ).change( discount_per_item );
			
			function loopForever() {
				$( '.hellodev-discount-manager-apply-discount-percentage' ).change( discount_per_item );
			}
			
			window.setInterval( function () {
				loopForever();
			}, 1000 );
			
		}
		
	});

})( jQuery );

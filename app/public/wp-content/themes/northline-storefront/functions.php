<?php
// Storefront prints an empty "Shop by Brand" section when no brand has products.
add_action( 'homepage', function () {
	$brands = get_terms( array(
		'taxonomy'     => 'product_brand',
		'hide_empty'   => true,
		'hierarchical' => false,
		'number'       => 1,
		'fields'       => 'ids',
	) );
	if ( empty( $brands ) || is_wp_error( $brands ) ) {
		remove_action( 'homepage', 'storefront_woocommerce_brands_homepage_section', 80 );
	}
}, 0 );
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

// Storefront prints the brands shortcode from its homepage template, so WooCommerce 10.4+ does not detect it and skips the brand styles.
add_filter( 'woocommerce_should_load_brands_styles', function ( $load ) {
	return $load || is_page_template( 'template-homepage.php' );
} );
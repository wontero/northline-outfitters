<?php
// Storefront adds an empty "Shop by Brand" section when the store has no brands.
add_action( 'init', function () {
	remove_action( 'homepage', 'storefront_woocommerce_brands_homepage_section', 80 );
} );
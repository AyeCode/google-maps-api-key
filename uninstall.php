<?php
/**
 * Uninstall API KEY for Google Maps.
 *
 * Removes the saved Google Maps API key from the database.
 *
 * @package GMAPIKEY
 * @since   1.2.16
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( is_multisite() ) {
	$rgmk_site_ids = get_sites( array( 'fields' => 'ids', 'number' => 0 ) );

	foreach ( $rgmk_site_ids as $rgmk_site_id ) {
		switch_to_blog( $rgmk_site_id );
		delete_option( 'rgmk_google_map_api_key' );
		restore_current_blog();
	}
} else {
	delete_option( 'rgmk_google_map_api_key' );
}

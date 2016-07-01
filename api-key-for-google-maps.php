<?php
/**
 * This is the main GeoDirectory plugin file, here we declare and call the important stuff
 *
 * @package     GMAPIKEY
 * @copyright   2016 AyeCode Ltd
 * @license     GPL-2.0+
 * @since       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: API KEY for Google Maps
 * Plugin URI: http://wpgeodirectory.com/
 * Description: Adds API KEY to Google maps calls if they have been enqueue correctly.
 * Version: 1.0.0
 * Author: GeoDirectory
 * Author URI: https://wpgeodirectory.com
 * Text Domain: gmaps-api-key
 * Domain Path: /languages
 * Requires at least: 3.1
 * Tested up to: 4.5
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The current version number.
 *
 * @since 1.0.0
 */
define( "GMAPIKEY_VERSION", "1.0.0" );



add_action( 'plugins_loaded', 'rgmk_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function rgmk_load_textdomain() {
	load_plugin_textdomain( 'gmaps-api-key', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}


add_filter( 'clean_url', 'rgmk_find_add_key', 99, 3 );
/**
 * Clean url.
 *
 * @since   1.0.0
 * @package GMAPIKEY
 *
 * @param string $url          Url.
 * @param string $original_url Original url.
 * @param string $_context     Context.
 *
 * @return string Modified url.
 */
function rgmk_find_add_key( $url, $original_url, $_context ) {
	$key = get_option( 'rgmk_google_map_api_key' );

	// If no key added no point in checking
	if ( ! $key ) {
		return $url;
	}

	if ( strstr( $url, "maps.google.com/maps/api/js" ) !== false || strstr( $url, "maps.googleapis.com/maps/api/js" ) !== false ) {// it's a Google maps url

		if ( strstr( $url, "key=" ) === false ) {// it needs a key
			$url = add_query_arg( 'key',$key,$url);
			$url = str_replace( "&#038;", "&amp;", $url ); // or $url = $original_url
		}

	}

	return $url;
}

add_action( 'admin_menu', 'rgmk_add_admin_menu' );

/**
 * Add the admin menu link.
 *
 * @since   1.0.0
 * @package GMAPIKEY
 */
function rgmk_add_admin_menu() {
	add_submenu_page( 'options-general.php', 'Google API KEY', 'Google API KEY', 'manage_options', 'gmaps-api-key', 'rgmk_add_admin_menu_html' );
}

/**
 * The html output for the settings page.
 *
 * @since   1.0.0
 * @package GMAPIKEY
 */
function rgmk_add_admin_menu_html() {
	$updated = false;
	if ( isset( $_POST['rgmk_google_map_api_key'] ) ) {
		$key     = esc_attr( $_POST['rgmk_google_map_api_key'] );
		$updated = update_option( 'rgmk_google_map_api_key', $key );
	}

	if ( $updated ) {
		echo '<div class="updated fade"><p><strong>' . __( 'Kay Updated!', 'gmaps-api-key' ) . '</strong></p></div>';

	}
	?>
	<div class="wrap">

		<h2><?php _e( 'Retro Add Google Maps API KEY', 'gmaps-api-key' ); ?></h2>
		<p><?php _e( 'This plugin will attempt to add your Google API KEY to any Google Maps JS file that has properly been enqueue.', 'gmaps-api-key' ); ?></p>
		<p><?php echo sprintf( __( 'To Get a Google Maps API KEY %sclick here%s', 'geodirectory' ), '<a target="_blank" href=\'https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend&keyType=CLIENT_SIDE&reusekey=true\'>', '</a>' ) ?></p>

		<form method="post" action="options-general.php?page=gmaps-api-key">
			<label for="rgmk_google_map_api_key"><?php _e( 'Enter Google Maps API KEY', 'gmaps-api-key' ); ?></label>
			<input title="<?php _e( 'Add Google Maps API KEY', 'gmaps-api-key' ); ?>" type="text"
			       name="rgmk_google_map_api_key" id="rgmk_google_map_api_key"
			       value="<?php echo esc_attr( get_option( 'rgmk_google_map_api_key' ) ); ?>"/>
			<?php

			submit_button();

			?>
		</form>

	</div><!-- /.wrap -->
	<?php
}

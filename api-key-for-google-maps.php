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
 * Version: 1.2.0
 * Author: GeoDirectory
 * Author URI: https://wpgeodirectory.com
 * Text Domain: gmaps-api-key
 * Domain Path: /languages
 * Requires at least: 3.1
 * Tested up to: 4.9
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
define( "GMAPIKEY_VERSION", "1.2.0" );


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
			$url = add_query_arg( 'key', $key, $url );
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
 * @since   1.1.0 Added button to generate API KEY from wp-admin.
 * @package GMAPIKEY
 */
function rgmk_add_admin_menu_html() {
	add_thickbox();
	$updated = false;
	if ( isset( $_POST['rgmk_google_map_api_key'] ) ) {
		$key     = esc_attr( $_POST['rgmk_google_map_api_key'] );
		$updated = update_option( 'rgmk_google_map_api_key', $key );
	}

	if ( $updated ) {
		echo '<div class="updated fade"><p><strong>' . __( 'Key Updated!', 'gmaps-api-key' ) . '</strong></p></div>';

	}
	?>
	<div class="wrap">

		<h2><?php _e( 'Retro Add Google Maps API KEY', 'gmaps-api-key' ); ?></h2>
		<p><?php _e( 'This plugin will attempt to add your Google API KEY to any Google Maps JS file that has properly been enqueued.', 'gmaps-api-key' ); ?></p>
		<p>
			<?php $gm_api_url = 'https://console.developers.google.com/henhouse/?pb=["hh-1","maps_backend",null,[],"https://developers.google.com",null,["static_maps_backend","street_view_image_backend","maps_embed_backend","places_backend","geocoding_backend","directions_backend","distance_matrix_backend","geolocation","elevation_backend","timezone_backend","maps_backend"],null]';?>
			<a id="gd-api-key" onclick='window.open("<?php echo wp_slash($gm_api_url);?>", "newwindow", "width=600, height=400"); return false;' href='<?php echo $gm_api_url;?>' class="button-primary" name="<?php _e('Generate API Key - ( MUST be logged in to your Google account )','gmaps-api-key');?>" ><?php _e('Generate API Key','gmaps-api-key');?></a>

			<?php echo sprintf( __( 'or %sclick here%s to Get a Google Maps API KEY - ( MUST be logged in to your Google account )', 'gmaps-api-key' ), '<a target="_blank" href=\'https://console.developers.google.com/flows/enableapi?apiid=static_maps_backend,street_view_image_backend,maps_embed_backend,places_backend,geocoding_backend,directions_backend,distance_matrix_backend,geolocation,elevation_backend,timezone_backend,maps_backend&keyType=CLIENT_SIDE&reusekey=true\'>', '</a>' ) ?>
		</p>

		<form method="post" action="options-general.php?page=gmaps-api-key">
			<label for="rgmk_google_map_api_key"><?php _e( 'Enter Google Maps API KEY', 'gmaps-api-key' ); ?></label>
			<input title="<?php _e( 'Add Google Maps API KEY', 'gmaps-api-key' ); ?>" type="text"
			       name="rgmk_google_map_api_key" id="rgmk_google_map_api_key"
			       placeholder="<?php _e( 'Enter your API KEY here', 'gmaps-api-key' ); ?>"
			       style="padding: 6px; width:50%; display: block;"
			       value="<?php echo esc_attr( get_option( 'rgmk_google_map_api_key' ) ); ?>"/>

			<?php

			submit_button();

			?>
		</form>

	</div><!-- /.wrap -->
	<?php
}

/**
 * Add special offer banner on settings page.
 *
 * @since   1.1.0
 * @package GMAPIKEY
 */
function rgmk_show_geodirectory_offer() {
	if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'gmaps-api-key' ) {

		if ( defined( 'GEODIRECTORY_VERSION' ) || get_option( 'geodirectory_db_version' ) ) {
			return;
		}
		?>
		<div class="notice notice-info is-dismissible rgmk-offer-notice">
			<img src="<?php echo plugin_dir_url( __FILE__ ) . '/gd_banner.jpg'; ?>"/>
			<p><?php echo sprintf( __( 'API KEY for Google Maps was created for free by %sGeoDirecotry%s - The WordPress directory pluign. Discount Code: APIKEY25OFF', 'sample-text-domain' ), '<a target="_blank" href="https://wpgeodirectory.com/" >', '</a>' ); ?></p>
		</div>
		<?php
	}
}

add_action( 'admin_notices', 'rgmk_show_geodirectory_offer' );

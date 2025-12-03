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
 * Plugin URI: https://wpgeodirectory.com/
 * Description: Adds API KEY to Google maps calls if they have been enqueue correctly.
 * Version: 1.2.14
 * Author: AyeCode Ltd
 * Author URI: https://wpgeodirectory.com
 * Text Domain: gmaps-api-key
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.9
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
define( "GMAPIKEY_VERSION", "1.2.14" );


add_action( 'plugins_loaded', 'rgmk_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function rgmk_load_textdomain() {
	load_plugin_textdomain( 'gmaps-api-key', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

/**
 * Clean url.
 *
 * @param string $url Url.
 * @param string $original_url Original url.
 * @param string $_context Context.
 *
 * @return string Modified url.
 * @since   1.0.0
 * @package GMAPIKEY
 *
 */
function rgmk_find_add_key( $url, $original_url, $_context ) {
	$key = get_option( 'rgmk_google_map_api_key' );

	// If no key added no point in checking
	if ( ! $key ) {
		return $url;
	}

	// Check Google Maps API Url.
	if ( strstr( $url, "maps.google.com/maps/api/js" ) !== false || strstr( $url, "maps.googleapis.com/maps/api/js" ) !== false ) {
		if ( strstr( $url, "key=" ) === false ) {
			// Key not exists
			$url = str_replace( "&#038;", "&amp;", $url );
			$url = add_query_arg( 'key', esc_attr( $key ), $url );
			$url = str_replace( "&key=", "&amp;key=", $url );
		} else {
			// Key exists
			if ( strstr( $url, "key=" . $key ) === false ) {
				$url = str_replace( array( "&#038;", "&amp;key=" ), array( "&amp;", "&key=" ), $url );
				$url = remove_query_arg( 'key', $url );
				$url = add_query_arg( 'key', esc_attr( $key ), $url );
				$url = str_replace( "&key=", "&amp;key=", $url );
			}
		}

		// Since January 2023 Google made callback as a required parameter.
		if ( strstr( $url, "?callback=" ) === false && strstr( $url, "&callback=" ) === false && strstr( $url, ";callback=" ) === false ) {
			$url = str_replace( "&#038;", "&amp;", $url );
			$url = add_query_arg( 'callback', 'rgmkInitGoogleMaps', $url );
			$url = str_replace( "&callback=", "&amp;callback=", $url );
		}
	}

	return $url;
}
add_filter( 'clean_url', 'rgmk_find_add_key', 99, 3 );

/**
 * Add the admin menu link.
 *
 * @since   1.0.0
 * @package GMAPIKEY
 */
function rgmk_add_admin_menu() {
	add_submenu_page( 'options-general.php', 'Google API KEY', 'Google API KEY', 'manage_options', 'gmaps-api-key', 'rgmk_add_admin_menu_html' );
}
add_action( 'admin_menu', 'rgmk_add_admin_menu' );

/**
 * The html output for the settings page.
 *
 * @since   1.0.0
 * @since   1.1.0 Added button to generate API KEY from wp-admin.
 * @package GMAPIKEY
 */
function rgmk_add_admin_menu_html() {
	$updated = false;

	if ( isset( $_POST['rgmk_google_map_api_key'] ) && ! empty( $_POST['rgmk_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rgmk_nonce'] ) ), 'rgmk_save' ) && current_user_can( 'manage_options' ) ) {
		$key     = sanitize_text_field( wp_unslash( $_POST['rgmk_google_map_api_key'] ) );
		$updated = update_option( 'rgmk_google_map_api_key', $key );
	}

	if ( $updated ) {
		echo '<div class="updated fade"><p><strong>' . esc_html__( 'Key Updated!', 'gmaps-api-key' ) . '</strong></p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	$gm_api_url = 'https://console.cloud.google.com/apis/enableflow?apiid=maps_backend,static_maps_backend,street_view_image_backend,maps_embed_backend,places_backend,geocoding_backend,directions_backend,distance_matrix_backend,geolocation,elevation_backend,timezone_backend&keyType=CLIENT_SIDE&reusekey=true&pli=1';
	?>
	<div class="wrap">
		<h2><?php esc_html_e( 'Retro Add Google Maps API KEY', 'gmaps-api-key' ); ?></h2>
		<p><?php esc_html_e( 'This plugin will attempt to add your Google API KEY to any Google Maps JS file that has properly been enqueued.', 'gmaps-api-key' ); ?></p>
		<form method="post" action="options-general.php?page=gmaps-api-key">
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="gd-api-key"><?php esc_html_e( 'Generate API Key', 'gmaps-api-key' ); ?></label></th>
					<td><a id="gd-api-key" onclick='window.open("<?php echo wp_slash( $gm_api_url );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>", "newwindow", "width=600, height=400"); return false;' href="<?php echo esc_url( $gm_api_url ); ?>" class="button-primary" name="<?php esc_attr_e( 'Generate API Key - ( MUST be logged in to your Google account )', 'gmaps-api-key' ); ?>"><?php esc_html_e( 'Generate API Key', 'gmaps-api-key' ); ?></a><p class="description"><?php esc_html_e( 'MUST be logged in to your Google account', 'gmaps-api-key' ); ?></p></td>
				</tr>
				<tr>
					<th scope="row"><label for="rgmk_google_map_api_key"><?php esc_html_e( 'Google Maps API KEY', 'gmaps-api-key' ); ?></label></th>
					<td><input type="text" name="rgmk_google_map_api_key" id="rgmk_google_map_api_key" class="regular-text" title="<?php esc_html_e( 'Add Google Maps API KEY', 'gmaps-api-key' ); ?>" placeholder="<?php echo esc_attr__( 'Enter your API KEY here', 'gmaps-api-key' ); ?>" value="<?php echo esc_attr( get_option( 'rgmk_google_map_api_key' ) ); ?>"><?php wp_nonce_field( 'rgmk_save', 'rgmk_nonce' ); ?><p class="description"><?php esc_html_e( 'Enter the Google Maps API Key.', 'gmaps-api-key' ); ?></p></td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
		</form>
	</div><!-- /.wrap -->
	<div class="">
		<hr/>
		<br>
		<a target="_blank" href="https://mapfix.dev/" class="button button-primary button-hero"><?php esc_html_e( 'Check for API key errors', 'gmaps-api-key' ); ?> <span class="dashicons dashicons-external" style="line-height: 2;"></span></a>
	</div>
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
		if ( defined( 'GEODIRECTORY_VERSION' ) ) {
			// do nothing
		} else {
			?>
			<div class="notice notice-info is-dismissible rgmk-offer-notice">
				<img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '/gd_banner.jpg' ); ?>"/>
				<p><?php
				/* translators: 1: link open tag, 2: link close tag. */
				echo wp_sprintf( __( 'API KEY for Google Maps was created for free by %1$sGeoDirectory%2$s - The WordPress directory plugin. Discount Code: APIKEY25OFF', 'gmaps-api-key' ), '<a target="_blank" href="https://wpgeodirectory.com/" >', '</a>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			</div>
			<?php
		}
	}
}

add_action( 'admin_notices', 'rgmk_show_geodirectory_offer' );

/**
 * Add Google Maps API callback script to head.
 *
 * @since 1.2.4
 */
function rgmk_add_callback_script() {
	$script = '<script type="text/javascript">function rgmkInitGoogleMaps(){window.rgmkGoogleMapsCallback=true;try{jQuery(document).trigger("rgmkGoogleMapsLoad")}catch(err){}}</script>';

	/**
	 * Filters the Google Maps JavaScript callback.
	 *
	 * @since 2.2.23
	 *
	 * @param string $script The callback script.
	 */
	$script = apply_filters( 'rgmk_google_map_callback_script', $script );

	echo $script; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'rgmk_add_callback_script', 1 );
add_action( 'admin_head', 'rgmk_add_callback_script', 1 );
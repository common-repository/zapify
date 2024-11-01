<?php
/**
 *
 * Zapify
 *
 * Transform your WordPress experience by automating repetitive tasks effortlessly.
 *
 * @link      http://wordpress.org/plugins/zapify
 * @author    KaizenCoders <hello@kaizencoders.com>
 * @license   GPL-2.0+
 * @package   Zapify
 * @copyright 2024 KaizenCoders
 *
 * @wordpress-plugin
 * Plugin Name:       Zapify
 * Plugin URI:        https://kaizencoders.com/zapify
 * Description:       Transform your WordPress experience by automating repetitive tasks effortlessly.
 * Version:           1.0.3
 * Author:            KaizenCoders
 * Author URI:        https://kaizencoders.com
 * Tested up to:      6.6.2
 * Requires PHP:      5.6
 * Text Domain:       zapify
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

if ( ! function_exists( 'kaizencoders_zapify_fail_php_version_notice' ) ) {

	/**
	 * Admin notice for minimum PHP version.
	 *
	 * Warning when the site doesn't have the minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function kaizencoders_zapify_fail_php_version_notice() {
		/* translators: %s: PHP version */
		$message      = sprintf( esc_html__( 'Zapify requires PHP version %s+, plugin is currently NOT RUNNING.',
			'zapify' ), '5.6' );
		$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
		echo wp_kses_post( $html_message );
	}
}

if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {

	add_action( 'admin_notices', 'kaizencoders_zapify_fail_php_version_notice' );

	return;
}

if ( ! defined( 'KAIZENCODERS_ZAPIFY_PLUGIN_VERSION' ) ) {
	define( 'KAIZENCODERS_ZAPIFY_PLUGIN_VERSION', '1.0.3' );
}

// Plugin Folder Path.
if ( ! defined( 'KAIZENCODERS_ZAPIFY_PLUGIN_DIR' ) ) {
	define( 'KAIZENCODERS_ZAPIFY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'KAIZENCODERS_ZAPIFY_PLUGIN_BASE_NAME' ) ) {
	define( 'KAIZENCODERS_ZAPIFY_PLUGIN_BASE_NAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'KAIZENCODERS_ZAPIFY_PLUGIN_FILE' ) ) {
	define( 'KAIZENCODERS_ZAPIFY_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'KAIZENCODERS_ZAPIFY_PLUGIN_URL' ) ) {
	define( 'KAIZENCODERS_ZAPIFY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'KAIZENCODERS_ZAPIFY_HIDE_ADMIN_BAR' ) ) {
	define( 'KAIZENCODERS_ZAPIFY_HIDE_ADMIN_BAR', false );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in lib/Activator.php
 */
\register_activation_hook( __FILE__, '\KaizenCoders\Zapify\Activator::activate' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in lib/Deactivator.php
 */
\register_deactivation_hook( __FILE__, '\KaizenCoders\Zapify\Deactivator::deactivate' );


if ( ! function_exists( 'kaizencoders_zapify' ) ) {
	/**
	 * Initialize.
	 *
	 * @since 1.0.0
	 */
	function kaizencoders_zapify() {
		return \KaizenCoders\Zapify\Plugin::instance();
	}
}

add_action( 'plugins_loaded', function () {
	kaizencoders_zapify()->run();
} );

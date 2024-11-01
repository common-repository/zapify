<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       https://kaizencoders.com
 * @since      1.0.0
 *
 * @package    Zapify
 * @subpackage Zapify/admin
 */

namespace KaizenCoders\Zapify;

use KaizenCoders\Zapify\Admin\Activity_Logs_Table;
use KaizenCoders\Zapify\Helper;

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Zapify
 * @subpackage Zapify/admin
 * @author     KaizenCoders <hello@kaizencoders.com>
 */
class Admin {
	/**
	 * The plugin's instance.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    Plugin $plugin This plugin's instance.
	 */
	private $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param  Plugin  $plugin  This plugin's instance.
	 *
	 * @since 1.0.0
	 *
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Zapify_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Zapify_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( Helper::is_plugin_admin_screen() ) {

			\wp_enqueue_style(
				'zapify-app',
				\plugin_dir_url( __DIR__ ) . 'dist/styles/app.css',
				[],
				$this->plugin->get_version(),
				'all'
			);
		}

		\wp_enqueue_style(
			'zapify-admin',
			\plugin_dir_url( __DIR__ ) . 'dist/styles/zapify-admin.css',
			[],
			$this->plugin->get_version(),
			'all'
		);

		if ( KAIZENCODERS_ZAPIFY_HIDE_ADMIN_BAR ) {
			\wp_enqueue_style(
				'zapify-main',
				\plugin_dir_url( __DIR__ ) . 'dist/styles/zapify-main.css',
				[],
				$this->plugin->get_version(),
				'all'
			);
		}
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
	}

	public function add_admin_menu() {
		add_menu_page(
			__( 'Zapify', 'zapify' ),
			__( 'Zapify', 'zapify' ),
			'manage_options',
			'zapify',
			[
				$this,
				'render_dashboard',
			],
			'',
			30
		);


		do_action( 'kaizencoders_zapify_admin_menu' );
	}

	public function render_dashboard() {
		include_once KAIZENCODERS_ZAPIFY_ADMIN_TEMPLATES_DIR . '/landing.php';
	}
}

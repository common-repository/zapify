<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       https://kaizencoders.com
 * @since      1.0.0
 *
 * @package    Zapify
 * @subpackage Zapify/includes
 */

namespace KaizenCoders\Zapify;

use KaizenCoders\Zapify\Activity\User\Login;
use KaizenCoders\Zapify\DB\DB;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Zapify
 * @subpackage Zapify/includes
 * @author     KaizenCoders <hello@kaizencoders.com>
 */
class Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Zapify_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $Zapify The string used to uniquely identify this plugin.
	 */
	protected $plugin_name = 'Zapify';

	/**
	 * True instance of a class.
	 *
	 * @since 1.0.0
	 *
	 * @var null
	 */
	public static $instance = null;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version = '1.0.0';

	/**
	 * @var Object|DB
	 */
	public $db = null;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $version = '' ) {
		$this->version = $version;
		$this->loader  = new Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new I18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );
		$plugin_i18n->load_plugin_textdomain();
	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Admin( $this );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Zapify_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Init Classes
	 *
	 * @since 1.0.0
	 */
	public function init_classes() {

		$classes = [
			'KaizenCoders\Zapify\Activities\User\Login',
			'KaizenCoders\Zapify\Install',
		];

		foreach ( $classes as $class ) {
			$this->loader->add_class( $class );
		}
	}

	public function define_constants() {
		/* @const  KAIZENCODERS_ZAPIFY_ADMIN_TEMPLATES_DIR */
		if ( ! defined( 'KAIZENCODERS_ZAPIFY_ADMIN_TEMPLATES_DIR' ) ) {
			define( 'KAIZENCODERS_ZAPIFY_ADMIN_TEMPLATES_DIR',
				KAIZENCODERS_ZAPIFY_PLUGIN_DIR . 'lite/includes/Admin/Templates' );
		}
	}

	public function load_dependencies() {
	}

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Plugin ) ) {
			self::$instance = new Plugin( KAIZENCODERS_ZAPIFY_PLUGIN_VERSION );

			self::$instance->define_constants();
			self::$instance->load_dependencies();
			self::$instance->set_locale();
			self::$instance->define_admin_hooks();
			self::$instance->init_classes();
		}

		return self::$instance;
	}
}

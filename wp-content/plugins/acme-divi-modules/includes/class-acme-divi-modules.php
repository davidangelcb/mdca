<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://acmemk.com
 * @since      1.0.0
 *
 * @package    Acme_Divi_Modules
 * @subpackage Acme_Divi_Modules/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Acme_Divi_Modules
 * @subpackage Acme_Divi_Modules/includes
 * @author     Mirko Bianco <mirko@acmemk.com>
 */
class Acme_Divi_Modules {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Acme_Divi_Modules_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'acme-divi-modules';
		$this->version = '1.3.4';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Acme_Divi_Modules_Loader. Orchestrates the hooks of the plugin.
	 * - Acme_Divi_Modules_i18n. Defines internationalization functionality.
	 * - Acme_Divi_Modules_Admin. Defines all hooks for the admin area.
	 * - Acme_Divi_Modules_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acme-divi-modules-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-acme-divi-modules-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acme-divi-modules-admin.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-acme-divi-modules-public.php';

		$this->loader = new Acme_Divi_Modules_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Acme_Divi_Modules_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Acme_Divi_Modules_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Acme_Divi_Modules_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'et_builder_ready', $plugin_admin, 'ACME_Module_Portfolio' );
		$this->loader->add_action( 'et_builder_ready', $plugin_admin, 'ACME_Module_Carousel_Portfolio' );
		$this->loader->add_action( 'et_builder_ready', $plugin_admin, 'ACME_Module_Blog' );
		$this->loader->add_action( 'et_builder_ready', $plugin_admin, 'ACME_Module_Slide_In' );

		$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'set_new_image_size', 11 );

		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		//AJAX Action hooks
		$this->loader->add_action( 'wp_ajax_abmp_get_terms_html', $plugin_admin, 'append_abmp_preset' );
		$this->loader->add_action( 'wp_ajax_abmp_get_taxonomies', $plugin_admin, 'get_taxonomies' );

		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		// Define Admin Filters
		$this->loader->add_filter( 'acme_debug', $plugin_admin, 'run_debug', 10, 3 );
		$this->loader->add_filter( 'acme_drop_data', $plugin_admin, 'drop_plugin_data', 10 );
		$this->loader->add_filter( 'acme_get_post_types', $plugin_admin, 'get_post_types', 10, 2 );
		$this->loader->add_filter( 'acme_get_taxonomies', $plugin_admin, 'get_taxonomies', 10, 2 );
		$this->loader->add_filter( 'acme_get_terms', $plugin_admin, 'get_terms' );

		//Extend Page Builder Filter
		$this->loader->add_filter( 'et_builder_post_types', $plugin_admin, 'adm_et_builder_post_types', 20, 1 );

		// Save/Update our plugin options
		$this->loader->add_action( 'admin_init', $plugin_admin, 'options_update' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'abmb_options_update' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'abmp_options_update' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'abmsi_options_update' );

		$this->loader->add_filter ( 'et_project_posttype_rewrite_args', $plugin_admin, 'replace_project_slug', 10, 2 );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Acme_Divi_Modules_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');


		$plugin_admin = new Acme_Divi_Modules_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'set_new_image_size', 11 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
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
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Acme_Divi_Modules_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

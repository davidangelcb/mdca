<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://acmemk.com
 * @since      1.0.0
 *
 * @package    Acme_Divi_Modules
 * @subpackage Acme_Divi_Modules/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Acme_Divi_Modules
 * @subpackage Acme_Divi_Modules/public
 * @author     Mirko Bianco <mirko@acmemk.com>
 */
class Acme_Divi_Modules_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->adm_options = get_option( $this->plugin_name );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Acme_Divi_Modules_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Acme_Divi_Modules_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/acme-divi-modules-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/acme-divi-modules-apt.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Acme_Divi_Modules_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Acme_Divi_Modules_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$masonry = $this->plugin_name . '-masonry';
		wp_register_script($this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/acme-divi-modules-public.js', array( 'jquery','et-builder-modules-script', $masonry ), $this->version, true);
		wp_register_script( $masonry, plugin_dir_url( __FILE__ ) . 'js/masonry.pkgd.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $masonry );
		wp_enqueue_script( $this->plugin_name );
	}

}

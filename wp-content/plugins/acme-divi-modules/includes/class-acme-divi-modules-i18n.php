<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://acmemk.com
 * @since      1.0.0
 *
 * @package    Acme_Divi_Modules
 * @subpackage Acme_Divi_Modules/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Acme_Divi_Modules
 * @subpackage Acme_Divi_Modules/includes
 * @author     Mirko Bianco <mirko@acmemk.com>
 */
class Acme_Divi_Modules_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'acme-divi-modules',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

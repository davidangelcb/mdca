<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://acmemk.com
 * @since             1.0.0
 * @package           Acme_Divi_Modules
 *
 * @wordpress-plugin
 * Plugin Name:       ACME Divi Modules
 * Plugin URI:        http://acmemk.com/acme-divi-modules
 * Description:       This plugin add some extra modules to Divi Builder
 * Version:           1.3.4
 * Author:            Mirko Bianco
 * Author URI:        http://acmemk.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acme-divi-modules
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-acme-divi-modules-activator.php
 */
function activate_acme_divi_modules() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-acme-divi-modules-activator.php';
	Acme_Divi_Modules_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-acme-divi-modules-deactivator.php
 */
function deactivate_acme_divi_modules() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-acme-divi-modules-deactivator.php';
	Acme_Divi_Modules_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_acme_divi_modules' );
register_deactivation_hook( __FILE__, 'deactivate_acme_divi_modules' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-acme-divi-modules.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_acme_divi_modules() {

	$plugin = new Acme_Divi_Modules();
	$plugin->run();

}
run_acme_divi_modules();

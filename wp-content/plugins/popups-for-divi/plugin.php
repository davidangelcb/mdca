<?php
/**
 * Plugin Name: Popups for Divi
 * Plugin URI:  https://philippstracker.com/divi-popup/
 * Description: Finally a simple and intuitive way to add custom popups to your divi pages!
 * Author:      Philipp Stracker
 * Author URI:  https://philippstracker.com/
 * Created:     30.12.2017
 * Version:     1.2.3
 * License:     GPLv2 or later
 * Text Domain: divi-popup
 * Domain Path: /lang
 * ----------------------------------------------------------------------------
 */

/**
 * Copyright (c) 2017-2018 Philipp Stracker. All rights reserved.
 *
 * Released under the GPLv2 license
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * ****************************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * ****************************************************************************
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'EVR_DIVI_POPUP_PLUGIN', plugin_basename( __FILE__ ) );

/**
 * A new version value will force refresh of CSS and JS files for all users.
 */
define( 'EVR_DIVI_POPUP_VERSION', '1.2.3' );

add_action(
	'plugins_loaded',
	'divi_popup_load_plugin_textdomain'
);

/**
 * Add multilanguage support for the plugin.
 *
 * @since  1.0.0
 */
function divi_popup_load_plugin_textdomain() {
	load_plugin_textdomain(
		'popups-for-divi',
		false,
		dirname( EVR_DIVI_POPUP_PLUGIN ) . '/lang/'
	);
}

include 'include/class-evr-divi-popup.php';

global $divi_popup;
$divi_popup = new Evr_Divi_Popup();

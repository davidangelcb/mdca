<?php
/**
 * Divi Popups
 * Main plugin instance/controller. The main popup logic is done in javascript,
 * so we mainly need to make sure that our JS/CSS is loaded on the correctly.
 *
 * @package Evr_Divi_Popup
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Set up our popup integration.
 */
class Evr_Divi_Popup {

	/**
	 * Hook up the module.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {
		add_action(
			'wp_enqueue_scripts',
			array( $this, 'enqueue_scripts' )
		);

		add_filter(
			'plugin_action_links_' . EVR_DIVI_POPUP_PLUGIN,
			array( $this, 'plugin_add_settings_link' )
		);
	}

	/**
	 * Display a custom link in the plugins list
	 *
	 * @since  1.0.2
	 * @param  array $links List of plugin links.
	 * @return array New list of plugin links.
	 */
	public function plugin_add_settings_link( $links ) {
		$links[] = sprintf(
			'<a href="%s" target="_blank">%s</a>',
			'https://philippstracker.com/divi-popup/',
			__( 'How it works', 'divi-popup' )
		);
		return $links;
	}

	/**
	 * Add the CSS/JS support to the front-end to make the popups work.
	 *
	 * @since  1.0.0
	 */
	public function enqueue_scripts() {
		if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
			return;
		}
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		if ( isset( $_GET['et_pb_preview'] ) && isset( $_GET['et_pb_preview_nonce'] ) ) {
			return;
		}
		$cache_version = EVR_DIVI_POPUP_VERSION;

		if ( function_exists( 'et_fb_is_enabled' ) ) {
			$is_divi_v3 = true;
			add_filter( 'evr_divi_popup-build_mode', 'et_fb_is_enabled' );
		} else {
			$is_divi_v3 = false;
		}

		$js_data = apply_filters(
			'evr_divi_popup-js_data',
			array(
				/**
				 * CSS selector used to identify popups.
				 * Each popup must also have a unique ID attribute that
				 * identifies the individual popups.
				 */
				'popupSelector' => '.popup',

				/**
				 * All popups are wrapped in a new div element. This is the
				 * class name of this wrapper div.
				 *
				 * @since  1.2.0
				 */
				'popupWrapperClass' => 'popup_outer_wrap',

				/**
				 * CSS class that is added to the popup when it enters
				 * full-width mode (i.e. on small screens)
				 */
				'fullWidthClass' => 'popup_full_width',

				/**
				 * CSS class that is added to the popup when it enters
				 * full-height mode (i.e. on small screens)
				 */
				'fullHeightClass' => 'popup_full_height',

				/**
				 * CSS class that is added to the website body when at least
				 * one popup is visible.
				 */
				'openPopupClass' => 'evr_popup_open',

				/**
				 * CSS class that is added to the modal overlay that is
				 * displayed while at least one popup is visible.
				 */
				'overlayClass' => 'evr_fb_popup_modal',

				/**
				 * Class that indicates a modal popup. A modal popup can only
				 * be closed via a close button, not by clicking on the overlay.
				 */
				'modalIndicatorClass' => 'is-modal',

				/**
				 * Class that adds an exit-intent trigger to the popup.
				 * The exit intent popup is additionally triggered, when the
				 * mouse pointer leaves the screen towards the top.
				 * It's only triggered once.
				 */
				'exitIndicatorClass' => 'on-exit',

				/**
				 * This class is added to the foremost popup; this is useful to
				 * hide/fade popups in the background.
				 *
				 * @since  1.1.0
				 */
				'activePopupClass' => 'is-open',

				/**
				 * This changes the default close-button state when a popup does
				 * not specify noCloseClass or withCloseClass
				 *
				 * @since  1.1.0
				 */
				'defaultShowCloseButton' => true,

				/**
				 * Add this class to the popup section to hide the close button
				 * in the top right corner.
				 *
				 * @since  1.1.0
				 */
				'noCloseClass' => 'no-close',

				/**
				 * Add this class to the popup section to show the close button
				 * in the top right corner.
				 *
				 * @since  1.1.0
				 */
				'withCloseClass' => 'with-close',

				/**
				 * This is the class-name of the close button that is
				 * automatically added to the popup. Only change this, if you
				 * want to use existing CSS or when the default class causes a
				 * conflict with your existing code.
				 *
				 * Note: The button is wrapped in a span which gets the class-
				 *       name `closeButtonClass + "_wrap"` e.g. "evr-close_wrap"
				 *
				 * @since  1.1.0
				 */
				'closeButtonClass' => 'evr-close',

				/**
				 * Alternate popup trigger, e.g. 'data-popup' for
				 * <span data-popup="my-popup-id">Click here</span>
				 */
				'idAttrib' => 'data-popup',

				/**
				 * The base z-index. This z-index is used for the overlay, every
				 * popup has a z-index increased by 1:
				 */
				'zIndex' => 100000,

				/**
				 * Speed of the fade-in/out animations.
				 */
				'animateSpeed' => 400,

				/**
				 * Display debug output in the JS console.
				 */
				'debug' => false,

				/**
				 * Whether to wait for an JS event-trigger before initializing
				 * the popup module in front end. This is automatically set
				 * for the Divi theme.
				 *
				 * @since 1.2.0
				 */
				'initializeOnEvent' => ($is_divi_v3 ?
					'et_pb_after_init_modules' : // Divi 3.x
					false // Older Divi / other themes
				),
			)
		);

		if ( apply_filters( 'evr_divi_popup-build_mode', false ) ) {
			$inline_css = '';
			$base_name = 'builder';
		} else {
			$inline_css = sprintf(
				'.et_pb_section%s{display:none}',
				$js_data['popupSelector']
			);
			$base_name = 'front';
		}

		if ( $js_data['debug'] ) {
			$cache_version .= '-' . time();
		}

		wp_register_script(
			'js-divi-popup',
			plugins_url( 'js/' . $base_name . '.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			$cache_version,
			true
		);

		wp_register_style(
			'css-divi-popup',
			plugins_url( 'css/' . $base_name . '.css', dirname( __FILE__ ) ),
			array(),
			$cache_version,
			'all'
		);

		wp_localize_script( 'js-divi-popup', 'DiviPopupData', $js_data );

		wp_enqueue_script( 'js-divi-popup' );
		wp_enqueue_style( 'css-divi-popup' );

		if ( $inline_css ) {
			wp_add_inline_style( 'css-divi-popup', $inline_css );
		}
	}
}

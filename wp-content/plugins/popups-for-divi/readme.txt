=== Popups for Divi ===
Contributors: stracker.phil
Tags: popup, marketing, divi
Requires at least: 3.0.1
Tested up to: 4.9.8
Requires PHP: 5.2.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A quick and easy way to create Popup layers with the Divi visual builder.

== Description ==

No configuration needed. Simply activate the plugin and add the CSS class "popup" and ID tag to a divi section. To open the popup you only need to place a link on the page with the URL pointing to the section ID.

Example:

1. Edit a section and set the ID to "newsletter-optin" and CSS class to "popup"
2. Add a link (or button, etc) on the page with the URL "#newsletter-optin"
3. All done, save the page! When a visitor clicks on your new link the popup will be opened.

You can find more details, examples and full documentation here:

* [Plugin website (English)](https://philippstracker.com/divi-popup-en/)
* [Plugin website (German)](https://philippstracker.com/divi-popup/)

== Installation ==

Install the plugin from the WordPress admin page "Plugins > Install"

or

1. Upload `popups-for-divi` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How much performance does Popups for Divi need? =

Actually none! We designed it with maximum page performance in mind. Our tests did show literally no change in page loading speed.

The plugin will add a single line of CSS to the page output and load one JS and CSS file that currently are about 7 kb in size and are cached by the browser after first page load.

= Is Popups for Divi compatible with Caching plugins? =

Yes, absolutely! There is no dynamic logic in the PHP code like other popup plugins have. Popups for Divi is a little bit of PHP but the main logic sits inside the small javascript library it provides. It works on the client side, and therefore is not restricted by caching plugins.

= Is this plugin compatible with every Divi version? =

This plugin is kept compatible with the latest Divi release.

We did test it with all releases since the initial Divi 3.0 release. Possibly it will also work with older versions, but it is not confirmed yet.

= Does this plugin also work with other themes/site builders? =

Yes, actually it will! But out of the box it is designed to work with Divi. If you use any other theme or site builder then you need to change the default options of the plugin via the `evr_divi_popup-js_data` filter.

For more details visit https://philippstracker.com/divi-popup/

== Screenshots ==

(coming soon)

== Changelog ==

= 1.2.3 =
* Fix jQuery "invalid expression" error on some sites.

= 1.2.2 =
* Fix compatibility issues with Divi 3.1.16 and higher.
* Add backwards compatibility for php 5.2.4 - before this, the plugin required php 5.4 or higher.

= 1.2.1 =
* Improve: Faster and smoother handling of popup resizing, without an interval timer!
* Added Javascript event: $('.popup').on('DiviPopup:Init', ...)
* Added Javascript event: $('.popup').on('DiviPopup:Show', ...)
* Added Javascript event: $('.popup').on('DiviPopup:Hide', ...)
* Added Javascript event: $('.popup').on('DiviPopup:Blur', ...)
* Added Javascript event: $('.popup').on('DiviPopup:Focus', ...)

= 1.2.0 =
* Feature: Popups now support Divi loading animations!
* Improve: Popups will now correctly limit the size after the contents are changed, e.g. when accordeon is expanded.
* Bugfix: The Popups For Divi plugin now waits until Divi could initialize all components, before creating popups.

= 1.1.0 =
* Feature: Yay! All Popups now have a close-button in the top-right corner by default.
* Feature: Pressing the escape key will now close the currently open popup.
* Improve: The active popup now has an additional CSS class `is-open` that can be used for styling inactive popups.
* Improve: CSS and JS code is now minified.

Thanks for your feedback and all the positive comments we received so far. You are awesome :)

= 1.0.3 =
* Improve: Apply custom modules styles to elements inside popup
* Fix: Correct popup preview in visual builder

= 1.0.2.3 =
* Minor: Fixes in the readme.txt and naming of assets/language files

= 1.0.2 =
* Minor: Added link to the plugin documentation inside the plugins list
* Minor: Make plugin translateable

= 1.0.1 =
* Added: Support for lazy-load plugin

= 1.0 =
* Initial public release
* Added trigger: Click
* Added trigger: `on-exit`
* Added JavaScript API: DiviPopup.openPopup()
* Added JavaScript API: DiviPopup.closePopup()
* Added JavaScript API: DiviPopup.showOverlay()
* Added JavaScript API: DiviPopup.hideOverlay()
* Added WordPress filter: `evr_divi_popup-js_data`

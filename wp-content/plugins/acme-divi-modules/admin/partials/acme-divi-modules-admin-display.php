<?php
	/**
	 * Provide a admin area view for the plugin
	 *
	 * This file is used to markup the admin-facing aspects of the plugin.
	 *
	 * @link       http://acmemk.com
	 * @since      1.0.0
	 *
	 * @package    Acme_Divi_Modules
	 * @subpackage Acme_Divi_Modules/admin/partials
	 */

	$error_msg = null;

	if ( ! isset( $plugin_data ) ) {
		$plugin_data      = apply_filters( 'acme_drop_data', null );
		$plugin_name      = $plugin_data['plugin_name'];
		$abmp_options       = $plugin_data['abmp_options'];
		$options_presets = isset( $ambp_options['abmp_presets'] ) ? explode( ',', $abmp_options['abmp_presets'] ) : null;
	}

	if ( false == $plugin_data['divi_exists'] ) {
		$error_msg = sprintf(__( 'Divi Builder is not installed. Don\'t panic, you can still download it %shere%s.', $this->plugin_name ),'<a href="http://elegantthemes.com/" target="_blank">','</a>');
	}

?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<?php if (null!==$error_msg): ?>
		<div class="notice notice-error"><p><?php echo $error_msg ?></p></div>
		<?php ?>
	<?php else: ?>

<div id="tabs">
	<ul>
		<li><a href="#adm_main_settings"><?php _e('Basic Settings',$plugin_name); ?></a></li>
		<li><a href="#adm_abmb_settings"><?php _e('Extended Blog Module',$plugin_name); ?></a></li>
		<li><a href="#adm_abmp_settings"><?php _e('Extended Portfolio',$plugin_name); ?></a></li>
		<li><a href="#adm_abmsi_settings"><?php _e('Slide In Module',$plugin_name); ?></a></li>
	</ul>
	<!-- Content for the main settings tab -->
	<div id="adm_main_settings">
		<?php include('acme-divi-modules-admin-display-options.php'); ?>
	</div>
	<!-- Content for the abmb tab -->
	<div id="adm_abmb_settings">
		<?php include('acme-divi-modules-admin-display-abmb-main-form.php'); ?>
	</div>
	<!-- Content for the abmp tab -->
	<div id="adm_abmp_settings">
		<?php include('acme-divi-modules-admin-display-abmp-main-form.php'); ?>
	</div>
	<!-- Content for the abmsi tab -->
	<div id="adm_abmsi_settings">
		<?php include('acme-divi-modules-admin-display-abmsi-main-form.php'); ?>
	</div>
</div>
	<?php endif ?>
</div>

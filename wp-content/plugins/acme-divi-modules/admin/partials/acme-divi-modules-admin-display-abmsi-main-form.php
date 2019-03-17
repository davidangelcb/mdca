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

	$plugin_data     = apply_filters( 'acme_drop_data', null );
	$plugin_name     = $plugin_data['plugin_name'];
	$abmsi_options    = $plugin_data['abmsi_options'];
	//$options_presets = explode( ',', $abmp_options['abmp_presets'] );

	$settings_base_name = $plugin_name . '-abmsi';

	//My Options
	$enabled = $abmsi_options['abmsi_enabled'];

?>
<div class="notice notice-warning hidden save-reminder"><p><?php _e( 'Please click Save to apply changes.', $plugin_name ); ?></p></div>
<form method="post" name="acme_extended_portfolio_options" action="options.php">
	<?php
		settings_fields( $settings_base_name );
		do_settings_sections( $settings_base_name );

	?>

	<h2><?php _e('Slide In Module', $plugin_name); ?></h2>
	<fieldset>
		<legend class="screen-reader-text"><span><?php _e('Enable',$plugin_name); ?></span></legend>
		<label for="<?php echo $settings_base_name; ?>-abmsi_enabled">
			<input type="checkbox" id="<?php echo $settings_base_name; ?>-abmsi_enabled"
			       name="<?php echo $settings_base_name; ?>[abmsi_enabled]" value=1 <?php checked($enabled, 1); ?>/>
			<span><?php _e('Enable',$plugin_name); ?></span>
		</label>
	</fieldset>
	<em class="acme-tooltip"><?php _e('Acme Slide In Module will create a nice slide-in prompt box for your site. Based on Elegant Themes website slide in and on <a href="https://divilife.com/creating-slide-in-promo-bar-in-divi/" target="_blank">Divi Life tutorial</a>',$plugin_name);?></em>
	<?php submit_button( __('Save all changes',$plugin_name), 'primary', 'submit', true ); ?>
</form>

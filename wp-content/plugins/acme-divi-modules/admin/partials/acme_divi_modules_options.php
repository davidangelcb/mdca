<?php
/**
 * Created by PhpStorm.
 * User: hank
 * Date: 12/11/16
 * Time: 16.27
 */

	$plugin_data  = apply_filters( 'acme_drop_data', null );
	$plugin_name  = $plugin_data['plugin_name'];
	$main_options = $plugin_data['main_options'];

	$settings_base_name = $plugin_name;

	//My Options
	$slug = $main_options['slug'];

	?>

<form method="post" name="acme_extended_portfolio_options" action="options.php">
	<?php
		settings_fields( $settings_base_name );
		do_settings_sections( $settings_base_name );

	?>

	<h2><?php _e('Change Project Slug', $plugin_name); ?></h2>
	<fieldset>
		<legend class="screen-reader-text"><span><?php _e( 'New project slug name:', $plugin_name ); ?></span></legend>
		<label for="<?php echo $settings_base_name;?>-slug"><?php _e( 'New project slug name:', $plugin_name );?>
			<input type="text" class="regular-text" id="<?php echo $settings_base_name; ?>-slug"
			       name="<?php echo $settings_base_name?>[slug]" value="<?php echo $slug; ?>">
			<em class="acme-tooltip"><?php _e( 'This option will change the url slug used by Divi Project taxonomy. It won\'t change taxonomy and it is not translatable.', $plugin_name );?></em>
		</label>
	</fieldset>

	<?php submit_button( __('Save all changes',$plugin_name), 'primary', 'submit', true ); ?>

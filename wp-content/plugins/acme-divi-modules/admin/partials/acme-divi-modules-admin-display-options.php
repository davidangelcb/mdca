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

	/**
	 * Recall global variable for additional image sizes
	 */
	global $_wp_additional_image_sizes;

	$plugin_data  = apply_filters( 'acme_drop_data', null );
	$plugin_name  = $plugin_data['plugin_name'];
	$main_options = $plugin_data['main_options'];

	$settings_base_name = $plugin_name;

	$post_types_array = apply_filters( 'acme_get_post_types', false );
	//My Options
	$adm_slug = $main_options['adm_slug'];
	$excluded_post_types = array( 'post', 'project' );
	$et_images = $plugin_data['et_images'];


	/**
	 * Get actual image sizes
	 */
	foreach ( array_keys($et_images) as $myImg ) {
		$actual_size[ $myImg ] = sprintf( '%dx%d - %s',
			$_wp_additional_image_sizes[ $myImg ]['width'],
			$_wp_additional_image_sizes[ $myImg ]['height'],
			true == $_wp_additional_image_sizes[ $myImg ]['crop'] ? 'crop' : 'no-crop'
		);
	}

?>

<form method="post" name="acme_divi_modules_options" action="options.php">
	<?php
		settings_fields( $settings_base_name );
		do_settings_sections( $settings_base_name );

	?>

	<h2><?php _e('Change Project Slug', $plugin_name); ?></h2>
	<fieldset>
		<legend class="screen-reader-text"><span><?php _e( 'New project slug name:', $plugin_name ); ?></span></legend>
		<label for="<?php echo $settings_base_name;?>-adm_slug"><?php _e( 'New project slug name:', $plugin_name );?>
			<input type="text" class="regular-text" id="<?php echo $settings_base_name; ?>-adm_slug"
			       name="<?php echo $settings_base_name?>[adm_slug]" value="<?php echo $adm_slug; ?>">
			<em class="acme-tooltip"><?php _e( 'This option will change the url slug used by Divi Project taxonomy. It won\'t change taxonomy and it is not translatable. After changing this value you should open permalinks menu and save.', $plugin_name );?></em>
		</label>
	</fieldset>
	<hr>
	<?php if(is_array($post_types_array)&&count($post_types_array)>count($excluded_post_types)): ?>
		<h2><?php _e('Extend Page Builder to additional Post Types:', $plugin_name); ?></h2>
		<?php foreach($post_types_array as $post_type): ?>
			<?php if(!in_array($post_type,$excluded_post_types)): ?>
				<?php $curID='adm_use_pb_' . $post_type;?>
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo $post_type; ?></span></legend>
					<label for="<?php echo "$settings_base_name-$curID";?>">
						<input type="checkbox" id="<?php echo "$settings_base_name-$curID";?>"
						       name="<?php echo $settings_base_name.'['.$curID.']'?>" value=1 <?php checked($main_options[$curID], 1); ?>/>
						<span><?php echo $post_type; ?></span>
					</label>
				</fieldset>
			<?php endif ?>
		<?php endforeach; ?>
		<?php if(isset($curID)): ?>
			<em class="acme-tooltip"><?php _e( 'Here you can choose to extend the Divi Builder functionality to your additional post types. As Elegant Themes reports: it’s important to note that this method will not work with every single custom post type out there. Or with every third party plugin using custom post types.', $plugin_name );?></em>
		<?php endif; ?>
	<?php endif; ?>

	<hr>

	<h2><?php _e('Change Divi Image size/ratio', $plugin_name); ?></h2>
	<em class="acme-tooltip"><?php _e( 'This feature lets you change the default size and ratio of Divi images.<br>Note that this doesn\'t affect some image sizes defined by WordPress or by external plugins.<br><strong>Once changed these settings you should regenerate thumbnails.</strong> You can use some external plugin to do the job.' , $plugin_name );?></em>
	<?php foreach ( $et_images as $img => $default_size ): ?>
		<strong><?php echo $img; ?></strong>
	<fieldset>
		<legend class="screen-reader-text"><span><?php _e( 'Width:', $plugin_name ); ?></span></legend>
		<label for="<?php echo $settings_base_name-$img;?>-w"><?php _e( 'Width:', $plugin_name );?>
			<input type="text" class="small-text" id="<?php echo $settings_base_name-$img; ?>-w"
			       name="<?php echo $settings_base_name.'['.$img.']'?>[w]" value="<?php echo $main_options[$img]['w']; ?>">
		<legend class="screen-reader-text"><span><?php _e( 'Height:', $plugin_name ); ?></span></legend>
		<label for="<?php echo $settings_base_name-$img;?>-h"><?php _e( 'Height:', $plugin_name );?>
			<input type="text" class="small-text" id="<?php echo $settings_base_name-$img; ?>-h"
			       name="<?php echo $settings_base_name.'['.$img.']'?>[h]" value="<?php echo $main_options[$img]['h']; ?>"
		<legend class="screen-reader-text"><span><?php _e( 'Crop:', $plugin_name ); ?></span></legend>
			<label for="<?php echo $settings_base_name-$img;?>-crop">
			<input type="checkbox" id="<?php echo $settings_base_name-$img; ?>-crop"
			       name="<?php echo $settings_base_name.'['.$img.']'?>[crop]" value=1 <?php checked($main_options[$img]['crop'], 1); ?>
				<?php _e( 'Crop:', $plugin_name );?>
		</label>
			<em class="acme-tooltip"><?php printf(__( 'Default Divi settings are %s', $plugin_name ),$default_size);?></em>
	</fieldset>
	<?php endforeach; ?>
	<?php submit_button( __('Save all changes',$plugin_name), 'primary', 'submit', true ); ?>
</form>

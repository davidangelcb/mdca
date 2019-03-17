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

	if ( ! isset( $plugin_data ) ) {
		$plugin_data        = apply_filters( 'acme_drop_data', null );
		$plugin_name        = $plugin_data['plugin_name'];
		$abmp_options       = $plugin_data['abmp_options'];
		$options_presets    = explode( ',', $abmp_options['abmp_presets'] );
	}

	$settings_base_name = $plugin_name . '-abmp';

	if ( isset($abmp_options['abmp_preset']) && is_array( $abmp_options['abmp_preset'] ) ) {
		$k = 0;
		foreach ( $options_presets as $index ) {
			$key[ $k ]                = $index;
			$abmp_name[ $index ]      = $abmp_options['abmp_preset'][ $index ]['name'];
			$abmp_meta[ $index ]      = $abmp_options['abmp_preset'][ $index ]['post_meta'];
			$abmp_href[ $index ]      = $abmp_options['abmp_preset'][ $index ]['href'];
			$abmp_fw_style[ $index ]  = $abmp_options['abmp_preset'][ $index ]['fw_style'];
			$abmp_post_type[ $index ] = $abmp_options['abmp_preset'][ $index ]['post_type'];
			$abmp_taxonomy[ $index ]  = $abmp_options['abmp_preset'][ $index ]['taxonomy'];
			$abmp_orderby[ $index ]   = $abmp_options['abmp_preset'][ $index ]['abmp_orderby'];
			$abmp_order[ $index ]     = $abmp_options['abmp_preset'][ $index ]['abmp_order'];
			if ( $abmp_options['abmp_preset'][ $index ]['terms'] ) {
				foreach ( $abmp_options['abmp_preset'][ $index ]['terms'] as $id => $name ) {
					$abmp_preset_term[ $index ][ $id ] = $name;
				}
			}
			$k ++;
		}
	}
	$new_id = is_array( $options_presets ) ? end( $options_presets ) + 1 : 1;
	$max_i = strlen( $abmp_options['abmp_presets'] > 0 ) ? count( $options_presets ) + 1 : 1;
	$k = array();

	$default_orderby = array(
		'date',
		'modified',
		'title',
		'name',
		'ID',
		'rand',
		'author',
	);
	$default_order = array(
		'ASC',
		'DESC'
	);


?>

<?php for($i=0; $i<$max_i; $i++): ?>

	<?php

	$hr_i = $i + 1; //human readable for $i

	//default values in form fields
	$post_types_array = apply_filters( 'acme_get_post_types', false );

	$post_type = isset( $abmp_post_type[ $hr_i ] ) ? $abmp_post_type[ $hr_i ] : $post_types_array[0];
	$taxonomies_array = apply_filters( 'acme_get_taxonomies', true, $post_type );

	$new_preset = $i == $max_i - 1 ? "abmp_new_preset" : null;
	$index_preset = isset( $key[ $i ] ) && $key[ $i ] > 0 ? $key[ $i ] : $new_id;

	?>
	<h3><?php printf(__('Preset #%s: %s',$plugin_name),$hr_i,isset($abmp_name[$index_preset])?$abmp_name[$index_preset]:null); ?></h3>
	<div class="postbox acme-postbox <?php echo $new_preset;?>">
		<input type="hidden" name="<?php echo $settings_base_name?>[abmp_preset][<?php echo $index_preset?>]" value="<?php echo $index_preset?>"
		<fieldset>
			<legend class="screen-reader-text"><span><?php printf(__( 'Preset #%s name:', $plugin_name ),$i+1); ?></span></legend>
			<label for="<?php echo "$settings_base_name-abmp-preset-$index_preset"; ?>-name"><?php
					printf(__( 'Preset #%s name:', $plugin_name ),$hr_i);?>
				<input type="text" class="regular-text" id="<?php echo "$settings_base_name-abmp_preset-$index_preset"; ?>-name"
				       name="<?php echo $settings_base_name?>[abmp][<?php echo $index_preset?>][name]" value="<?php echo isset($abmp_name[$index_preset])?$abmp_name[$index_preset]:null; ?>">
			</label>
		</fieldset>
		<?php if(is_array($post_types_array)): ?>
			<fieldset>
				<legend class="screen-reader-text"><span><?php _e( 'Select Post Type:', $plugin_name ); ?></span></legend>
				<label for="<?php echo "$settings_base_name-abmp_preset-$index_preset";?>-post_type">
					<span><?php _e( 'Select Post Type:', $plugin_name );?></span>
					<select id="<?php echo "$settings_base_name-abmp_preset-$index_preset";?>-post_type" name="<?php echo $settings_base_name?>[abmp][<?php echo $index_preset?>][post_type]" class="<?php echo "$settings_base_name-abmp_preset-post_type";?>" rel="<?php echo "$index_preset";?>">
						<?php foreach($post_types_array as $pt):?>
							<option <?php selected(isset($abmp_post_type[$index_preset])?$abmp_post_type[$index_preset]:null, $pt);?> value="<?php echo $pt; ?>"><?php echo $pt ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			</fieldset>
		<?php endif; ?>
		<?php if(is_array($taxonomies_array)): ?>
			<fieldset>
				<legend class="screen-reader-text"><span><?php _e( 'Select Taxonomy:', $plugin_name ); ?></span></legend>
				<label for="<?php echo "$settings_base_name-abmp_preset-$index_preset";?>-taxonomy">
					<span><?php _e( 'Select Taxonomy:', $plugin_name ); ?></span>
					<select id="<?php echo "$settings_base_name-abmp_preset-$index_preset";?>-taxonomy" name="<?php echo $settings_base_name?>[abmp][<?php echo $index_preset?>][taxonomy]" class="<?php echo "$settings_base_name-abmp_preset-taxonomy";?>" rel="<?php echo $index_preset;?>">
						<?php foreach($taxonomies_array as $tax):?>
							<option <?php selected(isset($abmp_taxonomy[$index_preset])?$abmp_taxonomy[$index_preset]:null, $tax);?> value="<?php echo $tax; ?>"><?php echo $tax ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			</fieldset>
		<?php endif; ?>
		<fieldset>
			<legend class="screen-reader-text"><span><?php _e('Order By', $plugin_name ); ?></span></legend>
			<label for="<?php echo "$settings_base_name-abmp_preset-$index_preset";?>-abmp_orderby">
				<span><?php _e('Order By', $plugin_name ); ?></span>
				<select id="<?php echo "$settings_base_name-abmp_preset-$index_preset";?>-abmp_orderby" name="<?php echo $settings_base_name?>[abmp][<?php echo $index_preset?>][abmp_orderby]">
					<?php foreach($default_orderby as $ob):?>
						<option <?php selected(isset($abmp_orderby[$index_preset])?$abmp_orderby[$index_preset]:null,$ob );?> value="<?php echo $ob; ?>"><?php echo $ob; ?></option>
					<?php endforeach; ?>
				</select>
		</fieldset>
		<fieldset>
			<legend class="screen-reader-text"><span><?php _e('Order', $plugin_name ); ?></span></legend>
			<label for="<?php echo "$settings_base_name-abmp_preset-$index_preset";?>-abmp_order">
				<span><?php _e('Order', $plugin_name ); ?></span>
				<select id="<?php echo "$settings_base_name-abmp_preset-$index_preset";?>-abmp_order" name="<?php echo $settings_base_name?>[abmp][<?php echo $index_preset?>][abmp_order]">
					<?php foreach($default_order as $o):?>
						<option <?php selected( isset($abmp_order[$index_preset])?$abmp_order[$index_preset]:null, $o );?> value="<?php echo $o; ?>"><?php echo $o; ?></option>
					<?php endforeach; ?>
				</select>
		</fieldset>
		<div id="<?php echo "$settings_base_name-terms-$index_preset-container";?>">
			<div class="<?php echo isset($terms_array[$index_preset])?"accordion":null; ?>"><h4><?php _e('Terms List:',$plugin_name);?></h4>
				<div>
					<?php include ('acme-divi-modules-admin-display-abmp-terms-loop.php'); ?>
				</div>
			</div>
		</div>
		<h4><?php _e('Fullwidth Options:',$plugin_name); ?></h4>
		<input type="hidden" name="<?php echo $settings_base_name?>[abmp][<?php echo $index_preset?>][fw_style]" value="1">
		<fieldset>
			<legend class="screen-reader-text"><span><?php _e( 'Extra Fields (post_meta):', $plugin_name ); ?></span></legend>
			<label for="<?php echo "$settings_base_name-abmp-preset-$index_preset"; ?>-post_meta"><?php _e( 'Extra Fields (post_meta):', $plugin_name );?>
				<input type="text" class="regular-text" id="<?php echo "$settings_base_name-abmp_preset-$index_preset"; ?>-post_meta"
				       name="<?php echo $settings_base_name?>[abmp][<?php echo $index_preset?>][post_meta]" value="<?php echo isset($abmp_meta[$index_preset])?$abmp_meta[$index_preset]:null; ?>">
			</label>
			<em class="acme-tooltip"><?php _e( 'Fill in one or more custom fields to be displayed in portfolio. Comma separated values with no spaces are accepted.', $plugin_name );?></em>
		</fieldset>
		<fieldset>
			<legend class="screen-reader-text"><span><?php _e( 'Override permalink (post_meta):', $plugin_name ); ?></span></legend>
			<label for="<?php echo "$settings_base_name-abmp-preset-$index_preset"; ?>-href"><?php _e( 'Override permalink (post_meta):', $plugin_name );?>
				<input type="text" class="regular-text" id="<?php echo "$settings_base_name-abmp_preset-$index_preset"; ?>-href"
				       name="<?php echo $settings_base_name?>[abmp][<?php echo $index_preset?>][href]" value="<?php echo isset($abmp_href[$index_preset])?$abmp_href[$index_preset]:null; ?>">
			</label>
			<em class="acme-tooltip"><?php _e( 'Insert the post_meta name containing a target url. This option allows you to override the default link to the portfolio page with an alternate destination url. You may transform each item in a Call To Action.', $plugin_name );?></em>
		</fieldset>
		<a class="button-secondary delete" href="#" title="<?php esc_attr_e( 'Delete Preset', $plugin_name ); ?>" ><?php esc_attr_e( 'Delete Preset', $plugin_name ); ?></a>
	</div>
<?php endfor; ?>

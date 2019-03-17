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

	$ajax_callback = false;
	if ( ! isset( $plugin_data ) ) {
		$ajax_callback      = true;
		$plugin_data        = apply_filters( 'acme_drop_data', null );
		$plugin_name        = $plugin_data['plugin_name'];
		$abmp_options       = $plugin_data['abmp_options'];
		$options_presets    = explode( ',', $abmp_options['abmp_presets'] );
	}

	$settings_base_name = $plugin_name . '-abmp';


	if(true == $ajax_callback){
		$index_preset = isset($_POST['index_preset'])?$_POST['index_preset']:0;
		$taxonomy = $_POST['taxonomy'];
		//load saved values
		if(is_array($abmp_options['abmp_preset'][ $index_preset ]['terms'])) {
			foreach ( $abmp_options['abmp_preset'][ $index_preset ]['terms'] as $id => $name ) {
				$abmp_preset_term[ $index_preset ][ $id ] = $name;
				$k ++;
			}
		}

	} else {
		$taxonomy = isset( $abmp_taxonomy[ $index_preset ] ) ? $abmp_taxonomy[ $index_preset ] : $taxonomies_array[0];
	}


	$terms_array      = apply_filters( 'acme_get_terms', $taxonomy );

?>

<?php if(!is_array($terms_array)): ?>
	<em><?php _e('No Term available for this taxonomy', $plugin_name);?></em>
<?php else: ?>
	<?php foreach($terms_array as $id=>$name): ?>
		<fieldset>
			<legend class="screen-reader-text"><span><?php echo $name; ?></span></legend>
			<label for="<?php echo "$settings_base_name-abmp_preset-$index_preset-term$id-$name";?>">
				<input type="checkbox" id="<?php echo "$settings_base_name-abmp_preset-$index_preset-term$id-$name";?>"
				       name="<?php echo $settings_base_name?>[abmp][<?php echo $index_preset?>][terms][<?php echo $id?>]" value="<?php echo $name?>" <?php checked(isset($abmp_preset_term[ $index_preset ][ $id ])?$abmp_preset_term[ $index_preset ][ $id ]:null, $name); ?>/>
				<span><?php echo $name; ?></span>
			</label>
		</fieldset>
	<?php endforeach; ?>
<?php endif; ?>

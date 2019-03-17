<?php
	/**
	 * Specific functions for modules
	 *
	 * @link       http://acmemk.com
	 * @since      1.0.0
	 *
	 * @package    Acme_Divi_Modules
	 * @subpackage Acme_Divi_Modules/admin
	 */

	/**
	 * Specific functions for modules
	 *
	 * Manipulates data required from modules
	 *
	 * @package    Acme_Divi_Modules
	 * @subpackage Acme_Divi_Modules/admin
	 * @author     Mirko Bianco <mirko@acmemk.com>
	 */

	if ( ! function_exists( 'acme_et_builder_include_taxonomy_option' ) ) :
		function acme_et_builder_include_taxonomy_option( $args = array() ) {
			$defaults = apply_filters( 'et_builder_include_categories_defaults', array (
				'use_terms' => true,
				'term_name' => $args['taxonomy'],
			) );

			$args = wp_parse_args( $args, $defaults );

			$output = "\t" . "<% var et_pb_include_categories_temp = typeof et_pb_include_categories !== 'undefined' ? et_pb_include_categories.split( ',' ) : []; %>" . "\n";

			if ( $args['use_terms'] ) {
				$cats_array = get_terms( $args['term_name'] );
			} else {
				$cats_array = get_categories( apply_filters( 'et_builder_get_categories_args', 'hide_empty=0' ) );
			}

			if ( empty( $cats_array ) ) {
				$output = '<p>' . esc_html__( "You currently don't have any projects assigned to a category.", 'et_builder' ) . '</p>';
			}

			foreach ( $cats_array as $category ) {
				$contains = sprintf(
					'<%%= _.contains( et_pb_include_categories_temp, "%1$s" ) ? checked="checked" : "" %%>',
					esc_html( $category->term_id )
				);

				$output .= sprintf(
					'%4$s<label><input type="checkbox" name="et_pb_include_categories" value="%1$s"%3$s> %2$s</label><br/>',
					esc_attr( $category->term_id ),
					esc_html( $category->name ),
					$contains,
					"\n\t\t\t\t\t"
				);
			}

			$output = '<div id="et_pb_include_categories">' . $output . '</div>';

			return apply_filters( 'et_builder_include_categories_option_html', $output );
		}
	endif;


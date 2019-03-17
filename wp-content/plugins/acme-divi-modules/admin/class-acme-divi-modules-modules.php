<?php
	/**
	 * ACME Modules
	 *
	 * These are extra modules based on the Divi Builder
	 *
	 * @link       http://acmemk.com
	 * @since      1.0.0
	 *
	 * @package    Acme_Divi_Modules
	 * @subpackage Acme_Divi_Modules/admin
	 */

	/**
	 * ACME_Builder_Module_Portfolio
	 *
	 * Extended functionalities:
	 *  - added option to show excerpt in results
	 *  - Portfolio works with any post_type and taxonomies (via presets)
	 *
	 *  presets are setup from Acme Panel
	 *
	 * @since       1.0.0
	 * @package    Acme_Divi_Modules
	 * @subpackage Acme_Divi_Modules/admin
	 * @author     Mirko Bianco <mirko@acmemk.com>
	 */
	class ACME_Builder_Module_Portfolio extends ET_Builder_Module {
		public $plugin_name;
		public $abmp_options;
		public $presets;


		function init() {
			$this->name       = 'ACME Custom Portfolio';
			$this->slug       = 'et_pb_portfolio_acme';
			//$this->fb_support = true;

			$plugin_data        = apply_filters( 'acme_drop_data', null );
			$this->plugin_name = $plugin_data['plugin_name'];
			$this->abmp_options = $plugin_data['abmp_options'];

			if ( isset( $this->abmp_options['abmp_preset'] ) && is_array( $this->abmp_options['abmp_preset'] ) ) {
				foreach ( $this->abmp_options['abmp_preset'] as $key => $ar ) {
					$this->presets[ $key ] = $ar['name'];
				}
			}


			$this->whitelisted_fields = array(
				'fullwidth',
				'posts_number',
				'abmp_select_preset',
				'show_title',
				'show_excerpt',
				'show_categories',
				'show_pagination',
				'background_layout',
				'admin_label',
				'module_id',
				'module_class',
				'zoom_icon_color',
				'hover_overlay_color',
				'hover_icon',
			);

			$this->fields_defaults = array(
				'fullwidth'          => array( 'on' ),
				'abmp_select_preset' => array( 'k0' ),
				'posts_number'       => array( 10, 'add_default_setting' ),
				'show_title'         => array( 'on' ),
				'show_excerpt'       => array( 'off' ),
				'show_categories'    => array( 'on' ),
				'show_pagination'    => array( 'on' ),
				'background_layout'  => array( 'light' ),
			);

			$this->main_css_element = '%%order_class%% .et_pb_portfolio_item';
			$this->advanced_options = array(
				'fonts' => array(
					'title'   => array(
						'label'    => esc_html__( 'Title', 'et_builder' ),
						'css'      => array(
							'main' => "{$this->main_css_element} h2",
							'important' => 'all',
						),
					),
					'caption' => array(
						'label'    => esc_html__( 'Meta', 'et_builder' ),
						'css'      => array(
							'main' => "{$this->main_css_element} .post-meta, {$this->main_css_element} .post-meta a",
						),
					),
				),
				'background' => array(
					'settings' => array(
						'color' => 'alpha',
					),
				),
				'border' => array(),
			);
			$this->custom_css_options = array(
				'portfolio_image' => array(
					'label'    => esc_html__( 'Portfolio Image', 'et_builder' ),
					'selector' => '.et_portfolio_image',
				),
				'overlay' => array(
					'label'    => esc_html__( 'Overlay', 'et_builder' ),
					'selector' => '.et_overlay',
				),
				'overlay_icon' => array(
					'label'    => esc_html__( 'Overlay Icon', 'et_builder' ),
					'selector' => '.et_overlay:before',
				),
				'portfolio_title' => array(
					'label'    => esc_html__( 'Portfolio Title', 'et_builder' ),
					'selector' => '.et_pb_portfolio_item h2',
				),
				'portfolio_post_meta' => array(
					'label'    => esc_html__( 'Portfolio Post Meta', 'et_builder' ),
					'selector' => '.et_pb_portfolio_item .post-meta',
				),
			);
		}

		function get_fields() {
			$fields = array(
				'fullwidth' => array(
					'label'           => esc_html__( 'Layout', 'et_builder' ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => array(
						'on'  => esc_html__( 'Fullwidth', 'et_builder' ),
						'off' => esc_html__( 'Grid', 'et_builder' ),
					),
					'description'       => esc_html__( 'Choose your desired portfolio layout style.', 'et_builder' ),
					'computed_affects' => array(
						'__projects',
					),
				),
				'posts_number' => array(
					'label'             => esc_html__( 'Posts Number', 'et_builder' ),
					'type'              => 'text',
					'option_category'   => 'configuration',
					'description'       => esc_html__( 'Define the number of projects that should be displayed per page.', 'et_builder' ),
					'computed_affects' => array(
						'__projects',
					),
				),
				'abmp_select_preset' => array(
					'label'            => esc_html__( 'Select Preset', $this->plugin_name ),
					'type'             => 'select',
					'option_category'  => 'configuration',
					'options'          => $this->presets,
					'description'      => esc_html__( 'Choose your presets for this module.', $this->plugin_name ),
					'computed_affects' => array(
						'__projects',
					),
				),
				'show_title' => array(
					'label'           => esc_html__( 'Show Title', 'et_builder' ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'       => esc_html__( 'Turn project titles on or off.', 'et_builder' ),
				),
				'show_excerpt' => array(//mb
					'label'           => esc_html__( 'Show Excerpt', 'et_builder' ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'       => esc_html__( 'Turn display excerpt on or off.', 'et_builder' ),
				),
				'show_categories' => array(
					'label'           => esc_html__( 'Show Categories', 'et_builder' ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'        => esc_html__( 'Turn the category links on or off.', 'et_builder' ),
				),
				'show_pagination' => array(
					'label'           => esc_html__( 'Show Pagination', 'et_builder' ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'        => esc_html__( 'Enable or disable pagination for this feed.', 'et_builder' ),
				),
				'background_layout' => array(
					'label'           => esc_html__( 'Text Color', 'et_builder' ),
					'type'            => 'select',
					'option_category' => 'color_option',
					'options'         => array(
						'light'  => esc_html__( 'Dark', 'et_builder' ),
						'dark' => esc_html__( 'Light', 'et_builder' ),
					),
					'description'        => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
				),
				'zoom_icon_color' => array(
					'label'             => esc_html__( 'Zoom Icon Color', 'et_builder' ),
					'type'              => 'color',
					'custom_color'      => true,
					'tab_slug'          => 'advanced',
				),
				'hover_overlay_color' => array(
					'label'             => esc_html__( 'Hover Overlay Color', 'et_builder' ),
					'type'              => 'color-alpha',
					'custom_color'      => true,
					'tab_slug'          => 'advanced',
				),
				'hover_icon' => array(
					'label'               => esc_html__( 'Hover Icon Picker', 'et_builder' ),
					'type'                => 'text',
					'option_category'     => 'configuration',
					'class'               => array( 'et-pb-font-icon' ),
					'renderer'            => 'et_pb_get_font_icon_list',
					'renderer_with_field' => true,
					'tab_slug'            => 'advanced',
				),
				'disabled_on' => array(
					'label'           => esc_html__( 'Disable on', 'et_builder' ),
					'type'            => 'multiple_checkboxes',
					'options'         => array(
						'phone'   => esc_html__( 'Phone', 'et_builder' ),
						'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
						'desktop' => esc_html__( 'Desktop', 'et_builder' ),
					),
					'additional_att'  => 'disable_on',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
				),
				'admin_label' => array(
					'label'       => esc_html__( 'Admin Label', 'et_builder' ),
					'type'        => 'text',
					'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
				),
				'module_id' => array(
					'label'           => esc_html__( 'CSS ID', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'module_class' => array(
					'label'           => esc_html__( 'CSS Class', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'__projects'          => array(
					'type'                => 'computed',
					'computed_callback'   => array( 'ET_Builder_Module_Portfolio', 'get_portfolio_item' ),
					'computed_depends_on' => array(
						'abmp_select_preset',
						'posts_number',
						'include_categories',
						'fullwidth',
					),
				),
			);
			return $fields;
		}

		/**
		 * Get portfolio objects for portfolio module
		 *
		 * @param array  arguments that affect et_pb_portfolio query
		 * @param array  passed conditional tag for update process
		 * @param array  passed current page params
		 * @return array portfolio item data
		 */
		static function get_portfolio_item( $args = array(), $conditional_tags = array(), $current_page = array() ) {
			$defaults = array(
				'posts_number'       => 10,
				'include_categories' => 0,
				'fullwidth'          => 'on',
			);

			$args          = wp_parse_args( $args, $defaults );

			// Native conditional tag only works on page load. Data update needs $conditional_tags data
			$is_front_page = et_fb_conditional_tag( 'is_front_page', $conditional_tags );
			$is_search     = et_fb_conditional_tag( 'is_search', $conditional_tags );

			// Prepare query arguments
			$query_args = array(
				'posts_per_page' => (int) $args['posts_number'],
				'post_type'      => $args['abmp_post_type'],
				'post_status'    => 'publish',/**/
				'order'          => $args['abmp_order'],
				'orderby'       => $args['abmp_orderby']
			);

			// Conditionally get paged data
			if ( defined( 'DOING_AJAX' ) && isset( $current_page[ 'paged'] ) ) {
				$et_paged = intval( $current_page[ 'paged' ] );
			} else {
				$et_paged = $is_front_page ? get_query_var( 'page' ) : get_query_var( 'paged' );
			}

			if ( $is_front_page ) {
				$paged = $et_paged;
			}

			if ( ! is_search() ) {
				$query_args['paged'] = $et_paged;
			}

			// Passed categories parameter
			if ( '' !== $args['include_categories'] ) {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => $args['abmp_taxonomy'],
						'field'    => 'id',
						'terms'    => explode( ',', $args['include_categories'] ),
						'operator' => 'IN',
					)
				);
			}

			// Get portfolio query
			$query = new WP_Query( $query_args );

			// Format portfolio output, and add supplementary data
			$width     = 'on' === $args['fullwidth'] ?  1080 : 400;
			$width     = (int) apply_filters( 'et_pb_portfolio_image_width', $width );
			$height    = 'on' === $args['fullwidth'] ?  9999 : 284;
			$height    = (int) apply_filters( 'et_pb_portfolio_image_height', $height );
			$classtext = 'on' === $args['fullwidth'] ? 'et_pb_post_main_image' : '';
			$titletext = get_the_title();

			// Loop portfolio item data and add supplementary data
			if ( $query->have_posts() ) {
				$post_index = 0;
				while( $query->have_posts() ) {
					$query->the_post();

					$categories = array();

					$categories_object = get_the_terms( get_the_ID(), $args['abmp_taxonomy'] );

					if ( ! empty( $categories_object ) ) {
						foreach ( $categories_object as $category ) {
							if ( is_object( $category ) ) {
								$categories[] = array(
									'id'        => $category->term_id,
									'label'     => $category->name,
									'permalink' => get_term_link( $category ),
								);
							}
						}
					}

					// Get thumbnail
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );

					// Append value to query post
					$query->posts[ $post_index ]->post_permalink 	= get_permalink();
					$query->posts[ $post_index ]->post_thumbnail 	= print_thumbnail( $thumbnail['thumb'], $thumbnail['use_timthumb'], $titletext, $width, $height, '', false, true );
					$query->posts[ $post_index ]->post_categories 	= $categories;
					$query->posts[ $post_index ]->post_class_name 	= get_post_class( '', get_the_ID() );

					$post_index++;
				}

				$query->posts_next = array(
					'label' => esc_html__( '&laquo; Older Entries', 'et_builder' ),
					'url' => next_posts( $query->max_num_pages, false ),
				);

				$query->posts_prev = array(
					'label' => esc_html__( 'Next Entries &raquo;', 'et_builder' ),
					'url' => ( $et_paged > 1 ) ? previous_posts( false ) : '',
				);

				// Added wp_pagenavi support
				$query->wp_pagenavi = function_exists( 'wp_pagenavi' ) ? wp_pagenavi( array(
					'query' => $query,
					'echo' => false
				) ) : false;
			}

			wp_reset_postdata();

			return $query;
		}

		function shortcode_callback( $atts, $content = null, $function_name ) {
			$module_id          = $this->shortcode_atts['module_id'];
			$module_class       = $this->shortcode_atts['module_class'];
			$fullwidth          = $this->shortcode_atts['fullwidth'];
			$posts_number       = $this->shortcode_atts['posts_number'];
			$abmp_select_preset = $this->shortcode_atts['abmp_select_preset'];
			$include_categories = implode(',',array_keys($this->abmp_options['abmp_preset'][$abmp_select_preset]['terms']));
			$show_title         = $this->shortcode_atts['show_title'];
			$show_excerpt       = $this->shortcode_atts['show_excerpt'];//mb
			$show_categories    = $this->shortcode_atts['show_categories'];
			$show_pagination    = $this->shortcode_atts['show_pagination'];
			$background_layout  = $this->shortcode_atts['background_layout'];
			$zoom_icon_color     = $this->shortcode_atts['zoom_icon_color'];
			$hover_overlay_color = $this->shortcode_atts['hover_overlay_color'];
			$hover_icon          = $this->shortcode_atts['hover_icon'];
			$abmp_post_type = $this->abmp_options['abmp_preset'][ $abmp_select_preset ]['post_type'];
			$abmp_taxonomy = $this->abmp_options['abmp_preset'][ $abmp_select_preset ]['taxonomy'];
			$abmp_order =$this->abmp_options['abmp_preset'][ $abmp_select_preset ]['abmp_order'];
			$abmp_orderby =$this->abmp_options['abmp_preset'][ $abmp_select_preset ]['abmp_orderby'];




			global $paged;

			$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

			// Set inline style
			if ( '' !== $zoom_icon_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $zoom_icon_color )
					),
				) );
			}

			if ( '' !== $hover_overlay_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay',
					'declaration' => sprintf(
						'background-color: %1$s;
					border-color: %1$s;',
						esc_html( $hover_overlay_color )
					),
				) );
			}

			$container_is_closed = false;

			// Get loop data
			$portfolio = self::get_portfolio_item(
				array(
					'posts_number'       => $posts_number,
					'include_categories' => $include_categories,
					'abmp_select_preset' => $abmp_select_preset,
					'abmp_post_type'     => $abmp_post_type,
					'abmp_taxonomy'      => $abmp_taxonomy,
					'fullwidth'          => $fullwidth,
					'abmp_order'         => $abmp_order,
					'abmp_orderby'       => $abmp_orderby
				)
			);

			// setup overlay
			if ( 'on' !== $fullwidth ) {
				$data_icon = '' !== $hover_icon
					? sprintf(
						' data-icon="%1$s"',
						esc_attr( et_pb_process_font_icon( $hover_icon ) )
					)
					: '';

				$overlay = sprintf( '<span class="et_overlay%1$s"%2$s></span>',
					( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
					$data_icon
				);
			}

			ob_start();

			if ( $portfolio->have_posts() ) {
				while( $portfolio->have_posts() ) {
					$portfolio->the_post();

					// Get $post data of current loop
					global $post;

					array_push( $post->post_class_name, 'et_pb_portfolio_item' );

					if ( 'on' !== $fullwidth ) {
						array_push( $post->post_class_name, 'et_pb_grid_item' );
					}

					?>
					<div id="post-<?php echo esc_attr( $post->ID ); ?>" class="<?php echo esc_attr( join( $post->post_class_name, ' ' ) ); ?>">

						<?php if ( '' !== $post->post_thumbnail ) { ?>
							<a href="<?php echo esc_url( $post->post_permalink ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
								<?php if ( 'on' === $fullwidth ) { ?>
									<img src="<?php echo esc_url( $post->post_thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" width="1080" height="9999" />
								<?php } else { ?>
									<span class="et_portfolio_image">
								<img src="<?php echo esc_url( $post->post_thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" width="400" height="284" />
										<?php echo $overlay; ?>
							</span>
								<?php } ?>
							</a>
						<?php } ?>

						<?php if ( 'on' === $show_title ) { ?>
							<h2>
								<a href="<?php echo esc_url( $post->post_permalink ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
									<?php echo esc_html( get_the_title() ); ?>
								</a>
							</h2>
						<?php } ?>


						<?php if ( 'on' === $show_categories && ! empty( $post->post_categories ) ) : ?>
							<p class="post-meta">
								<?php
									$category_index = 0;
									foreach( $post->post_categories as $category ) {
										$category_index++;
										$separator =  $category_index < count(  $post->post_categories ) ? ', ' : '';
										echo '<a href="'. esc_url( $category['permalink'] ) .'" title="' . esc_attr( $category['label'] ) . '">' . esc_html( $category['label'] ) . '</a>' . $separator;
									}
								?>
							</p>
						<?php endif; ?>

						<?php
							if ( 'on' === $show_excerpt ) {
								the_excerpt();
							}
						?>

					</div><!-- .et_pb_portfolio_item -->
				<?php
				}

				if ( 'on' === $show_pagination && ! is_search() ) {
					if ( function_exists( 'wp_pagenavi' ) ) {
						wp_pagenavi( array( 'query' => $portfolio ) );
					} else {
						if ( et_is_builder_plugin_active() ) {
							include( ET_BUILDER_PLUGIN_DIR . 'includes/navigation.php' );
						} else {
							$next_posts_link_html = $prev_posts_link_html = '';

							if ( ! empty( $portfolio->posts_next['url'] ) ) {
								$next_posts_link_html = sprintf(
									'<div class="alignleft">
									<a href="%1$s">%2$s</a>
								</div>',
									esc_url( $portfolio->posts_next['url'] ),
									esc_html( $portfolio->posts_next['label'] )
								);
							}

							if ( ! empty( $portfolio->posts_prev['url'] ) ) {
								$prev_posts_link_html = sprintf(
									'<div class="alignright">
									<a href="%1$s">%2$s</a>
								</div>',
									esc_url( $portfolio->posts_prev['url'] ),
									esc_html( $portfolio->posts_prev['label'] )
								);
							}

							printf(
								'<div class="pagination clearfix">
								%1$s
								%2$s
							</div>',
								$next_posts_link_html,
								$prev_posts_link_html
							);
						}
					}
				}
			} else {
				if ( et_is_builder_plugin_active() ) {
					include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
				} else {
					get_template_part( 'includes/no-results', 'index' );
				}
			}

			// Reset post data
			wp_reset_postdata();

			$posts = ob_get_contents();

			ob_end_clean();

			$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

			$output = sprintf(
				'<div%5$s class="%1$s%3$s%6$s">
				%2$s
			%4$s',
				( 'on' === $fullwidth ? 'et_pb_portfolio' : 'et_pb_portfolio_grid clearfix' ),
				$posts,
				esc_attr( $class ),
				( ! $container_is_closed ? '</div> <!-- .et_pb_portfolio -->' : '' ),
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
			);

			return $output;
		}
	}



	/**
	 * ACME_Builder_Module_Fullwidth_Portfolio
	 *
	 * Extended functionalities:
	 *  - added option to show excerpt in results
	 *  - Portfolio works with any post_type and taxonomies (via presets)
	 *  - ACME Carousel Style will show excerpt and custom fields (via preset)
	 *  - ACME Carousel Style can replace default premalink with any url in custom fileds (via preset)
	 *  - Change default columns number output for ACME Carousel Style
	 *
	 *  presets are setup from Acme Panel
	 *
	 * @since       1.0.0
	 * @package    Acme_Divi_Modules
	 * @subpackage Acme_Divi_Modules/admin
	 * @author     Mirko Bianco <mirko@acmemk.com>
	 */
	class ACME_Builder_Module_Fullwidth_Portfolio extends ET_Builder_Module {
		public $plugin_name;
		public $abmp_options;
		public $presets;
		function init() {
			$this->name       = 'ACME FW Portfolio';
			$this->slug       = 'et_pb_portfolio_fw_acme';
			//$this->fb_support = true;
			$this->fullwidth  = true;


			$plugin_data        = apply_filters( 'acme_drop_data', null );
			$this->plugin_name = $plugin_data['plugin_name'];
			$this->abmp_options = $plugin_data['abmp_options'];

			if ( isset( $this->abmp_options['abmp_preset'] ) && is_array( $this->abmp_options['abmp_preset'] ) ) {
				foreach ( $this->abmp_options['abmp_preset'] as $key => $ar ) {
					$this->presets[ $key ] = $ar['name'];
				}
			}

			// need to use global settings from the slider module
			$this->global_settings_slug = 'et_pb_portfolio';

			$this->whitelisted_fields = array(
				'title',
				'fullwidth',
				'abmp_select_preset',
				'max_columns',
				'posts_number',
				'show_title',
				'show_excerpt',//mb
				'show_date',
				'background_layout',
				'auto',
				'auto_speed',
				'hover_icon',
				'hover_overlay_color',
				'zoom_icon_color',
				'admin_label',
				'module_id',
				'module_class',
			);

			$this->main_css_element = '%%order_class%%';

			$this->options_toggles = array(
				'general'  => array(
					'toggles' => array(
						'main_content' => esc_html__( 'Content', 'et_builder' ),
						'elements'     => esc_html__( 'Elements', 'et_builder' ),
					),
				),
				'advanced' => array(
					'toggles' => array(
						'layout'   => esc_html__( 'Layout', 'et_builder' ),
						'overlay'  => esc_html__( 'Overlay', 'et_builder' ),
						'rotation' => esc_html__( 'Rotation', 'et_builder' ),
						'text'     => array(
							'title'    => esc_html__( 'Text', 'et_builder' ),
							'priority' => 49,
						),
					),
				),
				'custom_css' => array(
					'toggles' => array(
						'animation' => array(
							'title'    => esc_html__( 'Animation', 'et_builder' ),
							'priority' => 90,
						),
					),
				),
			);


			$this->advanced_options = array(
				'fonts' => array(
					'title'   => array(
						'label'    => esc_html__( 'Title', 'et_builder' ),
						'css'      => array(
							'main' => "{$this->main_css_element} h3",
							'important' => 'all',
						),
					),
					'caption' => array(
						'label'    => esc_html__( 'Meta', 'et_builder' ),
						'css'      => array(
							'main' => "{$this->main_css_element} .post-meta, {$this->main_css_element} .post-meta a",
						),
					),
				),
				'background' => array(
					'settings' => array(
						'color' => 'alpha',
					),
				),
				'border' => array(
					'css' => array(
						'main' => "{$this->main_css_element} .et_pb_portfolio_item",
					),
				),
			);

			$this->custom_css_options = array(
				'portfolio_title' => array(
					'label'    => esc_html__( 'Portfolio Title', 'et_builder' ),
					'selector' => '> h2',
				),
				'portfolio_item' => array(
					'label'    => esc_html__( 'Portfolio Item', 'et_builder' ),
					'selector' => '.et_pb_portfolio_item',
				),
				'portfolio_overlay' => array(
					'label'    => esc_html__( 'Item Overlay', 'et_builder' ),
					'selector' => 'span.et_overlay',
				),
				'portfolio_item_title' => array(
					'label'    => esc_html__( 'Item Title', 'et_builder' ),
					'selector' => '.meta h3',
				),
				'portfolio_meta' => array(
					'label'    => esc_html__( 'Meta', 'et_builder' ),
					'selector' => '.meta p',
				),
				'portfolio_arrows' => array(
					'label'    => esc_html__( 'Navigation Arrows', 'et_builder' ),
					'selector' => '.et-pb-slider-arrows a',
				),
			);

			$this->fields_defaults = array(
				'abmp_select_preset' => array( 'k0' ),
				'fullwidth'          => array( 'on' ),
				'show_title'         => array( 'on' ),
				'show_excerpt'       => array( 'off' ),
				'max_columns'        => array( "5, 4, 3, 2, 1" ),
				'show_date'          => array( 'on' ),
				'background_layout'  => array( 'light' ),
				'auto'               => array( 'off' ),
				'auto_speed'         => array( '7000' ),
			);
		}

		function get_fields() {
			$fields = array(
				'title'               => array(
					'label'           => esc_html__( 'Portfolio Title', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Title displayed above the portfolio.', 'et_builder' ),
				),
				'fullwidth'           => array(
					'label'           => esc_html__( 'Layout', 'et_builder' ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => array(
						'on'  => esc_html__( 'Carousel', 'et_builder' ),
						'off' => esc_html__( 'Grid', 'et_builder' ),
					),
					'affects'         => array(
						'auto',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'layout',
					'description'     => esc_html__( 'Choose your desired portfolio layout style.', 'et_builder' ),
				),
				'abmp_select_preset'  => array(
					'label'            => esc_html__( 'Select Preset', $this->plugin_name ),
					'type'             => 'select',
					'option_category'  => 'layout',
					'options'          => $this->presets,
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'layout',
					'description'      => esc_html__( 'Choose your presets for this module.', $this->plugin_name ),
					'computed_affects' => array(
						'__projects',
					),
				),
				'max_columns'         => array(
					'label'           => esc_html__( 'Display Max Columns', $this->plugin_name ),
					'type'            => 'text',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'layout',
					'description'     => esc_html__( 'Comma Separated Values for responsive breakpoints: 1600|1024|768|480|320. This will affect the number of columns per row.', $this->plugin_name )
				),
				'posts_number'        => array(
					'label'           => esc_html__( 'Posts Number', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'Control how many projects are displayed. Leave blank or use 0 to not limit the amount.', 'et_builder' )
				),
				'show_title'          => array(
					'label'           => esc_html__( 'Show Title', 'et_builder' ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'     => esc_html__( 'Turn project titles on or off.', 'et_builder' ),
				),
				'show_excerpt'        => array(//mb
					'label'           => esc_html__( 'Show Excerpt', 'et_builder' ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'     => esc_html__( 'Turn display excerpt on or off.', 'et_builder' ),
				),
				'show_date'           => array(
					'label'           => esc_html__( 'Show Date', 'et_builder' ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'     => esc_html__( 'Turn the date display on or off.', 'et_builder' ),
				),
				'background_layout'   => array(
					'label'           => esc_html__( 'Text Color', 'et_builder' ),
					'type'            => 'select',
					'option_category' => 'color_option',
					'options'         => array(
						'light' => esc_html__( 'Dark', 'et_builder' ),
						'dark'  => esc_html__( 'Light', 'et_builder' ),
					),
					'description'     => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
				),
				'auto'                => array(
					'label'           => esc_html__( 'Automatic Carousel Rotation', 'et_builder' ),
					'type'            => 'yes_no_button',
					'option_category' => 'configuration',
					'options'         => array(
						'off' => esc_html__( 'Off', 'et_builder' ),
						'on'  => esc_html__( 'On', 'et_builder' ),
					),
					'affects'         => array(
						'auto_speed',
					),
					'description'     => esc_html__( 'If the carousel layout option is chosen and you would like the carousel to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'et_builder' ),
				),
				'auto_speed'          => array(
					'label'           => esc_html__( 'Automatic Carousel Rotation Speed (in ms)', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'depends_default' => true,
					'description'     => esc_html__( "Here you can designate how fast the carousel rotates, if 'Automatic Carousel Rotation' option is enabled above. The higher the number the longer the pause between each rotation. (Ex. 1000 = 1 sec)", 'et_builder' ),
				),
				'zoom_icon_color'     => array(
					'label'        => esc_html__( 'Zoom Icon Color', 'et_builder' ),
					'type'         => 'color',
					'custom_color' => true,
					'tab_slug'     => 'advanced',
				),
				'hover_overlay_color' => array(
					'label'        => esc_html__( 'Hover Overlay Color', 'et_builder' ),
					'type'         => 'color-alpha',
					'custom_color' => true,
					'tab_slug'     => 'advanced',
				),
				'hover_icon'          => array(
					'label'               => esc_html__( 'Hover Icon Picker', 'et_builder' ),
					'type'                => 'text',
					'option_category'     => 'configuration',
					'class'               => array( 'et-pb-font-icon' ),
					'renderer'            => 'et_pb_get_font_icon_list',
					'renderer_with_field' => true,
					'tab_slug'            => 'advanced',
				),
				'disabled_on'         => array(
					'label'           => esc_html__( 'Disable on', 'et_builder' ),
					'type'            => 'multiple_checkboxes',
					'options'         => array(
						'phone'   => esc_html__( 'Phone', 'et_builder' ),
						'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
						'desktop' => esc_html__( 'Desktop', 'et_builder' ),
					),
					'additional_att'  => 'disable_on',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
				),
				'admin_label'         => array(
					'label'       => esc_html__( 'Admin Label', 'et_builder' ),
					'type'        => 'text',
					'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
				),
				'module_id'           => array(
					'label'           => esc_html__( 'CSS ID', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'module_class'        => array(
					'label'           => esc_html__( 'CSS Class', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'__projects'          => array(
					'type'                => 'computed',
					'computed_callback'   => array( 'ET_Builder_Module_Fullwidth_Portfolio', 'get_portfolio_item' ),
					'computed_depends_on' => array(
						'posts_number',
					),
				),
			);
			return $fields;
		}

		/**
		 * Check if WPML is Installed
		 *
		 * @since    1.0.0
		 */
		private function is_wpml() {
			$response = false;
			if ( function_exists( 'icl_object_id' ) ) {
				if ( version_compare( ICL_SITEPRESS_VERSION, '3.6.0' ) >= 0 ) {
					$response = true;
				}
			}

			return $response;
		}
		/**
		 * Get portfolio objects for portfolio module
		 *
		 * @param array  arguments that affect et_pb_portfolio query
		 * @param array  passed conditional tag for update process
		 * @param array  passed current page params
		 * @return array portfolio item data
		 */
		static function get_portfolio_item( $args = array(), $conditional_tags = array(), $current_page = array(), $is_wpml ) {
			$defaults = array(
				'posts_number'       => '',
				'include_categories' => '',
			);

			$args = wp_parse_args( $args, $defaults );

			$query_args = array(
				'post_type'   => $args['abmp_post_type'],
				'post_status' => 'publish',
				'order'       => $args['abmp_order'],
				'orderby'    => $args['abmp_orderby']
			);

			if ( is_numeric( $args['posts_number'] ) && $args['posts_number'] > 0 ) {
				$query_args['posts_per_page'] = $args['posts_number'];
			} else {
				$query_args['nopaging'] = true;
			}

			if ( '' !== $args['include_categories'] ) {
				$cur_terms = explode( ',', $args['include_categories'] );
				if ( true == $is_wpml ) {
					foreach ( $cur_terms as $curID ) {
						$ar_terms[] = apply_filters( 'wpml_object_id', $curID, $args['abmp_taxonomy'], true );
					}
				} else {
					$ar_terms = explode( ',', $args['include_categories'] );
				}

				$query_args['tax_query'] = array(
					array(
						'taxonomy' => $args['abmp_taxonomy'],
						'field'    => 'id',
						'terms'    => $ar_terms,
						'operator' => 'IN'
					)
				);
			}

			// Get portfolio query
			$query = new WP_Query( $query_args );

			// Format portfolio output, add supplementary data
			$width  = (int) apply_filters( 'et_pb_portfolio_image_width', 510 );
			$height = (int) apply_filters( 'et_pb_portfolio_image_height', 382 );

			if( $query->post_count > 0 ) {
				$post_index = 0;
				while ( $query->have_posts() ) {
					$query->the_post();

					// Get thumbnail
					$thumbnail   = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( $width, $height ) );

					if ( isset( $thumbnail[2] ) && isset( $thumbnail[1] ) ) {
						$orientation = ( $thumbnail[2] > $thumbnail[1] ) ? 'portrait' : 'landscape';
					} else {
						$orientation = false;
					}
					$href = null;
					//inspect meta
					if ($args['href']  ) {
						$href = get_post_meta( get_the_ID(), $args['href'], true );
					}

					// Append value to query post
					$query->posts[ $post_index ]->post_permalink             = $href ? $href : get_permalink();
					$query->posts[ $post_index ]->post_thumbnail             = isset( $thumbnail[0] ) ? $thumbnail[0] : false;
					$query->posts[ $post_index ]->post_thumbnail_orientation = $orientation;
					$query->posts[ $post_index ]->post_date_readable         = get_the_date();
					$query->posts[ $post_index ]->post_class_name            = get_post_class( 'et_pb_portfolio_item et_pb_grid_item acme_portfolio_item' );

					$post_index++;
				}
			}

			wp_reset_postdata();

			return $query;
		}

		function shortcode_callback( $atts, $content = null, $function_name ) {
			$fullwidth           = $this->shortcode_atts['fullwidth'];
			$title               = $this->shortcode_atts['title'];
			$module_id           = $this->shortcode_atts['module_id'];
			$module_class        = $this->shortcode_atts['module_class'];
			$abmp_select_preset  = $this->shortcode_atts['abmp_select_preset'];
			$max_columns         = $this->shortcode_atts['max_columns'];
			$posts_number        = $this->shortcode_atts['posts_number'];
			$show_title          = $this->shortcode_atts['show_title'];
			$show_date           = $this->shortcode_atts['show_date'];
			$background_layout   = $this->shortcode_atts['background_layout'];
			$auto                = $this->shortcode_atts['auto'];
			$auto_speed          = $this->shortcode_atts['auto_speed'];
			$zoom_icon_color     = $this->shortcode_atts['zoom_icon_color'];
			$hover_overlay_color = $this->shortcode_atts['hover_overlay_color'];
			$hover_icon          = $this->shortcode_atts['hover_icon'];
			$abmp_post_type = $this->abmp_options['abmp_preset'][ $abmp_select_preset ]['post_type'];
			$abmp_taxonomy = $this->abmp_options['abmp_preset'][ $abmp_select_preset ]['taxonomy'];
			$show_excerpt       = $this->shortcode_atts['show_excerpt'];
			$abmp_order =$this->abmp_options['abmp_preset'][ $abmp_select_preset ]['abmp_order'];
			$abmp_orderby =$this->abmp_options['abmp_preset'][ $abmp_select_preset ]['abmp_orderby'];

			$include_categories  = implode(',',array_keys($this->abmp_options['abmp_preset'][$abmp_select_preset]['terms']));
			$abmp_post_meta = $this->abmp_options['abmp_preset'][ $abmp_select_preset ]['post_meta'];
			$abmp_href = $this->abmp_options['abmp_preset'][ $abmp_select_preset ]['href'];

			//apply_filters('acme_debug',$this->abmp_options['abmp_preset'][$abmp_select_preset]['fw_style'],'Valore Indice preset');
			$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

			if ( '' !== $zoom_icon_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $zoom_icon_color )
					),
				) );
			}

			if ( '' !== $hover_overlay_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay',
					'declaration' => sprintf(
						'background-color: %1$s;
					border-color: %1$s;',
						esc_html( $hover_overlay_color )
					),
				) );
			}

			$args = array();
			if ( is_numeric( $posts_number ) && $posts_number > 0 ) {
				$args['posts_per_page'] = $posts_number;
			} else {
				$args['nopaging'] = true;
			}

			if ( '' !== $include_categories ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'project_category',
						'field' => 'id',
						'terms' => explode( ',', $include_categories ),
						'operator' => 'IN'
					)
				);
			}

			$projects = self::get_portfolio_item( array(
				'posts_number'       => $posts_number,
				'include_categories' => $include_categories,
				'abmp_select_preset' => $abmp_select_preset,
				'abmp_post_type'     => $abmp_post_type,
				'abmp_taxonomy'      => $abmp_taxonomy,
				'href'               => $abmp_href,
				'abmp_order'         => $abmp_order,
				'abmp_orderby'       => $abmp_orderby
			), array(), array(), $this->is_wpml() );

			// take some settings from standard portfolio module if acme style is set
			// Set inline style
			if ( '' !== $zoom_icon_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $zoom_icon_color )
					),
				) );
			}

			if ( '' !== $hover_overlay_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay',
					'declaration' => sprintf(
						'background-color: %1$s;
					border-color: %1$s;',
						esc_html( $hover_overlay_color )
					),
				) );
			}


			$data_icon = '' !== $hover_icon
				? sprintf(
					' data-icon="%1$s"',
					esc_attr( et_pb_process_font_icon( $hover_icon ) )
				)
				: '';

			$overlay = sprintf( '<span class="et_overlay%1$s"%2$s></span>',
				( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
				$data_icon
			);


			ob_start();
			if( $projects->post_count > 0 ) {
				while ( $projects->have_posts() ) {
					$projects->the_post();

					?>

					<?php // Get $post data of current loop
					global $post;


					//apply_filters( 'acme_debug', $all_meta, 'post meta',true );

					//array_push( $post->post_class_name, 'et_pb_portfolio_item' );

					/*if ( 'on' !== $fullwidth ) {
						array_push( $post->post_class_name, 'et_pb_grid_item' );
					}*/

					?>
					<div id="post-<?php echo esc_attr( $post->ID ); ?>"
					     class="<?php echo esc_attr( join( $post->post_class_name, ' ' ) ); ?>">

						<?php if ( '' !== $post->post_thumbnail ) { ?>
							<a href="<?php echo esc_url( $post->post_permalink ); ?>"
							   title="<?php echo esc_attr( get_the_title() ); ?>">
								<span class="et_portfolio_image">
								<img src="<?php echo esc_url( $post->post_thumbnail ); ?>"
								     alt="<?php echo ( 'on' === $show_title ) ? esc_attr( get_the_title() ) : null ; ?>" />
									<?php echo $overlay; ?>
							</span>
							</a>
						<?php } ?>

						<?php if ( 'on' === $show_title ) { ?>
							<h2>
								<a href="<?php echo esc_url( $post->post_permalink ); ?>"
								   title="<?php echo esc_attr( get_the_title() ); ?>">
									<?php echo esc_html( get_the_title() ); ?>
								</a>
							</h2>
						<?php } ?>


						<?php
							if ( 'on' === $show_excerpt ) {
								the_excerpt();
							}
						?>
						<?php
							//Get Post Meta

							$all_meta = get_post_meta( $post->ID );
							if($abmp_post_meta) {
								if(is_array($all_meta)) {
									foreach ( explode(',',$abmp_post_meta) as $meta ) {
										echo sprintf( '<span class="abmp_meta_%1$s">%2$s</span>',
											$meta,
											$all_meta[$meta][0] );
									}
								}
							}
						?>

					</div>
				<?php
				}

			}

			wp_reset_postdata();

			$posts = ob_get_clean();

			$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

			$output = sprintf(
				'<div%4$s class="et_pb_fullwidth_portfolio %1$s%3$s%5$s%9$s" data-auto-rotate="%6$s" data-auto-rotate-speed="%7$s" data-max-columns="%11$s" >
				%8$s
				<div class="et_pb_portfolio_items clearfix %10$s" data-portfolio-columns="">
					%2$s
				</div><!-- .et_pb_portfolio_items -->
			</div> <!-- .et_pb_fullwidth_portfolio -->',
				( 'on' === $fullwidth ? 'et_pb_fullwidth_portfolio_carousel' : 'et_pb_fullwidth_portfolio_grid clearfix' ),
				$posts,
				esc_attr( $class ),
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
				( '' !== $auto && in_array( $auto, array( 'on', 'off' ) ) ? esc_attr( $auto ) : 'off' ),
				( '' !== $auto_speed && is_numeric( $auto_speed ) ? esc_attr( $auto_speed ) : '7000' ),
				( '' !== $title ? sprintf( '<h2>%s</h2>', esc_html( $title ) ) : '' ),
				( '1' == $this->abmp_options['abmp_preset'][ $abmp_select_preset ]['fw_style'] ? ' acme_carousel' : 'placeholder' ),
				( '1' == $this->abmp_options['abmp_preset'][ $abmp_select_preset ]['fw_style'] ? 'acme_portfolio_items' : 'placeholder' ),
				( $max_columns )
			);

			return $output;
		}
	}


	/**
	 * ACME_Builder_Module_Blog
	 *
	 * Extended functionalities:
	 *  - added option to change post order and sorting
	 *  - added Masonry support, you can change how many columns display for your grid
	 *
	 *
	 * @since       1.1.0
	 * @package    Acme_Divi_Modules
	 * @subpackage Acme_Divi_Modules/admin
	 * @author     Mirko Bianco <mirko@acmemk.com>
	 */
	class ACME_Builder_Module_Blog extends ET_Builder_Module {
		public $plugin_name;
		public $abmb_options;
		function init() {
			$this->name       = 'ACME Blog';
			$this->slug       = 'et_pb_blog_acme';
			//$this->fb_support = true;
			$plugin_data        = apply_filters( 'acme_drop_data', null );
			$this->plugin_name = $plugin_data['plugin_name'];
			//$this->abmb_options = $plugin_data['abmb_options'];

			$this->whitelisted_fields = array(
				'fullwidth',
				'posts_number',
				'use_masonry',
				'columns',
				'random_size',
				'ds_field',
				'include_categories',
				'meta_date',
				'show_thumbnail',
				'show_content',
				'show_more',
				'orderby',
				'order',
				'show_author',
				'show_date',
				'show_categories',
				'show_comments',
				'show_pagination',
				'offset_number',
				'background_layout',
				'admin_label',
				'module_id',
				'module_class',
				'masonry_tile_background_color',
				'use_dropshadow',
				'use_overlay',
				'overlay_icon_color',
				'hover_overlay_color',
				'hover_icon',
			);

			$this->fields_defaults = array(
				'fullwidth'         => array( 'on' ),
				'posts_number'      => array( 10, 'add_default_setting' ),
				'use_masonry'       => array( 'off', 'add_default_setting' ),
				'columns'           => array( 1, 'add_default_setting' ),
				'random_size'       => array( 'off', 'add_default_setting' ),
				//'ds_field'          => array( null ),
				'meta_date'         => array( 'M j, Y', 'add_default_setting' ),
				'show_thumbnail'    => array( 'on' ),
				'show_content'      => array( 'off' ),
				'orderby'           => array( 'date' ),
				'order'             => array( 'on' ),
				'show_more'         => array( 'off' ),
				'show_author'       => array( 'on' ),
				'show_date'         => array( 'on' ),
				'show_categories'   => array( 'on' ),
				'show_comments'     => array( 'off' ),
				'show_pagination'   => array( 'on' ),
				'offset_number'     => array( 0, 'only_default_setting' ),
				'background_layout' => array( 'light' ),
				'use_dropshadow'    => array( 'off' ),
				'use_overlay'       => array( 'off' ),
			);

			$this->main_css_element = '%%order_class%% .et_pb_post';
			$this->advanced_options = array(
				'fonts' => array(
					'header' => array(
						'label'    => esc_html__( 'Header', 'et_builder' ),
						'css'      => array(
							'main' => "{$this->main_css_element} .entry-title",
							'important' => 'all',
						),
					),
					'meta' => array(
						'label'    => esc_html__( 'Meta', 'et_builder' ),
						'css'      => array(
							'main' => "{$this->main_css_element} .post-meta",
						),
					),
					'body'   => array(
						'label'    => esc_html__( 'Body', 'et_builder' ),
						'css'      => array(
							'color'        => "{$this->main_css_element}, {$this->main_css_element} .post-content *",
							'line_height' => "{$this->main_css_element} p",
						),
					),
				),
				'border' => array(
					'css'      => array(
						'main' => "%%order_class%%.et_pb_module .et_pb_post",
						'important' => 'plugin_only',
					),
				),
			);
			$this->custom_css_options = array(
				'title' => array(
					'label'    => esc_html__( 'Title', 'et_builder' ),
					'selector' => '.et_pb_post .entry-title',
				),
				'post_meta' => array(
					'label'    => esc_html__( 'Post Meta', 'et_builder' ),
					'selector' => '.et_pb_post .post-meta',
				),
				'pagenavi' => array(
					'label'    => esc_html__( 'Pagenavi', 'et_builder' ),
					'selector' => '.wp_pagenavi',
				),
				'featured_image' => array(
					'label'    => esc_html__( 'Featured Image', 'et_builder' ),
					'selector' => '.et_pb_image_container',
				),
				'read_more' => array(
					'label'    => esc_html__( 'Read More Button', 'et_builder' ),
					'selector' => '.et_pb_post .more-link',
				),
			);
		}

		function get_fields() {
			$fields = array(
				'fullwidth' => array(
					'label'             => esc_html__( 'Layout', 'et_builder' ),
					'type'              => 'select',
					'option_category'   => 'layout',
					'options'           => array(
						'on'  => esc_html__( 'Fullwidth', 'et_builder' ),
						'off' => esc_html__( 'Grid', 'et_builder' ),
					),
					'affects'           => array(
						'background_layout',
						'use_dropshadow',
						'masonry_tile_background_color',
					),
					'description'        => esc_html__( 'Toggle between the various blog layout types.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'posts_number' => array(
					'label'             => esc_html__( 'Posts Number', 'et_builder' ),
					'type'              => 'text',
					'option_category'   => 'configuration',
					'description'       => esc_html__( 'Choose how much posts you would like to display per page.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'use_masonry' => array(
					'label'             => esc_html__( 'Use Masonry', $this->plugin_name ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'affects' => array('columns','random_size'),
					'description'        => esc_html__( 'Apply a nice masonry effect and choose how many columns to display.', $this->plugin_name )
				),
				'columns' => array(
					'label'             => esc_html__( 'Masonry Columns', $this->plugin_name ),
					'type'              => 'text',
					'option_category'   => 'configuration',
					'depends_show_if'   => 'on',
					'description'       => esc_html__( 'Choose how many columns you want to display. Comma Separated Values for element widths: 1600|1024|768|480|320. This will affect the number of columns per row.', $this->plugin_name )
				),
				'random_size' => array(
					'label'             => esc_html__( 'Random Size', $this->plugin_name ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'affects' => array( 'ds_field' ),
					'depends_show_if'   => 'on',
					'description'        => esc_html__( 'Some items will display double sized. Set to No if you want to set double size elements manually or leave all the elements at the same size', $this->plugin_name )
				),
				'ds_field' => array(
					'label'             => esc_html__( 'Double Size Field', $this->plugin_name ),
					'type'              => 'text',
					'option_category'   => 'configuration',
					'depends_show_if'   => 'off',
					'description'       => esc_html__( 'If you want to display specific post in double size, define the Custom Field name you want to use. In your post you must this very Custom Field and assign a non empty value to it. For instance fill the value `divi-ds` here and add the same custom field `divi-ds` with value `1` to the posts you want to display double size. Leave blank if you want to keep all elements at the same size.', $this->plugin_name )
				),
				'include_categories' => array(
					'label'            => esc_html__( 'Include Categories', 'et_builder' ),
					'renderer'         => 'et_builder_include_categories_option',
					'option_category'  => 'basic_option',
					'renderer_options' => array(
						'use_terms' => false,
					),
					'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'meta_date' => array(
					'label'             => esc_html__( 'Meta Date Format', 'et_builder' ),
					'type'              => 'text',
					'option_category'   => 'configuration',
					'description'       => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'show_thumbnail' => array(
					'label'             => esc_html__( 'Show Featured Image', 'et_builder' ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'        => esc_html__( 'This will turn thumbnails on and off.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'show_content' => array(
					'label'             => esc_html__( 'Content', 'et_builder' ),
					'type'              => 'select',
					'option_category'   => 'configuration',
					'options'           => array(
						'off' => esc_html__( 'Show Excerpt', 'et_builder' ),
						'on'  => esc_html__( 'Show Content', 'et_builder' ),
					),
					'affects'           => array(
						'show_more',
					),
					'description'        => esc_html__( 'Showing the full content will not truncate your posts on the index page. Showing the excerpt will only display your excerpt text.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'show_more' => array(
					'label'             => esc_html__( 'Read More Button', 'et_builder' ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'off' => esc_html__( 'Off', 'et_builder' ),
						'on'  => esc_html__( 'On', 'et_builder' ),
					),
					'depends_show_if'   => 'off',
					'description'       => esc_html__( 'Here you can define whether to show "read more" link after the excerpts or not.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'orderby' => array(
					'label'             => esc_html__( 'Order By', $this->plugin_name ),
					'type'              => 'select',
					'option_category'   => 'configuration',
					'options' => array(
						'date'     => __( 'Date', $this->plugin_name ),
						'modified' => __( 'Modified Date', $this->plugin_name ),
						'title'    => __( 'Title', $this->plugin_name ),
						'name'     => __( 'Name', $this->plugin_name ),
						'ID'       => 'ID',
						'rand'     => __( 'Random Order', $this->plugin_name ),
						'author'   => __( 'Author', $this->plugin_name ),
					),
					'affects'           => array(
						'oreder_reverse',
					),
					'description'        => esc_html__( 'Apply custom order to Blog Module', $this->plugin_name ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'order' => array(
					'label'             => esc_html__( 'Reverse Order', $this->plugin_name ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'        => esc_html__( 'Turn on or off the reverse order of posts.', $this->plugin_name ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'show_author' => array(
					'label'             => esc_html__( 'Show Author', 'et_builder' ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'        => esc_html__( 'Turn on or off the author link.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'show_date' => array(
					'label'             => esc_html__( 'Show Date', 'et_builder' ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'        => esc_html__( 'Turn the date on or off.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'show_categories' => array(
					'label'             => esc_html__( 'Show Categories', 'et_builder' ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'        => esc_html__( 'Turn the category links on or off.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'show_comments' => array(
					'label'             => esc_html__( 'Show Comment Count', 'et_builder' ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'        => esc_html__( 'Turn comment count on and off.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'show_pagination' => array(
					'label'             => esc_html__( 'Show Pagination', 'et_builder' ),
					'type'              => 'yes_no_button',
					'option_category'   => 'configuration',
					'options'           => array(
						'on'  => esc_html__( 'Yes', 'et_builder' ),
						'off' => esc_html__( 'No', 'et_builder' ),
					),
					'description'        => esc_html__( 'Turn pagination on and off.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'offset_number' => array(
					'label'           => esc_html__( 'Offset Number', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'Choose how many posts you would like to offset by', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'use_overlay' => array(
					'label'             => esc_html__( 'Featured Image Overlay', 'et_builder' ),
					'type'              => 'yes_no_button',
					'option_category'   => 'layout',
					'options'           => array(
						'off' => esc_html__( 'Off', 'et_builder' ),
						'on'  => esc_html__( 'On', 'et_builder' ),
					),
					'affects'           => array(
						'overlay_icon_color',
						'hover_overlay_color',
						'hover_icon',
					),
					'description'       => esc_html__( 'If enabled, an overlay color and icon will be displayed when a visitors hovers over the featured image of a post.', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'overlay_icon_color' => array(
					'label'             => esc_html__( 'Overlay Icon Color', 'et_builder' ),
					'type'              => 'color',
					'custom_color'      => true,
					'depends_show_if'   => 'on',
					'description'       => esc_html__( 'Here you can define a custom color for the overlay icon', 'et_builder' ),
				),
				'hover_overlay_color' => array(
					'label'             => esc_html__( 'Hover Overlay Color', 'et_builder' ),
					'type'              => 'color-alpha',
					'custom_color'      => true,
					'depends_show_if'   => 'on',
					'description'       => esc_html__( 'Here you can define a custom color for the overlay', 'et_builder' ),
				),
				'hover_icon' => array(
					'label'               => esc_html__( 'Hover Icon Picker', 'et_builder' ),
					'type'                => 'text',
					'option_category'     => 'configuration',
					'class'               => array( 'et-pb-font-icon' ),
					'renderer'            => 'et_pb_get_font_icon_list',
					'renderer_with_field' => true,
					'depends_show_if'     => 'on',
					'description'         => esc_html__( 'Here you can define a custom icon for the overlay', 'et_builder' ),
					'computed_affects'   => array(
						'__posts',
					),
				),
				'background_layout' => array(
					'label'       => esc_html__( 'Text Color', 'et_builder' ),
					'type'        => 'select',
					'option_category' => 'color_option',
					'options'           => array(
						'light' => esc_html__( 'Dark', 'et_builder' ),
						'dark'  => esc_html__( 'Light', 'et_builder' ),
					),
					'depends_default' => true,
					'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
				),
				'masonry_tile_background_color' => array(
					'label'             => esc_html__( 'Grid Tile Background Color', 'et_builder' ),
					'type'              => 'color-alpha',
					'custom_color'      => true,
					'tab_slug'          => 'advanced',
					'depends_show_if'   => 'off',
					'depends_to'        => array(
						'fullwidth'
					),
				),
				'use_dropshadow' => array(
					'label'             => esc_html__( 'Use Dropshadow', 'et_builder' ),
					'type'              => 'yes_no_button',
					'option_category'   => 'layout',
					'options'           => array(
						'off' => esc_html__( 'Off', 'et_builder' ),
						'on'  => esc_html__( 'On', 'et_builder' ),
					),
					'tab_slug'          => 'advanced',
					'depends_show_if'   => 'off',
					'depends_to'        => array(
						'fullwidth'
					),
				),
				'disabled_on' => array(
					'label'           => esc_html__( 'Disable on', 'et_builder' ),
					'type'            => 'multiple_checkboxes',
					'options'         => array(
						'phone'   => esc_html__( 'Phone', 'et_builder' ),
						'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
						'desktop' => esc_html__( 'Desktop', 'et_builder' ),
					),
					'additional_att'  => 'disable_on',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
				),
				'admin_label' => array(
					'label'       => esc_html__( 'Admin Label', 'et_builder' ),
					'type'        => 'text',
					'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
				),
				'module_id' => array(
					'label'           => esc_html__( 'CSS ID', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'module_class' => array(
					'label'           => esc_html__( 'CSS Class', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'__posts' => array(
					'type' => 'computed',
					'computed_callback' => array( 'ET_Builder_Module_Blog', 'get_blog_posts' ),
					'computed_depends_on' => array(
						'fullwidth',
						'posts_number',
						'include_categories',
						'meta_date',
						'show_thumbnail',
						'show_content',
						'show_more',
						'orderby',
						'order',
						'show_author',
						'show_date',
						'show_categories',
						'show_comments',
						'show_pagination',
						'offset_number',
						'use_overlay',
						'hover_icon',
					),
				),
			);
			return $fields;
		}

		/**
		 * Get blog posts for blog module
		 *
		 * @param array   arguments that is being used by et_pb_blog
		 * @return string blog post markup
		 */
		static function get_blog_posts( $args = array(), $conditional_tags = array(), $current_page = array() ) {
			global $paged, $post, $wp_query, $et_fb_processing_shortcode_object, $et_pb_rendering_column_content;

			$global_processing_original_value = $et_fb_processing_shortcode_object;

			// Default params are combination of attributes that is used by et_pb_blog and
			// conditional tags that need to be simulated (due to AJAX nature) by passing args
			$defaults = array(
				'fullwidth'                     => '',
				'posts_number'                  => '',
				'include_categories'            => '',
				'meta_date'                     => '',
				'show_thumbnail'                => '',
				'show_content'                  => '',
				'show_author'                   => '',
				'orderby'                   => '',
				'order'                   => '',
				'show_date'                     => '',
				'show_categories'               => '',
				'show_comments'                 => '',
				'show_pagination'               => '',
				'background_layout'             => '',
				'show_more'                     => '',
				'offset_number'                 => '',
				'masonry_tile_background_color' => '',
				'use_dropshadow'                => '',
				'overlay_icon_color'            => '',
				'hover_overlay_color'           => '',
				'hover_icon'                    => '',
				'use_overlay'                   => '',
			);

			// WordPress' native conditional tag is only available during page load. It'll fail during component update because
			// et_pb_process_computed_property() is loaded in admin-ajax.php. Thus, use WordPress' conditional tags on page load and
			// rely to passed $conditional_tags for AJAX call
			$is_front_page               = et_fb_conditional_tag( 'is_front_page', $conditional_tags );
			$is_search                   = et_fb_conditional_tag( 'is_search', $conditional_tags );
			$is_single                   = et_fb_conditional_tag( 'is_single', $conditional_tags );
			$et_is_builder_plugin_active = et_fb_conditional_tag( 'et_is_builder_plugin_active', $conditional_tags );

			$container_is_closed = false;

			// remove all filters from WP audio shortcode to make sure current theme doesn't add any elements into audio module
			remove_all_filters( 'wp_audio_shortcode_library' );
			remove_all_filters( 'wp_audio_shortcode' );
			remove_all_filters( 'wp_audio_shortcode_class');

			$args = wp_parse_args( $args, $defaults );

			$overlay_output = '';
			$hover_icon = '';

			if ( 'on' === $args['use_overlay'] ) {
				$data_icon = '' !== $args['hover_icon']
					? sprintf(
						' data-icon="%1$s"',
						esc_attr( et_pb_process_font_icon( $args['hover_icon'] ) )
					)
					: '';

				$overlay_output = sprintf(
					'<span class="et_overlay%1$s"%2$s></span>',
					( '' !== $args['hover_icon'] ? ' et_pb_inline_icon' : '' ),
					$data_icon
				);
			}

			$overlay_class = 'on' === $args['use_overlay'] ? ' et_pb_has_overlay' : '';

			$query_args = array(
				'posts_per_page' => intval( $args['posts_number'] ),
				'post_status'    => 'publish',
				'order'          => $args['order'],
				'orderby'       => $args['orderby']
			);

			if ( defined( 'DOING_AJAX' ) && isset( $current_page[ 'paged'] ) ) {
				$paged = intval( $current_page[ 'paged' ] );
			} else {
				$paged = $is_front_page ? get_query_var( 'page' ) : get_query_var( 'paged' );
			}

			if ( '' !== $args['include_categories'] ) {
				$query_args['cat'] = $args['include_categories'];
			}

			if ( ! $is_search ) {
				$query_args['paged'] = $paged;
			}

			if ( '' !== $args['offset_number'] && ! empty( $args['offset_number'] ) ) {
				/**
				 * Offset + pagination don't play well. Manual offset calculation required
				 * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
				 */
				if ( $paged > 1 ) {
					$query_args['offset'] = ( ( $paged - 1 ) * intval( $args['posts_number'] ) ) + intval( $args['offset_number'] );
				} else {
					$query_args['offset'] = intval( $args['offset_number'] );
				}

				/**
				 * If no category selected and it is ajax request, the offset starts from zero instead of one. Adjust accordingly.
				 */
				if ( ! isset( $query_args['cat'] ) && defined( 'DOING_AJAX' ) ) {
					$query_args['offset'] = intval( $query_args['offset'] ) + 1;
				}
			}

			if ( $is_single ) {
				$query_args['post__not_in'][] = get_the_ID();
			}

			// Get query
			$query = new WP_Query( $query_args );

			// Keep page's $wp_query global
			$wp_query_page = $wp_query;

			// Turn page's $wp_query into this module's query
			$wp_query = $query;

			ob_start();
			if ( $query->have_posts() ) {

				while( $query->have_posts() ) {
					$query->the_post();
					global $et_fb_processing_shortcode_object;

					$global_processing_original_value = $et_fb_processing_shortcode_object;

					// reset the fb processing flag
					$et_fb_processing_shortcode_object = false;

					$thumb          = '';
					$width          = 'on' === $args['fullwidth'] ? 1080 : 400;
					$width          = (int) apply_filters( 'et_pb_blog_image_width', $width );
					$height         = 'on' === $args['fullwidth'] ? 675 : 250;
					$height         = (int) apply_filters( 'et_pb_blog_image_height', $height );
					$classtext      = 'on' === $args['fullwidth'] ? 'et_pb_post_main_image' : '';
					$titletext      = get_the_title();
					$thumbnail      = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb          = $thumbnail["thumb"];
					$no_thumb_class = '' === $thumb || 'off' === $args['show_thumbnail'] ? ' et_pb_no_thumb' : '';

					$post_format = et_pb_post_format();
					if ( in_array( $post_format, array( 'video', 'gallery' ) ) ) {
						$no_thumb_class = '';
					}

					// Print output
					?>
					<article id="" <?php post_class( 'et_pb_post clearfix' . $no_thumb_class . $overlay_class ) ?>>
						<?php
							et_divi_post_format_content();

							if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
								if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
									$video_overlay = has_post_thumbnail() ? sprintf(
										'<div class="et_pb_video_overlay" style="background-image: url(%1$s); background-size: cover;">
											<div class="et_pb_video_overlay_hover">
												<a href="#" class="et_pb_video_play"></a>
											</div>
										</div>',
										$thumb
									) : '';

									printf(
										'<div class="et_main_video_container">
											%1$s
											%2$s
										</div>',
										$video_overlay,
										$first_video
									);
								elseif ( 'gallery' === $post_format ) :
									et_pb_gallery_images( 'slider' );
								elseif ( '' !== $thumb && 'on' === $args['show_thumbnail'] ) :
									if ( 'on' !== $args['fullwidth'] ) echo '<div class="et_pb_image_container">'; ?>
									<a href="<?php esc_url( the_permalink() ); ?>" class="entry-featured-image-url">
										<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
										<?php if ( 'on' === $args['use_overlay'] ) {
											echo $overlay_output;
										} ?>
									</a>
									<?php
									if ( 'on' !== $args['fullwidth'] ) echo '</div> <!-- .et_pb_image_container -->';
								endif;
							}
						?>

						<?php if ( 'off' === $args['fullwidth'] || ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) { ?>
							<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) { ?>
								<h2 class="entry-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h2>
							<?php } ?>

							<?php
							if ( 'on' === $args['show_author'] || 'on' === $args['show_date'] || 'on' === $args['show_categories'] || 'on' === $args['show_comments'] ) {
								printf( '<p class="post-meta">%1$s %2$s %3$s %4$s %5$s %6$s %7$s</p>',
									(
									'on' === $args['show_author']
										? et_get_safe_localization( sprintf( __( 'by %s', 'et_builder' ), '<span class="author vcard">' .  et_pb_get_the_author_posts_link() . '</span>' ) )
										: ''
									),
									(
									( 'on' === $args['show_author'] && 'on' === $args['show_date'] )
										? ' | '
										: ''
									),
									(
									'on' === $args['show_date']
										? et_get_safe_localization( sprintf( __( '%s', 'et_builder' ), '<span class="published">' . esc_html( get_the_date( $args['meta_date'] ) ) . '</span>' ) )
										: ''
									),
									(
									(( 'on' === $args['show_author'] || 'on' === $args['show_date'] ) && 'on' === $args['show_categories'] )
										? ' | '
										: ''
									),
									(
									'on' === $args['show_categories']
										? get_the_category_list(', ')
										: ''
									),
									(
									(( 'on' === $args['show_author'] || 'on' === $args['show_date'] || 'on' === $args['show_categories'] ) && 'on' === $args['show_comments'])
										? ' | '
										: ''
									),
									(
									'on' === $args['show_comments']
										? sprintf( esc_html( _nx( '1 Comment', '%s Comments', get_comments_number(), 'number of comments', 'et_builder' ) ), number_format_i18n( get_comments_number() ) )
										: ''
									)
								);
							}

							$post_content = et_strip_shortcodes( et_delete_post_first_video( get_the_content() ), true );

							// reset the fb processing flag
							$et_fb_processing_shortcode_object = false;
							// set the flag to indicate that we're processing internal content
							$et_pb_rendering_column_content = true;
							// reset all the attributes required to properly generate the internal styles
							ET_Builder_Element::clean_internal_modules_styles();

							echo '<div class="post-content">';

							if ( 'on' === $args['show_content'] ) {
								global $more;

								// page builder doesn't support more tag, so display the_content() in case of post made with page builder
								if ( et_pb_is_pagebuilder_used( get_the_ID() ) ) {
									$more = 1;

									echo apply_filters( 'the_content', $post_content );

								} else {
									$more = null;
									echo apply_filters( 'the_content', et_delete_post_first_video( get_the_content( esc_html__( 'read more...', 'et_builder' ) ) ) );
								}
							} else {
								if ( has_excerpt() ) {
									the_excerpt();
								} else {
									if ( '' !== $post_content ) {
										// set the $et_fb_processing_shortcode_object to false, to retrieve the content inside truncate_post() correctly
										$et_fb_processing_shortcode_object = false;
										echo wpautop( et_delete_post_first_video( strip_shortcodes( truncate_post( 270, false, '', true ) ) ) );
										// reset the $et_fb_processing_shortcode_object to its original value
										$et_fb_processing_shortcode_object = $global_processing_original_value;
									} else {
										echo '';
									}
								}
							}

							$et_fb_processing_shortcode_object = $global_processing_original_value;
							// retrieve the styles for the modules inside Blog content
							$internal_style = ET_Builder_Element::get_style( true );
							// reset all the attributes after we retrieved styles
							ET_Builder_Element::clean_internal_modules_styles( false );
							$et_pb_rendering_column_content = false;
							// append styles to the blog content
							if ( $internal_style ) {
								printf(
									'<style type="text/css" class="et_fb_blog_inner_content_styles">
											%1$s
										</style>',
									$internal_style
								);
							}

							echo '</div>';

							if ( 'on' !== $args['show_content'] ) {
								$more = 'on' == $args['show_more'] ? sprintf( ' <a href="%1$s" class="more-link" >%2$s</a>' , esc_url( get_permalink() ), esc_html__( 'read more', 'et_builder' ) )  : '';
								echo $more;
							}
							?>
						<?php } // 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote', 'gallery' ?>
					</article>
					<?php

					$et_fb_processing_shortcode_object = $global_processing_original_value;
				} // endwhile

				if ( 'on' === $args['show_pagination'] && ! $is_search ) {
					// echo '</div> <!-- .et_pb_posts -->'; // @todo this causes closing tag issue

					$container_is_closed = true;

					if ( function_exists( 'wp_pagenavi' ) ) {
						wp_pagenavi( array(
							'query' => $query
						) );
					} else {
						if ( $et_is_builder_plugin_active ) {
							include( ET_BUILDER_PLUGIN_DIR . 'includes/navigation.php' );
						} else {
							get_template_part( 'includes/navigation', 'index' );
						}
					}
				}

				wp_reset_query();
			} else {
				if ( $et_is_builder_plugin_active ) {
					include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
				} else {
					get_template_part( 'includes/no-results', 'index' );
				}
			}

			wp_reset_postdata();

			// Reset $wp_query to its origin
			$wp_query = $wp_query_page;

			$posts = ob_get_contents();

			ob_end_clean();

			return $posts;
		}

		function shortcode_callback( $atts, $content = null, $function_name ) {
			/**
			 * Cached $wp_filter so it can be restored at the end of the callback.
			 * This is needed because this callback uses the_content filter / calls a function
			 * which uses the_content filter. WordPress doesn't support nested filter
			 */
			global $wp_filter;
			$wp_filter_cache = $wp_filter;

			$module_id           = $this->shortcode_atts['module_id'];
			$module_class        = $this->shortcode_atts['module_class'];
			$fullwidth           = $this->shortcode_atts['fullwidth'];
			$posts_number        = $this->shortcode_atts['posts_number'];
			$use_masonry         = $this->shortcode_atts['use_masonry'];
			$columns             = $this->shortcode_atts['columns'];
			$random_size         = $this->shortcode_atts['random_size'];
			$ds_field            = $this->shortcode_atts['ds_field'];
			$include_categories  = $this->shortcode_atts['include_categories'];
			$meta_date           = $this->shortcode_atts['meta_date'];
			$show_thumbnail      = $this->shortcode_atts['show_thumbnail'];
			$show_content        = $this->shortcode_atts['show_content'];
			$orderby             = $this->shortcode_atts['orderby'];
			$order               = 'on' == $this->shortcode_atts['order'] ? 'DESC' : 'ASC';
			$show_author         = $this->shortcode_atts['show_author'];
			$show_date           = $this->shortcode_atts['show_date'];
			$show_categories     = $this->shortcode_atts['show_categories'];
			$show_comments       = $this->shortcode_atts['show_comments'];
			$show_pagination     = $this->shortcode_atts['show_pagination'];
			$background_layout   = $this->shortcode_atts['background_layout'];
			$show_more           = $this->shortcode_atts['show_more'];
			$offset_number       = $this->shortcode_atts['offset_number'];
			$masonry_tile_background_color = $this->shortcode_atts['masonry_tile_background_color'];
			$use_dropshadow      = $this->shortcode_atts['use_dropshadow'];
			$overlay_icon_color  = $this->shortcode_atts['overlay_icon_color'];
			$hover_overlay_color = $this->shortcode_atts['hover_overlay_color'];
			$hover_icon          = $this->shortcode_atts['hover_icon'];
			$use_overlay         = $this->shortcode_atts['use_overlay'];

			/**
			 * Masonry setting will override grid layout
			 */
			if ( 'on' === $use_masonry ) {
				$fullwidth = 'on';
			}


			global $paged;

			$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

			$container_is_closed = false;

			// remove all filters from WP audio shortcode to make sure current theme doesn't add any elements into audio module
			remove_all_filters( 'wp_audio_shortcode_library' );
			remove_all_filters( 'wp_audio_shortcode' );
			remove_all_filters( 'wp_audio_shortcode_class');

			if ( '' !== $masonry_tile_background_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%%.et_pb_blog_grid .et_pb_post',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $masonry_tile_background_color )
					),
				) );
			}

			if ( '' !== $overlay_icon_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay:before',
					'declaration' => sprintf(
						'color: %1$s !important;',
						esc_html( $overlay_icon_color )
					),
				) );
			}

			if ( '' !== $hover_overlay_color ) {
				ET_Builder_Element::set_style( $function_name, array(
					'selector'    => '%%order_class%% .et_overlay',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $hover_overlay_color )
					),
				) );
			}

			if ( 'on' === $use_overlay ) {
				$data_icon = '' !== $hover_icon
					? sprintf(
						' data-icon="%1$s"',
						esc_attr( et_pb_process_font_icon( $hover_icon ) )
					)
					: '';

				$overlay_output = sprintf(
					'<span class="et_overlay%1$s"%2$s></span>',
					( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
					$data_icon
				);
			}

			$overlay_class = 'on' === $use_overlay ? ' et_pb_has_overlay' : '';

			if ( 'on' !== $fullwidth ){
				if ( 'on' === $use_dropshadow ) {
					$module_class .= ' et_pb_blog_grid_dropshadow';
				}

				wp_enqueue_script( 'salvattore' );

				$background_layout = 'light';
			}

			$args = array( 'posts_per_page' => (int) $posts_number );


			$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );

			if ( is_front_page() ) {
				$paged = $et_paged;
			}

			if ( '' !== $include_categories )
				$args['cat'] = $include_categories;

			if ( ! is_search() ) {
				$args['paged'] = $et_paged;
			}

			if ( '' !== $offset_number && ! empty( $offset_number ) ) {
				/**
				 * Offset + pagination don't play well. Manual offset calculation required
				 * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
				 */
				if ( $paged > 1 ) {
					$args['offset'] = ( ( $et_paged - 1 ) * intval( $posts_number ) ) + intval( $offset_number );
				} else {
					$args['offset'] = intval( $offset_number );
				}
			}

			if ( is_single() && ! isset( $args['post__not_in'] ) ) {
				$args['post__not_in'] = array( get_the_ID() );
			}

			$args['order'] = $order;
			$args['orderby'] = $orderby;


			ob_start();
			query_posts( $args );/**
			 * Masonry injection
			 */
			$firstColumn = explode( ',', $columns );
			$fColVal = intval( trim( $firstColumn[0] ) ) > 0 ? intval( 100 / intval( trim( $firstColumn[0] ) ) ) : 100;


			if ( have_posts() ) {
				while ( have_posts() ): ?>
					<?php
					the_post();

					$post_format = et_pb_post_format();

					$thumb = '';

					$width = 'on' === $fullwidth ? 1080 : 400;
					$width = (int) apply_filters( 'et_pb_blog_image_width', $width );


					$height = 'on' === $fullwidth ? 675 : 250;
					$height = (int) apply_filters( 'et_pb_blog_image_height', $height );
					$classtext = 'on' === $fullwidth ? 'et_pb_post_main_image' : '';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					$no_thumb_class = '' === $thumb || 'off' === $show_thumbnail ? ' et_pb_no_thumb' : '';

					$masonry_item = null;
					if ( 'on' === $use_masonry ) {
						$style = sprintf( ' style="width: %d%%; float: left; padding: 0 0.5%%"', $fColVal*0.99 );
						$masonry_item .= ' acme_grid-item';
						if ( 'on' === $random_size ) {
							if ( rand() % 3 == 1 ) {
								$masonry_item .= ' acme_grid-item--width2';
							}
						} else {

							$all_meta = get_post_meta( get_the_ID() );
							if ( is_array( $all_meta ) ) {
								if ( isset( $ds_field ) && isset( $all_meta[$ds_field] ) ) {
									$masonry_item .= $all_meta[ $ds_field ][0] > 0 ? ' acme_grid-item--width2' : null;
								}
							}
						}
					}


					if ( in_array( $post_format, array( 'video', 'gallery' ) ) ) {
						$no_thumb_class = '';
					} ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post clearfix' . $no_thumb_class . $overlay_class . $masonry_item  ); echo $style?>>

						<?php
							et_divi_post_format_content();

							if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
								if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
									$video_overlay = has_post_thumbnail() ? sprintf(
										'<div class="et_pb_video_overlay" style="background-image: url(%1$s); background-size: cover;">
								<div class="et_pb_video_overlay_hover">
									<a href="#" class="et_pb_video_play"></a>
								</div>
							</div>',
										$thumb
									) : '';

									printf(
										'<div class="et_main_video_container">
								%1$s
								%2$s
							</div>',
										$video_overlay,
										$first_video
									);
								elseif ( 'gallery' === $post_format ) :
									et_pb_gallery_images( 'slider' );
								elseif ( '' !== $thumb && 'on' === $show_thumbnail ) :
									if ( 'on' !== $fullwidth ) echo '<div class="et_pb_image_container">'; ?>
									<a href="<?php esc_url( the_permalink() ); ?>" class="entry-featured-image-url">
										<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
										<?php if ( 'on' === $use_overlay ) {
											echo $overlay_output;
										} ?>
									</a>
									<?php
									if ( 'on' !== $fullwidth ) echo '</div> <!-- .et_pb_image_container -->';
								endif;
							} ?>

						<?php if ( 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) { ?>
							<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) { ?>
								<h2 class="entry-title acme_grid_title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h2>
							<?php } ?>

							<?php
							if ( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories || 'on' === $show_comments ) {
								printf( '<p class="post-meta">%1$s %2$s %3$s %4$s %5$s %6$s %7$s</p>',
									(
									'on' === $show_author
										? et_get_safe_localization( sprintf( __( 'by %s', 'et_builder' ), '<span class="author vcard">' .  et_pb_get_the_author_posts_link() . '</span>' ) )
										: ''
									),
									(
									( 'on' === $show_author && 'on' === $show_date )
										? ' | '
										: ''
									),
									(
									'on' === $show_date
										? et_get_safe_localization( sprintf( __( '%s', 'et_builder' ), '<span class="published">' . esc_html( get_the_date( $meta_date ) ) . '</span>' ) )
										: ''
									),
									(
									(( 'on' === $show_author || 'on' === $show_date ) && 'on' === $show_categories)
										? ' | '
										: ''
									),
									(
									'on' === $show_categories
										? get_the_category_list(', ')
										: ''
									),
									(
									(( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories ) && 'on' === $show_comments)
										? ' | '
										: ''
									),
									(
									'on' === $show_comments
										? sprintf( esc_html( _nx( '1 Comment', '%s Comments', get_comments_number(), 'number of comments', 'et_builder' ) ), number_format_i18n( get_comments_number() ) )
										: ''
									)
								);
							}

							echo '<div class="post-content">';
							global $et_pb_rendering_column_content;

							$post_content = et_strip_shortcodes( et_delete_post_first_video( get_the_content() ), true );

							$et_pb_rendering_column_content = true;

							if ( 'on' === $show_content ) {
								global $more;

								// page builder doesn't support more tag, so display the_content() in case of post made with page builder
								if ( et_pb_is_pagebuilder_used( get_the_ID() ) ) {
									$more = 1;
									echo apply_filters( 'the_content', $post_content );
								} else {
									$more = null;
									echo apply_filters( 'the_content', et_delete_post_first_video( get_the_content( esc_html__( 'read more...', 'et_builder' ) ) ) );
								}
							} else {
								if ( has_excerpt() ) {
									the_excerpt();
								} else {
									echo wpautop( et_delete_post_first_video( strip_shortcodes( truncate_post( 270, false, '', true ) ) ) );
								}
							}

							$et_pb_rendering_column_content = false;

							if ( 'on' !== $show_content ) {
								$more = 'on' == $show_more ? sprintf( ' <a href="%1$s" class="more-link" >%2$s</a>' , esc_url( get_permalink() ), esc_html__( 'read more', 'et_builder' ) )  : '';
								echo $more;
							}

							echo '</div>';
							?>
						<?php } // 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote', 'gallery' ?>

					</article> <!-- .et_pb_post -->

				<?php endwhile;?>
				<?php
				if ( 'on' === $show_pagination && ! is_search() ) {
					echo '</div> <!-- .et_pb_posts -->';

					$container_is_closed = true;

					if ( function_exists( 'wp_pagenavi' ) ) {
						wp_pagenavi();
					} else {
						if ( et_is_builder_plugin_active() ) {
							include( ET_BUILDER_PLUGIN_DIR . 'includes/navigation.php' );
						} else {
							get_template_part( 'includes/navigation', 'index' );
						}
					}
				}

				wp_reset_query();
			} else {
				if ( et_is_builder_plugin_active() ) {
					include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
				} else {
					get_template_part( 'includes/no-results', 'index' );
				}
			}

			$posts = ob_get_contents();

			ob_end_clean();

			$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

			$output = sprintf(
				'<div%5$s class="%1$s%3$s%6$s"%7$s>
				%2$s
			%4$s',
				( 'on' === $fullwidth ? 'et_pb_posts' : 'et_pb_blog_grid clearfix' ),
				$posts,
				esc_attr( $class ),
				( ! $container_is_closed ? '</div> <!-- .et_pb_posts -->' : '' ),
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
				( 'on' !== $fullwidth ? ' data-columns' : '' )
			);
			if ( 'on' !== $fullwidth )
				$output = sprintf( '<div class="et_pb_blog_grid_wrapper">%1$s</div>', $output );
			if('on'===$use_masonry) {
				$output = sprintf( '<div class="acme_grid" %2$s><div class="acme_grid_sizer" style="width:%3$s;"></div>%1$s</div>',
					$output,
					'data-acme-columns="' . $columns . '"',
					$fColVal . '%'
				);
			}
			// Restore $wp_filter
			$wp_filter = $wp_filter_cache;
			unset($wp_filter_cache);

			return $output;
		}

	}


	/**ACME_Builder_Module_Slide_In
	 *
	 */

	class ACME_Builder_Module_Slide_In extends ET_Builder_Module {
		public $plugin_name;
		function init() {
			$this->name       = esc_html__( 'ACME Slide In', 'et_builder' );
			$this->slug       = 'et_pb_cta_acme';
			$this->fb_support = true;
			$plugin_data        = apply_filters( 'acme_drop_data', null );
			$this->plugin_name = $plugin_data['plugin_name'];

			$this->whitelisted_fields = array(
				'title',
				'button_url',
				'url_new_window',
				'button_text',
				'background_color',
				'slidein_height',
				'cookie_expire',
				'closeb_bgcolor',
				'closeb_color',
				'background_layout',
				'text_orientation',
				'content_new',
				'admin_label',
				'module_id',
				'module_class',
				'max_width',
				'max_width_tablet',
				'max_width_phone',
				'max_width_last_edited',
				'custom_button'
			);

			$this->fields_defaults = array(
				'url_new_window'    => array( 'off' ),
				'background_color'  => array( et_builder_accent_color(), 'add_default_setting' ),
				'closeb_bgcolor'  => array( et_builder_accent_color(), 'add_default_setting' ),
				'closeb_color'  => array( et_builder_accent_color(), 'add_default_setting' ),
				'background_layout' => array( 'dark' ),
				'text_orientation'  => array( 'center' ),
				'slidein_height'    => array( '60px' )
			);

			$this->main_css_element = '%%order_class%%.et_pb_promo';
			$this->advanced_options = array(
				'fonts' => array(
					'header' => array(
						'label'    => esc_html__( 'Header', 'et_builder' ),
						'css'      => array(
							'main' => "{$this->main_css_element} h2",
							'important' => 'all',
						),
					),
					'body'   => array(
						'label'    => esc_html__( 'Body', 'et_builder' ),
						'css'      => array(
							'line_height' => "{$this->main_css_element} p",
							'plugin_main' => "{$this->main_css_element} p"
						),
					),
				),
				'border' => array(),
				'custom_margin_padding' => array(
					'css' => array(
						'important' => 'all',
					),
				)
			);
			$this->custom_css_options = array(
				'promo_button' => array(
					'label'    => esc_html__( 'Promo Button', 'et_builder' ),
					'selector' => '.et_pb_promo .et_pb_button.et_pb_promo_button',
					'no_space_before_selector' => true,
				)
			);
		}

		function get_fields() {
			$fields = array(
				'title'                 => array(
					'label'           => esc_html__( 'Title', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Input title here.', $this->plugin_name ),
				),
				'button_url'            => array(
					'label'           => esc_html__( 'Button URL', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Input the destination URL for your Slide button.', $this->plugin_name ),
				),
				'url_new_window'        => array(
					'label'           => esc_html__( 'Url Opens', 'et_builder' ),
					'type'            => 'select',
					'option_category' => 'configuration',
					'options'         => array(
						'off' => esc_html__( 'In The Same Window', 'et_builder' ),
						'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
					),
					'description'     => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				),
				'button_text'           => array(
					'label'           => esc_html__( 'Button Text', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Input your desired button text, or leave blank for no button.', 'et_builder' ),
				),
				'background_color'      => array(
					'label'       => esc_html__( 'Background Color', 'et_builder' ),
					'type'        => 'color-alpha',
					'description' => esc_html__( 'Here you can define a custom background color for your Slide In.', $this->plugin_name ),
				),
				'background_layout'     => array(
					'label'           => esc_html__( 'Text Color', 'et_builder' ),
					'type'            => 'select',
					'option_category' => 'color_option',
					'options'         => array(
						'dark'  => esc_html__( 'Light', 'et_builder' ),
						'light' => esc_html__( 'Dark', 'et_builder' ),
					),
					'description'     => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
				),
				'text_orientation'      => array(
					'label'           => esc_html__( 'Text Orientation', 'et_builder' ),
					'type'            => 'select',
					'option_category' => 'layout',
					'options'         => et_builder_get_text_orientation_options(),
					'description'     => esc_html__( 'This will adjust the alignment of the module text.', 'et_builder' ),
				),
				'content_new'           => array(
					'label'           => esc_html__( 'Content', 'et_builder' ),
					'type'            => 'tiny_mce',
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Input the main text content for your module here.', 'et_builder' ),
				),
				'slidein_height'        => array(
					'label' => esc_html__( 'Slide Height', $this->plugin_name ),
					'type'  => 'text',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'description'     => esc_html__( 'Here you can set the Slide In height in pixels. Default value is 60px', $this->plugin_name ),
				),
				'cookie_expire'        => array(
					'label' => esc_html__( 'Cookie Expiration time', $this->plugin_name ),
					'type'  => 'text',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'description'     => esc_html__( 'Days before slide in is shown again. Default value is 1 day', $this->plugin_name ),
				),
				'closeb_bgcolor'        => array(
					'label'       => esc_html__( 'Close Btn Bg Color', $this->plugin_name ),
					'type'        => 'color-alpha',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'description' => esc_html__( 'Here you can define a custom background color for Close Button.', 'et_builder' ),
				),
				'closeb_color'          => array(
					'label'       => esc_html__( 'Close Btn Color', $this->plugin_name ),
					'type'        => 'color-alpha',
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'description' => esc_html__( 'Here you can define a custom foreground color for Close.', 'et_builder' ),
				),
				'disabled_on'           => array(
					'label'           => esc_html__( 'Disable on', 'et_builder' ),
					'type'            => 'multiple_checkboxes',
					'options'         => array(
						'phone'   => esc_html__( 'Phone', 'et_builder' ),
						'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
						'desktop' => esc_html__( 'Desktop', 'et_builder' ),
					),
					'additional_att'  => 'disable_on',
					'option_category' => 'configuration',
					'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
				),
				'admin_label'           => array(
					'label'       => esc_html__( 'Admin Label', 'et_builder' ),
					'type'        => 'text',
					'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
				),
				'module_id'             => array(
					'label'           => esc_html__( 'CSS ID', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'module_class'          => array(
					'label'           => esc_html__( 'CSS Class', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				)
			);

			return $fields;
		}

		function shortcode_callback( $atts, $content = null, $function_name ) {
			$module_id            = $this->shortcode_atts['module_id'];
			$module_class         = $this->shortcode_atts['module_class'];
			$title                = $this->shortcode_atts['title'];
			$button_url           = $this->shortcode_atts['button_url'];
			$button_text          = $this->shortcode_atts['button_text'];
			$background_color     = $this->shortcode_atts['background_color'];
			$background_layout    = $this->shortcode_atts['background_layout'];
			$text_orientation     = $this->shortcode_atts['text_orientation'];
			$use_background_color = $this->shortcode_atts['use_background_color'];
			$url_new_window       = $this->shortcode_atts['url_new_window'];
			$custom_icon          = $this->shortcode_atts['button_icon'];
			$button_custom        = $this->shortcode_atts['custom_button'];
			$slidein_height       = $this->shortcode_atts['slidein_height'];
			$closeb_bgcolor       = $this->shortcode_atts['closeb_bgcolor'];
			$closeb_color         = $this->shortcode_atts['closeb_color'];
			$cookie_expire        = $this->shortcode_atts['cookie_expire'];

			$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

			if ( empty( $slidein_height ) ) {
				$slidein_height = 60;
			}
			$slidein_height = substr( $slidein_height, - 2 ) == 'px' ? $slidein_height : $slidein_height . 'px';

			if ( empty( $cookie_expire ) ) {
				$cookie_expire = 1;
			}
			if ( is_rtl() && 'left' === $text_orientation ) {
				$text_orientation = 'right';
			}

			$class = " et_pb_module et_pb_bg_layout_{$background_layout} et_pb_text_align_{$text_orientation}";

			$promocss = "
<style id=\"et-promo-slide-in\">

.promo-slide-in {
    position: fixed;
    z-index: 9;
    height: $slidein_height;
    -webkit-transition: all .5s ease;
    transition: all .5s ease;
    top: 0;
    left: 0;
    right: 0;
    background: $background_color;
    overflow:hidden;
    width:100%;
    -webkit-animation:promo-slide-in 2s ease;
    animation:promo-slide-in 2s ease;
}
.promo-slide-in-closed {
    -webkit-animation:promo-slide-out 1s ease;
    animation:promo-slide-out 1s ease;
}
@-webkit-keyframes promo-slide-in {
    0% {
        background:#ffffff;
        height: 0;
    }
    50 % {
        height: $slidein_height;
    }
    100 % {
        background: $background_color;
        height: $slidein_height;
    }
}
@keyframes promo-slide-in {
    0% {
        background:#ffffff;
        height: 0;
    }
    50 % {
        height: $slidein_height;
    }
    100 % {
        background: $background_color;
        height: $slidein_height;
    }
}
@-webkit-keyframes promo-slide-out {
    0% {
        background: $background_color;
        height: $slidein_height;
    }
    100 % {
        background: #ffffff;
        height: 0;
    }
}
@keyframes promo-slide-out {
    0 % {
        background: $background_color;
        height: $slidein_height;
    }
    100% {
        background:#ffffff;
        height: 0;
    }
}
@-webkit-keyframes promo-fade-in {
    0 % {
        -webkit-transform: scale(.5);
        transform: scale(.5);
        opacity: 0;
    }
    100 % {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 1;
    }
}
@keyframes promo-fade-in {
    0 % {
        -webkit-transform: scale(.5);
        transform: scale(.5);
        opacity: 0;
    }
    100 % {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 1;
    }
}
.promo-slide-in-close-promo {
    position: absolute;
    right: 20px;
    top: 16px;
    width: 32px;
    height: 32px;
    clear: both;
    cursor: pointer;
    background-color: $closeb_bgcolor;
    color: $closeb_color;
    -webkit-animation: promo-fade-in 1s ease;
    animation: promo-fade-in 1s ease;
}
.promo-slide-in-content {
    width: 960px;
    margin: 0 auto;
    text-align: center;
    -webkit-animation: promo-fade-in 1s ease;
    animation: promo-fade-in 1s ease;
    position: relative;
}
.promo-slide-in-content-inner {
    margin: 0 auto;
}
.promo-slide-in-content p {
    margin: 17px 0 0 127px;
    padding: 0;
    display: inline-block;
    float: left;
    font-size: 24px;
}
.fixed-nav-page-container {
    padding-top: 130px !important;
}
.fixed-nav-main-header {
    top: $slidein_height !important;
}
.nonfixed-nav-main-header {
    padding-top: $slidein_height;
}

#main-content {
	padding-top: $slidein_height;
}
@media(max-width: 980px) {
    .promo-slide-in-content p {
        font-size: 20px;
    }

    .promo-slide-in-button {
        padding: 5px 17px;
        font-size: 12px;
    }
}
@media(max-width: 775px) {
    .promo-slide-in-content {
        width: 100%;
    }

    .promo-slide-in-content p {
        margin: 0;
        font-size: 15px;
        width: 60%;
        line-height: 1.3em;
        position: absolute;
        left: 5%;
        padding-top: 3%;
    }

    .promo-slide-in-button {
        padding: 4px 12px;
        font-size: 10px;
        margin: 14px 0 0 0px;
        position: absolute;
        right: 60px;
    }
}
@media(min-width: 665px) and(max-width: 775px) {
    .promo-slide-in-content p {
        font-size: 18px;
    }

    .promo-slide-in-button {
        font-size: 12px;
    }
}

</style>";
			//apply_filters( 'acme_debug', $promocss );
			$promohtml = sprintf(
				'<div class="promo-slide-in"%5$s>
					<div class="et_pb_promo promo-slide-in-content%4$s%6$s"%7$s>
						<div class="et_pb_promo_description promo-slide-in-content-inner">
							%1$s
							%2$s
						</div>
					%3$s
					</div>
					<div class="promo-slide-in-close-promo icon_close"></div>
				</div>',
				( '' !== $title ? '<h2>' . esc_html( $title ) . '</h2>' : '' ),                                 //1
				$this->shortcode_content,                                                                       //2
				(                                                                                               //3
				'' !== $button_url && '' !== $button_text
					? sprintf( '<a class="et_pb_promo_button et_pb_button%5$s" href="%1$s"%3$s%4$s>%2$s</a>',
					esc_url( $button_url ),
					esc_html( $button_text ),
					( 'on' === $url_new_window ? ' target="_blank"' : '' ),
					'' !== $custom_icon && 'on' === $button_custom ? sprintf(
						' data-icon="%1$s"',
						esc_attr( et_pb_process_font_icon( $custom_icon ) )
					) : '',
					'' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : ''
				)
					: ''
				),
				esc_attr( $class ),                                                                             //4
				( 'on' === $use_background_color                                                                //5
					? sprintf( ' style="background-color: %1$s;"', esc_attr( $background_color ) )
					: ''
				),
				( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),               //6
				( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' )                    //7
			);
			$output = sprintf( '<div></div>
<script>
    function elegantPromo(a) {
        function l(a, b) {
            return "undefined" == typeof a ? b : a
        }

        function m(a) {
            var b = 24 * a * 60 * 60 * 1e3,
                c = new Date;
            return c.setTime(c.getTime() + b), "; expires=" + c.toGMTString() + "; path=/"
        }

        function n(a, d, e) {
            document.cookie = a + "=; expires=-1; path=/", "false" === e ? document.cookie = a + "=" + d + "; path=/" : "long" === e ? document.cookie = a + "=" + d + c : document.cookie = a + "=" + d + b
        }

        function o() {
            jQuery("head").append(e), jQuery("body").prepend(d), jQuery(".promo-slide-in-button").on("click", function() {
                p()
            }), jQuery(".promo-slide-in-close-promo").on("click", function() {
                p(), jQuery(".promo-slide-in").addClass("promo-slide-in-closed").delay(1e3).queue(function(a) {
                    jQuery(this).hide(), a()
                })
            })
        }

        function p() {
            new_value = "closed", n(i, new_value, "true")
        }

        function r() {
            var a = document.cookie.split("; ").reduce(function(a, b) {
                var c = b.split("=");
                return a[c[0]] = c[1], a
            }, {});
            return a
        }

        function s(a) {
            var b = "; " + document.cookie,
                c = b.split("; " + a + "=");
            if (2 == c.length) return c.pop().split(";").shift()
        }
        var a = a || {},
            b = m(a.cookieExpire) || "",
            c = m(a.longExpire) || "",
            d = l(a.promohtml, ""),
            e = l(a.promocss, ""),
            h = (l(a.promopage, ""), document.getElementsByTagName("html")[0], r()),
            i = "ACME_Slide_In_Cookie",
            k = (h[i], s("ACME_Slide_In_Cookie"));
        if (!k) {
            base_value = "open", document.cookie = i + "=" + base_value + b;
            var k = s("ACME_Slide_In_Cookie")
        }
        "open" === k && o()
    }
    var _elegantPromo = elegantPromo({
        cookieExpire: %d,
        longExpire: 365,
        promopage: "gallery",
        promocss: \'%s\',
        promohtml: \'%s\'
    });
</script>
<script type="text/javascript">
    if (jQuery("body").find("div.promo-slide-in").length > 0) {
        if (jQuery("body").hasClass("et_non_fixed_nav")) {
            jQuery(".et_non_fixed_nav #main-header").addClass("nonfixed-nav-main-header");
        }
        if (jQuery("body").hasClass("et_fixed_nav")) {
            jQuery(".et_fixed_nav.et_show_nav #page-container").addClass("fixed-nav-page-container");
            jQuery(".et_fixed_nav #main-header").addClass("fixed-nav-main-header");
        }
    }
    jQuery(".promo-slide-in .promo-slide-in-close-promo").click(function() {
        jQuery(this).parent().hide();
        if (jQuery("body").hasClass("et_fixed_nav")) {
            jQuery(".et_fixed_nav.et_show_nav #page-container").removeClass("fixed-nav-page-container");
            jQuery(".et_fixed_nav #main-header").removeClass("fixed-nav-main-header");
        }
        if (jQuery("body").hasClass("et_non_fixed_nav")) {
            jQuery(".et_non_fixed_nav #main-header").removeClass("nonfixed-nav-main-header");
        }
    });
</script>',$cookie_expire, preg_replace( "/\n/", "", $promocss ), preg_replace( "/\n/", "", $promohtml ) );

			/*	$output = sprintf(
					'<div%6$s class="et_pb_promo%4$s%7$s%8$s"%5$s>
					<div class="et_pb_promo_description">
						%1$s
						%2$s
					</div>
					%3$s
				</div>',
					( '' !== $title ? '<h2>' . esc_html( $title ) . '</h2>' : '' ),                                 //1
					$this->shortcode_content,                                                                       //2
					(                                                                                               //3
					'' !== $button_url && '' !== $button_text
						? sprintf( '<a class="et_pb_promo_button et_pb_button%5$s" href="%1$s"%3$s%4$s>%2$s</a>',
						esc_url( $button_url ),
						esc_html( $button_text ),
						( 'on' === $url_new_window ? ' target="_blank"' : '' ),
						'' !== $custom_icon && 'on' === $button_custom ? sprintf(
							' data-icon="%1$s"',
							esc_attr( et_pb_process_font_icon( $custom_icon ) )
						) : '',
						'' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : ''
					)
						: ''
					),
					esc_attr( $class ),                                                                             //4
					( 'on' === $use_background_color                                                                //5
						? sprintf( ' style="background-color: %1$s;"', esc_attr( $background_color ) )
						: ''
					),
					( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),                   //6
					( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),                  //7
					( 'on' !== $use_background_color ? ' et_pb_no_bg' : '' )                                        //8
				);*/

			return $output;
		}
	}

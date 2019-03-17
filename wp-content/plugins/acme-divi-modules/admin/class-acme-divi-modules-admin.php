<?php

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * @link       http://acmemk.com
	 * @since      1.0.0
	 *
	 * @package    Acme_Divi_Modules
	 * @subpackage Acme_Divi_Modules/admin
	 */

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the admin-specific stylesheet and JavaScript.
	 *
	 * @package    Acme_Divi_Modules
	 * @subpackage Acme_Divi_Modules/admin
	 * @author     Mirko Bianco <mirko@acmemk.com>
	 */
	class Acme_Divi_Modules_Admin {

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string $plugin_name The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string $version The current version of this plugin.
		 */
		private $version;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 *
		 * @param      string $plugin_name The name of this plugin.
		 * @param      string $version The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->version     = $version;
			$this->diviClassLoaded = false;
			$this->taxonomy = isset( $_REQUEST['taxonomy'] ) ? $_REQUEST['taxonomy'] : null;
			$this->options = get_option( $this->plugin_name );
			$this->abmb_options = get_option( $this->plugin_name . '-abmb' );
			$this->abmp_options = get_option( $this->plugin_name . '-abmp' );
			$this->abmsi_options = get_option( $this->plugin_name . '-abmsi' );
			$this->et_images = array(
				'et-pb-post-main-image'               => '400x250 crop',
				'et-pb-post-main-image-fullwidth'     => '1080x675 crop',
				'et-pb-portfolio-image'               => '400x284 crop',
				'et-pb-portfolio-module-image'        => '510x382 crop',
				'et-pb-portfolio-image-single'        => '1080x9999 no-crop',
				'et-pb-gallery-module-image-portrait' => '400x516 crop'
			);


			define ( 'ACME_DIVI_MODULES_NAME', $this->plugin_name );

		}

		/**
		 * Make plugin name and plugin options available outside this class
		 *
		 * @since   1.0.0
		 *
		 * @return array
		 */
		public function drop_plugin_data(){
			$array = array(
				"divi_exists"   => function_exists( 'et_builder_should_load_framework' ),
				"plugin_name"   => $this->plugin_name,
				"main_options"  => $this->options,
				"abmb_options"  => $this->abmb_options,
				"abmp_options"  => $this->abmp_options,
				"abmsi_options" => $this->abmsi_options,
				"et_images"     => $this->et_images,
			);

			return $array;
		}

		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles() {

			wp_enqueue_style( 'jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/acme-divi-modules-admin.css', array(), $this->version, 'all' );

		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/acme-divi-modules-admin.js', array( 'jquery','jquery-ui-tabs','jquery-ui-accordion' ), $this->version, true );

		}

		/**
		 * Register the administration menu for this plugin into the WordPress Dashboard menu.
		 *
		 * @since    1.0.0
		 */

		public function add_plugin_admin_menu() {
			$parent = 'acme_plugin_panel';

			$this->create_acme_admin_menu();
			add_submenu_page( $parent, 'ACME Divi Modules Setup', 'Divi Modules', 'manage_options', $this->plugin_name, array(
				$this,
				'display_plugin_setup_page'
			) );
			remove_submenu_page( $parent, 'acme_plugin_panel' );
			/*add_options_page( 'ACME Divi Modules Setup', 'ACME Modules', 'manage_options', $this->plugin_name, array(
					$this,
					'display_plugin_setup_page'
				)
			);*/
		}

		/**
		 * If not exists, create a ACME Menu for all plugins
		 */
		public function create_acme_admin_menu() {
			global $admin_page_hooks;
			if( ! isset( $admin_page_hooks['acme_plugin_panel'] ) ){
				add_menu_page( 'acme_plugin_panel', 'ACME', 'manage_options', 'acme_plugin_panel', NULL, 'dashicons-carrot', 81 );
			}

			return false;
		}

		/**
		 * Add settings action link to the plugins page.
		 *
		 * @since    1.0.0
		 */

		public function add_action_links( $links ) {
			/*
			*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
			*/
			$settings_link = array(
				'<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>',
			);

			return array_merge( $settings_link, $links );

		}
		public function display_plugin_setup_page() {
			$this->enqueue_styles();
			$this->enqueue_scripts();
			include_once( 'partials/acme-divi-modules-admin-display.php' );
		}

		/**
		 * ABMB - ACME Builder Module Blog Presets Validation
		 *
		 * @since    1.1.0
		 */
		public function validate_abmb($input) {
			$valid = array();

			$valid['abmb_enabled'] = (isset($input['abmb_enabled']) && !empty($input['abmb_enabled'])) ? 1 : 0;


			return $valid;
		}

		/**
		 * ABMB - ACME Builder Module Blog Presets Validation
		 *
		 * @since    1.1.0
		 */
		public function validate_abmsi($input) {
			$valid = array();

			$valid['abmsi_enabled'] = (isset($input['abmsi_enabled']) && !empty($input['abmsi_enabled'])) ? 1 : 0;


			return $valid;
		}

		/**
		 * ABMP - ACME Builder Module Portfolio Presets Validation
		 *
		 * @since    1.0.0
		 */
		public function validate_abmp($input) {
			$valid = array();

			$valid['abmp_enabled'] = (isset($input['abmp_enabled']) && !empty($input['abmp_enabled'])) ? 1 : 0;


			if(is_array($input['abmp_preset'])) {
				foreach($input['abmp_preset'] as $id_preset){
					if ( isset($input['abmp'][ $id_preset ]['name'])&&strlen($input['abmp'][ $id_preset ]['name'])>0 ) {
						//sanitize comma separated values
						$input['abmp'][ $id_preset ]['post_meta']           = str_replace( ' ', '', $input['abmp'][ $id_preset ]['post_meta'] );
						$valid['abmp_preset'][ $id_preset ]['post_meta']    = sanitize_text_field( $input['abmp'][ $id_preset ]['post_meta'] );
						$valid['abmp_preset'][ $id_preset ]['name']         = sanitize_text_field( $input['abmp'][ $id_preset ]['name'] );
						$valid['abmp_preset'][ $id_preset ]['post_type']    = sanitize_title( $input['abmp'][ $id_preset ]['post_type'] );
						$valid['abmp_preset'][ $id_preset ]['abmp_order']   = sanitize_text_field( $input['abmp'][ $id_preset ]['abmp_order'] );
						$valid['abmp_preset'][ $id_preset ]['abmp_orderby'] = sanitize_text_field( $input['abmp'][ $id_preset ]['abmp_orderby'] );
						$valid['abmp_preset'][ $id_preset ]['taxonomy']     = sanitize_title( $input['abmp'][ $id_preset ]['taxonomy'] );
						$valid['abmp_preset'][ $id_preset ]['href']         = sanitize_title( $input['abmp'][ $id_preset ]['href'] );
						$valid['abmp_preset'][ $id_preset ]['fw_style']     = ( isset( $input['abmp'][ $id_preset ]['fw_style'] ) && ! empty( $input['abmp'][ $id_preset ]['fw_style'] ) ? 1 : 0 );
						if ( is_array( $input['abmp'][ $id_preset ]['terms'] ) ) {
							foreach ( $input['abmp'][ $id_preset ]['terms'] as $term_id => $term_name ) {
								$valid['abmp_preset'][ $id_preset ]['terms'] [ $term_id ] = sanitize_text_field( $term_name );
							}
						}
					} else {
						unset( $input['abmp'][ $id_preset ] );
						unset( $input['abmp_preset'][ $id_preset ] );
					}
				}
				$valid['abmp_presets'] = implode( ',', array_keys($input['abmp_preset']) );
			}

			return $valid;
		}

		/**
		 * Main Options Validation
		 * @param $input
		 *
		 * @return array
		 */
		public function validate($input){
			$valid = array();
			$valid['adm_slug'] = sanitize_title( $input['adm_slug'] );
			/**
			 * Extending PB to additional post type loop.
			 * We also need to write some specific CSS
			 */
			$post_types_array = apply_filters( 'acme_get_post_types', false );
			foreach ($post_types_array as $post_type){
				$curID='adm_use_pb_' . $post_type;
				if ( isset( $input[ $curID ] ) && ! empty( $input[ $curID ] ) ) {
					$valid[ $curID ] = 1;
				}
			}
			foreach ( array_keys($this->et_images) as $img ) {
				if ( is_array( $input[ $img ] ) ) {
					$valid[ $img ]['w']    = sanitize_text_field( $input[ $img ]['w'] );
					$valid[ $img ]['h']    = sanitize_text_field( $input[ $img ]['h'] );
					$valid[ $img ]['crop'] = isset( $input[ $img ]['crop'] ) && ! empty( $input[ $img ]['crop'] ) ? 1 : 0;
				}
			}


			return $valid;
		}

		/**
		 * Registration of Acme Blog Module options
		 * since 1.1.0
		 */
		public function abmb_options_update() {
			register_setting( $this->plugin_name . '-abmb', $this->plugin_name . '-abmb', array( $this, 'validate_abmb' ) );
		}
		/**
		 * Registration of Acme Slide In Module options
		 * since 1.3.0
		 */
		public function abmsi_options_update() {
			register_setting( $this->plugin_name . '-abmsi', $this->plugin_name . '-abmsi', array( $this, 'validate_abmsi' ) );
		}

		/**
		 * Registration of Acme Portfolio Module options
		 * since 1.0.0
		 */
		public function abmp_options_update() {
			register_setting( $this->plugin_name . '-abmp', $this->plugin_name . '-abmp', array( $this, 'validate_abmp' ) );
		}

		/**
		 * Registration of Main options
		 * since 1.0.0
		 */
		public function options_update() {
			register_setting( $this->plugin_name , $this->plugin_name , array( $this, 'validate' ) );
			$this->adm_write_css( 'apt' );
		}



		/**
		 * Check if classes are included.
		 *
		 * @since    1.0.0
		 */

		public function include_modules() {
			if ( false === $this->diviClassLoaded ) {
				/**
				 * All the custom Modules.
				 */
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acme-divi-modules-modules.php';
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-acme-divi-modules-functions.php';
			}
			$this->diviClassLoaded = true;
		}

		/**
		 * Retrieve the post types used by the CMS
		 *
		 * @since   1.0.0
		 *
		 * @return array
		 */
		public function get_post_types(){
			$array = get_post_types( array( 'public' => true ) );
			$response = array();

			foreach ( $array as $post_type ) {
				if ( count( get_object_taxonomies( $post_type ) ) > 0 ) {
					$response[] = $post_type;
				}
			}

			return $response;
		}

		/**
		 * Retrieve the taxonomies used for passed post_type
		 *
		 * @since   1.0.0
		 *
		 * @param bool      $noAjax      outputs a simple array or a JSON array
		 * @param string    $post_type   passed post_type
		 *
		 * @return array
		 */
		public function get_taxonomies($noAjax = false, $post_type = null) {
			if ( null === $post_type ) {
				$post_type = $_POST['post_type'];
			}
			$array = get_object_taxonomies( $post_type );

			if ( true == $noAjax ) {
				return $array;
			}

			echo json_encode( $array );
			wp_die();

		}

		/**
		 * Retrieve terms for passed taxonomy
		 *
		 * @since   1.0.0
		 *
		 * @param string $taxonomy  passed taxonomy
		 *
		 * @return array
		 */
		public function get_terms( $taxonomy = null ) {

			if ( null === $taxonomy ) {
				$taxonomy = $_POST['taxonomy'];
			}
			$array = get_terms( array(
					'taxonomy' => $taxonomy
				)
			);

			$terms = null;
			foreach ( $array as $row ) {
				$terms[ $row->term_id ] = $row->name;
			}


			return $terms;

		}

		/**
		 * Write CSS
		 */
		private function adm_write_css($filename) {
			$ext    = 'css';
			$file   = plugin_dir_path( __FILE__ ) . '../public/css/' . $this->plugin_name . '-' . $filename . '.' . $ext;

			/**
			 * Create Content
			 */

			$handle = fopen( $file, "w" );
			$content = $this->adm_create_css_content();
			fwrite( $handle, $content );
			fclose( $handle );
			touch( $file );

			return false;
		}

		/**
		 * Additional CSS content creation
		 *
		 * @since   1.2.0
		 *
		 * @return string
		 */
		private function adm_create_css_content(){
			$response = null;
			/**
			 * Let's retrieve additional content for Page Builder on additional Post Types
			 */
			//loop through post types and saved options and save value to array
			$post_types_array = apply_filters( 'acme_get_post_types', false );
			foreach ( $post_types_array as $post_type ) {
				$curID='adm_use_pb_' . $post_type;
				if ( isset( $this->options[ $curID ] ) && $this->options[ $curID ] > 0 ) {
					$pt[] = $post_type;
				}
			}
			//let's build the css
			if ( isset( $pt ) && is_array( $pt ) ) {
				foreach ( $pt as $post_type ) {
					$css_obj1[] = sprintf( '.et_pb_pagebuilder_layout.single-%s #page-container .et_pb_row', $post_type );
					$css_obj2[] = sprintf( '.et_pb_pagebuilder_layout.single-%s #page-container .et_pb_with_background .et_pb_row', $post_type );
				}
				$myCSS = "/* PAGE BUILDER FOR ADDITIONAL POST TYPES */\n\n";
				$myCSS .= sprintf( "%s {\n\twidth: 100%%;\n}\n\n", implode( ",\n", $css_obj1 ) );
				$myCSS .= sprintf( "%s {\n\twidth: 80%%;\n}\n\n", implode( ",\n", $css_obj2 ) );
			}
			$response .= $myCSS;

			return $response;
	}

		/**
		 *
		 * MAIN FUNCTIONS
		 *
		 */


		/**
		 * Change current 'project' slug
		 *
		 * @since   1.0.0
		 *
		 * @return array
		 */
		public function replace_project_slug(){
			$slug = array ( 'slug' => $this->options['adm_slug'] );

			return $slug;

		}

		/**
		 * Extend PB to additional Post Types
		 *
		 * @since 1.2.0
		 *
		 * @return array
		 */
		public function adm_et_builder_post_types($post_types){
			$post_types_array = apply_filters( 'acme_get_post_types', false );
			foreach ( $post_types_array as $pt ) {
				$curID='adm_use_pb_' . $pt;
				if ( isset( $this->options[ $curID ] ) && $this->options[ $curID ] > 0 ) {
					$post_types[] = $pt;
				}
			}

			return $post_types;
		}

		/**
		 * Load the ACME Module Blog (abmb)
		 * @since 1.1.0
		 */
		public function ACME_Module_Blog(){
			$this->include_modules();
			if ( isset( $this->abmb_options['abmb_enabled'] ) && $this->abmb_options['abmb_enabled'] > 0 ) {
				$acme_module = new ACME_Builder_Module_Blog();
				add_shortcode( 'et_pb_blog_acme', array( $acme_module, '_shortcode_callback' ) );
			}
		}

		/**
		 * Load the ACME Module Portfolio (abmp)
		 * @since 1.0
		 */
		public function ACME_Module_Portfolio() {
			$this->include_modules();
			if ( isset( $this->abmp_options['abmp_enabled'] ) && $this->abmp_options['abmp_enabled'] > 0 ) {
				$acme_module = new ACME_Builder_Module_Portfolio();
				add_shortcode( 'et_pb_portfolio_acme', array( $acme_module, '_shortcode_callback' ) );
			}
		}

		/**
		 * Load the ACME Module Fullwidth Portfolio (abmp)
		 * @since 1.0
		 */
		public function ACME_Module_Carousel_Portfolio(){
			$this->include_modules();
			if ( isset( $this->abmp_options['abmp_enabled'] ) && $this->abmp_options['abmp_enabled'] > 0 ) {
				$acme_module = new ACME_Builder_Module_Fullwidth_Portfolio();
				add_shortcode( 'et_pb_portfolio_fw_acme', array( $acme_module, '_shortcode_callback' ) );
			}
		}

		/**
		 * Load the ACME Module Slide-In (abmsi)
		 * @since 1.3
		 */
		public function ACME_Module_Slide_In() {
			$this->include_modules();
			if ( isset( $this->abmsi_options['abmsi_enabled'] ) && $this->abmsi_options['abmsi_enabled'] > 0 ) {
				$acme_module = new ACME_Builder_Module_Slide_In();
				add_shortcode( 'et_pb_slidein_acme', array( $acme_module, 'ì_shortcode_callback' ) );
			}
		}

		/**
		 *  PURE AJAX CALLBACKS
		 * @since 1.0
		 *
		 */
		public function append_abmp_preset(){
			include( 'partials/acme-divi-modules-admin-display-abmp-terms-loop.php' );
			wp_die();
		}

		/**
		 * Resize Divi Images
		 *
		 * @since 1.3.0
		 *
		 */
		public function set_new_image_size(){
			foreach ( array_keys($this->et_images) as $img ) {
				if(is_array($this->options[$img]))
					add_image_size(
						$img,
						$this->options[ $img ]['w'],
						$this->options[ $img ]['h'],
						$this->options[ $img ]['crop'] > 0 ? true : false
					);
			}
		}

		/**
		 * Easy Debug
		 *
		 * @since 1.0.0
		 *
		 * @param mixed     $var            the variable you want to debug
		 * @param string    $placeholder    arbitrary string title for debug
		 * @param bool      $die            stop WP execution
		 */
		public function run_debug( $var, $placeholder = null, $die = false ) {
			$title = __( 'Debug Output:', $this->plugin_name );
			if ( null !== $placeholder ) {
				$title = sprintf( esc_html__( 'Debug Output for %s:', $this->plugin_name ), $placeholder );
			}
			$content = null;
			if ( is_string( $var ) ) {
				$content .= "<h4>Echoed val:</h4>";
				$content .= "<code>" . nl2br( $var ) . "</code>";
			} else {
				$content .= "<h4>Var Dump:</h4>";
				$content .= "<code>" . nl2br( var_export( $var, true ) ) . "</code>";
			}
			$response = '<div class="notice notice-error">';
			$response .= "<h3>$title</h3>";
			$response .= $content;
			$response .= '</div>';
			echo $response;
			if ( true == $die ) {
				wp_die();
			}
		}
	}

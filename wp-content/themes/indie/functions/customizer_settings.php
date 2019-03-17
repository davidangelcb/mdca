<?php
/**
 * Customizer - Add Custom Styling
 */
function indie_customizer_style()
{
	wp_enqueue_style('indie-customizer', get_template_directory_uri() . '/functions/css/customizer.css');
}
add_action('customize_controls_print_styles', 'indie_customizer_style');

/**
 * Customizer - Live Preview
 */
function indie_customizer_live_preview() {
	wp_enqueue_script(
		'indie_customizer',
		get_template_directory_uri() . '/js/theme-customizer.js',
		array( 'customize-preview' ),
		rand(),
		true
	);
}
add_action( 'customize_preview_init', 'indie_customizer_live_preview' );

/**
 * Customizer - include script to display pro message
 */
if ( ! function_exists( 'indie_customizer_scripts' ) ) :

	function indie_customizer_scripts() {

		wp_register_script( 'indie-customizer-pro', get_template_directory_uri() . '/js/customizer-pro.js', '1.2.6', 'jquery', true);

		// Localize the script with new data
		$translation_array = array(
			'pro_message' 	=> __( 'Check out Pro Version', 'indie' ),
		);

		wp_localize_script( 'indie-customizer-pro', 'pro_object', $translation_array );

		wp_enqueue_script( 'indie-customizer-pro' );

	}

endif;

add_action( 'customize_controls_enqueue_scripts', 'indie_customizer_scripts' );


/**
 * Customizer - Panels, Sections, Settings & Controls
 */
function indie_register_theme_customizer( $wp_customize ) {

	//  List Arrays
	$list_social_channels = array( // 1
		'rss'				=> __( 'RSS url', 'indie'),
		'linkedin'			=> __( 'LinkedIn url', 'indie' ),
		'facebook'			=> __( 'Facebook url', 'indie' ),
		'googleplus'		=> __( 'Google + url', 'indie' ),
	);

	$list_hide_homepage_elements = array( // 1
		'categories'		=> __( 'Hide Categories', 'indie'),
		'date'				=> __( 'Hide Date', 'indie'),
	);

	$list_enable_sidebar	= array(//1
		'page'				=> __( 'Show Sidebar on Pages', 'indie' ),
		'archive'			=> __( 'Show Sidebar on Archives/Tags/Categories', 'indie' ),
	);

	$array_main_content_color_controls = array(
		array('main_body_bg', __('Background Color', 'indie'), '', true),
		array('main_body_txt', __('Main Text Color', 'indie'), '#4C585C', true),
		array('main_article_bg', __('Article Background Color', 'indie'), '#fff', true),
		array('main_article_title', __('Article Title Color', 'indie'), '#2b2b2b', true),
		array('main_article_link', __('Highlight Color', 'indie'), '#db971a', true),
		array('main_article_link_hover', __('Link Hover Color', 'indie'), '#E0B549', false),
	);

   	$array_header_color_controls = array(
		array('header_bg', __('Background Color', 'indie'), '#FFF', true),
		array('header_title_color', __('Title Color', 'indie'), '#2b2b2b', true),
		array('header_tagline_color', __('Tagline Color', 'indie'), '#2b2b2b', true),
		array('header_title_hover_color', __('Title & Tagline Hover Color', 'indie'), '#E0B549', false),
	);

	$array_footer_color_controls = array(
		array('chunk_bg', __('Widget Area Background Color', 'indie'), '#FFF', true),
		array('chunk_txt', __('Widget Area Text Color', 'indie'), '#2b2b2b', true),
		array('chunk_txt_highlight', __('Widget Area Highlight Color', 'indie'), '#E0B549', true),
		array('chunk_txt_highlight_hover', __('Widget Area Highlight Hover Color', 'indie'), '#E0B549', false),
	);

	$list_footer_hide_elements	= array(
		'chunk_area'			=> __( 'Hide Widget Area', 'indie' ),
	);


	// ======== Google Font Setup

	$list_fonts        		= array(); // 1
	$list_font_weights 		= array(); // 2
	$webfonts_array    		= file(get_template_directory() . '/inc/fonts.json');
	$webfonts          		= implode( '', $webfonts_array );
	$list_fonts_decode 		= json_decode( $webfonts, true );
	$defaultFont			= 'Open Sans';
	foreach ( $list_fonts_decode['items'] as $key => $value ) {
		$item_family                     = $list_fonts_decode['items'][$key]['family'];
		$list_fonts[$item_family]        = $item_family;
		$list_font_weights[$item_family] = $list_fonts_decode['items'][$key]['variants'];
	}

	$list_all_font_weights = array( // 3
		'100'       => __( 'Thin', 'indie' ),
		'300'       => __( 'Light', 'indie' ),
		'400'  	=> __( 'Regular', 'indie' ),
		'600'       => __( 'Semi-Bold', 'indie' ),
		'700'       => __( 'Bold', 'indie' ),
		'800'       => __( 'Extra Bold', 'indie' ),
	);
	$list_font_sizes = array( // 3
		'10'	=> __('Extra Small', 'indie'),
		'12'    => __( 'Small', 'indie' ),
		'16' 	=> __( 'Medium', 'indie' ),
		'28'    => __( 'Large', 'indie' ),
		'48' 	=> __( 'Extra Large', 'indie' ),
		'70'	=> __('XX Large', 'indie'),
	);
	$array_font_sections = array(
		array('font_site_nav', __('Site Navigation', 'indie'), 'Open Sans', '400', '12', false),
		array('font_site_title', __('Site Title', 'indie'), 'Open Sans', '400', '48', false),
		array('font_site_tagline', __('Site Tagline', 'indie'), 'Open Sans', '400', '28', false),
		array('font_body', __('Body Text', 'indie'), 'Open Sans', '400', '16', false),
		array('font_headers', __('Headers', 'indie'), 'Open Sans', '400', '12', false),
	);

	$priority = 0;


	// ====== END font setup


	// Add Panels

	if(method_exists('WP_Customize_Manager', 'add_panel')):
		$wp_customize->add_panel('indie_header_panel', array(
			'title'	=> __('Header Settings', 'indie'),
			'priority'	=> 10,
		));
		$wp_customize->add_panel('indie_global_panel', array(
			'title'	=> __('Global Settings', 'indie'),
			'priority'	=> 11,
		));
		$wp_customize->add_panel('indie_homepage_panel', array(
			'title'	=> __('Homepage Settings', 'indie'),
			'priority'	=> 12,
		));
		$wp_customize->add_panel('indie_footer_panel', array(
			'title'	=> __('Footer Settings', 'indie'),
			'priority'	=> 13,
		));

		$wp_customize->add_panel('indie_post_page_panel', array(
			'title'	=> __('Post &amp; Page Settings', 'indie'),
			'priority'	=> 13,
		));

		$wp_customize->add_panel('indie_colors_panel', array(
			'title'	=> __('Color Settings', 'indie'),
			'priority'	=> 14,
		));

		$wp_customize->add_panel('indie_font_panel', array(
			'title'	=> __('Font Settings', 'indie'),
			'priority'	=> 15,
		));



	endif;


	// Add Sections

	$wp_customize->add_section( 'indie_site_title_fonts', array(
		'title'    		=> __( 'Site Title', 'indie' ),
		'description'   => __( '<strong>Note.</strong><br />Please enable tags section checkbox for activate and use Google Web Fonts on selected tags.', 'indie' ),
		'panel'			=> __('indie_font_panel', 'indie'),
	));
	$wp_customize->add_section( 'indie_site_tagline_fonts', array(
		'title'    		=> __( 'Site Title', 'indie' ),
		'description'   => __( '<strong>Note.</strong><br />Please enable tags section checkbox for activate and use Google Web Fonts on selected tags.', 'indie' ),
		'panel'			=> __('indie_font_panel', 'indie'),
	));
	$wp_customize->add_section( 'indie_body_fonts', array(
		'title'    		=> __( 'Body Fonts', 'indie' ),
		'description'   => __( '<strong>Note.</strong><br />Please enable tags section checkbox for activate and use Google Web Fonts on selected tags.', 'indie' ),
		'panel'			=> __('indie_font_panel', 'indie'),
	));
	$wp_customize->add_section( 'indie_body_fonts', array(
		'title'    		=> __( 'Body Fonts', 'indie' ),
		'description'   => __( '<strong>Note.</strong><br />Please enable tags section checkbox for activate and use Google Web Fonts on selected tags.', 'indie' ),
		'panel'			=> __('indie_font_panel', 'indie'),
	));
	$priority = 0;


	$wp_customize->add_section('indie_footer_colors_section', array(
		'title'		=> __('Footer Area Colors', 'indie'),
		'panel'		=> 'indie_footer_panel',
		'priority'	=> $priority++,
	));
	$wp_customize->add_section( 'indie_global_icons' , array(
		'title'      => __('Site Icons', 'indie'),
		'panel'		 => 'indie_global_panel',
		'priority'   => 2,
	) );

	$wp_customize->add_section( 'indie_global_layout' , array(
		'title'      => __('Site Layout', 'indie'),
		'panel'		 => 'indie_global_panel',
		'priority'   => 2,
	) );
	$wp_customize->add_section('indie_main_colors_section', array(
		'title'		=> __('Main Body Colors', 'indie'),
		'panel'		=> 'indie_global_panel',
		'priority'	=> 3,
	));
	$wp_customize->add_section( 'indie_custom_css' , array(
   		'title'      => __('Custom CSS', 'indie'),
   		'description'=> 'Add your custom CSS which will overwrite the theme CSS',
		'panel'		 => 'indie_global_panel',
   		'priority'   => 4,
	) );
	$wp_customize->add_section('indie_homepage_layout', array(
		'title'		=> __('Homepage Layout', 'indie'),
		'panel'		=> 'indie_homepage_panel',
		'priority'	=> 1,
	));


	$priority = 2;
	$wp_customize->add_section( 'indie_logo_header' , array(
   		'title'      	=> __('Logo &amp; Header Settings', 'indie'),
		'panel'			=> 'indie_header_panel',
   		'priority'   	=> $priority++,
	) );

	$wp_customize->add_section( 'indie_social_section', array(
		'title'			=> __('Social Media Accounts', 'indie'),
		'panel'			=> 'indie_header_panel',
		'priority'		=> $priority++,
	));


	$wp_customize->add_section('indie_header_colors_section', array(
		'title'		=> __('Header Area Colors', 'indie'),
		'panel'		=> 'indie_header_panel',
		'priority'	=> $priority++,
	));

	$wp_customize->add_section( 'indie_post_settings_section', array(
		'title'			=> __('Single Post Settings', 'indie'),
		'panel'			=> 'indie_post_page_panel',
		'priority'		=> 2,
	));
	$wp_customize->add_section( 'indie_hide_show_page_section', array(
		'title'			=> __('Page Settings', 'indie'),
		'panel'			=> 'indie_post_page_panel',
		'priority'		=> 3,
	));
	// Font Sections
	$arraycount = count($array_font_sections);
	for ($row = 0; $row <  $arraycount; $row++) {
		$wp_customize->add_section($array_font_sections[$row][0], array(
			'title'		=> $array_font_sections[$row][1],
			'panel'		=> 'indie_font_panel',
			'priority'	=> $priority++,
		));
	}

	// Footer Sections
	$wp_customize->add_section( 'indie_footer_copyright', array(
		'title'			=> __('Copyright Settings', 'indie'),
		'panel'			=> 'indie_footer_panel',
		'priority'		=> 1,
	));

    $wp_customize->add_section( 'indie_hide_footer_elements', array(
	 	'title'			=> __('Hide Footer Sections', 'indie'),
	 	'panel'			=> 'indie_footer_panel',
    ));

    //widgets section
    $wp_customize->add_section( 'indie_footer_widgets', array(
        'title'         => __('Display Widget Settings', 'indie'),
        'panel'         => 'widgets',
    ));




// Add Setting
// ------------------------------------------------------------------------------------------

    $wp_customize->add_setting('hide_site_title', array(
		'default'		=> false,
		'sanitize_callback'	=> 'indie_sanitize_checkbox',
	));
	$wp_customize->add_setting('hide_tagline', array(
		'default'		=> false,
		'sanitize_callback'	=> 'indie_sanitize_checkbox',
	));



	$arraycount = count($array_main_content_color_controls);
	for ($row = 0; $row <  $arraycount; $row++) {

		// check what transport method is needed
		if($array_main_content_color_controls[$row][3] == true){
			$transportMethod = 'postMessage';
		}else{
			$transportMethod = 'refresh';
		}

		$wp_customize->add_setting(
			$array_main_content_color_controls[$row][0],
			array(
				'default'    		=> $array_main_content_color_controls[$row][2],
				'sanitize_callback'	=> 'indie_sanitize_color',
				'transport'			=> $transportMethod,
			)
		);
	}

	$arraycount = count($array_header_color_controls);
	for ($row = 0; $row <  $arraycount; $row++) {

		// check what transport method is needed
		if($array_header_color_controls[$row][3] == true){
			$transportMethod = 'postMessage';
		}else{
			$transportMethod = 'refresh';
		}

		$wp_customize->add_setting(
			$array_header_color_controls[$row][0],
			array(
				'default'     		=> $array_header_color_controls[$row][2],
				'sanitize_callback'	=> 'indie_sanitize_color',
				'transport'			=> $transportMethod,
			)
		);
	}
	$arraycount = count($array_footer_color_controls);
	for ($row = 0; $row <  $arraycount; $row++) {

		// check what transport method is needed
		if($array_footer_color_controls[$row][3] == true){
			$transportMethod = 'postMessage';
		}else{
			$transportMethod = 'refresh';
		}

		$wp_customize->add_setting(
			$array_footer_color_controls[$row][0],
			array(
				'default'     => $array_footer_color_controls[$row][2],
				'sanitize_callback'	=> 'indie_sanitize_color',
				'transport'			=> $transportMethod,
			)
		);
	}
	$wp_customize->add_setting('global_color_scheme_override', array(
		'default' => false,
		'sanitize_callback'	=> 'indie_sanitize_checkbox',
	));
	$wp_customize->add_setting('global_color_scheme', array(
		'default' => 'blue',
		'sanitize_callback'	=> 'indie_sanitize_text',
	));


	// Global Icons
	$wp_customize->add_setting('indie_global_favicon', array(
		'sanitize_callback'	=> 'indie_sanitize_upload',
	));
	$wp_customize->add_setting('indie_global_apple_icon', array(
		'sanitize_callback'	=> 'indie_sanitize_upload',
	));

	// Global Layout
	foreach($list_enable_sidebar as $key => $value){
		$wp_customize->add_setting( 'indie_global_sidebar_'.$key, array(
        	'default'     => false,
			'sanitize_callback'	=> 'indie_sanitize_checkbox',
        ));
	}
	$wp_customize->add_setting('indie_global_css', array(
		'sanitize_callback'	=> 'indie_sanitize_textarea',
	));
	$wp_customize->add_setting('upload_site_background_image', array(
		'sanitize_callback'	=> 'indie_sanitize_upload',
	));
	$wp_customize->add_setting('upload_site_background_image_repeat', array(
		'default' 			=> 'repeat',
		'sanitize_callback'	=> 'indie_sanitize_text',
	));


	// Featured Slider
	$wp_customize->add_setting(
        'indie_featured_slider',
        array(
            'default'     => false,
			'sanitize_callback'	=> 'indie_sanitize_checkbox',
        )
    );
	$wp_customize->add_setting( 'indie_featured_cat', array(
		'sanitize_callback'	=> 'indie_sanitize_text',
	));
	$wp_customize->add_setting(
        'indie_featured_cat_hide',
        array(
            'default'     => false,
			'sanitize_callback'	=> 'indie_sanitize_checkbox',
        )
    );
	$wp_customize->add_setting(
        'indie_featured_slider_slides',
        array(
            'default'     => '6',
			'sanitize_callback'	=> 'indie_sanitize_integer',
        )
    );

	// Homepage Hide Elements
	foreach($list_hide_homepage_elements as $key => $value){
		$wp_customize->add_setting(
			'indie_homepage_hide_'.$key, array(
				'default'	=> false,
				'sanitize_callback'	=> 'indie_sanitize_checkbox',
			)
		);
	}
	// Homepage Sidebar
	$wp_customize->add_setting('indie_homepage_hide_sidebar', array(
		'default'		=> false,
		'sanitize_callback'	=> 'indie_sanitize_checkbox',
	));
	// Homepage Columns
	$wp_customize->add_setting(
		'indie_homepage_column', array(
			'default'			=> 'one-col',
			'sanitize_callback'	=> 'indie_sanitize_text',
		)
	);

	// Background Image
	$wp_customize->add_setting('indie_background_header_repeat', array(
		'default' 			=> 'no-repeat',
		'sanitize_callback'	=> 'indie_sanitize_text',
		'transport'			=> 'postMessage',
	));

	// Header and logo
	$wp_customize->add_setting('indie_logo', array(
		'sanitize_callback'	=> 'indie_sanitize_upload',
	));
	$wp_customize->add_setting('indie_logo_retina', array(
		'sanitize_callback'		=> 'indie_sanitize_upload',
	));
	$wp_customize->add_setting(
        'indie_header_padding',
        array(
            'default'     => '40',
			'sanitize_callback'	=> 'indie_sanitize_integer',
        )
    );
	$wp_customize->add_setting(
        'indie_header_side_padding',
        array(
            'default'     => '20',
			'sanitize_callback'	=> 'indie_sanitize_integer',
        )
    );
	$wp_customize->add_setting(
        'indie_logo_position',
        array(
            'default'     => 'center',
			'sanitize_callback'	=> 'indie_sanitize_text',
        )
    );

	// Social Media Acocunts
	foreach ($list_social_channels as $key => $value) {
		$wp_customize->add_setting( $key, array(
			'sanitize_callback' => 'indie_sanitize_upload',
		));
	}


	// Font Settings
	$arraycount = count($array_font_sections);
	for ($row = 0; $row <  $arraycount; $row++) {
		$wp_customize->add_setting(
			$array_font_sections[$row][0],
			array(
				'default'     => $array_font_sections[$row][2],
				'sanitize_callback'	=> 'indie_sanitize_text',
			)
		);
		$wp_customize->add_setting(
			$array_font_sections[$row][0].'_weight',
			array(
				'default'     => $array_font_sections[$row][3],
				'sanitize_callback'	=> 'indie_sanitize_text',
			)
		);
		$wp_customize->add_setting(
			$array_font_sections[$row][0].'_size',
			array(
				'default'     => $array_font_sections[$row][4],
				'sanitize_callback'	=> 'indie_sanitize_text',
			)
		);
		$wp_customize->add_setting(
			$array_font_sections[$row][0].'_display',
			array(
				'default'     => $array_font_sections[$row][5],
				'sanitize_callback'	=> 'indie_sanitize_checkbox',
			)
		);
	}

	// Footer Settings
	$wp_customize->add_setting('footer_copyright_strapline', array(
		'transport'			=> 'postMessage',
		'sanitize_callback'	=> 'indie_sanitize_text',
	));
    $wp_customize->add_setting('indie_hide_footer_widget_area', array(
		'default'			=> false,
		'sanitize_callback'	=> 'indie_sanitize_checkbox',
	));
	$wp_customize->add_setting('indie_hide_copyright_bar', array(
		'default'			=> false,
		'sanitize_callback'	=> 'indie_sanitize_checkbox',
	));

// Add Control

    $wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'hide_site_title_control',
			array(
				'label'      => __('Hide Site Title', 'indie'),
				'section'    => 'title_tagline',
				'settings'   => 'hide_site_title',
				'type'		 => 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'hide_tagline_control',
			array(
				'label'      => __('Hide Tagline', 'indie'),
				'section'    => 'title_tagline',
				'settings'   => 'hide_tagline',
				'type'		 => 'checkbox',
			)
		)
	);

	//Color Controls
	$priority = 0;

	$arraycount = count($array_main_content_color_controls);
	for ($row = 0; $row <  $arraycount; $row++) {
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$array_main_content_color_controls[$row][0],
				array(
					'label'      	=>  $array_main_content_color_controls[$row][1],
					'section'    	=> 'indie_main_colors_section',
					'settings'   	=> $array_main_content_color_controls[$row][0],
					'priority'		=> $priority++,
				)
			)
		);
	}

	$arraycount = count($array_header_color_controls);
	for ($row = 0; $row <  $arraycount; $row++) {
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$array_header_color_controls[$row][0],
				array(
					'label'      =>  $array_header_color_controls[$row][1],
					'section'    => 'indie_header_colors_section',
					'settings'   => $array_header_color_controls[$row][0],
					'priority'	 => $priority++,
				)
			)
		);
	}
	$arraycount = count($array_footer_color_controls);
	for ($row = 0; $row <  $arraycount; $row++) {
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$array_footer_color_controls[$row][0],
				array(
					'label'      =>  $array_footer_color_controls[$row][1],
					'section'    => 'indie_footer_colors_section',
					'settings'   => $array_footer_color_controls[$row][0],
					'priority'	 => $priority++,
				)
			)
		);
	}
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'global_color_scheme_override_control',
			array(
				'label'      	=> __('Override custom colors with pre-defined color scheme below', 'indie'),
				'section'    	=> 'indie_global_colors_section',
				'settings'   	=> 'global_color_scheme_override',
				'priority'	 	=> $priority++,
				'type'		 	=> 'checkbox',
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'global_color_scheme_control',
			array(
				'label'          => __('Choose Color Scheme', 'indie'),
				'section'        => 'indie_global_colors_section',
				'settings'       => 'global_color_scheme',
				'type'           => 'radio',
				'priority'	 => $priority++,
				'choices'        => array(
					'blue'   		=> __('Beau Blue', 'indie'),
					'red'  			=> __('Firebrick Red', 'indie'),
					'orange'		=> __('Mango Tango', 'indie'),
					'green'			=> __('Celadon green', 'indie'),
				)
			)
		)
	);

	//Post & Page Show/Hide Elements
	$priority =1;

	// Global Icons
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'indie_global_favicon',
			array(
				'label'      => __('Upload Favicon', 'indie'),
				'section'    => 'indie_global_icons',
				'settings'   => 'indie_global_favicon',
				'priority'	 => $priority++
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'indie_global_apple_icon',
			array(
				'label'      => __('Upload Apple App Icon', 'indie'),
				'section'    => 'indie_global_icons',
				'settings'   => 'indie_global_apple_icon',
				'priority'	 => $priority++
			)
		)
	);

	// Global Layout
	$priority = 0;
	foreach($list_enable_sidebar as $key => $value){
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'indie_sidebar_'.$key,
				array(
					'label'      => $value,
					'section'    => 'indie_global_layout',
					'settings'   => 'indie_global_sidebar_'.$key,
					'type'		 => 'checkbox',
					'priority'	=> $priority++,
				)
			)
		);
	}
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'upload_site_background_image',
			array(
				'label'      => __('Upload Background Image or Texture', 'indie'),
				'section'    => 'indie_global_layout',
				'settings'   => 'upload_site_background_image',
				'priority'	 => $priority++,
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'upload_site_background_image_repeat',
			array(
				'label'          => __('Background Repeat Image', 'indie'),
				'section'        => 'indie_global_layout',
				'settings'       => 'upload_site_background_image_repeat',
				'type'           => 'radio',
				'priority'	 => $priority++,
				'choices'        => array(
					'no-repeat'  	=> __('No Repeat', 'indie'),
					'repeat'		=> __('Tile', 'indie'),
					'repeat-x'   	=> __('Repeat Horizontally', 'indie'),
					'repeat-y'		=> __('Repeat Vertically', 'indie'),
				)
			)
		)
	);

	// Custom CSS
	$wp_customize->add_control(
		new Customize_CustomCss_Control(
			$wp_customize,
			'custom_css',
			array(
				'label'      => __('Custom CSS', 'indie'),
				'section'    => 'indie_custom_css',
				'settings'   => 'indie_global_css',
				'type'		 => 'custom_css',
				'priority'	 => 1
			)
		)
	);

	// Featured area
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'featured_slider',
			array(
				'label'      => __('Enable Featured Slider', 'indie'),
				'section'    => 'indie_featured_section',
				'settings'   => 'indie_featured_slider',
				'type'		 => 'checkbox',
				'priority'	 => 2
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Category_Control(
			$wp_customize,
			'featured_cat',
			array(
				'label'    => __('Select Featured Category', 'indie'),
				'section'  => 'indie_featured_section',
				'settings' => 'indie_featured_cat',
				'priority'	 => 3
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'featured_cat_hide',
			array(
				'label'      => __('Hide Featured Category', 'indie'),
				'section'    => 'indie_featured_section',
				'settings'   => 'indie_featured_cat_hide',
				'type'		 => 'checkbox',
				'priority'	 => 4
			)
		)
	);
	$wp_customize->add_control(
		new Customize_Number_Control(
			$wp_customize,
			'featured_slider_slides',
			array(
				'label'      => __('Amount of Slides', 'indie'),
				'section'    => 'indie_featured_section',
				'settings'   => 'indie_featured_slider_slides',
				'type'		 => 'number',
				'priority'	 => 5
			)
		)
	);

	$priority = 0;
	// Homepage Sidebar
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'indie_homepage_hide_sidebar',
			array(
				'label'      => __('Show Sidebar on homepage', 'indie'),
				'section'    => 'indie_homepage_layout',
				'settings'   => 'indie_homepage_hide_sidebar',
				'type'		 => 'checkbox',
				'priority'	 => $priority++,
			)
		)
	);
	// Homepage Hide Elements
	foreach($list_hide_homepage_elements as $key => $value){
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'homepage_hide_'.$key,
				array(
					'label'      => $value,
					'section'    => 'indie_homepage_layout',
					'settings'   => 'indie_homepage_hide_'.$key,
					'type'		 => 'checkbox',
					'priority'	 => $priority++,
				)
			)
		);
	}

    // Homepage Column Number
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'indie_homepage_column_number',
			array(
				'label'          => __('Number of columns', 'indie'),
				'section'        => 'indie_homepage_layout',
				'settings'       => 'indie_homepage_column',
				'type'           => 'radio',
				'priority'	 => $priority++,
				'choices'        => array(
                    'one-col'       => __('One Column', 'indie'),
					'two-col'  		=> __('Two Column', 'indie'),
				)
			)
		)
	);

	// Background Image
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'indie_background_header_repeat',
			array(
				'label'          => __('Background Repeat Image', 'indie'),
				'section'        => 'header_image',
				'settings'       => 'indie_background_header_repeat',
				'type'           => 'radio',
				'priority'	 => 12,
				'choices'        => array(
					'no-repeat'  	=> __('No Repeat', 'indie'),
					'repeat'		=> __('Tile', 'indie'),
					'repeat-x'   	=> __('Repeat Horizontally', 'indie'),
					'repeat-y'		=> __('Repeat Vertically', 'indie'),
				)
			)
		)
	);

	// Header and Logo
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'upload_logo',
			array(
				'label'      => __('Upload Logo', 'indie'),
				'section'    => 'indie_logo_header',
				'settings'   => 'indie_logo',
				'priority'	 => 20
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'upload_logo_retina',
			array(
				'label'      => __('Upload Logo (Retina Version)', 'indie'),
				'section'    => 'indie_logo_header',
				'settings'   => 'indie_logo_retina',
				'priority'	 => 21
			)
		)
	);

	$wp_customize->add_control(
		new Customize_Number_Control(
			$wp_customize,
			'header_padding',
			array(
				'label'      => __('Top & Bottom Logo Padding', 'indie'),
				'section'    => 'indie_logo_header',
				'settings'   => 'indie_header_padding',
				'type'		 => 'number',
				'priority'	 => 22
			)
		)
	);

	$wp_customize->add_control(
		new Customize_Number_Control(
			$wp_customize,
			'header_side_padding',
			array(
				'label'      => __('Left & Right Logo Padding', 'indie'),
				'section'    => 'indie_logo_header',
				'settings'   => 'indie_header_side_padding',
				'type'		 => 'number',
				'priority'	 => 23
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'home_layout',
			array(
				'label'          => __('Logo Position', 'indie'),
				'section'        => 'indie_logo_header',
				'settings'       => 'indie_logo_position',
				'type'           => 'radio',
				'priority'	 => 24,
				'choices'        => array(
					'left'   	=> __('Left', 'indie'),
					'center'  	=> __('Center', 'indie'),
					'right'		=> __('Right', 'indie'),
				)
			)
		)
	);

	// Social Media Acocunts
	foreach ($list_social_channels as $key => $value) {
		$wp_customize->add_control( $key, array(
			'label'   => $value,
			'section' => 'indie_social_section',
			'type'    => 'url',
		) );
	}


	// Font Controls
	$arraycount = count($array_font_sections);
	for ($row = 0; $row <  $arraycount; $row++) {
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				$array_font_sections[$row][0].'_display',
				array(
					'label'      	=> __('Enable these settings', 'indie'),
					'section'    	=> $array_font_sections[$row][0],
					'settings'   	=> $array_font_sections[$row][0].'_display',
					'type'		 	=> 'checkbox',
					'priority'		=> $priority++,
				)
			)
		);
		$wp_customize->add_control( $array_font_sections[$row][0], array(
			'type'     => 'select',
			'label'    => __( 'Font Family', 'indie' ),
			'section'  => $array_font_sections[$row][0],
			'priority' =>$priority++,
			'choices'  => $list_fonts
		));
		$wp_customize->add_control( $array_font_sections[$row][0].'_weight', array(
			'type'     => 'select',
			'label'    => __( 'Font Weight', 'indie' ),
			'section'  => $array_font_sections[$row][0],
			'priority' =>$priority++,
			'choices'  => $list_all_font_weights
		));
		$wp_customize->add_control( $array_font_sections[$row][0].'_size', array(
			'type'     => 'select',
			'label'    => __( 'Font Size', 'indie' ),
			'section'  => $array_font_sections[$row][0],
			'priority' => $priority++,
			'choices'  => $list_font_sizes
		));

	}

	// Footer Controls
	$wp_customize->add_control( 'footer_copyright_strapline', array(
		'label'    	=> __( 'Copyright Strapline', 'indie' ),
		'settings'	=> 'footer_copyright_strapline',
		'section'  	=> 'indie_footer_copyright',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'indie_hide_footer_widget_area',
			array(
				'label'      	=> __('Hide Footer Widget Area', 'indie'),
				'section'    	=> 'indie_hide_footer_elements',
				'settings'   	=> 'indie_hide_footer_widget_area',
				'type'		 	=> 'checkbox',

			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'indie_hide_copyright_bar',
			array(
				'label'      	=> __('Hide Copyright Bar', 'indie'),
				'section'    	=> 'indie_hide_footer_elements',
				'settings'   	=> 'indie_hide_copyright_bar',
				'type'		 	=> 'checkbox',

			)
		)
	);



	// Remove Sections

	$wp_customize->get_section( 'title_tagline' )->panel = 'indie_header_panel';
	$wp_customize->get_section( 'title_tagline' )->priority = 1;
	$wp_customize->get_section( 'header_image' )->panel = 'indie_header_panel';
	$wp_customize->get_section( 'header_image' )->priority = 3;
	$wp_customize->get_section( 'header_image' )->title = __('Background Image', 'indie');
    $wp_customize->get_control( 'blogname' )->priority = 1;
	$wp_customize->remove_control( 'display_header_text' );
	$wp_customize->remove_control('font_site_nav_weight');
	$wp_customize->remove_control('font_site_nav_size');
	$wp_customize->remove_control('font_headers_size');
	$wp_customize->remove_control('font_body_weight');
	$wp_customize->remove_control('font_body_size');
	$wp_customize->remove_section( 'nav');
	$wp_customize->remove_section( 'static_front_page');
	$wp_customize->remove_section( 'colors');

	// Change defaults for live preview
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

}
add_action( 'customize_register', 'indie_register_theme_customizer' );


// SANITIZATION
// ==============================

// Sanitize Text
function indie_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
// Sanitize Textarea
function indie_sanitize_textarea($input) {
	global $allowedposttags;
	$output = wp_kses( $input, $allowedposttags);
	return $output;
}
// Sanitize Checkbox
function indie_sanitize_checkbox( $input ) {
	if( $input ):
		$output = '1';
	else:
		$output = false;
	endif;
	return $output;
}
// Sanitize Numbers
function indie_sanitize_integer( $input ) {
	$value = (int) $input; // Force the value into integer type.
    return ( 0 < $input ) ? $input : null;
}
function indie_sanitize_float( $input ) {
	return floatval( $input );
}

// Sanitize Uploads
function indie_sanitize_upload($input){
	return esc_url_raw($input);
}

// Sanitize Colors
function indie_sanitize_color($input){
	return maybe_hash_hex_color($input);
}

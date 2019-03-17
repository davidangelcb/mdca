<?php
/**
 * indie functions and definitions
 *
 * @package indie
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 940; /* pixels */
}

if ( ! function_exists( 'indie_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function indie_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on indie, use a find and replace
	 * to change 'indie' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'indie', get_template_directory() . '/languages' );

	// Feed Links
	add_theme_support( 'automatic-feed-links' );
	
	// Post formats
	add_theme_support( 'post-formats', array( 'gallery', 'quote' ) );

	// Post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'full-thumb', 940, 0, true );
	add_image_size( 'slider-thumb', 650, 440, true );
	add_image_size( 'thumb', 440, 294, true );


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'indie' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );
	
	/**
	 * Display Title in theme
	 */
	add_theme_support( 'title-tag' );
	
	// link stylesheet file to the TinyMCE visual editor
	add_editor_style( array('style.css', 'css/editor-style.css') );

	// Adding custom background color support
	add_theme_support( 'custom-background' );
	
}
endif; // indie_setup
add_action( 'after_setup_theme', 'indie_setup' );


/**
 * Author Social Links
 */
function indie_contactmethods( $contactmethods ) {

	$contactmethods['twitter']   = __('Twitter Username', 'indie');
	$contactmethods['facebook']  = __('Facebook Username', 'indie');
	$contactmethods['google']    = __('Google Plus Username', 'indie');
	$contactmethods['tumblr']    = __('Tumblr Username', 'indie');
	$contactmethods['instagram'] = __('Instagram Username', 'indie');
	$contactmethods['pinterest'] = __('Pinterest Username', 'indie');

	return $contactmethods;
}
add_filter('user_contactmethods','indie_contactmethods',10,1);


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function indie_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'indie' ),
		'id'            => 'sidebar-1',
        'description'   => __( 'Main sidebar that appears on the left or right.', 'indie' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
    register_sidebar( array(
		'name' => __( 'Footer 1', 'indie' ),
		'id' => 'footer-1',
        'description'   => __( 'One of three widget areas that will apear at the bottom of the site.', 'indie' ),
		'before_widget' => '<aside id="%1$s" class="widget first %2$s"><div class="widget-wrap">',
		'after_widget' => '</div></aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
    register_sidebar( array(
		'name' => __( 'Footer 2', 'indie' ),
		'id' => 'footer-2',
        'description'   => __( 'One of three widget areas that will apear at the bottom of the site.', 'indie' ),
		'before_widget' => '<aside id="%1$s" class="widget first %2$s"><div class="widget-wrap">',
		'after_widget' => '</div></aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',        
	) );
    register_sidebar( array(
		'name' => __( 'Footer 3', 'indie' ),
		'id' => 'footer-3',
        'description'   => __( 'One of three widget areas that will apear at the bottom of the site.', 'indie' ),
		'before_widget' => '<aside id="%1$s" class="widget first %2$s"><div class="widget-wrap">',
		'after_widget' => '</div></aside>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'indie_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function indie_scripts() {
	
    // STYLES //
    
    // Load Google Fonts
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Noticia+Text|Montserrat:400,700|Oxygen|Raleway');
    // Load our main stylesheet.
	wp_enqueue_style('indie-style', get_stylesheet_uri());
    // Load stylesheet for Icon Fonts
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css');
    // Load styles for Gallery Carousel
	wp_enqueue_style('flexslider', get_template_directory_uri() . '/css/flexslider.css');
 
    // SCRIPTS //
  
	wp_enqueue_script('indie-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script('indie-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
    // Script used to scale Videos responsively
	wp_enqueue_script('jquery-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), '', true);
    // Script to write custom tooltips
	wp_enqueue_script('jquery-tooltipsy', get_template_directory_uri() . '/js/tooltipsy.jquery.js', array('jquery'), '', true);
    // Load script for Gallery Carousel
	wp_enqueue_script('jquery-flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array('jquery'), '', true);
    // Our Custom JS and triggers
	wp_enqueue_script('indie-scripts', get_template_directory_uri() . '/js/indie.js', array('jquery'), NULL, true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'indie_scripts' );	

/**
 * Include files
 */

//Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/extras.php';

// Masonry
include get_template_directory() . '/inc/masonry.php';

// Theme Options
include('functions/customizer_controller.php');
include('functions/customizer_settings.php');
include('functions/customizer_styles.php');


/**
 * Exclude Featured Category
 */
function indie_category($separator) {
	
	if(get_theme_mod( 'indie_featured_cat_hide' ) == true) {
		
		$excluded_cat = get_theme_mod('indie_featured_cat');
		
		$first_time = 1;
		foreach((get_the_category()) as $category) {
			if ($category->cat_ID != $excluded_cat) {
				if ($first_time == 1) {
					echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s", "indie" ), $category->name ) . '" ' . '>'  . $category->name.'</a>';
					$first_time = 0;
				} else {
					echo $separator . '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s", "indie" ), $category->name ) . '" ' . '>' . $category->name.'</a>';
				}
			}
		}
	
	} else {
		
		$first_time = 1;
		foreach((get_the_category()) as $category) {
			if ($first_time == 1) {
				echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s", "indie" ), $category->name ) . '" ' . '>'  . $category->name.'</a>';
				$first_time = 0;
			} else {
				echo $separator . '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s", "indie" ), $category->name ) . '" ' . '>' . $category->name.'</a>';
			}
		}
	
	}
}


/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );


/**
 * The Excerpt
 */
function indie_custom_excerpt_length( $length ) {
	return 19;
}
add_filter( 'excerpt_length', 'indie_custom_excerpt_length', 999 );

function indie_new_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'indie_new_excerpt_more' );

/**
 * Include Google Fonts
 */
function indie_google_fonts() {
	// Add Google Font stylesheets
	$array_font_sections = array(
		'font_site_title',
		'font_site_tagline',
		'font_body',
		'font_headers',
		'font_site_nav',
	);
	
	$fonts = '';
    $enqueueFonts = 0;
	foreach($array_font_sections as $id => $section)
	{
		if(get_theme_mod($array_font_sections[$id].'_display'))
		{
			$family = get_theme_mod($array_font_sections[$id]);
			$weight = get_theme_mod($array_font_sections[$id].'_weight');

			$fonts .= '|'.$family;

			if($weight)
			{
				$fonts .= ':'.$weight;
			}
            $enqueueFonts = 1;
		}
	}
    if($enqueueFonts == 1){
        $fonts = ltrim($fonts, '|');
        $url = add_query_arg('family', urlencode($fonts), "//fonts.googleapis.com/css" );

        wp_enqueue_style('indie-google-fonts', $url);
    } else{
        // Return nothing if google fonts have not been selected from the customizer.
        return;
    }
	
}
add_action('wp_enqueue_scripts', 'indie_google_fonts');

/**
 * Title tag fallback
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function indie_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'indie_render_title' );
endif;
/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	/*
	 * HEADER SECTION -------------------------------------------------------------
	*/

	wp.customize( 'indie_logo_header', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a .title' ).text( to );
		} );
	} );
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a .title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a .tagline' ).text( to );
		} );
	} );
	wp.customize( 'indie_background_header_repeat', function( value ) {
		value.bind( function( to ) {
			$( '.site-header' ).css( 'background-repeat', to );
		} );
	} );

	/*
	 * FOOTER SECTION -------------------------------------------------------------
	*/

	wp.customize( 'footer_copyright_strapline', function( value ) {
		value.bind( function( to ) {
			$( '.site-footer p' ).html( to );
		} );
	} );




	/*
	 * HOMEPAGE SECTION -------------------------------------------------------------
	*/

	wp.customize( 'indie_grid_title', function( value ) {
		value.bind( function( to ) {
			$( '.grid-header h2' ).text( to );
		} );
	} );
	wp.customize( 'indie_grid_sub_title', function( value ) {
		value.bind( function( to ) {
			$( '.grid-header h3' ).text( to );
		} );
	} );


	/*
	 * COLORS -------------------------------------------------------------
	*/

	// ------------ Main Colors

	wp.customize( 'main_body_bg', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'background-color', to );
		} );
	} );
	wp.customize( 'main_body_txt', function( value ) {
		value.bind( function( to ) {
			$( 'body, button, input, select, textarea' ).css( 'color', to );
		} );
	} );
	wp.customize( 'main_article_bg', function( value ) {
		value.bind( function( to ) {
			$( 'article .post-wrap, .sticky-post, .single .comments-area .post-wrap, #secondary .sidebar-wrap, .footer-widgets, .nav-links a, .author .post-author, .comments-area .post-wrap' ).css( 'background-color', to );
		} );
	} );
	wp.customize( 'main_article_link', function( value ) {
		value.bind( function( to ) {
			$( 'article a, article a:visited, .sticky-post' ).css( 'color', to );
		} );
	} );
	wp.customize( 'main_article_title', function( value ) {
		value.bind( function( to ) {
			$( '.post-title, .post-title a, .sidebar .widget-title, .nav-links a' ).css( 'color', to );
			$( '.format-standard .post-image .overlay span, .related-wrap .overlay span' ).css( 'background-color', to );
		} );
	} );


	// ------------ Header Colors

	wp.customize( 'header_bg', function( value ) {
		value.bind( function( to ) {
			$( '.site-header' ).css( 'background-color', to );
		} );
	} );
	wp.customize( 'header_title_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a .title' ).css( 'color', to );
		} );
	} );
	wp.customize( 'header_tagline_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a .tagline' ).css( 'color', to );
		} );
	} );

	// ------------ Footer Colors

	wp.customize( 'chunk_bg', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widgets' ).css( 'background-color', to );
		} );
	} );
	wp.customize( 'chunk_txt', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widgets, .footer-widgets h4, .footer-widgets li a, .footer-widgets li a:visited' ).css( 'color', to );
		} );
	} );
	wp.customize( 'chunk_txt_highlight', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widgets a' ).css( 'color', to );
		} );
	} );
	wp.customize( 'copyright_bg', function( value ) {
		value.bind( function( to ) {
			$( 'footer.site-footer' ).css( 'background-color', to );
		} );
	} );
	wp.customize( 'copyright_txt', function( value ) {
		value.bind( function( to ) {
			$( 'footer.site-footer' ).css( 'color', to );
		} );
	} );
	wp.customize( 'copyright_txt_highlight', function( value ) {
		value.bind( function( to ) {
			$( 'footer.site-footer a' ).css( 'color', to );
		} );
	} );

} )( jQuery );

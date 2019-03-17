<?php
//////////////////////////////////////////////////////////////////
// Customizer - Add CSS
//////////////////////////////////////////////////////////////////
function indie_customizer_css() {

	?>

	<style>

		.site-header{
			background-repeat:<?php echo get_theme_mod('indie_background_header_repeat'); ?>;
		}

		.site-title {
			padding-left:<?php echo get_theme_mod( 'indie_header_side_padding' ); ?>px;
			padding-right:<?php echo get_theme_mod( 'indie_header_side_padding' ); ?>px;
			padding-top:<?php echo get_theme_mod( 'indie_header_padding' ); ?>px;
			padding-bottom:<?php echo get_theme_mod( 'indie_header_padding' ); ?>px;
		}

		<?php if(get_theme_mod('upload_site_background_image')):?>
			.site-content{
				background:url(<?php echo get_theme_mod('upload_site_background_image') ;?>) top left;
				background-repeat: <?php echo(get_theme_mod('upload_site_background_image_repeat')); ?>;
				<?php if(get_theme_mod('upload_site_background_image_repeat') === 'no-repeat'):?>
					background-size: 100% 100%;
				<?php endif; ?>
			}
		<?php endif; ?>

		/* Top Bar Colors */
		.main-navigation{background-color:<?php echo get_theme_mod('topbar_bg');?>; }
		.nav-menu a{color:<?php echo get_theme_mod('topbar_link');?> ;border-color:<?php echo get_theme_mod('topbar_link');?>;}
		.nav-menu li:hover > a, .nav-menu .current-menu-item > a, .nav-menu .current-menu-ancestor > a, .nav-menu .current_page_item > a, .nav-menu .current_page_ancestor > a{color:<?php echo get_theme_mod('topbar_link_active');?> ;}
		#search-toggle{background-color:<?php echo get_theme_mod('topbar_search_bar'); ?>; color:<?php echo get_theme_mod('topbar_bg');?>;}
		#menu-toggle.icon-cross, #search-toggle.icon-cross, #menu-toggle:hover, #search-toggle:hover{color:<?php echo get_theme_mod('topbar_link_active');?>;}
		.social-media a i{color:<?php echo get_theme_mod('topbar_link'); ?>;}
		.social-media a:hover i{color:<?php echo get_theme_mod('topbar_link_active'); ?>;}
		.search-box{background-color:<?php echo get_theme_mod('topbar_search_bar');?>;}
		.search-form .search-field{background-color:<?php echo get_theme_mod('topbar_link');?>;color:<?php echo get_theme_mod('topbar_bg');?>;}
		.search-form .search-submit,.search-form .search-submit:focus{background-color:<?php echo get_theme_mod('topbar_link');?>;color:<?php echo get_theme_mod('topbar_bg');?>;}
		.search-form .search-submit:hover{background-color:<?php echo get_theme_mod('topbar_link_active');?>;}
		.search-form .search-field:focus {outline-color:<?php echo get_theme_mod('topbar_link_active');?>;color:<?php echo get_theme_mod('topbar_bg');?>;}
		.search-field::-webkit-search-cancel-button{background-color:<?php echo get_theme_mod('topbar_bg');?>;}
		.search-field::-webkit-search-cancel-button:after{color:<?php echo get_theme_mod('topbar_link');?>;}

		/* Header Colors */
		.site-header{background-color:<?php echo get_theme_mod('header_bg'); ?> ;}
		.site-title a .title{color:<?php echo get_theme_mod('header_title_color'); ?>;}
		.site-title a:hover .title, .site-title a:focus .title, .site-title a:hover .tagline, .site-title a:focus .tagline {color:<?php echo get_theme_mod('header_title_hover_color'); ?>;}
		.site-title a .tagline{color:<?php echo get_theme_mod('header_tagline_color'); ?>;}


		/* Main Body Colors */
		body
		{
			background-color:<?php echo get_theme_mod('main_body_bg'); ?>;
			color:<?php echo get_theme_mod('main_body_txt');?>;
		}
		article .post-wrap,
		.sticky-post,
		.single .comments-area .post-wrap,
		#secondary .sidebar-wrap,
		.footer-widgets,
		.nav-links a,
		.author .post-author,
		.comments-area .post-wrap {
			background-color:<?php echo get_theme_mod('main_article_bg');?>;
		}

		article a,
		article a:visited,
		.sticky-post,
		.footer-widgets li a:before,
		.sidebar li a:before,
		.sidebar a
		{
			color:<?php echo get_theme_mod('main_article_link');?>;
		}
		.format-standard .post-image .overlay span,
		.related-wrap .overlay span
		{
			background-color:<?php echo get_theme_mod('main_article_link');?>;
			color:#2b2b2b;
		}
		article a:hover,
		article a:focus,
		.post-title a:hover,
		.post-title a:focus,
		.sidebar a:hover,
		.sidebar a:focus
		{
			color:<?php echo get_theme_mod('main_article_link_hover');?>;
		}
		article .post-title,
		article .post-title a,
		.sidebar .widget-title,
		.nav-links a
		{
			color:<?php echo get_theme_mod('main_article_title');?>;
		}

		/* Footer Colors */
		.footer-widgets{
			background-color:<?php echo get_theme_mod('chunk_bg'); ?> ;
		}
		.footer-widgets,
		.footer-widgets h4
		{
			color:<?php echo get_theme_mod('chunk_txt'); ?>;
		}
		.footer-widgets li a,
		.footer-widgets li a:visited
		{
			color:<?php echo get_theme_mod('chunk_txt_highlight'); ?>;
		}
		.footer-widgets li a:hover {
			color:<?php echo get_theme_mod('chunk_txt_highlight_hover'); ?>;
		}
		footer.site-footer{
			background-color:<?php echo get_theme_mod('copyright_bg'); ?> ;
		}
		footer.site-footer{
			color:<?php echo get_theme_mod('copyright_txt'); ?>;
		}
		footer.site-footer a{
			color:<?php echo get_theme_mod('copyright_txt_highlight'); ?>;
		}

		/* Font Settings */
		<?php if(get_theme_mod('font_body_display')): ?>
			body {font-family: <?php echo(get_theme_mod('font_body'));?>;}
		<?php endif; ?>
		<?php if(get_theme_mod('font_headers_display')): ?>
			h1,h2,h3,h4,h5,h6, .footer-widgets h4 {font-family: <?php echo(get_theme_mod('font_headers'));?>;}
		<?php endif; ?>
		<?php if(get_theme_mod('font_site_nav_display')): ?>
			.nav-menu li a {font-family: <?php echo(get_theme_mod('font_site_nav'));?>;}
		<?php endif; ?>
		<?php if(get_theme_mod('font_site_title_display')): ?>
			.site-title a .title {font-family: <?php echo(get_theme_mod('font_site_title'));?>; font-size: <?php echo(get_theme_mod('font_site_title_size'));?>px;line-height:<?php echo(get_theme_mod('font_site_title_size'));?>px;}
		<?php endif; ?>
		<?php if(get_theme_mod('font_site_tagline_display')): ?>
			.site-title a .tagline {font-family: <?php echo(get_theme_mod('font_site_tagline'));?>;font-size: <?php echo(get_theme_mod('font_site_tagline_size'));?>px;line-height:<?php echo(get_theme_mod('font_site_tagline_size'));?>px;}
		<?php endif; ?>
        <?php if(get_theme_mod('indie_title_uppercase')):?>
			.site-title a .title{ text-transform:uppercase; }
		<?php endif; ?>

		<?php if(get_theme_mod('indie_tagline_uppercase')):?>
			.site-title a .tagline{ text-transform:uppercase; }
		<?php endif; ?>

		<?php if(get_theme_mod( 'indie_global_css' )) : ?>
			<?php echo get_theme_mod( 'indie_global_css' ); ?>
		<?php endif; ?>

	</style>
	<?php
}
add_action( 'wp_head', 'indie_customizer_css' );

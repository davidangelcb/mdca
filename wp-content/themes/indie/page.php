<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package indie
 */

get_header(); ?>

	<div id="primary" class="content-area <?php if(get_theme_mod( 'indie_global_sidebar_page' )) : ?>indie-sidebar <?php endif; 
	if(get_theme_mod('indie_sidebar_position') == 'left'): echo('left'. ' '); endif;?>">
		<main id="main" class="site-main" role="main">
			<div class="inner">
				<?php while ( have_posts() ) : the_post(); ?>
	
					<?php get_template_part( 'content-page' ); ?>
	
					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>
	
				<?php endwhile; // end of the loop. ?>
			</div><!-- .inner -->
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php 
		if(
                get_theme_mod('indie_global_sidebar_page') ||
                (is_front_page() && get_theme_mod('indie_homepage_hide_sidebar'))
        ):
			get_sidebar(); 
		endif;
	?>
	
<?php get_footer(); ?>

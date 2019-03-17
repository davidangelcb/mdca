<?php
/**
 * The template for displaying all single posts.
 *
 * @package indie
 */

get_header(); ?>

	<div id="primary" class="content-area indie-sidebar <?php 
	if(get_theme_mod('indie_sidebar_position') == 'left'): echo('left'. ' '); endif;?>">
		<main id="main" class="site-main" role="main">
			<div class="inner">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content' ); ?>	
					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>
				<?php endwhile; // end of the loop. ?>
			</div>	
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package indie
 */

get_header(); ?>

	<section id="primary" class="content-area <?php if(get_theme_mod( 'indie_global_sidebar_archive' )) : ?>indie-sidebar<?php endif; if(get_theme_mod('indie_homepage_column')): echo(esc_attr(get_theme_mod('indie_homepage_column')). ' '); endif; ?>">
		<main id="main" class="site-main" role="main">
			<div class="inner">
				<?php if ( have_posts() ) : ?>
				
					<header class="page-header">
						<h1 class="page-title">
							<?php
								if ( is_category() ) :
									single_cat_title();
				
								elseif ( is_tag() ) :
									single_tag_title();
				
								elseif ( is_author() ) :
									printf( __( 'Author: %s', 'indie' ), '<span class="vcard">' . get_the_author() . '</span>' );
				
								elseif ( is_day() ) :
									printf( __( 'Day: %s', 'indie' ), '<span>' . get_the_date() . '</span>' );
				
								elseif ( is_month() ) :
									printf( __( 'Month: %s', 'indie' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'indie' ) ) . '</span>' );
				
								elseif ( is_year() ) :
									printf( __( 'Year: %s', 'indie' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'indie' ) ) . '</span>' );
				
								elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
									_e( 'Asides', 'indie' );
				
								elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
									_e( 'Galleries', 'indie' );
				
								elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
									_e( 'Images', 'indie' );
				
								elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
									_e( 'Videos', 'indie' );
				
								elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
									_e( 'Quotes', 'indie' );
				
								elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
									_e( 'Links', 'indie' );
				
								elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
									_e( 'Statuses', 'indie' );
				
								elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
									_e( 'Audios', 'indie' );
				
								elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
									_e( 'Chats', 'indie' );
				
								else :
									_e( 'Archives', 'indie' );
				
								endif;
							?>
						</h1>
					</header><!-- .page-header -->
					
					<?php if(is_author()): ?>
						<?php get_template_part('inc/templates/about_author'); ?>
					<?php endif; ?>
				
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
				
						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
						?>
				
					<?php endwhile; ?>
				
					<?php indie_paging_nav(); ?>
				
				<?php else : ?>
				
					<?php get_template_part( 'content', 'none' ); ?>
				
				<?php endif; ?>
			</div><!-- .inner -->
		</main><!-- #main -->
	</section><!-- #primary -->

	<?php 
		if(	is_archive() && !is_author() && get_theme_mod('indie_global_sidebar_archive')) :
			get_sidebar(); 
		endif;

	?>
<?php get_footer(); ?>

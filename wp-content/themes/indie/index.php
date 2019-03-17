<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package indie
 */

get_header(); ?>
	<?php if(get_theme_mod( 'indie_featured_slider' ) == true) : ?>
		<?php get_template_part('inc/featured_slider/featured'); ?>
	<?php endif; ?>

	<div id="primary" class="content-area <?php 
		if(get_theme_mod('indie_sidebar_position') == 'left'): echo('left'. ' '); endif;
		if(get_theme_mod('indie_homepage_column')): echo(esc_attr(get_theme_mod('indie_homepage_column')). ' '); endif; ?>">
		
		<main id="main" class="site-main" role="main">
			<div class="inner">
                
                <?php if(get_theme_mod('indie_grid_show_title')): ?>
                    <div class="grid-header">
                        <h2><?php echo esc_html(get_theme_mod('indie_grid_title')); ?></h2>
                        <h3><?php echo esc_html(get_theme_mod('indie_grid_sub_title')); ?></h3>
                    </div>    
                <?php endif; ?>
                
			<?php if( get_theme_mod( 'indie_homepage_column' ) && get_theme_mod('indie_homepage_column') != 'one-col'): ?>
				<div id="masonry-loop">
			<?php else: ?>
				<div class="articles">
			<?php endif; ?>
			
			<?php if ( have_posts() ) : ?>
	
				<?php /* Start the Loop */ ?>
				<?php 
					while ( have_posts() ) : the_post();
						if(has_post_format('quote')) :
							get_template_part( 'content-quote', get_post_format('quote') );
						else:
							get_template_part('content', get_theme_mod('indie_post_layout'));
						endif;
					endwhile; 
				?>
	
			<?php else : ?>
	
				<?php get_template_part( 'content', 'none' ); ?>
	
			<?php endif; ?>
            
            </div><!-- end #masonry-loop or .articles -->
			
			<?php if(!is_single()): indie_paging_nav(); endif; ?>
			</div><!-- .inner -->
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php 
		if(is_front_page() && get_theme_mod('indie_homepage_hide_sidebar')):
			get_sidebar(); 
		endif;
	?>
	
<?php get_footer(); ?>

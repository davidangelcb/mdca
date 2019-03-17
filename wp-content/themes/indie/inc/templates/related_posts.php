<?php 

$orig_post = $post;
global $post;

$categories = get_the_category($post->ID);

if ($categories) {

	$category_ids = array();

	foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	
	$args = array(
		'category__in'     => $category_ids,
		'post__not_in'     => array($post->ID),
		'posts_per_page'   => 3, // Number of related posts that will be shown.
		'ignore_sticky_posts' => 1,
		'orderby' => 'rand'
	);

	$my_query = new wp_query( $args );
	if( $my_query->have_posts() ) { ?>
	
		<div class="post-related">
			<div class="post-box">
				<h4 class="post-box-title"><?php echo __('You Might Also Like', 'indie'); ?></h4>
			</div>
		<?php while( $my_query->have_posts() ) {
			$my_query->the_post();?>
	
			<div class="item-related">
				<div class="related-wrap">
                	<div class="rel-image-wrap">
                     	<a href="<?php echo get_permalink() ?>" class="overlay"></a>
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) : ?>
							<?php the_post_thumbnail('medium'); ?>
                        <?php else: ?>
                            <div class="empty-img"></div>
                        <?php endif; ?>
                        
                     </div>
					<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
					<span class="date"><?php the_time( get_option('date_format') ); ?></span>
				</div>
			</div>
		<?php
		}
		echo '</div>';
	}
}
$post = $orig_post;
wp_reset_query();

?>
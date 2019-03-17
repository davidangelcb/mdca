<?php
/**
 * @package indie
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'masonry-entry'); ?>>
	
    <div class="post-wrap">
	
		<?php if(!get_theme_mod('indie_homepage_hide_featured')) : ?>
            <?php if(is_sticky($post->ID)):?>
                <span class="sticky-icon"><span class="sticky-text"><?php _e('Featured', 'indie'); ?> </span><i class="fa fa-thumb-tack"></i></span>
            <?php endif; ?>
        <?php endif; ?>


        <div class="entry-meta">
            <span class="post-format"></span>

            <?php // Categories
            if(!get_theme_mod('indie_homepage_hide_categories')) : ?>
                <span class="cat-links">
                    <span><?php indie_category(' - '); ?></span>											
                </span>
            <?php endif;?>
        </div>

            <div class="inner-post">
                <header class="entry-header">

                        <!-- // Post Title & Category -->
                        <?php if(is_front_page()): ?>
                            <h2 class="post-title">
                                <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                            </h2>
                        <?php elseif(is_single()): ?>
                            <h1 class="post-title">
                                <?php the_title(); ?>
                            </h1>
                        <?php else: ?>
                            <h2 class="post-title">
                                <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                            </h2>
                        <?php endif; ?>

                        <div class="meta-data">
                        <!-- // Published Date -->
                            <?php if(is_front_page()): ?>
                                <?php if(!get_theme_mod('indie_homepage_hide_date')) : ?>
                                   <a href="<?php the_permalink(); ?>">
                                    <span class="date"><?php the_time( get_option('date_format') ); ?></span>
                                   </a>
                                <?php endif; ?>
                            <?php elseif(is_single()): ?>
                                <span class="date"><?php the_time( get_option('date_format') ); ?></span>
                            <?php else: ?>
                                <a href="<?php the_permalink(); ?>">
                                	<span class="date"><?php the_time( get_option('date_format') ); ?></span>
                                </a>
                            <?php endif; ?>

                            <!-- // author & Comment Count -->
                            <span class="author"><?php echo get_avatar( $post->post_author, 46 );?><?php _e('by','indie');?> <?php the_author_posts_link(); ?></span>

                            <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                                <span class="comments-link"><?php comments_popup_link( __( '0 Comments', 'indie' ), __( '1 Comment', 'indie' ), __( '% Comments', 'indie' ) ); ?></span>
                            <?php endif; ?>

                        </div>


                        <!-- Featured Media Section-->
                        <?php if(has_post_format('gallery')) : ?>

                            <?php $images = get_post_meta( $post->ID, '_format_gallery_images', true ); ?>

                            <?php if($images) : ?>
                                <div class="flexslider carousel post-image">
                                    <ul class="slides">
                                        <?php foreach($images as $image) : ?>
                                            <?php $the_image = wp_get_attachment_image_src( $image, 'full-thumb' ); ?> 											 <?php $the_caption = get_post_field('post_excerpt', $image); ?>
                                            <li><img src="<?php echo $the_image[0]; ?>" alt="<?php if($the_caption) : ?><?php echo $the_caption; ?><?php else: ?><?php _e('Slide Image', 'indie'); ?><?php endif; ?>"/></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                        <?php elseif(has_post_format('audio')) : ?>

                            <div class="post-image audio">
                                <?php $audio = get_post_meta( $post->ID, '_format_audio_embed', true ); ?>
                                <?php if(wp_oembed_get( $audio )) : ?>
                                    <?php echo wp_oembed_get($audio); ?>
                                <?php else : ?>
                                    <?php echo $audio; ?>
                                <?php endif; ?>
                            </div>

                        <?php elseif(get_post_meta( $post->ID, '_format_video_embed', true )) : ?>

                            <div class="post-image video">
                                <?php $video = get_post_meta( $post->ID, '_format_video_embed', true ); ?>
                                <?php if(wp_oembed_get( $video )) : ?>
                                    <?php echo wp_oembed_get($video); ?>
                                <?php else : ?>
                                    <?php echo $video; ?>
                                <?php endif; ?>
                            </div>

                        <?php else : ?>

                            <?php if(has_post_thumbnail()) : ?>
                                <div class="post-image">
                                    <?php if(!is_single()): ?>
                                       <a href="<?php echo get_permalink() ?>" class="overlay"><span><?php _e('Read More', 'indie'); ?></span></a>
                                    <?php endif; ?>
                                    <figure>
                                        <?php the_post_thumbnail('full-thumb'); ?>
                                        <?php if(get_post(get_post_thumbnail_id())->post_excerpt): ?>
                                            <figcaption>
                                                <?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
                                            </figcaption>
                                        <?php endif; ?>
                                    </figure>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                </header><!-- .entry-header -->



                <div class="entry-content <?php if(is_single()):echo 'single-post';endif;?>">			
                    <?php
                        /* translators: %s: Name of current post */
                        the_content( sprintf(
                            __( 'Continue reading %s', 'indie' ), 
                            the_title( '<span class="screen-reader-text">"', '"</span>', false )
                        ) );
                    ?>
                    
                    <?php wp_link_pages(); ?>
                    
                    <div class="edit-share">
                        <?php edit_post_link( __( 'Edit', 'indie' ), '<span class="edit-link">', '</span>' ); ?>
                        <?php if(is_single()): ?>
                            <a target="_blank" title="<?php _e('share on Facebook', 'indie'); ?>" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="share-icon fa fa-facebook"></i></a>
                            <a target="_blank" title="<?php _e('share on Twitter', 'indie'); ?>" href="https://twitter.com/home?status=Check%20out%20this%20article:%20<?php the_title(); ?>%20-%20<?php the_permalink(); ?>"><i class="share-icon fa fa-twitter"></i></a>
                        <?php endif; ?>
                    </div><!-- .edit-share -->

                    
                    <?php if(is_single()) : ?>
                        <div class="post-tags">
                            <?php the_tags('<span>'. __('Tags:','indie') .'</span> ', ' ', '<br />'); ?> 
                        </div>
                    <?php endif; ?>
					
                   
                   
                </div><!-- .entry-content -->
                <?php if(is_single()):indie_post_nav(); endif;?>
                <?php if(is_single()):?>
                    <hr class="end-post-content">
                <?php endif; ?>

                <?php if(is_single()) : ?>
                    <?php get_template_part('inc/templates/about_author'); ?>
                <?php endif; ?>

                <footer class="entry-footer">
            		
                    <?php if(is_single()) : ?>
                        <?php get_template_part('inc/templates/related_posts'); ?>
                    <?php endif; ?>
                    
                </footer><!-- .entry-footer -->

            </div><!-- .inner-post -->
        </div><!-- .post-wrap -->
	</article><!-- #post-## -->
			



<article id="post-<?php the_ID(); ?>" <?php post_class( 'masonry-entry'); ?>> 
    <div class="post-wrap">
            <div class="featured-image-bg" <?php if(has_post_thumbnail()) :  $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>style="background-image:url('<?php echo $url; ?>');"<?php else: ?>style="background:#2b2b2b;"<?php endif; ?>></div>
        
        <blockquote>
            <p><?php the_content(); ?></p>
            <?php $name = get_post_meta( $post->ID, '_format_quote_source_name', true ); ?>
            <p><cite> - <?php echo($name);?> - </cite></p>
        </blockquote>
        
        <?php edit_post_link( __( 'Edit', 'indie' ), '<span class="edit-link">', '</span>' ); ?>
        
    </div><!-- .post-wrap -->
</article>
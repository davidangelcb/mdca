<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package indie
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-wrap">
        <header class="entry-header">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </header><!-- .entry-header -->
    
        <div class="entry-content">
            <?php the_content(); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'indie' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-content -->
    
        <footer class="entry-footer">
            <?php edit_post_link( __( 'Edit', 'indie' ), '<span class="edit-link">', '</span>' ); ?>
        </footer><!-- .entry-footer -->
    </div><!-- .post-wrap -->
</article><!-- #post-## -->

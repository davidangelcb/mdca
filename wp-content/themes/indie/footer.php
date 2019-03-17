<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package indie
 */
?>
			</div><!-- #content -->


                <?php if (!get_theme_mod('indie_hide_footer_widget_area')): ?>
                    <div class="footer-widgets">
                        <div class="inner">
                            <div class="foot-widget">
                                <?php if ( is_active_sidebar( 'footer-1' ) && dynamic_sidebar('footer-1') ) : else : ?>
                                    <?php echo '<h4>' . __('Widget Ready', 'indie') . '</h4>'; ?>
                                    <?php echo '<p>' . __('This right column is widget ready! Add one in the admin panel.', 'indie') . '</p>'; ?>
                                <?php endif; ?>
                            </div>
                            <div class="foot-widget">
                                <?php if ( is_active_sidebar( 'footer-2' ) && dynamic_sidebar('footer-2') ) : else : ?>
                                    <?php echo '<h4>' . __('Widget Ready', 'indie') . '</h4>'; ?>
                                    <?php echo '<p>' . __('This right column is widget ready! Add one in the admin panel.', 'indie') . '</p>'; ?>
                                <?php endif; ?>
                            </div>
                            <div class="foot-widget">
                                <?php if ( is_active_sidebar( 'footer-3' ) && dynamic_sidebar('footer-3') ) : else : ?>
                                    <?php echo '<h4>' . __('Widget Ready', 'indie') . '</h4>'; ?>
                                    <?php echo '<p>' . __('This right column is widget ready! Add one in the admin panel.', 'indie') . '</p>'; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div><!-- .footer-widgets -->
                <?php endif; ?>

                
				<?php if (!get_theme_mod('indie_hide_copyright_bar')): ?>
	                <footer class="site-footer" role="contentinfo">
	                    <div class="inner">
	
	                        <?php if(get_theme_mod('footer_copyright_strapline')) : ?>
	                            <p><?php 
                                        $args = array(
                                            'a' => array(
                                                'href' => array(),
                                                'title' => array()
                                            ),
                                            'br' => array(),
                                            'em' => array(),
                                            'strong' => array(),
                                        );
                                        echo wp_kses(get_theme_mod('footer_copyright_strapline'), $args);  ?>
                                </p>
	                        <?php else: ?>
                            	<?php $link = 'http://templateexpress.com'; ?>
	                        	<p><?php _e('Indie free Minimalist WordPress Theme developed by', 'indie'); ?> <a href="<?php echo($link); ?>"><?php _e('Template Express &copy;', 'indie');?> <?php echo(date('Y')); ?></a></p>
	                        <?php endif; ?>
	
	                    </div>
	                </footer>
	            <?php endif; ?>
	            
            </div><!-- #page -->

            <a href="#top" class="scroll-to-top"><?php __( 'Back to top', 'indie' ); ?> <i class="fa fa-long-arrow-up"></i></a>

            <?php wp_footer(); ?>
        </div><!-- .site-wrapper -->
	</body>
</html>
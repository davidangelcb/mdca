<?php

/**
 * This template generates links to social media icons once set in the theme options.  
 *
 * @package reznor
 */
?>
<ul class="social-media">

    <?php if ( get_theme_mod( 'rss' ) ) : ?>
		<li><a class="hastip rss-icon" title="RSS feed" href="<?php echo esc_url( get_theme_mod( 'rss' ) ); ?>" target="_blank"><i class="fa fa-rss-square fa-2x"></i></a></li>
	<?php endif; ?>
    
    <?php if ( get_theme_mod( 'linkedin' ) ) : ?>
		<li><a class="hastip linkedin-icon" title="LinkedIn" href="<?php echo esc_url( get_theme_mod( 'linkedin' ) ); ?>" target="_blank"><i class="fa fa-linkedin fa-2x"></i></a></li>
	<?php endif; ?>
    
	<?php if ( get_theme_mod( 'facebook' ) ) : ?>
		<li><a class="hastip facebook-icon" title="Facebook" href="<?php echo esc_url( get_theme_mod( 'facebook' ) ); ?>" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a></li>
	<?php endif; ?>
	
	<?php if ( get_theme_mod( 'googleplus' ) ) : ?>
		<li><a class="hastip google-icon" title="Google+" href="<?php echo esc_url( get_theme_mod( 'googleplus' ) ); ?>" target="_blank"><i class="fa fa-google-plus-square fa-2x"></i></a></li>
	<?php endif; ?>

</ul><!-- #social-icons-->
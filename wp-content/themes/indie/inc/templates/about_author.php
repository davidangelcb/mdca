<div class="post-author">
	<?php if(!is_author()): ?>
    	<h4>Author</h4>
    <?php endif; ?>
	<div class="author-img">
		<?php echo get_avatar( get_the_author_meta('email'), '100' ); ?>
	</div>
	<div class="author-content">
		<h5><?php the_author_posts_link(); ?></h5>
        <?php if(get_the_author_meta('twitter')) : ?><h6><a target="_blank" class="author-social" href="http://twitter.com/<?php echo the_author_meta('twitter'); ?>">@<?php echo the_author_meta('twitter'); ?></a></h6><?php endif; ?>
		<div class="author-description">
			<p><?php the_author_meta('description'); ?></p>
			<div class="author-sn">
				<?php if(get_the_author_meta('facebook')) : ?><a target="_blank" class="hastip-author author-social" title="Facebook" href="http://facebook.com/<?php echo the_author_meta('facebook'); ?>"><i class="fa fa-facebook"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('twitter')) : ?><a target="_blank" class="hastip-author author-social" title="Twitter" href="http://twitter.com/<?php echo the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('instagram')) : ?><a target="_blank" class="hastip-author author-social" title="Instagram" href="http://instagram.com/<?php echo the_author_meta('instagram'); ?>"><i class="fa fa-instagram"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('google')) : ?><a target="_blank" class="hastip-author author-social" title="Google+" href="http://plus.google.com/<?php echo the_author_meta('google'); ?>?rel=author"><i class="fa fa-google-plus"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('pinterest')) : ?><a target="_blank" class="hastip-author author-social" title="Pinterest" href="http://pinterest.com/<?php echo the_author_meta('pinterest'); ?>"><i class="fa fa-pinterest"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('tumblr')) : ?><a target="_blank" class="hastip-author author-social" title="Tumblr" href="http://<?php echo the_author_meta('tumblr'); ?>.tumblr.com/"><i class="fa fa-tumblr"></i></a><?php endif; ?>
			</div>
		</div>
	</div>
	
</div>
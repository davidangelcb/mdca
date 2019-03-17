<?php
/**
 * Masonry code for this theme.
 *
 * @package indie
 */

if(get_theme_mod('indie_homepage_column') != 'one-col' && ! function_exists('indie_masonry_scripts'))
{
    function indie_masonry_scripts()
    {
        wp_enqueue_script('masonry');
        wp_enqueue_script('imagesLoaded', get_template_directory_uri().'/js/imagesloaded.js', array('masonry'), '', true);
        wp_enqueue_script('indie-masonry', get_template_directory_uri().'/js/masonry_init.js', array('masonry', 'imagesLoaded'), '', true);
    }
    add_action('wp_enqueue_scripts', 'indie_masonry_scripts');
}
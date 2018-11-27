<?php

/**
 * Add <body> classes
 */
function bp_add_bodyclasses($classes)
{
    // add featured image class
    global $post;
    if (isset($post->ID) && get_the_post_thumbnail($post->ID)) {
        $classes[] = 'has-featured-image';
    }

    // add permalink as a class
    if (is_single() || (is_page() && !is_front_page())) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    return $classes;
}
add_filter('body_class', 'bp_add_bodyclasses');
/**
 * Clean up the_excerpt()
 */
function excerpt_more()
{
    return ' &hellip;';
}
add_filter('excerpt_more', 'excerpt_more');

function custom_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

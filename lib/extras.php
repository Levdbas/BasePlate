<?php

namespace BasePlate;

/**
 * Adding extra body classs to the body.
 * @since 1.1
 * @param array $classes origina array of body classes that we are expanding.
 */
function add_bodyclasses($classes)
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
add_filter('body_class', __NAMESPACE__ . '\\add_bodyclasses');

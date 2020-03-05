<?php

namespace BasePlate;

/**
 * Lets set up our theme!
 * - default text Domain
 * - navigation menus
 * - theme support
 * @since 1.0
 * @return [type] [description]
 */
function theme_init()
{
    load_theme_textdomain('BasePlate', get_template_directory() . '/lang');
    register_nav_menus([
        'primary_navigation' => __('Main menu', 'BasePlate'),
        'footer_navigation' => __('Footer navigation', 'BasePlate')
    ]);
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
    add_theme_support('title-tag');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', __NAMESPACE__ . '\\theme_init');


/**
 * Initialize Advanced custom fields here.
 * We run our block function over here.
 * We can also use this to run any other acf hooks.
 * @since 1.1
 * @return [type] [description]
 */
function acf_init()
{
    register_blocks();
}

add_action('acf/init', __NAMESPACE__ . '\\acf_init');

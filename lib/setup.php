<?php

namespace BasePlate;

/**
 * Lets set up our theme!
 * - default text Domain
 * - navigation menus
 * - theme support
 * @since 1.0
 * @return void
 */
function theme_init()
{
    load_theme_textdomain('BasePlate', get_template_directory() . '/resources/lang');
    register_nav_menus([
        'primary_navigation' => __('Main menu', 'BasePlate'),
        'footer_navigation' => __('Footer navigation', 'BasePlate')
    ]);
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form', 'script', 'style']);
    add_theme_support('title-tag');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');

    add_theme_support('quartermaster-clean-up');
    add_theme_support('quartermaster-development-helpers');
    add_theme_support('quartermaster-theme-helpers');
    add_theme_support('quartermaster-disable-posts-comments',);
    add_theme_support('quartermaster-disable-trackbacks');
    add_theme_support('quartermaster-disable-feeds');
    add_theme_support('quartermaster-disable-rest-api');
    add_theme_support('quartermaster-security');
    add_theme_support('quartermaster-nice-search');
    add_theme_support('quartermaster-content-lock');
}
add_action('after_setup_theme', __NAMESPACE__ . '\\theme_init');

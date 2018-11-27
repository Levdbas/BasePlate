<?php

/**
 * Theme setup
 */
function setup()
{
    load_theme_textdomain('BasePlate', get_template_directory() . '/lang');
    register_nav_menus([
        'primary_navigation' => __('Main menu', 'BasePlate')
    ]);
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'setup');

function baseplate_acf_init()
{
    baseplate_register_blocks();
}

add_action('acf/init', 'baseplate_acf_init');

/* security */
function my_htaccess_contents($rules)
{
    return $rules .
        "
    #Stop spam attack logins and comments
    <Files 'xmlrpc.php'>
    Order Allow,Deny
    deny from all
    </Files>\n";
}
add_filter('mod_rewrite_rules', 'my_htaccess_contents');

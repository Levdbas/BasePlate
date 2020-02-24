<?php

/**
 * Lets set up our theme!
 * - default text Domain
 * - navigation menus
 * - theme support
 * @since
 * @return [type] [description]
 */
function bp_setup()
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
add_action('after_setup_theme', 'bp_setup');

/**
 * Initialize Advanced custom fields here.
 * We run our block function over here.
 * We can also use this to run any other acf hooks.
 * @since 1.1
 * @return [type] [description]
 */
function baseplate_acf_init()
{
    //baseplate_register_blocks();
}

add_action('acf/init', 'baseplate_acf_init');

/**
 * Let's enhance our security.
 * We use this function to append extra htacces rules that block access to the xmlrpc endpoint.
 * @since
 * @param  [type] $rules [description]
 * @return [type]        [description]
 */
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

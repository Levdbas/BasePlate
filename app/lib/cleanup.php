<?php

if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
add_action('do_feed', 'bp_disable_feed', 1);
add_action('do_feed_rdf', 'bp_disable_feed', 1);
add_action('do_feed_rss', 'bp_disable_feed', 1);
add_action('do_feed_rss2', 'bp_disable_feed', 1);
add_action('do_feed_atom', 'bp_disable_feed', 1);
add_filter('post_thumbnail_html', 'bp_remove_thumbnail_dimensions', 10, 3);
add_filter('style_loader_src', 'bp_remove_wp_ver', 9999);
add_filter('script_loader_src', 'bp_remove_wp_ver', 9999);
add_action('admin_bar_menu', 'bp_admin_bar', 999);
add_action('admin_menu', 'bp_admin_menu');

function bp_disable_feed()
{
    die();
}

function bp_remove_wp_ver($src)
{
    if (strpos($src, 'ver=' . get_bloginfo('version'))) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

function bp_remove_thumbnail_dimensions($html, $post_id, $post_image_id)
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', '', $html);
    return $html;
}

function bp_admin_menu()
{
    remove_menu_page('edit-comments.php');
    remove_menu_page('edit.php');
    remove_menu_page('post-new.php');
}

function bp_admin_bar()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('new-post');
    $wp_admin_bar->remove_node('comments');
}

<?php



/**
 * Theme setup
 */
function setup() {
  load_theme_textdomain('BasePlate', get_template_directory() . '/lang');
  register_nav_menus([
    'primary_navigation' => __('Main menu', 'BasePlate'),
  ]);
  add_theme_support('post-thumbnails');
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
}
add_action('after_setup_theme', 'setup');



function my_admin_menu() {
     remove_menu_page( 'link-manager.php' );
     remove_menu_page( 'edit-comments.php' );
     remove_menu_page( 'edit.php' );
     remove_menu_page( 'post-new.php' );
}
add_action( 'admin_menu', 'my_admin_menu' );

// new posts verwijderen uit admin bar
function remove_wp_nodes(){
    global $wp_admin_bar;
    $wp_admin_bar->remove_node( 'new-post' );
}
add_action( 'admin_bar_menu', 'remove_wp_nodes', 999 );



function add_featured_image_body_class( $classes ) {
    global $post;
    if ( isset ( $post->ID ) && get_the_post_thumbnail($post->ID)) {
        $classes[] = 'has-featured-image';
    }
    return $classes;
}
add_filter( 'body_class', 'add_featured_image_body_class' );


if ( class_exists( 'TriggerBrowsersync' )  && strpos(get_site_url(), '.local') !== false ) {
  new TriggerBrowsersync();
}

/* security */
function my_htaccess_contents( $rules )
{
    return $rules . "
    #Stop spam attack logins and comments
    <Files 'xmlrpc.php'>
    Order Allow,Deny
    deny from all
    </Files>\n";
}
add_filter('mod_rewrite_rules', 'my_htaccess_contents');

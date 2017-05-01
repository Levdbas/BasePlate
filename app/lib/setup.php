<?php


use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('hoofdmenu', 'sage')
  ]);

  add_theme_support('post-thumbnails');
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
}
// remove bullshit.
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'rel_canonical', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
add_action( 'do_feed', 'disable_feed', 1 );
add_action( 'do_feed_rdf', 'disable_feed', 1 );
add_action( 'do_feed_rss', 'disable_feed', 1 );
add_action( 'do_feed_rss2', 'disable_feed', 1 );
add_action( 'do_feed_atom', 'disable_feed', 1 );
add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
     remove_menu_page( 'link-manager.php' );
     remove_menu_page( 'edit-comments.php' );
     remove_menu_page( 'edit.php' );
     remove_menu_page( 'post-new.php' );
     //remove_menu_page( 'tools.php' );
}
add_action('load-press-this.php', function() {
  wp_die(__('Press-this is uitgeschakeld', 'sage'));
});
function disable_feed() {
    die();
}
define('DISALLOW_FILE_EDIT', true);
// new posts verwijderen uit admin bar
function remove_wp_nodes()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_node( 'new-post' );
}
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );


function add_featured_image_body_class( $classes ) {
    global $post;
    if ( isset ( $post->ID ) && get_the_post_thumbnail($post->ID)) {
        $classes[] = 'has-featured-image';
    }
    return $classes;
}
add_filter( 'body_class', 'add_featured_image_body_class' );
/**
 * Theme assets
 */
function assets() {
  // vraag de mix-manifest file op
  $manifest = (__DIR__ . '/../dist/mix-manifest.json');
  //echo $manifest;
  if (file_exists($manifest)){
    $manifest = file_get_contents($manifest);
    $json = json_decode($manifest, true);
    // lees waarde uit json files
    $jsFile = $json['/scripts/app.js'];
    $cssFile = $json['/styles/app.css'];
    // enque de twee files uit de manist file
    wp_enqueue_style('sage/css', Assets\asset_path($cssFile), false, null);
    wp_enqueue_script('sage/js', Assets\asset_path($jsFile), ['jquery'], null, true);
  }
  else{
    wp_die(__('Draai webpack voor de eerste keer om de manifest file te genereren', 'sage'));
  }
  // leest de comment reply alleen in op het moment dat deze nodig is
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', '', $html );
	return $html;
}
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

/* security */
function my_htaccess_contents( $rules )
{
    // echo '<pre>'. $rules .'</pre>';
    // exit();
    return $rules . "
#Stop spam attack logins and comments
<Files 'xmlrpc.php'>
Order Allow,Deny
deny from all
</Files>\n";
}
add_filter('mod_rewrite_rules', 'my_htaccess_contents');

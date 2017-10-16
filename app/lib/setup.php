<?php


use Roots\Sage\Assets;

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
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');



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


// theme asset base
 function getAssetBase($type = null, $filename = null) {
   if (!isset($type) || $type == false){
     $privAssetDir = get_template_directory().'/dist/';
     $pubAssetDir = get_template_directory_uri(). '/dist/';
   } else{
     $privAssetDir = get_template_directory(). '/dist/' . $type.'/';
     $pubAssetDir = get_template_directory_uri(). '/dist/' . $type.'/';
   }
   if (isset($filename)){
     $filename = preg_split('~.(?=[^.]*$)~', $filename);
     $filename = glob($privAssetDir.$filename[0].'*'.$filename[1]);
     $file = str_replace($privAssetDir, $pubAssetDir, $filename);
   }
   return $file[0];
 }
 add_filter('getAssetBase','getAssetBase');

function assetbase($type = null, $filename = null){
  echo getAssetBase($type, $filename);
}
add_filter('assetBase','assetBase');

function assets() {

  // Look for the manifest file.
  $manifest = (__DIR__ . '/../dist/manifest.json');

  if (file_exists($manifest)){

    $manifest = file_get_contents($manifest);
    $json = json_decode($manifest, true);

    // read values from our manifest file.
    $cssFile = $json['app.css'];
    $jsFile = $json['app.js'];
    // remove jQuery as we included it in our app.js
    wp_deregister_script('jquery');
    wp_enqueue_style( 'BasePlate/css', getAssetBase(false, $cssFile));
    wp_enqueue_script('BasePlate/js', getAssetBase(false, $jsFile), false, false, true);
  }

  else{
    wp_die(__('Draai webpack voor de eerste keer om de manifest file te genereren', 'BasePlate'));
  }
  // leest de comment reply alleen in op het moment dat deze nodig is
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

if ( class_exists( 'TriggerBrowsersync' )  && strpos(get_site_url(), '.dev') !== false ) {
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

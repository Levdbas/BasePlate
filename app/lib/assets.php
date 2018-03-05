<?php

function getAsset($asset) {

  // Look for the manifest file.
  $manifest = (__DIR__ . '/../dist/manifest.json');
  if (file_exists($manifest)){
    $manifest = file_get_contents($manifest);
    $json = json_decode($manifest, true);
    $file = $json[$asset];
    return $file;
  }
  else{
    wp_die(__('Draai webpack voor de eerste keer om de manifest file te genereren', 'BasePlate'));
  }
}
function the_asset($asset){
  echo getAsset($asset);
}
add_filter('the_asset', 'the_asset');

function criticalstyles_in_header() {
	echo '<style>';
	include get_stylesheet_directory() . '/dist/styles/critical.php';
	echo '</style>';
}
add_action( 'wp_head', 'criticalstyles_in_header' );

function scripts_in_footer(){
  wp_deregister_script('jquery');
  wp_enqueue_style( 'BasePlate/css', get_template_directory_uri().'/dist/'.getAsset('app.css'));
  wp_enqueue_script('BasePlate/js', get_template_directory_uri().'/dist/'.getAsset('app.js'), false, false);
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'scripts_in_footer', 100);

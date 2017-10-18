<?php

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
 add_filter('getAssetBase', 'getAssetBase');

function assetBase($type = null, $filename = null){
  echo getAssetBase($type, $filename);
}
add_filter('assetBase', 'assetBase');




function assetName($asset) {

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

function criticalstyles_in_header() {
	echo '<style>';
	include get_stylesheet_directory() . '/dist/styles/critical.php';
	echo '</style>';
}
add_action( 'wp_head', 'criticalstyles_in_header' );

function scripts_in_footer(){
  wp_deregister_script('jquery');
  //wp_enqueue_style( 'BasePlate/css', get_template_directory_uri().'/dist/'.assetName('app.css'));
  wp_enqueue_script('BasePlate/js', get_template_directory_uri().'/dist/'.assetName('app.js'), false, false, true);
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'scripts_in_footer', 100);

function styles_in_footer() {
	echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/dist/'.assetName('app.css').'" type="text/css" media="all" />';
}
add_action( 'wp_footer', 'styles_in_footer' );

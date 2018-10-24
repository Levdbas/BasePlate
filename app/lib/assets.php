<?php
function get_asset($asset)
{
  // Look for the manifest file.
  $manifest = (__DIR__ . '/../dist/manifest.json');
  if (file_exists($manifest)) {
    $manifest = file_get_contents($manifest);
    $json     = json_decode($manifest, true);
    $file     = $json[$asset];
    $file     = get_template_directory_uri() . '/dist/' . $file;
    return $file;
  } else {
    wp_die(__('Draai webpack voor de eerste keer om de manifest file te genereren', 'BasePlate'));
  }
}

function the_asset($asset)
{
  echo get_asset($asset);
}



function scripts_in_footer()
{
  wp_deregister_script('jquery');
  wp_enqueue_style('BasePlate/css', get_asset('app.css'));
  wp_enqueue_script('BasePlate/vendor', get_asset('vendor.js'), false, false);
  wp_enqueue_script('BasePlate/js', get_asset('app.js'), false, false);
}


function baseplate_editor_assets() {
  // Scripts.
  wp_enqueue_script(
    'baseplate-block-js', // Handle.
    plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
    array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
    // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
    true // Enqueue the script in the footer.
  );

  // Styles.
  wp_enqueue_style(
    'baseplate-block-editor-css', // Handle.
    get_asset('editor.css'), // Block editor CSS.
    array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
    // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: filemtime — Gets file modification time.
  );
}
function baseplate_block_assets() {
  // Styles.
  wp_enqueue_style(
    'baseplate-style-css', // Handle.
    get_asset('blocks.css'), // Block style CSS.
    array( 'wp-blocks' ) // Dependency to include the CSS after it.
  );
}
add_action('wp_enqueue_scripts', 'scripts_in_footer', 100);
add_action( 'enqueue_block_assets', 'baseplate_block_assets');
add_action( 'enqueue_block_editor_assets', 'baseplate_editor_assets' )
?>

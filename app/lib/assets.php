<?php
/**
 * Returns the current path of the provided asset
 *
 * @param string $asset the name of the asset including the actual path
 * @return string
 */
function get_asset($asset)
{
    // Look for the manifest file.
    $manifest = __DIR__ . '/../dist/manifest.json';
    if (file_exists($manifest)) {
        $manifest = file_get_contents($manifest);
        $json = json_decode($manifest, true);
        $file = $json[$asset];
        $file = get_template_directory_uri() . '/dist/' . $file;
        return $file;
    } else {
        wp_die(__('Manifest file not found. Did you run Webpack for the first time?', 'BasePlate'));
    }
}
/**
 * Echoes get_asset
 *
 * @param string $asset the name of the asset including the actual path
 * @return string
 */
function the_asset($asset)
{
    echo get_asset($asset);
}

function bp_enqueue()
{
    wp_deregister_script('jquery');
    wp_enqueue_style('BasePlate/css', get_asset('app.css'), false);
    wp_enqueue_script('BasePlate/vendor', get_asset('vendor.js'), false);
    wp_enqueue_script('BasePlate/js', get_asset('app.js'), 'BasePlate/vendor');
}

function bp_editor_assets()
{
    /* Scripts.
  wp_enqueue_script(
      'baseplate-block-js', // Handle.
      plugins_url('/dist/blocks.build.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
      array('wp-blocks', 'wp-i18n', 'wp-element'), // Dependencies, defined above.
      wp_get_theme()->Version,
      true // Enqueue the script in the footer.
  );
  */
    // Styles.
    wp_enqueue_style('baseplate-block-editor-css', get_asset('gutenberg.css'), array('wp-edit-blocks'));
}

function bp_async_attr($tag, $handle)
{
    // add script handles to the array below
    $scripts_to_async = array('BasePlate/js', 'BasePlate/vendor');

    foreach ($scripts_to_async as $async_script) {
        if ($async_script === $handle) {
            return str_replace(' src', ' async="async" src', $tag);
        }
    }
    return $tag;
}
add_filter('script_loader_tag', 'bp_async_attr', 10, 2);
add_action('wp_enqueue_scripts', 'bp_enqueue');
add_action('enqueue_block_editor_assets', 'bp_editor_assets');
?>

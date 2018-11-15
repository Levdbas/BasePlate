<?php
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

function the_asset($asset)
{
    echo get_asset($asset);
}

function scripts_in_footer()
{
    wp_deregister_script('jquery');
    wp_enqueue_style('BasePlate/css', get_asset('app.css'), false);
    wp_enqueue_script('BasePlate/vendor', get_asset('vendor.js'), false);
    wp_enqueue_script('BasePlate/js', get_asset('app.js'), 'BasePlate/vendor');
}

function baseplate_editor_assets()
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

function add_async_attribute($tag, $handle)
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
add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
add_action('wp_enqueue_scripts', 'scripts_in_footer', 100);
add_action('enqueue_block_editor_assets', 'baseplate_editor_assets');
?>

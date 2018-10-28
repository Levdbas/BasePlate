<?php
function get_asset($asset)
{
    if (file_exists(get_template_directory() . '/dist/')) {
        $file = get_template_directory_uri() . '/dist/' . $asset;
        return $file;
    } else {
        wp_die(__('Draai webpack voor de eerste keer om de dist folder te genereren', 'BasePlate'));
    }
}

function the_asset($asset)
{
    echo get_asset($asset);
}

function scripts_in_footer()
{
    wp_deregister_script('jquery');
    wp_enqueue_style('BasePlate/css', get_asset('styles/app.css'), false, wp_get_theme()->Version);
    //wp_enqueue_script('BasePlate/vendor', get_asset('scripts/vendor.js'), false, wp_get_theme()->Version);
    wp_enqueue_script('BasePlate/js', get_asset('scripts/app.js'), false, wp_get_theme()->Version);
}

function baseplate_editor_assets()
{
    // Scripts.
    wp_enqueue_script(
        'baseplate-block-js', // Handle.
        plugins_url('/dist/blocks.build.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
        array('wp-blocks', 'wp-i18n', 'wp-element'), // Dependencies, defined above.
        wp_get_theme()->Version,
        true // Enqueue the script in the footer.
    );

    // Styles.
    wp_enqueue_style(
        'baseplate-block-editor-css', // Handle.
        get_asset('styles/editor.css'), // Block editor CSS.
        array('wp-edit-blocks'), // Dependency to include the CSS after it.
        wp_get_theme()->Version
    );
}
function baseplate_block_assets()
{
    // Styles.
    wp_enqueue_style(
        'baseplate-style-css', // Handle.
        get_asset('blocks.css'), // Block style CSS.
        array('wp-blocks') // Dependency to include the CSS after it.
    );
}
add_action('wp_enqueue_scripts', 'scripts_in_footer', 100);
add_action('enqueue_block_assets', 'baseplate_block_assets');
add_action('enqueue_block_editor_assets', 'baseplate_editor_assets');
?>

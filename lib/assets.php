<?php

namespace BasePlate;

/**
 * Returns the current path of the provided asset
 *
 * @param string $asset the name of the asset including the actual path
 * @return string
 */
function get_asset($asset, string $return_variant = null)
{
    $manifest = __DIR__ . '/../dist/manifest.json';
    if (file_exists($manifest)) {
        $manifest = file_get_contents($manifest);
        $json = json_decode($manifest, true);

        if (isset($json[$asset])) {
            $file = $json[$asset];

            switch ($return_variant) {
                case 'path':
                    return get_stylesheet_directory() . '/dist/' . $file;
                    break;
                case 'contents':
                    return file_get_contents(get_stylesheet_directory() . '/dist/' . $file, true);
                    break;
                default:
                    return get_stylesheet_directory_uri() . '/dist/' . $file;
                    break;
            }
        } else {
            return sprintf(__('File %s not found.', 'BasePlate'), $asset);
        }
    } else {
        frontend_error(__('Did you run Webpack for the first time?', 'BasePlate'), 'Manifest file not found');
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

/**
 * The front-end enqueue function for BasePlate.
 * 
 * @return [type] [description]
 */
function frontend_assets()
{
    $site = [];
    wp_enqueue_script('BasePlate/vendor', get_asset('vendor.js'), array(), false, false);
    wp_enqueue_script('BasePlate/js', get_asset('app.js'), 'BasePlate/vendor', false, false);
    wp_register_script('jquery', false, array('BasePlate/js'), '', false); // re-gegister jQuery again as part of BasePlate/js where we import jquery to our window
    wp_enqueue_style('BasePlate/css', get_asset('app.css'), false, null);

    $site = array(
        'dist' => get_template_directory_uri() . '/dist/',
        'url' => get_bloginfo('url'),
        'ajax' => admin_url('admin-ajax.php')
    );
    wp_localize_script('BasePlate/js', 'bp_site', $site);
}
/**
 * the back-end enqueue function for BasePlate
 * loads the special gutenberg.css file that wraps most, but not all scss partials from our assets/style folder
 * and wraps them in the gutenberg editor class.
 * This hook can later be expanded to include custom javascript as well.
 */
function editor_assets()
{
    wp_enqueue_script('BasePlate/vendor', get_asset('vendor.js'), false);
    wp_enqueue_script('BasePlate/gutenberg-js', get_asset('gutenberg.js'), array('wp-blocks', 'wp-i18n', 'wp-element', 'BasePlate/vendor', 'acf-blocks'));
    wp_enqueue_style('BasePlate/gutenberg-css', get_asset('gutenberg.css'), array('wp-edit-blocks'));
}

/**
 * Takes the javascript enqueues and adds the async attribute.
 * to speed up the load times.
 * @param  [type] $tag    the given tags from a handle.
 * @param  [type] $handle the enqueues
 * @return [type]         returns updates handles including the async tag.
 */
function async_attr($tag, $handle)
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

add_filter('script_loader_tag', __NAMESPACE__ . '\\async_attr', 10, 2);
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\frontend_assets');
add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\\editor_assets');

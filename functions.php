<?php

namespace BasePlate;

function frontend_error($message, $subtitle = '', $title = '')
{
    $title = $title ?: __('BasePlate &rsaquo; Error', 'sage');
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p>";
    wp_die($message, $title);
};

function backend_error($message, $subtitle = '', $title = '')
{
    $title = $title ?: __('BasePlate &rsaquo; Error', 'sage');
    $message = "<div class='error'><h2>{$title}<br><small>{$subtitle}</small></h2><p>{$message}</p></div>";
    add_action('admin_notices', function () use ($message) {
        echo $message;
    });
};


// Send notice to user if Timber Class cannot be found
if (!class_exists('Timber')) {
    // Notice on admin pages

    backend_error('Timber not activated. Make sure you activate the plugin.');

    // Notice on front pages
    add_filter('template_include', function () {
        frontend_error(__('Timber not activated. Make sure you activate the plugin.', 'BasePlate'));
    });

    return 0;
}

$baseplate_includes = [
    'lib/cleanup.php', // Theme setup
    'lib/setup.php', // Theme setup
    'lib/timber.php', // Theme setup
    'lib/assets.php', // Theme asset functions
    'lib/lazyload.php', // lazyload functionality
    'lib/blocks.php', // Gutengerb blocks
    'lib/bootstrap_navwalker.php', // navwalker
    'lib/extras.php', // Custom functions
    'lib/sidebars.php' // Theme sidebars
];

foreach ($baseplate_includes as $file) {
    if (!($filepath = locate_template($file))) {
        frontend_error(sprintf(__('Error locating %s for inclusion', 'BasePlate'), $file));
    }

    require_once $filepath;
}
unset($file, $filepath);


/**
 * Model autoloader
 *
 * Include all custom post types and block defintions automamagically
 */
foreach (glob(get_template_directory() . '/lib/models/*.php') as $filename) {
    include $filename;
}

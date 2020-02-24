<?php

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
        trigger_error(sprintf(__('Error locating %s for inclusion', 'BasePlate'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);

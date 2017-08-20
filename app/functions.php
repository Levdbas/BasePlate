<?php

$basePlate_includes = [
  'lib/setup.php',     // Theme setup
  '/lib/wp_bootstrap_navwalker.php',    // navwalker
  '/lib/shortcodes/_require.php',    // shotcodes
  '/lib/widgets/_require.php',    // shotcodes
  'lib/extras.php',    // Custom functions
  'lib/sidebars.php' // Theme sidebars
];

foreach ($basePlate_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'BasePlate'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

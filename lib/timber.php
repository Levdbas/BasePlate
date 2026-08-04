<?php

namespace BasePlate;

use Timber;

/**
 * Adds custom paths to the Timber loader.
 * 
 *
 * @param array $paths the default paths.
 * @return array $paths updated namespaces and paths.
 */
function timber_file_paths(array $paths): array
{
   $paths['__main__'] = [
      get_stylesheet_directory() . '/resources/views',
      get_template_directory() . '/resources/views',
   ];

   $paths['blocks'] = [
      get_stylesheet_directory() . '/blocks',
      get_template_directory() . '/blocks',
   ];

   return $paths;
}
add_filter('timber/locations', __NAMESPACE__ . '\\timber_file_paths');

/**
 * Adds data to Timber context.
 *
 * @param $data
 *
 * @return mixed
 */
function add_to_context($data)
{
   $data['primary_menu'] = wp_nav_menu([
      'echo'           => false,
      'theme_location' => 'primary_navigation',
      'depth'          => 2,
      'container'      => false,
      'menu_class'     => 'nav nav-menu',
   ]);

   $data['development'] = defined('WP_ENV') && WP_ENV == 'development' ? true : false;
   //$data['messages'] = get_template_messages();
   $data['options'] = get_fields('options');
   $data['logo']    = get_asset('images/logo.svg');
   return $data;
}

add_filter('timber/context', __NAMESPACE__ . '\\add_to_context');

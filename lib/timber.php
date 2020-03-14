<?php

namespace BasePlate;

use Timber;

Timber\Timber::$dirname = ['resources/views'];

/**
 * Adds data to Timber context.
 *
 * @param $data
 *
 * @return mixed
 */
function add_to_context($data)
{
   $data['primary_menu'] = wp_nav_menu(array(
      'echo' => false,
      'theme_location' => 'primary_navigation',
      'depth' => 2,
      'container' => false,
      'menu_class' => 'nav nav-menu'
   ));

   $data['development'] = defined('WP_ENV') && WP_ENV == 'development' ? true : false;
   //$data['messages'] = get_template_messages();
   $data['options'] = get_fields('options');
   $data['logo'] = get_asset('images/logo.svg');
   $classes = get_body_class();
   return $data;
}

add_filter('timber_context', __NAMESPACE__ . '\\add_to_context');


/**
 * My custom Twig functionality.
 *
 * @param \Twig\Environment $twig
 * @return \Twig\Environment
 * @since 2.0
 */
function add_to_twig($twig)
{
   // Adding a function.
   $twig->addFunction(new Timber\Twig_Function('bp_lazyload_img', 'bp_lazyload_img'));
   $twig->addFunction(new Timber\Twig_Function('bp_lazyload_bg_img', 'bp_lazyload_bg_img'));
   return $twig;
}
add_filter('timber/twig', __NAMESPACE__ . '\\add_to_twig');

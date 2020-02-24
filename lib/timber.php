<?php

// Send notice to user if Timber Class cannot be found
if (!class_exists('Timber')) {
   // Notice on admin pages
   add_action('admin_notices', function () {
      echo '<div class="error">
                  <p>Timber not activated. Make sure you activate the plugin in
                      <a href="' .
         esc_url(admin_url('plugins.php#timber')) .
         '">' .
         esc_url(admin_url('plugins.php')) .
         '</a>
                  </p>
              </div>';
   });

   // Notice on front pages
   add_filter('template_include', function () {
      wp_die(__('Timber not found. Did you active the plugin?', 'BasePlate'));
   });

   return 0;
}

/*
|--------------------------------------------------------------------------
| Template paths
|--------------------------------------------------------------------------
|
| Here you may specify an array of paths where to load templates.
|
| Default path: 'resources/views'
|
 */

Timber::$dirname = ['resources/views'];

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

add_filter('timber_context', 'add_to_context');


/**
 * My custom Twig functionality.
 *
 * @param \Twig\Environment $twig
 * @return \Twig\Environment
 */
function add_to_twig($twig)
{
   // Adding a function.
   $twig->addFunction(new Timber\Twig_Function('bp_lazyload_img', 'bp_lazyload_img'));
   $twig->addFunction(new Timber\Twig_Function('bp_lazyload_bg_img', 'bp_lazyload_bg_img'));
   return $twig;
}
add_filter('timber/twig', 'add_to_twig');

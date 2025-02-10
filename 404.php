<?php

/**
 * The 404 template file
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage BasePlate
 */

use Timber\Timber;

$context = Timber::context(
   [
      'menu_404' => [
         'show' => has_nav_menu('404_navigation'),
         'menu' => Timber::get_menu('404_navigation'),
      ],
   ]
);

Timber::render('templates/404.twig', $context);

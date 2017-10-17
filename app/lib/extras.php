<?php

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }
  return $classes;
});

/**
 * Clean up the_excerpt()
 */
 function excerpt_more() {
   return ' &hellip;';
 }
 add_filter('excerpt_more', 'excerpt_more');

 function wpdocs_custom_excerpt_length( $length ) {
     return 20;
 }
 add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

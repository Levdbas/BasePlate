<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
 function excerpt_more() {
   return ' &hellip;';
 }
 add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

 function wpdocs_custom_excerpt_length( $length ) {
     return 20;
 }
 add_filter( 'excerpt_length', __NAMESPACE__ . '\\wpdocs_custom_excerpt_length', 999 );

 function title() {
   if (is_home()) {
     if (get_option('page_for_posts', true)) {
       return get_the_title(get_option('page_for_posts', true));
     } else {
       return __('Latest Posts', 'sage');
     }
   } elseif (is_archive()) {
     return get_the_archive_title();
   } elseif (is_search()) {
     return sprintf(__('Search Results for %s', 'sage'), get_search_query());
   } elseif (is_404()) {
     return __('Not Found', 'sage');
   } else {
     return get_the_title();
   }
 }

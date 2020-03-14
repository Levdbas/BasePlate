<?php

namespace BasePlate;

function block_categories($categories, $post)
{
   return array_merge($categories, array(

      /* array(
         'slug' => 'example',
         'title' => 'Example Category'
      ) */
      //
   ));
}

add_filter('block_categories', __NAMESPACE__ . '\\block_categories', 10, 2);

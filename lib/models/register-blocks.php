<?php

namespace BasePlate;

/**
 * Function that checks for ACF function acf_register_block()
 * and registered blocks.
 * @since 1.1.0
 */
function register_blocks()
{
   if (function_exists('acf_register_block')) {
      acf_register_block(array(
         'name' => 'example',
         'title' => __('Google map', 'baseplate'),
         'align' => 'full',
         'description' => __('Pagina header voor de kaart', 'baseplate'),
         'render_callback' => __NAMESPACE__ . '\\render_acf_block',
         'category' => 'example',
         'icon' => 'location-alt',
         'keywords' => array('example'),
         'supports' => array(
            'align' => array('wide', 'full', 'center')
         )
      ));
   }
}

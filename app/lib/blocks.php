<?php



/**
 * Function that checks for ACF beta function acf_register_block()
 * and registered blocks.
 * @since 1.1.0
 */

function baseplate_register_blocks()
{
    if (function_exists('acf_register_block')) {
        // register a testimonial block
        acf_register_block(array(
            'name' => 'tabs',
            'title' => __('Tabbed content'),
            'description' => __('Tabbed content'),
            'render_callback' => 'baseplate_acf_bock_render_callback',
            'category' => 'formatting',
            'icon' => 'admin-comments',
            'keywords' => array('tabs', 'tab')
        ));
    }
}



/**
 * Function that matches the block file to the above defined acf_blocks
 * @param  object filled by acf_register_block() function
 * @since 	1.1.0
 */

 function baseplate_acf_block_render_callback($block)
 {
     $slug = str_replace('acf/', '', $block['name']);
     if (file_exists(get_stylesheet_directory() . "/partials/blocks/block-{$slug}.php")) {
         include get_stylesheet_directory() . "/partials/blocks/block-{$slug}.php";
     }
 }



 /**
  * returns one of the the elements of the $block element.
  * Currently only handles the ID of $block.
  * @since 1.1
  * @param  string $attr  the attribute you want to retrun
  * @param  object $block the block object passed by ACF
  * @return string        the attribute you need
  */

 function bp_acf_block_attr($attr, $block)
 {
     $slug = str_replace('acf/', '', $block['name']);
     switch ($attr) {
         case 'id':
             return $slug . '-' . $block['id'];
             break;

         default:
             return $slug . '-' . $block['id'];
             break;
     }
 }



/**
 * All classes for blocks combined in one function.
 * Handles naming, aligning and custom classes.
 * @since 1.1
 * @param  object $block         the block object passed by ACF
 * @param  string $extra_classes string of extra classes passed to the block class attr
 * @return string                string with all combined classnames.
 */

 function bp_block_classes($block, $extra_classes = '')
 {
     $slug = str_replace('acf/', '', $block['name']);
     $align_class = $block['align'] ? 'align' . $block['align'] : '';
     $classes = '';
     $classes .= 'block block-' . $slug . ' ';
     $classes .= $align_class . ' ';
     $classes .= $extra_classes . ' ';
     $classes = trim($classes, " ");
     return $classes;
 }



 /**
  * Echoes bp_block_classes()
  * @since 1.1
  * @param  [type] $block         the block object passed by ACF
  * @param  string $extra_classes string of extra classes passed to the block class attr
  */

 function the_bp_block_classes($block, $extra_classes = '')
 {
     echo bp_block_classes($block, $extra_classes);
 }
?>

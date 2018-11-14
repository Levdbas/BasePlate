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
 * @param  variable filled by acf_register_block() function
 * @since 	1.1.0
 */
function baseplate_acf_bock_render_callback($block)
{
    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);
    // include a template part from within the "partials/block" folder
    //
    if (file_exists(get_stylesheet_directory() . "/partials/blocks/block-{$slug}.php")) {
        include get_stylesheet_directory() . "/partials/blocks/block-{$slug}.php";
    }
}
function get_baseplate_acf_block_att($att, $block)
{
    $slug = '';
    switch ($att) {
        case 'id':
            return $slug . '-' . $block['id'];
            break;

        default:
            return $slug . '-' . $block['id'];
            break;
    }
}
?>

<?php

namespace BasePlate;

use Timber;

/**
 * Function that matches the block file to the above defined acf_blocks
 * @param  object $block filled by acf_register_block() function
 * @since 	1.1.0
 */

function render_acf_block($block, $content = '', $is_preview = false, $post_id = 0)
{
    $slug = str_replace('acf/', '', $block['name']);
    $context = Timber\Timber::context();
    $context['slug'] = $slug;
    $context['block'] = $block;
    $context['post_id'] = $post_id;
    $context['is_preview'] = $is_preview;
    $context['post'] = new Timber\Post();
    $context['fields'] = get_fields();
    $context['classes'] = block_classes($block);

    if (file_exists(get_stylesheet_directory() . "/resources/views/blocks/{$slug}.twig")) {
        Timber\Timber::render("resources/views/blocks/{$slug}.twig", $context);
    } elseif (file_exists(get_stylesheet_directory() . "/resources/views/blocks/{$slug}/{$slug}.twig")) {
        Timber\Timber::render("resources/views/blocks/{$slug}/{$slug}.twig", $context);
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

function block_classes($block, $extra_classes = '')
{
    $slug = str_replace('acf/', '', $block['name']);
    $align_class = $block['align'] ? 'align' . $block['align'] : '';
    $classes = '';
    $classes .= 'block ' . $slug . ' ';
    $classes .= $align_class . ' ';
    $classes .= $extra_classes . ' ';
    $classes = trim($classes, ' ');
    return $classes;
}

<?php

function baseplate_lazyload_image($attachment_id, $size = 'thumbnail', $icon = false, $attr = '')
{
    $html = '';
    $html = wp_get_attachment_image($attachment_id, $size, $icon, $attr);
    $html = str_replace('src=', 'data-src=', $html);
    $html = str_replace('srcset=', 'data-srcset=', $html);
    $html = str_replace('class="', 'class="lazyload ', $html);
    return $html;
}

function baseplate_lazyload_bg_image($image_id, $size = 'large')
{
    $html = '';
    $term_image = wp_get_attachment_image_src($image_id, $size);
    $term_image = $term_image[0];
    $html = 'data-background-image="' . $term_image . '"';
    return $html;
}

add_filter('the_content', 'baseplate_lazyload_content_images', 11);

function baseplate_lazyload_content_images($content)
{
    //-- Change src/srcset to data attributes.
    $content = preg_replace("/<img(.*?)(src=|srcset=)(.*?)>/i", '<img$1data-$2$3>', $content);
    //-- Add .lazyload class to each image that already has a class.
    $content = preg_replace('/<img(.*?)class=\"(.*?)\"(.*?)>/i', '<img$1class="$2 lazyload"$3>', $content);
    //-- Add .lazyload class to each image that doesn't have a class.
    $content = preg_replace('/<img(.*?)(?!\bclass\b)(.*?)/i', '<img$1 class="lazyload"$2', $content);
    return $content;
}

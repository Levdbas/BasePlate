<?php

/**
 * Based on wp_get_attachment_image() but now lazyload ready.
 * @since 1.1
 * @param  int     $attachment_id Image attachment ID.
 * @param  string  $size          Image size.
 * @param  boolean $icon          Whether the image should be treated as an icon.
 * @param  string  $attr          Attributes for the image markup
 * @return string                 HTML img element or empty string on failure.
 */
function bp_lazyload_img($attachment_id, $size = 'large', $icon = false, $attr = '')
{
    $html = '';
    $html = wp_get_attachment_image($attachment_id, $size, $icon, $attr);
    $html = str_replace('src=', 'data-src=', $html);
    $html = str_replace('srcset=', 'data-srcset=', $html);
    $html = str_replace('class="', 'class="lazyload ', $html);
    return $html;
}
/**
 * Based on wp_get_attachment_image_src() but now with lazyload background functionallity.
 * Used as follows, <div class="lazyload" <?php echo bp_lazyload_bg_img($image_id, $size); ?>></div>
 * @since
 * @param  int    $image_id Image attachment ID.
 * @param  string $size     Image size.
 * @return string           HTML attr for lazyloading a background image. Do not forget to set the class .lazyload as well.
 */
function bp_lazyload_bg_img($image_id, $size = 'large')
{
    $html = '';
    $term_image = wp_get_attachment_image_src($image_id, $size);
    $term_image = $term_image[0];
    $html = 'data-background-image="' . $term_image . '"';
    return $html;
}



/**
 * replace src with data-src and add lazyload class
 * @since
 * @param  string $content content passed by the_content()
 * @return [type]          returns the_content with images now containing ready for lazyloading
 */
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
add_filter('the_content', 'baseplate_lazyload_content_images', 11);

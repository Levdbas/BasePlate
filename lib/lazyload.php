<?php

namespace BasePlate;

/**
 * Based on wp_get_attachment_image() but now lazyload ready.
 * @since 1.1
 * @param  int     $attachment_id Image attachment ID.
 * @param  string  $size          Image size.
 * @param  boolean $icon          Whether the image should be treated as an icon.
 * @param  string  $attr          Attributes for the image markup
 * @return string                 HTML img element or empty string on failure.
 */
function lazyload_img($attachment_id, $size = 'large', $icon = false, $attr = '')
{
    $image = '';
    $image = wp_get_attachment_image($attachment_id, $size, $icon, $attr);

    if (!is_admin()) :
        $image = str_replace('src=', 'data-src=', $image);
        $image = str_replace('srcset=', 'data-srcset=', $image);
        $image = str_replace('class="', 'class="lazyload ', $image);
    endif;

    return $image;
}

/**
 * Based on wp_get_attachment_image_src() but now with lazyload background functionallity.
 * Used as follows, <div class="lazyload" <?php echo bp_lazyload_bg_img($image_id, $size); ?>></div>
 * @since
 * @param  int    $image_id Image attachment ID.
 * @param  string $size     Image size.
 * @return string           HTML attr for lazyloading a background image. Do not forget to set the class .lazyload as well.
 */
function lazyload_bg_img($image_id, $size = 'large')
{
    $image = '';
    $image = wp_get_attachment_image_src($image_id, $size);
    if (!is_admin()) :
        $image = $image[0];
        $image = 'data-bg="url(' . $image . ')"';
    endif;
    return $image;
}

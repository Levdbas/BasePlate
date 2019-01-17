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
    $image = '';
    $image = wp_get_attachment_image($attachment_id, $size, $icon, $attr);

    if (!is_admin()):
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
function bp_lazyload_bg_img($image_id, $size = 'large')
{
    $image = '';
    $image = wp_get_attachment_image_src($image_id, $size);
    if (!is_admin()):
        $image = $image[0];
        $image = 'data-bg="url(' . $image . ')"';
    endif;
    return $image;
}

/**
 * replace src with data-src and add lazyload class
 * @since
 * @param  string $content content passed by the_content()
 * @return [type]          returns the_content with images now containing ready for lazyloading
 */
function bp_lazyload_content($content)
{
    if (empty($content)) {
        return $content;
    }
    //$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($content);
    libxml_clear_errors();

    $content = $dom->saveHTML();

    $images = [];
    $background_images = [];
    $iframes = [];
    $videos = [];

    foreach ($dom->getElementsByTagName('img') as $node) {
        $images[] = $node;
    }

    foreach ($dom->getElementsByTagName('div') as $node) {
        if ($node->hasAttribute('style')) {
            $background_images[] = $node;
        }
    }

    foreach ($dom->getElementsByTagName('iframe') as $node) {
        $iframes[] = $node;
    }

    foreach ($dom->getElementsByTagName('video') as $node) {
        $videos[] = $node;
    }

    foreach ($images as $node) {
        $fallback = $node->cloneNode(true);

        if ($node->hasAttribute('sizes') && $node->hasAttribute('srcset')) {
            $sizes_attr = $node->getAttribute('sizes');
            $srcset = $node->getAttribute('srcset');
            $node->setAttribute('data-sizes', $sizes_attr);
            $node->setAttribute('data-srcset', $srcset);
            $node->removeAttribute('sizes');
            $node->removeAttribute('srcset');
            $node->removeAttribute('src');
            $src = $node->getAttribute('src');
        } else {
            $src = $node->getAttribute('src');
            $node->setAttribute('data-src', $src);
            $node->removeAttribute('src');
        }

        bp_lazyload_content_attr($dom, $node, $fallback);
    }
    // Convert iframs

    foreach ($iframes as $node) {
        $fallback = $node->cloneNode(true);
        $oldsrc = $node->getAttribute('src');
        $node->setAttribute('data-src', $oldsrc);
        $newsrc = '';
        $node->setAttribute('src', $newsrc);
        bp_lazyload_content_attr($dom, $node, $fallback);
    }

    foreach ($videos as $node) {
        $fallback = $node->cloneNode(true);
        $oldsrc = $node->getAttribute('src');
        $node->setAttribute('data-src', $oldsrc);
        $newsrc = '';
        $node->setAttribute('src', $newsrc);
        bp_lazyload_content_attr($dom, $node, $fallback);
    }

    foreach ($background_images as $node) {
        $fallback = $node->cloneNode(true);

        $element_style = $node->getAttribute('style');
        preg_match('/background-image:url\((.*?)\)(.*?)/i', $element_style, $matches);
        $node->setAttribute('data-bg', 'url(' . $matches[1] . ')');

        bp_lazyload_content_attr($dom, $node, $fallback);
    }

    $newHtml = $dom->saveHTML();
    return $newHtml;
}
add_filter('the_content', 'bp_lazyload_content', 11);

function bp_lazyload_content_attr($dom, $node, $fallback)
{
    $classes = $node->getAttribute('class');
    $newclasses = $classes . ' lazyload';
    $node->setAttribute('class', $newclasses);
    $noscript = $dom->createElement('noscript', '');
    $node->parentNode->insertBefore($noscript, $node);
    $noscript->appendChild($fallback);
}

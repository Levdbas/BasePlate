<?php
function get_asset($asset)
{
    // Look for the manifest file.
    $manifest = (__DIR__ . '/../dist/manifest.json');
    if (file_exists($manifest)) {
        $manifest = file_get_contents($manifest);
        $json     = json_decode($manifest, true);
        $file     = $json[$asset];
        $file     = get_template_directory_uri() . '/dist/' . $file;
        return $file;
    } else {
        wp_die(__('Draai webpack voor de eerste keer om de manifest file te genereren', 'BasePlate'));
    }
}

function the_asset($asset)
{
    echo get_asset($asset);
}


add_action('wp_head', 'critical_styles_in_header');
function critical_styles_in_header()
{
    echo '<style>';
    include get_stylesheet_directory() . '/dist/styles/critical.php';
    echo '</style>';
}

function scripts_in_footer()
{
    wp_deregister_script('jquery');
    wp_enqueue_style('BasePlate/css', get_asset('app.css'));
    wp_enqueue_script('BasePlate/js', get_asset('app.js'), false, false);
    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'scripts_in_footer', 100);


function baseplate_lazyload_image($attachment_id, $size = 'thumbnail', $icon = false, $attr = '')
{
    $html = '';
    $html = wp_get_attachment_image($attachment_id, $size = 'thumbnail', $icon = false, $attr = '');
    $html = str_replace('src=', 'data-src=', $html);
    $html = str_replace('srcset=', 'data-srcset=', $html);
    $html = str_replace('class="', 'class="lazyload ', $html);
    return $html;
}

function baseplate_lazyload_bg_image($image_id, $size = 'large')
{
    $html       = '';
    $term_image = wp_get_attachment_image_src($image_id, $size);
    $term_image = $term_image[0];
    $html       = 'data-background-image="' . $term_image . '"';
    return $html;
}

add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
function add_async_attribute($tag, $handle)
{
    // add script handles to the array below
    $scripts_to_async = array(
        'BasePlate/js'
    );

    foreach ($scripts_to_async as $async_script) {
        if ($async_script === $handle) {
            return str_replace(' src', ' async="async" src', $tag);
        }
    }
    return $tag;
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
?>

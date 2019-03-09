<?php

/**
 * Initize the sidebars.
 * @since
 * @return [type] [description]
 */
function widgets_init()
{
    register_sidebar([
        'name' => __('Primary', 'BasePlate'),
        'id' => 'sidebar-primary',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ]);

    register_sidebar([
        'name' => __('Footer', 'BasePlate'),
        'id' => 'sidebar-footer',
        'description' => __('Add widgets here to appear in your footer.', 'BasePlate'),
        'before_widget' => '<section id="%1$s" class="widget col-6 col-md-4 col-lg %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ]);
}
add_action('widgets_init', 'widgets_init');

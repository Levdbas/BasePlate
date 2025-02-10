<?php

/**
 * Custom post type file
 *
 * @package WordPress
 * @subpackage WP_Lemon\Child
 */

namespace WP_Lemon\Child\Models;

/**
 * Example post type
 *
 * @return void
 */
function cpt_example()
{
	$single_name = _x('Example', 'Post Type General Name', 'baseplate');
	$plural_name = _x('Examples', 'Post Type Singular Name', 'baseplate');

	$labels = [
		'name'                  => $plural_name,
		'singular_name'         => $single_name,
		'all_items'             => sprintf(__('All %s', 'baseplate'), strtolower($plural_name)),
		'add_new_item'          => sprintf(__('Add new %s', 'baseplate'), strtolower($single_name)),
		'add_new'               => sprintf(__('Add new %s', 'baseplate'), strtolower($single_name)),
		'new_item'              => sprintf(__('New %s', 'baseplate'), strtolower($single_name)),
		'edit_item'             => sprintf(__('Edit %s', 'baseplate'), strtolower($single_name)),
		'update_item'           => sprintf(__('Update %s', 'baseplate'), strtolower($single_name)),
		'view_item'             => sprintf(__('View %s', 'baseplate'), strtolower($single_name)),
	];

	$args = [
		'labels'                 => $labels,
		'supports'               => ['title', 'editor', 'thumbnail'],
		'taxonomies'             => ['category'],
		'hierarchical'           => false,
		'public'                 => true,
		'show_ui'                => true,
		'show_in_menu'           => true,
		'menu_position'          => 5,
		'rewrite'                => ['slug' => 'example'],
		'menu_icon'              => 'dashicons-businessperson',
		'show_in_admin_bar'      => true,
		'show_in_nav_menus'      => true,
		'show_in_rest'           => true,
		'can_export'             => true,
		'has_archive'            => false,
		'exclude_from_search'    => false,
		'publicly_queryable'     => true,
		'capability_type'        => 'page',
		'maybe_has_archive_page' => true,
		'enable_overview_block'  => true,
		'enable_latest_block'    => true,
	];
	register_post_type('example', $args); // unique singular post type name.
}
// add_action('init', __NAMESPACE__ . '\\cpt_example', 0);

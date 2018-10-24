<?php

function baseplate_register_blocks(){

	if( function_exists('acf_register_block') ) {

		// register a testimonial block
		acf_register_block(array(
			'name'				=> 'tabs',
			'title'				=> __('Tabbed content'),
			'description'		=> __('Tabbed content'),
			'render_callback'	=> 'baseplate_acf_bock_render_callback',
			'category'			=> 'formatting',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'tabs', 'tab' ),
		));

	}
	/**
	 * Function that matches the block file to the above defined acf_blocks
	 * @param  [type] $block [description]
	 * @return [type]        [description]
	 */
	function baseplate_acf_bock_render_callback( $block ) {

		// convert name ("acf/testimonial") into path friendly slug ("testimonial")
		$slug = str_replace('acf/', '', $block['name']);
		// include a template part from within the "partials/block" folder
		//
    if( file_exists(get_stylesheet_directory() . "/partials/blocks/block-{$slug}.php") ) {
			include( get_stylesheet_directory() . "/partials/blocks/block-{$slug}.php" );
		}
	}
}
?>

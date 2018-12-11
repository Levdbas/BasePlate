<?php
/**
 * Block Name: Example block
 *
 * This is the template that displays the testimonial block.
 */
?>
<div id="<?php echo bp_acf_block_attr('id', $block); ?>" class='<?php bp_block_classes($block); ?>'>
  <?php the_field('block_title'); ?>
</div>

<style type="text/css">
	#<?php echo bp_acf_block_attr('id', $block); ?> {
		background: <?php the_field('block_bg_color'); ?>;
		color: <?php the_field('text_color'); ?>;
	}
</style>

<?php
/**
 * Block Name: Testimonial
 *
 * This is the template that displays the testimonial block.
 */

// get image field (array)

// create id attribute for specific styling

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : ''; ?>
<section id="<?php echo get_baseplate_acf_block_att('id', $block); ?>" class='tabbed-content <?php echo $align_class; ?>'>
  <?php the_field('block_title'); ?>
</section>





<style type="text/css">
	#<?php echo get_baseplate_acf_block_att('id', $block); ?> {
		background: <?php the_field('block_bg_color'); ?>;
		color: <?php the_field('text_color'); ?>;
	}
</style>

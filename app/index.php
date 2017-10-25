<?php get_header(); ?>
<div class="wrap">
  <div class="holder row">
    <div  class="col-sm-10 col-xs-offset-1 col-xs-10">
      <div id="intro" class="row">
        <div class="col-sm-10">
          <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
              <h1><?php the_title(); ?></h1>
              <?php the_content(); ?>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div><!-- /intro -->
    </div><!-- /col -->
  </div><!--/holder -->
</div><!-- /wrap -->
<?php get_footer(); ?>

<?php get_header(); ?>
<div class="wrap">
  <div id="slider-holder" class="row">
    <div class="col-sm-12">
      <div id="slider">
        <?php
        if ( have_posts() ) {
          while ( have_posts() ) {
            the_post();
            ?>
          </div>
        </div>
      </div>
      <div class="holder row">
        <div  class="col-sm-10 col-xs-offset-1 col-xs-10">
          <div id="intro" class="row">
            <div class="col-sm-10">
              <h1><?php the_title(); ?></h1>
              <?php the_content(); ?>
              <?php
            } // end while
          } // end if
          ?>
        </div>
      </div><!-- /intro -->
    </div><!-- /col -->
  </div><!--/holder -->
</div><!-- /wrap -->
<?php get_footer(); ?>

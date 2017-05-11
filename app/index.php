<?php get_header(); ?>
<div class="col-12 col-sm-12 col-md-12 col-lg-8">
        <div class="area">
              <?php
              if ( have_posts() ) {
                while ( have_posts() ) {
                  the_post();
                  ?>
              <h1><?php the_title(); ?></h1>
              <?php the_content(); ?>
              <?php
            } // end while
          } // end if
          ?>
        </div>
      </div>
<?php get_footer(); ?>

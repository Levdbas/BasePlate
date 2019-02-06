<?php get_header(); ?>
<main class="main">
  <div class="container">
    <?php if (have_posts()): ?>
      <?php while (have_posts()):
          the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
      <?php
      endwhile; ?>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>

<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
get_header(); ?>
<main class="main">
  <div class="container">
    <?php if (have_posts()): ?>
      <?php while (have_posts()):
          the_post(); ?>
        <article class="content">
          <header>
            <h1><?php the_title(); ?></h1>
          </header>
          <div class="content__entry">
            <?php the_content(); ?>
          </div>
        </article>
        <?php
      endwhile; ?>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>

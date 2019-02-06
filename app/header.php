<?php get_template_part('partials/header-top'); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home_url" title="<?php bloginfo('name'); ?>">
      <img itemprop="logo" alt="Logo <?php bloginfo('name'); ?>" src="<?php the_asset('images/logo.svg'); ?>">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="<?php _e('Toggle navigation', 'baseplate'); ?>">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
      <?php wp_nav_menu(array(
          'theme_location' => 'primary_navigation',
          'depth' => 3,
          'container' => false,
          'menu_class' => 'navbar-nav mr-auto mt-2 mt-lg-0"',
          'fallback_cb' => 'bs4navwalker::fallback',
          'walker' => new bs4navwalker()
      )); ?>
      <div class="my-2 my-lg-0">
        icons
      </div>
    </div>
  </div>
</nav>

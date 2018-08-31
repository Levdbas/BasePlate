<?php get_template_part( 'partials/header-top'); ?>
<header class="header" role="menubar">
  <div class="logo">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
      <?php /* NOTE: you can load images and other assets from the dist dir by: the_asset('images/logo.svg') */ ?>
      <img alt="Logo <?php bloginfo( 'name' ); ?>" src="<?php //the_asset('images/logo.svg'); ?>">
    </a>
  </div>
  <?php get_template_part( 'partials/header-nav' ); ?>
</header>
<h1>test</h1>

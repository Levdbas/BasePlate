<?php get_template_part( 'partials/header-top'); ?>
<header class="header" role="menubar">
  <div class="logo">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>">
      <?php /* NOTE: you can load images from the dist/images dir by: <?php echo assetBase('images'); ?>/name.extention */ ?>
      <img alt="Logo <?php bloginfo( 'name' ); ?>" src="<?php //the_asset('images/logo.svg'); ?>">
    </a>
  </div>
  <?php get_template_part( 'partials/header-nav' ); ?>
</header>

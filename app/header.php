<header class="header" role="menubar">
  <div class="logo">
      <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>">
      <img alt="Logo <?php bloginfo( 'name' ); ?>" src="<?php //the_asset('images/logo.svg'); ?>">
    </a>
  </div>
  <?php get_template_part( 'partials/header', 'nav' ); ?>
</header>

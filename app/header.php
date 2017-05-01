<?php include_once(dirname(__FILE__) . '/partials/head.php'); ?>
<div class="wrap head">
  <div class="row">
    <div  class="col-12 col-sm-10 col-xs-offset-1">
      <header id="header" class="row">
        <div id="logo" class="col-sm-3 col-xs-12">
          <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>">
            <img alt="Logo <?php bloginfo( 'name' ); ?>" src="<?php bloginfo( 'template_url' ) ?>/dist/images/logo.png">
          </a>
        </div>
        <div id="menu-holder" class="row">
          <?php include_once(dirname(__FILE__) . '/partials/nav.php'); ?>
        </div><!-- /row-->
        <div class="clearfix visible-xs-block"></div>
      </header>
    </div><!-- / col -->
  </div><!-- /row -->
</div><!-- headwrap -->

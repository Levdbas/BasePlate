<?php include_once(dirname(__FILE__) . '/templates/head.php'); ?>
<div class="wrap head">
  <div class="row">
    <div  class="col-sm-10 col-xs-offset-1">
      <header id="header" class="row">
        <div id="logo" class="col-sm-3 col-xs-12">
          <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>">
            <img src="<?php bloginfo( 'template_url' ) ?>/dist/images/logo.png">
          </a>
        </div>
        <div id="menu-holder" class="row">
          <?php include_once(dirname(__FILE__) . '/templates/nav.php'); ?>
        </div><!-- /row-->
        <div class="clearfix visible-xs-block"></div>
      </header>
    </div><!-- / col -->
  </div><!-- /row -->
</div><!-- headwrap -->

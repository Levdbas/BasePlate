<nav class="navbar navbar-toggleable-sm navbar-light bg-faded" role="navigation">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navigationbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navigationbar">
    <?php
    wp_nav_menu( array(
      'theme_location' => 'primary_navigation',
      'depth' => 3,
      'container' => false,
      'menu_class' => 'nav navbar-nav',
      //Process nav menu using our custom nav walker
      'walker' => new wp_bootstrap_navwalker())
    );
    ?>
  </div>
</nav>

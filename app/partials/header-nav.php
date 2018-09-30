<nav class="navbar navbar-expand-lg navbar-light bg-faded">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigationbar" aria-controls="navigationbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navigationbar">
    <?php
    wp_nav_menu(array(
      'theme_location' => 'primary_navigation',
      'depth' => 3,
      'container' => false,
      'menu_class' => 'navbar-nav mr-auto',
      'fallback_cb'     => 'bs4navwalker::fallback',
      'walker'          => new bs4navwalker()
    ));
    ?>
  </div>
</nav>

<footer class="footer" role="footer">

  <?php if (is_active_sidebar('sidebar-footer')) { ?>
    <aside class="footer-widgets" role="complementary" aria-label="<?php esc_attr_e('Footer', 'baseplate'); ?>">
      <div class="container">
        <div class="row">
          <?php dynamic_sidebar('sidebar-footer'); ?>
        </div>

      </div>
    </aside><!-- .widget-area -->
  <?php } ?>

  <div class="site-info">
    <div class="container">
      <div class="row">
        <div class="col">
          Copyright &copy; <?php echo date('Y'); ?>
        </div>
        <div class="col">
          <?php if (has_nav_menu('footer_navigation')): ?>
            <nav class="footer-navigation" aria-label="<?php esc_attr_e('Footer Menu', 'baseplate'); ?>">
              <?php wp_nav_menu(array(
                  'theme_location' => 'footer_navigation',
                  'menu_class' => 'footer-menu nav',
                  'depth' => 1
              )); ?>
            </nav>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

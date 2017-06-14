<!doctype html>
<html class="no-js" lang="">
<head>
  <meta charset="<?php bloginfo( 'charset' ) ?>">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php bloginfo('name'); ?> | <?php the_title(); ?></title>
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="<?php echo assetBase('images'); ?>/apple-touch-icon.png">
  <!-- Place favicon.ico in the root directory -->
  <?php wp_head(); ?>
  <?php get_template_part( 'partials/header', 'analytics' ); ?>
  <?php $pagetitle = strtolower(get_the_title()); ?>
</head>
<body <?php body_class($pagetitle); ?>>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<?php

/**
 * The main template file
 *
 * @since 2.0.0
 */
$context = Timber::get_context();
$context['posts'] = new Timber\PostQuery();
Timber::render('templates/index.twig', $context);

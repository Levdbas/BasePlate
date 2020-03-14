<?php

/**
 * The 404 template file
 *
 * @since 2.0.0
 */
$context = Timber\Timber::get_context();
$context['posts'] = new Timber\PostQuery();
Timber\Timber::render('404.twig', $context);

<?php

add_action( 'wp_enqueue_scripts', 'association_child_enqueue_styles' );

function onepress_child_enqueue_styles() {

  $parent_style = 'association-style';

  wp_enqueue_style( $parent_style,
    get_template_directory_uri() . 'style.css'
  );

  // prettyPhoto css
	wp_enqueue_style( 'prettyPhoto',
    get_template_directory_uri() .	'/styles/prettyPhoto.css'
  );

	// Font Awesome css
	wp_enqueue_style( 'font-awesome',
    get_template_directory_uri() .
    '/styles/font-awesome.min.css'
  );

  // Local style
  wp_enqueue_style(
    'association-child-style',
    get_stylesheet_directory_uri() . '/style.css'
  );

}

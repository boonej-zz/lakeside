<?php
/*
 *Template Name: Blank
 *
 * @package Hestia Child
 */

$mp_image_dir = get_stylesheet_directory_uri() . '/assets/images/';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <div class="blank">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content-fullwidth', 'page' );
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endwhile;
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>
  </div>
   
<?php get_footer(); ?>

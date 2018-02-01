<?php
if ( !$is_callback ) { ?>
  <div class="hestia-bottom-footer-content">
<?php }
	$hestia_copyright_alignment = get_theme_mod(
    'hestia_copyright_alignment',
    'right'
  );

	$menu_class                 = 'pull-left';
	$copyright_class            = 'pull-right';

	switch ( $hestia_copyright_alignment ) {

		case 'left':
			$menu_class      = 'pull-right';
			$copyright_class = 'pull-left';
			break;
		case 'center':
			$menu_class      = 'hestia-center';
			$copyright_class = 'hestia-center';

	}
?>
<div class="hestia-bottom-footer-content">
<?php
  $menu_class = 'pull-left';
  wp_nav_menu(
  	array(
  		'theme_location' => 'footer',
  		'depth'          => 1,
  		'container'      => 'ul',
  		'menu_class'     => 'footer-menu ' . esc_attr( $menu_class ),
  	)
  );
?>

  <div class="copyright <?php echo esc_attr( $copyright_class ); ?>">
  	&copy; 2018 Lakeside Subdivision
  </div>
</div>

<?php if ( !$is_callback ) { ?>
</div>
<?php } ?>

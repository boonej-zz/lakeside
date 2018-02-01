<?php
add_action( 'wp_enqueue_scripts', 'moc_enqueue_styles' );
add_action( 'login_enqueue_scripts', 'moc_login_logo' );

add_filter( 'login_headerurl', 'moc_login_headerurl' );
add_filter( 'login_headertitle', 'moc_login_headertitle' );

if ( !current_user_can( 'administrator' ) ) {

  wp_deregister_script( 'admin-bar' );
  wp_deregister_style( 'admin-bar' );

  remove_action( 'admin_init', '_wp_admin_bar_init' );
  remove_action( 'in_admin_header', 'wp_admin_bar_render', 0 );
  add_action( 'admin_enqueue_scripts', 'moc_admin_filter' );
  add_action( 'wp_dashboard_setup', 'moc_remove_meta_boxes' );


}

function moc_enqueue_styles() {

    wp_enqueue_style(
      'bootstrap',
      get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css',
      array(),
      HESTIA_VENDOR_VERSION
    );

  	wp_style_add_data(
      'bootstrap',
      'rtl',
      'replace'
    );

  	wp_style_add_data( 'bootstrap', 'suffix', '.min' );

    wp_enqueue_style(
      'font-awesome',
      get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css',
      array(),
      HESTIA_VENDOR_VERSION
    );

    wp_enqueue_style(
      'hestia',
      get_template_directory_uri() . '/style.css'
    );

  	$hestia_headings_font = get_theme_mod( 'hestia_headings_font' );
  	$hestia_body_font = get_theme_mod( 'hestia_body_font' );

  	if ( empty( $hestia_headings_font ) || empty( $hestia_body_font ) ) {

  		wp_enqueue_style(
        'hestia_fonts',
        hestia_fonts_url(),
        array(),
        HESTIA_VERSION
      );

    }

    wp_enqueue_style(
      'lakeside',
      get_stylesheet_directory_uri() . '/style.css'
    );

}

function moc_login_logo() {

  include( get_stylesheet_directory() . '/includes/login-styles.php' );

}

function hesta_bottom_footer_content( $is_callback = false ) {

  include( get_stylesheet_directory() . '/includes/copyright.php' );

}

function moc_login_headerurl() {

  return 'https://www.lakesidesubdivision.com';

}

function moc_login_headertitle() {

  return 'Lakeside Subdivision';

}

function moc_admin_filter() {

  wp_enqueue_script(
    'admin_filter_script',
    get_stylesheet_directory_uri() . '/assets/js/admin-filter.js'
  );

}

function moc_remove_meta_boxes() {

  global $wp_meta_boxes;
  unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );

}

?>

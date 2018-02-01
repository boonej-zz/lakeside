<?php
/*
Plugin Name: Subdvision Shortcodes
Plugin URI: https://github.com/boonej/subdivision-shortcodes
Description: Adds shortcodes for subdivision websites.
Version: 1.0.0
Author: Jonathan Boone <jeboone@gmail.com>
License: GPL2
*/

if ( ! defined( 'WPINC' ) ) {
  die;
}

define( 'SUBDIVISION_VERSION', '1.0.0' );


require plugin_dir_path( __FILE__ ) . 'includes/class-subdivision.php';

function run_subdivision() {
  $subdivision = new Subdivision();
  $subdivision->run();
}

run_subdivision();

?>

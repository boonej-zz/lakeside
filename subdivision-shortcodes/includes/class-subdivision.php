<?php
/**
 * @since      1.0.0
 *
 * @package    Subdivision
 * @subpackage Subdivision/includes
 */

 class Subdivision {

  protected $updater;
  protected $plugin_name;
  protected $version;

  public function __construct() {

    if ( defined( 'SUBDIVISION_VERSION' ) ) {
      $this->version = SUBDIVISION_VERSION;
    } else {
      $this->version = '1.0.0';
    }

    $this->plugin_name = 'subdivision-shortcodes';
    $this->load_dependencies();

  }

  private function load_dependencies() {

    require_once plugin_dir_path( dirname( __FILE__ ) ) .
      'includes/class-plugin-updater.php';
    $this->updater = new PluginUpdater(
      plugin_dir_path( dirname( __FILE__ ) ) . 'subdivision.php',
      'boonej',
      'subdivision-shortcodes'
    );

  }

  public function shortcode_row( $atts, $content ) {

    ob_start();
    include( plugin_dir_path( dirname( __FILE__ ) ) .
        'includes/templates/snippet-row.php' );
    $data = ob_get_clean();
    return $data;

  }

  public function enqueue_styles() {

    wp_register_style( 'subdivision-style',
      plugin_dir_url( dirname( __FILE__ ) ) .
      'assets/css/style.css' );
    wp_enqueue_style( 'subdivision-style' );

  }

  public function shortcode_content_box( $atts = [], $content = null ) {

    $atts = array_change_key_case( ( array )$atts, CASE_LOWER );
    $button_link = $atts['lurl'];
    $button_text = $atts['ltext'];
    $snippet_title = $atts['title'];

    ob_start();
    include( plugin_dir_path( dirname( __FILE__ ) ) .
        'includes/templates/snippet-box.php' );
    $data = ob_get_clean();
    return $data;

  }

  public function run() {

    $this->enqueue_styles();
    add_shortcode('s-row', array( $this, shortcode_row ) );
    add_shortcode('s-box', array( $this, shortcode_content_box ) );

  }

  public function get_plugin_name() {
    return $this->plugin_name;
  }

  public function get_version() {
    return $this->version;
  }



 }

 ?>

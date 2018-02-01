<?php

class PluginUpdater {

  private $slug;
  private $plugin_data;
  private $username;
  private $repo;
  private $plugin_file;
  private $github_result;
  private $access_token;
  private $plugin_activated;

  function __construct( $plugin_file, $username, $repo, $access_token = '' ) {

    $this->plugin_file = $plugin_file;
    $this->username = $username;
    $this->repo = $repo;
    $this->access_token = $access_token;

  }

  public function activate_filters() {

    add_filter(
      'pre_set_site_transient_update_plugins',
      array( $this, 'set_transient')
    );
    add_filter(
      'plugins_api', array( $this, 'set_plugin_info' ), 10, 3
    );
    add_filter(
      'upgrader_pre_install', array( $this, 'pre_install', 10, 3 )
    );
    add_filter(
      'upgrader_post_install', array( $this, 'post_install' ), 10, 3
    );

  }

  private function init_plugin_data() {

    $this->slug = plugin_basename( $this->plugin_file );
    $this->plugin_data = get_plugin_data( $this->plugin_file );

  }

  private function append_token( $path ) {

    $url = $path;
    if ( ! empty( $this->access_token ) ) {
      $url = add_query_arg(
        array( 'access_token' => $this->access_token ),
        $url 
      );
    }
    return $url;

  }

  private function get_repo_release_info() {

    if ( ! empty( $this->github_result ) ) {
      return;
    }

    $url =
      "https://api.github.com/repos/{$this->username}/{$this->repo}/releases";


    $url = $this->append_token( $url );

    $this->github_result = wp_remote_retrieve_body( wp_remote_get( $url ) );
    $this->github_result = @json_decode( $this->github_result );

    if ( is_array( $this->github_result ) ) {
      $this->github_result = $this->github_result[0];
    }

  }

  public function set_transient( $transient ) {

    if ( empty( $transient->checked ) ) {
      return $transient;
    }

    $this->init_plugin_data();
    $this->get_repo_release_info();
    $version = $transient->checked[$this->slug];
    $do_update = version_compare( $this->github_result->tag_name,
      $version );

    if ( $do_update == 1 ) {
      $package = $this->append_token( $this->github_result->zipball_url );
      $obj = new stdClass();
      $obj->slug = $this->slug;
      $obj->new_version = $this->github_result->tag_name;
      $obj->url = $this->plugin_data['PluginURI'];
      $obj->package = $package;
      $transient->response[$this->slug] = $obj;
    }

    return $transient;

  }

  public function set_plugin_info( $false, $action, $response ) {

    $this->init_plugin_data();
    $this->get_repo_release_info();

    if ( empty( $response->slug ) || $response->slug != $this->slug ) {
      return $false;
    }

    $response->last_updated = $this->github_result->published_at;
    $response->slug = $this->slug;
    $response->plugin_name  = $this->plugin_data['Name'];
    $response->version = $this->github_result->tag_name;
    $response->author = $this->plugin_data['AuthorName'];
    $response->homepage = $this->plugin_data['PluginURI'];
    $download_link = $this->append_token( $this->github_result->zipball_url );
    $response->download_link = $download_link;

    $response->sections = array(
      'description' => $this->plugin_data['Description'],
      'changelog' => $this->github_result->body
    );

    $matches = null;
    preg_match( "/tested:\s([\d\.]+)/i", $this->github_result->body, $matches );

    if ( ! empty( $matches ) ) {
      if ( is_array( $matches) ) {
        if ( count( $matches ) > 1 ) {
          $response->tested = $matches[1];
        }
      }
    }

    return $response;
  }

  public function pre_install( $true, $args ) {
    $this->init_plugin_data();
    $this->plugin_activated = is_plugin_active( $this->slug );
  }

  public function post_install( $true, $hook_extra, $result ) {

    global $wp_filesystem;

    $plugin_folder = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR .
      dirname( $this->slug );
    $wp_filesystem->move( $result['destination'], $plugin_folder );
    $result['destination'] = $plugin_folder;

    if ( $this->plugin_activated ) {
      $activate = activate_plugin( $this->slug );
    }

    return $result;
  }
}
?>

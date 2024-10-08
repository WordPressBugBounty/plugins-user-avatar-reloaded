<?php
/*
Plugin Name: WP User Avatar - Reloaded
Plugin URI: http://wordpress.org/plugins/wp-user-avatar-reloaded
Description: WP User Avatar enables you to use any photo uploaded into your Media Library as an avatar. This means you use the same uploader and library as your posts. No extra folders or image editing functions are necessar
Author: saadiqbal
Author URI: https://profiles.wordpress.org/saadiqbal/
Version: 1.2.2
Text Domain: wp-user-avatar
Domain Path: /lang/
*/

if(!defined('ABSPATH')) {
  die('You are not allowed to call this page directly.');
}

/**
 * Let's get started!
 */
class WPUA_WP_User_Avatar_Setup {
  /**
   * Constructor
   * @since 1.9.2
   */
  public function __construct() {
    $this->_define_constants();
    $this->_load_wp_includes();
    $this->_load_wpua();
  }

  /**
   * Define paths
   * @since 1.9.2
   */
  private function _define_constants() {
    define('WPUA_VERSION', '1.2.2');
    define('WPUA_FOLDER', basename(dirname(__FILE__)));
    define('WPUA_DIR', plugin_dir_path(__FILE__));
    define('WPUA_INC', WPUA_DIR.'includes'.'/');
    define('WPUA_URL', plugin_dir_url(WPUA_FOLDER).WPUA_FOLDER.'/');
    define('WPUA_INC_URL', WPUA_URL.'includes'.'/');
  }

  /**
   * WordPress includes used in plugin
   * @since 1.9.2
   * @uses is_admin()
   */
  private function _load_wp_includes() {
    if(!is_admin()) {
      // wp_handle_upload
      require_once(ABSPATH.'wp-admin/includes/file.php');
      // wp_generate_attachment_metadata
      require_once(ABSPATH.'wp-admin/includes/image.php');
      // image_add_caption
      require_once(ABSPATH.'wp-admin/includes/media.php');
      // submit_button
      require_once(ABSPATH.'wp-admin/includes/template.php');
    }
    // add_screen_option
    require_once(ABSPATH.'wp-admin/includes/screen.php');
  }

  /**
   * Load WP User Avatar
   * @since 1.9.2
   * @uses bool $wpua_tinymce
   * @uses is_admin()
   */
  private function _load_wpua() {
    global $wpua_tinymce;
    require_once(WPUA_INC.'wpua-globals.php');
    require_once(WPUA_INC.'wpua-functions.php');
    require_once(WPUA_INC.'class-wp-user-avatar-admin.php');
    require_once(WPUA_INC.'class-wp-user-avatar.php');
    require_once(WPUA_INC.'class-wp-user-avatar-functions.php');
    require_once(WPUA_INC.'class-wp-user-avatar-shortcode.php');
    require_once(WPUA_INC.'class-wp-user-avatar-subscriber.php');
    require_once(WPUA_INC.'class-wp-user-avatar-update.php');
    require_once(WPUA_INC.'class-wp-user-avatar-widget.php');
    require_once(WPUA_INC.'mo-notice.php');
    
    // Load TinyMCE only if enabled
    if((bool) $wpua_tinymce == 1) {
      require_once(WPUA_INC.'wpua-tinymce.php');
    }

  }
}

/**
 * Initialize
 */
new WPUA_WP_User_Avatar_Setup();

<?php
/**
 * Plugin Name: MyCasa Custom Elementor
 * Plugin URI:  https://dev-mycasa.pantheonsite.io/
 * Description: Create custom Elementor components
 * Version:     1.0
 * Author:      MyCasa
 * Author URI:  https://dev-mycasa.pantheonsite.io/
 * License:     GPL-2.0+
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

define( 'MYCASA_ELEMENTOR_PLUGIN_PATH', '/wp-content/plugins/mycasa-elementor' );

/**
 * Main Mycasa Elementor Class
 *
 * The init class that runs the Mycasa Elementor plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 *
 * @since 1.0.0
 */
final class Mycasa_Elementor {

  /**
   * Plugin Version
   *
   * @since 1.0.0
   * @var string The plugin version.
   */
  const VERSION = '1.0.0';

  /**
   * Minimum Elementor Version
   *
   * @since 1.0.0
   * @var string Minimum Elementor version required to run the plugin.
   */
  const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

  /**
   * Minimum PHP Version
   *
   * @since 1.0.0
   * @var string Minimum PHP version required to run the plugin.
   */
  const MINIMUM_PHP_VERSION = '7.0';

  /**
   * Instance
   *
   * Ensures only one instance of the class is loaded or can be loaded.
   *
   * @since 1.0.0
   *
   * @access public
   * @static
   *
   * @return Elementor_Test_Extension An instance of the class.
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  /**
   * Constructor
   *
   * @since 1.0.0
   * @access public
   */
  public function __construct() {
    // Load translation
    add_action( 'init', [ $this, 'i18n' ] );

    // Init Plugin
    add_action( 'plugins_loaded', [ $this, 'init' ] );
  }

  /**
   * Load Textdomain
   *
   * Load plugin localization files.
   * Fired by `init` action hook.
   *
   * @since 1.2.0
   * @access public
   */
  public function i18n() {
    load_plugin_textdomain( 'mycasa-elementor' );
  }

  /**
   * Initialize the plugin
   *
   * Validates that Elementor is already loaded.
   * Checks for basic plugin requirements, if one check fail don't continue,
   * if all check have passed include the plugin class.
   *
   * Fired by `plugins_loaded` action hook.
   *
   * @since 1.2.0
   * @access public
   */
  public function init() {
    // Check if Elementor installed and activated
    if ( ! did_action( 'elementor/loaded' ) ) {
      add_action( 'admin_notices', [
        $this,
        'admin_notice_missing_main_plugin',
      ] );

      return;
    }

    // Check for required Elementor version
    if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
      add_action( 'admin_notices', [
        $this,
        'admin_notice_minimum_elementor_version',
      ] );

      return;
    }

    // Check for required PHP version
    if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
      add_action( 'admin_notices', [
        $this,
        'admin_notice_minimum_php_version',
      ] );

      return;
    }

    // Once we get here, We have passed all validation checks so we can safely include our plugin
    require_once( 'plugin.php' );
  }

  /**
   * Admin notice
   *
   * Warning when the site doesn't have Elementor installed or activated.
   *
   * @since 1.0.0
   * @access public
   */
  public function admin_notice_missing_main_plugin() {
    if ( isset( $_GET[ 'activate' ] ) ) {
      unset( $_GET[ 'activate' ] );
    }

    $message = sprintf(
    /* translators: 1: Plugin name 2: Elementor */
      esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'mycasa-elementor' ),
      '<strong>' . esc_html__( 'Mycasa Elementor', 'mycasa-elementor' ) . '</strong>',
      '<strong>' . esc_html__( 'Elementor', 'mycasa-elementor' ) . '</strong>'
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  }

  /**
   * Admin notice
   *
   * Warning when the site doesn't have a minimum required Elementor version.
   *
   * @since 1.0.0
   * @access public
   */
  public function admin_notice_minimum_elementor_version() {
    if ( isset( $_GET[ 'activate' ] ) ) {
      unset( $_GET[ 'activate' ] );
    }

    $message = sprintf(
    /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
      esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'mycasa-elementor' ),
      '<strong>' . esc_html__( 'Mycasa Elementor', 'mycasa-elementor' ) . '</strong>',
      '<strong>' . esc_html__( 'Elementor', 'mycasa-elementor' ) . '</strong>',
      self::MINIMUM_ELEMENTOR_VERSION
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  }

  /**
   * Admin notice
   *
   * Warning when the site doesn't have a minimum required PHP version.
   *
   * @since 1.0.0
   * @access public
   */
  public function admin_notice_minimum_php_version() {
    if ( isset( $_GET[ 'activate' ] ) ) {
      unset( $_GET[ 'activate' ] );
    }

    $message = sprintf(
    /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
      esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'mycasa-elementor' ),
      '<strong>' . esc_html__( 'Mycasa Elementor', 'mycasa-elementor' ) . '</strong>',
      '<strong>' . esc_html__( 'PHP', 'mycasa-elementor' ) . '</strong>',
      self::MINIMUM_PHP_VERSION
    );

    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  }
}

// Instantiate Mycasa_Elementor.
new Mycasa_Elementor();

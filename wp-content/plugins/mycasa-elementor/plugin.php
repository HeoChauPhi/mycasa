<?php

namespace MycasaElementor;

use Elementor\Controls_Manager;

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.0.0
 */
class Plugin {

  /**
   * Instance
   *
   * @since 1.0.0
   * @access private
   * @static
   *
   * @var Plugin The single instance of the class.
   */
  private static $_instance = NULL;

  /**
   * Instance
   *
   * Ensures only one instance of the class is loaded or can be loaded.
   *
   * @since 1.2.0
   * @access public
   *
   * @return Plugin An instance of the class.
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  /**
   * widget_scripts
   *
   * Load required plugin core files.
   *
   * @since 1.2.0
   * @access public
   */
  public function widget_scripts() {
    // wp_register_script( 'mycasa-elementor', plugins_url( '/assets/js/mycasa-elementor-script.js', __FILE__ ), [ 'jquery' ], FALSE, TRUE );
  }

  /**
   * Include Widgets files
   *
   * Load widgets files
   *
   * @since 1.2.0
   * @access private
   */
  private function include_widgets_files() {
    require_once( __DIR__ . '/widgets/project-listing.php' );
    require_once( __DIR__ . '/widgets/number-counter.php' );
    require_once( __DIR__ . '/widgets/multiple-shortcode.php' );
    require_once( __DIR__ . '/widgets/career-listing.php' );
    require_once( __DIR__ . '/widgets/project-banner-search.php' );
  }

  /**
   * Register Widgets
   *
   * Register new Elementor widgets.
   *
   * @since 1.2.0
   * @access public
   */
  public function register_widgets() {
    // Its is now safe to include Widgets files
    $this->include_widgets_files();

    // Register Widgets
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\MycasaProjectListing() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\MycasaNumberCounter() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\MycasaShortcodeMultiple() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\MycasaCareerListing() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\MycasaProjectBannerSearch() );
  }

  /**
   * Add WomenLift category
   *
   * Add new Elementor widgets category.
   *
   * @since 1.2.0
   * @access public
   */
  public function add_elementor_widget_categories( $elements_manager ) {
    $elements_manager->add_category(
      'mycasa-category',
      [
        'title' => __( 'Mycasa', 'mycasa-elementor' ),
        'icon'  => 'fa fa-sliders',
      ]
    );
  }

  /**
   *  Plugin class constructor
   *
   * Register plugin action hooks and filters
   *
   * @since 1.2.0
   * @access public
   */
  public function __construct() {

    // Register widget scripts.
    add_action( 'elementor/frontend/after_register_scripts', [
      $this,
      'widget_scripts',
    ] );

    // Register widgets.
    add_action( 'elementor/widgets/widgets_registered', [
      $this,
      'register_widgets',
    ] );

    // Add new Category.
    add_action( 'elementor/elements/categories_registered', [
      $this,
      'add_elementor_widget_categories',
    ] );
  }
}

// Instantiate Plugin Class
Plugin::instance();
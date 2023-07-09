<?php

namespace MycasaElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
  exit;
} // Exit if accessed directly

/**
 * @since 1.1.0
 */
class MycasaShortcodeMultiple extends Widget_Base {
  public function __construct( $data = [], $args = null ) {
    parent::__construct( $data, $args );

    wp_enqueue_style('mycasa-multiple-shortcode', MYCASA_ELEMENTOR_PLUGIN_PATH . '/css/shortcode-multiple.css', [], '1.1' );
  }

  /**
   * Retrieve the widget name.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'mycasa-shortcode-multiple';
  }

  /**
   * Retrieve the widget title.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __( 'Shortcode Multiple', 'mycasa-elementor' );
  }

  /**
   * Retrieve the widget icon.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'eicon-shortcode';
  }

  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * Used to determine where to display the widget in the editor.
   *
   * Note that currently Elementor supports only one category.
   * When multiple categories passed, Elementor uses the first one.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return array Widget categories.
   */
  public function get_categories() {
    return [ 'mycasa-category' ];
  }

  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize
   * the widget settings.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function _register_controls() {
    /*
     * Title
     */

    // Title Setting
    $this->start_controls_section(
      'section_title',
      [
        'label' => esc_html__( 'Title', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => esc_html__( 'Title', 'mycasa-elementor' ),
        'type' => Controls_Manager::TEXTAREA,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => esc_html__( 'Enter your title', 'mycasa-elementor' ),
        'default' => esc_html__( 'Add Your Heading Text Here', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'title_padding',
      [
        'label' => esc_html__( 'Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'title_margin',
      [
        'label' => esc_html__( 'Margin', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Title typography
    $this->start_controls_section(
      'section_title_style',
      [
        'label' => esc_html__( 'Title', 'mycasa-elementor' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'title_color',
      [
        'label'     => __( 'Text Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-title' => 'color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'title_typography',
        'global' => [
          'default' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        ],
        'selector' => '{{WRAPPER}} .mycasa-elementor-heading-title',
      ]
    );

    $this->end_controls_section();

    /*
     * Sub Title
     */

    // Sub Title Setting
    $this->start_controls_section(
      'section_sub_title',
      [
        'label' => esc_html__( 'Sub Title', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'sub_title',
      [
        'label' => esc_html__( 'Sub Title', 'mycasa-elementor' ),
        'type' => Controls_Manager::TEXTAREA,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => esc_html__( 'Enter your sub title', 'mycasa-elementor' ),
        'default' => esc_html__( 'Add Your Heading Text Here', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'sub_title_padding',
      [
        'label' => esc_html__( 'Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-sub-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'sub_title_margin',
      [
        'label' => esc_html__( 'Margin', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Sub Title typography
    $this->start_controls_section(
      'section_sub_title_style',
      [
        'label' => esc_html__( 'Sub Title', 'mycasa-elementor' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'sub_title_color',
      [
        'label'     => __( 'Text Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-sub-title' => 'color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'sub_title_typography',
        'global' => [
          'default' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        ],
        'selector' => '{{WRAPPER}} .mycasa-elementor-sub-title',
      ]
    );

    $this->end_controls_section();

    /*
     * Multiple Shortcode
     */
    $this->start_controls_section(
      'section_multiple_shortcode',
      [
        'label' => esc_html__( 'Multiple Shortcode', 'mycasa-elementor' ),
      ]
    );

    $repeater = new Repeater();

    $repeater->add_control(
      'shortcode_name',
      [
        'label'   => __('Shortcode Name', 'mycasa-elementor'),
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Shortcode Name', 'mycasa-elementor' ),
        'placeholder' => __( 'Shortcode Name', 'mycasa-elementor' ),
      ]
    );

    $repeater->add_control(
      'multiple_shortcode',
      [
        'label'   => __('Multiple Shortcode', 'mycasa-elementor'),
        'type' => Controls_Manager::TEXTAREA,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => '[shortcode id="123" size="medium"]',
        'default' => '',
      ]
    );

    $this->add_control(
      'multiple_shortcode_list',
      [
        'label' => esc_html__( 'Shortcodes List', 'mycasa-elementor' ),
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [],
        'title_field' => '{{ shortcode_name }}',
      ]
    );

    $this->add_control(
      'multiple_shortcode_padding',
      [
        'label' => esc_html__( 'Item Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .multiple-shortcode-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'multiple_shortcode_margin',
      [
        'label' => esc_html__( 'Item Margin', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .multiple-shortcode-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();
  }

  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function render() {
    $settings = $this->get_settings_for_display();
    include 'templates/multiple-shortcode.php';
  }
}
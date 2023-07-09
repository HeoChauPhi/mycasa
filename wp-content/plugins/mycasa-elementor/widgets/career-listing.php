<?php

namespace MycasaElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use WP_Query;


if ( ! defined( 'ABSPATH' ) ) {
  exit;
} // Exit if accessed directly

/**
 * @since 1.1.0
 */
class MycasaCareerListing extends Widget_Base {
  public function __construct( $data = [], $args = null ) {
    parent::__construct( $data, $args );

    wp_enqueue_style('mycasa-career-listing', MYCASA_ELEMENTOR_PLUGIN_PATH . '/css/career-listing.css', [], '1.1' );
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
    return 'mycasa-career-listing';
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
    return __( 'Career Listing', 'mycasa-elementor' );
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
    return 'eicon-gallery-justified';
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

    $this->add_responsive_control(
      'title_align',
      [
        'label' => esc_html__( 'Alignment', 'elementor' ),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => esc_html__( 'Left', 'elementor' ),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => esc_html__( 'Center', 'elementor' ),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => esc_html__( 'Right', 'elementor' ),
            'icon' => 'eicon-text-align-right',
          ],
          'justify' => [
            'title' => esc_html__( 'Justified', 'elementor' ),
            'icon' => 'eicon-text-align-justify',
          ],
        ],
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-title' => 'text-align: {{VALUE}};',
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
     * Career Listing
     */
    // Career Listing setting
    $this->start_controls_section(
      'section_career_listing',
      [
        'label' => esc_html__( 'Career Listing', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'career_listing_number',
      [
        'label'   => __('Post Number', 'mycasa-elementor'),
        'type'    => Controls_Manager::NUMBER,
        'min'     => 1,
        'max'     => 100,
        'step'    => 1,
        'default' => 7
      ]
    );

    $this->add_control(
      'career_item_padding',
      [
        'label' => esc_html__( 'Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .career-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'career_item_margin',
      [
        'label' => esc_html__( 'Margin', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .career-item-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Career Listing Style
    $this->start_controls_section(
      'section_career_item_style',
      [
        'label' => esc_html__( 'Career Listing Items', 'mycasa-elementor' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'career_item_border_width',
      [
        'label' => esc_html__( 'Border Items Width', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px' ],
        'selectors' => [
          '{{WRAPPER}} .career-item-inner' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'career_item_border_style',
      [
        'label' => esc_html__( 'Border Items Style', 'mycasa-elementor' ),
        'type' => Controls_Manager::SELECT,
        'default' => 'solid',
        'options' => [
          'none' => esc_html__( 'None', 'mycasa-elementor' ),
          'solid' => esc_html__( 'Solid', 'mycasa-elementor' ),
          'dotted' => esc_html__( 'Dotted', 'mycasa-elementor' ),
          'dashed' => esc_html__( 'Dashed', 'mycasa-elementor' ),
          'double' => esc_html__( 'Double', 'mycasa-elementor' ),
          'groove' => esc_html__( 'Groove', 'mycasa-elementor' ),
          'ridge' => esc_html__( 'Ridge', 'mycasa-elementor' ),
          'inset' => esc_html__( 'Inset', 'mycasa-elementor' ),
          'outset' => esc_html__( 'Outset', 'mycasa-elementor' ),
        ],
        'selectors' => [
          '{{WRAPPER}} .career-item-inner' => 'border-style: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'career_item_border_color',
      [
        'label'     => __( 'Border Items Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .career-item-inner' => 'border-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'career_item_title_color',
      [
        'label'     => __( 'Career Title Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .career-item .career-title > a' => 'color: {{VALUE}};',
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
        'name' => 'career_item_typography',
        'global' => [
          'default' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        ],
        'selector' => '{{WRAPPER}} .career-item .career-title',
      ]
    );

    $this->add_control(
      'career_item_title_color_hover',
      [
        'label'     => __( 'Career Title Color Hover', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .career-item .career-title > a:hover' => 'color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
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

    $args = array(
      'post_type' => 'career',
      'posts_per_page' => $settings['career_listing_number'],
      'post_status'   => 'publish',
    );

    $career_query = new WP_Query($args);

    if ($career_query->posts) {
      $careers = $career_query->posts;
    }

    include 'templates/career-listing.php';
  }
}
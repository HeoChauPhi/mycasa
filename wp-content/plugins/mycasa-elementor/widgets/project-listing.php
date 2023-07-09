<?php

namespace MycasaElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Repeater;
use WP_Query;


if ( ! defined( 'ABSPATH' ) ) {
  exit;
} // Exit if accessed directly

/**
 * @since 1.1.0
 */
class MycasaProjectListing extends Widget_Base {
  public function __construct( $data = [], $args = null ) {
    parent::__construct( $data, $args );

    wp_enqueue_style('mycasa-project-listing', MYCASA_ELEMENTOR_PLUGIN_PATH . '/css/mycasa-project-listing.css', [], '1.1' );

    wp_register_script('project-listing', MYCASA_ELEMENTOR_PLUGIN_PATH . '/js/project-listing.js', ['jquery'], '1.1', true );

    wp_enqueue_script( 'project-listing' );
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
    return 'mycasa-project-listing';
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
    return __( 'Project listing', 'mycasa-elementor' );
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
     * Heading Links
     */

    // Sub Title Setting
    $this->start_controls_section(
      'section_heading_link',
      [
        'label' => esc_html__( 'Heading Link', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'heading_link',
      [
        'label' => esc_html__( 'Link Text', 'mycasa-elementor' ),
        'type' => Controls_Manager::TEXT,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => esc_html__( 'Enter your heading link', 'mycasa-elementor' ),
        'default' => esc_html__( 'Add Your Heading Link Text Here', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'heading_link_url',
      [
        'label' => esc_html__( 'Link', 'mycasa-elementor' ),
        'type' => Controls_Manager::URL,
        'dynamic' => [
          'active' => true,
        ],
        'default' => [
          'url' => '',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'heading_link_padding',
      [
        'label' => esc_html__( 'Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'heading_link_margin',
      [
        'label' => esc_html__( 'Margin', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    // heading Link typography
    $this->start_controls_section(
      'section_heading_link_style',
      [
        'label' => esc_html__( 'Heading Link', 'mycasa-elementor' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'heading_link_color',
      [
        'label'     => __( 'Text Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-link' => 'color: {{VALUE}};',
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
        'name' => 'heading_link_typography',
        'global' => [
          'default' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        ],
        'selector' => '{{WRAPPER}} .mycasa-elementor-heading-link',
      ]
    );

    $this->add_control(
      'heading_link_bg_color',
      [
        'label'     => __( 'Background Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-link' => 'background-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'heading_link_border_width',
      [
        'label' => esc_html__( 'Border Width', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px' ],
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-link' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'heading_link_border_style',
      [
        'label' => esc_html__( 'Border Style', 'mycasa-elementor' ),
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
          '{{WRAPPER}} .mycasa-elementor-heading-link' => 'border-style: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'heading_link_border_color',
      [
        'label'     => __( 'Border Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-link' => 'border-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'heading_link_color_hover',
      [
        'label'     => __( 'Text Color hover', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-link:hover' => 'color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'heading_link_bg_color_hover',
      [
        'label'     => __( 'Background Color Hover', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-link:hover' => 'background-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'heading_link_border_color_hover',
      [
        'label'     => __( 'Border Color Hover', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .mycasa-elementor-heading-link:hover' => 'border-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->end_controls_section();

    /*
     * Project Listing
     */
    $this->start_controls_section(
      'section_project_listing',
      [
        'label' => esc_html__( 'Project Listing', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'project_listing_object',
      [
        'label' => __( 'Show Project', 'mycasa-elementor' ),
        'type' => Controls_Manager::SELECT2,
        'multiple' => true,
        'options' => $this->project_object()
      ]
    );

    $this->add_control(
      'project_listing_number',
      [
        'label'   => __('Post Number', 'mycasa-elementor'),
        'type'    => Controls_Manager::NUMBER,
        'min'     => 1,
        'max'     => 49,
        'step'    => 1,
        'default' => 7
      ]
    );


    $this->add_control(
      'project_listing_order',
      [
        'label' => esc_html__( 'Order by', 'mycasa-elementor' ),
        'type' => Controls_Manager::SELECT,
        'default' => 'd_hand_o_date',
        'options' => [
          'a_price' => esc_html__( 'Price - Low to High', 'mycasa-elementor' ),
          'd_price' => esc_html__( 'Price - High to Low', 'mycasa-elementor' ),
          'a_hand_o_date' => esc_html__( 'Hand over Date - Old to New', 'mycasa-elementor' ),
          'd_hand_o_date' => esc_html__( 'Hand over Date - New to Old', 'mycasa-elementor' )
        ],
      ]
    );

    $this->end_controls_section();

    /*
     * Custom Links
     */
    $this->start_controls_section(
      'section_custom_links',
      [
        'label' => esc_html__( 'Custom Links', 'mycasa-elementor' ),
      ]
    );

    $repeater = new Repeater();

    $repeater->add_control(
      'custom_links_text',
      [
        'label'   => __('Custom Link Text', 'mycasa-elementor'),
        'type'    => Controls_Manager::TEXT,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => esc_html__( 'Enter your text link', 'mycasa-elementor' ),
        'default' => esc_html__( 'Add Your custom Link Text Here', 'mycasa-elementor' ),
      ]
    );

    $repeater->add_control(
      'custom_links_url',
      [
        'label'   => __('Custom Link URL', 'mycasa-elementor'),
        'type'    => Controls_Manager::URL,
        'dynamic' => [
          'active' => true,
        ],
        'default' => [
          'url' => '',
        ],
        'separator' => 'before',
      ]
    );

    $repeater->add_control(
      'custom_links_class',
      [
        'label'   => __('Custom Link Class', 'mycasa-elementor'),
        'type'    => Controls_Manager::TEXT,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => esc_html__( 'Enter your class for this link', 'mycasa-elementor' ),
        'default' => esc_html__( '', 'mycasa-elementor' ),
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'custom_links_list',
      [
        'label' => esc_html__( 'Custom Links List', 'mycasa-elementor' ),
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'custom_links_text' => __('Interactive Map', 'mycasa-elementor'),
            'custom_links_url'  => '#',
          ],
          [
            'custom_links_text' => __('Sell A Home', 'mycasa-elementor'),
            'custom_links_url'  => '#',
          ],
          [
            'custom_links_text' => __('Search The Mls', 'mycasa-elementor'),
            'custom_links_url'  => '#',
          ],
        ],
        'title_field' => '{{ custom_links_text }}',
      ]
    );

    $this->add_control(
      'custom_links_padding',
      [
        'label' => esc_html__( 'Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .custom-link-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'custom_links_margin',
      [
        'label' => esc_html__( 'Margin', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .custom-link-item > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Custom Links typography
    $this->start_controls_section(
      'section_custom_links_style',
      [
        'label' => esc_html__( 'Custom Links', 'mycasa-elementor' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'custom_links_color',
      [
        'label'     => __( 'Text Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .custom-link-item > a' => 'color: {{VALUE}};',
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
        'name' => 'custom_links_typography',
        'global' => [
          'default' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        ],
        'selector' => '{{WRAPPER}} .custom-link-item > a',
      ]
    );

    $this->add_control(
      'custom_links_bg_color',
      [
        'label'     => __( 'Background Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .custom-link-item > a' => 'background-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'custom_links_border_width',
      [
        'label' => esc_html__( 'Border Width', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px' ],
        'selectors' => [
          '{{WRAPPER}} .custom-link-item > a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'custom_links_border_style',
      [
        'label' => esc_html__( 'Border Style', 'mycasa-elementor' ),
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
          '{{WRAPPER}} .custom-link-item > a' => 'border-style: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'custom_links_border_color',
      [
        'label'     => __( 'Border Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .custom-link-item > a' => 'border-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'custom_links_color_hover',
      [
        'label'     => __( 'Text Color hover', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .custom-link-item > a:hover' => 'color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'custom_links_bg_color_hover',
      [
        'label'     => __( 'Background Color Hover', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .custom-link-item > a:hover' => 'background-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'custom_links_border_color_hover',
      [
        'label'     => __( 'Border Color Hover', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .custom-link-item > a:hover' => 'border-color: {{VALUE}};',
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

    $orderby = $settings['project_listing_order'];
    $price_field_slug = 'avg_unit_price_sqm_usd';

    $current_lang = '/en/en';

    if (isset($_COOKIE['googtrans'])) {
      $current_lang = $_COOKIE['googtrans'];
    }

    if ($current_lang == '/en/vi' || $current_lang == '/en/vn') {
      $price_field_slug = 'avg_unit_price_sqm_vnd';
    }

    $args = array(
      'post_type' => 'project',
      'posts_per_page' => $settings['project_listing_number'],
    );

    if ( !empty($settings['project_listing_object']) ) {
      $args['post__in'] = $settings['project_listing_object'];
    } 

    if ($orderby == 'a_price') {
      $args['meta_key'] = $price_field_slug;
      $args['orderby'] = 'meta_value_num';
      $args['order'] = 'ASC';
    } elseif ($orderby == 'd_price') {
      $args['meta_key'] = $price_field_slug;
      $args['orderby'] = 'meta_value_num';
      $args['order'] = 'DESC';
    } elseif ($orderby == 'a_hand_o_date') {
      $args['meta_key'] = 'hand_over_date';
      $args['orderby'] = 'meta_value';
      $args['order'] = 'ASC';
    } else {
      $args['meta_key'] = 'hand_over_date';
      $args['orderby'] = 'meta_value';
      $args['order'] = 'DESC';
    }

    $projects = get_posts($args);

    wp_reset_query();

    include 'templates/project-listing.php';
  } 

  /**
   * Render the Project object
   *
   * @access protected
   */
  protected function project_object() {
    $post_obj = array();

    $args = array(
      'posts_per_page' => -1,
      'post_type'   => 'project',
      'post_status'   => 'publish'
    );

    $projects = get_posts($args);

    if ($projects) {
      foreach ($projects as $project) {
        $post_obj[$project->ID] = get_the_title($project->ID);
      }
    }

    wp_reset_query();

    return $post_obj;
  }
}
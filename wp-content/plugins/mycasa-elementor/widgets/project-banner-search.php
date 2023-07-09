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
class MycasaProjectBannerSearch extends Widget_Base {
  public function __construct( $data = [], $args = null ) {
    parent::__construct( $data, $args );

    wp_enqueue_style('mycasa-project-banner-search', MYCASA_ELEMENTOR_PLUGIN_PATH . '/css/project-banner-search.css', [], '1.1' );

    wp_register_script('banner-search', MYCASA_ELEMENTOR_PLUGIN_PATH . '/js/banner-search.js', ['jquery'], '1.1', true );

    wp_enqueue_script( 'banner-search' );
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
    return 'mycasa-project-banner-search';
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
    return __( 'Project Banner Search', 'mycasa-elementor' );
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
    return 'eicon-site-search';
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
     * Tabs
     */
    $this->start_controls_section(
      'banner_search',
      [
        'label' => esc_html__( 'Tabs', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'banner_search_list',
      [
        'label' => __( 'Show Tabs', 'mycasa-elementor' ),
        'type' => Controls_Manager::SELECT2,
        'multiple' => true,
        'options' => [
          'resell' => __('Resell', 'mycasa-elementor'),
          'lease' => __('Lease', 'mycasa-elementor'),
          'project' => __('Project', 'mycasa-elementor')
        ],
        'default' => ['project'],
      ]
    );

    $this->add_control(
      'banner_search_resell_label',
      [
        'label' => __('Resell Label', 'mycasa-elementor'),
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Resell', 'mycasa-elementor' ),
        'placeholder' => __('Label for Resell', 'mycasa-elementor'),
        'condition' => [
          'banner_search_list' => 'resell',
        ],
      ],
    );

    $this->add_control(
      'banner_search_lease_label',
      [
        'label' => __('Lease Label', 'mycasa-elementor'),
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Lease', 'mycasa-elementor' ),
        'placeholder' => __('Label for Lease', 'mycasa-elementor'),
        'condition' => [
          'banner_search_list' => 'lease',
        ],
      ],
    );

    $this->add_control(
      'banner_search_project_label',
      [
        'label' => __('Project Label', 'mycasa-elementor'),
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Project', 'mycasa-elementor' ),
        'placeholder' => __('Label for Project', 'mycasa-elementor'),
        'condition' => [
          'banner_search_list' => 'project',
        ],
      ],
    );

    $this->add_control(
      'banner_search_activate_tab',
      [
        'label' => __( 'Activate Tab', 'mycasa-elementor' ),
        'type' => Controls_Manager::SELECT,
        'options' => [
          'resell' => __('Resell', 'mycasa-elementor'),
          'lease' => __('Lease', 'mycasa-elementor'),
          'project' => __('Project', 'mycasa-elementor')
        ],
        'default' => 'resell',
      ]
    );

    $this->add_control(
      'banner_search_button_label',
      [
        'label' => __('Button Label', 'mycasa-elementor'),
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Search', 'mycasa-elementor' ),
        'placeholder' => __('Label for Button', 'mycasa-elementor'),
        'separator' => 'before',
      ],
    );

    $this->add_control(
      'banner_search_advance',
      [
        'label'   => __('Show advanced', 'mycasa-elementor'),
        'type'    => Controls_Manager::SWITCHER,
        'label_on' => __( 'Show', 'your-plugin' ),
        'label_off' => __( 'Hide', 'your-plugin' ),
        'return_value' => 'yes',
        'default' => 'yes',
        'separator' => 'before',
      ]
    );

    $this->end_controls_section();

    // Form Typography
    $this->start_controls_section(
      'banner_search_form',
      [
        'label' => esc_html__( 'Form', 'mycasa-elementor' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'banner_search_form_bg_color',
      [
        'label'     => __( 'Background Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-wrapper' => 'background-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'separator' => 'after',
      ]
    );

    $this->add_control(
      'banner_search_form_padding',
      [
        'label' => esc_html__( 'Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'separator' => 'after',
      ]
    );

    $this->add_control(
      'banner_search_form_radius',
      [
        'label' => esc_html__( 'Border Radius', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'banner_search_form_box_shadow',
        'label' => esc_html__( 'Box Shadow', 'mycasa-elementor' ),
        'selector' => '{{WRAPPER}} .banner-search-form-wrapper',
      ]
    );

    $this->end_controls_section();

    // Fields Typography
    $this->start_controls_section(
      'banner_search_field',
      [
        'label' => esc_html__( 'Fields', 'mycasa-elementor' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'banner_search_field_text_color',
      [
        'label'     => __( 'Text Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-field' => 'color: {{VALUE}};',
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
        'name' => 'banner_search_field_typography',
        'global' => [
          'default' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        ],
        'selector' => '{{WRAPPER}} .banner-search-form-field',
      ]
    );

    $this->add_control(
      'banner_search_field_bg_color',
      [
        'label'     => __( 'Background Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-field' => 'background-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'banner_search_field_border_color',
      [
        'label'     => __( 'Border Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-field' => 'border-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
        'separator' => 'after',
      ]
    );

    $this->add_control(
      'banner_search_field_radius',
      [
        'label' => esc_html__( 'Border Radius', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em'],
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'banner_search_field_padding',
      [
        'label' => __( 'Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-field-group' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'banner_search_field_margin',
      [
        'label' => __( 'Margin', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-field-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Button Typography
    $this->start_controls_section(
      'banner_search_button',
      [
        'label' => esc_html__( 'Button', 'mycasa-elementor' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->start_controls_tabs( 'banner_search_button_style' );

    $this->start_controls_tab(
      'banner_search_button_normal',
      [
        'label' => esc_html__( 'Normal', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'banner_search_button_bg_color',
      [
        'label' => esc_html__( 'Background Color', 'mycasa-elementor' ),
        'type' => Controls_Manager::COLOR,
        'default' => '#00aeff',
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-button' => 'background-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'banner_search_button_text_color',
      [
        'label' => esc_html__( 'Text Color', 'mycasa-elementor' ),
        'type' => Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-button' => 'color: {{VALUE}};',
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
        'name' => 'banner_search_button_typography',
        'selector' => '{{WRAPPER}} .banner-search-form-button',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(), [
        'name' => 'banner_search_button_border',
        'selector' => '{{WRAPPER}} .banner-search-form-button',
      ]
    );

    $this->add_responsive_control(
      'banner_search_button_border_radius',
      [
        'label' => esc_html__( 'Border Radius', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%' ],
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'banner_search_button_text_padding',
      [
        'label' => esc_html__( 'Text Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'banner_search_button_hover',
      [
        'label' => esc_html__( 'Hover', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'banner_search_button_bg_hover_color',
      [
        'label' => esc_html__( 'Background Color', 'mycasa-elementor' ),
        'type' => Controls_Manager::COLOR,
        'default' => '#33beff',
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-button:hover' => 'background-color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'banner_search_button_hover_color',
      [
        'label' => esc_html__( 'Text Color', 'mycasa-elementor' ),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-button:hover' => 'color: {{VALUE}};',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'banner_search_button_hover_border_color',
      [
        'label' => esc_html__( 'Border Color', 'mycasa-elementor' ),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .banner-search-form-button:hover' => 'border-color: {{VALUE}};',
        ],
        'condition' => [
          'banner_search_button_border_border!' => '',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_responsive_control(
      'banner_search_button_hover_animation',
      [
        'label' => esc_html__( 'Animation', 'mycasa-elementor' ),
        'type' => Controls_Manager::HOVER_ANIMATION,
      ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->end_controls_section();

    // Tabs Typography
    $this->start_controls_section(
      'banner_search_tabs',
      [
        'label' => esc_html__( 'Tabs Style', 'mycasa-elementor' ),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'banner_search_tabs_typography',
        'selector' => '{{WRAPPER}} .nav-item .nav-link',
      ]
    );

    $this->add_control(
      'banner_search_tabs_color',
      [
        'label'     => esc_html__( 'Tabs Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .banner-search-tabs .nav-link' => 'color: {{VALUE}}',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'banner_search_tabs_active_color',
      [
        'label'     => esc_html__( 'Tabs Active Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '#000000',
        'selectors' => [
          '{{WRAPPER}} .banner-search-tabs .nav-link.active' => 'color: {{VALUE}}',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'banner_search_tabs_bg_color',
      [
        'label'     => esc_html__( 'Tabs Background Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '#00aeff',
        'selectors' => [
          '{{WRAPPER}} .banner-search-tabs .nav-link' => 'background-color: {{VALUE}}',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_control(
      'banner_search_active_tabs_bg_color',
      [
        'label'     => esc_html__( 'Active Tabs Background Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .banner-search-tabs .nav-link.active' => 'background-color: {{VALUE}}',
        ],
        'scheme'    => [
          'type'  => Scheme_Color::get_type(),
          'value' => Scheme_Color::COLOR_1,
        ],
      ]
    );

    $this->add_responsive_control(
      'banner_search_tabs_padding',
      [
        'label' => __( 'Padding', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [
          '{{WRAPPER}} .banner-search-tabs .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'banner_search_tabs_margin',
      [
        'label' => __( 'Margin', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [
          '{{WRAPPER}} .banner-search-tabs .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'banner_search_tabs_radius',
      [
        'label' => __( 'Radius', 'mycasa-elementor' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [
          '{{WRAPPER}} .banner-search-tabs .nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'banner_search__tabs_align',
      [
        'label' => esc_html__( 'Alignment', 'mycasa-elementor' ),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
          ''  => [
            'title' => esc_html__( 'Left', 'mycasa-elementor' ),
            'icon' => 'fa fa-align-left',
          ],
          'justify-content-center' => [
            'title' => esc_html__( 'Center', 'mycasa-elementor' ),
            'icon' => 'fa fa-align-center',
          ]
        ],
        'default' => 'justify-content-center',
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

    // Project data
    $projects_data = [];
    $args = array(
      'posts_per_page' => -1,
      'post_type'   => 'project',
      'post_status'   => 'publish'
    );

    $projects = get_posts($args);

    if ($projects) {
      foreach ($projects as $project) {
        $projects_data[$project->ID] = get_the_title($project->ID);
      }
    }

    wp_reset_query();

    include 'templates/project-banner-search.php';
  } 
}
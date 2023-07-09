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
class MycasaNumberCounter extends Widget_Base {
  public function __construct( $data = [], $args = null ) {
    parent::__construct( $data, $args );

    wp_enqueue_style('mycasa-number-counter', MYCASA_ELEMENTOR_PLUGIN_PATH . '/css/mycasa-number-counter.css', [], '1.1' );

    wp_register_script('number-counter', MYCASA_ELEMENTOR_PLUGIN_PATH . '/js/number-counter.js', ['jquery'], '1.1', true );

    wp_enqueue_script( 'number-counter' );
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
    return 'mycasa-number-counter';
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
    return __( 'Number Counter', 'mycasa-elementor' );
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
    return 'eicon-counter';
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
     * List Numbers Counter
     */

    // List counter setting
    $this->start_controls_section(
      'section_list_number_counter',
      [
        'label' => esc_html__( 'List Number Counter', 'mycasa-elementor' ),
      ]
    );

    $repeater = new Repeater();

    $repeater->add_control(
      'number_counter_title',
      [
        'label'   => __('Number Counter Title', 'mycasa-elementor'),
        'type'    => Controls_Manager::TEXT,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => esc_html__( 'Counter Title', 'mycasa-elementor' ),
        'default' => esc_html__( 'Add Your Counter Title Here', 'mycasa-elementor' ),
      ]
    );

    $repeater->add_control(
      'number_counter_title_prefix',
      [
        'label'   => __('Number Counter Title Prefix', 'mycasa-elementor'),
        'type'    => Controls_Manager::TEXT,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => esc_html__( 'Counter Title Prefix', 'mycasa-elementor' ),
        'default' => esc_html__( '', 'mycasa-elementor' ),
      ]
    );

    $repeater->add_control(
      'number_counter_title_suffix',
      [
        'label'   => __('Number Counter Title Suffix', 'mycasa-elementor'),
        'type'    => Controls_Manager::TEXT,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => esc_html__( 'Counter Title Suffix', 'mycasa-elementor' ),
        'default' => esc_html__( '', 'mycasa-elementor' ),
      ]
    );

    $repeater->add_control(
      'number_counter_type',
      [
        'label'   => __('Number Counter Type', 'mycasa-elementor'),
        'type'    => Controls_Manager::SELECT,
        'default' => 'number',
        'options' => [
          'number'  => __( 'Number', 'plugin-domain' ),
          'string' => __( 'Text', 'plugin-domain' ),
        ],
      ]
    );

    $repeater->add_control(
      'number_counter_description',
      [
        'label'   => __('Number Counter Description', 'mycasa-elementor'),
        'type'    => Controls_Manager::TEXTAREA,
        'dynamic' => [
          'active' => true,
        ],
        'placeholder' => esc_html__( 'Counter Description', 'mycasa-elementor' ),
        'default' => esc_html__( 'Add Your Counter Description Here', 'mycasa-elementor' ),
      ]
    );

    $this->add_control(
      'number_counter_list',
      [
        'label' => esc_html__( 'Number Counter List', 'mycasa-elementor' ),
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'number_counter_title' => __('$1+B', 'mycasa-elementor'),
            'number_counter_type' => 'string',
            'number_counter_title_prefix' => null,
            'number_counter_title_suffix' => null,
            'number_counter_description'  => __('APPROX. TOTAL SALES', 'mycasa-elementor'),
          ],
          [
            'number_counter_title' => 85,
            'number_counter_type' => 'number',
            'number_counter_title_prefix' => null,
            'number_counter_title_suffix' => 'K',
            'number_counter_description'  => __('TOTAL EMAIL SUBSCRIBERS', 'mycasa-elementor'),
          ],
          [
            'number_counter_title' => 643,
            'number_counter_type' => 'number',
            'number_counter_title_prefix' => '$',
            'number_counter_title_suffix' => 'M',
            'number_counter_description'  => __('TOTAL SALES SINCE 2017', 'mycasa-elementor'),
          ],
          [
            'number_counter_title' => 220,
            'number_counter_type' => 'number',
            'number_counter_title_prefix' => null,
            'number_counter_title_suffix' => null,
            'number_counter_description'  => __('TRANSACTIONS SINCE 2017', 'mycasa-elementor'),
          ],
        ],
        'title_field' => '{{ number_counter_title }}',
      ]
    );

    $this->end_controls_section();

    // List Counter typography
    $this->start_controls_section(
      'section_number_counter_style',
      [
        'label' => esc_html__( 'Number Counter Style', 'mycasa-elementor' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'number_counter_title_color',
      [
        'label'     => __( 'Title Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .number-counter-title-wrap' => 'color: {{VALUE}};',
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
        'name' => 'number_counter_title_typography',
        'global' => [
          'default' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        ],
        'selector' => '{{WRAPPER}} .number-counter-title-wrap',
      ]
    );

    $this->add_control(
      'number_counter_title_align',
      [
        'label' => esc_html__( 'Title Alignment', 'elementor' ),
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
          '{{WRAPPER}} .number-counter-title-wrap' => 'text-align: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'number_counter_description_color',
      [
        'label'     => __( 'Description Color', 'mycasa-elementor' ),
        'type'      => Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
          '{{WRAPPER}} .number-counter-description' => 'color: {{VALUE}};',
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
        'name' => 'number_counter_description_typography',
        'global' => [
          'default' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        ],
        'selector' => '{{WRAPPER}} .number-counter-description',
      ]
    );

    $this->add_control(
      'number_counter_description_align',
      [
        'label' => esc_html__( 'description Alignment', 'elementor' ),
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
          '{{WRAPPER}} .number-counter-description' => 'text-align: {{VALUE}};',
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

    include 'templates/number-counter.php';
  }

}
<?php
/**
 * 
 */
class Mycasa_Post_Type_Career {
  /**
   * Initialize custom post type
   *
   * @access public
   * @return void
   */
  public function init() {
    add_action( 'init', array( __CLASS__ , 'definition') );
  }

  /**
   * Custom post type definition
   *
   * @access public
   * @return void
   */
  public function definition() {
    $labels = array(
      'name' => __( 'Career','mycasa'),
      'singular_name' => __( 'Career','mycasa' ),
      'add_new' => __('Add New Career','mycasa'),
      'add_new_item' => __('Add New','mycasa'),
      'edit_item' => __('Edit Career','mycasa'),
      'new_item' => __('New Career','mycasa'),
      'view_item' => __('View Career','mycasa'),
      'search_items' => __('Search Career','mycasa'),
      'not_found' =>  __('No Odoo Career','mycasa'),
      'not_found_in_trash' => __('No Career found in Trash','mycasa'),
      'parent_item_colon' => ''
    );

    $args = array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'query_var' => true,
      'has_archive' => true,
      'capability_type' => 'post',
      'map_meta_cap'    => true,
      'hierarchical' => true,
      'menu_icon' => 'dashicons-portfolio',
      'menu_position' => 5,
      'can_export' => true,
      'show_in_rest' => true,
      'supports' => array('title','editor','thumbnail','excerpt'),

       // The rewrite handles the URL structure.
      'rewrite' => array(
        'slug'       => 'career',
        'with_front' => false,
        'pages'      => true,
        'feeds'      => true,
        'ep_mask'    => EP_PERMALINK,
      ),
    );

    register_post_type('career',$args);
  }
}

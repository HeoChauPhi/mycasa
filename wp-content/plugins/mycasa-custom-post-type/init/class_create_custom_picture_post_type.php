<?php
/**
 * 
 */
class Mycasa_Post_Type_OdooPicture {
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
      'name' => __( 'Odoo Picture','mycasa'),
      'singular_name' => __( 'Odoo Picture','mycasa' ),
      'add_new' => __('Add New Odoo Picture','mycasa'),
      'add_new_item' => __('Add New','mycasa'),
      'edit_item' => __('Edit Odoo Picture','mycasa'),
      'new_item' => __('New Odoo Picture','mycasa'),
      'view_item' => __('View Odoo Picture','mycasa'),
      'search_items' => __('Search Odoo Picture','mycasa'),
      'not_found' =>  __('No Odoo Picture found','mycasa'),
      'not_found_in_trash' => __('No Odoo Picture found in Trash','mycasa'),
      'parent_item_colon' => ''
    );

    $args = array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => false,
      'query_var' => true,
      'has_archive' => true,
      'capability_type' => 'post',
      'map_meta_cap'    => true,
      'hierarchical' => true,
      'menu_icon' => 'dashicons-location',
      'menu_position' => 5,
      'can_export' => true,
      'show_in_rest' => true,
      'supports' => array('title'),

       // The rewrite handles the URL structure.
      'rewrite' => array(
        'slug'       => 'odoo_picture',
        'with_front' => false,
        'pages'      => true,
        'feeds'      => true,
        'ep_mask'    => EP_PERMALINK,
      ),
    );

    register_post_type('odoo_picture',$args);
  }
}

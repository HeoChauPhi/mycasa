<?php
/**
 * 
 */
class Mycasa_Custom_Taxonomy {
  /**
   * Initialize custom post type
   *
   * @access public
   * @return void
   */
  public function init() {
    add_action( 'init', array( __CLASS__ , 'property_tags') );
  }

  public function property_tags() {

    $labels = array(
      'name'              => __('Property Tags','mycasa'),
      'add_new_item'      => __('Add New Property Tags','mycasa'),
      'new_item_name'     => __('New Property Tags','mycasa')
    );

    $args =  array(
      'labels' => $labels,
      'hierarchical'  => true,
      'query_var'     => true,
      'show_in_rest'  => true,
      'rest_base'     => 'property_tag',
      'rewrite'       => array( 'slug' => 'property_tag', 'with_front' => false)
    );
    register_taxonomy('property_tag', array('property'), $args);
  }
}

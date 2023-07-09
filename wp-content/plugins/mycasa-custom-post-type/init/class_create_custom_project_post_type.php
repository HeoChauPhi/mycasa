<?php
/**
 * 
 */
class Mycasa_Post_Type_Project {
  /**
   * Initialize custom post type
   *
   * @access public
   * @return void
   */
  public function init() {
    add_action( 'init', array( __CLASS__ , 'definition') );
    add_action( 'init', array( __CLASS__ , 'project_type') );
  }

  /**
   * Custom post type definition
   *
   * @access public
   * @return void
   */
  public function definition() {
    $labels = array(
      'name' => __( 'Projects','mycasa'),
      'singular_name' => __( 'Project','mycasa' ),
      'add_new' => __('Add New Project','mycasa'),
      'add_new_item' => __('Add New','mycasa'),
      'edit_item' => __('Edit Project','mycasa'),
      'new_item' => __('New Project','mycasa'),
      'view_item' => __('View Project','mycasa'),
      'search_items' => __('Search Project','mycasa'),
      'not_found' =>  __('No Project found','mycasa'),
      'not_found_in_trash' => __('No Project found in Trash','mycasa'),
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
      'menu_icon' => 'dashicons-location',
      'menu_position' => 5,
      'can_export' => true,
      'show_in_rest'       => true,
      'supports' => array('title','editor','thumbnail','revisions','author','excerpt','comments'),
      'taxonomies' => array('property_feature'),

       // The rewrite handles the URL structure.
      'rewrite' => array(
        'slug'       => 'project',
        'with_front' => false,
        'pages'      => true,
        'feeds'      => true,
        'ep_mask'    => EP_PERMALINK,
      ),
    );

    register_post_type('project',$args);
  }

  public function project_type() {

    $labels = array(
      'name'              => __('Project Type','mycasa'),
      'add_new_item'      => __('Add New Project Type','mycasa'),
      'new_item_name'     => __('New Project Type','mycasa')
    );

    $args =  array(
      'labels' => $labels,
      'hierarchical'  => true,
      'query_var'     => true,
      'show_in_rest'  => true,
      'rest_base'     => 'project_type',
      'rewrite'       => array( 'slug' => 'project_type', 'with_front' => false)
    );
    register_taxonomy('project_type', array('project'), $args);
  }
}

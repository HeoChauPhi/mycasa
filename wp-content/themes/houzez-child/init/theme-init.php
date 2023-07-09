<?php
/*
 *
 * Custom Taxonomy
 *
 */
function houzez_child_create_custom_taxonomy() {
  $labels = array(
    'name'              => __('Member Type','mycasa'),
    'add_new_item'      => __('Add New Member Type','mycasa'),
    'new_item_name'     => __('New Member Type','mycasa')
  );

  $args =  array(
    'labels' => $labels,
    'hierarchical'  => true,
    'query_var'     => true,
    'show_in_rest'  => true,
    'rest_base'     => 'member_type',
    'rewrite'       => array( 'slug' => 'member_type', 'with_front' => false)
  );
  register_taxonomy('member_type', array('post'), $args);
}
add_action( 'init', 'houzez_child_create_custom_taxonomy', 0 );

/*
 * Get all meta values by meta fields key
 */
function houzez_child_get_meta_values($key) {
  global $wpdb;
  $result = $wpdb->get_col( 
  $wpdb->prepare("
      SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
      LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
      WHERE pm.meta_key = '%s' 
      AND p.post_status = 'publish'
      ORDER BY pm.meta_value", 
      $key
    )
  );

  return $result;
}

/*
 * Create Option Child theme
 */
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'MyCasa Theme General Settings',
    'menu_title'  => 'MyCasa Theme',
    'menu_slug'   => 'mycasa-theme-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));  
}

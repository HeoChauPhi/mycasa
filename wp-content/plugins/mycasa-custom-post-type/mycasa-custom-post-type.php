<?php
/**
 * Plugin Name: MyCasa custom Post Type
 * Plugin URI:  https://dev-mycasa.pantheonsite.io/
 * Description: Create custom post types and custom fields use ACF plugin
 * Version:     1.0
 * Author:      MyCasa
 * Author URI:  https://dev-mycasa.pantheonsite.io/
 * License:     GPL-2.0+
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

define( 'MYCASA_CPT_PLUGIN_PATH', '/wp-content/plugins/mycasa-custom-post-type' );

include_once('init/functions.php');

include_once('init/class_create_custom_project_post_type.php');
include_once('init/class_create_custom_picture_post_type.php');
include_once('init/class_create_custom_document_post_type.php');
include_once('init/class_create_custom_career_post_type.php');
include_once('init/class_create_custom_taxonomy.php');

require_once plugin_dir_path( __FILE__ ) . '/admin/class_career_admin_setting.php';

// Admin settings.
if(is_admin()) {
  if ( is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
    add_action('acf/update_field_group', 'mycasa_cpt_acf_json_update_point', 1, 1);
    add_filter('acf/settings/load_json', 'mycasa_cpt_acf_json_load_point', 9999);

    add_filter('acf/update_value/key=field_6120cc2b63f9d', 'mycasa_cpt_acf_reciprocal_relationship', 10, 3);
    add_filter('acf/update_value/key=field_611654c945aec', 'mycasa_cpt_acf_reciprocal_relationship', 10, 3);
  } else {
    add_action('admin_notices', 'mycasa_cpt_acf_deactivate');
  }

  // Add setting Career
  $settings = new MyCasaCareerSystem();
}

// Register Project Post Types
$mycasa_cpt_project = new Mycasa_Post_Type_Project();
$mycasa_cpt_project->init();

// Register Picture Post Types
$mycasa_cpt_picture = new Mycasa_Post_Type_OdooPicture();
$mycasa_cpt_picture->init();

// Register Document Post Types
$mycasa_cpt_document = new Mycasa_Post_Type_OdooDocument();
$mycasa_cpt_document->init();

// Register Career Post Types
$mycasa_cpt_career = new Mycasa_Post_Type_Career();
$mycasa_cpt_career->init();

// Register Custom Taxonomy
$mycasa_cpt_career = new Mycasa_Custom_Taxonomy();
$mycasa_cpt_career->init();


// register_deactivation_hook( __FILE__, 'mycasa_cpt_deactivate' );

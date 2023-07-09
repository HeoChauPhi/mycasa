<?php
/**
 * Plugin Name: MyCasa connect to Odoo
 * Plugin URI:  https://dev-mycasa.pantheonsite.io/
 * Description: Connect to Odoo API
 * Version:     1.0
 * Author:      MyCasa
 * Author URI:  https://dev-mycasa.pantheonsite.io/
 * License:     GPL-2.0+
*/
require_once plugin_dir_path( __FILE__ ) . '/json-machine/vendor/autoload.php';

require_once plugin_dir_path( __FILE__ ) . '/admin/functions.php';
require_once plugin_dir_path( __FILE__ ) . '/class-import/data-processor.php';

add_action('init', 'mycasa_to_odoo_create_json_files');

/*$wp_bp_plugin = WP_PLUGIN_DIR . '/wp-batch-processing';
if ( is_dir( $wp_bp_plugin ) ) {
  require WP_PLUGIN_DIR . '/wp-batch-processing/wp-batch-processing.php';  
} else {
  add_action( 'admin_notices', 'mycasa_to_odoo_admin_notice_error' );
}*/

require_once plugin_dir_path( __FILE__ ) . '/admin/admin.php';
require_once plugin_dir_path( __FILE__ ) . '/OdooClient/class_mycasa_odoo_client.php';
require_once plugin_dir_path( __FILE__ ) . '/admin/class_mycasa_config_wp_batch_processor.php';

// Admin settings.
if(is_admin()) {
  $settings = new MyCasaConnectOdooSystem();

  // Register style
  add_action('admin_init', 'mycasa_to_odoo_admin_styles');
  add_action('admin_init', 'mycasa_to_odoo_admin_script');

  // // Test Odoo
  // $odoo_options = get_option('mycasa_connect_odoo_board_settings');

  // $odoo_url = $odoo_options['mycasa_connect_odoo_url'];
  // $odoo_db = $odoo_options['mycasa_connect_odoo_db'];
  // $odoo_username = $odoo_options['mycasa_connect_odoo_username'];
  // $odoo_password = $odoo_options['mycasa_connect_odoo_password'];
  // $option_time = $odoo_options['mycasa_connect_odoo_export_time'];

  // $OdooClient = new MyCasa_Odoo_client($odoo_url, $odoo_db, $odoo_username, $odoo_password);

  // $odoo_data = $OdooClient->get_list_search('real.estate.unit' , null, null, array(), array('id'));
  // print_r($odoo_data);
  // die;
}

// Import process
require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_import_amenity_data.php';
//require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_remove_amenity_data.php';

require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_import_tags_data.php';

require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_import_picture_data.php';
//require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_remove_picture_data.php';

require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_import_document_data.php';
//require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_remove_document_data.php';

require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_import_project_data.php';
//require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_remove_project_data.php';

require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_import_properties_data.php';
//require_once plugin_dir_path( __FILE__ ) . '/class-import/class_mycasa_odoo_remove_properties_data.php';

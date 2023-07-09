<?php

use \JsonMachine\JsonMachine;

// Require WP Batch Processing plugin
function mycasa_to_odoo_admin_notice_error() {
  $element = '';
  $element .= '<div class="notice notice-error"><p>';
  $element .= __('Please install', 'mycasa') . '<a href="https://github.com/gdarko/wp-batch-processing" target="_blank">' . ' WP Batch Processing ' . '</a>' . __('plugin', 'mycasa');
  $element .= '</p></div>';
  echo $element;
}

// Create plugin folder in uploads folder
function mycasa_to_odoo_create_json_files() {
  $current_user = wp_get_current_user();
  $upload_dir   = wp_upload_dir();
   
  if (isset($current_user->user_login) && !empty($upload_dir['basedir'])) {
    $mycasa_to_odoo_folder = $upload_dir['basedir'].'/mycasa-odoo-connect';
    if (!file_exists($mycasa_to_odoo_folder)) {
      wp_mkdir_p( $mycasa_to_odoo_folder );
    }

    $project = $mycasa_to_odoo_folder . '/project';
    $property = $mycasa_to_odoo_folder . '/property';
    $amenity = $mycasa_to_odoo_folder . '/amenity';
    $tags = $mycasa_to_odoo_folder . '/tags';
    $picture = $mycasa_to_odoo_folder . '/picture';
    $document = $mycasa_to_odoo_folder . '/document';

    if (!file_exists($project)) {
      wp_mkdir_p( $mycasa_to_odoo_folder . '/project' );
    }

    if (!file_exists($property)) {
      wp_mkdir_p( $mycasa_to_odoo_folder . '/property' );
    }

    if (!file_exists($amenity)) {
      wp_mkdir_p( $mycasa_to_odoo_folder . '/amenity' );
    }

    if (!file_exists($tags)) {
      wp_mkdir_p( $mycasa_to_odoo_folder . '/tags' );
    }

    if (!file_exists($picture)) {
      wp_mkdir_p( $mycasa_to_odoo_folder . '/picture' );
    }

    if (!file_exists($document)) {
      wp_mkdir_p( $mycasa_to_odoo_folder . '/document' );
    }
  }
}

// Get Odoo Project fields
function mycasa_to_odoo_project_fields() {
  $project_show_fields = array(
    'id', 'name', 'type', 'developer_id', 'total_unit_number', 'amenity_ids', 'short_description', 'description', 'is_foreigner_quota', 'hand_over_date', 'status', 'picture_attachement_ids', 'project_public_image_urls', 'avg_unit_price_sqm_usd', 'avg_unit_price_sqm_vnd', 'document_ids', 'google_drive_link', 'street', 'street2', 'zip', 'city_id', 'district_id', 'state_id', 'country_id', 'full_address', 'display_name', 'create_uid', 'create_date', 'write_uid', 'write_date', '__last_update'
  );

  return $project_show_fields;
}

// Get Odoo Property (Apartment) fields
function mycasa_to_odoo_property_fields() {
  $property_show_fields = array(
    'id', 'name', 'unit_code', 'status', 'project_id', 'type_id', 'tag_ids', 'code', 'size_sqm', 'bedroom_number', 'management_fee', 'rent_usd', 'rent_vnd', 'resale_usd', 'resale_vnd', 'price_sqm_usd', 'price_sqm_vnd', 'is_foreign_quota', 'is_cooperation', 'picture_attachement_ids', 'public_image_urls', 'owner_partner_id', 'amenity_ids', 'description', 'tenant', 'rented_from', 'rented_until', 'last_notify_rented_will_expire', 'sold_at', 'living', 'furnished', 'direction', 'display_name', 'create_uid', 'create_date', 'write_uid', 'write_date', '__last_update'
  );

  return $property_show_fields;
}

// Function for register admin style
function mycasa_to_odoo_admin_styles() {
  wp_register_style('jqueryui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), '1.12.1', 'all');
  wp_enqueue_style('jqueryui-css');

  wp_register_style('mycasa_to_odoo_monthpicker_style', plugin_dir_url( __DIR__ ) . 'access/css/MonthPicker.min.css');
  wp_enqueue_style('mycasa_to_odoo_monthpicker_style');

  wp_register_style('mycasa_to_odoo_style', plugin_dir_url( __DIR__ ) . 'access/css/mycasa-to-odoo-style.css');
  wp_enqueue_style('mycasa_to_odoo_style');
}

// Function for register admin script
function mycasa_to_odoo_admin_script() {
  wp_register_script('jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array(), '1.12.1', false);
  wp_enqueue_script('jquery-ui');

  wp_register_script('mycasa_to_odoo_monthpicker_script', plugin_dir_url( __DIR__ ) . 'access/js/MonthPicker.min.js', array(), '1.0', false);
  wp_enqueue_script('mycasa_to_odoo_monthpicker_script');

  wp_register_script('mycasa_to_odoo_script', plugin_dir_url( __DIR__ ) . 'access/js/mycasa-to-odoo-script.js', array(), '1.0', false);
  wp_enqueue_script('mycasa_to_odoo_script');
}

// function to get  the address
function mycasa_to_odoo_gmap_latlng($address){
  $theme_options = get_option('houzez_options');
  $google_api_key = $theme_options['googlemap_api_key'];

  $address_str = str_replace(" ", "+", $address);

  $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=$google_api_key&address=$address_str");
  $json = json_decode($json);

  if ($json->status == "OK") {
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $lng = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

    $address = array(
      'address' => $address,
      'lat' => $lat,
      'lng' => $lng
    );
    return $address;
  }

  return $json['error_message'];
}

// Generate days of month
function mycasa_to_odoo_dates_month($month, $year) {
  $num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
  $dates_month = array();

  for ($i = 1; $i <= $num; $i++) {
    $mktime = mktime(0, 0, 0, $month, $i, $year);
    $date = date("Y-m-d", $mktime);
    $dates_month[$i] = $date;
  }

  return $dates_month;
}

// Get data from json files
function mycasa_to_odoo_get_json_data($folder) {
  $result = array();
  $dir = wp_upload_dir()['basedir'] . '/mycasa-odoo-connect/' . $folder;
  $files = array_diff(scandir($dir), array('.', '..'));
  natsort($files);

  foreach ($files as $file) {
    $file_url = wp_upload_dir()['baseurl'] . '/mycasa-odoo-connect/' . $folder . '/' . $file;
    $datas = JsonMachine::fromFile($file_url);

    foreach ($datas as $data) {
      array_push($result, $data);
    }
  }

  return $result;
}

// Get Realation by IDs
function mycasa_to_odoo_get_relation_fields($odooclient, $field_slug, $ids = array(), $show_fields=array()) {
  $relation_fields = array();
  $module_relation = array(
    'amenity_ids' => 'real.estate.amenity',
    'picture_attachement_ids' => 'real.estate.image',
    'document_ids' => 'ir.attachment'
  );

  $module = $module_relation[$field_slug];

  if (isset($module) && !empty($module) && !empty($ids)) {
    $relation_list = $odooclient->get_list_by_ids($module, $ids, $show_fields);
    unset($relation_list['status']);

    if (!empty($relation_list)) {
      $relation_fields = $relation_list;
    }
  }

  return $relation_fields;
}

// Convert Vietnam string to normal Latin
function mycasa_to_odoo_stripvn($str) {
  $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
  $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
  $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
  $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
  $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
  $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
  $str = preg_replace("/(đ)/", 'd', $str);

  $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
  $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
  $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
  $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
  $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
  $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
  $str = preg_replace("/(Đ)/", 'D', $str);
  return $str;
}

// Create API to get json data
add_action('rest_api_init','mycasa_to_odoo_get_json_data_api');
function mycasa_to_odoo_get_json_data_api(){
  register_rest_route('mycasa-odoo-connect/v1','/module',array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'mycasa_to_odoo_get_json_data_api_query'
  ));
}

function mycasa_to_odoo_get_json_data_api_query($data) {
  $folder = $data->get_param( 'name' );

  $result = array();
  $dir = wp_upload_dir()['basedir'] . '/mycasa-odoo-connect/' . $folder;
  $files = array_diff(scandir($dir), array('.', '..'));
  natsort($files);

  foreach ($files as $file) {
    $file_url = wp_upload_dir()['baseurl'] . '/mycasa-odoo-connect/' . $folder . '/' . $file;
    $datas = JsonMachine::fromFile($file_url);

    foreach ($datas as $data) {
      array_push($result, $data);
    }
  }

  return $result;
}

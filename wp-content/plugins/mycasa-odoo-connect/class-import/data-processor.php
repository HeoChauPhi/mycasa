<?php
// Odoo Verify user
add_action( 'wp_ajax_mycasa_to_odoo_verify_user', 'mycasa_to_odoo_verify_user' );
function mycasa_to_odoo_verify_user() {
  $values = $_REQUEST;

  $odoo_url = $values['odoo_url'];
  $odoo_db = $values['odoo_db'];
  $odoo_username = $values['odoo_username'];
  $odoo_password = $values['odoo_password'];

  $OdooClient = new MyCasa_Odoo_client($odoo_url, $odoo_db, $odoo_username, $odoo_password);

  $odoo_verify = $OdooClient->test_authentication();

  $result = json_encode(array(
    'odoo_verify' => $odoo_verify
  ));
  echo $result;

  wp_die();
}

// Odoo Get data
add_action( 'wp_ajax_mycasa_to_odoo_get_data', 'mycasa_to_odoo_get_data' );
function mycasa_to_odoo_get_data() {
  $values = $_REQUEST;
  $odoo_verify = [];

  // Odoo Informations
  $odoo_options = get_option('mycasa_connect_odoo_board_settings');
  $odoo_url = $odoo_options['mycasa_connect_odoo_url'];
  $odoo_db = $odoo_options['mycasa_connect_odoo_db'];
  $odoo_username = $odoo_options['mycasa_connect_odoo_username'];
  $odoo_password = $odoo_options['mycasa_connect_odoo_password'];

  $option_time_from = $values['option_time_from'];
  $option_time_to   = $values['option_time_to'];
  $option_limit     = $values['option_limit'];
  $module           = $values['module'];
  $folder           = $values['folder'];
  $data_connect     = $values['data_connect'];
  $data_loop        = $values['data_loop'];
  $data_count_val   = $values['data_count'];

  $OdooClient = new MyCasa_Odoo_client($odoo_url, $odoo_db, $odoo_username, $odoo_password);

  $data_filter = array();
  if (!empty($option_time_from) && !empty($option_time_to)) {
    // $option_month = date('m', strtotime($option_time));
    // $option_year = date('Y', strtotime($option_time));

    // $days_arr = mycasa_to_odoo_dates_month($option_month, $option_year);
    // $first_day = $days_arr[array_key_first($days_arr)];
    // $last_day = $days_arr[array_key_last($days_arr)];

    if ($folder == 'project' || $folder == 'property') {
      $data_filter = array(array('write_date', '>=' , $option_time_from), array('write_date', '<=' , $option_time_to));      
    }
  }

  $show_fields = array();
  if ($folder == 'project') {
    $show_fields = mycasa_to_odoo_project_fields();
  } elseif ($folder == 'property') {
    $show_fields = mycasa_to_odoo_property_fields();
  } elseif ($folder == 'amenity') {
    $show_fields = array('id', 'name');
  } elseif ($folder == 'tags') {
    $show_fields = array('id', 'name', 'display_name');
  } elseif ($folder == 'picture') {
    $data_filter = array(array('public_image_url', '!=', null));
    $show_fields = array('id', 'public_image_url', 'name');
  } elseif ($folder == 'document') {
    $data_filter = array(array('res_model', '=', 'real.estate.project'), array('website_url', '!=', null), array('mimetype', '!=', 'application/javascript'), array('mimetype', '!=', 'text/css'), array('mimetype', '!=', 'text/scss'), array('mimetype', '!=', 'application/octet-stream'));
    $show_fields = array('id', 'website_url', 'name', 'mimetype');
  }

  $files_name = array();
  $dir = wp_upload_dir()['basedir'] . '/mycasa-odoo-connect/' . $folder;
  $files = array_diff(scandir($dir), array('.', '..'));
  foreach ($files as $file) {
    $file_name = str_replace('.json', '', $file);
    array_push($files_name, (int)$file_name);
  }

  /*$data_count = $OdooClient->search_count($module);

  $pager = 1;
  if ($option_limit) {
    $pager = (int)$option_limit;
  }

  $offset_start = 0;
  if ($data_connect == "re-connect") {
    $offset_start = max($files_name) + $pager;
  } else {
    array_map('unlink', glob(wp_upload_dir()['basedir'] . '/mycasa-odoo-connect/' . $folder . '/*.json'));
  }

  for ($offset=$offset_start; $offset < $data_count; $offset+=$pager) {
    $odoo_data = $OdooClient->get_list_search($module, $pager, $offset, $data_filter, $show_fields);
    unset($odoo_data['status']);

    $json = json_encode($odoo_data, JSON_INVALID_UTF8_SUBSTITUTE);
    file_put_contents(wp_upload_dir()['basedir'] . '/mycasa-odoo-connect/'.$folder.'/'.$offset.'.json', $json);
    $odoo_data = null;
    $json = null;
    gc_collect_cycles();//add this line here
    sleep(1);
  }*/

  $data_count = null;
  if ($data_count_val != 0) {
    $data_count = $data_count_val;
  } else {
    $data_count = $OdooClient->search_count($module, $data_filter);
  }

  $pager = 1;
  if ($option_limit) {
    $pager = (int)$option_limit;
  }

  $offset_start = (int)$data_loop;
  if ($data_connect == 'connect') {
    if ($offset_start == 0 && !empty($files)) {
      array_map('unlink', glob(wp_upload_dir()['basedir'] . '/mycasa-odoo-connect/' . $folder . '/*.json'));
    }
  } else {
    $offset_start = max($files_name) + $pager;
  }

  $odoo_verify = array(
    'module' => $module,
    'data' => array(),
    'offset_start' => 0,
    'status' => 0,
    'data_count' => $data_count,
    'data_filter' => $data_filter
  );

  if ($offset_start <= $data_count) {
    $odoo_data = $OdooClient->get_list_search($module, $pager, $offset_start, $data_filter, $show_fields);
    unset($odoo_data['status']);

    $json = json_encode($odoo_data, JSON_INVALID_UTF8_SUBSTITUTE);
    file_put_contents(wp_upload_dir()['basedir'] . '/mycasa-odoo-connect/'.$folder.'/'.$offset_start.'.json', $json);

    foreach ($odoo_data as $data) {
      if ($data['name']) {
        array_push($odoo_verify['data'], 'ID: ' . $data['id'] . ', Name: ' . $data['name']);
      } else {
        array_push($odoo_verify['data'], $data['id']);
      }
    }

    $odoo_data = null;
    $json = null;
    gc_collect_cycles();//add this line here
    $odoo_verify['status'] = 1;
    $odoo_verify['offset_start'] = $offset_start + $pager;
  } else {
    $odoo_verify['status'] = 0;
    $odoo_verify['offset_start'] = 0;
  }

  $result = json_encode(array(
    'odoo_verify' => $odoo_verify
  ), JSON_INVALID_UTF8_SUBSTITUTE);
  echo $result;

  wp_die();
}

// Ajax remove data
add_action( 'wp_ajax_mycasa_to_odoo_remove_data', 'mycasa_to_odoo_remove_data' );
function mycasa_to_odoo_remove_data() {
  $values = $_REQUEST;

  $data_type = $values['data_type'];

  if ($data_type == 'property_feature' || $data_type == 'property_tag') {
    $terms = new WP_Term_Query( array(
      'taxonomy'    => $data_type,
      'hide_empty'  => false
    ) );

    if (count($terms->terms) > 0) {
      foreach ( $terms->terms as $term ) {
        wp_delete_term( $term->term_id, $data_type);
      }
      $remove_status = 1;
    } else {
      $remove_status = 0;
    }
  } else {
    $post_count = wp_count_posts($data_type);

    $public_count = $post_count->publish;

    /*while ($public_count > 0) {
      $args_post = array(
        'numberposts' => 200,
        'post_type'   => $data_type,
        'fields'      => 'ids'
      );
      $posts = get_posts($args_post);
      foreach ($posts as $post) {
        wp_delete_post($post, true);
      }
      wp_reset_query();

      $public_count = (int)$public_count - 200;
    }*/

    if ($public_count > 0) {
      $args_post = array(
        'numberposts' => 50,
        'post_type'   => $data_type,
        'fields'      => 'ids'
      );
      $posts = get_posts($args_post);
      foreach ($posts as $post) {
        wp_delete_post($post, true);
      }
      wp_reset_query();
      $remove_status = 1;
    } else {
      $remove_status = 0;
    }
  }

  $result = json_encode(array(
    'remove_status' => $remove_status
  ), JSON_INVALID_UTF8_SUBSTITUTE);
  echo $result;

  wp_die();
}

// Ajax clean data
add_action( 'wp_ajax_mycasa_to_odoo_clean_data', 'mycasa_to_odoo_clean_data' );
function mycasa_to_odoo_clean_data() {
  $values = $_REQUEST;

  $data_type = $values['data_type'];
  $data_module = $values['data_module'];

  // Odoo Informations
  $odoo_options = get_option('mycasa_connect_odoo_board_settings');
  $odoo_url = $odoo_options['mycasa_connect_odoo_url'];
  $odoo_db = $odoo_options['mycasa_connect_odoo_db'];
  $odoo_username = $odoo_options['mycasa_connect_odoo_username'];
  $odoo_password = $odoo_options['mycasa_connect_odoo_password'];

  $OdooClient = new MyCasa_Odoo_client($odoo_url, $odoo_db, $odoo_username, $odoo_password);

  $odoo_data = $OdooClient->get_list_search($data_module, null, null, array(), array('id'));

  $data_ids = array_column($odoo_data, 'id');

  $posts_title = array();

  $args = array(
    'post_type'   => $data_type,
    'post_status' => 'publish',
    'numberposts' => -1,
    'meta_query'  => array(
      'relation' => 'AND',
    )
  );

  switch ($data_type) {
    case 'project':
      array_push($args['meta_query'], array(
        'key' => 'project_id',
        'type' => 'NUMERIC',
        'value' => $data_ids,
        'compare' => 'NOT IN'
      ));
      break;

    case 'property':
      array_push($args['meta_query'], array(
        'key' => 'fave_property_id',
        'type' => 'NUMERIC',
        'value' => $data_ids,
        'compare' => 'NOT IN'
      ));
      break;
  }

  $posts_data = get_posts($args);

  if ( $posts_data  ) {
    foreach ($posts_data as $post) {
      array_push($posts_title, $post->post_title);
      wp_delete_post($post->ID, true);
    }
    wp_reset_query();
  }

  $result = json_encode(array(
    'remove_status' => $posts_title
  ), JSON_INVALID_UTF8_SUBSTITUTE);
  echo $result;

  wp_die();
}

// Ajax Import data
add_action( 'wp_ajax_mycasa_to_odoo_import_data', 'mycasa_to_odoo_import_data' );
function mycasa_to_odoo_import_data() {
  $values = $_REQUEST;

  $data_type = $values['data_type'];
  $data_number = $values['data_number'];

  $data_resulf = null;

  switch ($data_type) {
    case 'odoo_picture':
      $batch_import_data= new MyCasaToOdooImportPicture();
      break;

    case 'odoo_document':
      $batch_import_data = new MyCasaToOdooImportDocument();
      break;

    case 'property_tag':
      $batch_import_data = new MyCasaToOdooImportTags();
      break;

    case 'property_feature':
      $batch_import_data = new MyCasaToOdooImportAmenity();
      break;

    case 'project':
      $batch_import_data = new MyCasaToOdooImportProject();
      break;

    case 'property':
      $batch_import_data = new MyCasaToOdooImportProperties();
      break;
  }
  
  $data_resulf = $batch_import_data->process((int)$data_number);

  if ($data_resulf != false) {
    $import_status = 1;
  } else {
    $import_status = 0;
  }

  $batch_import_data = null;

  $result = json_encode(array(
    'import_status' => $import_status,
    'data_resulf' => $data_resulf
  ), JSON_INVALID_UTF8_SUBSTITUTE);
  echo $result;

  wp_die();
}

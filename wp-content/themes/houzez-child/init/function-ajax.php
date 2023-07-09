<?php

/*
 * Project Search Autocomplete Callback
 */
add_action( 'wp_ajax_mycasa_project_get_auto_complete_search', 'houzez_child_project_get_auto_complete_search' );
add_action( 'wp_ajax_nopriv_mycasa_project_get_auto_complete_search', 'houzez_child_project_get_auto_complete_search' );
function houzez_child_project_get_auto_complete_search() {
  $values = $_REQUEST;

  $content = do_shortcode('[project_search_autocomplete key="'.$values['key'].'"]');

  $result = json_encode($content, JSON_HEX_QUOT | JSON_HEX_TAG);
  echo $result;
  wp_die();
}

/*
 * ACF get Properties by Agents
 */
add_action( 'wp_ajax_acf_get_properties_by_agent', 'houzez_child_acf_get_properties_by_agent' );
function houzez_child_acf_get_properties_by_agent() {
  $values = $_REQUEST;

  if ($values['current_agent'] != 'None' || $values['current_agent'] != '') {
    $content = '<option value="None" selected>' . __('None', 'houzez_child') . '</option>';
  } else {
    $content = '<option value="None">' . __('None', 'houzez_child') . '</option>';
  }
  $agent_vals = houzez_child_get_meta_values('fave_create-uid');

  foreach ($agent_vals as $agent) {
    if ($agent == $values['current_agent']) {
      $content .= '<option value="' . $agent . '" selected>' . $agent . '</option>';
    } else {
      $content .= '<option value="' . $agent . '">' . $agent . '</option>';
    }
  }

  $result = json_encode($content, JSON_HEX_QUOT | JSON_HEX_TAG);
  echo $result;
  wp_die();
}

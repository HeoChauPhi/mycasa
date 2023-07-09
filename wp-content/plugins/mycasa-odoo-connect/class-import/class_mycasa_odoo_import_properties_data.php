<?php
/**
 * Import data from Odoo
 */
if ( class_exists( 'WP_Batch' ) ) {
  class MyCasaOdooImportProperties extends WP_Batch {
    /**
     * Unique identifier of each batch
     * @var string
     */
    public $id = 'mycasa_to_odoo_import_properties';

    /**
     * Describe the batch
     * @var string
     */
    public $title = 'Mycasa import Properties (Appartment) from Odoo';

    /* Import process */
    public function import_property() {
      $property_data = mycasa_to_odoo_get_json_data('property');

      if ($property_data) {

        foreach ($property_data as $property) {
          $args_property = array(
            'numberposts' => -1,
            'post_type'   => 'property',
            'meta_key'    => 'fave_property_id',
            'meta_value'  => $property['id'],
            'fields'      => 'ids'
          );

          $property_exited = get_posts($args_property);
          wp_reset_query();

          $args_new_property = array(
            'post_title'    => $property['code'],
            'post_status'   => 'publish',
            'post_type'     => 'property',
            'post_content'  => $property['description']
          );

          if (!empty($property_exited)) {
            $property_postid = $property_exited[0];
            $this->import_property_fields($property, $property_postid);
          } else {
            $property_postid = wp_insert_post($args_new_property);
            $this->import_property_fields($property, $property_postid);
          }
        }
      }
    }

    public function import_property_fields($property_data, $property_id) {
      $odoo_options = get_option('mycasa_connect_odoo_board_settings');
      $odoo_url = $odoo_options['mycasa_connect_odoo_url'];
    
      $post_field = array(
        'ID'           => $property_id,
        'post_title'   => $property_data['code'],
        'post_content' => $property_data['description'],
      );

      wp_update_post( $post_field );

      foreach ($property_data as $field_slug => $field_value) {
        $field_slug_web = 'fave_' . str_replace('_', '-', $field_slug);

        switch ($field_slug) {
          // Update Taxonomies
          case 'status':
            if ($field_value) {
              $this->get_term_from_fields($field_value, 'property_status', $property_id);
            }
            break;

          case 'type_id':
            if ($field_value) {
              $this->get_term_from_fields($field_value[1], 'property_type', $property_id);
            }
            break;

          case 'amenity_ids':
            if ($field_value) {
              $this->get_term_from_fields($field_value, 'property_feature', $property_id, 'amenity_id');
            }
            break;

          case 'direction':
            if ($field_value) {
              $this->get_term_from_fields($field_value, 'property_area', $property_id);
            }
            break;

          // Update Custom fields
          case 'id':
            update_post_meta($property_id, 'fave_property_id', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
            break;

          case 'name':
            if ($field_value) {
              update_post_meta($property_id, 'fave_code', $field_value);
            }
            break;

          case 'project_id':
            if ($field_value) {
              $args_project = array(
                'numberposts' => -1,
                'post_type'   => 'project',
                'meta_key'    => 'project_id',
                'meta_value'  => htmlentities($field_value[0], ENT_SUBSTITUTE, 'UTF-8'),
                'fields'      => 'ids'
              );

              $project_exited = get_posts($args_project);
              if (!empty($project_exited)) {
                $project_id = $project_exited[0];
                update_field('project_id', $project_exited, $property_id);

                $address = get_field('full_address', $project_id);
                update_post_meta($property_id, 'fave_property_map_address', $address['address']);
                update_post_meta($property_id, 'fave_property_location', $address['lat'].','.$address['lng']);

                $street = get_field('street', $project_id);
                update_post_meta($property_id, 'fave_property_address', $street);

                $zip_code = get_field('zip', $project_id);
                update_post_meta($property_id, 'fave_property_zip', $zip_code);

                $project_title = get_the_title($project_id);
                update_post_meta($property_id, 'fave_project-name', $project_title);

                $hand_over_date = get_field('hand_over_date', $project_id);
                update_post_meta($property_id, 'fave_property_year', $hand_over_date);

                // Update contact taxonomies
                $country = get_field('country_id', $project_id);
                $this->get_term_from_fields($country, 'property_country', $property_id);

                $state = get_field('state_id', $project_id);
                $this->get_term_from_fields($state, 'property_state', $property_id);

                $city = get_field('city_id', $project_id);
                $this->get_term_from_fields($city, 'property_city', $property_id);
              }
              wp_reset_query();
            }
            break;

          case 'size_sqm':
            if ($field_value) {
              update_post_meta($property_id, 'fave_property_size', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
            }
            break;

          case 'bedroom_number':
            if ($field_value) {
              update_post_meta($property_id, 'fave_property_bedrooms', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
            }
            break;
            
          case 'rent_usd':
            if (!empty($field_value)) {
              update_post_meta($property_id, 'fave_property_price', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
              $this->get_term_from_fields('Lease', 'property_label', $property_id);
            } else {
              update_post_meta($property_id, 'fave_property_price', 0);
              wp_set_post_terms($property_id, array(), 'property_label');
            }
            break;

          case 'resale_usd':
            if (!empty($field_value)) {
              update_post_meta($property_id, 'fave_resale-usd', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
              $this->get_term_from_fields('Resell', 'property_label', $property_id);
            } else {
              update_post_meta($property_id, 'fave_resale-usd', 0);
              wp_set_post_terms($property_id, array(), 'property_label');
            }
            break;

          case 'is_foreign_quota':
          case 'is_cooperation':
          case 'living':
            if ($field_value) {
              update_post_meta($property_id, $field_slug_web, 'Yes');
            } else {
              update_post_meta($property_id, $field_slug_web, 'No');
            }
            break;

          case 'public_image_urls':
            if ($field_value) {
              $pictures = array();

              $images_arr = explode(',', $field_value);

              foreach ($images_arr as $value) {
                $picture_path = $odoo_url . trim($value);
                $pictures[] = array(
                  'picture_attachement_ids' => $picture_path
                );
              }
              update_field( 'gallery_url', $pictures, $property_id );
            }
            break;

          case 'owner_partner_id':
          case 'tenant':
          case 'create_uid':
          case 'write_uid':
            if (is_array($field_value)) {
              update_post_meta($property_id, $field_slug_web, htmlentities($field_value[1], ENT_SUBSTITUTE, 'UTF-8'));
            }
            break;

          case '__last_update':
            if ($field_value) {
              update_post_meta($property_id, 'fave_last-update', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
            }
            break;

          default:
            if ($field_value) {
              update_post_meta($property_id, $field_slug_web, $field_value);
            }
            break;
        }
      }

      /*$test_additional_features = array(
        array(
          'fave_additional_feature_title' => 'Title 1',
          'fave_additional_feature_value' => 'Value 1'
        )
      );*/

      update_post_meta($property_id, 'fave_property_price_postfix', 'mo');
      update_post_meta($property_id, 'fave_property_size_prefix', 'sqm');
      update_post_meta($property_id, 'fave_property_map', 1);
      update_post_meta($property_id, 'fave_property_map_street_view', 'show');
      update_post_meta($property_id, 'fave_featured', 0);
      update_post_meta($property_id, 'fave_loggedintoview', 0);
      update_post_meta($property_id, 'fave_agent_display_option', 'author_info');
      update_post_meta($property_id, 'fave_prop_homeslider', 'no');
      //update_post_meta($property_id, 'additional_features', $test_additional_features);
    }

    public function get_term_from_fields($field_slug, $tax_slug, $postid, $meta_key = null) {
      if (is_array($field_slug)) { // Get exited terms
        $term_ids = array();
        $term_query = new WP_Term_Query( array(
          'taxonomy'    => $tax_slug,
          'hide_empty'  => false,
          'meta_key' => $meta_key,
          'meta_value' => $field_slug
        ) );

        if (!empty($term_query->terms) && is_array($term_query->terms)) {
          $term_ids = array_column($term_query->terms, 'term_id');
          wp_set_post_terms($postid, array_map('intval', $term_ids), $tax_slug, true);
        }
      } elseif (is_string($field_slug)) { // Find exited terms, if not have then add new term
        $term_id = null;
        $term_key = null;

        $term_slug = mycasa_to_odoo_stripvn($field_slug);
        $term_slug = mb_strtolower($term_slug, 'UTF-8');
        $term_slug = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $term_slug);
        $term_slug = str_replace(' ', '-', $term_slug);

        $term_query = new WP_Term_Query( array(
          'taxonomy'    => $tax_slug,
          'hide_empty'  => false
        ) );

        if (!empty($term_query->terms) && is_array($term_query->terms)) {
          $term_key = array_search($term_slug, array_column($term_query->terms, 'slug'));
        }

        if (!empty($term_key) || $term_key === 0 ) {
          $term_id = $term_query->terms[$term_key]->term_id;
          wp_set_post_terms($postid, array_map('intval',array($term_id)), $tax_slug, true);
        } else {
          $new_term = wp_insert_term(
            ucwords($field_slug),   // the term 
            $tax_slug, // the taxonomy
            array(
              'slug' => $term_slug
            )
          );
          if (is_array($new_term)) {
            $term_id = $new_term['term_id'];
            wp_set_post_terms($postid, array_map('intval',array($term_id)), $tax_slug, true);
          }
        }
      }
    }

    /* Batch process */

    /**
     * To setup the batch data use the push() method to add WP_Batch_Item instances to the queue.
     *
     * Note: If the operation of obtaining data is expensive, cache it to avoid slowdowns.
     *
     * @return void
     */
    public function setup() {
      $property_data = mycasa_to_odoo_get_json_data('property');

      if ($property_data) {
        foreach ($property_data as $property) {
          $this->push( new WP_Batch_Item(
            $property['id'] . ': ' . $property['code'],
            $property
          ));
        }
      }
    }

    /**
     * Handles processing of batch item. One at a time.
     *
     * In order to work it correctly you must return values as follows:
     *
     * - TRUE - If the item was processed successfully.
     * - WP_Error instance - If there was an error. Add message to display it in the admin area.
     *
     * @param WP_Batch_Item $item
     *
     * @return bool|\WP_Error
     */
    public function process( $item ) {
      $args_property = array(
        'numberposts' => -1,
        'post_type'   => 'property',
        'meta_key'    => 'fave_property_id',
        'meta_value'  => $item->get_value('id'),
        'fields'      => 'ids'
      );

      $property_exited = get_posts($args_property);
      wp_reset_query();

      $args_new_property = array(
        'post_title'    => $item->get_value('code'),
        'post_status'   => 'publish',
        'post_type'     => 'property',
        'post_content'  => $item->get_value('description')
      );

      if (!empty($property_exited)) {
        $property_postid = $property_exited[0];
        $this->import_property_fields($item->data, $property_postid);
      } else {
        $property_postid = wp_insert_post($args_new_property);
        $this->import_property_fields($item->data, $property_postid);
      }

      return true;
    }

    /**
     * Called when specific process is finished (all items were processed).
     * This method can be overriden in the process class.
     * @return void
     */
    public function finish() {
      // Do something after process is finished.
      // You have $this->items, or other data you can set.
      return 'importted items';
    }
  }

  function odoo_import_properties() {
    $import_data = new MyCasaOdooImportProperties();
    $OdooImport = $import_data->import_property();
    //$OdooRemove = $import_data->remove_odo_data('property');
  }
  //add_action('init', 'odoo_import_properties');

  /**
   * Initialize the batches.
   */
  function mycasa_import_properties_batch_processing_init() {
    $batch_import_propreties = new MyCasaOdooImportProperties();
    WP_Batch_Processor::get_instance()->register( $batch_import_propreties );
  }

  add_action( 'wp_batch_processing_init', 'mycasa_import_properties_batch_processing_init', 23, 1 );
}

/**
 * MyCasaToOdooImportProperties
 */
class MyCasaToOdooImportProperties {

  public function import_property_fields($property_data, $property_id) {
    $odoo_options = get_option('mycasa_connect_odoo_board_settings');
    $odoo_url = $odoo_options['mycasa_connect_odoo_url'];

    $post_field = array(
      'ID'           => $property_id,
      'post_title'   => $property_data['code'],
      'post_content' => $property_data['description'],
    );

    wp_update_post( $post_field );

    foreach ($property_data as $field_slug => $field_value) {
      $field_slug_web = 'fave_' . str_replace('_', '-', $field_slug);

      switch ($field_slug) {
        // Update Taxonomies
        case 'status':
          if ($field_value) {
            $this->get_term_from_fields($field_value, 'property_status', $property_id);
          }
          break;

        case 'type_id':
          if ($field_value) {
            $this->get_term_from_fields($field_value[1], 'property_type', $property_id);
          }
          break;

        case 'amenity_ids':
          if ($field_value) {
            $this->get_term_from_fields($field_value, 'property_feature', $property_id, 'amenity_id');
          }
          break;

        case 'tag_ids':
          if ($field_value) {
            $this->get_term_from_fields($field_value, 'property_tag', $property_id, 'property_tag_id');
            update_post_meta($property_id, 'fave_featured', 1);
          } else {
            update_post_meta($property_id, 'fave_featured', 0);
          }
          break;

        case 'direction':
          if ($field_value) {
            $this->get_term_from_fields($field_value, 'property_area', $property_id);
          }
          break;

        // Update Custom fields
        case 'id':
          update_post_meta($property_id, 'fave_property_id', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
          break;

        case 'name':
          if ($field_value) {
            update_post_meta($property_id, 'fave_code', $field_value);
          }
          break;

        case 'project_id':
          if ($field_value) {
            $args_project = array(
              'numberposts' => -1,
              'post_type'   => 'project',
              'meta_key'    => 'project_id',
              'meta_value'  => htmlentities($field_value[0], ENT_SUBSTITUTE, 'UTF-8'),
              'fields'      => 'ids'
            );

            $project_exited = get_posts($args_project);
            if (!empty($project_exited)) {
              $project_id = $project_exited[0];
              update_field('project_id', $project_exited, $property_id);

              $address = get_field('full_address', $project_id);
              update_post_meta($property_id, 'fave_property_map_address', $address['address']);
              update_post_meta($property_id, 'fave_property_location', $address['lat'].','.$address['lng']);

              $street = get_field('street', $project_id);
              update_post_meta($property_id, 'fave_property_address', $street);

              $zip_code = get_field('zip', $project_id);
              update_post_meta($property_id, 'fave_property_zip', $zip_code);

              $project_title = get_the_title($project_id);
              update_post_meta($property_id, 'fave_project-name', $project_title);

              $hand_over_date = get_field('hand_over_date', $project_id);
              update_post_meta($property_id, 'fave_property_year', $hand_over_date);

              // Update contact taxonomies
              $country = get_field('country_id', $project_id);
              $this->get_term_from_fields($country, 'property_country', $property_id);

              $state = get_field('state_id', $project_id);
              $this->get_term_from_fields($state, 'property_state', $property_id);

              $city = get_field('city_id', $project_id);
              $this->get_term_from_fields($city, 'property_city', $property_id);
            }
            wp_reset_query();
          }
          break;

        case 'size_sqm':
          if ($field_value) {
            update_post_meta($property_id, 'fave_property_size', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
          }
          break;

        case 'bedroom_number':
          if ($field_value) {
            update_post_meta($property_id, 'fave_property_bedrooms', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
          }
          break;

        case 'rent_usd':
          if (!empty($field_value)) {
            update_post_meta($property_id, 'fave_property_price', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
            $this->get_term_from_fields('Lease', 'property_label', $property_id);
          } else {
            update_post_meta($property_id, 'fave_property_price', 0);
            wp_remove_object_terms($property_id, 'lease', 'property_label');
          }
          break;

        case 'resale_usd':
          if (!empty($field_value)) {
            update_post_meta($property_id, 'fave_resale-usd', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
            $this->get_term_from_fields('Resell', 'property_label', $property_id);
          } else {
            update_post_meta($property_id, 'fave_resale-usd', 0);
            wp_remove_object_terms($property_id, 'resell', 'property_label');
          }
          break;

        case 'is_foreign_quota':
        case 'is_cooperation':
        case 'living':
          if ($field_value) {
            update_post_meta($property_id, $field_slug_web, 'Yes');
          } else {
            update_post_meta($property_id, $field_slug_web, 'No');
          }
          break;

        case 'public_image_urls':
          if ($field_value) {
            $pictures = array();
            
            $images_arr = explode(',', $field_value);

            foreach ($images_arr as $value) {
              $picture_path = $odoo_url . trim($value);
              $pictures[] = array(
                'picture_attachement_ids' => $picture_path
              );
            }
            update_field( 'gallery_url', $pictures, $property_id );
          }
          break;

        case 'owner_partner_id':
        case 'tenant':
        case 'create_uid':
        case 'write_uid':
          if (is_array($field_value)) {
            update_post_meta($property_id, $field_slug_web, htmlentities($field_value[1], ENT_SUBSTITUTE, 'UTF-8'));
          }
          break;

        case '__last_update':
          if ($field_value) {
            update_post_meta($property_id, 'fave_last-update', htmlentities($field_value, ENT_SUBSTITUTE, 'UTF-8'));
          }
          break;

        default:
          if ($field_value) {
            update_post_meta($property_id, $field_slug_web, $field_value);
          }
          break;
      }
    }

    /*$test_additional_features = array(
      array(
        'fave_additional_feature_title' => 'Title 1',
        'fave_additional_feature_value' => 'Value 1'
      )
    );*/

    update_post_meta($property_id, 'fave_property_price_postfix', 'mo');
    update_post_meta($property_id, 'fave_property_size_prefix', 'sqm');
    update_post_meta($property_id, 'fave_property_map', 1);
    update_post_meta($property_id, 'fave_property_map_street_view', 'show');
    update_post_meta($property_id, 'fave_loggedintoview', 0);
    update_post_meta($property_id, 'fave_agent_display_option', 'author_info');
    update_post_meta($property_id, 'fave_prop_homeslider', 'no');
    //update_post_meta($property_id, 'additional_features', $test_additional_features);
  }

  public function get_term_from_fields($field_slug, $tax_slug, $postid, $meta_key = null) {
    if (is_array($field_slug)) { // Get exited terms
      $term_ids = array();
      $term_query = new WP_Term_Query( array(
        'taxonomy'    => $tax_slug,
        'hide_empty'  => false,
        'meta_key' => $meta_key,
        'meta_value' => $field_slug
      ) );

      if (!empty($term_query->terms) && is_array($term_query->terms)) {
        $term_ids = array_column($term_query->terms, 'term_id');
        wp_set_post_terms($postid, array_map('intval', $term_ids), $tax_slug, true);
      }
    } elseif (is_string($field_slug)) { // Find exited terms, if not have then add new term
      $term_id = null;
      $term_key = null;

      $term_slug = mycasa_to_odoo_stripvn($field_slug);
      $term_slug = mb_strtolower($term_slug, 'UTF-8');
      $term_slug = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $term_slug);
      $term_slug = str_replace(' ', '-', $term_slug);

      $term_query = new WP_Term_Query( array(
        'taxonomy'    => $tax_slug,
        'hide_empty'  => false
      ) );

      if (!empty($term_query->terms) && is_array($term_query->terms)) {
        $term_key = array_search($term_slug, array_column($term_query->terms, 'slug'));
      }

      if (!empty($term_key) || $term_key === 0 ) {
        $term_id = $term_query->terms[$term_key]->term_id;
        wp_set_post_terms($postid, array_map('intval',array($term_id)), $tax_slug, true);
      } else {
        $new_term = wp_insert_term(
          ucwords($field_slug),   // the term 
          $tax_slug, // the taxonomy
          array(
            'slug' => $term_slug
          )
        );
        if (is_array($new_term)) {
          $term_id = $new_term['term_id'];
          wp_set_post_terms($postid, array_map('intval',array($term_id)), $tax_slug, true);
        }
      }
    }
  }
  
  public function process($number) {
    $data = mycasa_to_odoo_get_json_data('property')[$number];

    if ($data) {
      $args_property = array(
        'numberposts' => -1,
        'post_type'   => 'property',
        'meta_key'    => 'fave_property_id',
        'meta_value'  => $data['id'],
        'fields'      => 'ids'
      );

      $property_exited = get_posts($args_property);
      wp_reset_query();

      if (!empty($property_exited)) {
        $property_postid = $property_exited[0];
        $this->import_property_fields($data, $property_postid);
      } else {
        $args_new_property = array(
          'post_title'    => $data['code'],
          'post_status'   => 'publish',
          'post_type'     => 'property',
          'post_content'  => $data['description']
        );
        
        $property_postid = wp_insert_post($args_new_property);
        $this->import_property_fields($data, $property_postid);
      }

      return $data['code'];
    } else {
      return false;
    }
  }
}

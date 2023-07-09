<?php
/**
 * Import data from Odoo
 */
if ( class_exists( 'WP_Batch' ) ) {
  class MyCasaOdooImportProject extends WP_Batch {
    /**
     * Unique identifier of each batch
     * @var string
     */
    public $id = 'mycasa_to_odoo_import_project';

    /**
     * Describe the batch
     * @var string
     */
    public $title = 'Mycasa import Projects from Odoo';

    /* Import process */
    public function import_project() {
      $project_data = mycasa_to_odoo_get_json_data('project');

      if ($project_data) {
        foreach ($project_data as $project) {
          $args_project = array(
            'numberposts' => -1,
            'post_type'   => 'project',
            'meta_key'    => 'project_id',
            'meta_value'  => $project['id'],
            'fields'      => 'ids'
          );

          $project_exited = get_posts($args_project);
          wp_reset_query();

          $args_new_project = array(
            'post_title'    => $project['name'],
            'post_status'   => 'publish',
            'post_type'     => 'project',
            'post_content'  => $project['description']
          );

          if (!empty($project_exited)) {
            $project_postid = $project_exited[0];
            $this->import_project_fields($project, $project_postid);
          } else {
            $project_postid = wp_insert_post($args_new_project);
            $this->import_project_fields($project, $project_postid);
          }
        }
      }
    }

    public function import_project_fields($project_data, $project_id) {
      $odoo_options = get_option('mycasa_connect_odoo_board_settings');
      $odoo_url = $odoo_options['mycasa_connect_odoo_url'];
      
      $post_field = array(
        'ID'           => $project_id,
        'post_title'   => $project_data['name'],
        'post_content' => $project_data['description'],
      );

      wp_update_post( $post_field );

      foreach ($project_data as $field_slug => $field_value) {
        switch ($field_slug) {
          // Update Taxonomy
          case 'type':
            if ($field_value) {
              $this->get_term_from_fields($field_value, 'project_type', $project_id);
            }
            break;

          // Update Custom fields
          case 'id':
            update_field('project_id', $field_value, $project_id);
            break;

          case 'amenity_ids':
            if ($field_value) {
              $this->get_term_from_fields($field_value, 'property_feature', $project_id, 'amenity_id');
            }
            break;

          case 'developer_id':
            if ($field_value) {
              update_field('developer_id', $field_value[0], $project_id);
              update_field('developer_name', $field_value[1], $project_id);
            }
            break;

          case 'avg_unit_price_sqm_usd':
          case 'avg_unit_price_sqm_vnd':
            if ($field_value) {
              update_field($field_slug, $field_value, $project_id);
            } else {
              update_field($field_slug, (int)0, $project_id);
            }
            break;

          case 'hand_over_date':
            if ($field_value) {
              $year = date('Y', strtotime($field_value));

              update_field($field_slug, $field_value, $project_id);
              update_field('hand_over_year', $year, $project_id);
            }
            break;

          case 'create_uid':
            if ($field_value) {
              update_field('create_uid', $field_value[0], $project_id);
              update_field('create_name', $field_value[1], $project_id);
            }
            break;

          case 'write_uid':
            if ($field_value) {
              update_field('write_uid', $field_value[0], $project_id);
              update_field('write_name', $field_value[1], $project_id);
            }
            break;

          case 'city_id':
          case 'district_id':
          case 'state_id':
          case 'country_id':
            if ($field_value) {
              update_field($field_slug, $field_value[1], $project_id);
            }
            break;
          
          case 'full_address':
            if ($field_value) {
              $full_address = str_replace(array("\r","\n")," ",$field_value);

              $map_value = mycasa_to_odoo_gmap_latlng($full_address);
              update_field($field_slug, $map_value, $project_id);
            }
            break;

          case 'project_public_image_urls':
            if ($field_value) {
              $pictures = array();
            
              $images_arr = explode(',', $field_value);

              foreach ($images_arr as $value) {
                $picture_path = $odoo_url . trim($value);
                $pictures[] = array(
                  'picture_attachement_ids' => $picture_path
                );
              }
              update_field( 'gallery_url', $pictures, $project_id );
            }
            break;

          case 'document_ids':
            if ($field_value) {
              $documents = array();

              $args_document = array(
                'numberposts' => -1,
                'post_type'   => 'odoo_document',
                'meta_key'    => 'document_id',
                'meta_value'  => $field_value,
                'fields'      => 'ids'
              );

              $document_exited = get_posts($args_document);

              if ($document_exited) {
                foreach ($document_exited as $postid) {
                  $documents[] = array(
                    'document_id' => $postid
                  );
                }
                update_field( 'document_ids', $documents, $project_id );
              }
              wp_reset_query();
            }
            break;

          default:
            if ($field_value) {
              update_field($field_slug, $field_value, $project_id);
            }
            break;
        }
      }
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
      $project_data = mycasa_to_odoo_get_json_data('project');

      if ($project_data) {
        foreach ($project_data as $project) {
          $this->push( new WP_Batch_Item(
            $project['id'] . ': ' . $project['name'],
            $project
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
      $args_project = array(
        'numberposts' => -1,
        'post_type'   => 'project',
        'meta_key'    => 'project_id',
        'meta_value'  => $item->get_value('id'),
        'fields'      => 'ids'
      );

      $project_exited = get_posts($args_project);
      wp_reset_query();

      if (!empty($project_exited)) {
        $project_postid = $project_exited[0];
        $this->import_project_fields($item->data, $project_postid);
      } else {
        $args_new_project = array(
          'post_title'    => $item->get_value('name'),
          'post_status'   => 'publish',
          'post_type'     => 'project',
          'post_content'  => $item->get_value('description')
        );
        
        $project_postid = wp_insert_post($args_new_project);
        $this->import_project_fields($item->data, $project_postid);
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

  // function odoo_import_project() {
  //   $import_data = new MyCasaOdooImportProject();
  //   $OdooImport = $import_data->import_project();
  //   //$OdooRemove = $import_data->remove_odo_data('project');
  // }
  // add_action('init', 'odoo_import_project');

  /**
   * Initialize the batches.
   */
  function mycasa_import_project_batch_processing_init() {
    $batch_import_projects = new MyCasaOdooImportProject();
    WP_Batch_Processor::get_instance()->register( $batch_import_projects );
  }

  add_action( 'wp_batch_processing_init', 'mycasa_import_project_batch_processing_init', 21, 1 );
}

/**
 * MyCasaToOdooImportProject
 */
class MyCasaToOdooImportProject {
  
  public function import_project_fields($project_data, $project_id) {
    $odoo_options = get_option('mycasa_connect_odoo_board_settings');
    $odoo_url = $odoo_options['mycasa_connect_odoo_url'];

    $post_field = array(
      'ID'           => $project_id,
      'post_title'   => $project_data['name'],
      'post_content' => $project_data['description'],
    );

    wp_update_post( $post_field );

    foreach ($project_data as $field_slug => $field_value) {
      switch ($field_slug) {
        // Update Taxonomy
        case 'type':
          if ($field_value) {
            $this->get_term_from_fields($field_value, 'project_type', $project_id);
          }
          break;

        // Update Custom fields
        case 'id':
          update_field('project_id', $field_value, $project_id);
          break;

        case 'amenity_ids':
          if ($field_value) {
            $this->get_term_from_fields($field_value, 'property_feature', $project_id, 'amenity_id');
          }
          break;

        case 'developer_id':
          if ($field_value) {
            update_field('developer_id', $field_value[0], $project_id);
            update_field('developer_name', $field_value[1], $project_id);
          }
          break;

        case 'avg_unit_price_sqm_usd':
        case 'avg_unit_price_sqm_vnd':
          if ($field_value) {
            update_field($field_slug, $field_value, $project_id);
          } else {
            update_field($field_slug, (int)0, $project_id);
          }
          break;

        case 'hand_over_date':
          if ($field_value) {
            $year = date('Y', strtotime($field_value));

            update_field($field_slug, $field_value, $project_id);
            update_field('hand_over_year', $year, $project_id);
          }
          break;

        case 'create_uid':
          if ($field_value) {
            update_field('create_uid', $field_value[0], $project_id);
            update_field('create_name', $field_value[1], $project_id);
          }
          break;

        case 'write_uid':
          if ($field_value) {
            update_field('write_uid', $field_value[0], $project_id);
            update_field('write_name', $field_value[1], $project_id);
          }
          break;

        case 'city_id':
        case 'district_id':
        case 'state_id':
        case 'country_id':
          if ($field_value) {
            update_field($field_slug, $field_value[1], $project_id);
          }
          break;
        
        case 'full_address':
          if ($field_value) {
            $full_address = str_replace(array("\r","\n")," ",$field_value);

            $map_value = mycasa_to_odoo_gmap_latlng($full_address);
            update_field($field_slug, $map_value, $project_id);
          }
          break;

        case 'project_public_image_urls':
          if ($field_value) {
            $pictures = array();

            $images_arr = explode(',', $field_value);

            foreach ($images_arr as $value) {
              $picture_path = $odoo_url . trim($value);
              $pictures[] = array(
                'picture_attachement_ids' => $picture_path
              );
            }
            update_field( 'gallery_url', $pictures, $project_id );
          }
          break;

        case 'document_ids':
          if ($field_value) {
            $documents = array();

            $args_document = array(
              'numberposts' => -1,
              'post_type'   => 'odoo_document',
              'meta_key'    => 'document_id',
              'meta_value'  => $field_value,
              'fields'      => 'ids'
            );

            $document_exited = get_posts($args_document);

            if ($document_exited) {
              foreach ($document_exited as $postid) {
                $documents[] = array(
                  'document_id' => $postid
                );
              }
              update_field( 'document_ids', $documents, $project_id );
            }
            wp_reset_query();
          }
          break;

        default:
          if ($field_value) {
            update_field($field_slug, $field_value, $project_id);
          }
          break;
      }
    }
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
    $data = mycasa_to_odoo_get_json_data('project')[$number];

    if ($data) {
      $args_project = array(
        'numberposts' => -1,
        'post_type'   => 'project',
        'meta_key'    => 'project_id',
        'meta_value'  => $data['id'],
        'fields'      => 'ids'
      );

      $project_exited = get_posts($args_project);
      wp_reset_query();

      if (!empty($project_exited)) {
        $project_postid = $project_exited[0];
        $this->import_project_fields($data, $project_postid);
      } else {
        $args_new_project = array(
          'post_title'    => $data['name'],
          'post_status'   => 'publish',
          'post_type'     => 'project',
          'post_content'  => $data['description']
        );

        $project_postid = wp_insert_post($args_new_project);
        $this->import_project_fields($data, $project_postid);
      }
      
      return $data['name'];
    } else {
      return false;
    }
  }
}

<?php
/********************************************************************
 * Copyright (C) 2019 Darko Gjorgjijoski (https://darkog.com)
 *
 * This file is part of WP Batch Processing
 *
 * WP Batch Processing is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * WP Batch Processing is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WP Batch Processing. If not, see <https://www.gnu.org/licenses/>.
 **********************************************************************/

if ( class_exists( 'WP_Batch' ) ) {
  /**
   * Class MyCasaOdooImportAmenity
   */
  class MyCasaOdooImportAmenity extends WP_Batch {

    /**
     * Unique identifier of each batch
     * @var string
     */
    public $id = 'mycasa_to_odoo_import_amenity';

    /**
     * Describe the batch
     * @var string
     */
    public $title = 'Mycasa import Amenity from Odoo';

    /**
     * To setup the batch data use the push() method to add WP_Batch_Item instances to the queue.
     *
     * Note: If the operation of obtaining data is expensive, cache it to avoid slowdowns.
     *
     * @return void
     */
    public function setup() {
      $amenity_data = mycasa_to_odoo_get_json_data('amenity');

      if ($amenity_data) {
	      foreach ( $amenity_data as $amenity ) {
	        $this->push( new WP_Batch_Item( $amenity['name'], $amenity) );
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
      $term_id = null;
      $term_key = null;

    	$term_slug = mycasa_to_odoo_stripvn($item->get_value('name'));
      $term_slug = mb_strtolower($term_slug, 'UTF-8');
      $term_slug = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $term_slug);
      $term_slug = str_replace(' ', '-', $term_slug);

      $term_query = new WP_Term_Query( array(
        'taxonomy'    => 'property_feature',
        'hide_empty'  => false
      ) );

      if (!empty($term_query->terms) && is_array($term_query->terms)) {
        $term_key = array_search($term_slug, array_column($term_query->terms, 'slug'));
      }

      if (!empty($term_key) || $term_key === 0 ) {
        $term_id = $term_query->terms[$term_key]->term_id;
        update_field('amenity_id', $item->get_value('id'), 'property_feature_'.$term_id);
      } else {
        $new_term = wp_insert_term(
	        ucwords($item->get_value('name')),   // the term 
	        'property_feature', // the taxonomy
	        array(
	          'slug' => $term_slug
	        )
	      );

	      if (is_array($new_term)) {
	        $term_id = $new_term['term_id'];
	        update_field('amenity_id', $item->get_value('id'), 'property_feature_'.$term_id);
	      }
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
    }

  }

  /**
   * Initialize the batches.
   */
  function mycasa_import_amenity_batch_processing_init() {
    $batch_import_amenity = new MyCasaOdooImportAmenity();
    WP_Batch_Processor::get_instance()->register( $batch_import_amenity );
  }

  add_action( 'wp_batch_processing_init', 'mycasa_import_amenity_batch_processing_init', 15, 1 );
}

/**
 * MyCasaToOdooImportAmenity
 */
class MyCasaToOdooImportAmenity {

  public function process($number) {
    $data = mycasa_to_odoo_get_json_data('amenity')[$number];

    if ($data) {
      $term_id = null;
      $term_key = null;

      $term_slug = mycasa_to_odoo_stripvn($data['name']);
      $term_slug = mb_strtolower($term_slug, 'UTF-8');
      $term_slug = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $term_slug);
      $term_slug = str_replace(' ', '-', $term_slug);

      $term_query = new WP_Term_Query( array(
        'taxonomy'    => 'property_feature',
        'hide_empty'  => false
      ) );

      if (!empty($term_query->terms) && is_array($term_query->terms)) {
        $term_key = array_search($term_slug, array_column($term_query->terms, 'slug'));
      }

      if (!empty($term_key) || $term_key === 0 ) {
        $term_id = $term_query->terms[$term_key]->term_id;
        update_field('amenity_id', $data['id'], 'property_feature_'.$term_id);
      } else {
        $new_term = wp_insert_term(
          ucwords($data['name']),   // the term 
          'property_feature', // the taxonomy
          array(
            'slug' => $term_slug
          )
        );

        if (is_array($new_term)) {
          $term_id = $new_term['term_id'];
          update_field('amenity_id', $data['id'], 'property_feature_'.$term_id);
        }
      }

      return $data['name'];
    } else {
      return false;
    }
  }
}

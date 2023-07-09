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
   * Class MyCasaOdooRemoveAmenity
   */
  class MyCasaOdooRemoveAmenity extends WP_Batch {

    /**
     * Unique identifier of each batch
     * @var string
     */
    public $id = 'mycasa_to_odoo_remove_amenity';

    /**
     * Describe the batch
     * @var string
     */
    public $title = 'Mycasa remove Amenity';

    /**
     * To setup the batch data use the push() method to add WP_Batch_Item instances to the queue.
     *
     * Note: If the operation of obtaining data is expensive, cache it to avoid slowdowns.
     *
     * @return void
     */
    public function setup() {

      //$terms = get_terms('property_feature', array( 'fields' => 'ids', 'hide_empty' => false ) );

      $terms = new WP_Term_Query( array(
        'taxonomy'    => 'property_feature',
        'hide_empty'  => false
      ) );

      if ($terms->terms) {
	      foreach ( $terms->terms as $term ) {
	        $this->push( new WP_Batch_Item( $term->name, array( 'term_id' => $term->term_id ) ) );
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
      wp_delete_term( $item->get_value('term_id'), 'property_feature');
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
  function mycasa_remove_amenity_batch_processing_init() {
    $batch_remove_amenity = new MyCasaOdooRemoveAmenity();
    WP_Batch_Processor::get_instance()->register( $batch_remove_amenity );
  }

  add_action( 'wp_batch_processing_init', 'mycasa_remove_amenity_batch_processing_init', 16, 1 );
}
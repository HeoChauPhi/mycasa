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
	 * Class MyCasaOdooRemovePicture
	 */
	class MyCasaOdooRemovePicture extends WP_Batch {

		/**
		 * Unique identifier of each batch
		 * @var string
		 */
		public $id = 'mycasa_to_odoo_remove_picture';

		/**
		 * Describe the batch
		 * @var string
		 */
		public $title = 'Mycasa remove Picture';

		/**
		 * To setup the batch data use the push() method to add WP_Batch_Item instances to the queue.
		 *
		 * Note: If the operation of obtaining data is expensive, cache it to avoid slowdowns.
		 *
		 * @return void
		 */
		public function setup() {
			$args_post = array(
        'numberposts' => -1,
        'post_type'   => 'odoo_picture',
        'fields'      => 'ids'
      );
      $posts = get_posts($args_post);
      foreach ( $posts as $post ) {
        $this->push( new WP_Batch_Item( get_the_title($post), array('post_id' => $post) ));
      }
      wp_reset_query();
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
      wp_delete_post($item->get_value('post_id'), true);
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
	function mycasa_remove_picture_batch_processing_init() {
		$batch_remove_picture = new MyCasaOdooRemovePicture();
		WP_Batch_Processor::get_instance()->register( $batch_remove_picture );
	}

	add_action( 'wp_batch_processing_init', 'mycasa_remove_picture_batch_processing_init', 18, 1 );
}

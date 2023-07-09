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
	 * Class MyCasaOdooImportDocument
	 */
	class MyCasaOdooImportDocument extends WP_Batch {

		/**
		 * Unique identifier of each batch
		 * @var string
		 */
		public $id = 'mycasa_to_odoo_import_document';

		/**
		 * Describe the batch
		 * @var string
		 */
		public $title = 'Mycasa import Document from Odoo';

		/**
		 * Function import custom fields
		 */
		public function import_data_fields($field_data, $postid) {
      $odoo_options = get_option('mycasa_connect_odoo_board_settings');
      $odoo_url = $odoo_options['mycasa_connect_odoo_url'];

      foreach ($field_data as $field_slug => $field_value) {
        switch ($field_slug) {
        	case 'id':
        		update_field('document_id', $field_value, $postid);
        		break;

        	case 'website_url':
	        	if ($field_value) {
	        		update_field('document_path', $odoo_url . $field_value, $postid);
	        	}
        		break;

        	case 'mimetype':
	        	if ($field_value) {
	        		update_field('document_mimetype', $field_value, $postid);
	        	}
        		break;

          default:
	        	if ($field_value) {
	            update_field($field_slug, $field_value, $postid);
	          }
            break;
        }
      }
    }

		/**
		 * To setup the batch data use the push() method to add WP_Batch_Item instances to the queue.
		 *
		 * Note: If the operation of obtaining data is expensive, cache it to avoid slowdowns.
		 *
		 * @return void
		 */
		public function setup() {
			$document_data = mycasa_to_odoo_get_json_data('document');

			if ($document_data) {
				foreach ($document_data as $document) {
					$this->push( new WP_Batch_Item( $document['id'] . ': ' . $document['name'], $document) );
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
			$args_document = array(
        'numberposts' => -1,
        'post_type'   => 'odoo_document',
        'meta_key'    => 'document_id',
        'meta_value'  => $item->get_value('id'),
        'fields'      => 'ids'
      );

      $document_exited = get_posts($args_document);
      wp_reset_query();

      $args_new_document = array(
        'post_title'    => $item->get_value('name'),
        'post_status'   => 'publish',
        'post_type'     => 'odoo_document'
      );

      if (!empty($document_exited)) {
        $document_postid = $document_exited[0];
        $this->import_data_fields($item->data, $document_postid);
      } else {
        $document_postid = wp_insert_post($args_new_document);
        $this->import_data_fields($item->data, $document_postid);
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
	function mycasa_import_document_batch_processing_init() {
		$batch_import_document = new MyCasaOdooImportDocument();
		WP_Batch_Processor::get_instance()->register( $batch_import_document );
	}

	add_action( 'wp_batch_processing_init', 'mycasa_import_document_batch_processing_init', 19, 1 );
}


/**
 * MyCasaToOdooImportDocument
 */
class MyCasaToOdooImportDocument {

	public function import_data_fields($field_data, $postid) {
    $odoo_options = get_option('mycasa_connect_odoo_board_settings');
    $odoo_url = $odoo_options['mycasa_connect_odoo_url'];

    foreach ($field_data as $field_slug => $field_value) {
      switch ($field_slug) {
      	case 'id':
      		update_field('document_id', $field_value, $postid);
      		break;

      	case 'website_url':
        	if ($field_value) {
        		update_field('document_path', $odoo_url . $field_value, $postid);
        	}
      		break;

      	case 'mimetype':
        	if ($field_value) {
        		update_field('document_mimetype', $field_value, $postid);
        	}
      		break;

        default:
        	if ($field_value) {
            update_field($field_slug, $field_value, $postid);
          }
          break;
      }
    }
  }
	
	public function process($number) {
		$data = mycasa_to_odoo_get_json_data('document')[$number];

		if ($data) {
			$args_document = array(
        'numberposts' => -1,
        'post_type'   => 'odoo_document',
        'meta_key'    => 'document_id',
        'meta_value'  => $data['id'],
        'fields'      => 'ids'
      );

      $document_existed = get_posts($args_document);
      wp_reset_query();

      if (!empty($document_existed)) {
        $document_postid = $document_existed[0];
        $this->import_data_fields($data, $document_postid);
      } else {
	      $args_new_document = array(
	        'post_title'    => $data['name'],
	        'post_status'   => 'publish',
	        'post_type'     => 'odoo_document'
	      );

        $document_postid = wp_insert_post($args_new_document);
        $this->import_data_fields($data, $document_postid);
      }

			return $data['name'];
		} else {
			return false;
		}
	}
}

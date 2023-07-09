<?php
/**
 * MyCasaToOdooImportTags
 */
class MyCasaToOdooImportTags {

  public function process($number) {
    $data = mycasa_to_odoo_get_json_data('tags')[$number];

    if ($data) {
      $term_id = null;
      $term_key = null;

      $term_slug = mycasa_to_odoo_stripvn($data['name']);
      $term_slug = mb_strtolower($term_slug, 'UTF-8');
      $term_slug = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $term_slug);
      $term_slug = str_replace(' ', '-', $term_slug);

      $term_query = new WP_Term_Query( array(
        'taxonomy'    => 'property_tag',
        'hide_empty'  => false
      ) );

      if (!empty($term_query->terms) && is_array($term_query->terms)) {
        $term_key = array_search($term_slug, array_column($term_query->terms, 'slug'));
      }

      if (!empty($term_key) || $term_key === 0 ) {
        $term_id = $term_query->terms[$term_key]->term_id;
        update_field('property_tag_id', $data['id'], 'property_tag_'.$term_id);
      } else {
        $new_term = wp_insert_term(
          ucwords($data['display_name']),   // the term 
          'property_tag', // the taxonomy
          array(
            'slug' => $term_slug
          )
        );

        if (is_array($new_term)) {
          $term_id = $new_term['term_id'];
          update_field('property_tag_id', $data['id'], 'property_tag_'.$term_id);
        }
      }

      return $data['display_name'];
    } else {
      return false;
    }
  }
}

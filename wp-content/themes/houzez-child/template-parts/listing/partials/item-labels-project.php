<?php
$label_id = '';
$term_label = wp_get_post_terms( get_the_ID(), 'project_type', array("fields" => "all"));

$enable_label = houzez_option('disable_label', 1);

if( $enable_label ) {
?>
<div class="labels-wrap labels-right"> 

  <?php
  if( !empty($term_label) && $enable_label ) {
      foreach( $term_label as $label ) {
          $label_id = $label->term_id;
          $label_name = $label->name;
          echo '<a href="'.get_term_link($label_id).'" class="hz-label label label-color-'.intval($label_id).'">
          '.esc_attr($label_name).'
        </a>';
      }
  }
  ?>       

</div>
<?php }

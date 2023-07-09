<?php
global $post;

if (get_the_terms($post->ID, 'project_type')):
  $project_type = get_the_terms($post->ID, 'project_type');
  $count_project_type = count($project_type);
  $loop_term = 0;
?>
<div class="project-type property-labels-wrap">
<?php foreach ($project_type as $term) {
  $term_id = $term->term_id;
  $term_name = $term->name;

  if(++$loop_term === $count_project_type) {
    echo '<span class="project-type-term label-status label status-color-18">'.esc_attr($term_name).'</span>';
  } else {
    echo '<span class="project-type-term label-status label status-color-18">'.esc_attr($term_name).'</span>, ';
  }
} ?>          
</div>
<?php endif;

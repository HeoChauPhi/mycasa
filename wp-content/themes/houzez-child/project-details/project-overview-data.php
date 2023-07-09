<?php
global $post;
?>
<ul class="list-2-cols list-unstyled">
  <?php if (get_field('status', $post->ID)): ?>
  <li class="project-status"><strong><?php echo __('Status', 'houzez_child') ?></strong> <span><?php echo get_field('status', $post->ID); ?></span></li>
  <?php endif; ?>
  
  <?php if (get_field('hand_over_date', $post->ID)): ?>
  <li class="project-hand-over-date"><strong><?php echo __('Hand Over Year', 'houzez_child') ?></strong> <span><?php echo get_field('hand_over_year', $post->ID); ?></span></li>
  <?php endif; ?>
  
  <?php if (get_field('avg_unit_price_sqm_usd', $post->ID)): ?>
  <li class="project-price project-price-usd"><strong><?php echo __('Price', 'houzez_child') ?></strong> <span><?php echo '$' . number_format((int)get_field('avg_unit_price_sqm_usd', $post->ID), 0, '.', ',') . '/' . __('sqm', 'houzez_child'); ?></span></li>
  <?php elseif (get_field('avg_unit_price_sqm_vnd', $post->ID)): ?>
    <li class="project-price project-price-cnd"><?php echo number_format((int)get_field('avg_unit_price_sqm_vnd', $post->ID), 0, '.', ',') . ' VNĐ/' . __('m2', 'houzez_child'); ?></li>
  <?php else: ?>
    <li class="project-price"><?php echo __('Contact', 'houzez_child'); ?></li>
  <?php endif; ?>

  <?php
    if (get_the_terms($post->ID, 'project_type')):
    $project_type = get_the_terms($post->ID, 'project_type');
    $count_project_type = count($project_type);
    $loop_term = 0;
  ?>
  <li class="project-type">
    <strong><?php echo __('Type', 'houzez_child') ?> </strong>
    <span>
    <?php foreach ($project_type as $term) {
      $term_id = $term->term_id;
      $term_name = $term->name;

      if(++$loop_term === $count_project_type) {
        echo '<span>'.esc_attr($term_name).'</span>';
      } else {
        echo '<span>'.esc_attr($term_name).'</span>, ';
      }
    } ?>  
    </span>
  </li>
  <?php endif; ?>
  
  <?php if (get_field('total_unit_number', $post->ID)): ?>
  <li class="project-total-unit"><strong><?php echo __('Total unit', 'houzez_child') ?></strong> <span><?php echo get_field('total_unit_number', $post->ID); ?></span></li>
  <?php endif; ?>
  
  <?php if (get_field('developer_name', $post->ID)): ?>
  <li class="project-developer"><strong><?php echo __('Developer', 'houzez_child') ?></strong> <span><?php echo get_field('developer_name', $post->ID); ?></span></li>
  <?php endif; ?>
</ul>
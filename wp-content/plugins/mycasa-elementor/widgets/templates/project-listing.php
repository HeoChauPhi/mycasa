<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

?>

<div class="mycasa-elementor-project-listing">
  <?php if ($projects): ?>
    <div class="project-listing">
      <div class="heading-wrap project-listing--item">
        <div class="project-listing--item-inner">
          <?php if ($settings['title']): ?>
          <h2 class="mycasa-elementor-heading-title"><?php echo $settings['title']; ?></h2>
          <?php endif; ?>
          <?php if ($settings['sub_title']): ?>
          <h3 class="mycasa-elementor-sub-title"><?php echo $settings['sub_title']; ?></h3>
          <?php endif; ?>
          <?php if ($settings['heading_link']): ?>
          <a href="<?php echo $settings['heading_link_url']['url']; ?>" class="mycasa-elementor-heading-link" target="_blank"><?php echo $settings['heading_link']; ?></a>
          <?php endif; ?>
        </div>
      </div>

      <?php foreach ($projects as $project): ?>
      <div class="project-listing--item">
        <div class="project-listing--item-inner">
            <?php if (get_field('gallery_url', $project->ID)) {
              $image_url = get_field('gallery_url', $project->ID)[1]['picture_attachement_ids'];
            } else {
              $image_url = 'https://via.placeholder.com/545x320&text=My+Casa';
            } ?>
          <div class="project-item--image img-grayscale" style="background-image: url(https://adztvetajq.cloudimg.io/<?php echo $image_url; ?>);"></div>
          <div class="project-item-content">
            <?php if ( isset($current_lang) && get_field($price_field_slug, $project->ID)): ?>
              <?php if ($current_lang == '/en/vi' || $current_lang == '/en/vn'): ?>
              <div class="project-item-price"><?php echo number_format((int)get_field($price_field_slug, $project->ID), 0, '.', ',').__('vnd', 'mycasa-elementor'); ?></div>
              <?php else: ?>
              <div class="project-item-price"><?php echo '$'.number_format((int)get_field($price_field_slug, $project->ID), 0, '.', ','); ?></div>
              <?php endif; ?>
            <?php endif; ?>
            <div class="project-item-title"><?php echo get_the_title($project->ID); ?></div>
          </div>
          <div class="project-item-content-hover">
            <div class="project-item-title"><?php echo get_the_title($project->ID); ?></div>
            <a href="<?php echo get_the_permalink($project->ID); ?>"><?php echo __('View detail', 'mycasa-elementor'); ?> +</a>
          </div>
          <a href="<?php echo get_the_permalink($project->ID); ?>" class="mask-link"></a>
        </div>
      </div>
      <?php endforeach; ?>

      <?php if ($settings['custom_links_list']): ?>
      <div class="custom-links project-listing--item">
        <div class="project-listing--item-inner">
          <ul class="list-custom-links">
            <?php foreach ($settings['custom_links_list'] as $link): ?>
            <li class="custom-link-item">
              <?php
              if($link['custom_links_url']['custom_attributes']) {
                $attribute_arr = array();

                $attribute_arr_item = explode(',', $link['custom_links_url']['custom_attributes']);
                foreach ($attribute_arr_item as $item) {
                  $item_arr = trim($item);
                  $item_arr = explode('|', $item_arr);
                  $attribute = $item_arr[0].'="'.$item_arr[1].'"';
                  array_push($attribute_arr, $attribute);
                }

                //print_r($attribute_arr);
              }
              ?>
              <a class="<?php echo $link['custom_links_class']; ?>" href="<?php echo $link['custom_links_url']['url']; ?>" <?php if ($link['custom_links_url']['is_external']) {echo 'target="_blank"';} ?> <?php if ($attribute_arr) {echo implode(' ', $attribute_arr);} ?>><?php echo $link['custom_links_text']; ?></a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <?php endif; ?>
    </div>
  <?php else: ?>
  <div class="project-listing">
    <?php echo __('No content result', 'mycasa-elementor'); ?>
  </div>
  <?php endif; ?>
</div>

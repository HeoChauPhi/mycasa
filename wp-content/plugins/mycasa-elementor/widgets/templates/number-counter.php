<?php
// print_r($settings);

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

?>

<div class="mycasa-elementor-number-counter">
  <div class="heading-wrap">
    <?php if ($settings['title']): ?>
    <h2 class="mycasa-elementor-heading-title"><?php echo $settings['title']; ?></h2>      
    <?php endif; ?>
    <?php if ($settings['sub_title']): ?>
    <h3 class="mycasa-elementor-sub-title"><?php echo $settings['sub_title']; ?></h3>
    <?php endif; ?>
  </div>

  <?php if ($settings['number_counter_list']): ?>
  <div class="number-counter-list">
    <?php foreach ($settings['number_counter_list'] as $item): ?>
    <div class="number-counter-item">
      <?php if ($item['number_counter_title']): ?>
      <h3 class="number-counter-title-wrap">
        <?php if ($item['number_counter_title_prefix']): ?>
          <span class="number-counter-title-prefix"><?php echo $item['number_counter_title_prefix']; ?></span>
        <?php endif; ?>
        <?php if ($item['number_counter_type'] == 'string'): ?>
        <span class="number-counter-title"><?php echo $item['number_counter_title']; ?></span>
        <?php else: ?>
        <span class="number-counter-title number-counter-js" data-duration=2000 data-to-value="<?php echo (int)$item['number_counter_title']; ?>" data-from-value=0>0</span>
        <?php endif; ?>
        <?php if ($item['number_counter_title_suffix']): ?>
          <span class="number-counter-title-suffix"><?php echo $item['number_counter_title_suffix']; ?></span>
        <?php endif; ?>
      </h3>
      <?php endif; ?>

      <?php if ($item['number_counter_description']): ?>
        <div class="number-counter-description"><?php echo $item['number_counter_description']; ?></div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

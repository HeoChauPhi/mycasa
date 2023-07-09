<?php
// print_r($settings);

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

?>

<div class="mycasa-elementor-multiple-shortcode">
  <div class="heading-wrap">
    <div class="heading-inner">
      <?php if ($settings['title']): ?>
      <h2 class="mycasa-elementor-heading-title"><?php echo $settings['title']; ?></h2>      
      <?php endif; ?>
      <?php if ($settings['sub_title']): ?>
      <h3 class="mycasa-elementor-sub-title"><?php echo $settings['sub_title']; ?></h3>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($settings['multiple_shortcode_list']): ?>
  <div class="multiple-shortcode-list" <?php if (is_admin()) {echo 'style="margin-top: 100px;"';} ?>>
    <?php foreach ($settings['multiple_shortcode_list'] as $item): ?>
    <div class="multiple-shortcode-item">
      <?php if (!is_admin()): ?>
      <?php echo do_shortcode( shortcode_unautop( $item['multiple_shortcode'] ) ); ?>
      <?php else: ?>
      <div class="elementor-element elementor-widget-empty" style="padding: 10px;">
        <center><?php echo shortcode_unautop( $item['multiple_shortcode'] ); ?></center>
      </div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

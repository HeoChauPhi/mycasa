<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$career_options = get_option('career_board_settings');

?>

<div class="mycasa-elementor-career-listing">
  <?php if ($settings['title']): ?>
  <div class="heading-wrap">
    <h2 class="mycasa-elementor-heading-title"><?php echo $settings['title']; ?></h2>
  </div>
  <?php endif; ?>

  <?php if ($careers): ?>
    <div class="career-listing">
      <div class="row">
        <?php foreach ($careers as $career): ?>
        <div class="career-item col-lg-6">
          <div class="career-item-inner">
            <h3 class="career-title"><a href="<?php echo get_the_permalink($career->ID); ?>"><?php echo get_the_title($career->ID); ?></a></h3>
            <?php if ($career_options['career_company_location']): ?>
            <div class="career-location">
              <i class="fas fa-map-marker-alt"></i>
              <span><?php echo $career_options['career_company_location']; ?></span>
            </div>
            <?php endif; ?>
            <div class="career-information">
              <?php if (get_field('career_wage', $career->ID)): ?>
              <div class="field-career field-career-wage">
                <i class="far fa-money-bill-alt"></i>
                <span class="field-value"><?php echo get_field('career_wage', $career->ID); ?></span>
              </div>
              <?php endif; ?>
              <?php if (get_field('deadline_to', $career->ID)): ?>
              <div class="field-career field-career-deadline">
                <i class="far fa-calendar-alt"></i>
                <?php if (get_field('deadline_from', $career->ID)): ?>
                  <span class="field-value"><?php echo get_field('deadline_from', $career->ID); ?> </span> - 
                <?php endif; ?>
                <span class="field-value"><?php echo get_field('deadline_to', $career->ID); ?></span>
              </div>
              <?php endif; ?>
              <div class="career-read-more">
                <a href="<?php echo get_the_permalink($career->ID); ?>"><?php echo __('Read more', 'mycasa-elementor'); ?></a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>

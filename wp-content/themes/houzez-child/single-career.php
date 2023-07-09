<?php
/**
 * The Template for displaying all single posts
 * @since Houzez 1.0
 */

get_template_part('header-no-property-search');
$career_options = get_option('career_board_settings');

$content_class = 'col-lg-12 col-md-12';
if ($career_options) {
  $content_class = 'col-lg-8 col-md-12';
}

$other_career_args = array(
  'post_type' => 'career',
  'post_status' => 'publish',
  'post__not_in' => array($post->ID),
  'posts_per_page' => 5
);

$other_careers = new WP_Query($other_career_args);

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
<section class="blog-wrap">
  <div class="container">
    <div class="page-title-wrap">
        <?php get_template_part('template-parts/page/breadcrumb'); ?> 
    </div><!-- page-title-wrap -->
    <div class="row">
      <div class="<?php echo $content_class . ' '; ?>bt-content-wrap">
        <div class="article-wrap single-article-wrap">
          <?php while ( have_posts() ) : the_post(); ?>

          <article class="post-wrap">

            <div class="post-thumbnail-wrap">
                <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
            </div><!-- post-thumbnail-wrap -->
              
            <div class="post-header-wrap">
              <div class="post-title-wrap">
                <h1><?php the_title(); ?></h1>
              </div><!-- post-title-wrap -->

              <div class="post-career-information">
                <?php if (get_field('career_wage')): ?>
                  <div class="field-career field-career-wage">
                    <label><i class="fas fa-dollar-sign"></i> <?php echo __('Wage', 'houzez_child'); ?>: </label>
                    <span class="field-value"><?php echo get_field('career_wage'); ?></span>
                  </div>
                <?php endif; ?>
                <?php if (get_field('form_of_work')): ?>
                  <div class="field-career field-form-of-work">
                    <label><i class="fas fa-briefcase"></i> <?php echo __('Form of Work', 'houzez_child'); ?>: </label>
                    <span class="field-value"><?php echo get_field('form_of_work'); ?></span>
                  </div>
                <?php endif; ?>
                <?php if (get_field('deadline_to')): ?>
                  <div class="field-career field-career-deadline">
                    <label><i class="far fa-calendar-alt"></i> <?php echo __('Deadline for submission', 'houzez_child'); ?>: </label>
                    <?php if (get_field('deadline_from')): ?>
                      <span><?php echo __('From', 'houzez_child'); ?>: </span>
                      <span class="field-value"><?php echo get_field('deadline_from'); ?> </span> - 
                      <span><?php echo __('To', 'houzez_child'); ?>: </span>
                    <?php endif; ?>

                    <span class="field-value"><?php echo get_field('deadline_to'); ?></span>
                  </div>
                <?php endif; ?>
              </div>
            </div><!-- post-header-wrap -->

            <div class="post-content-wrap">
              <?php the_content(); ?>                
            </div><!-- post-content-wrap -->

            <?php if (get_field('application_form')): ?>
            <div id="field-application-form" class="field-application-form">
              <?php echo do_shortcode('[contact-form-7 id="'.get_field('application_form').'" title="Application Form"]') ?>
              <input type="hidden" name="career-page-title" class="career-page-title" value="<?php echo get_the_title(); ?>">
            </div>
            <?php endif; ?>

          </article><!-- post-wrap -->                        
              
          <?php endwhile; ?>
        </div><!-- article-wrap -->
      </div><!-- bt-content-wrap -->

      <?php if ($career_options): ?>
      <div class="col-lg-4 col-md-12 bt-sidebar-wrap houzez_sticky">
        <aside id="sidebar" class="sidebar-wrap">

        <?php if ($career_options['career_company_location'] || $career_options['career_company_email'] || $career_options['career_application_form']): ?>
        <div class="widget widget-wrap block-employer-information">
          <ul class="employer-information-list">
            <?php if ($career_options['career_company_location']): ?>
            <li class="employer-information-item employer-information-location">
              <label><i class="fas fa-angle-right"></i> <?php echo __('Company location', 'houzez_child'); ?></label>
              <span class="field-value"><?php echo $career_options['career_company_location']; ?></span>
            </li>
            <?php endif; ?>
            <?php if ($career_options['career_company_email']): ?>
            <li class="employer-information-item employer-information-email">
              <label><i class="fas fa-angle-right"></i> <?php echo __('Submit application by email', 'houzez_child'); ?></label>
              <span class="field-value"><?php echo $career_options['career_company_email']; ?></span>
            </li>
            <?php endif; ?>
          </ul>
          <div class="employer-information-actions">
            <?php if (get_field('application_form')): ?>
              <a href="#field-application-form" class="btn btn-primary btn-full-width btn-application-form js-scroll-to-element"><i class="fas fa-pencil-alt"></i> <?php echo __('submit an application', 'houzez_child'); ?></a>
            <?php endif; ?>
            <?php if ($career_options['career_application_form']): ?>
              <a href="<?php echo $career_options['career_application_form']; ?>" class="btn btn-primary btn-full-width btn-download" download><i class="fas fa-download"></i> <?php echo __('Download the application form', 'houzez_child'); ?></a>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($career_options['career_contact_us']): ?>
        <div class="widget widget-wrap block-employer-contact">
          <h3 class="widget-title"><?php echo __('Contact Us', 'houzez_child'); ?></h3>
          <div class="widget-content">
            <?php echo nl2br($career_options['career_contact_us']); ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( $other_careers->have_posts() ) : ?>
        <div class="widget widget-wrap block-other-career">
          <h3 class="widget-title"><?php echo __('Other Career', 'houzez_child'); ?></h3>
          <ul class="other-career-list">
          <?php while ( $other_careers->have_posts() ) : $other_careers->the_post(); ?>
            <li class="other-career-item">
              <a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo get_the_title($post->ID); ?></a>
            </li>
          <?php endwhile; ?>
          </ul>
        </div>
        <?php endif; ?>

        </aside>
      </div><!-- bt-sidebar-wrap -->
      <?php endif; ?>      
    </div><!-- row -->
  </div><!-- container -->
</section><!-- blog-wrap -->

<?php
}
get_footer();

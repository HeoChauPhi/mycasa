<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 29/09/16
 * Time: 5:10 PM
 * Since v1.4.0
 */
global $post, $houzez_local, $properties_ids;

get_template_part('header-no-property-search');

$content_classes = 'col-lg-8 col-md-12 bt-content-wrap';

if( have_posts() ): while( have_posts() ): the_post(); ?>

<section class="content-wrap property-wrap property-detail-v3 project-wrap">
  <!-- Navigation -->
  <div class="property-navigation-wrap">
    <div class="container-fluid">
      <ul class="property-navigation list-unstyled d-flex justify-content-between">
        <li class="property-navigation-item">
          <a class="target" href="#page-title-wrap">
            <i class="houzez-icon icon-arrow-button-circle-up"></i>
          </a>
        </li>
        <?php if ( get_field('video_url') ): ?>
        <li class="property-navigation-item">
          <a class="target" href="#video-url-wrap"><?php echo __('Video', 'houzez_child'); ?></a>
        </li>  
        <?php endif; ?>
        <li class="property-navigation-item">
          <a class="target" href="#property-overview-wrap"><?php echo __('Overview', 'houzez_child'); ?></a>
        </li>
        <li class="property-navigation-item">
          <a class="target" href="#property-description-wrap"><?php echo __('Description', 'houzez_child'); ?></a>
        </li>
        <li class="property-navigation-item">
          <a class="target" href="#property-address-wrap"><?php echo __('Address', 'houzez_child'); ?></a>
        </li>
        <?php if (get_the_terms($post->ID, 'property_feature')): ?>
        <li class="property-navigation-item">
          <a class="target" href="#property-features-wrap"><?php echo __('Features', 'houzez_child'); ?></a>
        </li>
        <?php endif; ?>
        <li class="property-navigation-item">
          <a class="target" href="#property-mortgage-calculator-wrap"><?php echo __('Mortgage Calculator', 'houzez_child'); ?></a>
        </li>
        <?php if (!empty(get_field('unit_ids', $post->ID))): ?>
        <li class="property-navigation-item">
          <a class="target" href="#lease-listings-wrap"><?php echo __('Lease Listings', 'houzez_child'); ?></a>
        </li> 
        <li class="property-navigation-item">
          <a class="target" href="#resell-listings-wrap"><?php echo __('Resell Listings', 'houzez_child'); ?></a>
        </li> 
        <?php endif; ?>    
      </ul>
    </div><!-- container -->
  </div><!-- End Navigation -->

  <!-- Project Title -->
  <div id="page-title-wrap" class="page-title-wrap">
    <div class="container">
      <div class="d-flex align-items-center">
        <?php get_template_part('template-parts/page/breadcrumb'); ?>
        <?php get_template_part('property-details/partials/tools'); ?> 
      </div><!-- d-flex -->
      <div class="d-flex align-items-center property-title-price-wrap project-title-wrap">
        <div class="page-title">
          <h1><?php the_title(); ?></h1>
        </div><!-- page-title -->

        <?php get_template_part('property-details/partials/item-price'); ?>
      </div><!-- d-flex -->

      <!-- Get Project type term -->
      <?php get_template_part('project-details/project-type-term'); ?>
      <!-- End get Project type term -->
      
      <?php if (get_field('full_address')): ?>
      <address class="item-address">
        <i class="houzez-icon icon-pin mr-1"></i>
        <?php echo get_field('full_address')['address']; ?>
      </address>
      <?php endif; ?>
    </div><!-- container -->
  </div><!-- page-title-wrap -->

  <div class="container">
    <div class="row">
      <div class="<?php echo esc_attr($content_classes); ?>">

        <!-- Banner -->
        <?php
          $project_images = get_field('gallery_url');
        ?>
        <?php if (!empty($project_images)): ?>
        <div class="property-top-wrap">
          <div class="property-banner">
            <div class="container hidden-on-mobile">
              <?php get_template_part('project-details/banner-nav'); ?>
            </div><!-- container -->
            <div class="tab-content" id="pills-tabContent">
              <?php get_template_part('project-details/media-tabs'); ?>
            </div><!-- tab-content -->
          </div><!-- property-banner -->
        </div><!-- property-top-wrap -->
        <?php endif; ?>
        <!-- End banner -->

        <div class="property-view">

          <!-- Visible on Mobile -->
          <div class="visible-on-mobile">
            <div class="mobile-top-wrap">
              <div class="mobile-property-tools clearfix">
                <?php 
                if (!empty($project_images)) {
                    get_template_part('project-details/banner-nav'); 
                }?>
                <?php get_template_part('property-details/partials/tools'); ?> 
              </div><!-- mobile-property-tools -->
              <div class="mobile-property-title clearfix">
                <?php get_template_part('project-details/project-type-term'); ?>
                <?php get_template_part('property-details/partials/title'); ?>
                <?php if (get_field('full_address')): ?>
                <address class="item-address">
                  <i class="houzez-icon icon-pin mr-1"></i>
                  <?php echo get_field('full_address')['address']; ?>
                </address>
                <?php endif; ?>
                <?php get_template_part('template-parts/listing/partials/item-price-project'); ?>
                  
              </div><!-- mobile-property-title -->
            </div><!-- mobile-top-wrap -->
          </div><!-- visible-on-mobile -->

          <!-- Videos -->
          <?php if ( get_field('video_url') ): ?>
          <div class="video-url-wrap property-section-wrap" id="video-url-wrap">
            <!-- <a class="js-form-popup" href="#" target="_blank" data-target="#popup-video" data-toggle="modal">video</a> -->
            
            <div class="block-wrap">
              <div class="block-title-wrap">
                <h2><?php echo __('Video', 'houzez_child'); ?></h2>
              </div><!-- block-title-wrap -->
              <div class="block-content-wrap">
                <div id="popup-video" class="popup-video"><?php print_r(get_field('video_url')); ?></div>
              </div><!-- block-content-wrap -->
            </div><!-- block-wrap -->
          </div>  
          <?php endif; ?>
          <!-- End Mortgage Calculator -->

          <!-- Overview -->
          <div class="property-overview-wrap property-section-wrap" id="property-overview-wrap">
            <div class="block-wrap">
              
              <div class="block-title-wrap d-flex justify-content-between align-items-center">
                <h2><?php echo __('Overview', 'houzez_child'); ?></h2>
                <?php if (get_field('brochure_url')): ?>
                  <a class="btn btn-primary btn-slim" href="<?php echo get_field('brochure_url'); ?>" download><i class="fas fa-download"></i> <?php echo get_field('brochure_text'); ?></a>
                <?php endif; ?>
              </div><!-- block-title-wrap -->

              <div class="project-overview-data block-content-wrap">
              <?php get_template_part('project-details/project-overview-data'); ?>
              </div><!-- d-flex -->
            </div><!-- block-wrap -->
          </div><!-- property-overview-wrap -->
          <!-- End Overview -->

          <!-- Description -->
          <div class="property-description-wrap property-section-wrap" id="property-description-wrap">
            <div class="block-wrap">
              <div class="block-title-wrap">
                <h2><?php echo __('Description', 'houzez_child'); ?></h2> 
              </div>
              <div class="block-content-wrap">
                <?php the_content(); ?>

                <?php /*
                $documents = get_field('document_ids');
                if(!empty($documents)): ?>
                  <div class="block-project-doc-wrap">
                    <div class="block-title-wrap block-title-property-doc">
                      <h3><?php echo __('Project documents', 'houzez_child'); ?></h3> 
                    </div>
                    <ul class="project-doc-list list-unstyled">
                    <?php foreach ($documents as $document): ?>
                      <?php
                      $d_id = $document['document_id'];
                      $d_mime = get_field('document_mimetype', $d_id);
                      ?>
                      <li><a href="<?php echo get_field('document_path', $d_id); ?>" download="<?php echo get_the_title($d_id); ?>"><i class="<?php echo houzez_child_fa_icon_class($d_mime); ?>"></i> <?php echo get_the_title($d_id); ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endif; */?>
              </div>
            </div>
          </div>
          <!-- End Description -->

          <!-- Address -->
          <div class="property-address-wrap property-section-wrap" id="property-address-wrap">
            <div class="block-wrap">
              <div class="block-title-wrap d-flex justify-content-between align-items-center">
                <h2><?php echo __('Address', 'houzez_child'); ?></h2>
                <?php if (get_field('full_address')): ?>
                  <a class="btn btn-primary btn-slim" href="http://maps.google.com/?q=<?php echo get_field('full_address')['address']; ?>" target="_blank"><i class="houzez-icon icon-maps mr-1"></i> Open on Google Maps</a>
                <?php endif; ?>
              </div><!-- block-title-wrap -->

              <div class="block-content-wrap">
                <ul class="list-2-cols list-unstyled">
                  <?php
                  if (get_field('street') || get_field('street2')):
                  $street = array(get_field('street'), get_field('street2'));
                  ?>
                    <li class="project-street"><strong><?php echo __('Street', 'houzez_child') ?></strong> <span><?php echo join(" ", $street); ?></span></li>
                  <?php endif; ?>

                  <?php if (get_field('district_id')): ?>
                    <li class="project-district"><strong><?php echo __('District', 'houzez_child') ?></strong> <span><?php echo get_field('district_id'); ?></span></li>
                  <?php endif; ?>

                  <?php if (get_field('city_id')): ?>
                    <li class="project-city"><strong><?php echo __('City', 'houzez_child') ?></strong> <span><?php echo get_field('city_id'); ?></span></li>
                  <?php endif; ?>

                  <?php if (get_field('zip')): ?>
                    <li class="project-zip"><strong><?php echo __('Zip code', 'houzez_child') ?></strong> <span><?php echo get_field('zip'); ?></span></li>
                  <?php endif; ?>

                  <?php if (get_field('country_id')): ?>
                    <li class="project-country"><strong><?php echo __('Country', 'houzez_child') ?></strong> <span><?php echo get_field('country_id'); ?></span></li>
                  <?php endif; ?>
                </ul>
              </div><!-- block-content-wrap -->
            </div><!-- block-wrap -->
          </div>
          <!-- End Address -->

          <!-- Amenities (Feature) -->
          <?php
          if (get_the_terms($post->ID, 'property_feature')):
            $amenities = get_the_terms($post->ID, 'property_feature');
            $count_amenities = count($amenities);
            $loop_term = 0;
          ?>
          <div class="property-features-wrap property-section-wrap" id="property-features-wrap">
            <div class="block-wrap">
              <div class="block-title-wrap d-flex justify-content-between align-items-center">
                <h2><?php echo __('Amenities', 'houzez_child'); ?></h2>
              </div><!-- block-title-wrap -->

              <div class="block-content-wrap">
                <ul class="list-3-cols list-unstyled">
                <?php foreach ($amenities as $term):
                  $term_id = $term->term_id;
                  $term_name = $term->name;
                ?>
                  <li class="project-feature"><i class="houzez-icon icon-check-circle-1 mr-2"></i> <a href="<?php echo get_term_link($term_id); ?>"><?php echo esc_attr($term_name); ?></a></li>
                <?php endforeach; ?>  
                </ul>
              </div><!-- block-content-wrap -->
            </div><!-- block-wrap -->
          </div>
          <?php endif; ?>
          <!-- End Amenities (Feature) -->

          <!-- Mortgage Calculator -->
          <div class="property-mortgage-calculator-wrap property-section-wrap" id="property-mortgage-calculator-wrap">
            <div class="block-wrap">
              <div class="block-title-wrap">
                <h2><?php echo houzez_option('sps_calculator', 'Mortgage Calculator'); ?></h2>
              </div><!-- block-title-wrap -->
              <div class="block-content-wrap">
                <?php get_template_part('property-details/partials/mortgage-calculator'); ?>
              </div><!-- block-content-wrap -->
            </div><!-- block-wrap -->
          </div><!-- property-mortgage-calculator-wrap -->
          <!-- End Mortgage Calculator -->

        </div><!-- property-view -->

      </div>

      <div class="col-lg-4 col-md-12 bt-sidebar-wrap houzez_sticky">
        <?php get_sidebar('project'); ?>
      </div><!-- bt-sidebar-wrap -->
    </div>

    <?php get_template_part('project-details/project-similar-listing'); ?>
  </div>

</section><!-- listing-wrap -->

<?php 
endwhile; endif;

get_template_part( 'property-details/lightbox');

get_footer();

<?php
global $wp, $wpdb;

// Config for polylang
$project_search_slug = null;
$project_page_search_id = get_page_by_path('project-listing');

if ( !empty($GLOBALS["polylang"]) ) {
  $search_page_trans = get_post_field('post_name', pll_get_post($project_page_search_id->ID));

  if (pll_current_language() == pll_default_language()) {
    $project_search_slug = 'project-listing';
  } else {
    $project_search_slug = pll_current_language() . '/' . $search_page_trans . '/';
  }
} else {
  $project_search_slug = 'project-listing';
}
$project_form_action = home_url( $project_search_slug );

// Select field label
$data_sticky_search = 1;
if ( is_singular('project') ) {
  $data_sticky_search = 0;
}

$select_all_text = __('Select All', 'houzez_child');
$delete_all_text = __('Deselect All', 'houzez_child');

// Get Street data
$street_arr = array();
$street_sql = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE CONVERT(`meta_key` USING utf8) = 'street' OR CONVERT(`meta_key` USING utf8) = 'street2' AND CONVERT(`meta_value` USING utf8) <> ''");

foreach ($street_sql as $street) {
  unset($street->meta_id);
  unset($street->post_id);
  unset($street->meta_key);
  if (!in_array($street->meta_value, $street_arr)) {
    array_push($street_arr, $street->meta_value);
  }
}
sort($street_arr);

// Get District data
$district_arr = array();
$district_sql = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE CONVERT(`meta_key` USING utf8) = 'district_id' AND CONVERT(`meta_value` USING utf8) <> ''");

foreach ($district_sql as $district) {
  unset($district->meta_id);
  unset($district->post_id);
  unset($district->meta_key);
  if (!in_array($district->meta_value, $district_arr)) {
    array_push($district_arr, $district->meta_value);
  }
}
sort($district_arr);

// Get City data
$city_arr = array();
$city_sql = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE CONVERT(`meta_key` USING utf8) = 'city_id' AND CONVERT(`meta_value` USING utf8) <> ''");

foreach ($city_sql as $city) {
  unset($city->meta_id);
  unset($city->post_id);
  unset($city->meta_key);
  if (!in_array($city->meta_value, $city_arr)) {
    array_push($city_arr, $city->meta_value);
  }
}
sort($city_arr);

// Get Hand Over Year data
$year_arr = array();
$year_sql = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE CONVERT(`meta_key` USING utf8) = 'hand_over_year' AND CONVERT(`meta_value` USING utf8) <> ''");

foreach ($year_sql as $year) {
  unset($year->meta_id);
  unset($year->post_id);
  unset($year->meta_key);
  if (!in_array($year->meta_value, $year_arr)) {
    array_push($year_arr, $year->meta_value);
  }
}
sort($year_arr);

// Get Price
$price_arr = array();
$price_sql = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE CONVERT(`meta_key` USING utf8) = 'avg_unit_price_sqm_usd' AND CONVERT(`meta_value` USING utf8) <> ''");

foreach ($price_sql as $price) {
  unset($price->meta_id);
  unset($price->post_id);
  unset($price->meta_key);
  if (!in_array($price->meta_value, $price_arr)) {
    array_push($price_arr, $price->meta_value);
  }
}
array_map('intval', $price_arr);
sort($price_arr);

?>
<section id="desktop-header-search" class="advanced-search advanced-search-nav project-search-nav" data-hidden=0 data-sticky=<?php echo $data_sticky_search ?>>
  <div class="container">
    <form class="houzez-search-form-js" method="get" autocomplete="off" action="<?php echo $project_form_action; ?>">
      
      <div class="advanced-search-v1">
        <div class="d-flex">
          <!-- Search text autocomplete -->
          <div class="flex-search flex-grow-1"> 
            <div class="form-group">
              <div class="search-icon">
                <input name="project_keyword" type="text" class="houzez-project-keyword-autocomplete form-control project_keyword" value="<?php if ($_GET['project_keyword']) { echo $_GET['project_keyword']; } ?>" placeholder="<?php echo __('Please enter the Project name, District, City, Country,...', 'houzez_child') ?>...">
                <div id="auto_complete_ajax" class="auto-complete"></div>
              </div><!-- search-icon -->
            </div><!-- form-group -->
          </div>

          <!-- Street field -->
          <div class="flex-search fields-width ">
            <div class="form-group">
              <div class="dropdown bootstrap-select show-tick form-control">
                <select name="project_street[]" data-size="5" class="selectpicker form-control project_street" title="<?php echo __('Street', 'houzez_child'); ?>" data-live-search="true" data-selected-text-format="count > 1" data-actions-box="true" multiple="" data-select-all-text="<?php echo $select_all_text; ?>" data-deselect-all-text="<?php echo $delete_all_text; ?>" data-count-selected-text="{0} <?php echo __('Streets', 'houzez_child'); ?>" data-none-results-text="<?php echo __('No results matched', 'houzez_child'); ?> {0}" data-container="body" tabindex="null">
                  <?php foreach ($street_arr as $street): ?>
                    <option value="<?php echo $street; ?>" <?php if ($_GET['project_street'] && in_array($street, $_GET['project_street'])) { echo 'selected="selected"'; } ?>><?php echo $street; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div><!-- form-group -->
          </div>

          <!-- District field -->
          <div class="flex-search fields-width ">
            <div class="form-group">
              <div class="dropdown bootstrap-select show-tick form-control">
                <select name="project_district[]" data-size="5" class="selectpicker form-control project_district" title="<?php echo __('District', 'houzez_child'); ?>" data-live-search="true" data-selected-text-format="count > 1" data-actions-box="true" multiple="" data-select-all-text="<?php echo $select_all_text; ?>" data-deselect-all-text="<?php echo $delete_all_text; ?>" data-count-selected-text="{0} <?php echo __('District', 'houzez_child'); ?>" data-none-results-text="<?php echo __('No results matched', 'houzez_child'); ?> {0}" data-container="body" tabindex="null">
                  <?php foreach ($district_arr as $district): ?>
                    <option value="<?php echo $district; ?>" <?php if ($_GET['project_district'] && in_array($district, $_GET['project_district'])) { echo 'selected="selected"'; } ?>><?php echo $district; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div><!-- form-group -->
          </div>

          <!-- City field -->
          <div class="flex-search fields-width ">
            <div class="form-group">
              <div class="dropdown bootstrap-select show-tick form-control">
                <select name="project_city[]" data-size="5" class="selectpicker form-control project_city" title="<?php echo __('City', 'houzez_child'); ?>" data-live-search="true" data-selected-text-format="count > 1" data-actions-box="true" multiple="" data-select-all-text="<?php echo $select_all_text; ?>" data-deselect-all-text="<?php echo $delete_all_text; ?>" data-count-selected-text="{0} <?php echo __('City', 'houzez_child'); ?>" data-none-results-text="<?php echo __('No results matched', 'houzez_child'); ?> {0}" data-container="body" tabindex="null">
                  <?php foreach ($city_arr as $city): ?>
                    <option value="<?php echo $city; ?>" <?php if ($_GET['project_city'] && in_array($city, $_GET['project_city'])) { echo 'selected="selected"'; } ?>><?php echo $city; ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div><!-- form-group -->
          </div>

          <!-- Search advance -->
          <div class="flex-search">
            <a class="btn advanced-search-btn btn-full-width" data-toggle="collapse" href="#advanced-search-filters">
              <i class="houzez-icon icon-cog mr-1"></i> <?php echo __('Advanced', 'houzez_child'); ?>
            </a>
          </div>
          
          <!-- Search Button -->
          <div class="flex-search btn-no-right-padding">
            <button type="submit" class="btn btn-search btn-secondary btn-full-width"><?php echo houzez_option('srh_btn_search', 'Search'); ?></button>
          </div>
        </div><!-- d-flex -->
      </div><!-- advanced-search-v1 -->

      <div id="advanced-search-filters" class="collapse">
        <div class="advanced-search-filters search-v1-v2">

          <div class="d-flex">
            <!-- Is Foreigner Quota field -->
            <div class="flex-search">
              <div class="form-group">
                <label class="control control--checkbox">
                  <input type="checkbox" id="project_is_foreigner_quota" class="project_is_foreigner_quota" name="project_is_foreigner_quota" value=1 <?php if ($_GET['project_is_foreigner_quota']) { echo 'checked="checked"'; } ?>> <?php echo __('Is Foreigner Quota', 'houzez_child'); ?>
                  <span class="control__indicator"></span>
                </label>
              </div><!-- form-group -->
            </div>

            <!-- Hand Over Year field -->
            <div class="flex-search">
              <div class="form-group">
                <div class="dropdown bootstrap-select show-tick form-control">
                  <select name="project_year[]" data-size="5" class="selectpicker form-control project_year" title="<?php echo __('Hand Over Year', 'houzez_child'); ?>" data-live-search="true" data-selected-text-format="count > 1" data-actions-box="true" multiple="" data-select-all-text="<?php echo $select_all_text; ?>" data-deselect-all-text="<?php echo $delete_all_text; ?>" data-count-selected-text="{0} <?php echo __('Hand Over Year', 'houzez_child'); ?>" data-none-results-text="<?php echo __('No results matched', 'houzez_child'); ?> {0}" data-container="body" tabindex="null">
                    <?php foreach ($year_arr as $year): ?>
                      <option value="<?php echo $year; ?>" <?php if ($_GET['project_year'] && in_array($year, $_GET['project_year'])) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                    <?php endforeach ?>
                  </select>
                </div><!-- selectpicker -->
              </div><!-- form-group -->
            </div>

            <!-- Status hidden field -->
            <div class="flex-search form-hidden">
              <div class="form-group">
                <input type="text" name="status" value="<?php echo $_GET['status']; ?>" class="project_status form-control" />
              </div><!-- form-group -->
            </div>
          </div><!-- d-flex -->

          <!-- Price field -->
          <div class="d-flex">
            <div class="flex-search-half project-price-range-wrap">
              <?php
              $current_min_price = (isset($_GET['project_min_price']) && $_GET['project_min_price'] != '') ? $_GET['project_min_price'] : min($price_arr);
              $current_max_price = (isset($_GET['project_max_price']) && $_GET['project_max_price'] != '') ? $_GET['project_max_price'] : max($price_arr);
              ?>
              <div class="range-text">
                <input type="text" name="project_min_price" class="min-price-range-hidden range-input" value=''>
                <input type="text" name="project_max_price" class="max-price-range-hidden range-input" value=''>
                <!-- Set values Price ranger -->
                <input type="hidden" class="value-min-price-range range-input" value=<?php echo (int)min($price_arr); ?>>
                <input type="hidden" class="value-max-price-range range-input" value=<?php echo (int)max($price_arr); ?>>
                <!-- Current Price ranger -->
                <input type="hidden" class="current-min-price-range range-input" value=<?php echo (int)$current_min_price; ?>>
                <input type="hidden" class="current-max-price-range range-input" value=<?php echo (int)$current_max_price; ?>>
                <span class="range-title"><?php echo houzez_option('srh_price_range', 'Price Range:'); ?></span> <?php echo houzez_option('srh_from', 'from'); ?> <span class="min-price-range"></span> <?php echo houzez_option('srh_to', 'to'); ?> <span class="max-price-range"></span>
              </div><!-- range-text -->
              <div class="price-range-wrap">
                <div class="project-price-range"></div><!-- price-range -->
              </div><!-- price-range-wrap -->
            </div>
          </div>

        </div>

        <div class="features-list-wrap">
          <a class="btn-features-list" data-toggle="collapse" href="#features-list">
            <i class="houzez-icon icon-add-square"></i> <?php echo houzez_option('srh_other_features', 'Other Features'); ?>
          </a><!-- btn-features-list -->
          <div id="features-list" class="collapse">
            <div class="features-list">
              <?php get_template_part('template-parts/search/fields/feature-field'); ?>
            </div><!-- features-list -->
          </div><!-- collapse -->
        </div><!-- features-list-wrap -->
      </div><!-- advanced-search-filters -->

    </form>
  </div><!-- container -->
</section><!-- advanced-search -->
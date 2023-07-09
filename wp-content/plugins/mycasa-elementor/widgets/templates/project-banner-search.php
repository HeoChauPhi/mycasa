<?php
$field_disabled = $settings['banner_search_activate_tab'] == 'project' ? 'disabled' : null;
$advanced_class = $settings['banner_search_activate_tab'] == 'project' ? 'hidden' : null;
$billion = __('billion', 'mycasa-elementor');
$millions = __('millions', 'mycasa-elementor');

//print_r($projects_data);
?>

<form class="project-banner-search-form-js" id="project-banner-search-form" method="get" action="<?php echo home_url('banner-search') ?>">
  <?php if ($settings['banner_search_list']): ?>
    <ul id="project-banner-search-tabs-wrap" class="banner-search-tabs nav nav-pills justify-content-center" role="tablist" data-toggle="buttons">
    <?php foreach ($settings['banner_search_list'] as $tab): ?>
      <li class="nav-item">
        <a class="nav-link <?php echo $settings['banner_search_activate_tab'] == $tab ? 'active' : null; ?>" data-val="<?php echo $tab; ?>" data-toggle="pill" href="#" role="tab" aria-selected="true"><?php echo $settings['banner_search_' . $tab . '_label'] ?></a>
      </li>
    <?php endforeach ?>
      <input type="hidden" name="type" class="search-by" value="<?php echo $settings['banner_search_activate_tab']; ?>">
    </ul>
  <?php endif; ?>

  <div class="banner-search-form-wrapper elementor-form-fields-wrapper">
    <div class="banner-search-form-field-group elementor-field-group elementor-column form-group elementor-col-80 banner-search-form-field-autocomplete">
      <input type="text" size="1" name="project_keyword" id="project-keyword" class="banner-search-form-field elementor-field form-control elementor-size-sm elementor-field-textual" placeholder="<?php echo __('Please enter the Project name, District, City, Country,...', 'mycasa-elementor') ?>">
      <div id="auto_complete_ajax" class="auto-complete"></div>
    </div>

    <div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-20">
      <button type="submit" class="btn banner-search-form-button elementor-button elementor-size-sm"><?php echo $settings['banner_search_button_label'] ?></button>
    </div>

    <?php if ($settings['banner_search_advance']): ?>
    <div class="banner-search-advanced-wrap <?php echo $advanced_class; ?>">
      <div id="advanced-search-filters" class="collapse banner-search-advanced show">
        <div class="banner-search-advanced-inner">

          <?php if ($projects_data): ?>
          <div class="banner-search-field-project-wrap elementor-field-group elementor-column form-group elementor-col-20">
            <label for="banner-search-field-project" class="elementor-field-label"><?php echo __('Projects', 'mycasa-elementor'); ?></label>
            <div class="elementor-field elementor-select-wrapper">
              <div class="dropdown bootstrap-select houzez-field-textual form-control elementor-size-sm banner-search-adv-field">
                <select data-size="5" name="project_id" id="banner-search-field-project" class="selectpicker houzez-field-textual form-control elementor-size-sm" data-none-results-text="No results matched {0}" tabindex="null" <?php echo $field_disabled; ?>>
                  <option data-ref='' value="" selected><?php echo __('Select Project', 'mycasa-elementor'); ?></option>
                 <?php foreach ($projects_data as $id => $name): ?>
                   <option data-ref='<?php echo $id; ?>' value="<?php echo $id; ?>"><?php echo $name; ?></option>
                 <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <div class="banner-search-field-resell-price-wrap banner-search-field-price-wrap elementor-field-group elementor-column form-group elementor-col-20 <?php echo $settings['banner_search_activate_tab'] == 'resell' ? null : 'hidden'; ?>">
            <label for="banner-search-field-sale-price" class="elementor-field-label"><?php echo __('Resell Price', 'mycasa-elementor'); ?></label>
            <div class="elementor-field elementor-select-wrapper">
              <div class="dropdown bootstrap-select houzez-field-textual form-control elementor-size-sm banner-search-adv-field">
                <select data-size="5" name="sale_price" id="banner-search-field-sale-price" class="selectpicker houzez-field-textual form-control elementor-size-sm" data-none-results-text="No results matched {0}" tabindex="null" <?php echo $settings['banner_search_activate_tab'] == 'resell' ? null : 'disabled'; ?>>
                  <option data-ref='' value="" selected><?php echo __('Any Price', 'mycasa-elementor'); ?></option>
                  <?php if (!empty($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/vi'): ?>
                  <option data-ref="0-1150000000" value="0-1150000000">< 1,115 <?php echo $billion; ?></option>
                  <option data-ref="1150000000-2300000000" value="1150000000-2300000000">1,115 - 2,3 <?php echo $billion; ?></option>
                  <option data-ref="2300000000-4600000000" value="2300000000-4600000000">2,3 - 4,6 <?php echo $billion; ?></option>
                  <option data-ref="4600000000-6900000000" value="4600000000-6900000000">4,6 - 6,9 <?php echo $billion; ?></option>
                  <option data-ref="6900000000-11500000000" value="6900000000-11500000000">6,9 - 11,5 <?php echo $billion; ?></option>
                  <option data-ref="11500000000-23000000000" value="11500000000-23000000000">11,5 - 23 <?php echo $billion; ?></option>
                  <option data-ref="23000000000" value="23000000000">> 23 <?php echo $billion; ?></option>
                  <?php else: ?>
                  <option data-ref="0-50000" value="0-50000">< 50k USD</option>
                  <option data-ref="50000-100000" value="50000-100000">50K - 100K USD</option>
                  <option data-ref="100000-200000" value="100000-200000">100K - 200k USD</option>
                  <option data-ref="200000-300000" value="200000-300000">200k - 300k USD</option>
                  <option data-ref="300000-500000" value="300000-500000">300k - 500k USD</option>
                  <option data-ref="500000-1000000" value="500000-1000000">500k - 1M USD</option>
                  <option data-ref="1000000" value="1000000">> 1M USD</option>
                  <?php endif; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="banner-search-field-lease-price-wrap banner-search-field-price-wrap elementor-field-group elementor-column form-group elementor-col-20 <?php echo $settings['banner_search_activate_tab'] == 'lease' ? null : 'hidden'; ?>">
            <label for="banner-search-field-rent-price" class="elementor-field-label"><?php echo __('Lease Price', 'mycasa-elementor'); ?></label>
            <div class="elementor-field elementor-select-wrapper">
              <div class="dropdown bootstrap-select houzez-field-textual form-control elementor-size-sm banner-search-adv-field">
                <select data-size="5" name="rent_price" id="banner-search-field-rent-price" class="selectpicker houzez-field-textual form-control elementor-size-sm" data-none-results-text="No results matched {0}" tabindex="null" <?php echo $settings['banner_search_activate_tab'] == 'lease' ? null : 'disabled'; ?>>
                  <option data-ref='' value="" selected><?php echo __('Any Price', 'mycasa-elementor'); ?></option>
                  <?php if (!empty($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/vi'): ?>
                  <option data-ref="0-11500000" value="0-11500000">< 11,5 <?php echo $millions; ?></option>
                  <option data-ref="11500000-23000000" value="11500000-23000000">11,5 - 23 <?php echo $millions; ?></option>
                  <option data-ref="23000000-34500000" value="23000000-34500000">23 - 34,5 <?php echo $millions; ?></option>
                  <option data-ref="34500000-46000000" value="34500000-46000000">34,5 - 46 <?php echo $millions; ?></option>
                  <option data-ref="46000000-80500000" value="46000000-80500000">46 - 80,5 <?php echo $millions; ?></option>
                  <option data-ref="80500000-115000000" value="80500000-115000000">80,5 - 115 <?php echo $millions; ?></option>
                  <option data-ref="115000000" value="115000000">> 115 <?php echo $millions; ?></option>
                  <?php else: ?>
                  <option data-ref="0-500" value="0-500">< 500 USD</option>
                  <option data-ref="500-1000" value="500-1000">500 - 1000 USD</option>
                  <option data-ref="1000-1500" value="1000-1500">1000 - 1500 USD</option>
                  <option data-ref="1500-2000" value="1500-2000">1500 - 2000 USD</option>
                  <option data-ref="2000-3500" value="2000-3500">2000 - 3500 USD</option>
                  <option data-ref="3500-5000" value="3500-5000">3500 - 5000 USD</option>
                  <option data-ref="5000" value="5000">> 5000 USD</option>
                  <?php endif; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="banner-search-field-area-wrap elementor-field-group elementor-column form-group elementor-col-20">
            <label for="banner-search-field-area" class="elementor-field-label"><?php echo __('Area Size', 'mycasa-elementor'); ?></label>
            <div class="elementor-field elementor-select-wrapper">
              <div class="dropdown bootstrap-select houzez-field-textual form-control elementor-size-sm banner-search-adv-field">
                <select data-size="5" name="area_size" id="banner-search-field-area" class="selectpicker houzez-field-textual form-control elementor-size-sm" data-none-results-text="No results matched {0}" tabindex="null" <?php echo $$field_disabled; ?>>
                  <option data-ref='' value="" selected><?php echo __('Any Area Size', 'mycasa-elementor'); ?></option>
                  <option data-ref='0-30' value="0-30">< 30 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                  <option data-ref='30-50' value="30-50">30 - 50 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                  <option data-ref='50-80' value="50-80">50 - 80 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                  <option data-ref='80-100' value="80-100">80 - 100 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                  <option data-ref='100-150' value="100-150">100 - 150 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                  <option data-ref='150-200' value="150-200">150 - 200 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                  <option data-ref='200-250' value="200-250">200 - 250 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                  <option data-ref='250-300' value="250-300">250 - 300 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                  <option data-ref='300-500' value="300-500">300 - 500 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                  <option data-ref='500' value="500">&gt;= 500 <?php echo __('sqm', 'mycasa-elementor'); ?></option>
                </select>
              </div>
            </div>
          </div>

          <div class="banner-search-field-bedroom-wrap elementor-field-group elementor-column form-group elementor-col-20">
            <label for="banner-search-field-bedroom" class="elementor-field-label"><?php echo __('Bedroom Number', 'mycasa-elementor'); ?></label>
            <div class="elementor-field elementor-select-wrapper">
              <div class="dropdown bootstrap-select houzez-field-textual form-control elementor-size-sm banner-search-adv-field">
                <select data-size="5" name="bedroom_number" id="banner-search-field-bedroom" class="selectpicker houzez-field-textual form-control elementor-size-sm" data-none-results-text="No results matched {0}" tabindex="null" <?php echo $$field_disabled; ?>>
                  <option data-ref='' value=""><?php echo __('Select Bedroom', 'mycasa-elementor') ?></option>
                  <option data-ref='1' value="1">1</option>
                  <option data-ref='2' value="2">2</option>
                  <option data-ref='3' value="3">3</option>
                  <option data-ref='4' value="4">4</option>
                  <option data-ref='5' value="5">5+</option>
                </select>
              </div>
            </div>
          </div>

        </div>
      </div>
      <a class="advanced-search-btn" data-toggle="collapse" href="#advanced-search-filters" aria-expanded="true">
        <i class="houzez-icon icon-cog mr-1"></i> Advanced
      </a>
    </div>
    <?php endif; ?>
  </div><!-- End wrapper-->
</form>
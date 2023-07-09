<?php

/**
 * Provide a admin area view for the plugin's advanced settings
 *
 * This file is used to markup the advanced admin-facing aspects of the plugin.
 *
 * @link       https://cloudimage.io
 * @since      3.0.0
 *
 * @package    Cloudimage
 * @subpackage Cloudimage/admin/partials
 */
?>

<?php
// Grab all options
$options = get_option($this->plugin_name);

$skip_classes = isset($options['cloudimage_skip_classes'])
    ? $options['cloudimage_skip_classes'] : ''; // string separated by comma (,)
$skip_files = isset($options['cloudimage_skip_files'])
    ? $options['cloudimage_skip_files'] : ''; // string separated by comma (,)
$srcset_widths = isset($options['cloudimage_srcset_widths'])
    ? $options['cloudimage_srcset_widths'] : ''; // string separated by comma (,)
$replaceable_text = isset($options['cloudimage_replaceable_text'])
    ? $options['cloudimage_replaceable_text'] : '';
$replacement_text = isset($options['cloudimage_replacement_text'])
    ? $options['cloudimage_replacement_text'] : '';
$enable_srcset = isset($options['cloudimage_enable_srcset'])
    ? $options['cloudimage_enable_srcset'] : 0; // 0 = disabling, 1 = enabling
$disable_image_downsize_filter = isset($options['cloudimage_disable_image_downsize_filter'])
    ? $options['cloudimage_disable_image_downsize_filter'] : 0; // 0 = enabling, 1 = disabling



$content_filter_method = isset($options['cloudimage_content_filter_method'])
    ? $options['cloudimage_content_filter_method'] : 0; // 0 = ob_buffer, 1 = the_content
$javascript_libraries_host = isset($options['cloudimage_javascript_libraries_host'])
    ? $options['cloudimage_javascript_libraries_host'] : 0; // 0 = cdn, 1 = local
$ignore_node_img_size = isset($options['cloudimage_ignore_node_img_size'])
    ? $options['cloudimage_ignore_node_img_size'] : 0; // 0 = false, 1 = true
$save_node_img_ratio = isset($options['cloudimage_save_node_img_ratio'])
    ? $options['cloudimage_save_node_img_ratio'] : 0; // 0 = false, 1 = true
$ignore_style_img_size = isset($options['cloudimage_ignore_style_img_size'])
    ? $options['cloudimage_ignore_style_img_size'] : 0; // 0 = false, 1 = true
$destroy_node_img_size = isset($options['cloudimage_destroy_node_img_size'])
    ? $options['cloudimage_destroy_node_img_size'] : 0; // 0 = false, 1 = true
$detect_image_node_css = isset($options['cloudimage_detect_image_node_css'])
    ? $options['cloudimage_detect_image_node_css'] : 0; // 0 = false, 1 = true
$process_only_width = isset($options['cloudimage_process_only_width'])
    ? $options['cloudimage_process_only_width'] : 0; // 0 = false, 1 = true
$disable_settimeout_checks = isset($options['cloudimage_disable_settimeout_checks'])
    ? $options['cloudimage_disable_settimeout_checks'] : 0; // 0 =  don't use, 1 = use
$CDNize_static_files = isset($options['cloudimage_cdnize_static_files'])
    ? $options['cloudimage_cdnize_static_files'] : 0; // 0 =  don't use, 1 = use

$both_mode_switches = [
   
    [
        'id' => 'disable_image_downsize_filter',
        'label' => 'Disable image downsize filter',
        'tooltip' => 'Filter to scale an image to fit a particular size. OFF for enabling the filter, ON for disabling the filter.',
        'value' => $disable_image_downsize_filter
    ]
];

$backend_fields = [

  
    [
        'id' => 'srcset_widths',
        'label' => 'Srcset widths (px)',
        'tooltip' => 'The widths in pixels that would be generated for srcset tag if srcset adding option is enabled.',
        'description' => 'Separated by comma (,)',
        'placeholder' => 'default: 320,576,940,1080',
        'value' => $srcset_widths
    ],
    [
        'id' => 'replaceable_text',
        'label' => 'Replaceable text',
        'tooltip' => 'The text you want to replace it with another value while adding the domain prefix.',
        'description' => 'ex: https://example.com/wp-content/images-uploaded',
        'placeholder' => 'example: https://example.com/wp-content/images-uploaded',
        'value' => $replaceable_text
    ],
    [
        'id' => 'replacement_text',
        'label' => 'Replacement text',
        'tooltip' => 'The text value that would be replaced with the replaceable text.',
        'description' => 'ex: __uploaded__',
        'placeholder' => 'example: __uploaded__',
        'value' => $replacement_text
    ]
];

$backend_switches = [
  
    [
        'id' => 'enable_srcset',
        'label' => 'Enable srcset adding',
        'tooltip' => 'Adding srcset for img tag. OFF for disabling, ON for enabling.',
        'value' => $enable_srcset
    ]
];

$JS_fields = [
    [
        'id' => 'skip_classes',
        'label' => 'Skip classes',
        'tooltip' => 'HTML tags with the specified classes would be skipped',
        'description' => 'Separated by comma (,)',
        'placeholder' => 'example: class,other_class,example-class',
        'value' => $skip_classes
    ],
    [
        'id' => 'skip_files',
        'label' => 'Skip files',
        'tooltip' => 'Files with these extensions would be skipped',
        'description' => 'Without dot (.) and separated by comma (,)',
        'placeholder' => 'example: ico,jpg,png',
        'value' => $skip_files
    ]
];

$JS_switches = [
    [
        'id' => 'content_filter_method',
        'label' => 'Use WordPress filter method',
        'tooltip' => 'The way of filtering page\'s content. OFF for using \'ob_buffer\' PHP function, ON for using \'the_content\' filter from wordPress.',
        'value' => $content_filter_method
    ],
    [
        'id' => 'javascript_libraries_host',
        'label' => 'Local JavaScript libraries',
        'tooltip' => 'The host where libraries files would be imported from. OFF for CDN\'s files, ON for plugin\'s local files.',
        'value' => $javascript_libraries_host
    ],
    

    [
        'id' => 'ignore_node_img_size',
        'label' => 'Ignore image node size',
        'tooltip' => 'OFF for caring, ON for ignoring.',
        'value' => $ignore_node_img_size
    ],
    [
        'id' => 'save_node_img_ratio',
        'label' => 'Save image node ratio ',
        'tooltip' => 'OFF for skipping, ON for saving.',
        'value' => $save_node_img_ratio
    ],
    [
        'id' => 'ignore_style_img_size',
        'label' => 'Ignore style image size',
        'tooltip' => 'OFF for caring, ON for ignoring.',
        'value' => $ignore_style_img_size
    ],
    [
        'id' => 'destroy_node_img_size',
        'label' => 'Destroy node image size',
        'tooltip' => 'OFF for skipping, ON for destorying. ',
        'value' => $destroy_node_img_size
    ],
    [
        'id' => 'detect_image_node_css',
        'label' => 'Detect image node css',
        'tooltip' => 'OFF for skipping, ON for detecting. ',
        'value' => $detect_image_node_css
    ],
    [
        'id' => 'process_only_width',
        'label' => 'Process only width',
        'tooltip' => 'OFF for skipping, ON for processing. ',
        'value' => $process_only_width
    ],
    [
        'id' => 'disable_settimeout_checks',
        'label' => 'Disable setTimeout checks',
        'tooltip' => 'Used to process dynamically loaded images. OFF for enabling, ON for disabling. ',
        'value' => $disable_settimeout_checks
    ]
];

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="cloudimg-plugin-container">
    <div class="cloudimg-lower">
        <form method="post" name="cloudimg_settings" action="options.php" class="cloudimg-boxes">
            <?php
            settings_fields($this->plugin_name);
            ?>
            <input type="hidden" name="advanced_settings" value="1"/>
            <div class="cloudimg-box">
                <div class="content-container">
                    <h1><?php esc_attr_e('Advanced settings', 'cloudimage'); ?></h1>
                    <fieldset>
                        <legend>Javascript mode</legend>
                        <table class="form-table">
                            <tbody>
                            <?php foreach ($JS_fields as $field) : ?>
                                <tr>
                                    <th scope="row" class="titledesc">
                                        <label for="<?php echo esc_attr($this->plugin_name . '-' . $field['id']); ?>">
                                            <?php esc_attr_e($field['label'], 'cloudimage'); ?>
                                            <div class="tooltip">?
                                                <span class="tooltiptext"><?php esc_attr_e($field['tooltip'], 'cloudimage'); ?></span>
                                            </div>
                                        </label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input type="text" id="<?php echo esc_attr($this->plugin_name . '-' . $field['id']); ?>"
                                               placeholder="<?php echo esc_attr($field['placeholder']); ?>"
                                               name="<?php echo esc_attr($this->plugin_name . '[' . $field['id'] . ']'); ?>"
                                               class="widefat"
                                               value="<?php if (!empty($field['value'])) echo esc_textarea($field['value']); ?>">
                                        <div class="cloudimage__description">
                                            <?php esc_attr_e($field['description'], 'cloudimage'); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                            foreach ($JS_switches as $switch) : ?>
                                <tr>
                                    <th scope="row" class="titledesc">
                                        <label for="<?php echo esc_attr($this->plugin_name . '-' . $switch['id']); ?>">
                                            <?php esc_attr_e($switch['label'], 'cloudimage'); ?>
                                            <div class="tooltip">?
                                                <span class="tooltiptext"><?php esc_attr_e($switch['tooltip'], 'cloudimage'); ?></span>
                                            </div>
                                        </label>
                                    </th>

                                    <td class="forminp forminp-text">
                                        <label class="switch">
                                            <input type="checkbox"
                                                   id="<?php echo esc_attr($this->plugin_name . '-' . $switch['id']); ?>"
                                                   name="<?php echo esc_attr($this->plugin_name . '[' . $switch['id'] . ']'); ?>" <?php checked($switch['value'], 1); ?> >
                                            <span class="slider round"></span>
                                        </label>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </fieldset>

                    <hr/>

                    <fieldset>
                        <legend>Backend mode</legend>
                        <table class="form-table">
                            <tbody>
                            <?php foreach ($backend_switches as $switch) : ?>
                                <tr>
                                    <th scope="row" class="titledesc">
                                        <label for="<?php echo esc_attr($this->plugin_name . '-' . $switch['id']); ?>">
                                            <?php esc_attr_e($switch['label'], 'cloudimage'); ?>
                                            <div class="tooltip">?
                                                <span class="tooltiptext"><?php esc_attr_e($switch['tooltip'], 'cloudimage'); ?></span>
                                            </div>
                                        </label>
                                    </th>

                                    <td class="forminp forminp-text">
                                        <label class="switch">
                                            <input type="checkbox"
                                                   id="<?php echo esc_attr($this->plugin_name . '-' . $switch['id']); ?>"
                                                   name="<?php echo esc_attr($this->plugin_name . '[' . $switch['id'] . ']'); ?>" <?php checked($switch['value'], 1); ?> >
                                            <span class="slider round"></span>
                                        </label>

                                    </td>
                                </tr>
                            <?php endforeach;
                            foreach ($backend_fields as $field) : ?>
                                <tr>
                                    <th scope="row" class="titledesc">
                                        <label for="<?php echo esc_attr($this->plugin_name . '-' . $field['id']); ?>">
                                            <?php esc_attr_e($field['label'], 'cloudimage'); ?>
                                            <div class="tooltip">?
                                                <span class="tooltiptext"><?php esc_attr_e($field['tooltip'], 'cloudimage'); ?></span>
                                            </div>
                                        </label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input type="text" id="<?php echo esc_attr($this->plugin_name . '-' . $field['id']); ?>"
                                               placeholder="<?php echo esc_attr($field['placeholder']); ?>"
                                               name="<?php echo esc_attr($this->plugin_name . '[' . $field['id'] . ']'); ?>"
                                               class="widefat"
                                               value="<?php if (!empty($field['value'])) echo esc_textarea($field['value']); ?>">
                                        <div class="cloudimage__description">
                                            <?php esc_attr_e($field['description'], 'cloudimage'); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </fieldset>

                    <hr/>

                    <fieldset>
                        <legend>Both modes (Backend & JS)</legend>
                        <table class="form-table">
                            <tbody>
                            <?php foreach ($both_mode_switches as $switch) : ?>
                                <tr>
                                    <th scope="row" class="titledesc">
                                        <label for="<?php echo esc_attr($this->plugin_name . '-' . $switch['id']); ?>">
                                            <?php esc_attr_e($switch['label'], 'cloudimage'); ?>
                                            <div class="tooltip">?
                                                <span class="tooltiptext"><?php esc_attr_e($switch['tooltip'], 'cloudimage'); ?></span>
                                            </div>
                                        </label>
                                    </th>

                                    <td class="forminp forminp-text">
                                        <label class="switch">
                                            <input type="checkbox"
                                                   id="<?php echo esc_attr($this->plugin_name . '-' . $switch['id']); ?>"
                                                   name="<?php echo esc_attr($this->plugin_name . '[' . $switch['id'] . ']'); ?>" <?php checked($switch['value'], 1); ?> >
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </fieldset>

                    <?php submit_button(__('Save all changes', 'cloudimage'), ['primary', 'large', 'cloudimage-save'], 'submit', true); ?>
                </div>
            </div>


            <div class="cloudimg-box">
                <h4>
                    <?php _e('Notes about compatibility: The current version of the plugin optimizes all images included in the final HTML, generated from every theme or plugin. It will not optimize images in the external CSS files (background-image properties), which are more challenging to detect. ', 'cloudimage'); ?>
                </h4>
            </div>

            <br>

            <div class="cloudimg-box">
                <h4>
                    <?php _e('To your Cloudimage administration panel for all configuration options:', 'cloudimage'); ?>
                    <a href="https://admin.cloudimage.io" class="cloudimage-link" target="_blank">
                        <?php _e('Cloudimage Admin ', 'cloudimage'); ?>
                    </a>
                </h4>
            </div>
        </form>
    </div>
</div>
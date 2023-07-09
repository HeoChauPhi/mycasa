<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://cloudimage.io
 * @since      1.0.0
 *
 * @package    Cloudimage
 * @subpackage Cloudimage/admin/partials
 */
?>

<?php
// Grab all options
$options = get_option($this->plugin_name);

$domain = $options['cloudimage_domain'];
$removes_v7 = isset($options['cloudimage_removes_v7'])
    ? $options['cloudimage_removes_v7'] : 0; // 0 = enabling, 1 = disabling
$use_js_powered_mode = isset($options['cloudimage_use_js_powered_mode'])
    ? $options['cloudimage_use_js_powered_mode'] : 0;
$use_for_logged_in_users = isset($options['cloudimage_use_for_logged_in_users'])
    ? $options['cloudimage_use_for_logged_in_users'] : 0;


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="cloudimg-plugin-container">
    <div class="cloudimg-lower">
        <div class="cloudimg-box">
            <div class="content-container">
                <div class="top_part">
                    <div class="small-cloud-image">
                        <img src=" <?php echo plugin_dir_url(__FILE__); ?>../images/small_cloud.png" width="50"
                             alt="small cloud">
                    </div>
                    <div class="cloud-image">
                        <img src=" <?php echo plugin_dir_url(__FILE__); ?>../images/big_cloud.png" alt="big cloud">
                    </div>
                    <div class="a_logo">
                        <a target="_blank" href="http://cloudimg.io/">
                              <img src=" <?php echo plugin_dir_url(__FILE__); ?>../images/logo_new_cloudimage.png"
                                 alt="cloudimage logo">
                        </a>
                    </div>
                    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                </div>


                <div class="intro_text">
                    <p class="big_p">
                        <?php esc_attr_e('Cloudimage will resize, compress and optimise your Wordpress images before delivering responsive images lightning fast over Content Delivery Networks all around the World. Simply add your Cloudimage token below and the plugin will do the magic automatically.', 'cloudimage') ?>
                    </p>
                    <?php if (!$domain) { ?>
                        <p class="big_p">
                            <?php esc_attr_e('To start using Cloudimage you will need to sign up for a Cloudimage account and obtain a Cloudimage token. Sign up is free and takes only few seconds. ', 'cloudimage'); ?></p>
                        <p class="big_p">
                            <a href="https://www.cloudimage.io/en/register_page"
                               target="_blank"><?php esc_attr_e('Get your Cloudimage token', 'cloudimage'); ?></a>
                        </p>
                        <p class="big_p">
                            <?php _e('After signing up, please enter your Cloudimage token below:', 'cloudimage'); ?>
                        </p>
                    <?php } else { ?>
                        <p class="big_p">
                            <?php esc_attr_e('Thank you for connecting your Cloudimage account, you have successfully set up Cloudimage. If you need any help or have any concerns please drop us a message at ', 'cloudimage'); ?>
                            <a href="mailto:hello@cloudimage.io"
                               target="_blank"> <?php esc_attr_e('hello@cloudimage.io', 'cloudimage'); ?></a>.
                        </p>
                    <?php } ?>
                </div>
            </div>
        </div>


        <form method="post" name="cloudimg_settings" action="options.php" class="cloudimg-boxes">
            <?php
            settings_fields($this->plugin_name);
            do_settings_sections($this->plugin_name);
            ?>
            <div class="cloudimg-box">
                <div class="content-container">
                    <h1><?php esc_attr_e('Configuration', 'cloudimage'); ?></h1>
                    <table class="form-table">
                        <tbody>
                        <!-- domain -->
                        <tr>
                            <th scope="row" class="titledesc">
                                <label for="<?php echo esc_attr($this->plugin_name); ?>-domain" class="cloudimage-domain">
                                    <?php esc_attr_e('Cloudimage token or custom domain: ', 'cloudimage'); ?>
                                    <div class="tooltip">?
                                        <span class="tooltiptext"><?php esc_attr_e('Cloudimage token from your Cloudimage account', 'cloudimage') ?></span>
                                    </div>
                                </label>
                            </th>
                            <td class="forminp forminp-text">
                                <input type="text" id="<?php echo esc_attr($this->plugin_name); ?>-domain" placeholder="my-token"
                                       name="<?php echo esc_attr($this->plugin_name); ?>[domain]"
                                       class="widefat"
                                       value="<?php if (!empty($domain)) echo esc_textarea($domain); ?>">
                                <div class="cloudimage__description">
                                    <?php esc_attr_e('Enter token: ', 'cloudimage') ?>
                                    <code><?php esc_attr_e('for example azbxuwxXXX or img.acme.com', 'cloudimage') ?></code>
                                </div>
                            </td>
                        </tr>
                     
                        <tr>
                            <td colspan="2">
                            <span class="cloudimage-demo">
                                <?php esc_attr_e('By default, the plugin will resize all images and deliver them over the Cloudimage CDN. Your Theme\'s Wordpress native support for ', 'cloudimage') ?><i>srcset</i><?php esc_attr_e(' will continue to be used for delivering responsive images.', 'cloudimage') ?>
                                <br><br>
                                <?php esc_attr_e('Cloudimage offers a powerful alternative for enabling responsive images using the ', 'cloudimage') ?>
                                <a href="https://scaleflex.github.io/js-cloudimage-responsive/" target="_blank">Cloudimage Responsive Images JS plugin</a>
                                <?php esc_attr_e(' below:', 'cloudimage') ?>

                            </span>
                            </td>
                        </tr>

                        <!-- Use JS powered mode -->
                        <tr id="js-powered-section">
                            <th scope="row" class="titledesc">
                                <label for="<?php echo esc_attr($this->plugin_name); ?>-use_js_powered_mode">
                                    <?php esc_attr_e('Javascript mode', 'cloudimage'); ?>
                                    <div class="tooltip">?
                                        <span class="tooltiptext"><?php esc_attr_e('JavaScript Responsive Plugin works in the following directions: makes images responsive, adds lazyloading, and adds progressive loading effect.', 'cloudimage') ?></span>
                                    </div>
                                </label>
                            </th>

                            <td class="forminp forminp-text">
                                <label class="switch">
                                    <input type="checkbox" id="<?php echo esc_attr($this->plugin_name); ?>-use_js_powered_mode"
                                           name="<?php echo esc_attr($this->plugin_name); ?>[use_js_powered_mode]" <?php checked($use_js_powered_mode, 1); ?> >
                                    <span class="slider round"></span>
                                </label>

                            </td>
                        </tr>
                                 <!-- Remove v7 -->
                        <tr id="remove-v7-section">
                            <th scope="row" class="titledesc">
                                <label for="<?php echo esc_attr($this->plugin_name); ?>-removes_v7">
                                    <?php esc_attr_e('Remove v7', 'cloudimage'); ?>
                                    <div class="tooltip">?
                                        <span class="tooltiptext"><?php esc_attr_e('Removes the "/v7" part in URL format. Activate for token created after October 20th 2021', 'cloudimage') ?></span>
                                    </div>
                                </label>
                            </th>

                            <td class="forminp forminp-text">
                                <label class="switch">
                                    <input type="checkbox" id="<?php echo esc_attr($this->plugin_name); ?>-removes_v7"
                                           name="<?php echo esc_attr($this->plugin_name); ?>[removes_v7]" <?php checked($removes_v7, 1); ?> >
                                    <span class="slider round"></span>
                                </label>

                            </td>
                        </tr>

                        <!-- Use if user is logged in -->
                        <tr id="use-for-logged-in-users">
                            <th scope="row" class="titledesc">
                                <label for="<?php echo esc_attr($this->plugin_name); ?>-use_for_logged_in_users">
                                    <?php esc_attr_e('Use when logged in', 'cloudimage'); ?>
                                    <div class="tooltip">?
                                        <span class="tooltiptext"><?php esc_attr_e('Keep switching off if you\'d like to deactivate Cloudimage CDN delivery when a user is logged in. This will avoid using CDN bandwidth for test purposes for example.', 'cloudimage') ?></span>
                                    </div>
                                </label>
                            </th>

                            <td class="forminp forminp-text">
                                <label class="switch">
                                    <input type="checkbox" id="<?php echo esc_attr($this->plugin_name); ?>-use_for_logged_in_users"
                                           name="<?php echo esc_attr($this->plugin_name); ?>[use_for_logged_in_users]" <?php checked($use_for_logged_in_users, 1); ?> >
                                    <span class="slider round"></span>
                                </label>

                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <div class="warning-wrapper">
                        <p><?php _e('We recommend checking all pages, after turning on Cloudimage JavaScript Plugin, especially on JavaScript-heavy themes. Cloudimage plugin filters all the HTML content on your website. For that reason, it is a good idea to use a caching plugin for the changes to be cached.', 'cloudimage'); ?></p>
                        <p><?php _e('Please check your website in Incognito mode of the browser. We disabled image optimization when the current user is logged to WP-admin to save CDN traffic.', 'cloudimage'); ?></p>
                    </div>

                    <?php submit_button(__('Save all changes', 'cloudimage'), ['primary', 'large', 'cloudimage-save'], 'submit', true); ?>
                    <h4>
                        <a href="?page=cloudimage-advanced" class="cloudimage-link">
                            <strong>
                                <?php _e('Open Advanced settings', 'cloudimage'); ?>
                            </strong>
                        </a>
                    </h4>
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
                    <a href="https://www.cloudimage.io/en/login" class="cloudimage-link" target="_blank">
                        <?php _e('Cloudimage Admin ', 'cloudimage'); ?>
                    </a>
                </h4>
            </div>
        </form>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        //Variables initialization
        var cloudimage_use_js_powered_mode = jQuery('#cloudimage-use_js_powered_mode');
        var cloudimage_current_mode = jQuery('#cloudimage-current-mode');

        //Check if JavaScript is enabled to display lazy loading section
        if (cloudimage_use_js_powered_mode.is(':checked')) {
            // cloudimage_current_mode.text("JS Powered");
        } else {
            // cloudimage_current_mode.text("PHP Powered");
        }

        //Attach event to change of Cloudimage use resposnive JS checkbox
        cloudimage_use_js_powered_mode.change(function () {
            if (this.checked) {
                //If checked - show additional table row with checkbox
                // cloudimage_current_mode.text("JS Powered");

            } else {
                //If turned off - hide the additional table row and unmark the checkbox
                // cloudimage_current_mode.text("PHP Powered");
            }
        });

    });
</script>

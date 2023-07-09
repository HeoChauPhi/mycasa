<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cloudimage.io
 * @since      1.0.0
 *
 * @package    Cloudimage
 * @subpackage Cloudimage/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cloudimage
 * @subpackage Cloudimage/admin
 * @author     Cloudimage <hello@cloudimage.io>
 */
class Cloudimage_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Is Dev env.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $is_dev
     */
    private $is_dev;

    /**
     * The plugin menu container slug
     *
     * @since    3.0.0
     * @access   private
     * @var      string $main_menu_slug The slug of the menu.
     */
    private $main_menu_slug;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @param bool $is_dev Check if environnement is local or not
     *
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version, $is_dev = false)
    {

        $this->is_dev = $is_dev;
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->cloudimage_options = get_option($this->plugin_name);
        $this->main_menu_slug = $this->plugin_name . '-menu';

    }


    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cloudimage-admin.css', array(), $this->version, 'all');

    }


    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        return null;
    }


    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu()
    {
        $generalPageTitle = 'Welcome to the Cloudimage WordPress Plugin';

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        add_menu_page(
            $generalPageTitle,
            'Cloudimage',
            '',
            $this->main_menu_slug,
            array($this, 'display_plugin_general_page'),
            plugin_dir_url(__FILE__) . '../admin/images/cloudimage_icon.png'
        );

        add_submenu_page(
            $this->main_menu_slug,
            $generalPageTitle,
            'General',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_general_page')
        );

        add_submenu_page(
            $this->main_menu_slug,
            'Advanced settings - Cloudimage WordPress Plugin',
            'Advanced',
            'manage_options',
            $this->plugin_name . '-advanced',
            array($this, 'display_plugin_advanced_page')
        );
    }


    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links($links)
    {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url('admin.php?page=' . $this->plugin_name) . '">' . __('Settings', 'cloudimage') . '</a>',
        );

        return array_merge($settings_link, $links);
    }


    /**
     * Render the general settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_general_page()
    {
        include_once('partials/cloudimage-admin-general-display.php');
    }


    /**
     * Render the advanced settings page for this plugin.
     *
     * @since    3.0.0
     */
    public function display_plugin_advanced_page()
    {
        include_once('partials/cloudimage-admin-advanced-display.php');
    }


    /**
     * Validate data from admin
     *
     * @version  2.0.5
     * @since    1.0.0
     */
    public function validate($input)
    {
        // All options
        $valid = get_option($this->plugin_name);

        if (!isset($_POST['advanced_settings'])) {
            //Cleanup
            if (isset($input['domain'])) {
                if (!empty($input['domain']) && strpos($input['domain'], '.') === false) {
                    $valid['domain'] = $valid['cloudimage_domain'] = trim($input['domain'] . '.cloudimg.io', " .?");
                } else {
                    $valid['domain'] = $valid['cloudimage_domain'] = trim($input['domain'], " .?");
                }
            }

            $switches = ['use_js_powered_mode', 'use_for_logged_in_users','removes_v7'];
        } else {
            $switches = [
                'enable_srcset',
                'disable_image_downsize_filter',
                'content_filter_method',
                'javascript_libraries_host',
                'ignore_node_img_size',
                'save_node_img_ratio',
                'ignore_style_img_size',
                'destroy_node_img_size',
                'detect_image_node_css',
                'process_only_width',
                'disable_settimeout_checks',
                'cdnize_static_files',
                
            ];
            
            $valid['cloudimage_skip_files'] = trim($input['skip_files']);
            $valid['cloudimage_skip_classes'] = trim($input['skip_classes']);
            $valid['cloudimage_srcset_widths'] = trim($input['srcset_widths']);
            $valid['cloudimage_replaceable_text'] = trim($input['replaceable_text']);
            $valid['cloudimage_replacement_text'] = trim($input['replacement_text']);
        }
        
        foreach ($switches as $switch) {
            $valid['cloudimage_' . $switch] = empty($input[$switch]) ? 0 : 1;
        }

        return $valid;
    }


    /**
     * Register option once they are updated
     *
     * @since    1.0.0
     */
    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }


    /**
     * Add notice if domain is not set
     *
     * @since    1.0.0
     */
    public function cloudimage_admin_notice_no_domain()
    {
        $class = 'notice notice-warning';
        $message = __('Cloudimage is almost ready. To get started, please fill your cloudimage domain : ', 'cloudimage');

        if (!$this->cloudimage_options['cloudimage_domain']) {
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message) . '<a href="' . admin_url('admin.php?page=' . $this->plugin_name) . '">here</a>');
        }
    }


    /**
     * Add notice if we are on Localhost
     *
     * @since    1.0.0
     */
    public function cloudimage_admin_notice_localhost()
    {
        $class = 'notice notice-warning';
        $message = __('Cloudimage has been disable because your are running on localhost. Cloudimage needs accessible URL to work', 'cloudimage');

        if ($this->is_dev) {
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
        }
    }


}

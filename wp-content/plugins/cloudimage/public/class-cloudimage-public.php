<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cloudimage.io
 * @since      1.0.0
 *
 * @package    Cloudimage
 * @subpackage Cloudimage/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cloudimage
 * @subpackage Cloudimage/public
 * @author     Cloudimage <hello@cloudimage.io>
 */
class Cloudimage_Public
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
     * Cloudimage domain
     *
     * @since    2.0.0
     * @access   private
     * @var      string $cloudimage_domain The domain enter in the admin
     */
    private $cloudimage_domain;


    /**
     * Define if the JavaScript powered mode should be used
     * @since    2.6.0
     * @access   private
     * @var string $cloudimage_use_js_powered_mode 0 or 1 regarding is JS powered mode enabled
     */
    private $cloudimage_use_js_powered_mode;

    /**
     * Define all the classes you want to skip in content filtering - only used in $cloudimage_use_responsive_js
     *
     * @since    2.0.0
     * @access   private
     * @var      string $cloudimage_skip_classes string that need to be split with ','
     */
    private $cloudimage_skip_classes;

    /**
     * Define if Cloudimage optimization should work when user is logged-in
     *
     * @since    2.9.0
     * @access   private
     * @var      int $cloudimage_use_in_admin 0 or 1 regarding is optimization should work when users are logged in
     */
    private $cloudimage_use_for_logged_in_users;

    /**
     * Define all the files types you want to skip in content filtering - only used in $cloudimage_use_responsive_js
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_skip_files string that need to be split with ','
     */
    private $cloudimage_skip_files;

    /**
     * Define the widths that would be generated for srcset tag if enabled
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_srcset_widths string that need to be split with ','
     */
    private $cloudimage_srcset_widths;

    /**
     * Define the text that would be replaced while prefixing the domain
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_replaceable_text string
     */
    private $cloudimage_replaceable_text;

    /**
     * Define the text the would replace the replaceable text while prefixing the domain
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_replacement_text string
     */
    private $cloudimage_replacement_text;

    /**
     * Define is to add srcset to img tag if the theme doesn't support the srcset or not
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_enable_srcset 0 or 1 for disable or enable.
     */
    private $cloudimage_enable_srcset;

    /**
     * Define which filtering method should be used for content
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_content_filter_method 0 or 1 for ob_buffer or the_content regarding which method to use in filtering the content
     */
    private $cloudimage_content_filter_method;

    /**
     * Define which filtering method should be used for content
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_javascript_libraries_host 0 or 1 for cdn or local, is used to determine from which place to load the js libs.
     */
    private $cloudimage_javascript_libraries_host;

    /**
     * Define which to use ignoreNodeImgSize property in JS mode or not
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_ignore_node_img_size 0 or 1 for false or true
     */
    private $cloudimage_ignore_node_img_size;

    /**
     * Define which to use saveNodeImgRatio property in JS mode or not
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_save_node_img_ratio 0 or 1 for false or true
     */
    private $cloudimage_save_node_img_ratio;

    /**
     * Define which to use ignoreStyleImgSize property in JS mode or not
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_ignore_style_img_size 0 or 1 for false or true
     */
    private $cloudimage_ignore_style_img_size;

    /**
     * Define which to use destroyNodeImgSize property in JS mode or not
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_destroy_node_img_size 0 or 1 for false or true
     */
    private $cloudimage_destroy_node_img_size;

    /**
     * Define which to use detectImageNodeCSS property in JS mode or not
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_detect_image_node_css 0 or 1 for false or true
     */
    private $cloudimage_detect_image_node_css;

    /**
     * Define which to use processOnlyWidth property in JS mode or not
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_process_only_width 0 or 1 for false or true
     */
    private $cloudimage_process_only_width;


    /**
     * Define which to use processOnlyWidth property in JS mode or not
     *
     * @since    3.0.0
     * @access   private
     * @var      int $cloudimage_settimeout_checks 0 or 1 for false or true
     */
    private $cloudimage_disable_settimeout_checks;

    /**
     * Removes v7 parameter if not needed
     *
     * @since    latest
     * @access   private
     * @var      int $cloudimage_removes_v7 0 or 1 for false or true
     */
    private $cloudimage_removes_v7;


    /**
     * Define the default widths for srcset tag to be used if the srcset on backend is enabled
     * and no widths are set from user
     *
     * @since    3.0.0
     * @access   private
     * @var      array $default_srcset_widths the default widths values
     */
    private $default_srcset_widths = array(320, 576, 940, 1080);

       /**
     * Define if to deliver the website's static files through the CDN or not.
     *
     * @since    3.0.3
     * @access   private
     * @var      int $cloudimage_CDNize_static_files 0 or 1 for false or true
     */
    private $cloudimage_CDNize_static_files;
    
    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @param bool $is_dev Check if environnement is local or not
     *
     * @version  2.0.5
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version, $is_dev)
    {
        $this->is_dev = $is_dev;
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->cloudimage_options = get_option($this->plugin_name);

        $this->cloudimage_domain = isset($this->cloudimage_options['cloudimage_domain']) ? $this->cloudimage_options['cloudimage_domain'] : '';
        $this->cloudimage_use_js_powered_mode = isset($this->cloudimage_options['cloudimage_use_js_powered_mode']) ? $this->cloudimage_options['cloudimage_use_js_powered_mode'] : 0;
        $this->cloudimage_skip_classes = isset($this->cloudimage_options['cloudimage_skip_classes']) ? $this->cloudimage_options['cloudimage_skip_classes'] : '';
        $this->cloudimage_skip_files = isset($this->cloudimage_options['cloudimage_skip_files']) ? $this->cloudimage_options['cloudimage_skip_files'] : '';
        $this->cloudimage_srcset_widths = isset($this->cloudimage_options['cloudimage_srcset_widths']) ? $this->cloudimage_options['cloudimage_srcset_widths'] : '';
        $this->cloudimage_replaceable_text = isset($this->cloudimage_options['cloudimage_replaceable_text']) ? $this->cloudimage_options['cloudimage_replaceable_text'] : '';
        $this->cloudimage_replacement_text = isset($this->cloudimage_options['cloudimage_replacement_text']) ? $this->cloudimage_options['cloudimage_replacement_text'] : '';
        $this->cloudimage_enable_srcset = isset($this->cloudimage_options['cloudimage_enable_srcset']) ? $this->cloudimage_options['cloudimage_enable_srcset'] : 0;
        $this->cloudimage_content_filter_method = isset($this->cloudimage_options['cloudimage_content_filter_method']) ? $this->cloudimage_options['cloudimage_content_filter_method'] : 0;
        $this->cloudimage_javascript_libraries_host = isset($this->cloudimage_options['cloudimage_javascript_libraries_host']) ? $this->cloudimage_options['cloudimage_javascript_libraries_host'] : 0;
        $this->cloudimage_ignore_node_img_size = isset($this->cloudimage_options['cloudimage_ignore_node_img_size']) ? $this->cloudimage_options['cloudimage_ignore_node_img_size'] : 0;
        $this->cloudimage_save_node_img_ratio = isset($this->cloudimage_options['cloudimage_save_node_img_ratio']) ? $this->cloudimage_options['cloudimage_save_node_img_ratio'] : 0;
        $this->cloudimage_ignore_style_img_size = isset($this->cloudimage_options['cloudimage_ignore_style_img_size']) ? $this->cloudimage_options['cloudimage_ignore_style_img_size'] : 0;
        $this->cloudimage_destroy_node_img_size = isset($this->cloudimage_options['cloudimage_destroy_node_img_size']) ? $this->cloudimage_options['cloudimage_destroy_node_img_size'] : 0;
        $this->cloudimage_detect_image_node_css = isset($this->cloudimage_options['cloudimage_detect_image_node_css']) ? $this->cloudimage_options['cloudimage_detect_image_node_css'] : 0;
        $this->cloudimage_process_only_width = isset($this->cloudimage_options['cloudimage_process_only_width']) ? $this->cloudimage_options['cloudimage_process_only_width'] : 0;
        $this->cloudimage_disable_settimeout_checks = isset($this->cloudimage_options['cloudimage_disable_settimeout_checks']) ? $this->cloudimage_options['cloudimage_disable_settimeout_checks'] : 0;
        $this->cloudimage_use_for_logged_in_users = isset($this->cloudimage_options['cloudimage_use_for_logged_in_users']) ? $this->cloudimage_options['cloudimage_use_for_logged_in_users'] : 0;
        $this->cloudimage_removes_v7 = isset($this->cloudimage_options['cloudimage_removes_v7']) ? $this->cloudimage_options['cloudimage_removes_v7'] : 0;
         $this->cloudimage_CDNize_static_files = isset($this->cloudimage_options['cloudimage_cdnize_static_files']) ? $this->cloudimage_options['cloudimage_cdnize_static_files'] : 0;

    }


    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        return null;
    }


    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @version  2.0.5
     * @since    1.0.0
     *
     */
    public function enqueue_scripts()
    {
        $cloudimage_domain = $this->cloudimage_domain;
        $use_js_powered_mode = $this->cloudimage_use_js_powered_mode;

        if (isset($cloudimage_domain) && $use_js_powered_mode) {
            if ($this->cloudimage_javascript_libraries_host) {
                $dir = plugin_dir_url(__FILE__);
                $jsLib = $dir . 'js/js-cloudimage-responsive.min.js';
                $lazySizesLib = $dir . 'js/lazysizes.min.js';
            } else {
                $jsLib = 'https://cdn.scaleflex.it/plugins/js-cloudimage-responsive/4.8.3/wp/js-cloudimage-responsive.min.js';
                $lazySizesLib = 'https://cdn.scaleflex.it/filerobot/js-cloudimage-responsive/lazysizes.min.js';
            }
            // Initialize only JavaScipt repsonsive scripts for basic Cloudimage library
            wp_enqueue_script('js-cloudimage-responsive', $jsLib, ['lazysizes'], 3, true);
            wp_add_inline_script('js-cloudimage-responsive', $this->initializeResponsivePlugin());

            // Initialize the lazy loading scripts
            wp_enqueue_script('lazysizes', $lazySizesLib, [], null, true);
            wp_add_inline_script('lazysizes', $this->initializeLazysizesPlugin(), 'before');

        }
    }


    /**
     * Filters the attachment's url - apply on filter  wp_get_attachment_url
     * (https://core.trac.wordpress.org/browser/tags/4.8/src/wp-includes/post.php#L5077)
     *
     * @param string $url
     * @param int $post_id
     *
     * @return string
     *
     * @since    2.0.0
     */
    public function filter_cloudimage_wp_get_attachment_url($url, $post_id)
    {
        # Check if we need to perform the optimization for the current user state (logged in or not)
        $logged_in_user = $this->cloudimage_check_logged_user();

        if ($this->is_dev || !$this->cloudimage_domain || $logged_in_user) {
            return $url;
        }

        $res_url = $this->cloudimage_get_url($post_id, false, $url);
        
        

        if (!$res_url) {
            return $url;
        }

        return $res_url;
    }


    /**
     * Filters the image srcset urls and convert them to cloudimage.
     * apply on filter wp_calculate_image_srcset
     * (https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/media.php#L1045)
     *
     * @param string $url
     * @param int $post_id
     *
     * @return array
     *
     * @since    2.0.0
     */
    public function filter_cloudimage_wp_calculate_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id)
    {
        
        # Check if we need to perform the optimization for the current user state (logged in or not)
        $logged_in_user = $this->cloudimage_check_logged_user();

        if ($this->is_dev || !$this->cloudimage_domain || $logged_in_user) {
            # Return original sources
            return $sources;
        }

        if ($this->cloudimage_use_js_powered_mode) {
            return [];
        }

        if ($attachment_id) {
            // Get the image src for full size
            $img_src = wp_get_attachment_image_src($attachment_id, 'full');
        }

        // Support of the defined in the theme srcset values
        foreach ($sources as $img_width => &$source) {
            $source['url'] = $this->cloudimage_build_url($img_src[0], null, ['w' => $img_width]);
        }

        /*
         * Support for scrset for themes without
         *
         *
        */
        if ($this->cloudimage_enable_srcset) {
            // Get the image URL
           
            $img_url = wp_get_attachment_url($attachment_id);

            // Remove the h in the query param
            $img_url = remove_query_arg('h', $img_url);
            $widths = $this->_get_srcset_widths();

            // Add support to additional srcset if the theme doesn't support them
            foreach ($widths as $width) {
                // Build the Cloudimage URL with the width
                $sources[$width]['url'] = $this->cloudimage_build_url($img_url, null, ['w' => $width]);
                $sources[$width]['descriptor'] = 'w';
                $sources[$width]['value'] = $width;
            }
        }

        return $sources;
    }


    /**
     * Filters whether to preempt the output of image_downsize().
     * (https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/media.php#L182)
     *
     * @param $downsize Whether to short-circuit the image downsize. Default false.
     * @param $id Attachment ID for image.
     * @param $size Size of image. Image size or array of width and height values (in that order).
     *                Default 'medium'.
     *
     * @return array|bool
     */
    public function filter_cloudimage_image_downsize($short_cut, $id, $size)
    {
        # Check if we need to perform the optimization for the current user state (logged in or not)
        $logged_in_user = $this->cloudimage_check_logged_user();

        if ($short_cut || $this->is_dev || !$this->cloudimage_domain || $this->cloudimage_use_js_powered_mode || $logged_in_user) {
            return false;
        }

        // Solving the issue with data-o_data-large_image_width in WooCommerce product page
        if ($size == "full") {
            return false;
        }

        return $this->cloudimage_get_url($id, $size);
    }


    /**
     * Filters whether to modify the whole HTML return.
     * (https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/media.php#L182)
     *
     * @param $content the whole HTML of the page
     *
     * @return string
     *
     * @version  2.0.5
     * @since    1.0.0
     */
   public function filter_cloudimage_the_content($content)
    {
        if ($this->is_dev || !$this->cloudimage_domain) {
            return $content;
        }

        if ($this->cloudimage_use_js_powered_mode) {

            $match_content = $this->_get_content_haystack($content);

            // Construct Cloudimage prefix in both cases - custom domain or token
            
             if (!empty($this->cloudimage_removes_v7)){
         $cloudimg_prefix = "https://" . $this->cloudimage_domain . "/";
        }
        else{
            $cloudimg_prefix = "https://" . $this->cloudimage_domain . "/v7/";
        }



            $files_matched_tags = array();

            $images_extensions_ORed = 'jpg|jpeg|png|gif|svgz|webp|ico|bmp|tiff|tif|jpe|jif|jfif|jfi|jp2|j2k|jpf|jpx|jpm|mj2';
            $static_files_ORed = 'js|css|json|mp3|mp4|ogg|mpg|mpeg|avi|swf|flv|webm';

            $files_extensions_ORed = $images_extensions_ORed;

            if ($this->cloudimage_CDNize_static_files) {
                $files_extensions_ORed .= '|' . $static_files_ORed;
            }

            /* RegEX v1: '/<img[\s\r\n]+.*?>/is' */
            // This regex matches all the files with the extensions above inside whatever tag/attribute
            // ex. <img src="..." or background(-image)?: url('...')...etc.
            preg_match_all('/<.+?=[\'\"].*\.(?:' . $files_extensions_ORed . ')(?:\?.*)?[\'\"].*>/Ui', $match_content, $files_matched_tags);

            $search_files_tags = array();
            $replace_files_tags = array();

            if (!empty($files_matched_tags)) {
                foreach ($files_matched_tags[0] as $fileHTML) {

                    // don't do the replacement if an image with a data-uri or already a ci-src
                    if (!preg_match("/src=['\"]data:image/is", $fileHTML)
                        && !preg_match("/url\s*\(['\"]?data:image/is", $fileHTML)
                        && !preg_match("/ci-src=['\"].*['\"]/is", $fileHTML)
                        && !preg_match("/src=['\"](.*)\.svg['\"]/is", $fileHTML)
                        && !preg_match("/src=['\"](.*)cdninstagram.com/is", $fileHTML)
                        && !preg_match("/src=['\"](.*)cdn\.scaleflex/is", $fileHTML)
                    ) {
                        // if the element is img tag with src or srcset avoid prefixing the domain
                        // and replace it with ci-src
                        if (!preg_match('/<img(.*?)(src|srcset)=/is', $fileHTML)) {
                            $querySuffix = '';
                            
                            if (preg_match('/[\'\"].*\.(?:' . $static_files_ORed . ')(\?.*)?[\'\"]/Ui', $fileHTML, $static_file_matches)) {
                                $querySuffix = (isset($static_file_matches[1]) && $static_file_matches[1]) ? '&' : '?';
                                $querySuffix .= 'func=proxy';
                                
                            }
                            
                            // RegEX v1 (preg_replace): '/(<.+?(?:(url\s*\([\'\"]?)|[\'\"]))(.+?\.(?:' . $files_extensions_ORed . ')(?:\?.*)?)([\'\"\)]*)/Ui'
                            $replaceHTML = preg_replace(
                                '/(<.+?(?:(?:url\s*\([\'\"]?)|[\'\"]))(.+?\.(?:' . $files_extensions_ORed . ')(?:\?.*)?)([\'\"\)])/Ui',
                                '$1' . $cloudimg_prefix . '$2' . $querySuffix .'$3', $fileHTML
                            );
                            
                        } else {
                            // replace the src and add the data-src attribute
                            $replaceHTML = preg_replace('/<img(.*?)src=/is', '<img$1ci-src=', $fileHTML);

                            // also replace the srcset (responsive images)
                            $replaceHTML = str_replace('srcset', 'ci-srcset', $replaceHTML);

                            // replace sizes to avoid w3c errors for missing srcset
                            $replaceHTML = str_replace('sizes', 'ci-sizes', $replaceHTML);
                            
                        }


                        // replace the data-src in image tags, as they are used for some frontend builders
                        // $replaceHTML = preg_replace('/<img(.*?)data-src=([\'|"])(http.*\.)(jpe?g|png)/is', '<img$1 data-src=$2https://' . $this->cloudimage_domain . '/v7/$3$4', $replaceHTML);

                        // In case of No JS put back the correct tag for non-static files
                        if (!isset($querySuffix) || (isset($querySuffix) && !$querySuffix)) {
                            $replaceHTML .= '<noscript>' . $fileHTML . '</noscript>';
                        }

                        array_push($search_files_tags, $fileHTML);
                        array_push($replace_files_tags, $replaceHTML);
                        
                    }
                }

                $content = str_replace($search_files_tags, $replace_files_tags, $content);
                
            }
        }


        return $content;
    }





    /**
     *
     * Public function that can be used in templates / by other developers
     *
     */


    /**
     * Return the Javascript script to init the lazysize
     *
     * @param integer $id - Can be post_id or attachement_id
     * @param string|array $size Worpress size format
     * @param string|bool $url an simple url to transform to cloudimage URL
     *
     * @return string|array {
     * @type string $url - url of content with cloudimage format
     * @type int $width - width of image
     * @type int $height - height of the image
     * @type bool $intermediate - true if image is consider as intermediate
     * }
     * @since    2.0.0
     *
     */
    public function cloudimage_get_url($id, $size, $url = false)
    {
        

        if ($url) {
            // In this case $id -> $post_id
            if (wp_attachment_is_image($id)) {
                
                return $this->cloudimage_build_url($url);
                
            } else {
              
                return $this->cloudimage_build_url($url, 'proxy');
                
            }

        }

        // In this case $id -> $attachement_id

        $img_url = wp_get_attachment_url($id);
        $meta = wp_get_attachment_metadata($id);

        $cloudimage_parameters = $this->cloudimage_parse_parameters($size, $meta);

        $img_func = $cloudimage_parameters['func'];
        $img_size = $cloudimage_parameters['size'];
        $img_filters = $cloudimage_parameters['filters'];
        $size_meta = $cloudimage_parameters['size_meta'];
        


        $img_filters = apply_filters('cloudimage_filter_parameters', $img_filters, $id, $size, $meta);


        $width = isset($size_meta['width']) ? $size_meta['width'] : 0;
        $height = isset($size_meta['height']) ? $size_meta['height'] : 0;
       
        return [

            $this->cloudimage_build_url($img_url, $img_func, $img_size, $img_filters),
            $width,
            $height,
            true,
        ];
    }


    /**
     * Builds an Cloudimage URL for a dynamically sized image.
     *
     * @param string $img_url
     * @param string $img_func
     * @param array $img_size {
     * @type int|null $w
     * @type int|null $h
     * }
     * @param array $img_filters {
     * @type array|null $filter_name {
     * @type string $filter_value
     *  }
     * }
     *
     * @return string
     */
    public function cloudimage_build_url($img_url, $img_func = false,
                                         $img_size = false, $img_filters = false)
    {
        $domain = $this->cloudimage_domain;
        $url = $img_url;

        // Check if the image url is not correct
        if (strlen($img_url) == 0) {
            return $url;
        }

        // Only make URLs rewriting if we dont't want to use JavaScript responsive plugin. Otherwise the JS should handle all the responsive optimization.
        if ($this->cloudimage_use_js_powered_mode) {
            
            return $url;
        }

        // Fix for filtering MP3 files, as they are used with a lot of visual JS libraries
        if (preg_match("/(.*?)\.(mp3)/is", $img_url)) {
            return $url;
        }

        // If user conifgured some text to be replaced with another apply it.
        if (!empty($this->cloudimage_replaceable_text) && !empty($this->cloudimage_replacement_text)) {
            $img_url = str_replace(
                $this->cloudimage_replaceable_text,
                $this->cloudimage_replacement_text, $img_url
            );
        }

        // Removing http(s)://, :// or // if found any of them in beginning of URL.
        $img_url = preg_replace('/^(http(s)?:\/\/|(:)?\/\/)/i', '', $img_url);

        if (substr($img_url, 0, strlen($domain . '/v7/')) !== $domain . '/v7/') {
            $url = 'https://' . $domain . '/v7/' . $img_url;
        }

        if ($img_func) {
            $url = add_query_arg('func', $img_func, $url);
        }

        if ($img_size) {
            if (isset($img_size['w']) && $img_size['w'] > 0) {
                $url = add_query_arg('w', $img_size['w'], $url);
            }

            if (isset($img_size['h']) && $img_size['h'] > 0) {
                $url = add_query_arg('h', $img_size['h'], $url);
            }
        }

        if ($img_filters) {
            /*
             * https://developer.wordpress.org/reference/functions/add_query_arg/
            add_query_arg( array(
                    'key1' => 'value1',
                    'key2' => 'value2',
                   ), 'http://example.com' );
             */
            $url = add_query_arg($img_filters, $url);
        }

        $url = str_replace('?&', '?', $url);

        $url = trim($url, '?');
        if (!empty($this->cloudimage_removes_v7)){
          $url=str_replace("/v7","",$url);
        }
        //if the domain is repeating 
       if (substr_count($url,$domain)> 1){
            $pos = strpos($url, $domain);
          
        if ($pos !== false) {
            $url = substr_replace($url,"", $pos, strlen($domain));
            }
         
        $pos = strpos($url, "/");
        if ($pos !== false) {
            $url = substr_replace($url,"", $pos, strlen("/"));
            }
            }
        
        
        $url = apply_filters('filter_cloudimage_build_url', $url);

        return $url;
    }


    /**
     * Parse wordPress size and meta to get all Cloudimage parameters
     *
     * @param string|array $size
     * @param array $meta
     *
     * @return array
     */
    private function cloudimage_parse_parameters($size, $meta)
    {

        if (is_array($size)) {
            $size_meta = [
                "width" => $size[0],
                "height" => $size[1],
                "crop" => isset($size[2]) ? $size[2] : null
            ];
        } else {
            $size_meta = $this->cloudimage_image_sizes($size);
        }

        $filters = [];

        // Update $filters in the function if we need to set gravity
        $func = $this->cloudimage_define_function($size_meta, $meta, $filters);

        // Update $size_meta in the function if we sizes asked are bigger than original
        $size = $this->cloudimage_get_size($size_meta, $meta);

        return [
            'func' => $func,
            'size' => $size,
            'filters' => $filters,
            'size_meta' => $size_meta
        ];
    }


    /**
     * Define Cloudimage function regarding the WordPress size asked
     *
     * @param string|array $size
     * @param array $meta
     *
     * @return array
     */
    private function cloudimage_define_function($size_array, &$filters)
    {
        if ($size_array['crop']) {
            if ($size_array['width'] > 0 && $size_array['height'] > 0) {

                // if crop is array we need to define gravity center
                if (is_array($size_array['crop'])) {
                    $filters = array_merge(
                        $filters,
                        $this->cloudimage_convert_wordpress_crop_array_to_gravity_filters($size_array['crop'])
                    );
                }

                return "crop";
            }
        }

        if ($size_array['width'] > 0 && $size_array['height'] > 0) {
            return "bound";
        }

        return null;
    }


    /**
     * Define Cloudimage function regarding the WordPress size asked
     * (https://havecamerawilltravel.com/photographer/wordpress-thumbnail-crop)
     *
     * @param array $crop_array - Should be a crop array from Worpress specification
     *
     * @return array
     */
    private function cloudimage_convert_wordpress_crop_array_to_gravity_filters($crop_array)
    {
        if (count($crop_array) != 2) {
            return [];
        }

        $gravity = 'center';


        if (in_array('left', $crop_array) && in_array('top', $crop_array)) {
            $gravity = 'northwest';
        } elseif (in_array('center', $crop_array) && in_array('top', $crop_array)) {
            $gravity = 'north';
        } elseif (in_array('right', $crop_array) && in_array('top', $crop_array)) {
            $gravity = 'northeast';
        } elseif (in_array('center', $crop_array) && in_array('left', $crop_array)) {
            $gravity = 'west';
        } elseif (in_array('center', $crop_array) && in_array('right', $crop_array)) {
            $gravity = 'east';
        } elseif (in_array('bottom', $crop_array) && in_array('left', $crop_array)) {
            $gravity = 'southwest';
        } elseif (in_array('center', $crop_array) && in_array('bottom', $crop_array)) {
            $gravity = 'south';
        } elseif (in_array('bottom', $crop_array) && in_array('right', $crop_array)) {
            $gravity = 'southeast';
        }

        return ['gravity' => $gravity];
    }


    /**
     * Get Cloudimage function regarding the WordPress size asked
     *
     * @param array $size_array
     * @param array $meta
     *
     * @return array
     */
    private function cloudimage_get_size(&$size_array, $meta)
    {
        //Check if we have not set width and height
        if (!isset($meta['width']) && !isset($meta['height'])) {
            return [
                'w' => 0,
                'h' => 0,
            ];
        }

        // use min not to resize the images to bigger size than original one
        $size_array['width'] = min($size_array['width'], $meta['width']);
        $size_array['height'] = isset($size_array['height']) ? min($size_array['height'], $meta['height']) : 0;

        return [
            'w' => $size_array['width'],
            'h' => $size_array['height'],
        ];
    }


    /**
     * Get all WordPress declared image Sizes or only one specific size
     *
     * @param string $size - value of one size to return the exact object and not an array
     *
     * @return array
     */
    private function cloudimage_image_sizes($size = null)
    {
        global $_wp_additional_image_sizes;


        $sizes = [];

        // Retrieve all possible image sizes generated by WordPress
        $get_intermediate_image_sizes = get_intermediate_image_sizes();

        if (is_array($get_intermediate_image_sizes) || is_object($get_intermediate_image_sizes)) {

            foreach ($get_intermediate_image_sizes as $_size) {
                // If the size parameter is a default Worpress size
                if (in_array($_size, ['thumbnail', 'medium', 'medium_large', 'large'])) {
                    $array_size_construct = [
                        'width' => get_option($_size . '_size_w'),
                        'height' => get_option($_size . '_size_h'),
                        'crop' => get_option($_size . '_crop'),
                    ];
                } else if (isset($_wp_additional_image_sizes[$_size])) {
                    $array_size_construct = [
                        'width' => $_wp_additional_image_sizes[$_size]['width'],
                        'height' => $_wp_additional_image_sizes[$_size]['height'],
                        'crop' => $_wp_additional_image_sizes[$_size]['crop'],
                    ];
                }

                if ($size != null && $size == $_size) {
                    return $array_size_construct;
                }

                $sizes[$_size] = $array_size_construct;
            }

        }
        if ($size != null) {
            return null;
        }

        return $sizes;
    }


    /**
     * Remove elements we don't want to filter from the HTML string
     *
     * We are reducing the haystack by removing the hay we know we don't want to look for needles in
     *
     * @param string $content The HTML string
     * @return string The HTML string without the unwanted elements
     */
    protected function _get_content_haystack($content)
    {
        // Remove <noscript> elements from HTML string
        $content = preg_replace('/<noscript.*?(\/noscript>)/i', '', $content);

        // Remove HTML elements with certain classnames (or IDs) from HTML string
        $skip_classes = $this->_get_skip_classes('html');

        // Remove HTML elements with certain file types
        $skip_files = $this->_get_skip_files();

        /*
        http://stackoverflow.com/questions/1732348/regex-match-open-tags-except-xhtml-self-contained-tags/1732454#1732454
        We canâ€™t do this, but we still do it.
        */
        $skip_classes_quoted = array_map('preg_quote', $skip_classes);
        $skip_classes_ORed = implode('|', $skip_classes_quoted);

        $skip_files_quoted = array_map('preg_quote', $skip_files);
        $skip_files_ORed = implode('|', $skip_files_quoted);

        $skip_classes_regex = '/<[^>]+?\s+class\s*=\s*[\'"](|.*\s+?)(' . $skip_classes_ORed . ')(|\s+.*)[\'"].*>/Ui';
        $skip_files_regex = '/<[^>]+?\s+(src|href)\s*=\s*[\'"].+?\.(' . $skip_files_ORed . ')(|\?.*)[\'"].*>(<\/.*>)?+/Ui';

        $content = preg_replace([$skip_classes_regex, $skip_files_regex], '', $content);

        return $content;
    }


    /**
     * Get the skip classes
     *
     * @param string $content_type The content type (image/iframe etc)
     * @return array An array of strings with the class names
     */
    protected function _get_skip_classes($content_type)
    {

        $skip_classes = array();

        $skip_classes_str = $this->cloudimage_skip_classes;

        if (strlen(trim($skip_classes_str))) {
            $skip_classes = array_map('trim', explode(',', $skip_classes_str));
        }

        if (!in_array('lazy', $skip_classes)) {
            $skip_classes[] = 'lazy';
        }

        /**
         * Filter the class names to skip
         *
         * @param array $skip_classes The current classes to skip
         * @param string $content_type The current content type
         */
        $skip_classes = apply_filters('cloudimage_filter_skip_classes', $skip_classes, $content_type);

        return $skip_classes;
    }

    /**
     * Get the skip files
     *
     * @return array An array of strings with the files names
     */
    protected function _get_skip_files()
    {

        $skip_files = array();

        $skip_files_str = $this->cloudimage_skip_files;

        if (strlen(trim($skip_files_str))) {
            $skip_files = array_map('trim', explode(',', $skip_files_str));
        }

        return $skip_files;
    }

    /**
     * Get the srcset widths
     *
     * @return array An array of numbers with the srcset widths
     */
    protected function _get_srcset_widths()
    {

        $srcset_widths = array();

        $srcset_widths_str = $this->cloudimage_srcset_widths;

        if (strlen(trim($srcset_widths_str))) {
            $srcset_widths = array_map(array($this, '_trim_parse_int'), explode(',', $srcset_widths_str));
        }

        return count($srcset_widths) === 0 ? $this->default_srcset_widths : $srcset_widths;
    }

    /**
     * Trimming the string and parsing it into a number
     *
     * @param string $value represents the value which will be trimmed and parsed into a number.
     * @return integer a number that is sanitized
     */
    protected function _trim_parse_int($value)
    {
        return ((int)trim($value));
    }

    /**
     * Return the Javascript script to init the Responsive plugin
     *
     * @return string
     *
     * @since    2.0.0
     *
     */
    private function initializeResponsivePlugin()
    {
        $add_domain_if_needed = '';

        $exploded_domain = explode('.', $this->cloudimage_domain);

        $token = array_shift($exploded_domain);
        $domain = implode('.', $exploded_domain);


        if ($domain) {
            //Add the domain if it is needed
            $add_domain_if_needed = 'domain: "' . $domain . '"';
        }

        //Lazy loading variable for quick tests
        $lazy_loading = 'true';

        // Additional fix for some common sliders in WP
        $slider_improvements = "window.onload = function() {
          var carousels = jQuery('.carousel');
          var number = jQuery('.carousel').length;
          if (number > 0) {
            carousels.on('slide.bs.carousel', function () {
              window.dispatchEvent(new Event('resize'));
            });
          }
        };";

        // Initializating the empty variable, holding the dynamic script modification
        $dynamic_page_script = "";

        // Check if this is checkout page and assign the script to the variable
        if ($this->is_checkout()) {
            $dynamic_page_script = " (function() {
              window.ciResponsiveUtils = window.ciResponsiveUtils || {};
              window.cloudimgResponsive = window.cloudimgResponsive || {};
              window.ciResponsiveUtils.getImages = function () {
                return [].slice.call(document.images ? document.images : document.getElementsByTagName('img'), 0);
              };
            
              setInterval(function() {
                var imageList = window.ciResponsiveUtils.getImages(), process = false;
                imageList.forEach(function(image) {
                  if (!image.src && image.getAttribute('ci-src') && !image.getAttribute('data-src')) { process = true; }
                });
                if (process) { window.cloudimgResponsive.process && window.cloudimgResponsive.process(); }
              }, 1000)
            })();";
        }
        
        return
            'var cloudimgResponsive = new window.CIResponsive({
            token: "' . $token . '", 
            ' . $add_domain_if_needed . ',
             baseUrl: "' . get_site_url() . '",
           
            lazyLoading: ' . $lazy_loading . ',
            limitFactor: 10,
            ratio: 1,
          
            ignoreNodeImgSize: ' . $this->boolean_to_string(
                $this->cloudimage_ignore_node_img_size
            ) . ',
            apiVersion: '.$this->tokenVerion($this->cloudimage_removes_v7
            ).',

            saveNodeImgRatio: ' . $this->boolean_to_string(
                $this->cloudimage_save_node_img_ratio
            ) . ',
            ignoreStyleImgSize: ' . $this->boolean_to_string(
                $this->cloudimage_ignore_style_img_size
            ) . ',
            destroyNodeImgSize: ' . $this->boolean_to_string(
                $this->cloudimage_destroy_node_img_size
            ) . ',
            detectImageNodeCSS: ' . $this->boolean_to_string(
                $this->cloudimage_detect_image_node_css
            ) . ',
            processOnlyWidth: ' . $this->boolean_to_string(
                $this->cloudimage_process_only_width
            ) . '
        }); 
        window.lazySizes.init();
        ' . (!$this->cloudimage_disable_settimeout_checks
                ? 'cloudimgResponsive.process();
        ' : '')
            . $slider_improvements . $dynamic_page_script;
    }

    /**
     * Detect if the current page is checkout and return True \ False
     * Tries to find the build-in in WooCommerce (from 4.0) function, if it is not exist - make own checks
     *
     * @return bool
     *
     * @since 2.8.3
     */
    private function is_checkout()
    {
        if (function_exists('is_checkout')) {
            return is_checkout();
        }

        // By default we are returning False, as we don't use WooCommerce most probably
        return False;
    }

    /**
     * Add custom inline scripts in head to improve visualization in JavaScript mode
     *
     * @return void
     *
     * @since    2.8.3
     */
    public function cloudimage_add_custom_styles()
    {
        if ($this->cloudimage_domain && $this->cloudimage_use_js_powered_mode) {
            //echo "<style>img[ci-src] {opacity: 0;} img.ci-image-loaded {opacity: 1;}</style>";
             echo "<style>" . esc_html( "img[ci-src] {opacity: 0;} img.ci-image-loaded {opacity: 1;}" ) . "</style>";
        }

    }

    /**
     * Return the Javascript script to init the lazysize
     *
     * @return string
     *
     * @since    2.0.0
     *
     */
    private function initializeLazysizesPlugin()
    {
        return "window.lazySizesConfig = window.lazySizesConfig || {}; window.lazySizesConfig.init = false;";

    }

    /**
     * Cloudimage output buffer start. We use it as a hook to filter all the HTML content.
     * It is not closed, as it will be when PHP interpreter reaches the end of the page.
     *
     * @return void
     *
     * @since    2.7.4
     */
    public function cloudimage_buffer_start()
    {
        # Check if we need to perform the optimization for the current user state (logged in or not)
        $logged_in_user = $this->cloudimage_check_logged_user();

        # Additional check if current request is from admin, as we don't want to use JS mode in admin section
        $is_admin = is_admin();

        if ($this->cloudimage_use_js_powered_mode && !$logged_in_user && !$is_admin) {

            if ($this->cloudimage_content_filter_method) {

                add_filter('the_content', [$this, 'filter_cloudimage_the_content']);

            } else {

                ob_start([$this, 'filter_cloudimage_the_content']);

            }

        }
    }

    /**
     * Example function for removing "/v7/" from the Cloudimage URL
     * It can be used for example and custom implementation of filter_cloudimage_build_url filter
     *
     * @return void
     *
     * @since    2.7.8
     */
    public function cloudimage_remove_v7($url)
    {
        return str_replace("/v7/", "/", $url);
    }

    /**
     * Function to return if we need to perform optimization with Cloudimage
     *
     * @return bool
     *
     * @since    2.9.0
     */
    public function cloudimage_check_logged_user()
    {
        if ((is_admin() || is_user_logged_in()) && !$this->cloudimage_use_for_logged_in_users) {
            return 1;
        }

        return 0;
    }

    /**
     * Returns the string value of boolean value (0 or 1) as (false or true)
     *
     * @return bool
     *
     * @since 3.0.0
     */
     private function boolean_to_string($value)
    {
        return boolval($value) ? 'true' : 'false';
    }
      /**
     * Returns the null or v7 if to append in the URL(new tokens (since 01/11/21) dont need v7 in the url) 
     *
     * @return void
     *
     * @since 3.0.0
     */
    private function tokenVerion($flags)
    {
        return boolval($flags) ? 'null' : "'v7'";
    }
}

=== Cloudimage ===
Cloudimage - Fast and Responsive Images as a Service
Contributors: scaleflex, cloudimage, cloudimageio
Tags: CDN, convert webp, image resizing, optimize images, SEO, resize, fast, compression, optimize, image optimization, image optimizer, optimize, image compression, optimize images, images optimization, optimize images, image compressor, image optimisation, webp
Requires at least: 4.8
Tested up to: 5.9
Requires PHP: 5.6
Stable tag: 3.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The easiest way to resize, compress, optimise and deliver lightning fast images to your users on any device via CDN.

== Description ==

**Did you know ?**
Faster images increase conversion and thus revenue.

Cloudimage resizes, optimises, compresses and distributes your images lightning fast over CDN on any device around the world.  
Apply image filters, custom transformations and watermarks to get the most out of your images and convert more users thanks to beautiful and fast images.  
Embeds lazyloading and progressive loading effect for best user experience.

The Cloudimage WordPress plugin leverages the Cloudimage v7 API and offers 2 options for making images responsive on your theme:

1. Using standard HTML5 [srcscet](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images) tags.
Your WordPress theme must natively support the HTML5 tags for responsive images above.  
By using this method, images in the WordPress media gallery will also be delivered over Cloudimage.

2. Using the powerful [Cloudimage Responsive JS Plugin](https://scaleflex.github.io/js-cloudimage-responsive/).  
The plugin smartly identifies the image container width and delivers the optimal image size.  
No need for your Theme to support responsive images.  
It also adds lazyloading and progressive loading effect to your images for best user experience.  
This option makes the lightest possible output code and does not modify images in the WordPress media gallery.

**No development needed, it's plug-and-play!**

Simply [register](https://www.cloudimage.io/en/registration?utm_source=WordPress&utm_medium=plugins_listing&utm_campaign=wordpress_plugins-page&utm_term=organic_plugin_profile_registration&utm_id=UTM_campaign) for a free Cloudimage account and enjoy fast and responsive images.

<a href="https://www.youtube.com/embed/tk4j_MpqvM8
" target="_blank"><img src="http://img.youtube.com/vi/JFZSE1vYb0k/0.jpg"
alt="Cloudimage resizes and optimises your images" width="360" height="270" border="1"/></a>

To start boosting your images, create a free account at [Cloudimage](https://www.cloudimage.io/en/registration?utm_source=WordPress&utm_medium=plugins_listing&utm_campaign=wordpress_plugins-page&utm_term=organic_plugin_profile_registration&utm_id=UTM_campaign) to obtain a Cloudimage token.
You get 25GB of CDN traffic and image cache for free every month. If you exceed this limit, we will contact you to set up a paid plan.
But do not worry, 25 GB should be enough for any small to medium-sized WordPress site.

More information on our paid plans [here](https://www.cloudimage.io/pricing).

**How does it work**
The Cloudimage plugin will rewrite the WordPress image URLs and replace them with Cloudimage URLs.
Your origin images will be downloaded from your storage (WordPress media gallery, S3 bucket, ...), resized by Cloudimage and distributed over CDN.
**No development needed**.

**Coming soon**

- Cloudimage statistics dashboard within the Cloudimage plugin configuration page in your WordPress admin
- Support for image  URL signatures

If you have suggestions for new features, feel free to email us at [hello@cloudimage.io](mailto:hello@cloudimage.io)

Cloudimage is crafted by the [Scaleflex](https://www.scaleflex.com) team.
Also, follow [Scaleflex on Twitter](https://twitter.com/scaleflex_com) for the latest news!

== Installation ==

1. Search and install the plugin through the Plugins > Add New page in your WordPress dashboard. Alternatively, upload the plugin's .zip there
2. If not already done, register for a free account on [Cloudimage](https://www.cloudimage.io/en/registration?utm_source=WordPress&utm_medium=plugins_listing&utm_campaign=wordpress_plugins-page&utm_term=organic_plugin_profile_registration&utm_id=UTM_campaign) and get your token
3. Activate the Cloudimage plugin through the Plugins page in your WordPress
4. Enter your Cloudimage token or custom CNAME in the plugin's configuration page

== Frequently Asked Questions ==

= Question 1: How does Cloudimage resize and optimise my WordPress images?

Upon first load of your WordPress site after activating the Cloudimage plugin, the origin images will be downloaded by the Cloudimage image management infrastructure, resized, optimised and delivered over CDN to your end users.

Cloudimage adds an additional layer of image cache (shield) on top of the CDN to make every further request from the CDN to an origin image fast.  
Cloudimage does not store your WordPress images permanently, you should always keep your images in your WordPress gallery.

= Question 2:  Why are my images not going through Cloudimage?=

Check if you have a Cache service like W3 Total Cache / WP Super Cache / ...
In this case, you need to reload the cache to enable the transformation of your URL.

If the problem persist please [contact us](hello@cloudimage.io).

= Question 3: How much does Cloudimage cost? =

Cloudimage is a SaaS with a free tier subscription for 25GB CDN traffic and 25GB image cache per month.  
We offer paid plans with higher CDN traffic and image cache allowances, pricing [here](https://www.cloudimage.io/pricing).

= Question 4: Will my origin images be affected? =

Cloudimage donwloads your images on-the-fly and **does not** modify your origin images.

= Question 5: What happen if I deactivate Cloudimage WP plugin? =

Your WordPress site will be back as it was before the activation of the Cloudimage Plugin. We do not apply permanent changes to your WordPress site and/or origin images.

== Screenshots ==

1. Cloudimage website
2. Benchmark your images before and after Cloudimage
3. Plugin configuration page
4. Cloudimage Admin - Usage Statistics
5. Cloudimage Admin - Performance Statistics

== Changelog ==

= 1.0.0 =
* First version of Cloudimage WP plugin adapted from photon (Jetpack)

= 2.0.0 =
* Added support for Cloudimage v7 API
* Re-designed plugin configuration page
* Added support for the [Cloudimage Responsive JS Plugin](https://scaleflex.github.io/js-cloudimage-responsive/)
* Added native <noscript> tags to load images if JavaScript is disabled on user's browser

= 2.0.5 =
* Added option to disable lazyloading if handled by another plugin

= 2.1.0 =
* BlurHash implementation of progressive loading as alternative. Newly uploaded images and existing images on updated articles will load with the BlurHash progressive loading effect. See demo (link to blurhash demo page).

= 2.1.1 =
* Styling improvements in admin section
* Added better text on tooltips with additional information

= 2.1.2 =
* Improvements on blurhash loading

= 2.1.3 =
* Text improvements in admin section

= 2.1.4 =
* Bug fixes for unused variables, planned for version 3.0

= 2.1.5 =
* Insert different JavaScript responsive library if blurhash is used. Save progressive loading.

= 2.1.6 =
* Add default ci-ration = 1
* Change the version of the JavaScript responsive libraries

= 2.1.7 =
* Added new baloon with additional information in footer
* Changed link to cloudimage login page in footer

= 2.2.0 =
* Change version of the JavaScript responsive plugins
* fixed bug with is-resized class for resized images

= 2.3.0 =
* Change the default function of Cloudimage picture resizing from "fit" to "bound"

= 2.3.5 =
* Better error handlig for the base Cloudimage class
* Blurhash PHP comptability fix

= 2.4.0 =
* Add support for the latest versions of Cloudimage JavaScript plugin
* Add additional functions to fix Cloudimage JavaScript plugin bugs

= 2.4.1 =
* Switch to Cloudimage JavaScript version 3.3.2

= 2.4.2 =
* Switch to Cloudimage JavaScript version 3.3.3

= 2.5.0 =
* Add hook for the content in Elementor theme

= 2.6.0 =
* Remove unused functions and files
* Visual styling of the admin section
* Added two type of modes for simplicity
* Added new type of hook for full content filtering (output buffering)

= 2.6.1 =
* Add hint in admin to use a caching plugin

= 2.6.2 =
* Add new version of the JavaScript responsive plugin 3.5.0

= 2.7.0 =
* Start using the filters: 'the_content', 'the_excerpt', 'comment_text', 'widget_text_content' for filtering the content for the JavaSript responsive mode

= 2.7.1 =
* Improve localhost detection

= 2.7.2 =
* Improvement for handle bad configuration of WordPress base URLs

= 2.7.3 =
* Improved filtering content in Elementor
* Speed improvement in filtering content
* Better Error handling, when you don't have all images size (Comming from WP 4.x)

= 2.7.4 =
* Improved content filtering for JavaScript mode

= 2.7.5 =
* SVG excluded from JavaScript mode
* Improved background-images detection in the JavaScript mode

= 2.7.6 =
* Detection of logged in user, to avoid using Cloudimage for saving bandwidth in admin
* Upgrade to the newest version of JavaScript responsive plugin 4.2.1
* Text improvements in admin section
* Improve regex to detect a not fully W3 compliant background images
* Improve speed of content filtering

= 2.7.7 =
* Fix text typo in admin section

= 2.7.8 =
* Add custom hook for custom changes on cloudimage URL - filter_cloudimage_build_url

= 2.8.0 =
* MP3 files exclude in backend mode, as some of JavaScript widgets not work fine
* image_downsize remove in JavaScript mode
* Not using CDN and URL prefixing in backend mode, when there is logged in user
* Extend and add new srcsets in background mode, even the theme is not adding them (as option)

= 2.8.1 =
* image_downsize turn off, when user is logged in

= 2.8.2 =
* fix an issue in WooCommerce Single Product view

= 2.8.3 =
* reorder JavaScript initialization scripts
* increment JavaScript responsive plugin to 4.4.0
* add function for detection of checkout page
* add improved scripts on checkout pages
* add inline styles in JavaScript mode for better visualization
* admin section texts improvement

= 2.8.4 =
* fix an issue in JavaScript mode with custom domain for background images
* fix an issue with custom img_filters in build URL construction

= 2.8.5 =
* improve RegEx for the background image filtering
* improve validator of Cloudimage input token

= 2.8.6 =
* fix bug with some styles used in the JS mode

= 2.8.7 =
* fix issue with custom Cloudimage name and background image

= 2.8.8 =
* fix some styles in admin section

= 2.8.9 =
* Instagram widget fix

= 2.9.0 =
* Add options to choose if plugin should work when user is logged in

= 2.9.1 =
* Tested with WP version 5.4.2
* Improved wordings in the admin section

= 2.9.2 =
* Changed text in admin section

= 2.9.3 =
* Compatibility checks with WordPress 5.5

= 2.9.4 =
* Fix problem for icons in dashboard in JavaScript mode and admin logged-in in some cases

= 3.0.0 =
* Adding advanced settings page with a lot of advanced configurations for customizing the service on your website
* Srcset adding support to img tag if you enabled the option in advanced settings page
* Improving the loading for JS libraries by loading them through ultrafast CDN

= 3.0.1 =
* Fix an issue with some PHP version and Advanced tab

= 3.0.2 =
* Fix an issue with double CDN of Cloudimage JS
* Add the newest, improved version of Cloudimage JS - 4.6.3
* Fix an issue with RegEx in JS mode (WP_DEBUG warning)

= 3.0.3 =
* Fix preg_match issue in some PHP versions

= 3.0.4 =
* Fix preg_match issue in some PHP versions

= 3.0.5 =
* Adding option (Remove v7) in general settings page for removing api versioning in the URL's.
* Fix issue of repeating of URLs.   

= 3.0.6 =
* added contributors.   

== Upgrade Notice ==
* Upgrading from version 1 to 2 or 3 can show you warnings in the admin section



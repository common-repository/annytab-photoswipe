<?php

    /*
    Plugin Name:       Annytab PhotoSwipe
    Description:       This plugin implements PhotoSwipe to display an image gallery in a lightbox.
    Version:           1.0.0
    Requires at least: 5.4
    Requires PHP:      7.4
    Author:            A Name Not Yet Taken AB
    Author URI:        https://www.annytab.com
    License:           GPL v2 or later
    License URI:       https://www.gnu.org/licenses/gpl-2.0.html
    Text Domain:       annytab-photoswipe
    Domain Path:       /languages

    Annytab PhotoSwipe is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    any later version.

    Annytab PhotoSwipe is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Annytab PhotoSwipe. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
    */

    // Turn strict types on, by default PHP 7 remains a weakly typed language.
    declare(strict_types=1);

    // Add a namespace to avoid conflicts
    namespace Annytab\Plugins\PhotoSwipe;

    // Make sure we don't expose any info if called directly
    if (!function_exists('add_action')) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }

    // Variables
    define('ANNYTAB_PHOTOSWIPE_VERSION', '1.0.0');
    define('ANNYTAB_PHOTOSWIPE_PLUGIN_DIR', plugin_dir_path(__FILE__));

    // Load translations
    load_plugin_textdomain('annytab-photoswipe', FALSE, basename(dirname( __FILE__ )) . '/languages/');

    // Create a startup instance
    $startup = new StartUp(ANNYTAB_PHOTOSWIPE_VERSION);

    // Add actions
    add_action('wp_footer', array($startup, 'add_html'));
    add_action('wp_enqueue_scripts', array($startup, 'add_styles_and_scripts'));

    // This class includes startup actions for the plugin
    class StartUp
    {
        #region Variables

        private $version;

        #endregion

        #region Constructors

        // Create a new instance
        public function __construct($version) 
        {
            // Set values for instance variables
            $this->version = $version;

        } // End of the constructor

        #endregion

        #region Methods

        // Add html
        public function add_html() 
        {
            ?>
                <!-- Root element of PhotoSwipe. Must have class pswp. -->
                <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                    <!-- Hidden data  -->
                    <input id="pswp__facebook" type="hidden" value="<?php _e('Share on Facebook', 'annytab-photoswipe'); ?>" />
                    <input id="pswp__twitter" type="hidden" value="<?php _e('Tweet', 'annytab-photoswipe'); ?>" />
                    <input id="pswp__pinterest" type="hidden" value="<?php _e('Pin it', 'annytab-photoswipe'); ?>" />
                    <input id="pswp__download" type="hidden" value="<?php _e('Download image', 'annytab-photoswipe'); ?>" />

                    <!-- Background of PhotoSwipe. It's a separate element as animating opacity is faster than rgba(). -->
                    <div class="pswp__bg"></div>

                    <!-- Slides wrapper with overflow:hidden. -->
                    <div class="pswp__scroll-wrap">

                        <!-- Container that holds slides. 
                            PhotoSwipe keeps only 3 of them in the DOM to save memory.
                            Don't modify these 3 pswp__item elements, data is added later on. -->
                        <div class="pswp__container">
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                        </div>

                        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                        <div class="pswp__ui pswp__ui--hidden">

                            <div class="pswp__top-bar">

                                <!--  Controls are self-explanatory. Order can be changed. -->

                                <div class="pswp__counter"></div>

                                <button class="pswp__button pswp__button--close" title="<?php _e('Close (Esc)', 'annytab-photoswipe'); ?>"></button>

                                <button class="pswp__button pswp__button--share" title="<?php _e('Share', 'annytab-photoswipe'); ?>"></button>

                                <button class="pswp__button pswp__button--fs" title="<?php _e('Toggle fullscreen', 'annytab-photoswipe'); ?>"></button>

                                <button class="pswp__button pswp__button--zoom" title="<?php _e('Zoom in/out', 'annytab-photoswipe'); ?>"></button>

                                <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                                <!-- element will get class pswp__preloader--active when preloader is running -->
                                <div class="pswp__preloader">
                                    <div class="pswp__preloader__icn">
                                    <div class="pswp__preloader__cut">
                                        <div class="pswp__preloader__donut"></div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                <div class="pswp__share-tooltip"></div> 
                            </div>

                            <button class="pswp__button pswp__button--arrow--left" title="<?php _e('Previous', 'annytab-photoswipe'); ?>">
                            </button>

                            <button class="pswp__button pswp__button--arrow--right" title="<?php _e('Next', 'annytab-photoswipe'); ?>">
                            </button>

                            <div class="pswp__caption">
                                <div class="pswp__caption__center"></div>
                            </div>

                        </div>

                    </div>

                </div>
            <?php

        } // End of the add_html method

        // Add styles and scripts
        public function add_styles_and_scripts()
        {
            // Add styles
            wp_enqueue_style('annytab-photoswipe-main', esc_url(plugins_url('css/photoswipe.min.css',__FILE__)), array(), $this->version, 'all');
            wp_enqueue_style('annytab-photoswipe-skin', esc_url(plugins_url('css/default-skin/default-skin.min.css',__FILE__)), array(), $this->version, 'all');

            // Add scripts
            wp_enqueue_script('annytab-photoswipe-0', esc_url(plugins_url('js/photoswipe.min.js',__FILE__)), array(), $this->version, true);
            wp_enqueue_script('annytab-photoswipe-1', esc_url(plugins_url('js/photoswipe-ui-default.min.js',__FILE__)), array(), $this->version, true);
            wp_enqueue_script('annytab-photoswipe-2', esc_url(plugins_url('js/startup.min.js',__FILE__)), array(), $this->version, true);

        } // End of the add_styles_and_scripts method

        #endregion

    } // End of the class

?>
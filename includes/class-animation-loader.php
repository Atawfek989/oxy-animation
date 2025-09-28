<?php
/**
 * Animation Loader Class
 * Handles loading of animation scripts and styles
 *
 * @package    Oxy_Animation
 * @author     Ahmed Tawfek
 * @copyright  Copyright (c) 2025 Ahmed Tawfek
 * @link       https://ahmed-tawfek.com
 * @instagram  https://www.instagram.com/ahmedtawfek4/
 */

if (!defined('ABSPATH')) {
    exit;
}

class Oxy_Anim_Loader {

    public function __construct() {
        // Hook for both frontend and Oxygen Builder with higher priority to ensure loading
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'), 5);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'), 5);
        add_action('wp_head', array($this, 'add_inline_css_check'), 999);
        add_filter('script_loader_tag', array($this, 'add_module_to_scripts'), 10, 3);

        // Additional hooks to ensure frontend loading
        add_action('template_redirect', array($this, 'ensure_frontend_loading'));
        add_action('wp_footer', array($this, 'verify_assets_loaded'), 1);
    }

    /**
     * Check if we're in Oxygen Builder
     */
    private function is_oxygen_builder() {
        // Check URL parameters
        if (isset($_GET['ct_builder']) && $_GET['ct_builder'] === 'true') {
            return true;
        }
        if (isset($_GET['oxygen_iframe']) && $_GET['oxygen_iframe'] === 'true') {
            return true;
        }

        // Check for Oxygen's AJAX actions
        if (defined('DOING_AJAX') && DOING_AJAX) {
            if (isset($_REQUEST['action'])) {
                $action = $_REQUEST['action'];
                if (strpos($action, 'ct_') === 0 || strpos($action, 'oxy_') === 0) {
                    return true;
                }
            }
        }

        return false;
    }

    public function enqueue_frontend_assets() {
        // Always load on frontend, and load in Oxygen Builder editor
        // Only skip in WordPress admin pages (like dashboard, posts, etc.)
        if (is_admin() && !$this->is_oxygen_builder()) {
            return;
        }

        // Debug: Add info about loading context
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('OxyAnim: Loading assets - is_admin=' . (is_admin() ? 'true' : 'false') . ', is_oxygen=' . ($this->is_oxygen_builder() ? 'true' : 'false'));
        }

        $settings = get_option('oxy_anim_settings', array());

        // Core animations CSS - Animate.css based with oxy-ani- prefix
        $css_version = OXY_ANIM_VERSION;
        // Add timestamp for development to force cache refresh
        if (defined('WP_DEBUG') && WP_DEBUG) {
            $css_version .= '.' . time();
        }

        wp_enqueue_style(
            'oxy-anim-core',
            OXY_ANIM_PLUGIN_URL . 'assets/css/animations.css',
            array(),
            $css_version
        );

        // Initialize scroll-triggered animations with Intersection Observer
        $version = OXY_ANIM_VERSION;
        // Add timestamp for development to force cache refresh
        if (defined('WP_DEBUG') && WP_DEBUG) {
            $version .= '.' . time();
        }

        wp_enqueue_script(
            'oxy-anim-init',
            OXY_ANIM_PLUGIN_URL . 'assets/js/animations-init.js',
            array('jquery', 'underscore'),  // Add dependencies to ensure proper loading
            $version,
            true
        );

        // GSAP library (optional) - for advanced effects when needed
        if (!empty($settings['load_gsap'])) {
            wp_enqueue_script(
                'gsap',
                'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
                array(),
                '3.12.2',
                true
            );

            wp_enqueue_script(
                'gsap-scrolltrigger',
                'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js',
                array('gsap'),
                '3.12.2',
                true
            );
        }
    }

    /**
     * Enqueue admin assets for Oxygen Builder
     */
    public function enqueue_admin_assets() {
        // Only load in Oxygen Builder context
        if (!$this->is_oxygen_builder()) {
            return;
        }

        // Load the same assets for Oxygen Builder
        $this->enqueue_frontend_assets();
    }


    /**
     * Add inline CSS check to ensure animations work even if main CSS fails to load
     */
    public function add_inline_css_check() {
        // Only on frontend or Oxygen Builder
        if (is_admin() && !$this->is_oxygen_builder()) {
            return;
        }

        // Add critical animation CSS inline as fallback
        ?>
        <style id="oxy-anim-fallback">
        /* Critical animation fallback CSS */
        .oxy-ani {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        @keyframes oxy-bounce {
            from, 20%, 53%, to {
                animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
                transform: translate3d(0, 0, 0);
            }
            40%, 43% {
                animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
                transform: translate3d(0, -30px, 0) scaleY(1.1);
            }
            70% {
                animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
                transform: translate3d(0, -15px, 0) scaleY(1.05);
            }
            80% {
                transition-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
                transform: translate3d(0, 0, 0) scaleY(0.95);
            }
            90% {
                transform: translate3d(0, -4px, 0) scaleY(1.02);
            }
        }

        .oxy-ani-bounce {
            animation-name: oxy-bounce;
            transform-origin: center bottom;
        }

        @keyframes oxy-fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .oxy-ani-fadeIn {
            animation-name: oxy-fadeIn;
        }

        @keyframes oxy-pulse {
            from {
                transform: scale3d(1, 1, 1);
            }
            50% {
                transform: scale3d(1.05, 1.05, 1.05);
            }
            to {
                transform: scale3d(1, 1, 1);
            }
        }

        .oxy-ani-pulse {
            animation-name: oxy-pulse;
            animation-iteration-count: infinite;
        }
        </style>
        <?php
    }

    /**
     * Ensure frontend loading
     */
    public function ensure_frontend_loading() {
        if (!is_admin()) {
            // Force enqueue on frontend if not already done
            if (!wp_style_is('oxy-anim-core', 'enqueued')) {
                $this->enqueue_frontend_assets();
            }
        }
    }

    /**
     * Verify assets are loaded and add fallback
     */
    public function verify_assets_loaded() {
        if (!is_admin()) {
            // Check if our CSS is loaded, if not add critical inline CSS
            ?>
            <script>
            (function() {
                // Check if our CSS loaded by looking for a specific rule
                var cssLoaded = false;
                var sheets = document.styleSheets;
                for (var i = 0; i < sheets.length; i++) {
                    try {
                        var rules = sheets[i].cssRules || sheets[i].rules;
                        if (rules) {
                            for (var j = 0; j < rules.length; j++) {
                                if (rules[j].selectorText && rules[j].selectorText.includes('oxy-ani-bounce')) {
                                    cssLoaded = true;
                                    break;
                                }
                            }
                        }
                    } catch (e) {
                        // Cross-origin stylesheet, skip
                    }
                    if (cssLoaded) break;
                }

                // If CSS not loaded, log warning
                if (!cssLoaded) {
                    console.warn('OxyAnim: Main CSS file may not have loaded properly, relying on inline fallback');
                }

                // Ensure OxyAnim object exists
                if (!window.OxyAnim) {
                    console.warn('OxyAnim: JavaScript not loaded properly');
                }
            })();
            </script>
            <?php
        }
    }

    public function add_module_to_scripts($tag, $handle, $src) {
        // Add module attribute to specific scripts if needed
        $module_scripts = array();

        if (in_array($handle, $module_scripts)) {
            $tag = str_replace(' src=', ' type="module" src=', $tag);
        }

        return $tag;
    }

}
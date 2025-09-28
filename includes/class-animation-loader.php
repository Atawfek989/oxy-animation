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
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('oxygen_enqueue_scripts', array($this, 'enqueue_oxygen_builder_assets'));
        add_filter('script_loader_tag', array($this, 'add_module_to_scripts'), 10, 3);
    }

    public function enqueue_frontend_assets() {
        $settings = get_option('oxy_anim_settings', array());

        // Core animations CSS - Animate.css based with oxy-ani- prefix
        wp_enqueue_style(
            'oxy-anim-core',
            OXY_ANIM_PLUGIN_URL . 'assets/css/animations.css',
            array(),
            OXY_ANIM_VERSION
        );

        // Initialize scroll-triggered animations with Intersection Observer
        wp_enqueue_script(
            'oxy-anim-init',
            OXY_ANIM_PLUGIN_URL . 'assets/js/animations-init.js',
            array(),
            OXY_ANIM_VERSION,
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

    public function enqueue_oxygen_builder_assets() {
        if (defined('OXYGEN_IFRAME')) {
            // GSAP for builder if enabled
            $settings = get_option('oxy_anim_settings', array());

            if (!empty($settings['load_gsap'])) {
                wp_enqueue_script(
                    'gsap',
                    'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
                    array(),
                    '3.12.2',
                    true
                );
            }
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
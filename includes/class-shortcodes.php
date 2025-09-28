<?php
/**
 * Shortcodes Handler Class
 * Provides WordPress shortcodes for animation effects
 *
 * @package    Oxy_Animation
 * @author     Ahmed Tawfek
 */

if (!defined('ABSPATH')) {
    exit;
}

class Oxy_Animation_Shortcodes {

    public function __construct() {
        $this->register_shortcodes();
    }

    private function register_shortcodes() {
        // Main animation shortcode - ready for new effects
        add_shortcode('oxy_anim', array($this, 'animation_shortcode'));
    }

    /**
     * Main animation shortcode
     * Ready to handle new effects as they are added
     * Usage: [oxy_anim type="effect-name" duration="1" delay="0.5"]Content[/oxy_anim]
     */
    public function animation_shortcode($atts, $content = null) {
        $defaults = array(
            'type' => '',
            'class' => '',
            'id' => '',
            'duration' => '',
            'delay' => '',
            'easing' => '',
            'trigger' => '',
            'style' => ''
        );

        $atts = shortcode_atts($defaults, $atts);

        // Return empty if no type specified
        if (empty($atts['type'])) {
            return $content;
        }

        // Get effect data from registry
        $registry = Oxy_Animation_Effects_Registry::get_instance();

        // Build element attributes
        $element_atts = array();

        // Add ID if provided
        if (!empty($atts['id'])) {
            $element_atts[] = 'id="' . esc_attr($atts['id']) . '"';
        }

        // Build class list
        $classes = array();
        if (!empty($atts['class'])) {
            $classes[] = esc_attr($atts['class']);
        }

        // Add animation class (will be populated when effects are added)
        $classes[] = 'oxy-anim-' . esc_attr($atts['type']);

        $element_atts[] = 'class="' . implode(' ', $classes) . '"';

        // Add data attributes
        if (!empty($atts['duration'])) {
            $element_atts[] = 'data-duration="' . esc_attr($atts['duration']) . '"';
        }

        if (!empty($atts['delay'])) {
            $element_atts[] = 'data-delay="' . esc_attr($atts['delay']) . '"';
        }

        if (!empty($atts['easing'])) {
            $element_atts[] = 'data-easing="' . esc_attr($atts['easing']) . '"';
        }

        if (!empty($atts['trigger'])) {
            $element_atts[] = 'data-trigger="' . esc_attr($atts['trigger']) . '"';
        }

        // Add inline style if provided
        if (!empty($atts['style'])) {
            $element_atts[] = 'style="' . esc_attr($atts['style']) . '"';
        }

        // Build output
        $output = '<div ' . implode(' ', $element_atts) . '>';
        $output .= do_shortcode($content);
        $output .= '</div>';

        return $output;
    }
}
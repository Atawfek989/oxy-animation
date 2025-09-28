<?php
/**
 * Scroll Animations Class
 * Provides scroll-triggered animation definitions for the plugin
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

class Oxy_Anim_Scroll_Animations {

    /**
     * Get all available scroll animations
     */
    public static function get_available_animations() {
        return array(
            // Fade variations
            'fadeInUp' => 'Fade In Up',
            'fadeInDown' => 'Fade In Down',
            'fadeInLeft' => 'Fade In Left',
            'fadeInRight' => 'Fade In Right',
            'fadeInUpBig' => 'Fade In Up Big',
            'fadeInDownBig' => 'Fade In Down Big',
            'fadeInLeftBig' => 'Fade In Left Big',
            'fadeInRightBig' => 'Fade In Right Big',

            // Slide variations
            'slideInUp' => 'Slide In Up',
            'slideInDown' => 'Slide In Down',
            'slideInLeft' => 'Slide In Left',
            'slideInRight' => 'Slide In Right',

            // Zoom with rotation
            'zoomInRotate' => 'Zoom In Rotate',
            'zoomInScale' => 'Zoom In Scale',

            // Advanced entrance
            'flipInHorizontal' => 'Flip In Horizontal',
            'flipInVertical' => 'Flip In Vertical',
            'rollInFromLeft' => 'Roll In From Left',
            'rollInFromRight' => 'Roll In From Right',

            // Blur effects
            'blurIn' => 'Blur In',
            'blurInUp' => 'Blur In Up',
            'blurInDown' => 'Blur In Down',

            // Expand effects
            'expandIn' => 'Expand In',
            'expandInUp' => 'Expand In Up',
            'expandInDown' => 'Expand In Down',

            // Special scroll effects
            'parallaxUp' => 'Parallax Up',
            'parallaxDown' => 'Parallax Down',
            'revealFromLeft' => 'Reveal From Left',
            'revealFromRight' => 'Reveal From Right',
            'revealFromTop' => 'Reveal From Top',
            'revealFromBottom' => 'Reveal From Bottom',

            // Stagger effects
            'staggerFadeIn' => 'Stagger Fade In',
            'staggerSlideUp' => 'Stagger Slide Up',
            'staggerZoomIn' => 'Stagger Zoom In',

            // Complex animations
            'morphIn' => 'Morph In',
            'glitchIn' => 'Glitch In',
            'digitalIn' => 'Digital In',
            'particleIn' => 'Particle In'
        );
    }

    /**
     * Get scroll animation categories
     */
    public static function get_animation_categories() {
        return array(
            'fade' => array(
                'label' => 'Fade Effects',
                'animations' => array(
                    'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight',
                    'fadeInUpBig', 'fadeInDownBig', 'fadeInLeftBig', 'fadeInRightBig'
                )
            ),
            'slide' => array(
                'label' => 'Slide Effects',
                'animations' => array(
                    'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight'
                )
            ),
            'zoom' => array(
                'label' => 'Zoom Effects',
                'animations' => array(
                    'zoomInRotate', 'zoomInScale'
                )
            ),
            'flip' => array(
                'label' => 'Flip Effects',
                'animations' => array(
                    'flipInHorizontal', 'flipInVertical', 'rollInFromLeft', 'rollInFromRight'
                )
            ),
            'blur' => array(
                'label' => 'Blur Effects',
                'animations' => array(
                    'blurIn', 'blurInUp', 'blurInDown'
                )
            ),
            'expand' => array(
                'label' => 'Expand Effects',
                'animations' => array(
                    'expandIn', 'expandInUp', 'expandInDown'
                )
            ),
            'special' => array(
                'label' => 'Special Effects',
                'animations' => array(
                    'parallaxUp', 'parallaxDown', 'revealFromLeft', 'revealFromRight',
                    'revealFromTop', 'revealFromBottom'
                )
            ),
            'stagger' => array(
                'label' => 'Stagger Effects',
                'animations' => array(
                    'staggerFadeIn', 'staggerSlideUp', 'staggerZoomIn'
                )
            ),
            'complex' => array(
                'label' => 'Complex Effects',
                'animations' => array(
                    'morphIn', 'glitchIn', 'digitalIn', 'particleIn'
                )
            )
        );
    }

    /**
     * Get scroll animation settings
     */
    public static function get_animation_settings($animation) {
        $default_settings = array(
            'duration' => '1000ms',
            'delay' => '0ms',
            'threshold' => '0.1',
            'rootMargin' => '0px 0px -50px 0px',
            'once' => true,
            'easing' => 'ease-out'
        );

        // Special settings for specific scroll animations
        $special_settings = array(
            'parallaxUp' => array(
                'threshold' => '0',
                'rootMargin' => '0px',
                'once' => false,
                'easing' => 'linear'
            ),
            'parallaxDown' => array(
                'threshold' => '0',
                'rootMargin' => '0px',
                'once' => false,
                'easing' => 'linear'
            ),
            'staggerFadeIn' => array(
                'stagger_delay' => '100ms',
                'duration' => '800ms'
            ),
            'staggerSlideUp' => array(
                'stagger_delay' => '150ms',
                'duration' => '600ms'
            ),
            'staggerZoomIn' => array(
                'stagger_delay' => '120ms',
                'duration' => '700ms'
            )
        );

        if (isset($special_settings[$animation])) {
            return array_merge($default_settings, $special_settings[$animation]);
        }

        return $default_settings;
    }

    /**
     * Get trigger options for scroll animations
     */
    public static function get_trigger_options() {
        return array(
            'enter' => 'When element enters viewport',
            'exit' => 'When element exits viewport',
            'enter-exit' => 'When element enters and exits viewport',
            'progress' => 'Based on scroll progress',
            'custom' => 'Custom intersection settings'
        );
    }
}
<?php
/**
 * CSS Animations Class
 * Provides CSS animation definitions for the plugin
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

class Oxy_Anim_CSS_Animations {

    /**
     * Get all available CSS animations
     */
    public static function get_available_animations() {
        return array(
            // Entrance animations
            'fadeIn' => 'Fade In',
            'fadeInUp' => 'Fade In Up',
            'fadeInDown' => 'Fade In Down',
            'fadeInLeft' => 'Fade In Left',
            'fadeInRight' => 'Fade In Right',
            'slideInUp' => 'Slide In Up',
            'slideInDown' => 'Slide In Down',
            'slideInLeft' => 'Slide In Left',
            'slideInRight' => 'Slide In Right',
            'zoomIn' => 'Zoom In',
            'zoomInUp' => 'Zoom In Up',
            'zoomInDown' => 'Zoom In Down',
            'zoomInLeft' => 'Zoom In Left',
            'zoomInRight' => 'Zoom In Right',
            'rotateIn' => 'Rotate In',
            'rotateInUpLeft' => 'Rotate In Up Left',
            'rotateInUpRight' => 'Rotate In Up Right',
            'rotateInDownLeft' => 'Rotate In Down Left',
            'rotateInDownRight' => 'Rotate In Down Right',
            'flipInX' => 'Flip In X',
            'flipInY' => 'Flip In Y',
            'lightSpeedIn' => 'Light Speed In',
            'rollIn' => 'Roll In',

            // Exit animations
            'fadeOut' => 'Fade Out',
            'fadeOutUp' => 'Fade Out Up',
            'fadeOutDown' => 'Fade Out Down',
            'fadeOutLeft' => 'Fade Out Left',
            'fadeOutRight' => 'Fade Out Right',
            'slideOutUp' => 'Slide Out Up',
            'slideOutDown' => 'Slide Out Down',
            'slideOutLeft' => 'Slide Out Left',
            'slideOutRight' => 'Slide Out Right',
            'zoomOut' => 'Zoom Out',
            'zoomOutUp' => 'Zoom Out Up',
            'zoomOutDown' => 'Zoom Out Down',
            'zoomOutLeft' => 'Zoom Out Left',
            'zoomOutRight' => 'Zoom Out Right',
            'rotateOut' => 'Rotate Out',
            'rotateOutUpLeft' => 'Rotate Out Up Left',
            'rotateOutUpRight' => 'Rotate Out Up Right',
            'rotateOutDownLeft' => 'Rotate Out Down Left',
            'rotateOutDownRight' => 'Rotate Out Down Right',
            'flipOutX' => 'Flip Out X',
            'flipOutY' => 'Flip Out Y',
            'lightSpeedOut' => 'Light Speed Out',
            'rollOut' => 'Roll Out',

            // Attention seekers
            'bounce' => 'Bounce',
            'flash' => 'Flash',
            'headShake' => 'Head Shake',
            'heartBeat' => 'Heart Beat',
            'jello' => 'Jello',
            'pulse' => 'Pulse',
            'rubberBand' => 'Rubber Band',
            'shake' => 'Shake',
            'swing' => 'Swing',
            'tada' => 'Tada',
            'wobble' => 'Wobble',
            'shakeX' => 'Shake X',
            'shakeY' => 'Shake Y',

            // Specials
            'hinge' => 'Hinge',
            'jackInTheBox' => 'Jack In The Box',
            'backInDown' => 'Back In Down',
            'backInLeft' => 'Back In Left',
            'backInRight' => 'Back In Right',
            'backInUp' => 'Back In Up',
            'backOutDown' => 'Back Out Down',
            'backOutLeft' => 'Back Out Left',
            'backOutRight' => 'Back Out Right',
            'backOutUp' => 'Back Out Up',
            'bounceIn' => 'Bounce In',
            'bounceInDown' => 'Bounce In Down',
            'bounceInLeft' => 'Bounce In Left',
            'bounceInRight' => 'Bounce In Right',
            'bounceInUp' => 'Bounce In Up',
            'bounceOut' => 'Bounce Out',
            'bounceOutDown' => 'Bounce Out Down',
            'bounceOutLeft' => 'Bounce Out Left',
            'bounceOutRight' => 'Bounce Out Right',
            'bounceOutUp' => 'Bounce Out Up'
        );
    }

    /**
     * Get animation categories
     */
    public static function get_animation_categories() {
        return array(
            'entrance' => array(
                'label' => 'Entrance',
                'animations' => array(
                    'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight',
                    'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight',
                    'zoomIn', 'zoomInUp', 'zoomInDown', 'zoomInLeft', 'zoomInRight',
                    'rotateIn', 'rotateInUpLeft', 'rotateInUpRight', 'rotateInDownLeft', 'rotateInDownRight',
                    'flipInX', 'flipInY', 'lightSpeedIn', 'rollIn',
                    'backInDown', 'backInLeft', 'backInRight', 'backInUp',
                    'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp'
                )
            ),
            'exit' => array(
                'label' => 'Exit',
                'animations' => array(
                    'fadeOut', 'fadeOutUp', 'fadeOutDown', 'fadeOutLeft', 'fadeOutRight',
                    'slideOutUp', 'slideOutDown', 'slideOutLeft', 'slideOutRight',
                    'zoomOut', 'zoomOutUp', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight',
                    'rotateOut', 'rotateOutUpLeft', 'rotateOutUpRight', 'rotateOutDownLeft', 'rotateOutDownRight',
                    'flipOutX', 'flipOutY', 'lightSpeedOut', 'rollOut',
                    'backOutDown', 'backOutLeft', 'backOutRight', 'backOutUp',
                    'bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp'
                )
            ),
            'attention' => array(
                'label' => 'Attention Seekers',
                'animations' => array(
                    'bounce', 'flash', 'headShake', 'heartBeat', 'jello', 'pulse',
                    'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'shakeX', 'shakeY'
                )
            ),
            'special' => array(
                'label' => 'Special Effects',
                'animations' => array(
                    'hinge', 'jackInTheBox'
                )
            )
        );
    }

    /**
     * Get animation settings/properties
     */
    public static function get_animation_settings($animation) {
        $default_settings = array(
            'duration' => '1s',
            'delay' => '0s',
            'timing' => 'ease',
            'fill_mode' => 'both',
            'iteration_count' => '1'
        );

        // Special settings for specific animations
        $special_settings = array(
            'bounce' => array(
                'iteration_count' => 'infinite',
                'duration' => '2s'
            ),
            'pulse' => array(
                'iteration_count' => 'infinite',
                'duration' => '1s'
            ),
            'heartBeat' => array(
                'iteration_count' => 'infinite',
                'duration' => '1.3s'
            ),
            'flash' => array(
                'iteration_count' => 'infinite',
                'duration' => '2s'
            )
        );

        if (isset($special_settings[$animation])) {
            return array_merge($default_settings, $special_settings[$animation]);
        }

        return $default_settings;
    }
}
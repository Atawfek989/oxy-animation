<?php
/**
 * JavaScript Effects Class
 * Provides JavaScript-based animation effects for the plugin
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

class Oxy_Anim_JS_Effects {

    /**
     * Get all available JavaScript effects
     */
    public static function get_available_effects() {
        return array(
            // Text effects
            'typewriter' => 'Typewriter Effect',
            'textScramble' => 'Text Scramble',
            'splitText' => 'Split Text Animation',
            'morphText' => 'Morphing Text',
            'glowText' => 'Glowing Text',
            'neonText' => 'Neon Text Effect',
            'wavyText' => 'Wavy Text',
            'fadeText' => 'Fade Text',

            // Counter effects
            'countUp' => 'Count Up Numbers',
            'countDown' => 'Count Down Timer',
            'progressBar' => 'Animated Progress Bar',
            'circularProgress' => 'Circular Progress',

            // Interactive effects
            'magneticHover' => 'Magnetic Hover',
            'tiltEffect' => 'Tilt on Hover',
            'rippleEffect' => 'Ripple Click Effect',
            'liquidButton' => 'Liquid Button',
            'hoverDistort' => 'Hover Distortion',
            'cursorFollow' => 'Cursor Following Element',

            // Particle effects
            'particleText' => 'Particle Text',
            'particleExplosion' => 'Particle Explosion',
            'floatingParticles' => 'Floating Particles',
            'mouseParticles' => 'Mouse Trail Particles',

            // Background effects
            'parallaxElement' => 'Parallax Background',
            'backgroundGradientAnimation' => 'Animated Gradient',
            'waveBackground' => 'Wave Background',
            'geometricBackground' => 'Geometric Background',

            // Scroll effects
            'scrollProgress' => 'Scroll Progress Indicator',
            'scrollReveal' => 'Scroll Reveal',
            'scrollParallax' => 'Scroll Parallax',
            'stickyReveal' => 'Sticky Reveal',

            // 3D effects
            'rotate3D' => '3D Rotation',
            'flip3D' => '3D Flip',
            'cube3D' => '3D Cube',
            'sphere3D' => '3D Sphere',

            // Morphing effects
            'morphShape' => 'Morphing Shapes',
            'liquidMorph' => 'Liquid Morphing',
            'elasticMorph' => 'Elastic Morphing',

            // Sound effects
            'soundVisualization' => 'Sound Visualization',
            'audioReactive' => 'Audio Reactive Animation',

            // Advanced effects
            'glitchEffect' => 'Digital Glitch',
            'hologramEffect' => 'Hologram Effect',
            'matrixEffect' => 'Matrix Rain',
            'fireEffect' => 'Fire Animation',
            'waterEffect' => 'Water Ripple',
            'smokeEffect' => 'Smoke Effect'
        );
    }

    /**
     * Get JavaScript effects categories
     */
    public static function get_effect_categories() {
        return array(
            'text' => array(
                'label' => 'Text Effects',
                'effects' => array(
                    'typewriter', 'textScramble', 'splitText', 'morphText',
                    'glowText', 'neonText', 'wavyText', 'fadeText'
                )
            ),
            'counter' => array(
                'label' => 'Counter Effects',
                'effects' => array(
                    'countUp', 'countDown', 'progressBar', 'circularProgress'
                )
            ),
            'interactive' => array(
                'label' => 'Interactive Effects',
                'effects' => array(
                    'magneticHover', 'tiltEffect', 'rippleEffect', 'liquidButton',
                    'hoverDistort', 'cursorFollow'
                )
            ),
            'particle' => array(
                'label' => 'Particle Effects',
                'effects' => array(
                    'particleText', 'particleExplosion', 'floatingParticles', 'mouseParticles'
                )
            ),
            'background' => array(
                'label' => 'Background Effects',
                'effects' => array(
                    'parallaxElement', 'backgroundGradientAnimation', 'waveBackground', 'geometricBackground'
                )
            ),
            'scroll' => array(
                'label' => 'Scroll Effects',
                'effects' => array(
                    'scrollProgress', 'scrollReveal', 'scrollParallax', 'stickyReveal'
                )
            ),
            '3d' => array(
                'label' => '3D Effects',
                'effects' => array(
                    'rotate3D', 'flip3D', 'cube3D', 'sphere3D'
                )
            ),
            'morph' => array(
                'label' => 'Morphing Effects',
                'effects' => array(
                    'morphShape', 'liquidMorph', 'elasticMorph'
                )
            ),
            'sound' => array(
                'label' => 'Sound Effects',
                'effects' => array(
                    'soundVisualization', 'audioReactive'
                )
            ),
            'advanced' => array(
                'label' => 'Advanced Effects',
                'effects' => array(
                    'glitchEffect', 'hologramEffect', 'matrixEffect', 'fireEffect',
                    'waterEffect', 'smokeEffect'
                )
            )
        );
    }

    /**
     * Get effect settings and parameters
     */
    public static function get_effect_settings($effect) {
        $default_settings = array(
            'trigger' => 'load',
            'duration' => '1000',
            'delay' => '0',
            'easing' => 'ease',
            'repeat' => 'once'
        );

        // Special settings for specific effects
        $special_settings = array(
            'typewriter' => array(
                'speed' => '50',
                'cursor' => true,
                'loop' => false,
                'delay_between_chars' => '50'
            ),
            'countUp' => array(
                'start_value' => '0',
                'end_value' => '100',
                'duration' => '2000',
                'decimal_places' => '0',
                'separator' => ','
            ),
            'particleText' => array(
                'particle_count' => '50',
                'particle_size' => '2',
                'animation_speed' => '1',
                'color' => '#ffffff'
            ),
            'magneticHover' => array(
                'strength' => '0.3',
                'distance' => '100',
                'duration' => '500'
            ),
            'tiltEffect' => array(
                'max_tilt' => '15',
                'perspective' => '1000',
                'speed' => '300'
            ),
            'parallaxElement' => array(
                'speed' => '0.5',
                'direction' => 'vertical',
                'offset' => '0'
            ),
            'scrollProgress' => array(
                'thickness' => '4',
                'color' => '#667eea',
                'position' => 'top'
            ),
            'glitchEffect' => array(
                'intensity' => '5',
                'speed' => '100',
                'color_shift' => true
            )
        );

        if (isset($special_settings[$effect])) {
            return array_merge($default_settings, $special_settings[$effect]);
        }

        return $default_settings;
    }

    /**
     * Get trigger options for JavaScript effects
     */
    public static function get_trigger_options() {
        return array(
            'load' => 'On Page Load',
            'scroll' => 'On Scroll Into View',
            'hover' => 'On Hover',
            'click' => 'On Click',
            'focus' => 'On Focus',
            'custom' => 'Custom Event',
            'continuous' => 'Continuous Animation'
        );
    }

    /**
     * Get required dependencies for effects
     */
    public static function get_effect_dependencies($effect) {
        $dependencies = array(
            'typewriter' => array('jquery'),
            'textScramble' => array('jquery'),
            'splitText' => array('gsap'),
            'morphText' => array('gsap'),
            'countUp' => array('countup.js'),
            'particleText' => array('three.js'),
            'particleExplosion' => array('three.js'),
            'rotate3D' => array('three.js'),
            'flip3D' => array('three.js'),
            'cube3D' => array('three.js'),
            'sphere3D' => array('three.js'),
            'soundVisualization' => array('web-audio-api'),
            'audioReactive' => array('web-audio-api')
        );

        return isset($dependencies[$effect]) ? $dependencies[$effect] : array('jquery');
    }
}
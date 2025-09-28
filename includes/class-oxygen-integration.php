<?php
/**
 * Oxygen Builder Integration Class
 * Integrates animation features with Oxygen Builder
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

class Oxy_Anim_Oxygen_Integration {

    public function __construct() {
        // Load both in builder and frontend
        add_action('ct_builder_start', array($this, 'init_builder_integration'));
        add_filter('oxy_component_json_args', array($this, 'add_animation_controls'), 10, 2);
        add_action('oxygen_add_plus_sections', array($this, 'add_animation_section'));
        add_action('oxygen_add_plus_animation_section_content', array($this, 'render_animation_controls'));
        add_filter('ct_template_output', array($this, 'process_animation_attributes'), 10, 3);

        // Auto-detect classes and attributes
        add_filter('oxygen_vsb_element_render_attributes', array($this, 'auto_detect_animation_classes'), 10, 3);
        add_action('wp_footer', array($this, 'output_class_detection_script'));
        add_action('oxygen_enqueue_scripts', array($this, 'output_class_detection_script'));
    }

    /**
     * Initialize builder integration
     */
    public function init_builder_integration() {
        // Add animation component to Oxygen
        add_action('oxygen_add_plus_fundamentals_section_content', array($this, 'add_animation_component'));

        // Register animation parameters
        $this->register_animation_parameters();
    }

    /**
     * Add animation component to Oxygen fundamentals
     */
    public function add_animation_component() {
        ?>
        <div class="oxygen-add-section-element" data-searchid="oxy_animation_wrapper">
            <img src="<?php echo OXY_ANIM_PLUGIN_URL; ?>assets/images/animation-icon.svg" />
            <h4><?php _e('Animation Wrapper', 'oxy-animation-pro'); ?></h4>
        </div>

        <script>
            jQuery(document).ready(function($) {
                $('.oxygen-add-section-element[data-searchid="oxy_animation_wrapper"]').on('click', function() {
                    oxyAnimAddComponent('animation_wrapper');
                });
            });

            function oxyAnimAddComponent(type) {
                var component = {
                    name: 'oxy_animation_wrapper',
                    displayName: 'Animation Wrapper',
                    params: {
                        oxy_animation_type: 'fadeIn',
                        oxy_animation_duration: '1000',
                        oxy_animation_delay: '0',
                        oxy_animation_trigger: 'scroll'
                    }
                };

                // Add to Oxygen Builder
                if (typeof window.oxygenCtBuilderAddComponent === 'function') {
                    window.oxygenCtBuilderAddComponent(component);
                }
            }
        </script>
        <?php
    }

    /**
     * Register animation parameters for Oxygen elements
     */
    private function register_animation_parameters() {
        ?>
        <script>
            if (typeof window.oxyAnimationParams === 'undefined') {
                window.oxyAnimationParams = {
                    animations: <?php echo json_encode(Oxy_Anim_CSS_Animations::get_available_animations()); ?>,
                    scrollAnimations: <?php echo json_encode(Oxy_Anim_Scroll_Animations::get_available_animations()); ?>,
                    jsEffects: <?php echo json_encode(Oxy_Anim_JS_Effects::get_available_effects()); ?>
                };
            }
        </script>
        <?php
    }

    /**
     * Add animation controls to Oxygen components
     */
    public function add_animation_controls($args, $component_name) {
        // Add animation tab to all visual components
        $visual_components = array('ct_div_block', 'ct_text_block', 'ct_image', 'ct_heading', 'ct_button', 'ct_section');

        if (!in_array($component_name, $visual_components)) {
            return $args;
        }

        // Add animation parameters
        $args['params']['oxy_anim_enabled'] = array(
            'type' => 'checkbox',
            'heading' => __('Enable Animation', 'oxy-animation-pro'),
            'param_name' => 'oxy_anim_enabled',
            'value' => array('' => 'false'),
            'css' => false
        );

        $args['params']['oxy_anim_type'] = array(
            'type' => 'dropdown',
            'heading' => __('Animation Type', 'oxy-animation-pro'),
            'param_name' => 'oxy_anim_type',
            'value' => $this->get_animation_types(),
            'condition' => 'oxy_anim_enabled:true',
            'css' => false
        );

        $args['params']['oxy_anim_trigger'] = array(
            'type' => 'dropdown',
            'heading' => __('Trigger', 'oxy-animation-pro'),
            'param_name' => 'oxy_anim_trigger',
            'value' => array(
                'load' => __('On Load', 'oxy-animation-pro'),
                'scroll' => __('On Scroll', 'oxy-animation-pro'),
                'hover' => __('On Hover', 'oxy-animation-pro'),
                'click' => __('On Click', 'oxy-animation-pro')
            ),
            'condition' => 'oxy_anim_enabled:true',
            'css' => false
        );

        $args['params']['oxy_anim_duration'] = array(
            'type' => 'textfield',
            'heading' => __('Duration (ms)', 'oxy-animation-pro'),
            'param_name' => 'oxy_anim_duration',
            'value' => '1000',
            'condition' => 'oxy_anim_enabled:true',
            'css' => false
        );

        $args['params']['oxy_anim_delay'] = array(
            'type' => 'textfield',
            'heading' => __('Delay (ms)', 'oxy-animation-pro'),
            'param_name' => 'oxy_anim_delay',
            'value' => '0',
            'condition' => 'oxy_anim_enabled:true',
            'css' => false
        );

        $args['params']['oxy_anim_easing'] = array(
            'type' => 'dropdown',
            'heading' => __('Easing', 'oxy-animation-pro'),
            'param_name' => 'oxy_anim_easing',
            'value' => array(
                'ease' => 'Ease',
                'ease-in' => 'Ease In',
                'ease-out' => 'Ease Out',
                'ease-in-out' => 'Ease In Out',
                'linear' => 'Linear',
                'cubic-bezier(0.68,-0.55,0.265,1.55)' => 'Elastic'
            ),
            'condition' => 'oxy_anim_enabled:true',
            'css' => false
        );

        return $args;
    }

    /**
     * Add animation section to Oxygen Plus menu
     */
    public function add_animation_section() {
        ?>
        <div class="oxygen-add-section-accordion-contents" ng-if="isShowSection('animation')">
            <h4><?php _e('Animation Effects', 'oxy-animation-pro'); ?></h4>
            <?php do_action('oxygen_add_plus_animation_section_content'); ?>
        </div>
        <?php
    }

    /**
     * Render animation controls in Oxygen builder
     */
    public function render_animation_controls() {
        ?>
        <div class="oxy-animation-controls">
            <div class="oxygen-control-row">
                <div class="oxygen-control-wrapper">
                    <label class="oxygen-control-label"><?php _e('Animation Library', 'oxy-animation-pro'); ?></label>
                    <div class="oxygen-control">
                        <div class="oxygen-button-list">
                            <button class="ct-button" onclick="oxyAnimOpenLibrary('css')">
                                <?php _e('CSS Animations', 'oxy-animation-pro'); ?>
                            </button>
                            <button class="ct-button" onclick="oxyAnimOpenLibrary('scroll')">
                                <?php _e('Scroll Animations', 'oxy-animation-pro'); ?>
                            </button>
                            <button class="ct-button" onclick="oxyAnimOpenLibrary('js')">
                                <?php _e('JS Effects', 'oxy-animation-pro'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="oxygen-control-row">
                <div class="oxygen-control-wrapper">
                    <label class="oxygen-control-label"><?php _e('Quick Presets', 'oxy-animation-pro'); ?></label>
                    <div class="oxygen-control">
                        <select class="oxy-anim-preset-selector" onchange="oxyAnimApplyPreset(this.value)">
                            <option value=""><?php _e('Select Preset...', 'oxy-animation-pro'); ?></option>
                            <optgroup label="<?php _e('Entrance', 'oxy-animation-pro'); ?>">
                                <option value="fadeIn">Fade In</option>
                                <option value="slideInUp">Slide In Up</option>
                                <option value="zoomIn">Zoom In</option>
                                <option value="rotateIn">Rotate In</option>
                            </optgroup>
                            <optgroup label="<?php _e('Emphasis', 'oxy-animation-pro'); ?>">
                                <option value="pulse">Pulse</option>
                                <option value="shake">Shake</option>
                                <option value="bounce">Bounce</option>
                                <option value="tada">Tada</option>
                            </optgroup>
                            <optgroup label="<?php _e('Advanced', 'oxy-animation-pro'); ?>">
                                <option value="typewriter">Typewriter</option>
                                <option value="countUp">Count Up</option>
                                <option value="splitText">Split Text</option>
                                <option value="parallax">Parallax</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>

            <div class="oxygen-control-row">
                <div class="oxygen-control-wrapper">
                    <label class="oxygen-control-label"><?php _e('Animation Builder', 'oxy-animation-pro'); ?></label>
                    <div class="oxygen-control">
                        <button class="ct-button ct-button-primary" onclick="oxyAnimOpenBuilder()">
                            <?php _e('Open Animation Builder', 'oxy-animation-pro'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function oxyAnimOpenLibrary(type) {
                // Open animation library modal
                var modal = jQuery('<div class="ct-modal oxy-anim-library-modal"></div>');
                var content = '<h2>Animation Library: ' + type.toUpperCase() + '</h2>';
                content += '<div class="oxy-anim-library-grid">';

                if (type === 'css' && window.oxyAnimationParams) {
                    for (var key in window.oxyAnimationParams.animations) {
                        content += '<div class="oxy-anim-library-item" data-animation="' + key + '">';
                        content += '<div class="oxy-anim-preview"></div>';
                        content += '<h4>' + window.oxyAnimationParams.animations[key] + '</h4>';
                        content += '</div>';
                    }
                }

                content += '</div>';
                modal.html(content);
                jQuery('body').append(modal);

                jQuery('.oxy-anim-library-item').on('click', function() {
                    var animation = jQuery(this).data('animation');
                    oxyAnimApplyAnimation(animation);
                    modal.remove();
                });
            }

            function oxyAnimApplyPreset(preset) {
                if (!preset) return;

                // Apply preset to current element
                var currentElement = window.oxygenActiveComponent;
                if (currentElement) {
                    currentElement.setOptionModel('oxy_anim_enabled', 'true');
                    currentElement.setOptionModel('oxy_anim_type', preset);
                    currentElement.setOptionModel('oxy_anim_trigger', 'scroll');
                    currentElement.setOptionModel('oxy_anim_duration', '1000');
                }
            }

            function oxyAnimOpenBuilder() {
                // Open animation builder interface
                window.open('<?php echo admin_url('admin.php?page=oxy-animation-preview'); ?>', 'oxyAnimBuilder', 'width=1200,height=800');
            }

            function oxyAnimApplyAnimation(animation) {
                // Apply animation to current element
                var currentElement = window.oxygenActiveComponent;
                if (currentElement) {
                    currentElement.setOptionModel('oxy_anim_enabled', 'true');
                    currentElement.setOptionModel('oxy_anim_type', animation);
                }
            }
        </script>
        <?php
    }

    /**
     * Process animation attributes in template output
     */
    public function process_animation_attributes($output, $template_id, $is_preview) {
        // Add animation processing for rendered elements
        if (strpos($output, 'oxy_anim_enabled') !== false) {
            $output = preg_replace_callback(
                '/data-oxy-anim="([^"]*)"/',
                function($matches) {
                    $params = json_decode(base64_decode($matches[1]), true);
                    return $this->build_animation_attributes($params);
                },
                $output
            );
        }

        return $output;
    }

    /**
     * Build animation attributes from parameters
     */
    private function build_animation_attributes($params) {
        if (empty($params['oxy_anim_enabled'])) {
            return '';
        }

        $attributes = array();
        $classes = array('oxy-animated');

        if ($params['oxy_anim_trigger'] === 'scroll') {
            $classes[] = 'oxy-scroll-animate';
            $attributes[] = 'data-oxy-scroll-animation="' . esc_attr($params['oxy_anim_type']) . '"';
        } else {
            $classes[] = 'oxy-anim';
            $classes[] = 'oxy-anim-' . $params['oxy_anim_type'];
        }

        $attributes[] = 'data-oxy-anim-trigger="' . esc_attr($params['oxy_anim_trigger']) . '"';
        $attributes[] = 'data-oxy-anim-duration="' . esc_attr($params['oxy_anim_duration']) . '"';
        $attributes[] = 'data-oxy-anim-delay="' . esc_attr($params['oxy_anim_delay']) . '"';
        $attributes[] = 'data-oxy-anim-easing="' . esc_attr($params['oxy_anim_easing']) . '"';

        return 'class="' . implode(' ', $classes) . '" ' . implode(' ', $attributes);
    }

    /**
     * Get animation types for dropdown
     */
    private function get_animation_types() {
        $types = array_merge(
            Oxy_Anim_CSS_Animations::get_available_animations(),
            Oxy_Anim_Scroll_Animations::get_available_animations(),
            Oxy_Anim_JS_Effects::get_available_effects()
        );

        return $types;
    }

    /**
     * Auto-detect animation classes and attributes
     */
    public function auto_detect_animation_classes($attributes, $element, $params) {
        // Get existing classes
        $classes = isset($attributes['class']) ? $attributes['class'] : '';
        $class_array = explode(' ', $classes);

        // Check for animation classes
        foreach ($class_array as $class) {
            // CSS Animation classes (oxy-[animation-name])
            if (preg_match('/^oxy-(.+)$/', $class, $matches)) {
                $animation = $matches[1];
                if ($this->is_valid_css_animation($animation)) {
                    $attributes = $this->apply_css_animation_attributes($attributes, $animation);
                }
            }

            // Scroll Animation classes (scroll-[animation-name])
            if (preg_match('/^scroll-(.+)$/', $class, $matches)) {
                $animation = $matches[1];
                if ($this->is_valid_scroll_animation($animation)) {
                    $attributes = $this->apply_scroll_animation_attributes($attributes, $animation);
                }
            }

            // JS Effect classes (effect-[effect-name])
            if (preg_match('/^effect-(.+)$/', $class, $matches)) {
                $effect = $matches[1];
                if ($this->is_valid_js_effect($effect)) {
                    $attributes = $this->apply_js_effect_attributes($attributes, $effect);
                }
            }

            // Quick animation classes (fadeIn, slideUp, etc.)
            if ($this->is_valid_css_animation($class)) {
                $attributes = $this->apply_css_animation_attributes($attributes, $class);
            }
        }

        // Check for custom attributes
        foreach ($params as $key => $value) {
            // Animation attribute (anim="fadeIn")
            if ($key === 'anim' && !empty($value)) {
                if ($this->is_valid_css_animation($value)) {
                    $attributes = $this->apply_css_animation_attributes($attributes, $value);
                }
            }

            // Scroll attribute (scroll="fadeInUp")
            if ($key === 'scroll' && !empty($value)) {
                if ($this->is_valid_scroll_animation($value)) {
                    $attributes = $this->apply_scroll_animation_attributes($attributes, $value);
                }
            }

            // Effect attribute (effect="typewriter")
            if ($key === 'effect' && !empty($value)) {
                if ($this->is_valid_js_effect($value)) {
                    $attributes = $this->apply_js_effect_attributes($attributes, $value);
                }
            }

            // Duration attribute (duration="2s" or duration="2000")
            if ($key === 'duration' && !empty($value)) {
                $attributes['data-oxy-duration'] = $value;
            }

            // Delay attribute (delay="0.5s" or delay="500")
            if ($key === 'delay' && !empty($value)) {
                $attributes['data-oxy-delay'] = $value;
            }

            // Trigger attribute (trigger="hover" or trigger="scroll")
            if ($key === 'trigger' && !empty($value)) {
                $attributes['data-oxy-trigger'] = $value;
            }
        }

        return $attributes;
    }

    /**
     * Apply CSS animation attributes
     */
    private function apply_css_animation_attributes($attributes, $animation) {
        $attributes['class'] = (isset($attributes['class']) ? $attributes['class'] . ' ' : '') . 'oxy-anim oxy-anim-' . $animation;
        $attributes['data-oxy-anim-type'] = $animation;
        $attributes['data-oxy-anim-trigger'] = 'load';
        return $attributes;
    }

    /**
     * Apply scroll animation attributes
     */
    private function apply_scroll_animation_attributes($attributes, $animation) {
        $attributes['class'] = (isset($attributes['class']) ? $attributes['class'] . ' ' : '') . 'oxy-scroll-animate';
        $attributes['data-oxy-scroll-animation'] = $animation;
        $attributes['data-oxy-scroll-duration'] = '1000';
        $attributes['data-oxy-scroll-delay'] = '0';
        $attributes['data-oxy-scroll-threshold'] = '0.5';
        return $attributes;
    }

    /**
     * Apply JS effect attributes
     */
    private function apply_js_effect_attributes($attributes, $effect) {
        $attributes['class'] = (isset($attributes['class']) ? $attributes['class'] . ' ' : '') . 'oxy-js-effect';
        $attributes['data-oxy-effect'] = $effect;
        $attributes['data-oxy-trigger'] = 'load';
        return $attributes;
    }

    /**
     * Check if animation is valid CSS animation
     */
    private function is_valid_css_animation($animation) {
        $css_animations = Oxy_Anim_CSS_Animations::get_available_animations();
        return array_key_exists($animation, $css_animations);
    }

    /**
     * Check if animation is valid scroll animation
     */
    private function is_valid_scroll_animation($animation) {
        $scroll_animations = Oxy_Anim_Scroll_Animations::get_available_animations();
        return array_key_exists($animation, $scroll_animations);
    }

    /**
     * Check if effect is valid JS effect
     */
    private function is_valid_js_effect($effect) {
        $js_effects = Oxy_Anim_JS_Effects::get_available_effects();
        return array_key_exists($effect, $js_effects);
    }

    /**
     * Output class detection script
     */
    public function output_class_detection_script() {
        ?>
        <script>
        (function() {
            'use strict';

            // Auto-detect animation classes on page load
            document.addEventListener('DOMContentLoaded', function() {
                detectAnimationClasses();
            });

            // Re-detect after Oxygen updates
            if (typeof jQuery !== 'undefined') {
                jQuery(document).on('oxygen-ajax-element-loaded', function() {
                    setTimeout(detectAnimationClasses, 100);
                });
            }

            function detectAnimationClasses() {
                // CSS Animation class patterns
                const cssAnimationClasses = [
                    'fadeIn', 'fadeOut', 'slideInLeft', 'slideInRight', 'slideInUp', 'slideInDown',
                    'zoomIn', 'zoomOut', 'rotateIn', 'bounce', 'shake', 'pulse', 'flip',
                    'heartbeat', 'rubberBand', 'swing', 'tada', 'wobble', 'jello', 'glitch', 'floating'
                ];

                // Scroll Animation class patterns
                const scrollAnimationClasses = [
                    'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'zoomInRotate',
                    'slideInLeft', 'slideInRight', 'slideInUp', 'slideInDown', 'flipIn', 'blurIn', 'expandIn', 'parallaxUp'
                ];

                // JS Effect class patterns
                const jsEffectClasses = [
                    'typewriter', 'countUp', 'particleText', 'morphText', 'glowPulse',
                    'magneticHover', 'liquidButton', 'splitText', 'parallaxElement', 'tiltEffect',
                    'rippleEffect', 'cursorFollow', 'scrollProgress', 'textScramble', 'backgroundGradientAnimation'
                ];

                // Detect direct class names
                cssAnimationClasses.forEach(function(animation) {
                    const elements = document.querySelectorAll('.' + animation + ':not(.oxy-anim)');
                    elements.forEach(function(element) {
                        element.classList.add('oxy-anim', 'oxy-anim-' + animation);
                        element.setAttribute('data-oxy-anim-type', animation);
                        element.setAttribute('data-oxy-anim-trigger', 'load');
                    });
                });

                // Detect oxy-[animation] classes
                cssAnimationClasses.forEach(function(animation) {
                    const elements = document.querySelectorAll('.oxy-' + animation + ':not(.oxy-anim)');
                    elements.forEach(function(element) {
                        element.classList.add('oxy-anim', 'oxy-anim-' + animation);
                        element.setAttribute('data-oxy-anim-type', animation);
                        element.setAttribute('data-oxy-anim-trigger', 'load');
                    });
                });

                // Detect scroll-[animation] classes
                scrollAnimationClasses.forEach(function(animation) {
                    const elements = document.querySelectorAll('.scroll-' + animation + ':not(.oxy-scroll-animate)');
                    elements.forEach(function(element) {
                        element.classList.add('oxy-scroll-animate');
                        element.setAttribute('data-oxy-scroll-animation', animation);
                        element.setAttribute('data-oxy-scroll-duration', '1000');
                        element.setAttribute('data-oxy-scroll-delay', '0');
                        element.setAttribute('data-oxy-scroll-threshold', '0.5');
                    });
                });

                // Detect effect-[effect] classes
                jsEffectClasses.forEach(function(effect) {
                    const elements = document.querySelectorAll('.effect-' + effect + ':not(.oxy-js-effect)');
                    elements.forEach(function(element) {
                        element.classList.add('oxy-js-effect');
                        element.setAttribute('data-oxy-effect', effect);
                        element.setAttribute('data-oxy-trigger', 'load');
                    });
                });

                // Detect elements with animation attributes
                const attributeElements = document.querySelectorAll('[anim], [scroll], [effect]');
                attributeElements.forEach(function(element) {
                    const animAttr = element.getAttribute('anim');
                    const scrollAttr = element.getAttribute('scroll');
                    const effectAttr = element.getAttribute('effect');
                    const duration = element.getAttribute('duration') || '1000';
                    const delay = element.getAttribute('delay') || '0';
                    const trigger = element.getAttribute('trigger') || 'load';

                    if (animAttr && cssAnimationClasses.includes(animAttr)) {
                        element.classList.add('oxy-anim', 'oxy-anim-' + animAttr);
                        element.setAttribute('data-oxy-anim-type', animAttr);
                        element.setAttribute('data-oxy-anim-trigger', trigger);
                        element.setAttribute('data-oxy-anim-duration', duration);
                        element.setAttribute('data-oxy-anim-delay', delay);
                    }

                    if (scrollAttr && scrollAnimationClasses.includes(scrollAttr)) {
                        element.classList.add('oxy-scroll-animate');
                        element.setAttribute('data-oxy-scroll-animation', scrollAttr);
                        element.setAttribute('data-oxy-scroll-duration', duration);
                        element.setAttribute('data-oxy-scroll-delay', delay);
                        element.setAttribute('data-oxy-scroll-threshold', '0.5');
                    }

                    if (effectAttr && jsEffectClasses.includes(effectAttr)) {
                        element.classList.add('oxy-js-effect');
                        element.setAttribute('data-oxy-effect', effectAttr);
                        element.setAttribute('data-oxy-trigger', trigger);
                        element.setAttribute('data-oxy-delay', delay);
                    }
                });

                // Refresh animation systems after detection
                if (window.oxyRefreshScrollAnimations) {
                    window.oxyRefreshScrollAnimations();
                }
                if (window.oxyEffects && window.oxyEffects.refresh) {
                    window.oxyEffects.refresh();
                }
                if (window.oxyAnimation && window.oxyAnimation.refresh) {
                    window.oxyAnimation.refresh();
                }
            }
        })();
        </script>
        <?php
    }
}
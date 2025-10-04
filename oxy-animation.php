<?php
/**
 * Plugin Name: Oxy Animation
 * Plugin URI: https://ahmed-tawfek.com
 * Description: Advanced animation capabilities for Oxygen Builder with scroll-triggered animations, custom CSS animations, and JavaScript effects
 * Version: 2.1.1
 * Author: Ahmed Tawfek
 * Author URI: https://ahmed-tawfek.com
 * License: GPL v2 or later
 * Text Domain: oxy-animation-pro
 *
 * Copyright (c) 2025 Ahmed Tawfek
 * Website: https://ahmed-tawfek.com
 * Instagram: https://www.instagram.com/ahmedtawfek4/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('OXY_ANIM_VERSION', '2.1.1');
define('OXY_ANIM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('OXY_ANIM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('OXY_ANIM_PLUGIN_FILE', __FILE__);

// Safeguard: Ensure core scripts are never removed
add_action('wp_print_scripts', function() {
    // Force underscore to be available
    if (!wp_script_is('underscore', 'enqueued')) {
        wp_enqueue_script('underscore');
    }
}, 1);

// Check if Oxygen Builder is active
add_action('plugins_loaded', 'oxy_anim_check_oxygen_builder');
function oxy_anim_check_oxygen_builder() {
    if (!defined('CT_VERSION')) {
        add_action('admin_notices', 'oxy_anim_oxygen_missing_notice');
        return;
    }

    // Initialize plugin
    oxy_anim_init();
}

function oxy_anim_oxygen_missing_notice() {
    ?>
    <div class="notice notice-error">
        <p><?php _e('Oxy Animation Pro requires Oxygen Builder to be installed and activated.', 'oxy-animation-pro'); ?></p>
    </div>
    <?php
}

// Initialize plugin
function oxy_anim_init() {
    // Load all required files
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-effects-registry.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-animation-loader.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-admin-settings.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-effects-showcase.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-shortcodes.php';

    // Load animation classes required for Oxygen integration
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-css-animations.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-scroll-animations.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-js-effects.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-oxygen-integration.php';

    // Initialize all classes
    new Oxy_Anim_Loader();
    new Oxy_Anim_Admin_Settings();
    new Oxy_Anim_Oxygen_Integration();
    Oxy_Animation_Effects_Registry::get_instance();
    new Oxy_Animation_Shortcodes();

    // Simple fallback: Always ensure basic animations work
    add_action('wp_head', 'oxy_anim_ensure_basic_animations', 999);
    add_action('wp_footer', 'oxy_anim_ensure_basic_animations', 999);
    add_action('admin_footer', 'oxy_anim_ensure_basic_animations', 999);
}

// Activation hook
register_activation_hook(__FILE__, 'oxy_anim_activate');
function oxy_anim_activate() {
    // Create default options
    add_option('oxy_anim_settings', array(
        'enable_scroll_animations' => true,
        'enable_css_presets' => true,
        'enable_js_effects' => true,
        'load_gsap' => false,
        'load_gsap_plugins' => false,
        'performance_mode' => 'balanced'
    ));
}

// Ensure basic animations always work (fallback)
function oxy_anim_ensure_basic_animations() {
    // Check if we're not already loaded the inline CSS
    static $css_loaded = false;
    if ($css_loaded) return;
    $css_loaded = true;

    // Debug: Log that this function is called
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('OxyAnim: oxy_anim_ensure_basic_animations called on ' . (is_admin() ? 'admin' : 'frontend'));
    }

    ?>
    <style id="oxy-anim-guaranteed">
    /* GUARANTEED ANIMATION CSS - ALWAYS LOADS */
    .oxy-ani {
        animation-duration: 1s !important;
        animation-fill-mode: both !important;
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
        animation-name: oxy-bounce !important;
        transform-origin: center bottom !important;
    }

    @keyframes oxy-fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .oxy-ani-fadeIn {
        animation-name: oxy-fadeIn !important;
    }

    @keyframes oxy-pulse {
        from { transform: scale3d(1, 1, 1); }
        50% { transform: scale3d(1.05, 1.05, 1.05); }
        to { transform: scale3d(1, 1, 1); }
    }

    .oxy-ani-pulse {
        animation-name: oxy-pulse !important;
        animation-iteration-count: infinite !important;
    }

    @keyframes oxy-shake {
        from, to { transform: translate3d(0, 0, 0); }
        10%, 30%, 50%, 70%, 90% { transform: translate3d(-10px, 0, 0); }
        20%, 40%, 60%, 80% { transform: translate3d(10px, 0, 0); }
    }

    .oxy-ani-shake {
        animation-name: oxy-shake !important;
    }
    </style>
    <script>
    // Auto-detect and trigger existing animations on the page
    function detectAndTriggerAnimations() {
        const animatedElements = document.querySelectorAll('[class*="oxy-ani-"]');

        for (let i = 0; i < animatedElements.length; i++) {
            const el = animatedElements[i];

            // Add base animation class if missing
            if (!el.classList.contains('oxy-ani')) {
                el.classList.add('oxy-ani');
            }

            // Process animation attributes
            applyAnimationAttributes(el);

            // Force animation restart
            el.style.animation = 'none';
            el.offsetHeight; // Force reflow
            el.style.animation = null;
        }
    }

    // Apply animation attributes to element
    function applyAnimationAttributes(element) {
        // Duration attribute
        const duration = element.getAttribute('data-oxy-anim-duration');
        if (duration) {
            element.style.setProperty('animation-duration', duration, 'important');
        }

        // Delay attribute
        const delay = element.getAttribute('data-oxy-anim-delay');
        if (delay) {
            element.style.setProperty('animation-delay', delay, 'important');
        }

        // Repeat attribute
        const repeat = element.getAttribute('data-oxy-anim-repeat');
        if (repeat) {
            const iterationCount = repeat === 'infinite' ? 'infinite' : repeat;
            element.style.setProperty('animation-iteration-count', iterationCount, 'important');
        }

        // Trigger attribute - determines when animation starts
        const trigger = element.getAttribute('data-oxy-anim-trigger');
        if (trigger) {
            handleAnimationTrigger(element, trigger);
        }

        // Timing function attribute
        const timing = element.getAttribute('data-oxy-anim-timing');
        if (timing) {
            element.style.setProperty('animation-timing-function', timing, 'important');
        }

        // Direction attribute
        const direction = element.getAttribute('data-oxy-anim-direction');
        if (direction) {
            element.style.setProperty('animation-direction', direction, 'important');
        }

        // Fill mode attribute
        const fillMode = element.getAttribute('data-oxy-anim-fill-mode');
        if (fillMode) {
            element.style.setProperty('animation-fill-mode', fillMode, 'important');
        }

        // Play state attribute
        const playState = element.getAttribute('data-oxy-anim-play-state');
        if (playState) {
            element.style.setProperty('animation-play-state', playState, 'important');
        }

        // Handle Ken Burns specific attributes
        if (element.classList.contains('oxy-ani-ken-burns')) {
            applyKenBurnsAttributes(element);
        }
    }

    // Apply Ken Burns specific attributes
    function applyKenBurnsAttributes(element) {
        // Get Ken Burns specific attributes
        const direction = element.getAttribute('data-ken-burns-direction');
        const scale = element.getAttribute('data-ken-burns-scale');
        const origin = element.getAttribute('data-ken-burns-origin');

        // Apply direction (this is handled by CSS selectors, just ensure it's set)
        if (direction) {
            element.setAttribute('data-ken-burns-direction', direction);
        } else {
            element.setAttribute('data-ken-burns-direction', 'zoom-in');
        }

        // Apply scale as CSS custom property
        if (scale) {
            element.style.setProperty('--ken-burns-scale', scale);
        } else {
            element.style.setProperty('--ken-burns-scale', '1.2');
        }

        // Apply transform origin as CSS custom property
        if (origin) {
            // Convert origin values to CSS format
            const originMap = {
                'top-left': 'top left',
                'top-right': 'top right',
                'bottom-left': 'bottom left',
                'bottom-right': 'bottom right',
                'top-center': 'top center',
                'bottom-center': 'bottom center',
                'left-center': 'left center',
                'right-center': 'right center',
                'center': 'center'
            };
            const cssOrigin = originMap[origin] || 'center';
            element.style.setProperty('--ken-burns-origin', cssOrigin);
        } else {
            element.style.setProperty('--ken-burns-origin', 'center');
        }
    }

    // Handle different animation triggers
    function handleAnimationTrigger(element, trigger) {
        switch(trigger) {
            case 'load':
            case 'immediate':
                // Animation starts immediately (default behavior)
                element.style.animationPlayState = 'running';
                break;

            case 'hover':
                // Start animation on hover
                element.style.animationPlayState = 'paused';
                element.addEventListener('mouseenter', function() {
                    this.style.animationPlayState = 'running';
                });
                element.addEventListener('mouseleave', function() {
                    this.style.animationPlayState = 'paused';
                });
                break;

            case 'click':
                // Start animation on click
                element.style.animationPlayState = 'paused';
                element.addEventListener('click', function() {
                    this.style.animation = 'none';
                    this.offsetHeight;
                    this.style.animation = null;
                });
                break;

            case 'scroll':
                // Start animation when element comes into view
                element.style.animationPlayState = 'paused';
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.style.animationPlayState = 'running';
                            observer.unobserve(entry.target);
                        }
                    });
                });
                observer.observe(element);
                break;

            case 'manual':
                // Animation controlled manually via JavaScript
                element.style.animationPlayState = 'paused';
                break;

            default:
                // Default to immediate
                element.style.animationPlayState = 'running';
        }
    }

    // Create global OxyAnim object if it doesn't exist
    if (!window.OxyAnim) {
        window.OxyAnim = {
            trigger: function(selector) {
                const elements = document.querySelectorAll(selector);
                for (let i = 0; i < elements.length; i++) {
                    elements[i].style.animationPlayState = 'running';
                    // Force restart
                    elements[i].style.animation = 'none';
                    elements[i].offsetHeight;
                    elements[i].style.animation = null;
                }
            },
            animate: function(selector, animationClass, options) {
                const elements = document.querySelectorAll(selector);
                for (let i = 0; i < elements.length; i++) {
                    const el = elements[i];
                    el.classList.add('oxy-ani', animationClass);

                    // Apply options as attributes if provided
                    if (options) {
                        if (options.duration) el.setAttribute('data-oxy-anim-duration', options.duration);
                        if (options.delay) el.setAttribute('data-oxy-anim-delay', options.delay);
                        if (options.repeat) el.setAttribute('data-oxy-anim-repeat', options.repeat);
                        if (options.timing) el.setAttribute('data-oxy-anim-timing', options.timing);
                        if (options.direction) el.setAttribute('data-oxy-anim-direction', options.direction);

                        // Ken Burns specific options
                        if (options.kenBurnsDirection) el.setAttribute('data-ken-burns-direction', options.kenBurnsDirection);
                        if (options.kenBurnsScale) el.setAttribute('data-ken-burns-scale', options.kenBurnsScale);
                        if (options.kenBurnsOrigin) el.setAttribute('data-ken-burns-origin', options.kenBurnsOrigin);
                    }

                    // Apply attributes
                    applyAnimationAttributes(el);

                    // Force animation start
                    el.style.animation = 'none';
                    el.offsetHeight;
                    el.style.animation = null;
                }
            },
            refresh: function() {
                detectAndTriggerAnimations();
            },
            updateAttributes: function(selector) {
                const elements = document.querySelectorAll(selector);
                for (let i = 0; i < elements.length; i++) {
                    applyAnimationAttributes(elements[i]);
                    // Restart animation to apply changes
                    elements[i].style.animation = 'none';
                    elements[i].offsetHeight;
                    elements[i].style.animation = null;
                }
            },
            testKenBurns: function() {
                console.log('=== Ken Burns Test ===');

                // Create a test element with background image
                const testDiv = document.createElement('div');
                testDiv.innerHTML = 'KEN BURNS TEST';
                testDiv.className = 'oxy-ani oxy-ani-ken-burns';
                testDiv.setAttribute('data-oxy-anim-duration', '3s');
                testDiv.setAttribute('data-ken-burns-direction', 'zoom-pan-right');
                testDiv.setAttribute('data-ken-burns-scale', '1.5');
                testDiv.setAttribute('data-ken-burns-origin', 'top-left');
                testDiv.style.cssText = 'position:fixed;top:50px;right:50px;width:300px;height:200px;background-image:url("https://picsum.photos/400/300");z-index:99999;border:3px solid red;color:white;text-align:center;line-height:200px;font-weight:bold;';

                document.body.appendChild(testDiv);

                console.log('Before processing attributes:');
                console.log('data-ken-burns-direction:', testDiv.getAttribute('data-ken-burns-direction'));
                console.log('data-ken-burns-scale:', testDiv.getAttribute('data-ken-burns-scale'));
                console.log('data-ken-burns-origin:', testDiv.getAttribute('data-ken-burns-origin'));

                // Apply Ken Burns attributes
                applyKenBurnsAttributes(testDiv);

                console.log('After processing attributes:');
                console.log('--ken-burns-scale:', testDiv.style.getPropertyValue('--ken-burns-scale'));
                console.log('--ken-burns-origin:', testDiv.style.getPropertyValue('--ken-burns-origin'));
                console.log('data-ken-burns-direction:', testDiv.getAttribute('data-ken-burns-direction'));

                // Clean up after 8 seconds
                setTimeout(() => {
                    if (testDiv.parentNode) {
                        document.body.removeChild(testDiv);
                    }
                }, 8000);

                console.log('Ken Burns test element created. Should show zoom-pan-right with 1.5x scale from top-left origin.');
            },
        };
    }

    // Set up MutationObserver to detect attribute changes
    function setupAttributeObserver() {
        if (!window.MutationObserver) return;

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName && mutation.attributeName.includes('anim')) {
                    applyAnimationAttributes(mutation.target);
                } else if (mutation.type === 'childList') {
                    // Check new nodes for animation classes
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1 && node.className && node.className.includes('oxy-ani-')) {
                            applyAnimationAttributes(node);
                        }
                    });
                }
            });
        });

        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['data-oxy-anim-duration', 'data-oxy-anim-delay', 'data-oxy-anim-repeat', 'data-oxy-anim-trigger', 'class'],
            childList: true,
            subtree: true
        });
    }

    // Auto-detect animations when page loads
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            detectAndTriggerAnimations();
            setupAttributeObserver();
        });
    } else {
        detectAndTriggerAnimations();
        setupAttributeObserver();
    }
    </script>
    <?php
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'oxy_anim_deactivate');
function oxy_anim_deactivate() {
    // Clean up if needed
}
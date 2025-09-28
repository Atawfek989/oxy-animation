/*!
 * Oxy Animation Initializer
 * Handles scroll-triggered animations using Intersection Observer
 * Version: 2.0.5
 */

(function() {
    'use strict';

    // Animation configuration
    const config = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px',
        animationClass: 'oxy-ani',
        triggerClass: 'oxy-ani-on-scroll',
        triggeredClass: 'oxy-ani-triggered'
    };

    /**
     * Initialize scroll-triggered animations
     */
    function initScrollAnimations() {
        // Check for Intersection Observer support
        if (!('IntersectionObserver' in window)) {
            // Fallback: immediately show all elements
            const elements = document.querySelectorAll('.' + config.triggerClass);
            elements.forEach(el => {
                el.classList.add(config.triggeredClass);
            });
            return;
        }

        // Create intersection observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add triggered class to start animation
                    entry.target.classList.add(config.triggeredClass);

                    // Optional: stop observing this element
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: config.threshold,
            rootMargin: config.rootMargin
        });

        // Observe all elements with scroll trigger class
        const elements = document.querySelectorAll('.' + config.triggerClass);
        elements.forEach(el => {
            observer.observe(el);
        });
    }

    /**
     * Auto-detect animation classes and add scroll triggers
     */
    function autoDetectAnimations() {
        // Find all elements with oxy-ani- classes
        const allElements = document.querySelectorAll('[class*="oxy-ani-"]:not(.oxy-ani-on-scroll)');

        allElements.forEach(el => {
            // Skip utility classes
            const classes = el.className.split(' ');
            const hasAnimationClass = classes.some(cls =>
                cls.startsWith('oxy-ani-') &&
                !cls.includes('delay') &&
                !cls.includes('repeat') &&
                !cls.includes('slower') &&
                !cls.includes('slow') &&
                !cls.includes('fast') &&
                !cls.includes('faster')
            );

            if (hasAnimationClass) {
                // Add scroll trigger classes
                el.classList.add(config.triggerClass);
            }
        });
    }

    /**
     * Handle manual triggers
     */
    function initManualTriggers() {
        // Handle click triggers
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-oxy-trigger="click"]');
            if (trigger) {
                const targetSelector = trigger.dataset.oxyTarget;
                if (targetSelector) {
                    const targets = document.querySelectorAll(targetSelector);
                    targets.forEach(target => {
                        target.classList.add(config.triggeredClass);
                    });
                }
            }
        });

        // Handle hover triggers
        document.addEventListener('mouseenter', (e) => {
            const trigger = e.target.closest('[data-oxy-trigger="hover"]');
            if (trigger) {
                const targetSelector = trigger.dataset.oxyTarget;
                if (targetSelector) {
                    const targets = document.querySelectorAll(targetSelector);
                    targets.forEach(target => {
                        target.classList.add(config.triggeredClass);
                    });
                }
            }
        }, true);
    }

    /**
     * Add utility functions to global scope
     */
    window.OxyAnim = {
        /**
         * Trigger animation on specific element
         */
        trigger: function(selector) {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
                el.classList.add(config.triggeredClass);
            });
        },

        /**
         * Reset animation on specific element
         */
        reset: function(selector) {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
                el.classList.remove(config.triggeredClass);
                // Force reflow to restart animation
                el.offsetHeight;
            });
        },

        /**
         * Add animation class to element
         */
        animate: function(selector, animationClass, options = {}) {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
                // Remove existing animation classes
                el.className = el.className.replace(/oxy-ani-[^\s]*/g, '').trim();

                // Add new animation class
                el.classList.add('oxy-ani', animationClass);

                // Add timing classes if specified
                if (options.duration) {
                    el.classList.add('oxy-ani-' + options.duration);
                }
                if (options.delay) {
                    el.classList.add('oxy-ani-delay-' + options.delay);
                }
                if (options.repeat) {
                    el.classList.add('oxy-ani-repeat-' + options.repeat);
                }

                // Trigger animation
                if (options.trigger !== false) {
                    el.classList.add(config.triggeredClass);
                }
            });
        }
    };

    /**
     * Initialize everything when DOM is ready
     */
    function init() {
        autoDetectAnimations();
        initScrollAnimations();
        initManualTriggers();

        // Dispatch ready event
        document.dispatchEvent(new CustomEvent('oxyAnimReady'));
    }

    // Initialize when DOM is loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
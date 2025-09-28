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
            for (let i = 0; i < elements.length; i++) {
                elements[i].classList.add(config.triggeredClass);
            }
            return;
        }

        // Create intersection observer
        const observer = new IntersectionObserver(function(entries) {
            for (let i = 0; i < entries.length; i++) {
                const entry = entries[i];
                if (entry.isIntersecting) {
                    // Add triggered class to start animation
                    entry.target.classList.add(config.triggeredClass);

                    // Optional: stop observing this element
                    observer.unobserve(entry.target);
                }
            }
        }, {
            threshold: config.threshold,
            rootMargin: config.rootMargin
        });

        // Observe all elements with scroll trigger class
        const elements = document.querySelectorAll('.' + config.triggerClass);
        for (let i = 0; i < elements.length; i++) {
            observer.observe(elements[i]);
        }
    }

    /**
     * Auto-detect animation classes and add scroll triggers
     */
    function autoDetectAnimations() {
        // Find all elements with oxy-ani- classes
        const allElements = document.querySelectorAll('[class*="oxy-ani-"]:not(.oxy-ani-on-scroll):not(.oxy-ani-triggered)');

        for (let i = 0; i < allElements.length; i++) {
            const el = allElements[i];
            // Skip utility classes
            const classes = el.className.split(' ');
            let hasAnimationClass = false;

            for (let j = 0; j < classes.length; j++) {
                const cls = classes[j];
                if (cls.indexOf('oxy-ani-') === 0 &&
                    cls.indexOf('delay') === -1 &&
                    cls.indexOf('repeat') === -1 &&
                    cls.indexOf('slower') === -1 &&
                    cls.indexOf('slow') === -1 &&
                    cls.indexOf('fast') === -1 &&
                    cls.indexOf('faster') === -1 &&
                    cls.indexOf('on-scroll') === -1 &&
                    cls.indexOf('triggered') === -1) {
                    hasAnimationClass = true;
                    break;
                }
            }

            if (hasAnimationClass) {
                // Check if element has data-trigger attribute
                const trigger = el.getAttribute('data-trigger') || el.getAttribute('data-oxy-trigger');

                if (trigger === 'scroll') {
                    // Explicitly set to scroll trigger
                    el.classList.add(config.triggerClass);
                } else {
                    // Default behavior: immediate animation (no scroll trigger needed)
                    // The animation will play immediately since the CSS class is already applied
                    // No need to add any trigger classes
                }
            }
        }
    }

    /**
     * Helper function to find closest ancestor matching selector (polyfill for older browsers)
     */
    function findClosest(element, selector) {
        if (!element || element === document) return null;

        // Check if element matches the selector
        if (element.matches && element.matches(selector)) {
            return element;
        }

        // Check parent elements
        return findClosest(element.parentElement, selector);
    }

    /**
     * Helper function for matches() polyfill
     */
    function elementMatches(element, selector) {
        if (element.matches) return element.matches(selector);
        if (element.msMatchesSelector) return element.msMatchesSelector(selector);
        if (element.webkitMatchesSelector) return element.webkitMatchesSelector(selector);

        // Fallback: check if element exists in querySelectorAll results
        const matches = document.querySelectorAll(selector);
        for (let i = 0; i < matches.length; i++) {
            if (matches[i] === element) return true;
        }
        return false;
    }

    /**
     * Enhanced findClosest with better compatibility
     */
    function findClosestCompat(element, selector) {
        if (!element || element === document) return null;

        // Check if current element matches
        if (elementMatches(element, selector)) {
            return element;
        }

        // Check parent elements
        return findClosestCompat(element.parentElement, selector);
    }

    /**
     * Handle manual triggers
     */
    function initManualTriggers() {
        // Handle click triggers
        document.addEventListener('click', function(e) {
            const trigger = findClosestCompat(e.target, '[data-oxy-trigger="click"]');
            if (trigger) {
                const targetSelector = trigger.getAttribute('data-oxy-target');
                if (targetSelector) {
                    const targets = document.querySelectorAll(targetSelector);
                    for (let i = 0; i < targets.length; i++) {
                        targets[i].classList.add(config.triggeredClass);
                    }
                }
            }
        });

        // Handle hover triggers
        document.addEventListener('mouseenter', function(e) {
            const trigger = findClosestCompat(e.target, '[data-oxy-trigger="hover"]');
            if (trigger) {
                const targetSelector = trigger.getAttribute('data-oxy-target');
                if (targetSelector) {
                    const targets = document.querySelectorAll(targetSelector);
                    for (let i = 0; i < targets.length; i++) {
                        targets[i].classList.add(config.triggeredClass);
                    }
                }
            }
        }, true);
    }

    /**
     * Update animation attributes for all elements
     */
    function updateAnimationAttributes() {
        const animatedElements = document.querySelectorAll('[class*="oxy-ani-"]');

        for (let i = 0; i < animatedElements.length; i++) {
            const element = animatedElements[i];

            // Get attribute values
            const duration = element.getAttribute('data-oxy-anim-duration');
            const delay = element.getAttribute('data-oxy-anim-delay');
            const repeat = element.getAttribute('data-oxy-anim-repeat');
            const trigger = element.getAttribute('data-oxy-anim-trigger');

            // Apply duration with important flag
            if (duration) {
                element.style.setProperty('animation-duration', duration, 'important');
            }

            // Apply delay with important flag
            if (delay) {
                element.style.setProperty('animation-delay', delay, 'important');
            }

            // Apply repeat with important flag
            if (repeat) {
                if (repeat === 'infinite') {
                    element.style.setProperty('animation-iteration-count', 'infinite', 'important');
                } else {
                    element.style.setProperty('animation-iteration-count', repeat, 'important');
                }
            }

            // Handle trigger
            if (trigger) {
                if (trigger === 'scroll') {
                    element.classList.add(config.triggerClass);
                } else if (trigger === 'click' || trigger === 'hover') {
                    element.setAttribute('data-oxy-trigger', trigger);
                }
            }
        }
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
            for (let i = 0; i < elements.length; i++) {
                elements[i].classList.add(config.triggeredClass);
            }
        },

        /**
         * Reset animation on specific element
         */
        reset: function(selector) {
            const elements = document.querySelectorAll(selector);
            for (let i = 0; i < elements.length; i++) {
                const el = elements[i];
                el.classList.remove(config.triggeredClass);
                // Force reflow to restart animation
                el.offsetHeight;
            }
        },

        /**
         * Add animation class to element
         */
        animate: function(selector, animationClass, options) {
            options = options || {};
            const elements = document.querySelectorAll(selector);
            for (let i = 0; i < elements.length; i++) {
                const el = elements[i];
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
            }
        },

        /**
         * Refresh animation detection and initialization
         */
        refresh: function() {
            autoDetectAnimations();
            triggerImmediateAnimations();
            initScrollAnimations();
            updateAnimationAttributes();
        },

        /**
         * Force trigger all animations immediately (useful for testing)
         */
        triggerAll: function() {
            const allAnimationElements = document.querySelectorAll('[class*="oxy-ani-"]');
            for (let i = 0; i < allAnimationElements.length; i++) {
                allAnimationElements[i].classList.add(config.triggeredClass);
            }
        },

        /**
         * Update animation attributes for all elements
         */
        updateAttributes: function() {
            updateAnimationAttributes();
        },

        /**
         * Test all attributes functionality
         */
        testAllAttributes: function() {
            console.log('OxyAnim: Testing all animation attributes...');

            // Create test elements
            const testContainer = document.createElement('div');
            testContainer.id = 'oxy-anim-test-container';
            testContainer.style.cssText = 'position: fixed; top: 10px; right: 10px; z-index: 99999; background: rgba(0,0,0,0.8); color: white; padding: 10px; border-radius: 5px; max-width: 300px;';

            // Test 1: Duration
            const durationTest = document.createElement('div');
            durationTest.className = 'oxy-ani oxy-ani-bounce';
            durationTest.setAttribute('data-oxy-anim-duration', '3s');
            durationTest.textContent = 'Duration: 3s (slow bounce)';
            durationTest.style.cssText = 'margin: 5px 0; padding: 5px; background: #4CAF50; border-radius: 3px;';

            // Test 2: Delay
            const delayTest = document.createElement('div');
            delayTest.className = 'oxy-ani oxy-ani-fadeIn';
            delayTest.setAttribute('data-oxy-anim-delay', '2s');
            delayTest.textContent = 'Delay: 2s (fadeIn after 2s)';
            delayTest.style.cssText = 'margin: 5px 0; padding: 5px; background: #2196F3; border-radius: 3px;';

            // Test 3: Repeat
            const repeatTest = document.createElement('div');
            repeatTest.className = 'oxy-ani oxy-ani-pulse';
            repeatTest.setAttribute('data-oxy-anim-repeat', '3');
            repeatTest.textContent = 'Repeat: 3 times (pulse)';
            repeatTest.style.cssText = 'margin: 5px 0; padding: 5px; background: #FF9800; border-radius: 3px;';

            // Test 4: Combined attributes
            const combinedTest = document.createElement('div');
            combinedTest.className = 'oxy-ani oxy-ani-bounce';
            combinedTest.setAttribute('data-oxy-anim-duration', '2s');
            combinedTest.setAttribute('data-oxy-anim-delay', '1s');
            combinedTest.setAttribute('data-oxy-anim-repeat', '2');
            combinedTest.textContent = 'Combined: 2s duration, 1s delay, 2x repeat';
            combinedTest.style.cssText = 'margin: 5px 0; padding: 5px; background: #9C27B0; border-radius: 3px;';

            // Close button
            const closeBtn = document.createElement('button');
            closeBtn.textContent = '✕ Close';
            closeBtn.style.cssText = 'background: #f44336; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; float: right; margin-top: 10px;';
            closeBtn.onclick = function() {
                document.body.removeChild(testContainer);
            };

            // Add all to container
            testContainer.appendChild(durationTest);
            testContainer.appendChild(delayTest);
            testContainer.appendChild(repeatTest);
            testContainer.appendChild(combinedTest);
            testContainer.appendChild(closeBtn);

            // Add to page
            document.body.appendChild(testContainer);

            // Apply attributes
            updateAnimationAttributes();

            console.log('OxyAnim: Test elements created with attributes applied');

            // Auto-close after 15 seconds
            setTimeout(function() {
                if (document.body.contains(testContainer)) {
                    document.body.removeChild(testContainer);
                }
            }, 15000);
        }
    };

    /**
     * Trigger immediate animations for elements that should animate on load
     */
    function triggerImmediateAnimations() {
        // This function is now simplified since most animations trigger immediately by default
        // Only elements with data-trigger="scroll" will use the scroll trigger system
        // All other animation elements will animate immediately when the CSS class is applied

        // Ensure any elements that were hidden for scroll animations but don't have scroll trigger
        // are made visible
        const hiddenElements = document.querySelectorAll('[class*="oxy-ani-"]:not(.oxy-ani-on-scroll)');
        for (let i = 0; i < hiddenElements.length; i++) {
            const el = hiddenElements[i];
            const trigger = el.getAttribute('data-trigger') || el.getAttribute('data-oxy-trigger');

            // If not a scroll trigger, ensure element is visible
            if (trigger !== 'scroll') {
                if (el.style.opacity === '0' || el.style.visibility === 'hidden') {
                    el.style.opacity = '';
                    el.style.visibility = '';
                }
            }
        }
    }

    /**
     * Initialize everything when DOM is ready
     */
    function init() {
        autoDetectAnimations();
        initScrollAnimations();
        initManualTriggers();
        triggerImmediateAnimations();
        updateAnimationAttributes();

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
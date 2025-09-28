/**
 * Oxy Animation - Admin JavaScript
 * Handles admin panel functionality
 *
 * @package    Oxy_Animation
 * @author     Ahmed Tawfek
 * @copyright  Copyright (c) 2025 Ahmed Tawfek
 * @link       https://ahmed-tawfek.com
 * @instagram  https://www.instagram.com/ahmedtawfek4/
 */

(function($) {
    'use strict';

    // Global error handler for unhandled promise rejections
    window.addEventListener('unhandledrejection', function(event) {
        // Suppress clipboard API related errors that don't affect functionality
        if (event.reason && typeof event.reason === 'object' &&
            (event.reason.name === 'NotAllowedError' ||
             event.reason.message && event.reason.message.includes('clipboard'))) {
            event.preventDefault();
            console.warn('Oxy Animation: Clipboard permission issue - using fallback method');
            return;
        }

        // Log other errors for debugging but don't break the page
        console.warn('Oxy Animation: Unhandled promise rejection:', event.reason);
        event.preventDefault();
    });

    // Safe initialization with error handling
    function safeInit() {
        try {
            // Check if we're on the right admin page
            if (!window.location.href.includes('oxy-animation')) {
                return;
            }

            // Initialize preview functionality
            if (typeof initAnimationPreview === 'function') {
                initAnimationPreview();
            }

            // Initialize preset management
            if (typeof initPresetManagement === 'function') {
                initPresetManagement();
            }

            // Initialize tabs
            if (typeof initTabs === 'function') {
                initTabs();
            }

            // Initialize tooltips
            if (typeof initTooltips === 'function') {
                initTooltips();
            }

            // Initialize enhanced preview page
            if (typeof initEnhancedPreview === 'function') {
                initEnhancedPreview();
            }

            // Initialize code modal
            if (typeof initCodeModal === 'function') {
                initCodeModal();
            }

            // Initialize custom builder
            if (typeof initCustomBuilder === 'function') {
                initCustomBuilder();
            }

        } catch (error) {
            console.warn('Oxy Animation Admin: Initialization error:', error);
        }
    }

    // Initialize when DOM is ready
    $(document).ready(function() {
        // Small delay to ensure all elements are rendered
        setTimeout(safeInit, 100);
    });

    // Fallback initialization for late-loading content
    $(window).on('load', function() {
        setTimeout(safeInit, 200);
    });

    // Animation preview functionality
    function initAnimationPreview() {
        const $previewElement = $('#preview-element');
        const $animationSelect = $('#animation-select');
        const $duration = $('#duration');
        const $delay = $('#delay');
        const $easing = $('#easing');
        const $playButton = $('#play-animation');
        const $resetButton = $('#reset-animation');
        const $cssOutput = $('#css-output');

        // Play animation
        $playButton.on('click', function() {
            const animation = $animationSelect.val();
            const duration = $duration.val();
            const delay = $delay.val();
            const easing = $easing.val();

            // Reset animation first
            resetAnimation();

            // Apply animation
            setTimeout(function() {
                $previewElement.addClass('oxy-anim oxy-anim-' + animation);
                $previewElement.css({
                    'animation-duration': duration + 'ms',
                    'animation-delay': delay + 'ms',
                    'animation-timing-function': easing,
                    'animation-fill-mode': 'both'
                });

                // Generate CSS output
                generateCSSOutput(animation, duration, delay, easing);
            }, 100);
        });

        // Reset animation
        $resetButton.on('click', resetAnimation);

        function resetAnimation() {
            $previewElement.removeClass(function(index, className) {
                return (className.match(/\boxy-anim-\S+/g) || []).join(' ');
            });
            $previewElement.removeClass('oxy-anim');
            $previewElement.removeAttr('style');
        }

        // Generate CSS output
        function generateCSSOutput(animation, duration, delay, easing) {
            const cssClass = `oxy-anim-${animation}`;

            // Generate complete CSS with class name, attributes info, and keyframes
            const css = `/* CSS Class for Oxygen Builder */\n.${cssClass} {\n` +
                `    animation-name: oxy${capitalizeFirst(animation)};\n` +
                `    animation-duration: ${duration}ms;\n` +
                `    animation-delay: ${delay}ms;\n` +
                `    animation-timing-function: ${easing};\n` +
                `    animation-fill-mode: both;\n` +
                `}\n\n` +
                `/* HTML Attributes for Oxygen Builder */\n` +
                `/* Add these to Advanced -> Attributes: */\n` +
                `/* data-duration="${duration}ms" */\n` +
                `/* data-delay="${delay}ms" */\n` +
                `/* data-easing="${easing}" */\n\n` +
                `/* Usage in Oxygen Builder: */\n` +
                `/* 1. Add CSS class: ${cssClass} */\n` +
                `/* 2. Add attributes in Advanced -> Attributes */\n` +
                `/* 3. Preview your animation! */`;

            $cssOutput.text(css);

            // Highlight code
            if (typeof Prism !== 'undefined') {
                Prism.highlightElement($cssOutput[0]);
            }
        }

        // Auto-preview on change
        $animationSelect.add($duration).add($delay).add($easing).on('change', function() {
            if ($previewElement.hasClass('oxy-anim')) {
                $playButton.trigger('click');
            }
        });

        // Preview presets
        $('.preview-preset').on('click', function() {
            const preset = $(this).data('preset');
            $animationSelect.val(preset);
            $playButton.trigger('click');
        });
    }

    // Preset management
    function initPresetManagement() {
        const $form = $('#custom-preset-form');
        const $presetGrid = $('.oxy-anim-presets-grid');

        // Save custom preset
        $form.on('submit', function(e) {
            e.preventDefault();

            const name = $('#preset-name').val().trim();
            const css = $('#preset-css').val().trim();

            if (!name || !css) {
                showNotice('Please fill in all fields', 'error');
                return;
            }

            // Check if preset already exists
            const existingPreset = $presetGrid.find('.preset-card h3:contains("' + name + '")');
            if (existingPreset.length > 0) {
                if (!confirm('A preset with this name already exists. Do you want to update it?')) {
                    return;
                }
            }

            // Send AJAX request
            $.ajax({
                url: oxyAnimAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'oxy_anim_save_preset',
                    name: name,
                    css: css,
                    nonce: oxyAnimAdmin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotice(response.data.message, 'success');

                        const editMode = $('#preset-edit-mode').val();
                        if (editMode === 'edit') {
                            exitEditMode();
                        } else {
                            $form[0].reset();
                            if (!response.data.is_update) {
                                addPresetToGrid(response.data.name);
                            }
                        }
                    } else {
                        showNotice(response.data.message || 'Error saving preset', 'error');
                    }
                },
                error: function() {
                    showNotice('Error saving preset', 'error');
                }
            });
        });

        // Add preset to grid
        function addPresetToGrid(name) {
            const $card = $('<div class="preset-card">' +
                '<h3>' + name + '</h3>' +
                '<button class="button preview-preset" data-preset="' + name + '">Preview</button>' +
                '<button class="button delete-preset" data-preset="' + name + '">Delete</button>' +
                '</div>');

            $presetGrid.append($card);
        }

        // Edit preset
        $presetGrid.on('click', '.edit-preset', function() {
            const $button = $(this);
            const preset = $button.data('preset');

            // Load preset data
            $.ajax({
                url: oxyAnimAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'oxy_anim_load_preset',
                    name: preset,
                    nonce: oxyAnimAdmin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        enterEditMode(response.data.name, response.data.css);
                        // Scroll to form
                        $('html, body').animate({
                            scrollTop: $('#custom-preset-form').offset().top - 50
                        }, 500);
                    } else {
                        showNotice(response.data.message || 'Error loading preset', 'error');
                    }
                },
                error: function() {
                    showNotice('Error loading preset', 'error');
                }
            });
        });

        // Delete preset
        $presetGrid.on('click', '.delete-preset', function() {
            const $button = $(this);
            const preset = $button.data('preset');

            if (!confirm('Are you sure you want to delete this preset?')) {
                return;
            }

            $.ajax({
                url: oxyAnimAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'oxy_anim_delete_preset',
                    name: preset,
                    nonce: oxyAnimAdmin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotice(response.data.message, 'success');
                        $button.closest('.preset-card').fadeOut(function() {
                            $(this).remove();
                        });
                    } else {
                        showNotice('Error deleting preset', 'error');
                    }
                },
                error: function() {
                    showNotice('Error deleting preset', 'error');
                }
            });
        });

        // Import/Export presets
        $('#export-presets').on('click', function() {
            // Get all presets and download as JSON
            $.ajax({
                url: oxyAnimAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'oxy_anim_export_presets',
                    nonce: oxyAnimAdmin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        downloadJSON(response.data, 'oxy-animation-presets.json');
                    }
                }
            });
        });

        $('#import-presets').on('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const presets = JSON.parse(e.target.result);
                    importPresets(presets);
                } catch (error) {
                    showNotice('Invalid preset file', 'error');
                }
            };
            reader.readAsText(file);
        });

        // Cancel edit button
        $('#preset-cancel-btn').on('click', function() {
            exitEditMode();
        });

        // Functions for edit mode
        function enterEditMode(name, css) {
            $('#preset-edit-mode').val('edit');
            $('#preset-original-name').val(name);
            $('#preset-name').val(name);
            $('#preset-css').val(css);
            $('#preset-form-title').text('Edit Custom Preset');
            $('#preset-submit-btn').text('Update Preset');
            $('#preset-cancel-btn').show();

            // Highlight the form
            $('.custom-preset-form').addClass('edit-mode');
        }

        function exitEditMode() {
            $('#preset-edit-mode').val('create');
            $('#preset-original-name').val('');
            $('#preset-name').val('');
            $('#preset-css').val('');
            $('#preset-form-title').text('Create Custom Preset');
            $('#preset-submit-btn').text('Save Preset');
            $('#preset-cancel-btn').hide();

            // Remove highlight
            $('.custom-preset-form').removeClass('edit-mode');
        }
    }

    // Initialize tabs
    function initTabs() {
        // Main tabs
        $('.oxy-anim-tab').on('click', function() {
            const $tab = $(this);
            const target = $tab.data('tab');

            // Update active states
            $('.oxy-anim-tab').removeClass('active');
            $tab.addClass('active');

            // Show content
            $('.oxy-anim-tab-content').removeClass('active');
            $('#' + target).addClass('active');
        });

        // GSAP category tabs
        $('.category-tab').on('click', function() {
            const $tab = $(this);
            const category = $tab.data('category');

            // Update active states
            $('.category-tab').removeClass('active');
            $tab.addClass('active');

            // Show content
            $('.category-content').removeClass('active');
            $('#' + category + '-effects').addClass('active');
        });
    }

    // Initialize tooltips
    function initTooltips() {
        $('[data-tooltip]').each(function() {
            const $element = $(this);
            const tooltip = $element.data('tooltip');

            $element.on('mouseenter', function() {
                const $tooltip = $('<div class="oxy-anim-tooltip">' + tooltip + '</div>');
                $('body').append($tooltip);

                const offset = $element.offset();
                $tooltip.css({
                    top: offset.top - $tooltip.outerHeight() - 10,
                    left: offset.left + ($element.outerWidth() / 2) - ($tooltip.outerWidth() / 2)
                });
            }).on('mouseleave', function() {
                $('.oxy-anim-tooltip').remove();
            });
        });
    }

    // Utility functions
    function showNotice(message, type) {
        const $notice = $('<div class="oxy-anim-notice ' + type + '">' + message + '</div>');

        $('.wrap h1').after($notice);

        setTimeout(function() {
            $notice.fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }

    function capitalizeFirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function downloadJSON(data, filename) {
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    function importPresets(presets) {
        $.ajax({
            url: oxyAnimAdmin.ajaxUrl,
            type: 'POST',
            data: {
                action: 'oxy_anim_import_presets',
                presets: JSON.stringify(presets),
                nonce: oxyAnimAdmin.nonce
            },
            success: function(response) {
                if (response.success) {
                    showNotice('Presets imported successfully', 'success');
                    location.reload();
                } else {
                    showNotice('Error importing presets', 'error');
                }
            }
        });
    }

    // Live animation builder
    class AnimationBuilder {
        constructor() {
            this.keyframes = [];
            this.currentFrame = 0;
            this.init();
        }

        init() {
            this.setupTimeline();
            this.setupControls();
        }

        setupTimeline() {
            const $timeline = $('<div class="oxy-anim-timeline"></div>');
            // Timeline implementation
        }

        setupControls() {
            // Control panel implementation
        }

        addKeyframe(time, properties) {
            this.keyframes.push({
                time: time,
                properties: properties
            });
            this.updateTimeline();
        }

        generateCSS() {
            // Generate CSS from keyframes
        }

        preview() {
            // Preview animation
        }
    }

    // Enhanced preview functionality
    function initEnhancedPreview() {
        try {
            // Handle preview buttons
            $(document).off('click.oxyPreview').on('click.oxyPreview', '.preview-btn', function(e) {
                e.preventDefault();
                const $button = $(this);
                const animation = $button.data('animation') || $button.data('effect');
                const $card = $button.closest('.oxy-anim-effect-card');
                const type = $card.data('type');
                const $preview = $card.find('.preview-element');

                if (animation && type && $preview.length) {
                    previewAnimation($preview, animation, type);
                }
            });

            // Handle code buttons
            $(document).off('click.oxyCode').on('click.oxyCode', '.code-btn', function(e) {
                e.preventDefault();
                const $button = $(this);
                const animation = $button.data('animation') || $button.data('effect');
                const $card = $button.closest('.oxy-anim-effect-card, .effect-card');

                // Get type from card or button (Effects Library uses button data-type)
                const type = $card.data('type') || $button.data('type');

                // Handle Effects Library data
                const cssClass = $button.data('css-class');
                const category = $button.data('category');

                if (animation && type) {
                    // Special handling for Effects Library
                    if (cssClass && category) {
                        showEffectsLibraryModal(animation, type, cssClass, category, $button);
                    } else {
                        showCodeModal(animation, type);
                    }
                }
            });

            // Auto-preview on card hover with debouncing
            let hoverTimeout;
            $(document).off('mouseenter.oxyHover').on('mouseenter.oxyHover', '.oxy-anim-effect-card', function() {
                const $card = $(this);
                const animation = $card.data('effect');
                const type = $card.data('type');
                const $preview = $card.find('.preview-element');

                clearTimeout(hoverTimeout);
                hoverTimeout = setTimeout(() => {
                    if ($card.is(':hover') && animation && type && $preview.length) {
                        previewAnimation($preview, animation, type);
                    }
                }, 800);
            }).off('mouseleave.oxyHover').on('mouseleave.oxyHover', '.oxy-anim-effect-card', function() {
                clearTimeout(hoverTimeout);
            });

        } catch (error) {
            console.warn('Enhanced preview initialization error:', error);
        }
    }

    // Preview animation
    function previewAnimation($element, animation, type) {
        try {
            if (!$element || !$element.length || !animation || !type) {
                console.warn('Invalid preview parameters');
                return;
            }

            // Reset any existing animations
            $element.removeClass(function(index, className) {
                return (className.match(/\banimate-\S+/g) || []).join(' ');
            });

            // Force reflow
            if ($element[0]) {
                $element[0].offsetHeight;
            }

            // Apply animation based on type
            if (type === 'css') {
                $element.addClass('animate-' + animation);

                // Remove animation class after completion
                setTimeout(() => {
                    if ($element.length) {
                        $element.removeClass('animate-' + animation);
                    }
                }, 1500);
            } else if (type === 'scroll') {
                // Simulate scroll animation
                const initialTransform = getInitialTransform(animation);
                $element.css({
                    opacity: 0,
                    transform: initialTransform
                });

                setTimeout(() => {
                    if ($element.length) {
                        $element.css({
                            opacity: 1,
                            transform: 'none',
                            transition: 'all 1s ease'
                        });
                    }
                }, 100);

                setTimeout(() => {
                    if ($element.length) {
                        $element.css('transition', '');
                    }
                }, 1100);
            } else if (type === 'js') {
                // Simulate JS effects
                simulateJSEffect($element, animation);
            }
        } catch (error) {
            console.warn('Preview animation error:', error);
        }
    }

    // Get initial transform for scroll animations
    function getInitialTransform(animation) {
        const transforms = {
            'fadeInUp': 'translateY(30px)',
            'fadeInDown': 'translateY(-30px)',
            'fadeInLeft': 'translateX(-30px)',
            'fadeInRight': 'translateX(30px)',
            'zoomIn': 'scale(0.8)',
            'zoomInRotate': 'scale(0.8) rotate(-10deg)',
            'slideInLeft': 'translateX(-100%)',
            'slideInRight': 'translateX(100%)',
            'slideInUp': 'translateY(100%)',
            'slideInDown': 'translateY(-100%)'
        };

        return transforms[animation] || 'translateY(30px)';
    }

    // Simulate JavaScript effects
    function simulateJSEffect($element, effect) {
        const $content = $element.find('.preview-content p');
        const originalText = $content.text();

        switch (effect) {
            case 'typewriter':
                $content.text('');
                let i = 0;
                const typeInterval = setInterval(() => {
                    $content.text(originalText.substring(0, i + 1));
                    i++;
                    if (i >= originalText.length) {
                        clearInterval(typeInterval);
                    }
                }, 100);
                break;

            case 'countUp':
                $content.text('0');
                let count = 0;
                const countInterval = setInterval(() => {
                    count += 50;
                    $content.text(count);
                    if (count >= 1000) {
                        clearInterval(countInterval);
                    }
                }, 50);
                break;

            case 'textScramble':
                const chars = '!@#$%^&*()';
                let scrambleCount = 0;
                const scrambleInterval = setInterval(() => {
                    let scrambled = '';
                    for (let j = 0; j < originalText.length; j++) {
                        if (Math.random() < 0.3) {
                            scrambled += chars[Math.floor(Math.random() * chars.length)];
                        } else {
                            scrambled += originalText[j];
                        }
                    }
                    $content.text(scrambled);
                    scrambleCount++;
                    if (scrambleCount > 10) {
                        clearInterval(scrambleInterval);
                        $content.text(originalText);
                    }
                }, 100);
                break;

            case 'glowPulse':
                $element.css({
                    'box-shadow': '0 0 20px rgba(0, 255, 0, 0.8)',
                    'transition': 'box-shadow 0.5s ease'
                });
                setTimeout(() => {
                    $element.css('box-shadow', '');
                }, 1000);
                break;

            default:
                // Generic animation for other effects
                $element.css('transform', 'scale(1.1)');
                setTimeout(() => {
                    $element.css('transform', '');
                }, 500);
        }
    }

    // Code modal functionality
    function initCodeModal() {
        try {
            // Close modal with proper event handling
            $(document).off('click.oxyModal').on('click.oxyModal', '.modal-close', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $('#code-modal').hide();
            });

            $(document).off('click.oxyModalBg').on('click.oxyModalBg', '.oxy-anim-modal', function(e) {
                if (e.target === this) {
                    e.preventDefault();
                    $('#code-modal').hide();
                }
            });

            // Escape key to close modal
            $(document).off('keydown.oxyModal').on('keydown.oxyModal', function(e) {
                if (e.keyCode === 27 && $('#code-modal').is(':visible')) {
                    $('#code-modal').hide();
                }
            });

            // Code tabs with error handling
            $(document).off('click.oxyTabs').on('click.oxyTabs', '.code-tab', function(e) {
                e.preventDefault();
                try {
                    const $tab = $(this);
                    const lang = $tab.data('lang');
                    const $container = $tab.closest('.modal-body, .builder-code-output');

                    if (!lang || !$container.length) return;

                    $container.find('.code-tab').removeClass('active');
                    $tab.addClass('active');

                    $container.find('.code-block').removeClass('active');

                    // Handle different tab structures
                    let targetId;
                    if ($container.hasClass('modal-body')) {
                        // Enhanced Effects Library modal structure
                        if (lang === 'oxygen') {
                            targetId = '#modal-oxygen-content';
                        } else if (lang === 'shortcode') {
                            targetId = '#modal-shortcode-content';
                        } else if (lang === 'js') {
                            targetId = '#modal-js-content';
                        } else {
                            // CSS, HTML use the simple structure
                            targetId = '#modal-' + lang + '-code';
                        }
                    } else {
                        // Builder code output structure
                        targetId = '#builder-' + lang + '-output';
                    }

                    $container.find(targetId).addClass('active');
                } catch (error) {
                    console.warn('Tab switching error:', error);
                }
            });

            // Individual copy buttons for specific elements
            $(document).on('click', '.copy-btn', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const target = $btn.data('target');
                const $targetElement = $('#' + target);

                if ($targetElement.length) {
                    const text = $targetElement.text();

                    // Use modern clipboard API
                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(text).then(() => {
                            showCopySuccess($btn);
                        }).catch(() => {
                            fallbackCopy(text, $btn);
                        });
                    } else {
                        fallbackCopy(text, $btn);
                    }
                }
            });

            // Copy to clipboard
            $('#copy-code, #builder-copy-code').on('click', function() {
                const $container = $(this).closest('.modal-body, .builder-code-output');
                const $activeCode = $container.find('.code-block.active');
                const text = $activeCode.text();

                // Use modern clipboard API with proper error handling
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(() => {
                        showCopyNotification();
                    }).catch((err) => {
                        console.warn('Clipboard API failed:', err);
                        fallbackCopyText(text);
                    });
                } else {
                    fallbackCopyText(text);
                }
            });

            // Fallback copy function
            function fallbackCopyText(text) {
                try {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    textarea.style.pointerEvents = 'none';
                    document.body.appendChild(textarea);
                    textarea.focus();
                    textarea.select();

                    const successful = document.execCommand('copy');
                    document.body.removeChild(textarea);

                    if (successful) {
                        showCopyNotification();
                    } else {
                        showCopyError();
                    }
                } catch (err) {
                    console.error('Copy failed:', err);
                    showCopyError();
                }
            }

        } catch (error) {
            console.error('Code modal initialization error:', error);
        }
    }

    // Show code modal
    function showCodeModal(animation, type) {
        const codes = generateCode(animation, type);

        $('#modal-title').text(animation + ' - Animation Code');
        $('#modal-css-code').text(codes.css);
        $('#modal-html-code').text(codes.html);
        $('#modal-js-code').text(codes.js);
        $('#modal-shortcode-code').text(codes.shortcode);

        $('#code-modal').show();
    }

    // Show Effects Library modal with AJAX data
    function showEffectsLibraryModal(effect, type, cssClass, category, $button) {
        console.log('=== EFFECTS LIBRARY MODAL ===');
        console.log('Effect:', effect, 'Type:', type, 'CSS Class:', cssClass, 'Category:', category);

        // Check if we have the AJAX data available (from Effects Library page)
        if (typeof oxyAnimData !== 'undefined' && oxyAnimData.ajaxUrl) {
            $.post(oxyAnimData.ajaxUrl, {
                action: 'oxy_anim_get_effect_code',
                nonce: oxyAnimData.nonce,
                category: category,
                effect: effect
            })
            .done(function(response) {
                console.log('Effects Library AJAX Response:', response);

                if (response && response.success && response.data) {
                    // Use the comprehensive data from Effects Library
                    const data = response.data;

                    $('#modal-title').text((data.effect_name || effect) + ' - Effect Code');

                    // Populate Oxygen Builder Tab
                    populateOxygenBuilderTab(data);

                    // Populate Shortcode Tab
                    populateShortcodeTab(data, effect);

                    // Populate CSS Tab
                    const cssCode = data.custom_css || generateEffectCSS(data.css_class || cssClass, data);
                    $('#modal-css-code').text(cssCode);

                    // Populate HTML Tab
                    const htmlCode = data.html || generateEffectHTML(data.css_class || cssClass, data.attributes);
                    $('#modal-html-code').text(htmlCode);

                    // Populate JavaScript Tab
                    populateJavaScriptTab(data, cssClass);

                    $('#code-modal').show();
                } else {
                    console.error('Failed to get Effects Library data, using fallback');
                    showCodeModalFallback(effect, cssClass);
                }
            })
            .fail(function() {
                console.error('Effects Library AJAX failed, using fallback');
                showCodeModalFallback(effect, cssClass);
            });
        } else {
            // Fallback to basic modal with generated codes
            showCodeModalFallback(effect, cssClass);
        }
    }

    // Fallback modal for Effects Library
    function showCodeModalFallback(effect, cssClass) {
        $('#modal-title').text(effect + ' - Effect Code');
        $('#modal-css-code').text(generateEffectCSS(cssClass));
        $('#modal-html-code').text(generateEffectHTML(cssClass));
        $('#modal-js-code').text(generateEffectJS(cssClass));
        $('#modal-shortcode-code').text(generateEffectShortcode(effect));
        $('#code-modal').show();
    }

    // Helper functions for Effects Library code generation
    function generateEffectCSS(cssClass, data = {}) {
        return `/* ${cssClass} Effect */\n` +
               `.${cssClass} {\n` +
               `    /* Add this CSS class to your element in Oxygen Builder */\n` +
               `    /* Go to Advanced → CSS Classes and add: ${cssClass} */\n` +
               `}\n\n` +
               `/* The animation CSS is loaded automatically by the plugin */`;
    }

    function generateEffectHTML(cssClass, attributes = {}) {
        let html = `<!-- Copy this HTML structure -->\n<div class="${cssClass}"`;

        if (attributes && Object.keys(attributes).length > 0) {
            for (let attr in attributes) {
                html += `\n     ${attr}="${attributes[attr]}"`;
            }
        }

        html += `>\n    Your content here\n</div>`;
        return html;
    }

    function generateEffectJS(cssClass, requiresGsap = false) {
        if (requiresGsap) {
            return `// ${cssClass} - Requires GSAP\n` +
                   `// Make sure GSAP is loaded in plugin settings\n\n` +
                   `if (typeof gsap !== 'undefined') {\n` +
                   `    // GSAP animation code\n` +
                   `    document.querySelectorAll('.${cssClass}').forEach(element => {\n` +
                   `        // Initialize ${cssClass} effect\n` +
                   `    });\n` +
                   `} else {\n` +
                   `    console.warn('GSAP library required for ${cssClass}');\n` +
                   `}`;
        } else {
            return `// ${cssClass} Effect\n` +
                   `// This is a CSS-only effect\n` +
                   `// Just add the "${cssClass}" class to your element in Oxygen Builder`;
        }
    }

    function generateEffectShortcode(effect, attributes = {}) {
        let shortcode = `[oxy_anim type="${effect}"`;

        if (attributes && Object.keys(attributes).length > 0) {
            for (let attr in attributes) {
                const attrName = attr.replace('data-', '');
                shortcode += ` ${attrName}="${attributes[attr]}"`;
            }
        }

        shortcode += `]\n    Your content here\n[/oxy_anim]`;
        return shortcode;
    }

    // Populate Oxygen Builder Tab
    function populateOxygenBuilderTab(data) {
        // CSS Class
        const cssClass = data.css_class || 'oxy-effect-class';
        $('#modal-oxygen-class').text(cssClass);

        // Custom Attributes
        let attributesText = '';
        if (data.attributes && Object.keys(data.attributes).length > 0) {
            for (let attr in data.attributes) {
                attributesText += `${attr}="${data.attributes[attr]}"\n`;
            }
        } else {
            attributesText = 'No attributes required for this effect.';
        }
        $('#modal-oxygen-attributes').text(attributesText);
    }

    // Populate Shortcode Tab
    function populateShortcodeTab(data, effect) {
        // Shortcode
        const shortcode = data.shortcode || generateEffectShortcode(effect, data.attributes);
        $('#modal-shortcode-code').text(shortcode);

        // Available Parameters
        let paramsHtml = '';
        if (data.parameters && Object.keys(data.parameters).length > 0) {
            paramsHtml = '<ul class="parameter-list">';
            for (let param in data.parameters) {
                paramsHtml += `<li><strong>${param}:</strong> ${data.parameters[param].description}</li>`;
            }
            paramsHtml += '</ul>';
        } else if (data.attributes && Object.keys(data.attributes).length > 0) {
            // Generate parameters from attributes
            paramsHtml = '<ul class="parameter-list">';
            for (let attr in data.attributes) {
                const paramName = attr.replace('data-', '');
                paramsHtml += `<li><strong>${paramName}:</strong> ${attr} (Default: ${data.attributes[attr]})</li>`;
            }
            paramsHtml += '</ul>';
        } else {
            paramsHtml = '<p>This effect does not have configurable parameters.</p>';
        }
        $('#modal-shortcode-params').html(paramsHtml);
    }

    // Populate JavaScript Tab
    function populateJavaScriptTab(data, cssClass) {
        // JavaScript Code
        const jsCode = data.javascript || generateEffectJS(data.css_class || cssClass, data.requires_gsap);
        $('#modal-js-code').text(jsCode);

        // Custom Options Example
        let optionsCode = '';
        if (data.js_options) {
            optionsCode = data.js_options;
        } else if (data.attributes && Object.keys(data.attributes).length > 0) {
            // Generate options example from attributes
            optionsCode = `// Available options for ${data.effect_name || 'this effect'}\n`;
            optionsCode += `const options = {\n`;
            for (let attr in data.attributes) {
                const optionName = attr.replace('data-', '');
                optionsCode += `    ${optionName}: '${data.attributes[attr]}', // ${attr}\n`;
            }
            optionsCode += `};\n\n`;
            optionsCode += `// Apply options via data attributes:\n`;
            for (let attr in data.attributes) {
                optionsCode += `// <div ${attr}="${data.attributes[attr]}">Content</div>\n`;
            }
        } else if (data.requires_gsap) {
            optionsCode = `// GSAP Options Example\n`;
            optionsCode += `const options = {\n`;
            optionsCode += `    duration: 1,        // Animation duration in seconds\n`;
            optionsCode += `    delay: 0,           // Animation delay in seconds\n`;
            optionsCode += `    ease: 'power2.out', // GSAP easing function\n`;
            optionsCode += `    trigger: 'scroll'   // Trigger type\n`;
            optionsCode += `};\n\n`;
            optionsCode += `// Apply to elements:\n`;
            optionsCode += `gsap.to('.${data.css_class || cssClass}', options);`;
        } else {
            optionsCode = `// ${data.effect_name || 'This effect'} - CSS Only\n`;
            optionsCode += `// This effect is controlled entirely by CSS.\n`;
            optionsCode += `// You can customize it by modifying the CSS variables:\n\n`;
            optionsCode += `:root {\n`;
            optionsCode += `    --animation-duration: 1s;\n`;
            optionsCode += `    --animation-delay: 0s;\n`;
            optionsCode += `    --animation-timing: ease-in-out;\n`;
            optionsCode += `}`;
        }

        $('#modal-js-options').text(optionsCode);
    }

    // Helper function for copy success feedback
    function showCopySuccess($btn) {
        const originalText = $btn.text();
        $btn.text('Copied!').addClass('copied');
        setTimeout(() => {
            $btn.text(originalText).removeClass('copied');
        }, 2000);
    }

    // Fallback copy function
    function fallbackCopy(text, $btn) {
        try {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();

            const successful = document.execCommand('copy');
            document.body.removeChild(textarea);

            if (successful) {
                showCopySuccess($btn);
            } else {
                $btn.text('Copy Failed').addClass('error');
                setTimeout(() => {
                    $btn.text('Copy').removeClass('error');
                }, 2000);
            }
        } catch (err) {
            console.error('Copy failed:', err);
        }
    }

    // Generate code for animation
    function generateCode(animation, type) {
        const codes = {
            css: '',
            html: '',
            js: '',
            shortcode: ''
        };

        if (type === 'css') {
            const cssClass = `oxy-anim-${animation}`;
            codes.css = `/* Copy this CSS to your stylesheet */\n.${cssClass} {\n    animation: oxy${capitalizeFirst(animation)} 1s ease;\n    animation-fill-mode: both;\n}\n\n/* Trigger on scroll or hover */\n.${cssClass}.in-view,\n.${cssClass}:hover {\n    animation-play-state: running;\n}\n\n@keyframes oxy${capitalizeFirst(animation)} {\n    /* Animation keyframes are loaded automatically */\n}`;

            codes.html = `<!-- Copy this HTML structure -->\n<div class="${cssClass}"\n     data-duration="1s"\n     data-delay="0s">\n    Your content here\n</div>`;

            codes.js = `// Optional JavaScript for scroll trigger\nconst observer = new IntersectionObserver(entries => {\n    entries.forEach(entry => {\n        if (entry.isIntersecting) {\n            entry.target.classList.add('in-view');\n        }\n    });\n});\n\ndocument.querySelectorAll('.${cssClass}').forEach(el => {\n    observer.observe(el);\n});`;

            codes.shortcode = `[oxy_anim type="${animation}" duration="1s" delay="0s"]\n    Your content here\n[/oxy_anim]`;

        } else if (type === 'scroll') {
            const scrollClass = `oxy-scroll-${animation}`;
            codes.css = `/* Copy this CSS */\n.${scrollClass} {\n    opacity: 0;\n    transform: translateY(50px);\n    transition: all 1s ease;\n}\n\n.${scrollClass}.in-view {\n    opacity: 1;\n    transform: translateY(0);\n}`;

            codes.html = `<!-- Copy this HTML -->\n<div class="${scrollClass}"\n     data-scroll-animation="${animation}"\n     data-duration="1000"\n     data-delay="0">\n    Your content here\n</div>`;

            codes.js = `// Scroll trigger JavaScript\nconst scrollObserver = new IntersectionObserver((entries) => {\n    entries.forEach(entry => {\n        if (entry.isIntersecting) {\n            entry.target.classList.add('in-view');\n        }\n    });\n});\n\ndocument.querySelectorAll('.${scrollClass}').forEach(element => {\n    scrollObserver.observe(element);\n});`;

            codes.shortcode = `[oxy_scroll animation="${animation}" duration="1000" delay="0"]\n    Your content here\n[/oxy_scroll]`;

        } else if (type === 'js') {
            const jsClass = `oxy-js-${animation}`;
            codes.css = `/* Base styles for ${animation} effect */\n.${jsClass} {\n    /* JavaScript will handle the animation */\n    /* Add your base styles here */\n}`;

            codes.html = `<!-- Copy this HTML -->\n<div class="${jsClass}"\n     data-effect="${animation}"\n     data-trigger="load"\n     data-speed="50">\n    Your content here\n</div>`;

            codes.js = `// ${animation} Effect JavaScript\nfunction init${capitalizeFirst(animation)}() {\n    document.querySelectorAll('.${jsClass}').forEach(element => {\n        const speed = element.dataset.speed || 50;\n        // Add your ${animation} effect logic here\n        console.log('Initializing ${animation} on:', element);\n    });\n}\n\n// Initialize when page loads\ndocument.addEventListener('DOMContentLoaded', init${capitalizeFirst(animation)});`;

            codes.shortcode = `[oxy_js effect="${animation}" speed="50" trigger="load"]\n    Your content here\n[/oxy_js]`;
        }

        return codes;
    }

    // Custom builder functionality
    function initCustomBuilder() {
        const $builderType = $('#builder-animation-type');
        const $builderDuration = $('#builder-duration');
        const $builderDelay = $('#builder-delay');
        const $builderTrigger = $('#builder-trigger');
        const $builderEasing = $('#builder-easing');
        const $builderPreview = $('#builder-preview');
        const $builderReset = $('#builder-reset');
        const $previewElement = $('#builder-preview-element');

        // Update code output when settings change
        function updateBuilderCode() {
            const type = $builderType.find(':selected').data('type');
            const animation = $builderType.val();
            const duration = $builderDuration.val();
            const delay = $builderDelay.val();
            const trigger = $builderTrigger.val();
            const easing = $builderEasing.val();

            const codes = generateBuilderCode(animation, type, {
                duration: duration,
                delay: delay,
                trigger: trigger,
                easing: easing
            });

            $('#builder-css-output').text(codes.css);
            $('#builder-html-output').text(codes.html);
            $('#builder-js-output').text(codes.js);
            $('#builder-shortcode-output').text(codes.shortcode);
        }

        // Event handlers
        $builderType.add($builderDuration).add($builderDelay).add($builderTrigger).add($builderEasing).on('change input', updateBuilderCode);

        $builderPreview.on('click', function() {
            const type = $builderType.find(':selected').data('type');
            const animation = $builderType.val();
            const duration = $builderDuration.val();
            const delay = $builderDelay.val();
            const easing = $builderEasing.val();

            previewBuilderAnimation($previewElement, animation, type, {
                duration: duration,
                delay: delay,
                easing: easing
            });
        });

        $builderReset.on('click', function() {
            $previewElement.removeClass(function(index, className) {
                return (className.match(/\banimate-\S+/g) || []).join(' ');
            });
            $previewElement.removeAttr('style');
        });

        // Initialize with default values
        updateBuilderCode();
    }

    // Generate builder code
    function generateBuilderCode(animation, type, options) {
        const codes = {
            css: '',
            html: '',
            js: '',
            shortcode: ''
        };

        if (type === 'css') {
            const builderClass = `oxy-anim-${animation}`;
            codes.css = `/* Custom ${animation} animation */\n.${builderClass} {\n    animation: oxy${capitalizeFirst(animation)} ${options.duration}ms ${options.easing};\n    animation-delay: ${options.delay}ms;\n    animation-fill-mode: both;\n}\n\n/* Trigger conditions */\n.${builderClass}[data-trigger=\"hover\"]:hover,\n.${builderClass}[data-trigger=\"scroll\"].in-view {\n    animation-play-state: running;\n}`;

            codes.html = `<!-- Custom animation HTML -->\n<div class="${builderClass}"\n     data-trigger="${options.trigger}"\n     data-duration="${options.duration}"\n     data-delay="${options.delay}">\n    Your content here\n</div>`;

        } else if (type === 'js') {
            const jsBuilderClass = `oxy-js-${animation}`;
            codes.js = `// Custom ${animation} JavaScript\nfunction apply${capitalizeFirst(animation)}Effect() {\n    document.querySelectorAll('.${jsBuilderClass}').forEach(element => {\n        // Custom ${animation} logic\n        setTimeout(() => {\n            // Add your effect logic here\n            console.log('Applying ${animation} to:', element);\n        }, ${options.delay});\n    });\n}\n\n// Initialize\nif (document.readyState === 'loading') {\n    document.addEventListener('DOMContentLoaded', apply${capitalizeFirst(animation)}Effect);\n} else {\n    apply${capitalizeFirst(animation)}Effect();\n}`;

            codes.html = `<!-- Custom JS effect HTML -->\n<div class="${jsBuilderClass}"\n     data-effect="${animation}"\n     data-trigger="${options.trigger}"\n     data-delay="${options.delay}">\n    Your content here\n</div>`;
        }

        codes.shortcode = `[oxy_${type === 'css' ? 'anim' : 'js'} ${type === 'css' ? 'type' : 'effect'}="${animation}" duration="${options.duration}" delay="${options.delay}" trigger="${options.trigger}"]\n    Your content here\n[/oxy_${type === 'css' ? 'anim' : 'js'}]`;

        return codes;
    }

    // Preview builder animation
    function previewBuilderAnimation($element, animation, type, options) {
        // Reset
        $element.removeClass(function(index, className) {
            return (className.match(/\banimate-\S+/g) || []).join(' ');
        });
        $element.removeAttr('style');

        // Force reflow
        $element[0].offsetHeight;

        // Apply animation
        setTimeout(() => {
            if (type === 'css') {
                $element.addClass('animate-' + animation);
                $element.css({
                    'animation-duration': options.duration + 'ms',
                    'animation-delay': options.delay + 'ms',
                    'animation-timing-function': options.easing
                });
            } else {
                simulateJSEffect($element, animation);
            }
        }, parseInt(options.delay));
    }

    // Show copy notification
    function showCopyNotification() {
        const $notification = $('<div class="copy-notification">Copied to clipboard!</div>');
        $('body').append($notification);

        setTimeout(() => {
            $notification.remove();
        }, 2000);
    }

    // Show copy error notification
    function showCopyError() {
        const $notification = $('<div class="copy-notification copy-error">Failed to copy. Please try again.</div>');
        $('body').append($notification);

        setTimeout(() => {
            $notification.remove();
        }, 3000);
    }

    // Animation Preview Filters and Search
    function initAnimationPreviewFilters() {
        if ($('.oxy-anim-preview-wrap').length === 0) return;

        // Search functionality
        $('#preview-search').on('input', function() {
            const query = $(this).val().toLowerCase();
            filterAnimations(query);
        });

        $('#clear-search').on('click', function() {
            $('#preview-search').val('');
            filterAnimations('');
        });

        // Tag filtering
        $('.filter-tag').on('click', function() {
            $('.filter-tag').removeClass('active');
            $(this).addClass('active');

            const tag = $(this).data('tag');
            filterByTag(tag);
        });

        // Sorting
        $('#sort-animations').on('change', function() {
            const sortBy = $(this).val();
            sortAnimations(sortBy);
        });

        // Initialize results counter
        updateResultsCount();
    }

    function filterAnimations(query) {
        $('.oxy-anim-effect-card').each(function() {
            const card = $(this);
            const name = card.data('name') || '';
            const tags = card.data('tags') || '';
            const description = card.find('.effect-description').text().toLowerCase();

            const matches = name.includes(query) ||
                          tags.includes(query) ||
                          description.includes(query);

            if (matches || query === '') {
                card.show();
            } else {
                card.hide();
            }
        });

        updateResultsCount();
    }

    function filterByTag(tag) {
        $('.oxy-anim-effect-card').each(function() {
            const card = $(this);
            const tags = card.data('tags') || '';

            if (tag === 'all' || tags.includes(tag)) {
                card.show();
            } else {
                card.hide();
            }
        });

        updateResultsCount();
    }

    function sortAnimations(sortBy) {
        const containers = ['.oxy-anim-effects-grid'];

        containers.forEach(containerSelector => {
            const container = $(containerSelector);
            if (container.length === 0) return;

            const cards = container.find('.oxy-anim-effect-card').get();

            cards.sort(function(a, b) {
                const aCard = $(a);
                const bCard = $(b);

                switch(sortBy) {
                    case 'name':
                        return aCard.data('name').localeCompare(bCard.data('name'));
                    case 'name-desc':
                        return bCard.data('name').localeCompare(aCard.data('name'));
                    case 'category':
                        const aCat = aCard.data('category') || 'zzz';
                        const bCat = bCard.data('category') || 'zzz';
                        return aCat.localeCompare(bCat);
                    case 'popularity':
                        // Sort by tag popularity (more tags = more popular)
                        const aTags = (aCard.data('tags') || '').split(',').length;
                        const bTags = (bCard.data('tags') || '').split(',').length;
                        return bTags - aTags;
                    default:
                        return 0;
                }
            });

            $.each(cards, function(index, item) {
                container.append(item);
            });
        });
    }

    function updateResultsCount() {
        const visible = $('.oxy-anim-effect-card:visible').length;
        const total = $('.oxy-anim-effect-card').length;

        // Update or create results counter
        if ($('.results-count').length === 0) {
            $('.preview-controls').append('<div class="results-count"></div>');
        }

        $('.results-count').text(`Showing ${visible} of ${total} animations`);
    }

    // Initialize animation preview filters
    initAnimationPreviewFilters();

    // Initialize animation builder if on builder page
    if ($('#animation-builder').length) {
        new AnimationBuilder();
    }

})(jQuery);
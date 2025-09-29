<?php
/**
 * Effects Showcase Page
 * Displays all effects organized by category with code examples
 *
 * @package    Oxy_Animation
 * @author     Ahmed Tawfek
 */

if (!defined('ABSPATH')) {
    exit;
}

class Oxy_Animation_Effects_Showcase {

    public function render_showcase_page() {
        $registry = Oxy_Animation_Effects_Registry::get_instance();
        $effects = $registry->get_all_effects();
        ?>
        <div class="wrap oxy-anim-showcase">
            <!-- Simplified Header -->
            <div class="showcase-header-simple">
                <h1>Animation Effects Library</h1>
                <p>Simple animation effects for Oxygen Builder</p>
            </div>

            <div class="showcase-layout">
                <!-- Sidebar -->
                <div class="effects-sidebar">
                    <div class="sidebar-search">
                        <input type="text" id="effects-search" placeholder="Search animations...">
                        <span class="dashicons dashicons-search"></span>
                    </div>

                    <div class="sidebar-filters">
                        <h3>Animation Types</h3>
                        <ul class="filter-list">
                            <?php
                            // Calculate total effects count
                            $total_effects_count = 0;
                            foreach ($effects as $cat) {
                                $total_effects_count += count($cat['effects']);
                            }
                            ?>
                            <li class="filter-item active" data-tag="all">
                                <span class="dashicons dashicons-grid-view"></span>
                                All Animations
                                <span class="count"><?php echo $total_effects_count; ?></span>
                            </li>

                            <?php foreach ($effects as $category_key => $category_data): ?>
                            <li class="filter-section">
                                <div class="section-header" data-toggle="collapse" data-category="<?php echo esc_attr($category_key); ?>">
                                    <span class="dashicons dashicons-arrow-down-alt2 toggle-icon"></span>
                                    <span class="<?php echo esc_attr($category_data['icon']); ?>"></span>
                                    <?php echo esc_html($category_data['name']); ?>
                                    <span class="category-count"><?php echo count($category_data['effects']); ?></span>
                                </div>
                                <ul class="sub-filters" style="display: <?php echo $category_key === 'general' ? 'block' : 'none'; ?>;">
                                    <?php
                                    // Get unique tags for this category
                                    $category_tags = array();
                                    foreach ($category_data['effects'] as $effect) {
                                        foreach ($effect['tags'] as $tag) {
                                            if (!in_array($tag, $category_tags)) {
                                                $category_tags[] = $tag;
                                            }
                                        }
                                    }

                                    // Display first 8 tags for this category
                                    $tag_icons = array(
                                        'attention seekers' => 'dashicons-star-filled',
                                        'fading entrances' => 'dashicons-images-alt2',
                                        'fading exits' => 'dashicons-images-alt2',
                                        'bouncing entrances' => 'dashicons-format-status',
                                        'bouncing exits' => 'dashicons-format-status',
                                        'zooming entrances' => 'dashicons-search',
                                        'zooming exits' => 'dashicons-search',
                                        'sliding entrances' => 'dashicons-slides',
                                        'sliding exits' => 'dashicons-slides',
                                        'rotating entrances' => 'dashicons-image-rotate',
                                        'rotating exits' => 'dashicons-image-rotate',
                                        'flippers' => 'dashicons-image-flip-horizontal',
                                        'lightspeed' => 'dashicons-superhero-alt',
                                        'specials' => 'dashicons-awards',
                                        'background' => 'dashicons-format-image',
                                        'gradient' => 'dashicons-art',
                                        'color' => 'dashicons-admin-appearance',
                                        'pattern' => 'dashicons-grid-view',
                                        'texture' => 'dashicons-editor-textcolor',
                                        'overlay' => 'dashicons-layout',
                                        'digital' => 'dashicons-laptop',
                                        'space' => 'dashicons-star-filled',
                                        'particles' => 'dashicons-networking'
                                    );

                                    $displayed_tags = array_slice($category_tags, 0, 8);
                                    foreach ($displayed_tags as $tag):
                                        $icon = isset($tag_icons[$tag]) ? $tag_icons[$tag] : 'dashicons-tag';
                                        $tag_display = ucwords(str_replace(array('-', '_'), ' ', $tag));
                                    ?>
                                    <li class="filter-item" data-tag="<?php echo esc_attr($tag); ?>" data-category="<?php echo esc_attr($category_key); ?>">
                                        <span class="dashicons <?php echo esc_attr($icon); ?>"></span>
                                        <?php echo esc_html($tag_display); ?>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="effects-main-content">
                    <!-- Effects Grid -->
                    <div class="effects-grid">
                <?php
                $total_count = 0;

                // Loop through all categories dynamically
                foreach ($effects as $category_key => $category_data):
                    $category_count = 0;
                ?>
                <div class="category-section" data-category="<?php echo esc_attr($category_key); ?>">
                    <div class="category-header">
                        <h2 class="category-title">
                            <span class="<?php echo esc_attr($category_data['icon']); ?>"></span>
                            <?php echo esc_html($category_data['name']); ?>
                        </h2>
                        <div class="effects-count">
                            <span class="count-number"><?php echo count($category_data['effects']); ?></span>
                            <span class="count-label">effects available</span>
                        </div>
                    </div>

                    <div class="effects-list">
                        <?php foreach ($category_data['effects'] as $effect_key => $effect):
                            $total_count++;
                            $category_count++;
                        ?>
                            <div class="effect-card"
                                 data-effect="<?php echo esc_attr($effect_key); ?>"
                                 data-tags="<?php echo esc_attr(implode(' ', $effect['tags'])); ?>"
                                 data-name="<?php echo esc_attr(strtolower($effect['name'])); ?>">

                                <div class="effect-preview">
                                    <div class="preview-element" data-preview-text="<?php echo esc_attr($effect['class']); ?>">
                                        <span class="preview-text"><?php echo esc_html($effect['class']); ?></span>
                                    </div>
                                    <div class="preview-overlay">
                                        <button class="preview-btn" data-class="<?php echo esc_attr($effect['class']); ?>">
                                            <span class="dashicons dashicons-controls-play"></span>
                                            Preview
                                        </button>
                                    </div>
                                </div>

                                <div class="effect-info">
                                    <div class="effect-header">
                                        <h3 class="effect-title"><?php echo esc_html($effect['name']); ?></h3>
                                        <span class="effect-number">#<?php echo $category_count; ?></span>
                                    </div>

                                    <p class="effect-description"><?php echo esc_html($effect['preview']); ?></p>

                                    <!-- Tags Display -->
                                    <div class="effect-tags">
                                        <?php foreach ($effect['tags'] as $tag): ?>
                                            <span class="tag-badge" data-tag="<?php echo esc_attr($tag); ?>"><?php echo esc_html($tag); ?></span>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="effect-actions">
                                        <button class="button button-primary code-btn"
                                                data-effect="<?php echo esc_attr($effect_key); ?>"
                                                data-type="css"
                                                data-css-class="<?php echo esc_attr($effect['class']); ?>"
                                                data-category="<?php echo esc_attr($category_key); ?>">
                                            <span class="dashicons dashicons-editor-code"></span> Get Code
                                        </button>
                                        <button class="button copy-class-btn"
                                                data-class="<?php echo esc_attr($effect['class']); ?>"
                                                title="Copy CSS class to clipboard">
                                            <span class="dashicons dashicons-admin-page"></span>
                                        </button>
                                        <button class="button demo-btn"
                                                data-class="<?php echo esc_attr($effect['class']); ?>"
                                                title="Quick demo animation">
                                            <span class="dashicons dashicons-controls-play"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
                </div><!-- .effects-main-content -->
            </div><!-- .showcase-layout -->

            <!-- Code Modal -->
            <div id="code-modal" class="oxy-anim-modal" style="display: none;">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title-section">
                            <h2 id="modal-title">Animation Code</h2>
                            <p id="modal-subtitle">Copy the code for your animation</p>
                        </div>
                        <button class="modal-close" title="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="code-tabs-wrapper">
                            <div class="code-tabs">
                                <button class="code-tab active" data-lang="settings">
                                    <span class="dashicons dashicons-admin-generic"></span>
                                    Settings
                                </button>
                                <button class="code-tab" data-lang="oxygen">
                                    <span class="dashicons dashicons-admin-customizer"></span>
                                    Oxygen Builder
                                </button>
                                <button class="code-tab" data-lang="css" style="display: none;">
                                    <span class="dashicons dashicons-media-code"></span>
                                    CSS
                                </button>
                                <button class="code-tab" data-lang="html" style="display: none;">
                                    <span class="dashicons dashicons-editor-code"></span>
                                    HTML
                                </button>
                                <button class="code-tab" data-lang="shortcode" style="display: none;">
                                    <span class="dashicons dashicons-shortcode"></span>
                                    Shortcode
                                </button>
                                <button class="code-tab" data-lang="js" style="display: none;">
                                    <span class="dashicons dashicons-media-code"></span>
                                    JavaScript
                                </button>
                            </div>
                        </div>
                        <div class="code-content">
                            <!-- Settings Tab -->
                            <div id="modal-settings-content" class="code-panel active">
                                <div class="settings-main-section">
                                    <div id="attribute-controls-container">
                                        <!-- Attribute controls will be loaded here via AJAX -->
                                    </div>

                                    <div class="generated-code-preview">
                                        <div class="code-header">
                                            <h4>Generated CSS Class with Attributes</h4>
                                            <button class="copy-btn" data-target="generated-css-output" title="Copy generated class">
                                                <span class="dashicons dashicons-admin-page"></span>
                                                Copy
                                            </button>
                                        </div>
                                        <div class="code-box">
                                            <code id="generated-css-output"></code>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Oxygen Builder Tab -->
                            <div id="modal-oxygen-content" class="code-panel">
                                <div class="code-main-section">
                                    <div class="code-preview">
                                        <div class="code-header">
                                            <h4>CSS Class to Add</h4>
                                            <button class="copy-btn" data-target="modal-oxygen-class" title="Copy class name">
                                                <span class="dashicons dashicons-admin-page"></span>
                                                Copy
                                            </button>
                                        </div>
                                        <div class="code-box">
                                            <code id="modal-oxygen-class" class="css-class-display"></code>
                                        </div>
                                    </div>

                                    <div class="usage-guide">
                                        <h4>How to Use</h4>
                                        <div class="simple-steps">
                                            <div class="simple-step">
                                                <span class="step-number">1</span>
                                                <span class="step-text">Select element in Oxygen</span>
                                            </div>
                                            <div class="simple-step">
                                                <span class="step-number">2</span>
                                                <span class="step-text">Add CSS class above</span>
                                            </div>
                                            <div class="simple-step">
                                                <span class="step-number">3</span>
                                                <span class="step-text">Save & preview</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shortcode Tab -->
                            <div id="modal-shortcode-content" class="code-block">
                                <h3>WordPress Shortcode</h3>
                                <div class="code-section">
                                    <pre id="modal-shortcode-code" class="shortcode-display"></pre>
                                    <button class="copy-btn" data-target="modal-shortcode-code">Copy</button>
                                </div>

                                <h3>Available Parameters</h3>
                                <div id="modal-shortcode-params" class="parameters-list">
                                    <!-- Parameters will be populated here -->
                                </div>
                            </div>

                            <!-- CSS Tab -->
                            <pre id="modal-css-code" class="code-block"></pre>

                            <!-- HTML Tab -->
                            <pre id="modal-html-code" class="code-block"></pre>

                            <!-- JavaScript Tab -->
                            <div id="modal-js-content" class="code-block">
                                <h3>JavaScript Code</h3>
                                <div class="code-section">
                                    <pre id="modal-js-code" class="js-code-display"></pre>
                                    <button class="copy-btn" data-target="modal-js-code">Copy</button>
                                </div>

                                <h3>Custom Options Example</h3>
                                <div class="code-section">
                                    <pre id="modal-js-options" class="js-options-display"></pre>
                                    <button class="copy-btn" data-target="modal-js-options">Copy</button>
                                </div>
                            </div>
                        </div>
                        <button id="copy-code" class="button button-primary">
                            <?php _e('Copy to Clipboard', 'oxy-animation-pro'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Settings Modal -->
            <div id="settings-modal" class="oxy-modal">
                <div class="modal-content">
                    <span class="modal-close">&times;</span>
                    <h2>Effect Settings</h2>

                    <form id="effect-settings-form">
                        <div id="settings-fields"></div>

                        <div class="modal-actions">
                            <button type="button" class="button button-primary" id="generate-with-settings">
                                Generate Code with Settings
                            </button>
                            <button type="button" class="button modal-close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
        jQuery(document).ready(function($) {
            // Toggle Simple Animation section
            $('.section-header[data-toggle="collapse"]').on('click', function() {
                const $header = $(this);
                const $subFilters = $header.next('.sub-filters');

                // Toggle collapsed state
                $header.toggleClass('collapsed');
                $subFilters.toggleClass('collapsed');

                // Animate the toggle
                if ($subFilters.hasClass('collapsed')) {
                    $subFilters.slideUp(300);
                } else {
                    $subFilters.slideDown(300);
                }
            });

            // Sidebar filter functionality
            $('.filter-item').on('click', function() {
                const filterTag = $(this).data('tag');

                // Update active state
                $('.filter-item').removeClass('active');
                $(this).addClass('active');

                // Filter effects
                if (filterTag === 'all') {
                    $('.effect-card').show();
                } else {
                    $('.effect-card').hide();
                    $('.effect-card[data-tags*="' + filterTag + '"]').show();
                }

                // Update visible count
                updateVisibleCount();
            });

            // Search functionality
            $('#effects-search').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();

                if (searchTerm === '') {
                    // Show all cards matching current filter
                    const activeFilter = $('.filter-item.active').data('tag');
                    if (activeFilter === 'all') {
                        $('.effect-card').show();
                    } else {
                        $('.effect-card').hide();
                        $('.effect-card[data-tags*="' + activeFilter + '"]').show();
                    }
                } else {
                    // Search within current filter
                    const activeFilter = $('.filter-item.active').data('tag');
                    $('.effect-card').each(function() {
                        const name = $(this).data('name');
                        const tags = $(this).data('tags');
                        const matchesSearch = name.includes(searchTerm) || tags.includes(searchTerm);
                        const matchesFilter = activeFilter === 'all' || tags.includes(activeFilter);

                        $(this).toggle(matchesSearch && matchesFilter);
                    });
                }

                updateVisibleCount();
            });

            // Update visible count
            function updateVisibleCount() {
                const visibleCount = $('.effect-card:visible').length;
                $('#visible-count').text(visibleCount);
                $('.filter-item.active .count').text(visibleCount);
            }

            // Demo button functionality - play animation on preview element
            $(document).on('click', '.demo-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const $button = $(this);
                const animationClass = $button.data('class');
                const $card = $button.closest('.effect-card');
                const $previewEl = $card.find('.preview-element');

                console.log('Demo button clicked:', animationClass);

                if (!animationClass || !$previewEl.length) {
                    console.log('Missing animation class or preview element');
                    return;
                }

                // Remove animation class if it exists
                $previewEl.removeClass(animationClass + ' oxy-ani');

                // Force reflow
                $previewEl[0].offsetHeight;

                // Add animation classes directly
                $previewEl.addClass('oxy-ani ' + animationClass);

                console.log('Animation triggered with class:', animationClass);

                // Remove classes after animation
                setTimeout(() => {
                    $previewEl.removeClass(animationClass + ' oxy-ani');
                }, 2000);
            });

            // Copy class button
            $('.copy-class-btn').on('click', function(e) {
                e.preventDefault();
                const classText = $(this).data('class');

                // Create temporary textarea
                const $temp = $('<textarea>');
                $('body').append($temp);
                $temp.val(classText).select();
                document.execCommand('copy');
                $temp.remove();

                // Show feedback
                const originalText = $(this).html();
                $(this).html('<span class="dashicons dashicons-yes"></span>');
                setTimeout(() => {
                    $(this).html(originalText);
                }, 1000);
            });

            // Code button - open modal
            $('.code-btn').on('click', function(e) {
                e.preventDefault();
                const effect = $(this).data('effect');
                const cssClass = $(this).data('css-class');
                const category = $(this).data('category');

                // Update modal content
                $('#modal-title').text(effect.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()));
                $('#modal-subtitle').text('Configure animation settings and copy the code');
                $('#modal-oxygen-class').text(cssClass);

                // Load attribute controls via AJAX
                loadAttributeControls(category, effect, cssClass);

                // Show only relevant tabs
                $('.code-tab').hide();
                $('.code-tab[data-lang="settings"]').show(); // Always show Settings tab
                $('.code-tab[data-lang="oxygen"]').show(); // Always show Oxygen tab

                // For CSS animations, show CSS tab for advanced users
                if (cssClass.includes('oxy-ani-')) {
                    $('.code-tab[data-lang="css"]').show();
                }

                // Reset to Settings tab as default
                $('.code-tab').removeClass('active');
                $('.code-panel').removeClass('active').hide();
                $('.code-tab[data-lang="settings"]').addClass('active');
                $('#modal-settings-content').addClass('active').show();

                // Show modal with animation
                $('#code-modal').show();
            });

            // Close modal
            $('.modal-close').on('click', function() {
                $(this).closest('.oxy-anim-modal, .oxy-modal').hide();
            });

            // Code tabs
            $('.code-tab').on('click', function() {
                const lang = $(this).data('lang');

                // Update active tab
                $('.code-tab').removeClass('active');
                $(this).addClass('active');

                // Show corresponding content
                $('.code-panel, .code-block').removeClass('active').hide();
                $('#modal-' + lang + '-content').addClass('active').show();
            });

            // Close modal on overlay click
            $('.modal-overlay').on('click', function() {
                $('#code-modal').hide();
            });

            // Copy code button in modal
            $('.copy-btn').on('click', function(e) {
                e.preventDefault();
                const targetId = $(this).data('target');
                const $target = $('#' + targetId);
                const textToCopy = $target.text();

                // Create temporary textarea
                const $temp = $('<textarea>');
                $('body').append($temp);
                $temp.val(textToCopy).select();
                document.execCommand('copy');
                $temp.remove();

                // Show feedback
                $(this).text('Copied!').addClass('copied');
                setTimeout(() => {
                    $(this).text('Copy').removeClass('copied');
                }, 2000);
            });

            // Function to load attribute controls via AJAX
            function loadAttributeControls(category, effect, cssClass) {
                $.ajax({
                    url: oxyAnimAdmin.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'oxy_anim_get_effect_code',
                        nonce: oxyAnimAdmin.nonce,
                        category: category,
                        effect: effect
                    },
                    success: function(response) {
                        if (response.success && response.data.controls) {
                            $('#attribute-controls-container').html(response.data.controls);
                            $('#generated-css-output').text(cssClass);

                            // Bind change events to form controls
                            bindAttributeControls(cssClass);
                        } else {
                            $('#attribute-controls-container').html('<p>No configurable options for this animation.</p>');
                            $('#generated-css-output').text(cssClass);
                        }
                    },
                    error: function() {
                        $('#attribute-controls-container').html('<p>Error loading animation settings.</p>');
                        $('#generated-css-output').text(cssClass);
                    }
                });
            }

            // Function to bind attribute control events
            function bindAttributeControls(baseCssClass) {
                $(document).off('change', '.animation-settings-form select');
                $(document).on('change', '.animation-settings-form select', function() {
                    updateGeneratedCode(baseCssClass);
                });

                // Initial code generation
                updateGeneratedCode(baseCssClass);
            }

            // Function to update generated code based on form values
            function updateGeneratedCode(baseCssClass) {
                let generatedClass = baseCssClass;
                let attributes = [];

                $('.animation-settings-form select').each(function() {
                    const name = $(this).attr('name');
                    const value = $(this).val();

                    if (value && value !== '1s' && value !== '0s' && value !== '1' && value !== 'scroll') {
                        attributes.push(name + '="' + value + '"');
                    }
                });

                // Generate duration classes
                const duration = $('select[name="data-oxy-anim-duration"]').val();
                if (duration && duration !== '1s') {
                    if (duration === '0.5s') generatedClass += ' oxy-ani-faster';
                    else if (duration === '0.8s') generatedClass += ' oxy-ani-fast';
                    else if (duration === '2s') generatedClass += ' oxy-ani-slow';
                    else if (duration === '3s') generatedClass += ' oxy-ani-slower';
                }

                // Generate delay classes
                const delay = $('select[name="data-oxy-anim-delay"]').val();
                if (delay && delay !== '0s') {
                    generatedClass += ' oxy-ani-delay-' + delay.replace('s', '');
                }

                // Add attributes info if any
                if (attributes.length > 0) {
                    generatedClass += '\n\nAttributes to add:\n' + attributes.join('\n');
                }

                $('#generated-css-output').text(generatedClass);
            }
        });
        </script>
        <?php
    }
}
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
            <div class="showcase-header">
                <h1><span class="dashicons dashicons-video-alt3"></span>Animation Effects Library</h1>
                <p class="showcase-description">Complete collection of CSS animations from Animate.css library - all optimized for text, images, and sections</p>

                <!-- Stats Bar -->
                <div class="effects-stats">
                    <div class="stat-item">
                        <span class="stat-number"><?php echo count($effects['general']['effects']); ?></span>
                        <span class="stat-label">Total Effects</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">12</span>
                        <span class="stat-label">Categories</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">CSS Based</span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Search & Filter Bar -->
            <div class="effects-controls">
                <div class="search-section">
                    <div class="search-input-wrapper">
                        <span class="dashicons dashicons-search search-icon"></span>
                        <input type="text" id="effects-search" placeholder="Search effects by name or tag (e.g., 'bounce', 'fade', 'attention'...)">
                        <button id="clear-search" class="clear-btn">&times;</button>
                    </div>
                </div>

                <!-- Tag Filters -->
                <div class="tag-filters">
                    <label>Filter by type:</label>
                    <button class="tag-btn active" data-tag="all">All Effects</button>
                    <button class="tag-btn" data-tag="attention seekers">Attention</button>
                    <button class="tag-btn" data-tag="fading entrances">Fade</button>
                    <button class="tag-btn" data-tag="bouncing entrances">Bounce</button>
                    <button class="tag-btn" data-tag="zooming entrances">Zoom</button>
                    <button class="tag-btn" data-tag="sliding entrances">Slide</button>
                    <button class="tag-btn" data-tag="rotating entrances">Rotate</button>
                    <button class="tag-btn" data-tag="flippers">Flip</button>
                    <button class="tag-btn" data-tag="lightspeed">Speed</button>
                    <button class="tag-btn" data-tag="specials">Special</button>
                </div>
            </div>

            <!-- Effects Grid -->
            <div class="effects-grid">
                <?php
                $general = $effects['general'];
                $count = 0;
                ?>
                <div class="category-section" data-category="general">
                    <div class="category-header">
                        <h2 class="category-title">
                            <span class="<?php echo esc_attr($general['icon']); ?>"></span>
                            <?php echo esc_html($general['name']); ?>
                        </h2>
                        <div class="effects-count">
                            <span class="count-number" id="visible-count"><?php echo count($general['effects']); ?></span>
                            <span class="count-label">effects available</span>
                        </div>
                    </div>

                    <div class="effects-list">
                        <?php foreach ($general['effects'] as $effect_key => $effect):
                            $count++;
                        ?>
                            <div class="effect-card"
                                 data-effect="<?php echo esc_attr($effect_key); ?>"
                                 data-tags="<?php echo esc_attr(implode(' ', $effect['tags'])); ?>"
                                 data-name="<?php echo esc_attr(strtolower($effect['name'])); ?>">

                                <div class="effect-preview">
                                    <div class="preview-element <?php echo esc_attr($effect['class']); ?>" data-preview-text="<?php echo esc_attr($effect['name']); ?>">
                                        <span class="preview-text"><?php echo esc_html($effect['name']); ?></span>
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
                                        <span class="effect-number">#<?php echo $count; ?></span>
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
                                                data-category="general">
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
            </div>

            <!-- Code Modal (Using working Animation Preview structure) -->
            <div id="code-modal" class="oxy-anim-modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="modal-title"><?php _e('Effect Code', 'oxy-animation-pro'); ?></h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="code-tabs">
                            <button class="code-tab active" data-lang="oxygen">Oxygen Builder</button>
                            <button class="code-tab" data-lang="shortcode">Shortcode</button>
                            <button class="code-tab" data-lang="css">CSS</button>
                            <button class="code-tab" data-lang="html">HTML</button>
                            <button class="code-tab" data-lang="js">JavaScript</button>
                        </div>
                        <div class="code-content">
                            <!-- Oxygen Builder Tab -->
                            <div id="modal-oxygen-content" class="code-block active">
                                <h3>CSS Class</h3>
                                <div class="code-section">
                                    <code id="modal-oxygen-class" class="css-class-display"></code>
                                    <button class="copy-btn" data-target="modal-oxygen-class">Copy</button>
                                </div>

                                <h3>Custom Attributes</h3>
                                <div class="code-section">
                                    <pre id="modal-oxygen-attributes" class="attributes-display"></pre>
                                    <button class="copy-btn" data-target="modal-oxygen-attributes">Copy</button>
                                </div>

                                <h3>How to Use in Oxygen Builder</h3>
                                <div class="usage-instructions">
                                    <ol>
                                        <li>Select your element in Oxygen Builder</li>
                                        <li>Go to <strong>Advanced → CSS Classes</strong></li>
                                        <li>Add the CSS class shown above</li>
                                        <li>If attributes are needed, go to <strong>Advanced → Attributes</strong></li>
                                        <li>Click the <strong>+ Add Attribute</strong> button for each attribute</li>
                                        <li>Enter the attribute name (e.g., <code>data-duration</code>) in the <strong>Name</strong> field</li>
                                        <li>Enter the attribute value (e.g., <code>1</code>) in the <strong>Value</strong> field</li>
                                        <li>Repeat for each attribute shown above</li>
                                        <li>Save and preview your page</li>
                                    </ol>
                                    <p class="note"><strong>Note:</strong> Add attributes one by one. Don't copy the entire attribute string.</p>
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

        <style>
        .oxy-anim-showcase {
            max-width: 1400px;
            margin: 20px auto;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Header Styles */
        .showcase-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
        }

        .showcase-header h1 {
            margin: 0 0 15px 0;
            font-size: 2.5em;
            font-weight: 300;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .showcase-header .dashicons {
            font-size: 40px;
        }

        .showcase-description {
            font-size: 1.2em;
            margin: 0 0 30px 0;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Stats Bar */
        .effects-stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 30px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9em;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Controls */
        .effects-controls {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .search-section {
            margin-bottom: 20px;
        }

        .search-input-wrapper {
            position: relative;
            max-width: 600px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 18px;
        }

        .effects-controls input {
            width: 100%;
            padding: 15px 20px 15px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s;
            background: #f8f9fa;
        }

        .effects-controls input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .clear-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 24px;
            color: #999;
            cursor: pointer;
            display: none;
        }

        .clear-btn.active {
            display: block;
        }

        /* Tag Filters */
        .tag-filters {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .tag-filters label {
            font-weight: 600;
            color: #555;
            margin-right: 10px;
        }

        .tag-btn {
            padding: 8px 16px;
            background: #f1f3f4;
            border: 2px solid transparent;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 13px;
            font-weight: 500;
        }

        .tag-btn:hover {
            background: #e8eaed;
            transform: translateY(-1px);
        }

        .tag-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        /* Category Header */
        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .category-title {
            font-size: 1.8em;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #2c3e50;
        }

        .category-title .dashicons {
            color: #667eea;
            font-size: 32px;
        }

        .effects-count {
            text-align: right;
        }

        .count-number {
            display: block;
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
        }

        .count-label {
            font-size: 0.85em;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Effects Grid */
        .effects-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .effect-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .effect-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .effect-card.hidden {
            display: none;
        }

        /* Preview */
        .effect-preview {
            height: 180px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .preview-element {
            color: white;
            font-size: 18px;
            font-weight: 600;
            padding: 15px 25px;
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
        }

        .preview-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s;
        }

        .effect-card:hover .preview-overlay {
            opacity: 1;
        }

        .preview-btn {
            background: rgba(255,255,255,0.9);
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            color: #333;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .preview-btn:hover {
            background: white;
            transform: scale(1.05);
        }

        /* Effect Info */
        .effect-info {
            padding: 20px;
        }

        .effect-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .effect-title {
            margin: 0;
            font-size: 1.3em;
            color: #2c3e50;
            font-weight: 600;
        }

        .effect-number {
            background: #f1f3f4;
            color: #666;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 600;
        }

        .effect-description {
            margin: 0 0 15px 0;
            color: #555;
            font-size: 14px;
            line-height: 1.4;
        }

        /* Tags */
        .effect-tags {
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tag-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
            text-transform: lowercase;
            cursor: pointer;
            transition: all 0.2s;
        }

        .tag-badge:hover {
            transform: scale(1.05);
            opacity: 0.8;
        }

        /* Actions */
        .effect-actions {
            display: flex;
            gap: 8px;
        }

        .effect-actions .button {
            padding: 8px 12px;
            height: auto;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .effect-actions .button-primary {
            background: #667eea;
            border-color: #667eea;
            flex: 1;
        }

        .effect-actions .button-primary:hover {
            background: #5a67d8;
            border-color: #5a67d8;
            transform: translateY(-1px);
        }

        .effect-actions .button:not(.button-primary) {
            background: #f8f9fa;
            color: #555;
            border-color: #e1e5e9;
            min-width: 40px;
            justify-content: center;
        }

        .effect-actions .button:not(.button-primary):hover {
            background: #e9ecef;
            transform: translateY(-1px);
        }

        /* Modal Styles */
        .oxy-modal {
            display: none;
            position: fixed;
            z-index: 100000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
        }

        .oxy-modal.active {
            display: block;
        }

        .modal-content {
            background: white;
            margin: 50px auto;
            padding: 30px;
            width: 90%;
            max-width: 800px;
            border-radius: 8px;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
        }

        .modal-close {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 28px;
            cursor: pointer;
            color: #999;
        }

        .modal-close:hover {
            color: #333;
        }

        .code-tabs {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            border-bottom: 2px solid #ddd;
        }

        .code-tab {
            padding: 10px 20px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            transition: all 0.3s;
        }

        .code-tab:hover {
            background: #f5f5f5;
        }

        .code-tab.active {
            border-bottom-color: #007cba;
            color: #007cba;
            font-weight: bold;
        }

        .code-panel {
            display: none;
        }

        .code-panel.active {
            display: block;
        }

        .code-block {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin: 10px 0;
            position: relative;
        }

        .code-block code,
        .code-block pre {
            margin: 0;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }

        .copy-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            background: #007cba;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
        }

        .copy-btn:hover {
            background: #005a8a;
        }

        .copy-btn.copied {
            background: #28a745;
        }

        .usage-steps {
            background: #f9f9f9;
            border-left: 4px solid #007cba;
            padding: 15px 15px 15px 30px;
            margin: 20px 0;
        }

        .usage-steps li {
            margin: 8px 0;
        }

        /* Settings Form */
        .settings-field {
            margin-bottom: 15px;
        }

        .settings-field label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .settings-field input,
        .settings-field select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .modal-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        </style>
        <?php
    }
}
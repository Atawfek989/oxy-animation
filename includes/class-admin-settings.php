<?php
/**
 * Admin Settings Class
 * Handles plugin settings and configuration
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

class Oxy_Anim_Admin_Settings {

    private $settings_key = 'oxy_anim_settings';

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

        // Effects library AJAX handlers
        add_action('wp_ajax_oxy_anim_get_effects', array($this, 'ajax_get_effects'));
        add_action('wp_ajax_oxy_anim_get_effect_code', array($this, 'ajax_get_effect_code'));
    }

    public function add_admin_menu() {
        add_menu_page(
            __('Oxy Animation Pro', 'oxy-animation-pro'),
            __('Oxy Animation', 'oxy-animation-pro'),
            'manage_options',
            'oxy-animation-settings',
            array($this, 'render_settings_page'),
            'dashicons-video-alt3',
            85
        );

        add_submenu_page(
            'oxy-animation-settings',
            __('Effects Library', 'oxy-animation-pro'),
            __('Effects Library', 'oxy-animation-pro'),
            'manage_options',
            'oxy-animation-effects',
            array($this, 'render_effects_library_page')
        );

        add_submenu_page(
            'oxy-animation-settings',
            __('Credits', 'oxy-animation-pro'),
            __('Credits', 'oxy-animation-pro'),
            'manage_options',
            'oxy-animation-credits',
            array($this, 'render_credits_page')
        );
    }

    public function register_settings() {
        register_setting('oxy_anim_settings_group', $this->settings_key);

        add_settings_section(
            'oxy_anim_general_section',
            __('General Settings', 'oxy-animation-pro'),
            array($this, 'general_section_callback'),
            'oxy-animation-settings'
        );

        add_settings_field(
            'load_gsap',
            __('Load GSAP Library', 'oxy-animation-pro'),
            array($this, 'load_gsap_callback'),
            'oxy-animation-settings',
            'oxy_anim_general_section'
        );
    }

    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'oxy-animation') !== false) {
            wp_enqueue_style(
                'oxy-anim-admin',
                OXY_ANIM_PLUGIN_URL . 'assets/css/admin.css',
                array(),
                OXY_ANIM_VERSION
            );

            wp_enqueue_script(
                'oxy-anim-admin',
                OXY_ANIM_PLUGIN_URL . 'assets/js/admin.js',
                array('jquery'),
                OXY_ANIM_VERSION,
                true
            );

            wp_localize_script('oxy-anim-admin', 'oxyAnimAdmin', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('oxy_anim_admin_nonce'),
                'strings' => array(
                    'loading' => __('Loading...', 'oxy-animation-pro'),
                    'error' => __('An error occurred', 'oxy-animation-pro'),
                    'copied' => __('Copied to clipboard!', 'oxy-animation-pro')
                )
            ));
        }
    }

    public function render_settings_page() {
        $settings = get_option($this->settings_key, array());
        ?>
        <div class="wrap">
            <h1><?php _e('Oxy Animation Settings', 'oxy-animation-pro'); ?></h1>

            <form method="post" action="options.php">
                <?php
                settings_fields('oxy_anim_settings_group');
                do_settings_sections('oxy-animation-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function render_effects_library_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Animation Effects Library', 'oxy-animation-pro'); ?></h1>
            <p><?php _e('Effects library is ready for new animations to be added.', 'oxy-animation-pro'); ?></p>

            <!-- Effects Showcase will be loaded here -->
            <?php
            $showcase = new Oxy_Animation_Effects_Showcase();
            $showcase->render_showcase_page();
            ?>
        </div>
        <?php
    }

    public function render_credits_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Credits & About', 'oxy-animation-pro'); ?></h1>

            <div class="card">
                <h2><?php _e('Plugin Author', 'oxy-animation-pro'); ?></h2>
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <h3>Ahmed Tawfek</h3>
                        <p><?php _e('Professional web developer specializing in WordPress and Oxygen Builder development.', 'oxy-animation-pro'); ?></p>
                        <p><strong><?php _e('Website:', 'oxy-animation-pro'); ?></strong> <a href="https://ahmed-tawfek.com" target="_blank">ahmed-tawfek.com</a></p>
                        <p><strong><?php _e('Instagram:', 'oxy-animation-pro'); ?></strong> <a href="https://www.instagram.com/ahmedtawfek4/" target="_blank">@ahmedtawfek4</a></p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2><?php _e('About Oxy Animation Pro', 'oxy-animation-pro'); ?></h2>
                <p><?php _e('Advanced animation capabilities for Oxygen Builder with scroll-triggered animations, custom CSS animations, and JavaScript effects. Version', 'oxy-animation-pro'); ?> <?php echo OXY_ANIM_VERSION; ?></p>

                <h3><?php _e('Features:', 'oxy-animation-pro'); ?></h3>
                <ul>
                    <li><?php _e('70+ Animate.css based animations with oxy-ani- prefix', 'oxy-animation-pro'); ?></li>
                    <li><?php _e('Scroll-triggered animations using Intersection Observer', 'oxy-animation-pro'); ?></li>
                    <li><?php _e('Universal compatibility with text, images, and sections', 'oxy-animation-pro'); ?></li>
                    <li><?php _e('Performance-optimized animation system', 'oxy-animation-pro'); ?></li>
                    <li><?php _e('Easy-to-use class and attribute-based implementation', 'oxy-animation-pro'); ?></li>
                    <li><?php _e('GSAP integration support for advanced effects', 'oxy-animation-pro'); ?></li>
                </ul>
            </div>

            <div class="card">
                <h2><?php _e('Technologies Used', 'oxy-animation-pro'); ?></h2>
                <ul>
                    <li><strong>CSS3 Animations</strong> - Hardware-accelerated smooth effects</li>
                    <li><strong>Intersection Observer API</strong> - Efficient scroll detection</li>
                    <li><strong>ES6 JavaScript</strong> - Modern effects and interactions</li>
                    <li><strong>WordPress Plugin API</strong> - Seamless integration</li>
                    <li><strong>Oxygen Builder API</strong> - Deep builder integration</li>
                    <li><strong>GSAP (Optional)</strong> - Advanced animation library</li>
                </ul>
            </div>

            <div class="card">
                <h2><?php _e('Special Thanks', 'oxy-animation-pro'); ?></h2>
                <ul>
                    <li><?php _e('The WordPress community for their continuous support', 'oxy-animation-pro'); ?></li>
                    <li><?php _e('Oxygen Builder team for creating an amazing page builder', 'oxy-animation-pro'); ?></li>
                    <li><?php _e('Animate.css library for providing excellent animation presets', 'oxy-animation-pro'); ?></li>
                    <li><?php _e('All users who provide feedback and suggestions', 'oxy-animation-pro'); ?></li>
                </ul>
            </div>

            <div class="card">
                <h2><?php _e('License', 'oxy-animation-pro'); ?></h2>
                <p><?php _e('This plugin is released under the GNU General Public License v2 or later.', 'oxy-animation-pro'); ?></p>
                <p><small><?php _e('Copyright (c) 2025 Ahmed Tawfek. All rights reserved.', 'oxy-animation-pro'); ?></small></p>
            </div>

            <hr>
            <p style="text-align: center; font-style: italic; color: #666;">
                <?php _e('Developed with passion by Ahmed Tawfek', 'oxy-animation-pro'); ?> ❤️
            </p>
        </div>
        <?php
    }

    public function general_section_callback() {
        echo '<p>' . __('Configure general animation settings.', 'oxy-animation-pro') . '</p>';
    }

    public function load_gsap_callback() {
        $settings = get_option($this->settings_key, array());
        $value = isset($settings['load_gsap']) ? $settings['load_gsap'] : false;
        ?>
        <input type="checkbox" id="load_gsap" name="<?php echo $this->settings_key; ?>[load_gsap]" value="1" <?php checked(1, $value, true); ?> />
        <label for="load_gsap"><?php _e('Load GSAP library from CDN (required for GSAP effects)', 'oxy-animation-pro'); ?></label>
        <?php
    }

    public function ajax_get_effects() {
        check_ajax_referer('oxy_anim_admin_nonce', 'nonce');

        $registry = Oxy_Animation_Effects_Registry::get_instance();
        $effects = $registry->get_all_effects();

        wp_send_json_success($effects);
    }

    public function ajax_get_effect_code() {
        check_ajax_referer('oxy_anim_admin_nonce', 'nonce');

        $category = sanitize_text_field($_POST['category']);
        $effect = sanitize_text_field($_POST['effect']);

        $registry = Oxy_Animation_Effects_Registry::get_instance();
        $effect_data = $registry->get_effect($category, $effect);

        if (!$effect_data) {
            wp_send_json_error('Effect not found');
        }

        $code_data = array(
            'css_class' => $effect_data['class'],
            'attributes' => isset($effect_data['attributes']) ? $effect_data['attributes'] : array(),
            'oxygen' => $this->generate_oxygen_instructions($effect_data),
            'shortcode' => $this->generate_shortcode($effect_data),
            'css' => $this->generate_effect_css($effect_data),
            'html' => $this->generate_effect_html($effect_data),
            'javascript' => $this->generate_effect_js($effect_data)
        );

        wp_send_json_success($code_data);
    }

    private function generate_oxygen_instructions($effect_data) {
        $class = $effect_data['class'];
        $attributes = isset($effect_data['attributes']) ? $effect_data['attributes'] : array();

        $instructions = array(
            'class' => $class,
            'attributes' => $attributes,
            'steps' => array(
                __('Select your element in Oxygen Builder', 'oxy-animation-pro'),
                __('Go to Advanced → CSS Classes', 'oxy-animation-pro'),
                __('Add the CSS class: ' . $class, 'oxy-animation-pro')
            )
        );

        if (!empty($attributes)) {
            $instructions['steps'][] = __('Go to Advanced → Attributes', 'oxy-animation-pro');
            $instructions['steps'][] = __('Add custom attributes as shown above', 'oxy-animation-pro');
        }

        return $instructions;
    }

    private function generate_shortcode($effect_data) {
        $class = $effect_data['class'];
        $attributes = isset($effect_data['attributes']) ? $effect_data['attributes'] : array();

        $shortcode = '[oxy_anim class="' . $class . '"';

        foreach ($attributes as $key => $value) {
            $attr_name = str_replace('data-', '', $key);
            $shortcode .= ' ' . $attr_name . '="' . $value . '"';
        }

        $shortcode .= ']Your content here[/oxy_anim]';

        return $shortcode;
    }

    private function generate_effect_css($effect_data) {
        $class = $effect_data['class'];
        $name = $effect_data['name'];

        return "/* {$name} - Copy this CSS to your stylesheet */\n" .
               ".{$class} {\n" .
               "    animation-name: " . str_replace('oxy-ani-', 'oxy-', $class) . ";\n" .
               "    animation-duration: 1s;\n" .
               "    animation-fill-mode: both;\n" .
               "}\n\n" .
               "/* Add base animation class */\n" .
               ".oxy-ani {\n" .
               "    animation-duration: 1s;\n" .
               "    animation-fill-mode: both;\n" .
               "}\n\n" .
               "/* Scroll-triggered version */\n" .
               ".{$class}.oxy-ani-on-scroll {\n" .
               "    opacity: 0;\n" .
               "}\n\n" .
               ".{$class}.oxy-ani-on-scroll.oxy-ani-triggered {\n" .
               "    opacity: 1;\n" .
               "}";
    }

    private function generate_effect_html($effect_data) {
        $class = $effect_data['class'];
        $attributes = isset($effect_data['attributes']) ? $effect_data['attributes'] : array();

        $html = '<div class="' . $class . '"';

        foreach ($attributes as $key => $value) {
            $html .= ' ' . $key . '="' . esc_attr($value) . '"';
        }

        $html .= '>' . "\n";
        $html .= '    Your content here' . "\n";
        $html .= '</div>';

        return $html;
    }

    private function generate_effect_js($effect_data) {
        $class = $effect_data['class'];
        $name = $effect_data['name'];

        return "// {$name} - Pure CSS Animation with JavaScript triggers\n" .
               "// The animation is handled by CSS. Use these JavaScript methods for control:\n\n" .
               "// Method 1: Auto-trigger on scroll (recommended)\n" .
               "// Just add the 'oxy-ani-on-scroll' class to your element\n" .
               "document.querySelectorAll('.{$class}').forEach(el => {\n" .
               "    el.classList.add('oxy-ani-on-scroll');\n" .
               "});\n\n" .
               "// Method 2: Manual trigger with JavaScript\n" .
               "// Trigger animation immediately\n" .
               "function trigger" . str_replace(array('oxy-ani-', '-'), array('', ''), ucwords($class, '-')) . "() {\n" .
               "    document.querySelectorAll('.{$class}').forEach(el => {\n" .
               "        el.classList.add('oxy-ani-triggered');\n" .
               "    });\n" .
               "}\n\n" .
               "// Method 3: Using the global OxyAnim utility\n" .
               "// OxyAnim.trigger('.{$class}'); // Trigger animation\n" .
               "// OxyAnim.reset('.{$class}');   // Reset animation\n\n" .
               "// Method 4: Advanced usage with options\n" .
               "// OxyAnim.animate('.my-element', '{$class}', {\n" .
               "//     duration: 'slow',    // slow, fast, faster, slower\n" .
               "//     delay: '1s',         // 1s, 2s, 3s, 4s, 5s\n" .
               "//     repeat: '2'          // 1, 2, 3, infinite\n" .
               "// });";
    }
}
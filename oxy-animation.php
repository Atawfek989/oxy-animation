<?php
/**
 * Plugin Name: Oxy Animation
 * Plugin URI: https://ahmed-tawfek.com
 * Description: Advanced animation capabilities for Oxygen Builder with scroll-triggered animations, custom CSS animations, and JavaScript effects
 * Version: 2.1.0
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
define('OXY_ANIM_VERSION', '2.1.0');
define('OXY_ANIM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('OXY_ANIM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('OXY_ANIM_PLUGIN_FILE', __FILE__);

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
    // Load only essential files for plugin structure
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-animation-loader.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-admin-settings.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-oxygen-integration.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-effects-registry.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-effects-showcase.php';
    require_once OXY_ANIM_PLUGIN_PATH . 'includes/class-shortcodes.php';

    // Initialize only essential classes
    new Oxy_Anim_Loader();
    new Oxy_Anim_Admin_Settings();
    new Oxy_Anim_Oxygen_Integration();

    // Initialize registry and shortcodes (empty but ready)
    Oxy_Animation_Effects_Registry::get_instance();
    new Oxy_Animation_Shortcodes();
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

// Deactivation hook
register_deactivation_hook(__FILE__, 'oxy_anim_deactivate');
function oxy_anim_deactivate() {
    // Clean up if needed
}
=== Oxy Animation ===
Contributors: ahmedtawfek
Tags: oxygen, animation, effects, scroll, css, javascript
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Author: Ahmed Tawfek
Author URI: https://ahmed-tawfek.com

Advanced animation capabilities for Oxygen Builder with scroll-triggered animations, custom CSS animations, JavaScript effects, and professional GSAP integrations.

Copyright (c) 2025 Ahmed Tawfek
Website: https://ahmed-tawfek.com
Instagram: https://www.instagram.com/ahmedtawfek4/

== Description ==

Oxy Animation is the most comprehensive animation plugin for Oxygen Builder, enabling you to create stunning animated websites with professional-grade effects. This plugin provides:

**🎬 Scroll-Triggered Animations**
* 25+ built-in scroll animations (fade, slide, zoom, etc.)
* Intersection Observer API for performance
* Customizable trigger points and offsets
* Staggered animations for child elements
* Advanced parallax effects

**🎨 CSS Animation Presets**
* 30+ pre-built CSS animations
* Custom animation builder
* Keyframe editor
* Animation timing controls
* Mobile-responsive animations

**⚡ JavaScript Effects**
* Typewriter text effect
* Count-up numbers
* 3D tilt effects
* Ripple animations
* Magnetic hover effects
* Text scramble effects
* Particle animations

**🚀 Professional GSAP Integration**
* 50+ Advanced GSAP effects
* Cursor followers and custom cursors
* Draggable elements with physics
* Interactive dial controls and spin wheels
* 3D card flips and carousels
* Particle explosion systems
* Liquid distortion effects
* SVG morphing animations
* Timeline builder with controls
* Physics-based animations (bounce, pendulum, elastic)
* Scroll-controlled video playback
* Before/after image sliders

**🔧 Oxygen Builder Integration**
* Visual animation controls in builder
* Live preview functionality
* Animation library browser
* Quick animation toolbar
* Real-time editing

**📱 Performance Optimized**
* Intersection Observer for scroll animations
* GPU acceleration when possible
* Reduced motion support
* Performance monitoring
* Mobile optimization

**🎯 Easy Class & Attribute Usage**
* Add animations with simple class names (fadeIn, bounce, pulse)
* GSAP effects with class names (gsap-fade-in, gsap-bounce-in, gsap-parallax-slow)
* Use custom attributes (anim="fadeIn", scroll="slideUp")
* Advanced GSAP attributes (data-gsap-effect="gsap-cursor-follower")
* Auto-detection system
* No configuration required

**🎮 Interactive Elements**
* Draggable cards and sliders
* Cursor followers and trails
* Dial controls and spin wheels
* Physics simulations
* Particle systems
* 3D transformations

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/oxy-animation/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Make sure Oxygen Builder is installed and activated
4. Navigate to 'Oxy Animation' in your WordPress admin to configure settings

== Quick Start ==

**Method 1: CSS Classes**
Add these class names in Oxygen Builder's "Class" field:

*Basic Animations:*
* `fadeIn` - Fade in animation
* `bounce` - Bouncing effect
* `scroll-fadeInUp` - Fade in up on scroll
* `effect-typewriter` - Typewriter text effect

*GSAP Effects:*
* `gsap-fade-in` - GSAP fade animation
* `gsap-slide-up` - Smooth slide up effect
* `gsap-bounce-in` - Bounce in with physics
* `gsap-cursor-follower` - Custom cursor follower
* `gsap-draggable` - Make element draggable
* `gsap-3d-card-wrapper` - 3D flip card effect
* `gsap-parallax-slow` - Smooth parallax scrolling
* `gsap-particle-system` - Particle effects
* `gsap-dial-control` - Interactive dial control

**Method 2: Attributes**
Add custom attributes in Oxygen Builder's "Attributes" section:

*Basic Effects:*
* Attribute: `anim` Value: `fadeIn`
* Attribute: `scroll` Value: `slideInUp`
* Attribute: `effect` Value: `typewriter`
* Attribute: `duration` Value: `2s`
* Attribute: `trigger` Value: `hover`

*GSAP Effects:*
* Attribute: `data-gsap-effect` Value: `gsap-bounce-in`
* Attribute: `data-cursor-type` Value: `magnetic`
* Attribute: `data-drag-type` Value: `rotation`
* Attribute: `data-particle-count` Value: `50`

**Method 3: GSAP Shortcodes**
Use these shortcodes for advanced effects:

*Cursor Effects:*
`[oxy_cursor type="follower" color="#ff0000" size="30"]`

*Draggable Elements:*
`[oxy_draggable type="free" axis="both" inertia="true"]Your content[/oxy_draggable]`

*Interactive Controls:*
`[oxy_dial min="0" max="100" value="50" color="#007cba"]`

*3D Effects:*
`[oxy_3d_card width="300" height="400" flip="hover"]Card content[/oxy_3d_card]`

*Particle Systems:*
`[oxy_particle_system type="confetti" count="100"]`

*Physics Animations:*
`[oxy_physics gravity="1" bounce="0.8"]Physics content[/oxy_physics]`

== Features ==

**Scroll Animations:**
* fadeIn, fadeInUp, fadeInDown, fadeInLeft, fadeInRight
* zoomIn, zoomInRotate
* slideInLeft, slideInRight, slideInUp, slideInDown
* flipIn, blurIn, expandIn
* parallaxUp

**CSS Animations:**
* Entrance: fadeIn, slideIn variations, zoomIn, rotateIn
* Emphasis: bounce, shake, pulse, heartbeat, rubberBand
* Attention: swing, tada, wobble, jello
* Special: glitch, floating

**JavaScript Effects:**
* typewriter - Animated typing effect
* countUp - Animated number counting
* splitText - Letter/word reveal animations
* tiltEffect - 3D perspective tilt
* rippleEffect - Click ripple animation
* magneticHover - Magnetic cursor attraction
* parallaxElement - Smooth parallax scrolling
* textScramble - Matrix-style text reveal
* glowPulse - Glowing animation
* cursorFollow - Element follows cursor

**GSAP Advanced Effects:**

*Cursor Effects:*
* gsap-cursor-follower - Custom cursor with smooth animation
* gsap-cursor-magnetic - Elements attract to cursor
* gsap-cursor-trail - Trail following cursor
* gsap-cursor-glow - Glowing cursor effect

*Draggable Elements:*
* gsap-draggable - Make any element draggable
* gsap-draggable-cards - Tinder-style card stack
* gsap-drag-rotate - Rotate by dragging
* gsap-throwable - Physics-based throwing

*Interactive Controls:*
* gsap-dial-control - Volume knob style controls
* gsap-circular-menu - Rotating navigation menu
* gsap-spin-wheel - Lucky wheel with momentum
* gsap-before-after - Image comparison slider

*Physics Animations:*
* gsap-bounce-physics - Realistic gravity effects
* gsap-pendulum - Swinging motion
* gsap-elastic-band - Stretchy connections

*3D Effects:*
* gsap-3d-card - Interactive flip cards
* gsap-3d-carousel - Circular 3D carousel
* gsap-3d-cube - Rotating cube animations

*Particle Systems:*
* gsap-particle-explosion - Burst effects
* gsap-confetti - Celebration animations
* gsap-particle-trail - Following particles

*Morphing & Distortion:*
* gsap-blob-morph - Organic shape animations
* gsap-liquid-distortion - WebGL distortions
* gsap-water-ripple - Realistic ripples
* gsap-shape-shifter - Morphing shapes

*Text Effects:*
* gsap-text-3d - 3D rotating text
* gsap-text-glitch - Cyberpunk effects
* gsap-text-wave - Wave motion text
* gsap-text-scramble - Matrix-style reveals

*Scroll Effects:*
* gsap-scroll-video - Video controlled by scroll
* gsap-parallax-zoom - Zoom on scroll
* gsap-pin-section - Pin elements during scroll

**Triggers:**
* On Load - Animation starts when page loads
* On Scroll - Animation triggers when element enters viewport
* On Hover - Animation starts on mouse hover
* On Click - Animation starts when clicked

== Usage ==

**In Oxygen Builder:**

1. Select any element in Oxygen Builder
2. Add animation class name or attribute
3. Animation works automatically
4. Publish your changes

**Using Classes:**

Fade In Animation:
```
Class: fadeIn
```

Scroll Animation:
```
Class: scroll-fadeInUp
```

JavaScript Effect:
```
Class: effect-typewriter
```

**Using Attributes:**

CSS Animation:
```
Attribute: anim
Value: fadeIn
```

Scroll Animation:
```
Attribute: scroll
Value: slideInUp
```

With Custom Timing:
```
Attribute: anim
Value: bounce

Attribute: duration
Value: 2s

Attribute: trigger
Value: hover
```

**Using Shortcodes:**

Scroll Animation:
```
[oxy_scroll_anim animation="fadeInUp" duration="1000" delay="200"]
Your content here
[/oxy_scroll_anim]
```

CSS Animation:
```
[oxy_css_anim animation="bounce" duration="1s" iteration="infinite"]
Bouncing element
[/oxy_css_anim]
```

JavaScript Effect:
```
[oxy_js_effect effect="typewriter" params='{"speed":50,"cursor":true}']
This text will be typed out
[/oxy_js_effect]
```

== Settings ==

Navigate to **Oxy Animation > Settings** to configure:

* Enable/disable scroll animations
* Enable/disable CSS presets
* Enable/disable JavaScript effects
* **Load GSAP library** - Enable for advanced effects
* **Load GSAP plugins** - Enable Draggable, Inertia, and other plugins
* Performance mode (Performance/Balanced/Quality)

**GSAP Settings:**
To use advanced GSAP effects, enable "Load GSAP Library" in settings. This loads:
* GSAP core library (v3.12.2)
* ScrollTrigger plugin
* Optional: Draggable and InertiaPlugin

No GSAP license required for most effects. Some premium features require GSAP Club membership.

== Animation Library ==

Access the animation library at **Oxy Animation > Preview** to:

* Browse all available animations with live previews
* **GSAP Effects Library** - Preview all advanced GSAP effects
* View CSS, HTML, JS, and Shortcode examples
* Test custom animation combinations
* Copy code snippets for Oxygen Builder
* Build custom animations
* Interactive GSAP component builder

== Performance ==

The plugin is optimized for performance:

* Uses Intersection Observer API for scroll detection
* Animations only run when elements are visible
* GPU acceleration when supported
* Respects user's reduced motion preferences
* Lazy loading of animation resources

== Browser Support ==

* Chrome 51+
* Firefox 55+
* Safari 12+
* Edge 15+
* Internet Explorer 11 (limited support)

== Frequently Asked Questions ==

= Does this work without Oxygen Builder? =

While some features work independently, this plugin is specifically designed for Oxygen Builder integration. Full functionality requires Oxygen Builder.

= Can I create custom animations? =

Yes! You can create custom CSS animations and JavaScript effects through the admin interface or by adding your own code.

= Does this affect page load speed? =

The plugin is optimized for performance. CSS animations are lightweight, and JavaScript effects only load when needed. You can also choose performance mode for maximum speed.

= Are animations mobile-friendly? =

Yes, all animations are responsive and work on mobile devices. You can also disable specific animations on mobile if needed.

= Can I use GSAP with this plugin? =

Yes! The plugin can optionally load GSAP and ScrollTrigger for advanced animations.

= How do I add a simple fade in animation? =

Just add `fadeIn` as a class name in Oxygen Builder, or add attribute `anim` with value `fadeIn`. The animation will work automatically.

== Screenshots ==

1. Animation controls in Oxygen Builder
2. Animation library with live previews
3. Settings page configuration
4. Custom animation builder
5. Live animation preview with code generation

== Changelog ==

= 1.0.0 =
* Initial release
* 15 scroll-triggered animations
* 20+ CSS animation presets
* 15 JavaScript effects
* Full Oxygen Builder integration
* Animation library and preset system
* Auto-detection of classes and attributes
* Performance optimization
* Mobile responsiveness

== Upgrade Notice ==

= 1.0.0 =
Initial release of Oxy Animation. Adds powerful animation capabilities to Oxygen Builder with simple class and attribute usage.

== Developer Notes ==

**Hooks and Filters:**

```php
// Add custom animation
add_filter('oxy_anim_css_animations', function($animations) {
    $animations['myCustomAnim'] = 'My Custom Animation';
    return $animations;
});

// Modify animation config
add_filter('oxy_anim_scroll_config', function($config) {
    $config['rootMargin'] = '0px 0px -100px 0px';
    return $config;
});
```

**JavaScript API:**

```javascript
// Register custom effect
window.oxyEffects.register('myEffect', function(element, params) {
    // Your custom effect code
});

// Apply animation programmatically
window.oxyAnimation.utils.addClass('.my-element', 'oxy-anim-fadeIn');

// Refresh animations after AJAX
window.oxyRefreshScrollAnimations();
```

== Credits ==

**Developed by Ahmed Tawfek**
* Website: https://ahmed-tawfek.com
* Instagram: https://www.instagram.com/ahmedtawfek4/

Built with modern web technologies:
* Intersection Observer API
* CSS3 Animations
* ES6 JavaScript
* WordPress Plugin API
* Oxygen Builder API

== Copyright ==

Copyright (c) 2024 Ahmed Tawfek. All rights reserved.

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
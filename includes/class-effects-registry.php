<?php
/**
 * Effects Registry
 * Central registry for all animation effects in the plugin
 *
 * @package    Oxy_Animation
 * @author     Ahmed Tawfek
 */

if (!defined('ABSPATH')) {
    exit;
}

class Oxy_Animation_Effects_Registry {

    private static $instance = null;
    private $effects = array();

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->register_all_effects();
    }

    private function get_standard_attributes() {
        return array(
            'data-oxy-anim-duration' => array(
                'label' => 'Duration',
                'type' => 'select',
                'options' => array(
                    '1s' => 'Normal (1s)',
                    '0.5s' => 'Faster (0.5s)',
                    '0.8s' => 'Fast (0.8s)',
                    '2s' => 'Slow (2s)',
                    '3s' => 'Slower (3s)'
                ),
                'default' => '1s'
            ),
            'data-oxy-anim-delay' => array(
                'label' => 'Delay',
                'type' => 'select',
                'options' => array(
                    '0s' => 'No Delay',
                    '0.5s' => '0.5 seconds',
                    '1s' => '1 second',
                    '2s' => '2 seconds',
                    '3s' => '3 seconds'
                ),
                'default' => '0s'
            ),
            'data-oxy-anim-repeat' => array(
                'label' => 'Repeat',
                'type' => 'select',
                'options' => array(
                    '1' => 'Once',
                    '2' => 'Twice',
                    '3' => '3 times',
                    'infinite' => 'Infinite'
                ),
                'default' => '1'
            ),
            'data-oxy-anim-trigger' => array(
                'label' => 'Trigger',
                'type' => 'select',
                'options' => array(
                    'scroll' => 'On Scroll',
                    'hover' => 'On Hover',
                    'click' => 'On Click',
                    'load' => 'On Page Load'
                ),
                'default' => 'scroll'
            )
        );
    }

    private function register_all_effects() {
        $standard_attributes = $this->get_standard_attributes();

        // GENERAL EFFECTS - All Animate.css animations in one tab
        $this->effects['general'] = array(
            'name' => 'General Effects',
            'icon' => 'dashicons-video-alt3',
            'description' => 'Complete collection of CSS animations from Animate.css library',
            'effects' => array(
                // Attention Seekers
                'bounce' => array(
                    'name' => 'Bounce',
                    'class' => 'oxy-ani-bounce',
                    'preview' => 'Element bounces up and down',
                    'tags' => array('attention seekers', 'fun', 'playful'),
                    'attributes' => $standard_attributes
                ),
                'flash' => array(
                    'name' => 'Flash',
                    'class' => 'oxy-ani-flash',
                    'preview' => 'Element flashes in and out',
                    'tags' => array('attention seekers', 'emphasis', 'alert'),
                    'attributes' => $standard_attributes
                ),
                'pulse' => array(
                    'name' => 'Pulse',
                    'class' => 'oxy-ani-pulse',
                    'preview' => 'Element pulses with scale effect',
                    'tags' => array('attention seekers', 'heartbeat', 'emphasis'),
                    'attributes' => $standard_attributes
                ),
                'rubber-band' => array(
                    'name' => 'Rubber Band',
                    'class' => 'oxy-ani-rubberBand',
                    'preview' => 'Element stretches like rubber band',
                    'tags' => array('attention seekers', 'elastic', 'fun'),
                    'attributes' => $standard_attributes
                ),
                'shake-x' => array(
                    'name' => 'Shake X',
                    'class' => 'oxy-ani-shakeX',
                    'preview' => 'Element shakes horizontally',
                    'tags' => array('attention seekers', 'error', 'alert')
                ),
                'shake-y' => array(
                    'name' => 'Shake Y',
                    'class' => 'oxy-ani-shakeY',
                    'preview' => 'Element shakes vertically',
                    'tags' => array('attention seekers', 'vibration', 'alert')
                ),
                'head-shake' => array(
                    'name' => 'Head Shake',
                    'class' => 'oxy-ani-headShake',
                    'preview' => 'Element shakes like saying no',
                    'tags' => array('attention seekers', 'rejection', 'human-like')
                ),
                'swing' => array(
                    'name' => 'Swing',
                    'class' => 'oxy-ani-swing',
                    'preview' => 'Element swings back and forth',
                    'tags' => array('attention seekers', 'pendulum', 'gentle')
                ),
                'tada' => array(
                    'name' => 'Tada',
                    'class' => 'oxy-ani-tada',
                    'preview' => 'Element celebrates with tada effect',
                    'tags' => array('attention seekers', 'celebration', 'success')
                ),
                'wobble' => array(
                    'name' => 'Wobble',
                    'class' => 'oxy-ani-wobble',
                    'preview' => 'Element wobbles side to side',
                    'tags' => array('attention seekers', 'unstable', 'fun')
                ),
                'jello' => array(
                    'name' => 'Jello',
                    'class' => 'oxy-ani-jello',
                    'preview' => 'Element jiggles like jello',
                    'tags' => array('attention seekers', 'elastic', 'playful')
                ),
                'heart-beat' => array(
                    'name' => 'Heart Beat',
                    'class' => 'oxy-ani-heartBeat',
                    'preview' => 'Element beats like a heart',
                    'tags' => array('attention seekers', 'love', 'pulse')
                ),

                // Back Entrances
                'back-in-down' => array(
                    'name' => 'Back In Down',
                    'class' => 'oxy-ani-backInDown',
                    'preview' => 'Element enters from top with back motion',
                    'tags' => array('back entrances', 'directional', 'smooth')
                ),
                'back-in-left' => array(
                    'name' => 'Back In Left',
                    'class' => 'oxy-ani-backInLeft',
                    'preview' => 'Element enters from left with back motion',
                    'tags' => array('back entrances', 'directional', 'smooth')
                ),
                'back-in-right' => array(
                    'name' => 'Back In Right',
                    'class' => 'oxy-ani-backInRight',
                    'preview' => 'Element enters from right with back motion',
                    'tags' => array('back entrances', 'directional', 'smooth')
                ),
                'back-in-up' => array(
                    'name' => 'Back In Up',
                    'class' => 'oxy-ani-backInUp',
                    'preview' => 'Element enters from bottom with back motion',
                    'tags' => array('back entrances', 'directional', 'smooth')
                ),

                // Back Exits
                'back-out-down' => array(
                    'name' => 'Back Out Down',
                    'class' => 'oxy-ani-backOutDown',
                    'preview' => 'Element exits to bottom with back motion',
                    'tags' => array('back exits', 'directional', 'smooth')
                ),
                'back-out-left' => array(
                    'name' => 'Back Out Left',
                    'class' => 'oxy-ani-backOutLeft',
                    'preview' => 'Element exits to left with back motion',
                    'tags' => array('back exits', 'directional', 'smooth')
                ),
                'back-out-right' => array(
                    'name' => 'Back Out Right',
                    'class' => 'oxy-ani-backOutRight',
                    'preview' => 'Element exits to right with back motion',
                    'tags' => array('back exits', 'directional', 'smooth')
                ),
                'back-out-up' => array(
                    'name' => 'Back Out Up',
                    'class' => 'oxy-ani-backOutUp',
                    'preview' => 'Element exits to top with back motion',
                    'tags' => array('back exits', 'directional', 'smooth')
                ),

                // Bouncing Entrances
                'bounce-in' => array(
                    'name' => 'Bounce In',
                    'class' => 'oxy-ani-bounceIn',
                    'preview' => 'Element bounces into view',
                    'tags' => array('bouncing entrances', 'playful', 'elastic'),
                    'attributes' => $standard_attributes
                ),
                'bounce-in-down' => array(
                    'name' => 'Bounce In Down',
                    'class' => 'oxy-ani-bounceInDown',
                    'preview' => 'Element bounces in from top',
                    'tags' => array('bouncing entrances', 'directional', 'playful')
                ),
                'bounce-in-left' => array(
                    'name' => 'Bounce In Left',
                    'class' => 'oxy-ani-bounceInLeft',
                    'preview' => 'Element bounces in from left',
                    'tags' => array('bouncing entrances', 'directional', 'playful')
                ),
                'bounce-in-right' => array(
                    'name' => 'Bounce In Right',
                    'class' => 'oxy-ani-bounceInRight',
                    'preview' => 'Element bounces in from right',
                    'tags' => array('bouncing entrances', 'directional', 'playful')
                ),
                'bounce-in-up' => array(
                    'name' => 'Bounce In Up',
                    'class' => 'oxy-ani-bounceInUp',
                    'preview' => 'Element bounces in from bottom',
                    'tags' => array('bouncing entrances', 'directional', 'playful')
                ),

                // Bouncing Exits
                'bounce-out' => array(
                    'name' => 'Bounce Out',
                    'class' => 'oxy-ani-bounceOut',
                    'preview' => 'Element bounces out of view',
                    'tags' => array('bouncing exits', 'playful', 'elastic')
                ),
                'bounce-out-down' => array(
                    'name' => 'Bounce Out Down',
                    'class' => 'oxy-ani-bounceOutDown',
                    'preview' => 'Element bounces out to bottom',
                    'tags' => array('bouncing exits', 'directional', 'playful')
                ),
                'bounce-out-left' => array(
                    'name' => 'Bounce Out Left',
                    'class' => 'oxy-ani-bounceOutLeft',
                    'preview' => 'Element bounces out to left',
                    'tags' => array('bouncing exits', 'directional', 'playful')
                ),
                'bounce-out-right' => array(
                    'name' => 'Bounce Out Right',
                    'class' => 'oxy-ani-bounceOutRight',
                    'preview' => 'Element bounces out to right',
                    'tags' => array('bouncing exits', 'directional', 'playful')
                ),
                'bounce-out-up' => array(
                    'name' => 'Bounce Out Up',
                    'class' => 'oxy-ani-bounceOutUp',
                    'preview' => 'Element bounces out to top',
                    'tags' => array('bouncing exits', 'directional', 'playful')
                ),

                // Fading Entrances
                'fade-in' => array(
                    'name' => 'Fade In',
                    'class' => 'oxy-ani-fadeIn',
                    'preview' => 'Element fades in smoothly',
                    'tags' => array('fading entrances', 'basic', 'smooth'),
                    'attributes' => $standard_attributes
                ),
                'fade-in-down' => array(
                    'name' => 'Fade In Down',
                    'class' => 'oxy-ani-fadeInDown',
                    'preview' => 'Element fades in from top',
                    'tags' => array('fading entrances', 'directional', 'smooth'),
                    'attributes' => $standard_attributes
                ),
                'fade-in-down-big' => array(
                    'name' => 'Fade In Down Big',
                    'class' => 'oxy-ani-fadeInDownBig',
                    'preview' => 'Element fades in from far top',
                    'tags' => array('fading entrances', 'directional', 'dramatic')
                ),
                'fade-in-left' => array(
                    'name' => 'Fade In Left',
                    'class' => 'oxy-ani-fadeInLeft',
                    'preview' => 'Element fades in from left',
                    'tags' => array('fading entrances', 'directional', 'smooth'),
                    'attributes' => $standard_attributes
                ),
                'fade-in-left-big' => array(
                    'name' => 'Fade In Left Big',
                    'class' => 'oxy-ani-fadeInLeftBig',
                    'preview' => 'Element fades in from far left',
                    'tags' => array('fading entrances', 'directional', 'dramatic')
                ),
                'fade-in-right' => array(
                    'name' => 'Fade In Right',
                    'class' => 'oxy-ani-fadeInRight',
                    'preview' => 'Element fades in from right',
                    'tags' => array('fading entrances', 'directional', 'smooth'),
                    'attributes' => $standard_attributes
                ),
                'fade-in-right-big' => array(
                    'name' => 'Fade In Right Big',
                    'class' => 'oxy-ani-fadeInRightBig',
                    'preview' => 'Element fades in from far right',
                    'tags' => array('fading entrances', 'directional', 'dramatic')
                ),
                'fade-in-up' => array(
                    'name' => 'Fade In Up',
                    'class' => 'oxy-ani-fadeInUp',
                    'preview' => 'Element fades in from bottom',
                    'tags' => array('fading entrances', 'directional', 'smooth'),
                    'attributes' => $standard_attributes
                ),
                'fade-in-up-big' => array(
                    'name' => 'Fade In Up Big',
                    'class' => 'oxy-ani-fadeInUpBig',
                    'preview' => 'Element fades in from far bottom',
                    'tags' => array('fading entrances', 'directional', 'dramatic')
                ),
                'fade-in-top-left' => array(
                    'name' => 'Fade In Top Left',
                    'class' => 'oxy-ani-fadeInTopLeft',
                    'preview' => 'Element fades in from top-left corner',
                    'tags' => array('fading entrances', 'corner', 'diagonal')
                ),
                'fade-in-top-right' => array(
                    'name' => 'Fade In Top Right',
                    'class' => 'oxy-ani-fadeInTopRight',
                    'preview' => 'Element fades in from top-right corner',
                    'tags' => array('fading entrances', 'corner', 'diagonal')
                ),
                'fade-in-bottom-left' => array(
                    'name' => 'Fade In Bottom Left',
                    'class' => 'oxy-ani-fadeInBottomLeft',
                    'preview' => 'Element fades in from bottom-left corner',
                    'tags' => array('fading entrances', 'corner', 'diagonal')
                ),
                'fade-in-bottom-right' => array(
                    'name' => 'Fade In Bottom Right',
                    'class' => 'oxy-ani-fadeInBottomRight',
                    'preview' => 'Element fades in from bottom-right corner',
                    'tags' => array('fading entrances', 'corner', 'diagonal')
                ),

                // Fading Exits
                'fade-out' => array(
                    'name' => 'Fade Out',
                    'class' => 'oxy-ani-fadeOut',
                    'preview' => 'Element fades out smoothly',
                    'tags' => array('fading exits', 'basic', 'smooth')
                ),
                'fade-out-down' => array(
                    'name' => 'Fade Out Down',
                    'class' => 'oxy-ani-fadeOutDown',
                    'preview' => 'Element fades out to bottom',
                    'tags' => array('fading exits', 'directional', 'smooth')
                ),
                'fade-out-down-big' => array(
                    'name' => 'Fade Out Down Big',
                    'class' => 'oxy-ani-fadeOutDownBig',
                    'preview' => 'Element fades out to far bottom',
                    'tags' => array('fading exits', 'directional', 'dramatic')
                ),
                'fade-out-left' => array(
                    'name' => 'Fade Out Left',
                    'class' => 'oxy-ani-fadeOutLeft',
                    'preview' => 'Element fades out to left',
                    'tags' => array('fading exits', 'directional', 'smooth')
                ),
                'fade-out-left-big' => array(
                    'name' => 'Fade Out Left Big',
                    'class' => 'oxy-ani-fadeOutLeftBig',
                    'preview' => 'Element fades out to far left',
                    'tags' => array('fading exits', 'directional', 'dramatic')
                ),
                'fade-out-right' => array(
                    'name' => 'Fade Out Right',
                    'class' => 'oxy-ani-fadeOutRight',
                    'preview' => 'Element fades out to right',
                    'tags' => array('fading exits', 'directional', 'smooth')
                ),
                'fade-out-right-big' => array(
                    'name' => 'Fade Out Right Big',
                    'class' => 'oxy-ani-fadeOutRightBig',
                    'preview' => 'Element fades out to far right',
                    'tags' => array('fading exits', 'directional', 'dramatic')
                ),
                'fade-out-up' => array(
                    'name' => 'Fade Out Up',
                    'class' => 'oxy-ani-fadeOutUp',
                    'preview' => 'Element fades out to top',
                    'tags' => array('fading exits', 'directional', 'smooth')
                ),
                'fade-out-up-big' => array(
                    'name' => 'Fade Out Up Big',
                    'class' => 'oxy-ani-fadeOutUpBig',
                    'preview' => 'Element fades out to far top',
                    'tags' => array('fading exits', 'directional', 'dramatic')
                ),

                // Flippers
                'flip' => array(
                    'name' => 'Flip',
                    'class' => 'oxy-ani-flip',
                    'preview' => 'Element flips around',
                    'tags' => array('flippers', '3D', 'rotation')
                ),
                'flip-in-x' => array(
                    'name' => 'Flip In X',
                    'class' => 'oxy-ani-flipInX',
                    'preview' => 'Element flips in horizontally',
                    'tags' => array('flippers', '3D', 'rotation')
                ),
                'flip-in-y' => array(
                    'name' => 'Flip In Y',
                    'class' => 'oxy-ani-flipInY',
                    'preview' => 'Element flips in vertically',
                    'tags' => array('flippers', '3D', 'rotation')
                ),
                'flip-out-x' => array(
                    'name' => 'Flip Out X',
                    'class' => 'oxy-ani-flipOutX',
                    'preview' => 'Element flips out horizontally',
                    'tags' => array('flippers', '3D', 'rotation')
                ),
                'flip-out-y' => array(
                    'name' => 'Flip Out Y',
                    'class' => 'oxy-ani-flipOutY',
                    'preview' => 'Element flips out vertically',
                    'tags' => array('flippers', '3D', 'rotation')
                ),

                // Lightspeed
                'light-speed-in-right' => array(
                    'name' => 'Light Speed In Right',
                    'class' => 'oxy-ani-lightSpeedInRight',
                    'preview' => 'Element enters at light speed from right',
                    'tags' => array('lightspeed', 'fast', 'dramatic')
                ),
                'light-speed-in-left' => array(
                    'name' => 'Light Speed In Left',
                    'class' => 'oxy-ani-lightSpeedInLeft',
                    'preview' => 'Element enters at light speed from left',
                    'tags' => array('lightspeed', 'fast', 'dramatic')
                ),
                'light-speed-out-right' => array(
                    'name' => 'Light Speed Out Right',
                    'class' => 'oxy-ani-lightSpeedOutRight',
                    'preview' => 'Element exits at light speed to right',
                    'tags' => array('lightspeed', 'fast', 'dramatic')
                ),
                'light-speed-out-left' => array(
                    'name' => 'Light Speed Out Left',
                    'class' => 'oxy-ani-lightSpeedOutLeft',
                    'preview' => 'Element exits at light speed to left',
                    'tags' => array('lightspeed', 'fast', 'dramatic')
                ),

                // Rotating Entrances
                'rotate-in' => array(
                    'name' => 'Rotate In',
                    'class' => 'oxy-ani-rotateIn',
                    'preview' => 'Element rotates into view',
                    'tags' => array('rotating entrances', 'rotation', 'spin')
                ),
                'rotate-in-down-left' => array(
                    'name' => 'Rotate In Down Left',
                    'class' => 'oxy-ani-rotateInDownLeft',
                    'preview' => 'Element rotates in from top-left',
                    'tags' => array('rotating entrances', 'corner', 'rotation')
                ),
                'rotate-in-down-right' => array(
                    'name' => 'Rotate In Down Right',
                    'class' => 'oxy-ani-rotateInDownRight',
                    'preview' => 'Element rotates in from top-right',
                    'tags' => array('rotating entrances', 'corner', 'rotation')
                ),
                'rotate-in-up-left' => array(
                    'name' => 'Rotate In Up Left',
                    'class' => 'oxy-ani-rotateInUpLeft',
                    'preview' => 'Element rotates in from bottom-left',
                    'tags' => array('rotating entrances', 'corner', 'rotation')
                ),
                'rotate-in-up-right' => array(
                    'name' => 'Rotate In Up Right',
                    'class' => 'oxy-ani-rotateInUpRight',
                    'preview' => 'Element rotates in from bottom-right',
                    'tags' => array('rotating entrances', 'corner', 'rotation')
                ),

                // Rotating Exits
                'rotate-out' => array(
                    'name' => 'Rotate Out',
                    'class' => 'oxy-ani-rotateOut',
                    'preview' => 'Element rotates out of view',
                    'tags' => array('rotating exits', 'rotation', 'spin')
                ),
                'rotate-out-down-left' => array(
                    'name' => 'Rotate Out Down Left',
                    'class' => 'oxy-ani-rotateOutDownLeft',
                    'preview' => 'Element rotates out to bottom-left',
                    'tags' => array('rotating exits', 'corner', 'rotation')
                ),
                'rotate-out-down-right' => array(
                    'name' => 'Rotate Out Down Right',
                    'class' => 'oxy-ani-rotateOutDownRight',
                    'preview' => 'Element rotates out to bottom-right',
                    'tags' => array('rotating exits', 'corner', 'rotation')
                ),
                'rotate-out-up-left' => array(
                    'name' => 'Rotate Out Up Left',
                    'class' => 'oxy-ani-rotateOutUpLeft',
                    'preview' => 'Element rotates out to top-left',
                    'tags' => array('rotating exits', 'corner', 'rotation')
                ),
                'rotate-out-up-right' => array(
                    'name' => 'Rotate Out Up Right',
                    'class' => 'oxy-ani-rotateOutUpRight',
                    'preview' => 'Element rotates out to top-right',
                    'tags' => array('rotating exits', 'corner', 'rotation')
                ),

                // Specials
                'hinge' => array(
                    'name' => 'Hinge',
                    'class' => 'oxy-ani-hinge',
                    'preview' => 'Element falls like a hinge',
                    'tags' => array('specials', 'physics', 'gravity')
                ),
                'jack-in-the-box' => array(
                    'name' => 'Jack In The Box',
                    'class' => 'oxy-ani-jackInTheBox',
                    'preview' => 'Element pops up like jack-in-the-box',
                    'tags' => array('specials', 'surprise', 'playful')
                ),
                'roll-in' => array(
                    'name' => 'Roll In',
                    'class' => 'oxy-ani-rollIn',
                    'preview' => 'Element rolls into view',
                    'tags' => array('specials', 'rotation', 'movement')
                ),
                'roll-out' => array(
                    'name' => 'Roll Out',
                    'class' => 'oxy-ani-rollOut',
                    'preview' => 'Element rolls out of view',
                    'tags' => array('specials', 'rotation', 'movement')
                ),

                // Zooming Entrances
                'zoom-in' => array(
                    'name' => 'Zoom In',
                    'class' => 'oxy-ani-zoomIn',
                    'preview' => 'Element zooms into view',
                    'tags' => array('zooming entrances', 'scale', 'growth'),
                    'attributes' => $standard_attributes
                ),
                'zoom-in-down' => array(
                    'name' => 'Zoom In Down',
                    'class' => 'oxy-ani-zoomInDown',
                    'preview' => 'Element zooms in from top',
                    'tags' => array('zooming entrances', 'scale', 'directional')
                ),
                'zoom-in-left' => array(
                    'name' => 'Zoom In Left',
                    'class' => 'oxy-ani-zoomInLeft',
                    'preview' => 'Element zooms in from left',
                    'tags' => array('zooming entrances', 'scale', 'directional')
                ),
                'zoom-in-right' => array(
                    'name' => 'Zoom In Right',
                    'class' => 'oxy-ani-zoomInRight',
                    'preview' => 'Element zooms in from right',
                    'tags' => array('zooming entrances', 'scale', 'directional')
                ),
                'zoom-in-up' => array(
                    'name' => 'Zoom In Up',
                    'class' => 'oxy-ani-zoomInUp',
                    'preview' => 'Element zooms in from bottom',
                    'tags' => array('zooming entrances', 'scale', 'directional')
                ),

                // Zooming Exits
                'zoom-out' => array(
                    'name' => 'Zoom Out',
                    'class' => 'oxy-ani-zoomOut',
                    'preview' => 'Element zooms out of view',
                    'tags' => array('zooming exits', 'scale', 'shrink')
                ),
                'zoom-out-down' => array(
                    'name' => 'Zoom Out Down',
                    'class' => 'oxy-ani-zoomOutDown',
                    'preview' => 'Element zooms out to bottom',
                    'tags' => array('zooming exits', 'scale', 'directional')
                ),
                'zoom-out-left' => array(
                    'name' => 'Zoom Out Left',
                    'class' => 'oxy-ani-zoomOutLeft',
                    'preview' => 'Element zooms out to left',
                    'tags' => array('zooming exits', 'scale', 'directional')
                ),
                'zoom-out-right' => array(
                    'name' => 'Zoom Out Right',
                    'class' => 'oxy-ani-zoomOutRight',
                    'preview' => 'Element zooms out to right',
                    'tags' => array('zooming exits', 'scale', 'directional')
                ),
                'zoom-out-up' => array(
                    'name' => 'Zoom Out Up',
                    'class' => 'oxy-ani-zoomOutUp',
                    'preview' => 'Element zooms out to top',
                    'tags' => array('zooming exits', 'scale', 'directional')
                ),

                // Sliding Entrances
                'slide-in-down' => array(
                    'name' => 'Slide In Down',
                    'class' => 'oxy-ani-slideInDown',
                    'preview' => 'Element slides in from top',
                    'tags' => array('sliding entrances', 'directional', 'smooth')
                ),
                'slide-in-left' => array(
                    'name' => 'Slide In Left',
                    'class' => 'oxy-ani-slideInLeft',
                    'preview' => 'Element slides in from left',
                    'tags' => array('sliding entrances', 'directional', 'smooth'),
                    'attributes' => $standard_attributes
                ),
                'slide-in-right' => array(
                    'name' => 'Slide In Right',
                    'class' => 'oxy-ani-slideInRight',
                    'preview' => 'Element slides in from right',
                    'tags' => array('sliding entrances', 'directional', 'smooth'),
                    'attributes' => $standard_attributes
                ),
                'slide-in-up' => array(
                    'name' => 'Slide In Up',
                    'class' => 'oxy-ani-slideInUp',
                    'preview' => 'Element slides in from bottom',
                    'tags' => array('sliding entrances', 'directional', 'smooth'),
                    'attributes' => $standard_attributes
                ),

                // Sliding Exits
                'slide-out-down' => array(
                    'name' => 'Slide Out Down',
                    'class' => 'oxy-ani-slideOutDown',
                    'preview' => 'Element slides out to bottom',
                    'tags' => array('sliding exits', 'directional', 'smooth')
                ),
                'slide-out-left' => array(
                    'name' => 'Slide Out Left',
                    'class' => 'oxy-ani-slideOutLeft',
                    'preview' => 'Element slides out to left',
                    'tags' => array('sliding exits', 'directional', 'smooth')
                ),
                'slide-out-right' => array(
                    'name' => 'Slide Out Right',
                    'class' => 'oxy-ani-slideOutRight',
                    'preview' => 'Element slides out to right',
                    'tags' => array('sliding exits', 'directional', 'smooth')
                ),
                'slide-out-up' => array(
                    'name' => 'Slide Out Up',
                    'class' => 'oxy-ani-slideOutUp',
                    'preview' => 'Element slides out to top',
                    'tags' => array('sliding exits', 'directional', 'smooth')
                )
            )
        );

        // BACKGROUND EFFECTS - Background animations and transitions
        $this->effects['background'] = array(
            'name' => 'Background Effects',
            'icon' => 'dashicons-format-image',
            'description' => 'Background animations including gradients, colors, and patterns',
            'effects' => array(
                // Empty for now - background animations to be added later
            )
        );
    }

    public function get_all_effects() {
        return $this->effects;
    }

    public function get_category($category) {
        return isset($this->effects[$category]) ? $this->effects[$category] : null;
    }

    public function get_effect($category, $effect) {
        if (isset($this->effects[$category]['effects'][$effect])) {
            return $this->effects[$category]['effects'][$effect];
        }
        return null;
    }

    public function generate_shortcode($category, $effect, $attributes = array()) {
        $effect_data = $this->get_effect($category, $effect);
        if (!$effect_data) return '';

        $shortcode = '[oxy_anim';
        $shortcode .= ' type="' . $effect . '"';
        $shortcode .= ' class="' . $effect_data['class'] . '"';

        foreach ($attributes as $key => $value) {
            $shortcode .= ' ' . $key . '="' . esc_attr($value) . '"';
        }

        $shortcode .= ']Your content here[/oxy_anim]';

        return $shortcode;
    }

    public function generate_oxygen_code($category, $effect) {
        $effect_data = $this->get_effect($category, $effect);
        if (!$effect_data) return '';

        $code = array(
            'css_class' => $effect_data['class'],
            'attributes' => isset($effect_data['attributes']) ? $effect_data['attributes'] : array(),
            'custom_css' => $this->get_effect_css($effect_data['class']),
            'javascript' => $this->get_effect_js($effect_data['class']),
            'requirements' => isset($effect_data['requires']) ? $effect_data['requires'] : array()
        );

        return $code;
    }

    private function get_effect_css($class) {
        // CSS will be added as effects are registered
        return '';
    }

    private function get_effect_js($class) {
        // JavaScript will be added as effects are registered
        return '';
    }
}
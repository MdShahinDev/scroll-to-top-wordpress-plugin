<?php
/*
 * Plugin Name:       Customizable Swift Scroll To Top
 * Plugin URI:        https://wordpress.org/plugins/customizable-swift-top/
 * Description:       Add a sleek, customizable scroll-to-top button to your site for fast, smooth        navigation. Style it your way for an enhanced user experience!
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Md Shahin
 * Author URI:        github.com/MdShahinDev
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       customizable-swift-scroll-to-top
 */

//  CSS Include 
function customswift_enqueue_style(){
    wp_enqueue_style('customswift-style',plugins_url('css/customswift-style.css',__FILE__), array(), '1.0.0');
}
add_action('wp_enqueue_scripts','customswift_enqueue_style');

// Include JS 
function customswift_enqueue_scripts(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('customswift-plugin', plugins_url( 'js/customswift-plugin.js', __FILE__),array(),'1.0.0','true');
}
add_action('wp_enqueue_scripts','customswift_enqueue_scripts');
// JQuery Plugin Active 
function customswift_scroll_script(){
?>
<script>
        jQuery(document).ready(function () {
            jQuery.scrollUp({
                scrollImg: true, 
                scrollText: '',  
                topDistance: '300', 
                topSpeed: 600,
            });
        });
    </script>

<?php
}
add_action('wp_footer','customswift_scroll_script');
// Plugin Customization Setting    
add_action('customize_register', 'customswift_scroll_to_top');
function customswift_scroll_to_top($wp_customize) {
    // Add a new section for Scroll To Top settings
    $wp_customize->add_section('customswift_scroll_top_section', array(
        'title'       => __( 'Scroll To Top', 'customizable-swift-scroll-to-top'),
        'description' => __('The Customizable Swift Scroll To Top plugin lets you add and customize a Back to Top button on your WordPress site.', 'customizable-swift-scroll-to-top' ),
        'priority'    => 30, 
    ));

    // Add a setting for the background color
    $wp_customize->add_setting('customswift_default_color', array(
        'default'   => '#000000', 
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    // Add a control for the background color
    $wp_customize->add_control('customswift_default_color', array(
        'label'    => __( 'Background Color', 'customizable-swift-scroll-to-top' ),
        'description'=> __('Set Icon Color','customizable-swift-scroll-to-top'),
        'section'  => 'customswift_scroll_top_section',
        'type'     => 'color', 
    ));



    
    // // Add a setting for the Border Radius
    $wp_customize->add_setting('customswift_rounded_corner', array(
        'default'   => '5px', 
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // // Add a control for the Border Radius
    $wp_customize->add_control('customswift_rounded_corner', array(
        'label'    => __( 'Border Radius', 'customizable-swift-scroll-to-top' ),
        'description'=> __('Set the border radius. Maximum of 25px for a fully rounded','customizable-swift-scroll-to-top'),
        'section'  => 'customswift_scroll_top_section',
        'type'     => 'text',
    ));



    // // Add a setting for Position Bottom
    $wp_customize->add_setting('customswift_position_bottom', array(
        'default'   => '20px',
        'sanitize_callback' => 'sanitize_text_field', 
    ));

    // // Add a setting for Position Bottom
    $wp_customize->add_control('customswift_position_bottom', array(
        'label'    => __( 'Position Bottom', 'customizable-swift-scroll-to-top' ),
        'description'=> __('Set the Position For Bottom','customizable-swift-scroll-to-top'),
        'section'  => 'customswift_scroll_top_section',
        'type'     => 'text',
    ));


    // // Add a setting for Position Right
    $wp_customize->add_setting('customswift_position_right', array(
        'default'   => '50px', 
        'sanitize_callback' => 'sanitize_text_field', 
    ));

    // // Add a setting for Position Right
    $wp_customize->add_control('customswift_position_right', array(
        'label'    => __( 'Position Right', 'customizable-swift-scroll-to-top' ),
        'description'=> __('Set the Position for Right ','customizable-swift-scroll-to-top'),
        'section'  => 'customswift_scroll_top_section',
        'type'     => 'text',
    ));



    // // Add a setting for Change Icon
    $wp_customize->add_setting('customswift_icon', array(
        'default'   => plugins_url( 'img/top.png',__FILE__ ), 
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'customswift_icon_image_control', array(
        'label'       => __('Change Icon', 'customizable-swift-scroll-to-top'),
        'description' => __('Upload a 38x38 px PNG icon image for the scroll-to-top button.','customizable-swift-scroll-to-top'),
        'section'     => 'customswift_scroll_top_section',
        'settings'    => 'customswift_icon',
    )));    
}

// Css Customizer 
add_action('wp_head', 'customswift_apply_custom_style');
function customswift_apply_custom_style() {
    // Get the color value from the customizer setting
    $background_color = get_theme_mod('customswift_default_color', '#000000'); 
    $border_radius = get_theme_mod('customswift_rounded_corner', '5px');
    $bottom = get_theme_mod('customswift_position_bottom', '20px');
    $right = get_theme_mod('customswift_position_right', '50px');
    $icon = get_theme_mod('customswift_icon','');
    ?>
    <style>
        #scrollUp {
            background-color: <?php echo esc_attr($background_color); ?>;
            border-radius:  <?php echo esc_attr($border_radius); ?>;
            bottom:  <?php echo esc_attr($bottom); ?>;
            right:  <?php echo esc_attr($right); ?>;
            <?php 
            if($icon):?>
            background-image: url(<?php echo esc_url($icon); ?>);
            <?php endif; ?>
        }
    </style>
    <?php
}
?>
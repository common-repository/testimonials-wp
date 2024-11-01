<?php
/*
Plugin Name: Testimonials WP
Plugin URI: http://wordpress.plustime.com.au/testimonials-wp/
Description: Customizable plugin that creates and displays your testimonials with shortcodes. Create the testimonials as an Admin or as a User.
Version: 1.0.0
Text Domain: testimonials-wp
Author: second2none
Author URI: http://wordpress.plustime.com.au/
License: GPL2
*/

if( ! defined( 'WP_CONTENT_DIR' ) ) {if ( ! defined( 'ABSPATH' ) ) { exit; } }

include( plugin_dir_path( __FILE__ ) . 'options.php' );

add_action( 'plugins_loaded' , 'twp_init_plugin' );

//include( plugin_dir_path( __FILE__ ) . 'my-services-postcode-widget.php' );
//add_action( 'widgets_init' , create_function( '' , 'register_widget("twp_Widget");' ) );

function twp_init_plugin(){
    add_action( 'admin_menu' , 'twp_create_menu' );
}

function twp_create_menu() {
	add_menu_page( __( 'Testimonials WP' , 'testimonials-wp') , __( 'Testimonials Settings' , 'testimonials-wp') , 'manage_options' , 'twp_options' , 'twp_settings_page' , 'dashicons-format-status' );
	add_action( 'admin_init', 'register_twp_settings' );
}

function twp_admin_scripts( $args ){
    $current_screen = get_current_screen();
    if( strpos( $current_screen->base , 'twp_options' ) !== false ) {
        wp_enqueue_style( 'twp_fa_css' , 'https://use.fontawesome.com/releases/v5.7.2/css/all.css' , false , '1.0.0' , 'all' );
        wp_enqueue_style( 'twp_admin_css' , plugins_url( 'css/admin_page_css.css' , __FILE__ ) , false , '1.0.0' , 'all' );

        wp_enqueue_script( 'twp_admin_js' , plugins_url( 'js/twp_admin.js' , __FILE__ ) , array( 'jquery') , '1.0.0' , true );
        wp_enqueue_media();
    }
} 
add_action( 'admin_enqueue_scripts' , 'twp_admin_scripts' );

function twp_scripts_with_jquery(){
    $params = [
        'ajaxurl' => admin_url( 'admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('twp-ajax_nonce-string'),
    ];
    wp_enqueue_script( 'twp-rating-js' , plugins_url( '/js/twp-s2n.js' , __FILE__ ) , array( 'jquery' ) , '1.0.0' );
    wp_localize_script( 'twp-rating-js' , 'twp_save' , $params );
    wp_enqueue_style( 'twp_fa' , 'https://use.fontawesome.com/releases/v5.7.2/css/all.css' , false , '1.0.0' , 'all' );
    wp_enqueue_style( 'twp_css' , plugins_url( '/css/twp.css' , __FILE__ ) , false , '1.0.0' , 'all' );

}
add_action( 'wp_enqueue_scripts', 'twp_scripts_with_jquery' );

function twp_activate() {
    global $wpdb;
    if ( ! class_exists('Testimonials_WP') ) {
        include( plugin_dir_path( __FILE__ ) . 'php_libraries/testimonial_class.php');
    }
    $twp = new Testimonials_WP( $wpdb );
    $twp->createTableIfNotExist();

    $twp_settings = get_option( 'twp_settings' );
    $twp_display_settings = get_option( 'twp_display_settings' );
    
    $twp_defaults = array(
            'global-ONOFF'              => 'on',
            'labels-ONOFF'              => 'on',
            'placeholder-ONOFF'         => 'on',
            'testimonial-title'         => __( 'Leave Us A Testimonial' , 'testimonials-wp'),
            'class-success'             => 'success-message',
            'class-error'               => 'error-message',
            'message-success'           => __( 'Awesome, thanks for your testimonial!' , 'testimonials-wp'),
            'message-error'             => __( 'There was an error' , 'testimonials-wp'),
            'auto-approve'              => false,
            'form-theme'                => 'dark-theme',
            'star-size'                 => 's2n-md',
            'save-spinner'              => 'fas fa-spinner'
    ); 

    $twp_display_defaults = array(
            'display-ONOFF'             => 'on',
            'display-theme'             => 'dark-theme',
            'border-ONOFF'              => 'on',
            'testimonial-title'         => __( 'Our Testimonials' , 'testimonials-wp'),
            'image-shape'               => 'img-circle',
            'star-size'                 => 's2n-md',
            'links-ONOFF'               => 'on',
            'nofollow-ONOFF'            => 'on',
            'arrow-type'                => 'double-angle',
            'display-count'             => '1',
            'arrow-hover'               => 'img-sqaure',
            'slide-effect'              => 'fade',
    ); 
    
    if( ! is_array( $twp_settings ) ){
        $twp_settings = [];
    }
    if( ! is_array( $twp_display_settings ) ){
        $twp_display_settings = [];
    }

    $twp_option = wp_parse_args( $twp_settings , $twp_defaults );   
    $twp_display_option = wp_parse_args( $twp_display_settings , $twp_display_defaults );   
    
    update_option( 'twp_settings' , $twp_option ); 
    update_option( 'twp_display_settings' , $twp_display_option ); 
    
}
register_activation_hook( __FILE__ , 'twp_activate' );

function twp_form_shortcode( $atts ) {
        $twp_settings =  get_option( 'twp_settings' );

        if($twp_settings['global-ONOFF'] != 'off'){
            global $wpdb;
            if ( ! class_exists('Testimonials_WP') ) {
                include( plugin_dir_path( __FILE__ ) . 'php_libraries/testimonial_class.php');
            }
            $twp = new Testimonials_WP( $wpdb );

            return $twp->returnUserInput( $twp_settings );
        }
        return '';
}
add_shortcode( 'twp_form', 'twp_form_shortcode' );

function twp_display_shortcode( $atts ) {
    $twp_display_settings =  get_option( 'twp_display_settings' );

    if($twp_display_settings['display-ONOFF'] != 'off'){
        global $wpdb;
        if ( ! class_exists('Testimonials_WP') ) {
            include( plugin_dir_path( __FILE__ ) . 'php_libraries/testimonial_class.php');
        }
        $twp = new Testimonials_WP( $wpdb );
        $twp->set_PluginURL( plugins_url( '/' , __FILE__ ) );

        return $twp->returnDisplay( $twp_display_settings );
    }
    return '';
}
add_shortcode( 'twp_display', 'twp_display_shortcode' );

?>
<?php

function register_twp_settings() {
    //set defaults
    
    $twp_settings = get_option( 'twp_settings' );
    $twp_display_settings = get_option( 'twp_display_settings' );
    
    //set checkboxs
    $twp_settings['global-ONOFF']           = ( $twp_settings['global-ONOFF'] == 'on'           ? 'checked' : '' ); 
    $twp_settings['labels-ONOFF']           = ( $twp_settings['labels-ONOFF'] == 'on'           ? 'checked' : '' ); 
    $twp_settings['placeholder-ONOFF']      = ( $twp_settings['placeholder-ONOFF'] == 'on'      ? 'checked' : '' ); 
    $twp_settings['auto-approve']           = ( $twp_settings['auto-approve']                   ? 'checked' : '' ); 

    $twp_display_settings['display-ONOFF']  = ( $twp_display_settings['display-ONOFF'] == 'on'  ? 'checked' : '' ); 
    $twp_display_settings['links-ONOFF']    = ( $twp_display_settings['links-ONOFF'] == 'on'    ? 'checked' : '' ); 
    $twp_display_settings['nofollow-ONOFF'] = ( $twp_display_settings['nofollow-ONOFF'] == 'on' ? 'checked' : '' ); 
    $twp_display_settings['border-ONOFF']   = ( $twp_display_settings['border-ONOFF'] == 'on'   ? 'checked' : '' ); 
    
    //set sections
    add_settings_section( 
        'twp_settings_op',
        __( 'Testimonial Form Settings' , 'testimonials-wp'),
        'twp_settings_callback',
        'twp_settings_op'
    );
    add_settings_section( 
        'twp_display_settings_op',
        __( 'Testimonial Display Settings' , 'testimonials-wp'),
        'twp_display_settings_callback',
        'twp_display_settings_op'
    );
    
    add_settings_field(  
        'global-ONOFF',                      
        '',               
        'twp_switch_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'global-ONOFF', 
            'ID'          => 'global-ONOFF', 
            'name'        => 'global-ONOFF',
            'value'       => $twp_settings['global-ONOFF'],
            'option_name' => 'twp_settings',
            'class'       => '',
            'hint'        => __( 'Turn Testimonials WP Form On / Off Sitewide' , 'testimonials-wp')
        )
    );
    add_settings_field(  
        'form-theme',                      
        __( 'Form Theme' , 'testimonials-wp'),               
        'twp_select_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'form-theme', 
            'ID'          => 'form-theme', 
            'name'        => 'form-theme',
            'value'       => $twp_settings['form-theme'],
            'option_name' => 'twp_settings',
            'options'     => [ 
                'dark-theme'    => 'Dark Theme', 
                'light-theme'   => 'Light Theme', 
                'purple-theme'  => 'Purple Theme', 
                'blue-theme'    => 'Blue Theme', 
                'green-theme'   => 'Green Theme', 
            ],
            'class'       => ''
        )
    );  
    add_settings_field(  
        'testimonial-title',                      
        __( 'Title' , 'testimonials-wp'),               
        'twp_textbox_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'testimonial-title', 
            'ID'          => 'testimonial-title', 
            'name'        => 'testimonial-title',
            'value'       => $twp_settings['testimonial-title'],
            'option_name' => 'twp_settings',
            'class'       => ''
        )
    );
    add_settings_field(  
        'labels-ONOFF',                      
        'Labels',               
        'twp_switch_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'labels-ONOFF', 
            'ID'          => 'labels-ONOFF', 
            'name'        => 'labels-ONOFF',
            'value'       => $twp_settings['labels-ONOFF'],
            'option_name' => 'twp_settings',
            'class'       => '',
            'hint'        => __( 'Turn Labels On/Off Form' , 'testimonials-wp')
        )
    );
    add_settings_field(  
        'placeholder-ONOFF',                      
        'Placeholders',               
        'twp_switch_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'placeholder-ONOFF', 
            'ID'          => 'placeholder-ONOFF', 
            'name'        => 'placeholder-ONOFF',
            'value'       => $twp_settings['placeholder-ONOFF'],
            'option_name' => 'twp_settings',
            'class'       => '',
            'hint'        => __( 'Turn Placeholders On/Off Form' , 'testimonials-wp')
        )
    );

    

    add_settings_field(  
        'auto-approve',                      
        __( 'Auto Approve' , 'testimonials-wp'),               
        'twp_checkbox_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'auto-approve', 
            'ID'          => 'auto-approve', 
            'name'        => 'auto-approve',
            'value'       => $twp_settings['auto-approve'],
            'option_name' => 'twp_settings',
            'class'       => '',
            'hint'        => __( 'If selected testimonials will be automatically approved!' , 'testimonials-wp')
        )
    );
    add_settings_field(  
        'message-success',                      
        __( 'Success Message' , 'testimonials-wp'),               
        'twp_textbox_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'message-success', 
            'ID'          => 'message-success', 
            'name'        => 'message-success',
            'value'       => $twp_settings['message-success'],
            'option_name' => 'twp_settings',
            'class'       => ''
        )
    );
    add_settings_field(  
        'class-success',                      
        __( 'Success Message Class' , 'testimonials-wp'),               
        'twp_textbox_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'class-success', 
            'ID'          => 'class-success', 
            'name'        => 'class-success',
            'value'       => $twp_settings['class-success'],
            'option_name' => 'twp_settings',
            'class'       => '',
            'hint'        => 'Defaults: mgreen, mred, mblue, myellow, mpurple'
        )
    );
    add_settings_field(  
        'message-error',                      
        __( 'Error Message' , 'testimonials-wp'),               
        'twp_textbox_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'message-error', 
            'ID'          => 'message-error', 
            'name'        => 'message-error',
            'value'       => $twp_settings['message-error'],
            'option_name' => 'twp_settings',
            'class'       => ''
        )
    );
    add_settings_field(  
        'class-error',                      
        __( 'Error Message Class' , 'testimonials-wp'),               
        'twp_textbox_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'class-error', 
            'ID'          => 'class-error', 
            'name'        => 'class-error',
            'value'       => $twp_settings['class-error'],
            'option_name' => 'twp_settings',
            'class'       => '',
            'hint'        => 'Defaults: mgreen, mred, mblue, myellow, mpurple'
        )
    );  
    add_settings_field(  
        'star-size',                      
        __( 'Star Size' , 'testimonials-wp'),               
        'twp_select_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'star-size', 
            'ID'          => 'star-size', 
            'name'        => 'star-size',
            'value'       => $twp_settings['star-size'],
            'option_name' => 'twp_settings',
            'options'     => [ 
                's2n-xlg'   => 'Extra Large', 
                's2n-lg'    => 'Large', 
                's2n-md'    => 'Medium', 
                's2n-sm'    => 'Small', 
                's2n-xs'    => 'Extra Small', 
            ],
            'class'       => '',
            'hint'        => ''
        )
    );  
    add_settings_field(  
        'save-spinner',                      
        __( 'Saving Spinner' , 'testimonials-wp'),               
        'twp_icon_select_callback',   
        'twp_settings_op',                     
        'twp_settings_op',
        array (
            'label_for'   => 'save-spinner', 
            'ID'          => 'save-spinner', 
            'name'        => 'save-spinner',
            'value'       => $twp_settings['save-spinner'],
            'option_name' => 'twp_settings',
            'options'     => [ 
                'fas fa-star'               => '&#xf005; Star', 
                'fas fa-certificate'        => '&#xf0a3; Certificate', 
                'far fa-sun'                => '&#xf185; Sun', 
                'fas fa-hourglass-start'    => '&#xf251; Hour Glass', 
                'fas fa-atom'               => '&#xf5d2; Atom', 
                'fas fa-spinner'            => '&#xf110; Spinner',
                'fas fa-adjust'             => '&#xf042; Adjust',
                'fas fa-asterisk'           => '&#xf069; Astertisk',
                'fas fa-arrows-alt-v'       => '&#xf338; V-Arrow',
                'fas fa-circle-notch'       => '&#xf1ce; Circie Notch',
                'far fa-grin-stars'         => '&#xf587; Grin Stars',
                'far fa-grin-squint-tears'  => '&#xf586; Grin Squint Tears',
                'far fa-grin-hearts'        => '&#xf584; Grin Hearts',
                'far fa-grin'               => '&#xf580; Grin',
                'fas fa-history'            => '&#xf1da; History',
            ],
            'class'       => '',
            'hint'        => ''
        )
    ); 
    // Display Settings

    add_settings_field(  
        'display-ONOFF',                      
        '',               
        'twp_switch_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'display-ONOFF', 
            'ID'          => 'display-ONOFF', 
            'name'        => 'display-ONOFF',
            'value'       => $twp_display_settings['display-ONOFF'],
            'option_name' => 'twp_display_settings',
            'class'       => '',
            'hint'        => __( 'Turn Testimonials WP Display On / Off Sitewide' , 'testimonials-wp')
        )
    );
    add_settings_field(  
        'display-theme',                      
        __( 'Display Theme' , 'testimonials-wp'),               
        'twp_select_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'display-theme', 
            'ID'          => 'display-theme', 
            'name'        => 'display-theme',
            'value'       => $twp_display_settings['display-theme'],
            'option_name' => 'twp_display_settings',
            'options'     => [ 
                'dark-theme'    => 'Dark Theme', 
                'light-theme'   => 'Light Theme', 
                'purple-theme'  => 'Purple Theme', 
                'blue-theme'    => 'Blue Theme', 
                'green-theme'   => 'Green Theme', 
            ],
            'class'       => ''
        )
    ); 
    add_settings_field(  
        'border-ONOFF',                      
        'Container Border',               
        'twp_switch_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'border-ONOFF', 
            'ID'          => 'border-ONOFF', 
            'name'        => 'border-ONOFF',
            'value'       => $twp_display_settings['border-ONOFF'],
            'option_name' => 'twp_display_settings',
            'class'       => '',
            'hint'        => __( 'Turn Container Border On / Off' , 'testimonials-wp')
        )
    );
    add_settings_field(  
        'testimonial-title',                      
        __( 'Title' , 'testimonials-wp'),               
        'twp_textbox_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'testimonial-title', 
            'ID'          => 'testimonial-title', 
            'name'        => 'testimonial-title',
            'value'       => $twp_display_settings['testimonial-title'],
            'option_name' => 'twp_display_settings',
            'class'       => ''
        )
    );
    add_settings_field(  
        'links-ONOFF',                      
        'Link URL',               
        'twp_switch_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'links-ONOFF', 
            'ID'          => 'links-ONOFF', 
            'name'        => 'links-ONOFF',
            'value'       => $twp_display_settings['links-ONOFF'],
            'option_name' => 'twp_display_settings',
            'class'       => '',
            'hint'        => __( 'Turn Testimonials WP Links On / Off' , 'testimonials-wp')
        )
    );
    add_settings_field(  
        'nofollow-ONOFF',                      
        'Nofollow Link',               
        'twp_switch_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'nofollow-ONOFF', 
            'ID'          => 'nofollow-ONOFF', 
            'name'        => 'nofollow-ONOFF',
            'value'       => $twp_display_settings['nofollow-ONOFF'],
            'option_name' => 'twp_display_settings',
            'class'       => '',
            'hint'        => __( 'Turn Testimonials WP Nofollow On / Off For Links' , 'testimonials-wp')
        )
    );
    add_settings_field(  
        'image-shape',                      
        __( 'Image Shape' , 'testimonials-wp'),               
        'twp_select_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'image-shape', 
            'ID'          => 'image-shape', 
            'name'        => 'image-shape',
            'value'       => $twp_display_settings['image-shape'],
            'option_name' => 'twp_display_settings',
            'options'     => [ 
                'img-circle'        => 'Circle', 
                'img-square'        => 'Square', 
                'img-rhombus'       => 'Rhombus', 
                'img-triangle'      => 'Triangle', 
                'img-hexagon'       => 'Hexagon', 
                'img-ellipse'       => 'Ellipse', 
                'img-parallelogram' => 'Parallelogram', 
            ],
            'class'       => '',
            'hint'        => ''
        )
    );  

    add_settings_field(  
        'display-count',                      
        __( 'Tesitmonials Per Slide' , 'testimonials-wp'),               
        'twp_select_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'display-count', 
            'ID'          => 'display-count', 
            'name'        => 'display-count',
            'value'       => $twp_display_settings['display-count'],
            'option_name' => 'twp_display_settings',
            'options'     => [ 
                '1'     => '1', 
                '2'     => '2', 
                '3'     => '3'
            ],
            'class'       => '',
            'hint'        => ''
        )
    ); 

    add_settings_field(  
        'star-size',                      
        __( 'Star Size' , 'testimonials-wp'),               
        'twp_select_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'star-size', 
            'ID'          => 'star-size', 
            'name'        => 'star-size',
            'value'       => $twp_display_settings['star-size'],
            'option_name' => 'twp_display_settings',
            'options'     => [ 
                's2n-xlg'   => 'Extra Large', 
                's2n-lg'    => 'Large', 
                's2n-md'    => 'Medium', 
                's2n-sm'    => 'Small', 
                's2n-xs'    => 'Extra Small', 
            ],
            'class'       => '',
            'hint'        => ''
        )
    ); 
    add_settings_field(  
        'arrow-type',                      
        __( 'Arrow Type' , 'testimonials-wp'),               
        'twp_icon_select_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'arrow-type', 
            'ID'          => 'arrow-type', 
            'name'        => 'arrow-type',
            'value'       => $twp_display_settings['arrow-type'],
            'option_name' => 'twp_display_settings',
            'options'     => [ 
                'none'              => 'None - Don\'t Display', 
                'double-angle'      => '&#xf100; &#xf101; Double Angle', 
                'single-angle'      => '&#xf104; &#xf105; Single Angle', 
                'double-caret'      => '&#xf04a; &#xf04e; Double Caret',  
                'single-caret'      => '&#xf0d9; &#xf0da; Single Caret',  
                'circle-chevron'    => '&#xf137; &#xf138; Circle Chevron',
                'circle-arrow'      => '&#xf0a8; &#xf0a9; Circle Arrow', 
                'circle-alt-arrow'  => '&#xf359; &#xf35a; Circle Alt Arrow', 
            ],
            'class'       => '',
            'hint'        => ''
        )
    ); 

    add_settings_field(  
        'arrow-hover',                      
        __( 'Arrow Hover Shape' , 'testimonials-wp'),               
        'twp_select_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'arrow-hover', 
            'ID'          => 'arrow-hover', 
            'name'        => 'arrow-hover',
            'value'       => $twp_display_settings['arrow-hover'],
            'option_name' => 'twp_display_settings',
            'options'     => [ 
                'img-circle'    => 'Circle', 
                'img-sqaure'    => 'Sqaure'
            ],
            'class'       => '',
            'hint'        => ''
        )
    ); 
    add_settings_field(  
        'slide-effect',                      
        __( 'Slide Effect' , 'testimonials-wp'),               
        'twp_select_callback',   
        'twp_display_settings_op',                     
        'twp_display_settings_op',
        array (
            'label_for'   => 'slide-effect', 
            'ID'          => 'slide-effect', 
            'name'        => 'slide-effect',
            'value'       => $twp_display_settings['slide-effect'],
            'option_name' => 'twp_display_settings',
            'options'     => [ 
                'slide'     => 'Slide', 
                'fade'      => 'Fade'
            ],
            'class'       => '',
            'hint'        => ''
        )
    ); 

    //register settings
    $twp_args   = array( 'sanitize_callback'   => 'twp_post_callback' );
    $twp_display_args   = array( 'sanitize_callback'   => 'twp_display_post_callback' );

    register_setting( 'twp_settings_op' , 'twp_settings' , $twp_args );
    register_setting( 'twp_display_settings_op' , 'twp_display_settings' , $twp_display_args );
}
function twp_display_post_callback( $input ) {
    if( ! isset( $input['display-ONOFF'] ) ){ $input['display-ONOFF'] = 'off'; } 
    if( ! isset( $input['links-ONOFF'] ) ){ $input['links-ONOFF'] = 'off'; } 
    if( ! isset( $input['nofollow-ONOFF'] ) ){ $input['display-ONOFF'] = 'off'; }
    if( ! isset( $input['border-ONOFF'])){ $input['border-ONOFF'] = 'off'; }   
    return $input; 
}
function twp_post_callback( $input ) {
    if( ! isset( $input['global-ONOFF'])){ $input['global-ONOFF'] = 'off'; }    
    if( ! isset( $input['labels-ONOFF'])){ $input['labels-ONOFF'] = 'off'; }    
    if( ! isset( $input['placeholder-ONOFF'])){ $input['placeholder-ONOFF'] = 'off'; }      
    if( ! isset( $input['auto-approve'])){ $input['auto-approve'] = false; }else{ $input['auto-approve'] = true; }
    return $input;  
}
function twp_settings_callback( $args ) { 
    printf( '<p>%s [twp_form]</p>', __( 'Shortcode:' , 'testimonials-wp' ) );
}
function twp_display_settings_callback( $args ) { 
    printf( '<p>%s [twp_display]</p>', __( 'Shortcode:' , 'testimonials-wp' ) );
}
function twp_custom_button ( $args ){
    echo '<button id="' . $args["ID"] . '" class="' . $args["class"] . '"> ' . $args["value"] . ' </button> ';
}
function twp_switch_callback( $args ){
    echo '<div class="onoffswitch">
                <input type="checkbox" name="' . $args["option_name"] . '[' . $args["ID"] . ']" class="onoffswitch-checkbox" id="' . $args["ID"] . '" ' . $args["value"] . '>
                <label class="onoffswitch-label" for="' . $args["ID"] . '"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span></label>
          </div>';         
    echo ( isset( $args["hint"] ) ? '<p class="hint">' . $args["hint"] . '</p>' : '' );
}
function twp_textbox_callback( $args ) { 
    echo '<input type="text" id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" value="' . $args["value"] . '" class="field-40"></input>';
    echo ( isset( $args["hint"] ) ? '<p class="hint">' . $args["hint"] . '</p>' : '' );
}
function twp_textarea_callback( $args ) { 
    if(!isset($args["rows"]))$args["rows"] = 5;
    echo '<textarea id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" rows="'.$args["rows"].'" class="field-40">' . $args["value"] . '</textarea> ';
    echo ( isset( $args["hint"] ) ? '<p class="hint">' . $args["hint"] . '</p>' : '' );
}
function twp_checkbox_callback( $args ) { 
    echo '<input type="checkbox" id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" ' . $args["value"] . ' ></input>';
    echo ( isset( $args["hint"] ) ? '<p class="hint">' . $args["hint"] . '</p>' : '' );
}
function twp_infobox_callback( $args ) { 
    echo '<tr id="' . $args["ID"] . ' class="'.$args["class"].'>';
    echo '<td class="mw_d_title">' . $args["title"] . '</td><td>' . $args["text"] . '</td>';
    echo '</tr>';
}
function twp_select_callback( $args ) { 
    echo '<select id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" class="field-40">';
    foreach( $args['options'] as $type => $label ){
        echo ( ( $args["value"] == $type ) ? '<option value="' . $type . '" selected>' . $label . '</option>' : '<option value="' . $type . '">' . $label . '</option>' );
    }
    echo '</select>';
    echo ( isset( $args["hint"] ) ? '<p class="hint">' . $args["hint"] . '</p>' : '' );
}

function twp_icon_select_callback( $args ) { 
    echo '<select id="' . $args["ID"] . '" name="' . $args["option_name"] . '[' . $args["ID"] . ']" class="icon-select field-40">';
    foreach( $args['options'] as $type => $label ){
        echo ( ( $args["value"] === $type ) ? '<option value="' . $type . '" selected>' . $label . '</option>' : '<option value="' . $type . '">' . $label . '</option>' );
    }
    echo '</select>';
    echo ( isset( $args["hint"] ) ? '<p class="hint">' . $args["hint"] . '</p>' : '' );
}
function twp_settings_page() {
    global $wpdb;
    if ( ! class_exists('Testimonials_WP') ) {
        include( plugin_dir_path( __FILE__ ) . 'php_libraries/testimonial_class.php');
    }
    $twp = new Testimonials_WP( $wpdb );

    if ( ! class_exists('TWP_Tables') ) {
        include( plugin_dir_path( __FILE__ ) . 'php_libraries/twp_tables_class.php');
    }
    
    $twpt = new TWP_Tables( $twp );
    $twpt->set_PluginURL( plugins_url( '/' , __FILE__ ) );
    $twpt->process_bulk_action();
   

    if( isset( $_POST['submit_testimonial'] ) ){
        $insert = $twp->addTestimonial( 
            sanitize_text_field( $_POST['firstname'] ) ,  
            sanitize_text_field( $_POST['lastname'] ) ,  
            esc_url_raw( $_POST['url'] ) ,  
            sanitize_email( $_POST['email'] ) ,  
            sanitize_textarea_field( $_POST['comment'] ) ,  
            sanitize_text_field( $_POST['imageid'] ) , 
            get_current_user_id() ,  
            sanitize_text_field( $_POST['star-rating'] ) );

        if( $insert === false ){
            add_settings_error( 'twp-notices', 'twp-add-testimonial', __('Failed to Add Testimonial', 'myplugin'), 'error' );
        }else{
            add_settings_error( 'twp-notices', 'twp-add-testimonial', __('Testimonial Successfully Added', 'twp'), 'updated' );
            $update = $twp->approveTestimonial( $wpdb->insert_id , get_current_user_id() );
            if( $update === false ){
                add_settings_error( 'twp-notices', 'twp-approve-testimonial', __('Failed to Approve Testimonial', 'twp'), 'error' );   
            }else{
                add_settings_error( 'twp-notices', 'twp-approve-testimonial', __('Testimonial Successfully Approved', 'twp'), 'updated' );
            }
        }
    }

?>

<div class="wrap">  
        <div id="icon-themes" class="icon32"></div>  
        <h2><?php _e( 'Testimonials WP', 'testimonials-wp' ); ?></h2>  
        <div class="description"><?php _e( 'Improve user experience', 'testimonials-wp' ); ?></div>
        <?php settings_errors(); 
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'form';  
        ?>  

        <h2 class="nav-tab-wrapper">  
            <a href="?page=twp_options&tab=form" class="nav-tab <?php       echo $active_tab == 'form'      ? 'nav-tab-active' : ''; ?>">Form Settings</a>  
            <a href="?page=twp_options&tab=display" class="nav-tab <?php    echo $active_tab == 'display'   ? 'nav-tab-active' : ''; ?>">Display Settings</a>   
            <a href="?page=twp_options&tab=add" class="nav-tab <?php        echo $active_tab == 'add'       ? 'nav-tab-active' : ''; ?>">Add Testimonial</a>   
            <a href="?page=twp_options&tab=approve" class="nav-tab <?php    echo $active_tab == 'approve'   ? 'nav-tab-active' : ''; ?>">Need Approval</a>   
            <a href="?page=twp_options&tab=approved" class="nav-tab <?php   echo $active_tab == 'approved'  ? 'nav-tab-active' : ''; ?>">Approved Testimonials</a>  
        </h2>  
        <?php 
        
        if( $active_tab == 'form' ) { 
            ?>

            <form method="post" action="options.php"> 

            <?php
            settings_fields( 'twp_settings_op' );
            do_settings_sections( 'twp_settings_op' );
            submit_button();
        } elseif( $active_tab == 'display' ) {
            ?>

            <form method="post" action="options.php">

            <?php
            settings_fields( 'twp_display_settings_op' );
            do_settings_sections( 'twp_display_settings_op' );
            submit_button();
        } elseif( $active_tab == 'add' ) { 
            
        ?>

        <form method="post" action="<?php echo admin_url( 'admin.php?page=twp_options&tab=add' ); ?>"> 
        <p>Add a Custom Testimonial</p>
        <?php echo $twp->returnAdminAddForm(); ?>
            
        <?php
        } elseif( $active_tab == 'approve' ) {
            $add_columns = array(
                'cb'	    => '<input type="checkbox" />', 	 
                'imageid'	=> __( 'Image', 'testimonials-wp' ),
                'firstname'	=> __( 'First Name', 'testimonials-wp' ),
                'lastname'	=> __( 'Last Name', 'testimonials-wp' ),			
                'rating'	=> __( 'Rating', 'testimonials-wp' ),
                'comment'	=> __( 'Comment', 'testimonials-wp' ),
                'email'	    => __( 'Email', 'testimonials-wp' ),
                'url'	    => __( 'URL', 'testimonials-wp' )
            );	
            $twpt->setTable( $add_columns , 'Approve' , 's-purple' , [ 'approve' => 'Approve', 'delete' => 'Delete' ] );

            $twpt->prepare_items();
            
        ?>

        <form method="post" action="<?php echo admin_url( 'admin.php?page=twp_options&tab=approve' ); ?>">
        <p>Testimonials That Need Approving</p>
        <input name="form_approve" value="form_approve" type="hidden" />
        <?php $twpt->display();  ?>
        <?php  
        }elseif( $active_tab == 'approved' ) {
            $add_columns = array(
                'cb'	        => '<input type="checkbox" />', 	 
                'imageid'	    => __( 'Image', 'testimonials-wp' ),
                'firstname'	    => __( 'First Name', 'testimonials-wp' ),
                'lastname'	    => __( 'Last Name', 'testimonials-wp' ),			
                'rating'	    => __( 'Rating', 'testimonials-wp' ),
                'comment'	    => __( 'Comment', 'testimonials-wp' ),
                'email'	        => __( 'Email', 'testimonials-wp' ),
                'url'	        => __( 'URL', 'testimonials-wp' ),
                'showing'	    => __( 'Show', 'testimonials-wp' ),
                'approvedby'    => __( 'Approved By', 'testimonials-wp' ),
            );	
            $twpt->setTable( $add_columns , 'AllApproved' , 's-purple' , [ 'delete' => 'Delete' , 'show' => 'Show' , 'hide' => 'Hide' ] );

            $twpt->prepare_items();
            
        ?>

        <form method="post" action="<?php echo admin_url( 'admin.php?page=twp_options&tab=approved' ); ?>">
        <p>Testimonials That Need Approving</p>
        <input name="form_approved" value="form_approved" type="hidden" />
        <?php $twpt->display();  ?>
        <?php  
        }
        ?>             
    </form> 
</div> 

<?php 
}
function twp_ajax_save() {

    $twp_settings = get_option( 'twp_settings' );

    check_ajax_referer( 'twp-ajax_nonce-string', 'wp_nonce' );

    if ( ! class_exists('TWP_Image') ) {
        include( plugin_dir_path( __FILE__ ) . 'php_libraries/twp_image_class.php');
    }
    
    $twpi = new TWP_Image( );

    if ( empty( $_POST ) && ! isset( $_POST['action'] ) && strcmp( $_POST['action'] , 'twp_ajax_save' ) !== 0 ) {
        echo json_encode( array( 'Error' , __( 'Data Error - Contact Admin', 'testimonials-wp' ) ) , JSON_FORCE_OBJECT );
        die();
    }
    
    if ( ! isset( $_POST['firstname'] ) || empty ( $_POST['firstname'] ) ) {
        echo json_encode( array( 'Error' , __( 'Please Enter Your Name', 'testimonials-wp' ) ) , JSON_FORCE_OBJECT );
        die();
    }

    if ( ! isset( $_POST['lastname'] ) || empty ( $_POST['lastname'] ) ) {
        echo json_encode( array( 'Error' , __( 'Please Enter Your Name', 'testimonials-wp' ) ) , JSON_FORCE_OBJECT );
        die();
    }
    if ( ! isset( $_POST['comment'] ) || empty ( $_POST['comment'] ) ) {
        echo json_encode( array( 'Error' , __( 'Please Leave Some Comments', 'testimonials-wp' ) ) , JSON_FORCE_OBJECT );
        die();
    }
    if ( ! isset( $_POST['rating'] ) || empty ( $_POST['rating'] ) ) {
        echo json_encode( array( 'Error' , __( 'Please Give A Rating', 'testimonials-wp' ) ) , JSON_FORCE_OBJECT );
        die();
    }
    if ( ! isset( $_POST['image'] ) ) {
        echo json_encode( array( 'Error' , __( 'Image Error - Contact Admin', 'testimonials-wp' ) ) , JSON_FORCE_OBJECT );
        die();
    }
    $save_image = 0;
    if( strpos( $_POST['image'] , 'default-profile.png' ) === false ){
        $save_image = $twpi->save_image( esc_url(  $_POST['image'] , array( 'data' ) ) );
    }    

    global $wpdb;
    if ( ! class_exists('Testimonials_WP') ) {
        include( plugin_dir_path( __FILE__ ) . 'php_libraries/testimonial_class.php');
    }
    $twp = new Testimonials_WP( $wpdb );
    

    $insert = $twp->addTestimonial( 
        sanitize_text_field( $_POST['firstname'] ) , 
        sanitize_text_field( $_POST['lastname'] ) , 
        esc_url_raw( $_POST['url'] ) , 
        sanitize_email( $_POST['email'] ) , 
        sanitize_textarea_field( $_POST['comment'] ) , 
        $save_image , 
        get_current_user_id() , 
        sanitize_text_field( $_POST['rating'] ) );

    if( ! $insert ){
        echo json_encode( array( 'Error' , __( 'Couldn\'t Add Testimonial At This Time.' , 'testimonials-wp' ) ) , JSON_FORCE_OBJECT );
        die();
    }

    if( $twp_settings['auto-approve'] ) {
        $update = $twp->approveTestimonial( $wpdb->insert_id , get_current_user_id() ); 
    }

    echo json_encode( array( 'Success' , 'Testimonial Saved!' ) , JSON_FORCE_OBJECT );
    die();
}
add_action( 'wp_ajax_twp_ajax_save' , 'twp_ajax_save' );
add_action( 'wp_ajax_nopriv_twp_ajax_save' , 'twp_ajax_save' );
?>
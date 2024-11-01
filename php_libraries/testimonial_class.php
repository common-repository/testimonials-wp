<?php

class Testimonials_WP {
    private $wpdb;
    public $twpdb;
    public $star;
    public $star_half;
    public $star_empty;
    public $ratingcount;
    public $plugin_url;

    function __construct( $wpdb ){
        
        $this->wpdb = $wpdb;
        $this->twpdb = $wpdb->prefix.'testimonials_wp';
        $this->star = 'fas';
        $this->star_half = 'fas fa-star-half-alt';
        $this->star_empty = 'far';
        $this->ratingcount = 5;

    }
    
    public function set_PluginURL( $url ){
        $this->plugin_url = $url;
    }
    public function addTestimonial( $firstname , $lastname , $url , $email , $comment , $imageid , $uploaduser , $rating ){
       return $this->wpdb->insert( 
            $this->twpdb, 
            [ 
                'time'          => date("Y-m-d H:i:s"), 
                'firstname'     => $firstname, 
                'lastname'      => $lastname, 
                'url'           => $url, 
                'email'         => $email, 
                'comment'       => $comment, 
                'imageid'       => $imageid, 
                'uploaduser'    => $uploaduser, 
                'rating'        => $rating, 
                'approved'      => 0, 
                'approvedby'    => 0, 
                'showing'       => 0, 
            ], 
            [ '%s' , '%s' , '%s' , '%s' , '%s' , '%s' , '%d' , '%s' , '%f' , '%d' , '%d' , '%d'  ] 
        );
    }
    public function deleteBulkTestimonials( $ids , $by ){
        $delete = [];
        foreach( $ids as $id ){
            $delete[ $id ] = $this->deleteTestimonial( $id , $by );
        }
        return $delete;
    }
    public function deleteTestimonial( $id , $by ){
        return $this->wpdb->update( 
            $this->twpdb, 
            [
                'approved'      => 2,
                'approvedby'    => $by,
            ], 
            [ 'id' => $id ], 
            [ '%d' , '%s' ], 
            [ '%d' ] 
        );
    }
    public function showBulkTestimonials( $ids){
        $update = [];
        foreach( $ids as $id ){
            $update[ $id ] = $this->showTestimonial( $id );
        }
        return $update;
    }
    public function showTestimonial( $id  ){
        return $this->wpdb->update( 
            $this->twpdb, 
            [ 'showing' => 1 ], 
            [ 'id' => $id ], 
            [ '%d' ], 
            [ '%d' ] 
        );
    }
    public function hideBulkTestimonials( $ids){
        $update = [];
        foreach( $ids as $id ){
            $update[ $id ] = $this->hideTestimonial( $id );
        }
        return $update;
    }
    public function hideTestimonial( $id  ){
        return $this->wpdb->update( 
            $this->twpdb, 
            [ 'showing' => 1 ], 
            [ 'id' => $id ], 
            [ '%d' ], 
            [ '%d' ] 
        );
    }
    public function approveBulkTestimonials( $ids , $by ){
        $updates = [];
        foreach( $ids as $id ){
            $updates[ $id ] = $this->approveTestimonial( $id , $by );
        }
        return $updates;
    }
    public function approveTestimonial( $id , $by ){
        return $this->wpdb->update( 
                $this->twpdb, 
                [
                    'approved'      => 1,
                    'approvedby'    => $by,
                ], 
                [ 'id' => $id ], 
                [ '%d' , '%s' ], 
                [ '%d' ] 
            );
    }
    public function returnTestimonial( $id ){
        return $this->wpdb->get_results( "SELECT * FROM {$this->twpdb} WHERE id = $id", OBJECT );
    }
    public function returnAllTestimonials(){
        return $this->wpdb->get_results( "SELECT * FROM {$this->twpdb}", OBJECT );
    }
    public function returnAllApprovedTestimonials($Limit = ''){
        return $this->wpdb->get_results( "SELECT * FROM {$this->twpdb} WHERE approved = 1".( ( is_array($Limit) ) ? ' LIMIT '.$Limit['Offset'] .',' . $Limit['Limit'] : '' ) , OBJECT );
    }
    public function returnShowApprovedTestimonials(){
        return $this->wpdb->get_results( "SELECT * FROM {$this->twpdb} WHERE approved = 1 AND showing = 1" , OBJECT );
    }
    public function returnAllApprovedTestimonialsCount(){
        return $this->wpdb->get_results( "SELECT count(id) FROM {$this->twpdb} WHERE approved = 1" , ARRAY_A );
    }
    public function returnWaitingTestimonials($Limit = ''){
        return $this->wpdb->get_results( "SELECT * FROM {$this->twpdb} WHERE approved = 0".( ( is_array($Limit) ) ? ' LIMIT '.$Limit['Offset'] .',' . $Limit['Limit'] : '' ) , OBJECT );
    }
    public function returnWaitingTestimonialsCount(){
        return $this->wpdb->get_results( "SELECT count(id) FROM {$this->twpdb} WHERE approved = 0" , ARRAY_A );
    }
    private function returnArrowIcon( $name ){
        $arrows = [
            'double-angle'      => [ 'Next' => 'fas fa-angle-double-right'      , 'Prev' => 'fas fa-angle-double-left' ],
            'single-angle'      => [ 'Next' => 'fas fa-angle-right'             , 'Prev' => 'fas fa-angle-left' ],
            'double-caret'      => [ 'Next' => 'fas fa-forward'                 , 'Prev' => 'fas fa-backward' ],
            'single-caret'      => [ 'Next' => 'fas fa-caret-right'             , 'Prev' => 'fas fa-caret-left' ],
            'circle-chevron'    => [ 'Next' => 'fas fa-chevron-circle-right'    , 'Prev' => 'fas fa-chevron-circle-left' ],
            'circle-arrow'      => [ 'Next' => 'fas fa-arrow-circle-right'      , 'Prev' => 'fas fa-arrow-circle-left' ],
            'circle-alt-arrow'  => [ 'Next' => 'fas fa-arrow-alt-circle-right'  , 'Prev' => 'fas fa-arrow-alt-circle-left' ],
        ];
        return ( ( isset( $arrows[ $name ] ) ) ? $arrows[ $name ] : '' );
    }
    public function returnDisplayCountClass( $count ){
        $classes = [
            1 => '',
            2 => 'two-by',
            3 => 'three-by',
            4 => 'four-by',
        ];
        return ( ( isset( $classes[ $count ] ) ) ? $classes[ $count ] : $classes[1] );
    }
    public function returnDisplay( $settings ){
        $testimonials = $this->returnShowApprovedTestimonials();
        $arrows = $this->returnArrowIcon( $settings[ 'arrow-type' ] );
        $html = '
        <div class="s2n-rating-display ' . $settings[ 'display-theme' ] . ' ' . ( ( $settings[ 'border-ONOFF' ] == 'on' ) ? 'box-border' : '' ) . '">
            <h2>' . $settings[ 'testimonial-title' ] . '</h2>
                ';
        if( count ( $testimonials) <= 0 ){
            $html .= '<p>Currently No Testimonails To Show</p>';    
        }else{
            $html .='
            <div class="s2n-testimonial-container ">
            ' . ( ( $settings[ 'arrow-type' ] != 'none' ) ? '<div class="s2n-prev ' . ( ( $settings[ 'arrow-hover' ] == 'img-circle' ) ? 'control-circle' : '' ) . '"><i class="' . $arrows[ 'Prev' ] . '"></i></div>' : '' );
            $slider_count = 0;
            for( $i = 0; $i < count ( $testimonials ); $i++ ){
                $html .= '<div class="s2n-testimonials" data-testimonial="' . $slider_count .'">'; 
                if($settings['display-count'] > 1){
                    for( $x = 0; $x < $settings['display-count']; $x++){
                        if( isset( $testimonials[$i] ) ){
                            $data = $testimonials[$i];
                            
                            $name = '<div class="name"> ' . esc_html( $data->firstname ) . ' ' . esc_html( $data->lastname ). ' </div>';
                            if( $settings['links-ONOFF'] == 'on' ){
                                $name = '<div class="name"><a ' . ( ( $settings['nofollow-ONOFF'] == 'on' ) ? 'rel="nofollow"' : '' ) . ' href=" ' . esc_url( $data->url ) . ' ">' . esc_html( $data->firstname ) . ' ' . esc_html( $data->lastname ). '</a></div>';
                            }
                            $html .= '
                                <div class="s2n-testimonial ' . $this->returnDisplayCountClass( $settings['display-count'] ) . '">
                                    
                                    <div class="image "><div class="image-container ' . $settings[ 'image-shape' ] . '"> <img class="' . $settings[ 'image-shape' ] . '" src="'. ( ( $data->imageid == 0 ) ?  $this->plugin_url . 'images/default-profile.png' : wp_get_attachment_image_src( $data->imageid )[0] ) .'"/></div></div>
                                    ' . $name .'
                                    <div class="input-container"> ' . $this->returnDisplayRating( esc_html( $data->rating ) , '' , esc_html( $this->ratingcount ) , $settings[ 'star-size' ] ) . '</div>
                                    <div class="comment"> ' . esc_html( $data->comment ) . '</div>
                                    
                                </div>';
                                $i++;
                        }
                    }
                    $i--;
                }else{
                    $data = $testimonials[$i];
                    $name = '<div class="name"> ' . esc_html( $data->firstname ) . ' ' . esc_html( $data->lastname ). ' </div>';
                    if( $settings['links-ONOFF'] == 'on' ){
                        $name = '<div class="name"><a ' . ( ( $settings['nofollow-ONOFF'] == 'on' ) ? 'rel="nofollow"' : '' ) . ' href=" ' . esc_url( $data->url ) . ' ">' . esc_html( $data->firstname ) . ' ' . esc_html( $data->lastname ). '</a></div>';
                    }
                    $html .= '
                        <div class="s2n-testimonial">
                            
                            <div class="image "><div class="image-container ' . $settings[ 'image-shape' ] . '"> <img class="' . $settings[ 'image-shape' ] . '" src="'. ( ( $data->imageid == 0 ) ?  $this->plugin_url . 'images/default-profile.png' : wp_get_attachment_image_src( $data->imageid )[0] ) .'"/></div></div>
                            ' . $name .'
                            <div class="input-container"> ' . $this->returnDisplayRating( esc_html( $data->rating ), '' , esc_html( $this->ratingcount ), $settings[ 'star-size' ] ) . '</div>
                            <div class="comment"> ' . esc_html( $data->comment ) . '</div>
                            
                        </div>';
                }
                $slider_count++;
                $html .= '</div>';
            }

            $html .= '
            <input type="hidden" id="current-testimonial" value="0" />   
            <input type="hidden" id="show-display" value="' . $settings['display-count'] . '" />   
            <input type="hidden" id="slide-effect" value="' . $settings['slide-effect'] . '" />   
            <input type="hidden" id="max-testimonial" value="' . ( $slider_count - 1 ). '" />   
            ' . ( ( $settings[ 'arrow-type' ] != 'none' ) ? '<div class="s2n-next ' . ( ( $settings[ 'arrow-hover' ] == 'img-circle' ) ? 'control-circle': '' ) . '"><i class="' . $arrows[ 'Next' ] . '"></i></div>' : '' );
            
        }   
        $html .=' 
            </div>
            <ol class="s2n-dots">';
            for($t = 0; $t < $slider_count; $t++){
                $html .='<li class="slider-select" data-select="' . $t . '"></li>';
            }
                
                
        $html .=' </ol>
            </div>';
        return $html;
    }
    public function returnDisplayRating( $rating , $colourClass , $count , $size = 's2n-xs' ){
        $html = '<div class="s2n_display_rating">';
        for( $i = 1; $i <= $count; $i++ ){
            if($i <= $rating ){
                $html .= '<i data-star="' . $i . '" class="' . $size . ' '. $this->star . ' fa-star ' . $colourClass . '"></i>';    
            }else{
                if( fmod( $rating , 1 ) !== 0.00 && round($rating) == $i){
                    $html .= '<i data-star="' . $i . '" class="' . $size . ' '. $this->star_half . ' ' . $colourClass . '"></i>'; 
                } else {
                    $html .= '<i data-star="' . $i . '" class="' . $size . ' '. $this->star_empty . ' fa-star ' . $colourClass . '"></i>'; 
                }
            }  
        }
        $html .= '</div>';
        return $html;
    }
    public function returnUserInput( $settings ){
        $textboxes = [
            [ 'Name' => 'firstname' , 'Placeholder' => 'Enter First Name' , 'Label' => 'First Name:' ], 
            [ 'Name' => 'lastname' , 'Placeholder' => 'Enter Last Name' , 'Label' => 'Last Name:'  ], 
            [ 'Name' => 'email' , 'Placeholder' => 'Enter Your Email'  , 'Label' => 'Email:' ], 
            [ 'Name' => 'url' , 'Placeholder' => 'Enter URL' , 'Label' => 'URL:'  ]
        ];
        $html = '
        <div class="s2n-rating-form-container ' . $settings[ 'form-theme' ] . ' box-border">
            <h2>' . $settings['testimonial-title'] . '</h2>
            <form class="s2n-rate-us">';  
            foreach( $textboxes as $inputs ){
                $html .= '<div class="input-container">
                            <label> ' .  ( ( $settings[ 'labels-ONOFF' ] == 'on' ) ? $inputs[ 'Label' ] : '' ) . ' 
                                <input type="text" name="' . $inputs[ 'Name' ] . '" ' .  ( ( $settings[ 'placeholder-ONOFF' ] == 'on' ) ? 'placeholder="' . $inputs[ 'Placeholder' ] . '"' : '' ) . ' class="s2n-rating-input" />
                            </label>
                          </div>';
            }
        
        $html .= '
                <div class="input-container">
                    <label> ' .  ( ( $settings[ 'labels-ONOFF' ] == 'on' )  ? 'Image:' : '' ) . '
                    ' . $this->returnImageInput( false ) . '
                    </label>
                </div>
                <div class="input-container">
                    <label> ' .  ( ( $settings[ 'labels-ONOFF' ] == 'on' )  ? 'Comment:' : '' ) . '
                        <textarea name="comments" rows="5" ' .  ( ( $settings[ 'placeholder-ONOFF' ] == 'on' ) ? 'placeholder="Enter Your Comments"' : '' ) . ' class="s2n-rating-input"></textarea>
                    </label>
                </div>
                <div class="input-container text-center">
                    <label> ' .  ( ( $settings[ 'labels-ONOFF' ] == 'on' )  ? 'Rating' : '' ) . '
                    ' . $this->returnRatingInput( $this->star_empty , $this->ratingcount , $settings[ 'star-size' ] ) . '
                    </label>
                </div>
                <div class="input-container">
                    <input type="submit" class="submit-button submit-testimonial" name="submit_testimonial" value="Leave Testimonial">
                </div>   

            </form>
            <div class="form-saving">
                <div class="text-center">
                    <i class="save-spinner ' . $settings[ 'save-spinner' ] . ' "></i>
                    <p class="text-center"> Saving Testimonial.. .</p>  
                </div>
            </div>
            <div class="form-finished text-center">
                <div class="success-msg ' . $settings[ 'class-success' ] . '">
                    <i class="icon fas fa-check"></i>
                    <p>' .  $settings[ 'message-success' ] . '</p>
                </div>
                <div class="error-msg ' . $settings[ 'class-error' ] . '">
                    <i class="icon fas fa-times"></i>
                    <p>' .  $settings[ 'message-error' ] . '</p>
                </div>
            </div>
        </div>
        <script>
            var star_full = "' . $this->star . '";
            var star_half = "' . $this->star_half . '";
            var star_empty = "' . $this->star_empty . '";
;        </script>
        ';
        return $html;
    }
    private function returnRatingInput( $empty , $count, $size ='' ){
        $html = '<div class="s2n_rating ">';
        for( $i = 1; $i <= $count; $i++ ){
            $html .= '<i data-star="' . $i . '" class=" ' . $size  .' '. $empty . ' fa-star "></i>';
        }
        $html .= '<input type="hidden" name="star-rating" class="star-rating" value="0" /></div>';
        return $html;
    }
    private function returnImageInput( $admin = true ){
        $html = '
        <img class="profile_image" src="' . plugins_url( '/testimonials-wp/images/default-profile.png')  . '" height="100" width="100"/>';

        if( $admin ){
            $html .= '<input class="profile_image_url" type="text" name="profile_image_url" size="60" value="" disabled>
            <input type="hidden" name="imageid" id="imageid" value="" />
            <a href="#" class="profile_upload button button-primary">Upload</a>';
            return $html;
        }

        $html .= '<input class="profile_image_url" type="file" name="profile_image_url" size="60" value="">
        <button class="submit-button upload-button"> Upload Image </button>';

        return $html; 

        
    }
    public function returnAdminAddForm(){
        $html = '
        <table class="form-table twp-admin-form">
        <tr><th>First Name:</th><td><input type="text" name="firstname" id="firstname" class="field-40" /> </td></tr>
        <tr><th>Last Name:</th><td><input type="text" name="lastname" id="lastname" class="field-40" /> </td></tr>
        <tr><th>URL:</th><td><input type="text" name="url" id="url" class="field-40" /> </td></tr>
        <tr><th>Email:</th><td><input type="text" name="email" id="email" class="field-40" /> </td></tr>
        <tr><th>Comment:</th><td><textarea name="comment" id="comment" class="field-40"> </textarea></td></tr>
        <tr><th>Image:</th><td>' . $this->returnImageInput() . '</td></tr>
        <tr><th>Rating:</th><td>' . $this->returnRatingInput( 's-purple' , $this->star_empty , $this->ratingcount ) . '</td></tr>
        <tr><th></th><td><input type="submit" name="submit_testimonial" value="Add Testimonial"></td></tr>
        </table>
        <script>
            var star_full = "' . $this->star . '";
            var star_half = "' . $this->star_half . '";
            var star_empty = "' . $this->star_empty . '";
;        </script>
        ';
        return $html;
    }
    public function createTableIfNotExist(){
        if( $this->wpdb->get_var( "SHOW TABLES LIKE '{$this->twpdb}'" ) != $this->twpdb) {
           $this->createTable(); 
        }
        return true;
    }
    private function createTable(){
        $collate = $this->wpdb->get_charset_collate();
        $sql  = "CREATE TABLE $this->twpdb (
        id int(11) NOT NULL AUTO_INCREMENT,
        time datetime NOT NULL,
        firstname varchar(25) NOT NULL,
        lastname varchar(25) NOT NULL,
        url text NOT NULL,
        comment text NOT NULL,
        email text NOT NULL,
        imageid int(12) NOT NULL,
        uploaduser text NOT NULL,
        rating float NOT NULL,
        approved int(1) NOT NULL,
        approvedby int(12) NOT NULL,
        showing int(1) NOT NULL,
        UNIQUE KEY (id)
        ) $collate";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
        return true;
    }
}

?>
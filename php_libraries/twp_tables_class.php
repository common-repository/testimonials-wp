<?php


if( ! class_exists( 'WP_List_Table' ) ){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class TWP_Tables extends WP_List_Table {

    public $set_columns;
    public $set_items;
    public $colour;
    public $bulk_actions;
    public $plugin_url;
    private $twp;

    function __construct( $twp ){
        $this->twp = $twp;
        $this->screen = get_current_screen();
    }
    public function set_PluginURL( $url ){
        $this->plugin_url = $url;
    }
    public function setTable( $columns , $items , $colour, $bulk){
        $this->set_columns = $columns;
        $this->set_items = $items;
        $this->colour = $colour;
        $this->bulk_actions = $bulk;
    }
    public function get_columns() {	
        return $this->set_columns;	
    }
    public function prepare_items() {

        $per_page = 5;
        $current_page = $this->get_pagenum(); 

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($this->set_columns, $hidden, $sortable);

        if($this->set_items === 'AllApproved'){
            $this->items = $this->twp->returnAllApprovedTestimonials([ 'Offset' => ( ( $current_page != 1 ) ? ($current_page - 1) * $per_page : 0) , 'Limit' => $per_page ]);
            $total_items = $this->twp->returnAllApprovedTestimonialsCount();
        }

        if($this->set_items === 'Approve'){
            $this->items = $this->twp->returnWaitingTestimonials([ 'Offset' => ( ( $current_page != 1 ) ? ($current_page - 1) * $per_page : 0) , 'Limit' => $per_page ]);
            $total_items = $this->twp->returnWaitingTestimonialsCount();
        }
        $this->set_pagination_args( array(
            'total_items' => $total_items[0]['count(id)'],
            'per_page'    => $per_page
        ) );
    }
    function column_cb( $item ) {
        return '<input type="checkbox" name="approve[]" value="' . $item->id . '"/>';
    }
    function column_imageid( $item ) {
        return '<img src="'. ( ( $item->imageid == 0 ) ?  $this->plugin_url . 'images/default-profile.png' : wp_get_attachment_image_src( $item->imageid )[0] ) .'"/><p style="text-align:center;">' . $item->time . '</p>';
    }
    function column_firstname( $item ) {
         return esc_html( $item->firstname );
    }
    function column_lastname( $item ) {
         return esc_html( $item->lastname );
    }
    function column_showing( $item ) {
        return ( ( $item->showing == 1 ) ? 'Showing' : 'N/A'  );
    }
    
    function column_rating( $item ) {
         return $this->twp->returnDisplayRating( $item->rating , $this->colour , $this->twp->ratingcount );
    }
    function column_comment( $item ) {
        return  esc_html( $item->comment );
    }
    function column_email( $item ) {
        return  esc_html( $item->email ) ;
    }
    
    function column_url( $item ) {
        return  '<a href="' . esc_url( $item->url ) . '" rel="nofollow">' . esc_html( $item->url ) . '</a>';
    }
    function column_approvedby( $item ) {
        $user =  get_user_by( 'ID',  $item->approvedby );
        return $user->user_login;
    }
    
    public function get_bulk_actions() {
        return $this->bulk_actions;
    }
    public function process_bulk_action() {
        if ( isset( $_POST['action'] ) && isset( $_POST['action2'] ) ){
            if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

                $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
                $action = 'bulk-' . $this->_args['plural'];

                if ( ! wp_verify_nonce( $nonce, $action ) )
                    wp_die( 'Nope! Security check failed!' );

            }

            $action = $this->current_action();

            if( isset( $_POST['form_approve'] ) ){
                $this->postApproveTestimonials( $action );
            }

            if( isset( $_POST['form_approved'] ) ){
                $this->postApprovedTestimonials( $action );
            }
            
            return;
        }
    }
    function postApprovedTestimonials( $action ){
        switch ( $action ) {
            case 'show':
                if( isset( $_POST['approve'] ) && is_array( $_POST['approve'] ) ){
                    $shows = $this->twp->showBulkTestimonials( $_POST['approve'] );  
                    $count = 0;
                    foreach($shows as $id => $show){
                    
                        if( $show === false ){
                            add_settings_error( 'twp-notices', 'twp-bulk-show-testimonials',  sprintf(__('Failed To Show Testimonial ID: %s', 'twp' ), $id) , 'error' );    
                        }else{
                            $count++;
                        }
                    }
                    add_settings_error( 'twp-notices', 'twp-show-testimonial', sprintf( _n( 'Successfully Shown: %d Testimonial', 'Successfully Shown: %d Testimonials.', $count, 'twp'  ), $count) , 'updated' );
                }
                break;
            case 'hide':
                if( isset( $_POST['approve'] ) && is_array( $_POST['approve'] ) ){
                    $hides = $this->twp->hideBulkTestimonials( $_POST['approve'] );  
                    $count = 0;
                    foreach($hides as $id => $hide){
                    
                        if( $hide === false ){
                            add_settings_error( 'twp-notices', 'twp-bulk-hide-testimonials',  sprintf(__('Failed To Hide Testimonial ID: %s', 'twp' ), $id) , 'error' );    
                        }else{
                            $count++;
                        }
                    }
                    add_settings_error( 'twp-notices', 'twp-hide-testimonial', sprintf( _n( 'Successfully Hidden: %d Testimonial', 'Successfully Hidden: %d Testimonials.', $count, 'twp'  ), $count) , 'updated' );
                }
                if( isset( $_POST['approve'] ) && is_array( $_POST['approve'] ) ){
                    $shows = $this->twp->showBulkTestimonials( $_POST['approve'] , get_current_user_id() );  
                    $count = 0;
                    foreach($shows as $id => $show){
                    
                        if( $show === false ){
                            add_settings_error( 'twp-notices', 'twp-bulk-show-testimonials',  sprintf(__('Failed To Show Testimonial ID: %s', 'twp' ), $id) , 'error' );    
                        }else{
                            $count++;
                        }
                    }
                    add_settings_error( 'twp-notices', 'twp-show-testimonial', sprintf( _n( 'Successfully Shown: %d Testimonial', 'Successfully Shown: %d Testimonials.', $count, 'twp'  ), $count) , 'updated' );
                }
                break;
            case 'delete':
                if( isset( $_POST['approve'] ) && is_array( $_POST['approve'] ) ){
                    $deletes = $this->twp->deleteBulkTestimonials( $_POST['approve'] , get_current_user_id() );  
                    $count = 0;
                    foreach($deletes as $id => $delete){
                    
                        if( $delete === false ){
                            add_settings_error( 'twp-notices', 'twp-bulk-delete-testimonials',  sprintf(__('Failed To Delete Testimonial ID: %s', 'twp' ), $id) , 'error' );    
                        }else{
                            $count++;
                        }
                    }
                    add_settings_error( 'twp-notices', 'twp-delete-testimonial', sprintf( _n( 'Successfully Delete: %d Testimonial', 'Successfully Deleted: %d Testimonials.', $count, 'twp'  ), $count) , 'updated' );
                }
                break;
        }
        return;
    }

    function postApproveTestimonials( $action ){
        switch ( $action ) {

            case 'delete':
                if( isset( $_POST['approve'] ) && is_array( $_POST['approve'] ) ){
                    $deletes = $this->twp->deleteBulkTestimonials( $_POST['approve'] , get_current_user_id() );  
                    $count = 0;
                    foreach($deletes as $id => $delete){
                    
                        if( $delete === false ){
                            add_settings_error( 'twp-notices', 'twp-bulk-delete-testimonials',  sprintf(__('Failed To Delete Testimonial ID: %s', 'twp' ), $id) , 'error' );    
                        }else{
                            $count++;
                        }
                    }
                    add_settings_error( 'twp-notices', 'twp-delete-testimonial', sprintf( _n( 'Successfully Deleted: %d Testimonial', 'Successfully Deleted: %d Testimonials.', $count, 'twp'  ), $count) , 'updated' );
  
                }
                break;
            case 'approve':
            
                if( isset( $_POST['approve'] ) && is_array( $_POST['approve'] ) ){
                $updates = $this->twp->approveBulkTestimonials( $_POST['approve'] , get_current_user_id() );
                $count = 0;
                foreach($updates as $id => $update){
                    
                    if( $update === false ){
                        add_settings_error( 'twp-notices', 'twp-bulk-approve-testimonials',  sprintf(__('Failed To Update Testimonial ID: %s', 'twp' ), $id) , 'error' );    
                    }else{
                        $count++;
                    }
                }
                add_settings_error( 'twp-notices', 'twp-approve-testimonial', sprintf( _n( 'Successfully Updated: %d Testimonial', 'Successfully Updated: %d Testimonials.', $count, 'twp'  ), $count) , 'updated' );

                }
                break;

            default:
                add_settings_error( 'twp-notices', 'twp-bulk-approve-testimonials', __('Please Select Action', 'twp'), 'error' );
                break;
        }  
        return;  
    }

}


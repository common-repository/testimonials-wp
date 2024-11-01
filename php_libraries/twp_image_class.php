<?php

class TWP_Image{

    public $filetypes;

    function __construct(){
        $this->filetypes = [
            'jpeg',
            'jpg',
            'png'
        ];
    }
    private function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    
    public function save_image( $base64 ) {
        $check_type = $this->getFileType( $base64 );
        if( ! $check_type ){
            return false;
        }

        $upload_dir  = wp_upload_dir();
        $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
  
        $img             = str_replace( 'data:image/' . $check_type . ';base64,', '', $base64 );
        $img             = str_replace( ' ', '+', $img );
        $decoded         = base64_decode( $img );
        $filename        = $this->generateRandomString(15) . '.'.$check_type;
        $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;
        
        $file_path = $upload_path . $hashed_filename;
        $file_url = $upload_dir['url'] . '/' . $hashed_filename;

        if( ! file_put_contents( $file_path, $decoded ) ){
            return false;   
        }
        
        $file_type = wp_check_filetype( $file_path);

        apply_filters('wp_handle_upload', array('file' => $file_path, 'url' => $file_url, 'type' => $file_type), 'upload');
        
        $attachment = array(
            'post_mime_type' => $file_type['type'],
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $hashed_filename ) ),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
        );
    
        $attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename );

        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
        if( empty ($attach_data) ){
            return false;
        }
        wp_update_attachment_metadata( $attach_id, $attach_data );  

        return $attach_id;
    }
    private function getFileType( $base64 ){
        if( strpos( $base64 , 'data:image' ) === false ){
            return false;
        }
        preg_match('/data:image\/(.*);base64/', $base64, $match);
        if( isset( $match[1] ) && in_array( $match[1] , $this->filetypes ) ){
            return $this->filetypes[ array_search( $match[1] , $this->filetypes ) ];
        }
        return false;
    }

}
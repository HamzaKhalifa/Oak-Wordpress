<?php
class Reporting_Safety {
    function __construct() {
        if ( isset( $_GET['page'] ) ) :
            if (  $_GET['page'] == 'oak_reporting_safety' ) :
                add_action( 'admin_enqueue_scripts', array( $this, 'reporting_safety' ) );
            endif;
        endif;

        add_action( 'admin_menu', array ( $this, 'handle_admin_menu' ) );

        add_action( 'wp_ajax_oak_get_everything', array( $this, 'oak_get_everything') );
        add_action( 'wp_ajax_nopriv_oak_get_everything', array( $this, 'oak_get_everything') );

        return; 
        global $wpdb;
        $result = $wpdb->get_results('SHOW TABLES');

        foreach( $result as $key => $value_array ) :
            foreach( $value_array as $table_name_key => $table_name ) :
                // $columns = $wpdb->get_results( "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'" );
                
                // $result[ $key ] = array(
                //     'table_name' => $table_name,
                //     'columns' => $columns
                // );
            endforeach;
            
        endforeach;
        Oak::var_dump( $result );

        // $this->create_zip();
    }

    function handle_admin_menu() {
        add_menu_page( __( 'Reporting Safety', Oak::$text_domain ), __( 'Reporting Safety', Oak::$text_domain ), 'manage_options', 'oak_reporting_safety', array ( $this, 'main_view'), 'dashicons-index-card', 100 );
    }

    function main_view() {
        include get_template_directory() . '/functions/reporting-safety/views/main_view.php';
    }

    public function reporting_safety() {
        wp_enqueue_script( 'oak_reporting_safety', get_template_directory_uri() . '/functions/reporting-safety/src/js/reporting-safety.js', array('jquery'), false, true );
        wp_localize_script( 'oak_reporting_safety', 'REPORTING_SAFETY_DATA', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        ) );
    }

    public function get_archive_directory() {
        $home_path_divided = explode( '/', get_home_path() );
        $project_directory_path = '';
        for( $i = 0; $i < count( $home_path_divided ) - 2; $i++ ) :
            $project_directory_path .= $home_path_divided[ $i ] . '/';
        endfor;

        return $project_directory_path;
    }

    public function create_zip() {
        $zip = new ZipArchive();
        $filename = $this->get_archive_directory() . 'myzipfile.zip';

        if ( $zip->open( $filename, ZipArchive::CREATE ) !== TRUE ) {
            var_dump( "cannot open <$filename>\n" );
        }

        $dir = get_home_path();

        // Create zip
        if ( is_dir( $dir ) ){
            if ( $dh = opendir( $dir) ){
                while ( ( $file = readdir( $dh ) ) !== false ){
                    // If file
                    if ( is_file( $dir . $file ) ) {
                        if( $file != '' && $file != '.' && $file != '..') :
                            // $zip->addFile($dir.$file);
                        endif;
                    }
                }
                closedir($dh);
            }
        }
        // $zip->close();

        // echo $filename;
    }

    public function oak_get_everything() {
        wp_send_json_success();
        $result = $wpdb->get_results('SELECT * FROM SYSOBJECTS WHERE xtype="U" GO');
        wp_send_json_success( array(
            'result' => $result
        ) );
    }
}


$reporting_safety = new Reporting_Safety();
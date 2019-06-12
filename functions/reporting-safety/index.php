<?php
class Reporting_Safety {
    // Command to generate sql: 
    // mysqldump -u wpress -pDeiddEj2 wordpress  > testdatabase.sql
    function __construct() {
        if ( isset( $_GET['page'] ) ) :
            if (  $_GET['page'] == 'oak_reporting_safety' ) :
                add_action( 'admin_enqueue_scripts', array( $this, 'reporting_safety_enqueue_scripts' ) );
                add_action( 'admin_enqueue_scripts', array( $this, 'reporting_safety_enqueue_styles' ) );
            endif;
        endif;

        add_action( 'admin_menu', array ( $this, 'handle_admin_menu' ) );

        add_action( 'wp_ajax_oak_save_reporting_safety_configuration', array( $this, 'oak_save_reporting_safety_configuration') );
        add_action( 'wp_ajax_nopriv_oak_save_reporting_safety_configuration', array( $this, 'oak_save_reporting_safety_configuration') );

        add_action( 'wp_ajax_oak_generate_sql_file', array( $this, 'oak_generate_sql_file') );
        add_action( 'wp_ajax_nopriv_oak_generate_sql_file', array( $this, 'oak_generate_sql_file') );
        // $this->create_zip();
    }

    function handle_admin_menu() {
        add_menu_page( __( 'Reporting Safety', Oak::$text_domain ), __( 'Reporting Safety', Oak::$text_domain ), 'manage_options', 'oak_reporting_safety', array ( $this, 'main_view'), 'dashicons-index-card', 100 );
    }

    function main_view() {
        include get_template_directory() . '/functions/reporting-safety/views/main_view.php';
    }

    public function reporting_safety_enqueue_scripts() {
        wp_enqueue_script( 'oak_reporting_safety', get_template_directory_uri() . '/functions/reporting-safety/src/js/reporting-safety.js', array('jquery'), false, true );
        wp_localize_script( 'oak_reporting_safety', 'REPORTING_SAFETY_DATA', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        ) );
    }

    public function reporting_safety_enqueue_styles() {
        wp_enqueue_style( 'reporting_safety_main_view', get_template_directory_uri() . '/functions/reporting-safety/src/style/main-view.css' );
    }

    public function oak_save_reporting_safety_configuration() {
        $backup_ajax_url = $_POST['backup_ajax_url'];
        update_option( 'oak_backup_ajax_url', $backup_ajax_url );
        wp_send_json_success();
    }

    public function oak_generate_sql_file() {
        $command_result = shell_exec( 'mysqldump -u wpress -pDeiddEj2 wordpress  > testdatabase.sql' );
    }

    public function import_database() {
        global $wpdb;

        // Name of the file
        $filename = get_template_directory() . '/functions/reporting-safety/database.sql';

        // Replace wpdb prefix
        $file_content = file_get_contents( $filename );
        // $file_content = str_replace( '`wp_', '`' . $wpdb->prefix, $file_content );
        $file_content = str_replace( 'https://joro.isivalue.com', site_url(), $file_content );
        file_put_contents( $filename , $file_content );

        // Drop all tables first: 
        $all_tables=$wpdb->get_results("SHOW TABLES");
        foreach( $all_tables as $table_array ) :
            foreach( $table_array as $key => $tabl_name ) :
                $wpdb->query( "DROP TABLE IF EXISTS $tabl_name" );
            endforeach;
        endforeach;

        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file( $filename );
        // Loop through each line
        foreach ( $lines as $line )
        {
            // Skip it if it's a comment
            if (substr( $line, 0, 2 ) == '--' || $line == '')
                continue;

            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $result = $wpdb->get_results( $templine );
                // Oak::var_dump( $result );
                // Reset temp variable to empty
                $templine = '';
            }
        }
        echo "Tables imported successfully";
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
}


$reporting_safety = new Reporting_Safety();
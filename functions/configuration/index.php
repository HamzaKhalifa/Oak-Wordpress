<?php 

class Configuration {
    function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action( 'admin_menu', array( $this, 'handle_admin_menu' ) );
        
        $this->handle_ajax_calls();
    }

    function handle_admin_menu() {
        add_menu_page( 'OAK (Materiality Reporting)', 'OAK (Materiality Reporting)', 'manage_options', 'oak_materiality_reporting', array( $this, 'oak_materility_reporting' ), 'dashicons-chart-pie', 99 );
    }

    function oak_materility_reporting() {
        include get_template_directory() . '/functions/configuration/views/configuration-page.php';
    }

    function admin_enqueue_scripts() {
        // Configuration page
        if ( get_current_screen()->id == 'toplevel_page_oak_materiality_reporting' ) :
            wp_enqueue_script( 'oak_configuration_script', get_template_directory_uri() . '/functions/configuration/src/js/configuration-page.js', array('jquery'), false, true );
            wp_localize_script( 'oak_configuration_script', 'DATA', array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'oakWhichPerimeter' => get_option('oak_which_perimeter') != false ? get_option('oak_which_perimeter') : 0
            ) );
        endif;
    }

    function handle_ajax_calls() {
        add_action( 'wp_ajax_oak_save_configuration', array( $this, 'oak_save_configuration') );
        add_action( 'wp_ajax_nopriv_oak_save_configuration', array( $this, 'oak_save_configuration') );
    }

    function oak_save_configuration() {
        $data = $_POST['data'];
        $default_menu = $data['defaultMenu'];
        $central = $data['central'];
        $central_url = $data['centralUrl'];
        $business_line = $data['businessLine'];
        $which_perimeter = $data['whichPerimeter'];
        $regions = $data['regions'];
        $custom_perimeter = $data['customPerimeter'];

        update_option( 'oak_default_menu', $default_menu );
        update_option( 'oak_corn', $central );
        update_option( 'oak_central_url', $central_url );
        update_option( 'oak_business_line', $business_line );
        update_option( 'oak_which_perimeter', $which_perimeter );
        update_option( 'oak_regions', $regions );
        update_option( 'oak_custom_perimeter', $custom_perimeter );

        wp_send_json_success( array(
            'central' => $central,
            'centralUrl' => $central_url
        ) );
    }
}

$configuration = new Configuration();
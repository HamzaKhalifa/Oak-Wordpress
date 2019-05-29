<?php

class Data_Studio {
    function __construct() {
        add_action( 'admin_menu', array( $this, 'handle_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        $this->handle_ajax_calls();
    }

    function handle_admin_menu() {
        add_menu_page( 'Data Studio', 'Data Studio', 'manage_options', 'oak_data_studio', array( $this, 'oak_data_studio' ), 'dashicons-chart-pie', 100 );
    }

    function oak_data_studio() {
        include get_template_directory() . '/functions/data-studio/views/data-studio.php';
    }

    function admin_enqueue_scripts() {
        if ( get_current_screen()->id == 'toplevel_page_oak_data_studio' ) :
            wp_enqueue_script( 'oak_charts', get_template_directory_uri() . '/src/js/vendor/chart.bundle.min.js', array(), false, true);
            wp_enqueue_script( 'oak_data_studio', get_template_directory_uri() . '/functions/data-studio/src/js/data-studio.js', array('jquery'), false, true );
            wp_localize_script( 'oak_data_studio', 'DATA', array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'allData' => array(
                    'organizations' => array (
                        'organizations' => Oak::$organizations,
                        'organizationsWithoutRedundancy' => Oak::$organizations_without_redundancy,
                    ),
                    'publications' => array(
                        'publications' => Oak::$publications,
                        'publicationsWithoutRedundancy' => Oak::$publications_without_redundancy,
                    ),
                    'quantis' => array(
                        'quantis' => Oak::$quantis,
                        'quantisWithoutRedundancy' => Oak::$quantis_without_redundancy,
                    ),
                    'performances' => array(
                        'performances' => Oak::$performances,
                        'performancesWithoutRedundancy' => Oak::$performances_without_redundancy,
                    )
                )
            ) );
        endif;
    }

    function handle_ajax_calls() {
        add_action('wp_ajax_oak_save_graph', array( $this, 'oak_save_graph') );
        add_action('wp_ajax_nopriv_oak_save_graph', array( $this, 'oak_save_graph') );
    }

    function oak_save_graph() {
        Graphs::save_graph();
    }
}

$data_studio = new Data_Studio();